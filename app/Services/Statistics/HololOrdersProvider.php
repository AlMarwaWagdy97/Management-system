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
        // Build endpoint and params as provided by the user
        $base = rtrim((string) $domain->domain_url, '/');
        $endpoint = $base.'/api/management/orders/stats';
        $params = [];
        if ($from) { $params['date_from'] = $from->toDateString(); }
        if ($to)   { $params['date_to']   = $to->toDateString(); }

        try {
            $response = Http::timeout(30)
                ->withToken((string) $domain->token)
                ->acceptJson()
                ->get($endpoint, $params);

            if ($response->failed()) {
                throw new \RuntimeException('Holol API error: '.$response->status().' - '.$response->body());
            }

            $json = $response->json();
            Log::info('[HololOrdersProvider] raw json', [
                'domain_id' => $domain->id,
                'endpoint'  => $endpoint,
                'params'    => $params,
                'json'      => $json,
            ]);

            $payload = $json;
            if (is_array($json)) {
                if (array_key_exists('data', $json) && is_array($json['data'])) {
                    $payload = $json['data'];
                } elseif (array_key_exists('stats', $json) && is_array($json['stats'])) {
                    $payload = $json['stats'];
                } elseif (array_key_exists('result', $json) && is_array($json['result'])) {
                    $payload = $json['result'];
                }
            }
            Log::info('[HololOrdersProvider] normalized payload', [
                'domain_id' => $domain->id,
                'keys'      => is_array($payload) ? array_keys($payload) : null,
                'is_list'   => is_array($payload) ? (bool) array_is_list($payload) : null,
            ]);

            $ordersCount = 0;
            $totalAmount = 0.0;

            // Helper to extract count and total from an item (array)
            $extract = function ($item): array {
                if (!is_array($item)) { return [0, 0.0]; }
                $cnt = (int) (
                    $item['orders_count']
                    ?? $item['completed_orders_count']
                    ?? $item['count']
                    ?? $item['orders']
                    ?? $item['ordersCount']
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
                // Payload is a list of orders: count and sum
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
                // Payload is an aggregate object or a map of aggregates (e.g., grouped by date)
                [$directCnt, $directSum] = $extract($payload);
                if ($directCnt > 0 || $directSum > 0) {
                    $ordersCount = $directCnt;
                    $totalAmount = $directSum;
                } else {
                    // Try aggregating over values if payload is an associative map
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
        } catch (\Throwable $e) {
            Log::error('[HololOrdersProvider] fetch failed for domain '.$domain->id.' : '.$e->getMessage());
            return collect();
        }
    }
}
