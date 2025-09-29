<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RefersController extends Controller
{
    public function index(Request $request)
    {
        $domains = Domain::query()->orderBy('domain_name')->get();

        $selectedDomainId = $request->input('domain_id');

        $refers = collect();
        $error = null;

        if ($selectedDomainId) {
            try {
                $domain = Domain::findOrFail($selectedDomainId);
                $base = rtrim($domain->domain_url ?: config('app.url'), '/');
                $endpoint = $base.'/api/management/refers';

                // Use higher per_page by default to minimize requests; allow override from UI
                $perPage = $request->integer('per_page', 200);
                $params = ['per_page' => $perPage];

                // First request
                $response = Http::withToken($domain->token)->acceptJson()->get($endpoint, $params);
                if ($response->failed()) {
                    throw new \RuntimeException('Refers API error: '.$response->status());
                }
                $json = $response->json();
                $data = is_array($json) && array_key_exists('data', $json) && is_array($json['data'])
                    ? $json['data']
                    : (is_array($json) ? $json : []);

                $refers = collect($data)->values();

                // Normalize pagination/meta (some APIs misname the key: pagnation/pagenation/paganation)
                $pager = null;
                if (is_array($json)) {
                    foreach (['pagination', 'pagnation', 'pagenation', 'paganation', 'meta'] as $key) {
                        if (isset($json[$key]) && is_array($json[$key])) { $pager = $json[$key]; break; }
                    }
                }

                // Helper to read pager values with multiple possible keys
                $getPager = function (array $p, string $k, $default = null) {
                    $aliases = [
                        'current_page' => ['current_page','currentPage','page'],
                        'last_page'    => ['last_page','lastPage','last'],
                        'per_page'     => ['per_page','perPage','limit'],
                        'next'         => ['next_page_url','next','nextUrl'],
                    ];
                    foreach ($aliases[$k] ?? [$k] as $name) {
                        if (array_key_exists($name, $p)) return $p[$name];
                    }
                    return $default;
                };

                $fetched = $refers->count();

                if (is_array($pager)) {
                    // Prefer following next_page_url if present
                    $nextUrl = $getPager($pager, 'next');
                    $visited = 0; $maxFollow = 200;
                    while ($nextUrl && $visited < $maxFollow) {
                        $r = Http::withToken($domain->token)->acceptJson()->get($nextUrl);
                        if ($r->failed()) break;
                        $j = $r->json();
                        $d = is_array($j) && array_key_exists('data', $j) && is_array($j['data']) ? $j['data'] : (is_array($j) ? $j : []);
                        if (empty($d)) break;
                        $before = $refers->count();
                        $refers = $refers->merge($d);
                        $after = $refers->count();
                        if ($after === $before) break; // no growth => stop
                        // update next
                        $p2 = null; foreach (['pagination','pagnation','pagenation','paganation','meta'] as $k) { if (isset($j[$k]) && is_array($j[$k])) { $p2 = $j[$k]; break; } }
                        $nextUrl = is_array($p2) ? ($p2['next_page_url'] ?? $p2['next'] ?? null) : null;
                        $visited++;
                    }

                    // If no next_page_url, fallback to numeric paging
                    if (!$getPager($pager, 'next')) {
                        $current = (int) ($getPager($pager, 'current_page', 1));
                        $last    = (int) ($getPager($pager, 'last_page', 1));
                        $maxPages = 200;
                        for ($page = $current + 1; $page <= $last && $page <= $current + $maxPages; $page++) {
                            $pageParams = $params; $pageParams['page'] = $page;
                            $r = Http::withToken($domain->token)->acceptJson()->get($endpoint, $pageParams);
                            if ($r->failed()) break;
                            $j = $r->json();
                            $d = is_array($j) && array_key_exists('data', $j) && is_array($j['data']) ? $j['data'] : (is_array($j) ? $j : []);
                            if (empty($d)) break;
                            $refers = $refers->merge($d);
                        }
                    }
                } elseif (is_array($json) && isset($json['links']) && is_array($json['links'])) {
                    // Fallback: links-based pagination (if provided)
                    $page = 2; $maxPages = 200;
                    while ($page <= $maxPages) {
                        $pageParams = $params; $pageParams['page'] = $page;
                        $r = Http::withToken($domain->token)->acceptJson()->get($endpoint, $pageParams);
                        if ($r->failed()) break;
                        $j = $r->json();
                        $d = is_array($j) && array_key_exists('data', $j) && is_array($j['data']) ? $j['data'] : (is_array($j) ? $j : []);
                        if (empty($d)) break; // no more
                        $refers = $refers->merge($d);
                        $page++;
                    }
                }
            } catch (\Throwable $e) {
                $error = $e->getMessage();
                $refers = collect();
            }
        }

        return view('admin.dashboard.domains.refers', [
            'domains' => $domains,
            'selectedDomainId' => $selectedDomainId,
            'refers' => $refers,
            'error' => $error,
        ]);
    }
}
