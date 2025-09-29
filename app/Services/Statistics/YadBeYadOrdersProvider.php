<?php

namespace App\Services\Statistics;

use App\Models\Domain;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class YadBeYadOrdersProvider implements StoreOrdersProviderInterface
{
    public function fetch(Domain $domain, ?CarbonInterface $from, ?CarbonInterface $to): Collection
    {
        $base = rtrim($domain->domain_url ?: config('app.url'), '/');
        $endpoint = $base.'/api/management/orders';
        $params = [];
        if ($from) { $params['date_from'] = $from->toDateString(); }
        if ($to)   { $params['date_to']   = $to->toDateString(); }

        $orders = [];
        try {
            $response = Http::withToken($domain->token)->acceptJson()->get($endpoint, $params);
            if ($response->failed()) {
                throw new \RuntimeException('YadBeYad API error: '.$response->status());
            }
            $json = $response->json();
            // Many APIs return a data wrapper; try to unwrap if exists
            if (is_array($json) && array_key_exists('data', $json) && is_array($json['data'])) {
                $orders = $json['data'];
            } elseif (is_array($json)) {
                $orders = $json; // assume array of orders
            }
        } catch (\Throwable $e) {
            // On error, return empty stats
            return collect();
        }

        $count = 0;
        $sum = 0.0;
        foreach ($orders as $order) {
            $count++;
            // Try common keys for total/amount
            $val = 0.0;
            if (isset($order['total'])) {
                $val = (float) $order['total'];
            } elseif (isset($order['amount'])) {
                $val = (float) $order['amount'];
            } elseif (isset($order['grand_total'])) {
                $val = (float) $order['grand_total'];
            }
            $sum += $val;
        }

        $storeName = $domain->domain_name ?: 'yadbeyad';
        $storeSlug = parse_url($domain->domain_url ?? '', PHP_URL_HOST) ?: 'yadbeyad';

        return collect([
            [
                'store_name'   => $storeName,
                'store_slug'   => $storeSlug,
                'orders_count' => $count,
                'total_amount' => $sum,
            ]
        ]);
    }
}
