<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        $domains = Domain::query()->orderBy('domain_name')->get();

        $selectedDomainId = $request->input('domain_id');

        $orders = collect();
        $error = null;
        $ordersCount = null;
        $totalAmount = null;
        $currency = null;
        $onlyCompletedEffective = true;

        if ($selectedDomainId) {
            try {
                $domain = Domain::findOrFail($selectedDomainId);
                $base = rtrim($domain->domain_url ?: config('app.url'), '/');
                $endpoint = $base.'/api/management/orders';

                $params = [];
                if ($request->filled('date_from')) { $params['date_from'] = $request->input('date_from'); }
                if ($request->filled('date_to'))   { $params['date_to']   = $request->input('date_to'); }

                $all = [];
                $page = 1;
                $perPage = 50;
                $lastPage = null;

                $requestPage = function(array $query) use ($endpoint, $domain) {
                    $maxAttempts = 5;
                    $attempt = 0;
                    $backoff = 1; 
                    do {
                        $attempt++;
                        $response = Http::withToken($domain->token)->acceptJson()->get($endpoint, $query);
                        if ($response->status() === 429) {
                            $retryAfter = (int) $response->header('Retry-After', $backoff);
                            \Log::warning('[Admin Orders] 429 rate limited. Sleeping', [
                                'attempt' => $attempt,
                                'retry_after' => $retryAfter,
                                'query' => $query,
                            ]);
                            sleep(max(1, $retryAfter));
                            $backoff = min($backoff * 2, 30);
                            continue;
                        }
                        if ($response->serverError()) {
                            \Log::warning('[Admin Orders] server error, retrying', [
                                'status' => $response->status(),
                                'attempt' => $attempt,
                                'query' => $query,
                            ]);
                            sleep($backoff);
                            $backoff = min($backoff * 2, 30);
                            continue;
                        }
                        return $response; 
                    } while ($attempt < $maxAttempts);
                    return $response;
                };

                do {
                    $q = array_merge($params, ['page' => $page, 'per_page' => $perPage]);
                    $response = $requestPage($q);
                    if ($response->failed()) {
                        throw new \RuntimeException('Orders API error: '.$response->status());
                    }

                    $json = $response->json();

                    $payload = [];
                    $pagination = null;

                    if (is_array($json)) {
                        if (array_key_exists('data', $json) && is_array($json['data'])) {
                            $dataNode = $json['data'];
                            if (array_key_exists('data', $dataNode) && is_array($dataNode['data'])) {
                                $payload = $dataNode['data'];
                                $pagination = $dataNode['pagination'] ?? null;
                            } else {
                                $payload = $dataNode;
                            }
                        } else {
                            $payload = $json;
                        }
                    }

                    if (is_array($payload)) {
                        foreach ($payload as $item) { $all[] = $item; }
                    }

                    if ($pagination && is_array($pagination)) {
                        $current = (int) ($pagination['current_page'] ?? $page);
                        $lastPage = (int) ($pagination['last_page'] ?? $current);
                        $page = $current + 1;
                    } else {
                        $lastPage = $page; 
                    }

                } while ($lastPage !== null && $page <= $lastPage);

                
                $isCompleted = function($row): bool {
                    $r = is_array($row) ? $row : (array) $row;
                    $val = static function($k) use ($r) {
                        $v = $r[$k] ?? null;
                        if (is_string($v)) { return strtolower(trim($v)); }
                        if (is_bool($v))   { return $v ? '1' : '0'; }
                        if (is_numeric($v)) { return (string) ((int) $v); }
                        return $v;
                    };

                    $status = (string) ($val('status') ?? '');
                    $payStatus = (string) ($val('payment_status') ?? '');
                    $donStatus = (string) ($val('donation_status') ?? '');
                    $isPaidFlag = $val('is_paid');

                    $completedKeywords = ['completed','complete','paid','done','success','successful','finished'];

                    $in = function($value) use ($completedKeywords) {
                        if (!is_string($value)) return false;
                        foreach ($completedKeywords as $k) {
                            if ($value === $k) return true;
                        }
                        return false;
                    };

                    if ($in($status) || $in($payStatus) || $in($donStatus)) { return true; }
                    if ($isPaidFlag === '1' || $isPaidFlag === 1 || $isPaidFlag === true) { return true; }

                    return false;
                };

                $filtered = array_values(array_filter($all, $isCompleted));

                $orders = collect($filtered)->values();
                $ordersCount = $orders->count();
                $totalAmount = $orders->reduce(function($carry, $row){
                    $r = is_array($row) ? $row : (array) $row;
                    $val = (float) ($r['total'] ?? $r['amount'] ?? $r['grand_total'] ?? 0);
                    return $carry + $val;
                }, 0.0);
                $first = (array) (($orders[0] ?? []) ?: []);
                $currency = $first['currency'] ?? null;

                if (strtolower((string) $request->input('export')) === 'csv') {
                    $filename = 'orders_completed_'.date('Ymd_His').'.csv';
                    $headers = [
                        'Content-Type'        => 'text/csv; charset=UTF-8',
                        'Content-Disposition' => 'attachment; filename="'.$filename.'"',
                    ];

                    return response()->streamDownload(function() use ($orders) {
                        $out = fopen('php://output', 'w');
                        fwrite($out, chr(0xEF).chr(0xBB).chr(0xBF));

                        $common = ['payment_method_display','code','status','customer_name','total','created_at'];
                        $first = (array) (($orders[0] ?? []) ?: []);
                        $cols = array_values(array_unique(array_merge($common, array_keys($first))));
                        fputcsv($out, $cols);

                        foreach ($orders as $row) {
                            $r = is_array($row) ? $row : (array) $row;
                            $line = [];
                            foreach ($cols as $c) {
                                $v = $r[$c] ?? '';
                                if (is_scalar($v)) {
                                    if (in_array($c, ['total','amount','grand_total'], true) && is_numeric($v)) {
                                        $line[] = number_format((float) $v, 2, '.', '');
                                    } else {
                                        $line[] = (string) $v;
                                    }
                                } else {
                                    $line[] = '';
                                }
                            }
                            fputcsv($out, $line);
                        }

                        fclose($out);
                    }, $filename, $headers);
                }
            } catch (\Throwable $e) {
                $error = $e->getMessage();
                $orders = collect();
                $ordersCount = null;
                $totalAmount = null;
                $currency = null;
            }
        }

        return view('admin.dashboard.domains.orders', [
            'domains' => $domains,
            'selectedDomainId' => $selectedDomainId,
            'orders' => $orders,
            'error' => $error,
            'ordersCount' => $ordersCount,
            'totalAmount' => $totalAmount,
            'currency' => $currency,
            // Also echo back filters for the view convenience
            'dateFrom' => $request->input('date_from'),
            'dateTo' => $request->input('date_to'),
            'onlyCompleted' => $onlyCompletedEffective,
        ]);
    }

    /**
     * Fetch single order details (used by AJAX modal).
     * Requires domain_id to know which API base URL and token to use.
     */
    public function show(Request $request, $order)
    {
        $domainId = $request->input('domain_id');
        if (!$domainId) {
            return response()->json(['message' => 'domain_id is required'], 422);
        }

        try {
            $domain = Domain::findOrFail($domainId);
            $base = rtrim($domain->domain_url ?: config('app.url'), '/');
            // Try common REST pattern /api/management/orders/{id}
            $endpoint = $base.'/api/management/orders/'.urlencode((string)$order);

            $response = Http::withToken($domain->token)->acceptJson()->get($endpoint);
            if ($response->failed()) {
                return response()->json([
                    'message' => 'Orders API error',
                    'status' => $response->status(),
                    'body' => $response->json(),
                ], 502);
            }
            $json = $response->json();
            $data = is_array($json) && array_key_exists('data', $json) ? $json['data'] : $json;
            return response()->json(['data' => $data]);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
