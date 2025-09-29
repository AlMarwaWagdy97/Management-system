<?php

namespace App\Services\Statistics;

use App\Models\Domain;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HololOrdersProvider implements StoreOrdersProviderInterface
{
    public function fetch(Domain $domain, ?CarbonInterface $from, ?CarbonInterface $to): Collection
    {
        $base = rtrim((string) $domain->domain_url, '/');
        $listEndpoint  = $base.'/api/management/orders';
        $statsEndpoint = $base.'/api/management/orders/stats';

        $paramsDateFromTo = [];
        if ($from) { $paramsDateFromTo['date_from'] = $from->toDateString(); }
        if ($to)   { $paramsDateFromTo['date_to']   = $to->toDateString(); }

        $paramsFromTo = [];
        if ($from) { $paramsFromTo['from_date'] = $from->toDateString(); }
        if ($to)   { $paramsFromTo['to_date']   = $to->toDateString(); }

        $headers = ['Authorization' => 'Bearer '.(string) $domain->token];

        $payload = null;
        try {
            $res = Http::timeout(30)->withHeaders($headers)->acceptJson()->get($listEndpoint, $paramsDateFromTo);
            if ($res->ok()) {
                $json = $res->json();
                $tmp = is_array($json) && array_key_exists('data', $json) ? $json['data'] : $json;
                if (is_array($tmp) && array_is_list($tmp)) {
                    $payload = $tmp; // list of orders
                }
                Log::info('[HololOrdersProvider] list endpoint response', [
                    'domain_id' => $domain->id,
                    'endpoint'  => $listEndpoint,
                    'params'    => $paramsDateFromTo,
                    'used'      => (bool) $payload,
                ]);
            }
        } catch (\Throwable $e) {
        }

        if ($payload === null && !empty($paramsFromTo)) {
            try {
                $res = Http::timeout(30)->withHeaders($headers)->acceptJson()->get($listEndpoint, $paramsFromTo);
                if ($res->ok()) {
                    $json = $res->json();
                    $tmp = is_array($json) && array_key_exists('data', $json) ? $json['data'] : $json;
                    if (is_array($tmp) && array_is_list($tmp)) {
                        $payload = $tmp;
                    }
                    Log::info('[HololOrdersProvider] list endpoint response (alt params)', [
                        'domain_id' => $domain->id,
                        'endpoint'  => $listEndpoint,
                        'params'    => $paramsFromTo,
                        'used'      => (bool) $payload,
                    ]);
                }
            } catch (\Throwable $e) {
                // ignore and try stats
            }
        }

        if ($payload === null) {
            foreach ([$paramsDateFromTo, $paramsFromTo] as $params) {
                try {
                    $res = Http::timeout(30)->withHeaders($headers)->acceptJson()->get($statsEndpoint, $params);
                    if ($res->ok()) {
                        $json = $res->json();
                        $tmp = $json;
                        if (is_array($json)) {
                            if (array_key_exists('data', $json) && is_array($json['data'])) {
                                $tmp = $json['data'];
                            } elseif (array_key_exists('stats', $json) && is_array($json['stats'])) {
                                $tmp = $json['stats'];
                            } elseif (array_key_exists('result', $json) && is_array($json['result'])) {
                                $tmp = $json['result'];
                            }
                        }
                        $payload = is_array($tmp) ? $tmp : null;
                        Log::info('[HololOrdersProvider] stats endpoint response', [
                            'domain_id' => $domain->id,
                            'endpoint'  => $statsEndpoint,
                            'params'    => $params,
                            'keys'      => is_array($payload) ? array_keys($payload) : null,
                        ]);
                        if ($payload !== null) { break; }
                    }
                } catch (\Throwable $e) {
                }
            }
        }

        Log::info('[HololOrdersProvider] normalized payload', [
            'domain_id' => $domain->id,
            'keys'      => is_array($payload) ? array_keys($payload) : null,
            'is_list'   => is_array($payload) ? (bool) array_is_list($payload) : null,
        ]);

        $ordersCount = 0;
        $totalAmount = 0.0;

        $extract = function ($item): array {
            if (!is_array($item)) { return [0, 0.0]; }
            $cnt = (int) (
                $item['orders_count']
                ?? $item['completed_orders_count']
                ?? $item['count']
                ?? $item['orders']
                ?? $item['ordersCount']
                ?? $item['total_orders']
                ?? 0
            );
            $sum = (float) (
                $item['total_amount']
                ?? $item['orders_total']
                ?? $item['sum']
                ?? $item['total']
                ?? $item['total_price']
                ?? $item['totalAmount']
                ?? 0
            );
            return [$cnt, $sum];
        };

        if (is_array($payload) && array_is_list($payload)) {
            foreach ($payload as $order) {
                $ordersCount++;
                $val = 0.0;
                if (is_array($order)) {
                    $val = (float) ($order['total']
                        ?? $order['amount']
                        ?? $order['grand_total']
                        ?? 0);
                }
                $totalAmount += $val;
            }
        } elseif (is_array($payload)) {
            [$directCnt, $directSum] = $extract($payload);
            if ($directCnt > 0 || $directSum > 0) {
                $ordersCount = $directCnt;
                $totalAmount = $directSum;
            } else {
                foreach ($payload as $key => $value) {
                    if (is_array($value)) {
                        [$c, $s] = $extract($value);
                        if ($c > 0 || $s > 0) {
                            $ordersCount += $c;
                            $totalAmount += $s;
                        }
                    }
                }
            }
        }

        $storeName = $domain->domain_name ?: 'holol';
        $storeSlug = parse_url($domain->domain_url ?? '', PHP_URL_HOST) ?: 'holol';

        return collect([
            [
                'store_name'   => $storeName,
                'store_slug'   => $storeSlug,
                'orders_count' => $ordersCount,
                'total_amount' => $totalAmount,
            ]
        ]);
    }
}
