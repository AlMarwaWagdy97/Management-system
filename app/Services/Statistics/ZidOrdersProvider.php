<?php

namespace App\Services\Statistics;

use App\Models\Domain;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class ZidOrdersProvider implements StoreOrdersProviderInterface
{
    public function fetch(Domain $domain, ?CarbonInterface $from, ?CarbonInterface $to): Collection
    {
        // Placeholder implementation: adjust endpoint/params according to Zid API spec
        // Normalize domain URL (remove spaces, ensure scheme)
        $raw = (string) ($domain->domain_url ?: $domain->domain_name);
        $raw = preg_replace('/\s+/', '', trim($raw));
        if ($raw !== '' && !preg_match('~^https?://~i', $raw)) { $raw = 'https://' . $raw; }
        $parts = @parse_url($raw);
        if ($parts && !empty($parts['host'])) {
            $scheme = $parts['scheme'] ?? 'https';
            $host = preg_replace('/\s+/', '', $parts['host']);
            $port = isset($parts['port']) ? (':' . $parts['port']) : '';
            $path = $parts['path'] ?? '';
            $base = rtrim($scheme . '://' . $host . $port . $path, '/');
        } else {
            $base = '';
        }
        $endpoint = $base . '/api/orders/statistics';
        $params = [];
        if ($from) { $params['from'] = $from->toDateString(); }
        if ($to)   { $params['to']   = $to->toDateString(); }

        try {
            $response = Http::withToken($domain->token)->acceptJson()->get($endpoint, $params);
            if ($response->failed()) {
                throw new \RuntimeException('Zid API error: '.$response->status());
            }
            $data = $response->json();
            // Expecting $data as a list of stores with orders_count and total_amount
            return collect($data)->map(function ($item) {
                return [
                    'store_name'   => $item['store_name']   ?? null,
                    'store_slug'   => $item['store_slug']   ?? null,
                    'orders_count' => (int) ($item['orders_count'] ?? 0),
                    'total_amount' => (float) ($item['total_amount'] ?? 0),
                ];
            });
        } catch (\Throwable $e) {
            // Fallback to empty collection on error
            return collect();
        }
    }
}
