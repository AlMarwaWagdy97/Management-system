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

        if ($selectedDomainId) {
            try {
                $domain = Domain::findOrFail($selectedDomainId);
                $base = rtrim($domain->domain_url ?: config('app.url'), '/');
                $endpoint = $base.'/api/management/orders';
                $params = [];

                $response = Http::withToken($domain->token)->acceptJson()->get($endpoint, $params);
                if ($response->failed()) {
                    throw new \RuntimeException('Orders API error: '.$response->status());
                }
                $json = $response->json();
                $data = is_array($json) && array_key_exists('data', $json) && is_array($json['data'])
                    ? $json['data']
                    : (is_array($json) ? $json : []);

                // Show ALL orders as requested (no status filtering)
                $orders = collect($data)->values();
            } catch (\Throwable $e) {
                $error = $e->getMessage();
                $orders = collect();
            }
        }

        return view('admin.dashboard.domains.orders', [
            'domains' => $domains,
            'selectedDomainId' => $selectedDomainId,
            'orders' => $orders,
            'error' => $error,
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
