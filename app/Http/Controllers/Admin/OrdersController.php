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

        if ($selectedDomainId) {
            try {
                $domain = Domain::findOrFail($selectedDomainId);
                $base = rtrim($domain->domain_url ?: config('app.url'), '/');
                $endpoint = $base.'/api/management/orders';

                // Forward optional date filters
                $params = [];
                if ($request->filled('date_from')) { $params['date_from'] = $request->input('date_from'); }
                if ($request->filled('date_to'))   { $params['date_to']   = $request->input('date_to'); }

                // Pull ALL orders by iterating pagination on the remote API
                $all = [];
                $page = 1;
                $perPage = 100; // conservative high page size
                $lastPage = null;

                do {
                    $q = array_merge($params, ['page' => $page, 'per_page' => $perPage]);
                    $response = Http::withToken($domain->token)->acceptJson()->get($endpoint, $q);
                    if ($response->failed()) {
                        throw new \RuntimeException('Orders API error: '.$response->status());
                    }

                    $json = $response->json();

                    // Response can be either { success, data: { data: [...], pagination: {...} } } or simple array/list
                    $payload = [];
                    $pagination = null;

                    if (is_array($json)) {
                        if (array_key_exists('data', $json) && is_array($json['data'])) {
                            // Try nested data structure
                            $dataNode = $json['data'];
                            if (array_key_exists('data', $dataNode) && is_array($dataNode['data'])) {
                                $payload = $dataNode['data'];
                                $pagination = $dataNode['pagination'] ?? null;
                            } else {
                                // Sometimes data is the list itself
                                $payload = $dataNode;
                            }
                        } else {
                            // Fallback to entire json as list
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
                        // If no pagination meta returned, stop after first fetch
                        $lastPage = $page; // ensure loop ends
                    }

                } while ($lastPage !== null && $page <= $lastPage);

                // Normalize and compute stats
                $orders = collect($all)->values();
                $ordersCount = $orders->count();
                $totalAmount = $orders->reduce(function($carry, $row){
                    $r = is_array($row) ? $row : (array) $row;
                    $val = (float) ($r['total'] ?? $r['amount'] ?? $r['grand_total'] ?? 0);
                    return $carry + $val;
                }, 0.0);
                $first = (array) (($orders[0] ?? []) ?: []);
                $currency = $first['currency'] ?? null;

                // Export CSV if requested
                if (strtolower((string) $request->input('export')) === 'csv') {
                    $filename = 'orders_'.date('Ymd_His').'.csv';
                    $headers = [
                        'Content-Type'        => 'text/csv; charset=UTF-8',
                        'Content-Disposition' => 'attachment; filename="'.$filename.'"',
                    ];

                    return response()->streamDownload(function() use ($orders) {
                        $out = fopen('php://output', 'w');
                        // UTF-8 BOM for Excel compatibility
                        fwrite($out, chr(0xEF).chr(0xBB).chr(0xBF));

                        // Determine columns: start with common set, then add rest from first row
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
                                    // Format amounts
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
            'onlyCompleted' => $request->boolean('only_completed'),
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
