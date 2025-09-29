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
        $listEndpoint  = $base.'/api/management/orders';
        $statsEndpoint = $base.'/api/management/orders/stats';

        $paramsA = [];
        if ($from) { $paramsA['date_from'] = $from->toDateString(); }
        if ($to)   { $paramsA['date_to']   = $to->toDateString(); }

        $paramsB = [];
        if ($from) { $paramsB['from_date'] = $from->toDateString(); }
        if ($to)   { $paramsB['to_date']   = $to->toDateString(); }

        $headers = [];
        if ($domain->token) { $headers['Authorization'] = 'Bearer '.$domain->token; }

        $payload = null;

        foreach ([$paramsA, $paramsB] as $params) {
            try {
                $res = Http::withHeaders($headers)->acceptJson()->get($listEndpoint, $params);
                if ($res->ok()) {
                    $json = $res->json();
                    $tmp = is_array($json) && array_key_exists('data', $json) ? $json['data'] : $json;
                    if (is_array($tmp) && array_is_list($tmp)) {
                        $payload = $tmp; // list of orders
                        break;
                    }
                }
            } catch (\Throwable $e) {
                // keep trying
            }
        }

        if ($payload === null) {
            foreach ([$paramsA, $paramsB] as $params) {
                try {
                    $res = Http::withHeaders($headers)->acceptJson()->get($statsEndpoint, $params);
                    if ($res->ok()) {
                        $json = $res->json();
                        $tmp = $json;
                        if (is_array($json)) {
                            if (array_key_exists('data', $json) && is_array($json['data'])) {
                                $tmp = $json['data'];
                            } elseif (array_key_exists('stats', $json) && is_array($json['stats'])) {
                                $tmp = $json['stats'];
                            }
                        }
                        $payload = is_array($tmp) ? $tmp : null;
                        if ($payload !== null) { break; }
                    }
                } catch (\Throwable $e) {
                }
            }
        }

        $count = 0;
        $sum = 0.0;

        if (is_array($payload) && array_is_list($payload)) {
            foreach ($payload as $order) {
                $count++;
                $val = 0.0;
                if (is_array($order)) {
                    $val = (float) ($order['total']
                        ?? $order['amount']
                        ?? $order['grand_total']
                        ?? 0);
                }
                $sum += $val;
            }
        } elseif (is_array($payload)) {
            $count = (int) (
                $payload['orders_count']
                ?? $payload['count']
                ?? $payload['total_orders']
                ?? 0
            );
            $sum = (float) (
                $payload['total_amount']
                ?? $payload['orders_total']
                ?? $payload['sum']
                ?? 0
            );
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
