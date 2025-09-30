<?php

namespace App\Services\Admin;

use App\Models\Store;
use App\Models\StoreStatistics;
use App\Models\Domain;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class StoreApiService
{
    /**
     * Fetch statistics from all domains APIs
     */
    public function fetchAllStoresStatistics($startDate = null, $endDate = null)
    {
        $domains = Domain::where('status', 1)->get();
        $statistics = [];

        foreach ($domains as $domain) {
            try {
                $domainStats = $this->fetchDomainStatistics($domain, $startDate, $endDate);
                if ($domainStats) {
                    $statistics[] = $domainStats;
                }
            } catch (\Exception $e) {
                Log::error("Failed to fetch statistics for domain {$domain->id}: " . $e->getMessage());
                // Continue with other domains even if one fails
            }
        }

        return $statistics;
    }

    /**
     * Fetch statistics from a specific domain API
     */
    public function fetchDomainStatistics(Domain $domain, $startDate = null, $endDate = null)
    {
        // Get API URL from domain configuration
        $apiUrl = $this->getDomainApiUrl($domain);
        
        if (!$apiUrl) {
            return null;
        }

        $params = [
            'from_date' => $startDate ?: Carbon::now()->subMonth()->format('Y-m-d'),
            'to_date' => $endDate ?: Carbon::now()->format('Y-m-d'),
        ];

        try {
            // Add token to headers if available
            $headers = [];
            if ($domain->token) {
                $headers['Authorization'] = 'Bearer ' . $domain->token;
            }

            $response = Http::timeout(30)
                ->withHeaders($headers)
                ->get($apiUrl, $params);
            
            if ($response->successful()) {
                $data = $response->json();
                
                // Save statistics to database
                return $this->saveDomainStatistics($domain, $data, $params['from_date'], $params['to_date']);
            }
        } catch (\Exception $e) {
            Log::error("API call failed for domain {$domain->id}: " . $e->getMessage());
        }

        return null;
    }

    /**
     * Get API URL for a domain
     */
    private function getDomainApiUrl(Domain $domain)
    {
        // Get API URL from domain configuration
        // For yadbeyad: http://127.0.0.1:8000/api/management/statistics/completed-orders
        // For other domains: https://domain2.com/api/management/statistics/completed-orders, etc.
        
        $baseUrl = $domain->domain_url;
        
        if (!$baseUrl) {
            return null;
        }

        // Construct the full API URL for completed orders
        if (!str_starts_with($baseUrl, 'http')) {
            $baseUrl = "http://{$baseUrl}";
        }

        // Remove trailing slash if exists
        $baseUrl = rtrim($baseUrl, '/');
        
        // Add the specific API endpoint
        return $baseUrl . '/api/management/statistics/completed-orders';
    }

    /**
     * Save domain statistics to database
     */
    private function saveDomainStatistics(Domain $domain, array $data, $startDate, $endDate)
    {
        $statistics = StoreStatistics::create([
            'store_id' => $domain->id, // Using domain ID as store_id for compatibility
            'store_name' => $domain->domain_name,
            'api_url' => $this->getDomainApiUrl($domain),
            'orders_count' => $data['orders_count'] ?? 0,
            'orders_total' => $data['orders_total'] ?? 0,
            'statistics_date' => $endDate,
        ]);

        return $statistics;
    }

    /**
     * Get aggregated statistics for all stores
     */
    // public function getAggregatedStatistics($startDate = null, $endDate = null)
    // {
    //     $query = StoreStatistics::query();

    //     if ($startDate) {
    //         $query->where('statistics_date', '>=', $startDate);
    //     }
    //     if ($endDate) {
    //         $query->where('statistics_date', '<=', $endDate);
    //     }

    //     $statistics = $query->get();

    //     // Group by store and aggregate
    //     $grouped = $statistics->groupBy('store_id')->map(function ($items) {
    //         return [
    //             'store_name' => optional($items->last())->store_name,
    //             'orders_count' => $items->sum('orders_count'),
    //             'orders_total' => $items->sum('orders_total'),
    //         ];
    //     });

    //     return [
    //         'total_orders' => $grouped->sum('orders_count'),
    //         'total_amount' => $grouped->sum('orders_total'),
    //         'stores_count' => $grouped->count(), // count distinct stores
    //         'stores_details' => $grouped->values(),
    //     ];
    // }

    /**
     * Get statistics for a specific store
     */
    public function getStoreStatistics($storeId, $startDate = null, $endDate = null)
    {
        $query = StoreStatistics::where('store_id', $storeId);

        if ($startDate) {
            $query->where('statistics_date', '>=', $startDate);
        }
        if ($endDate) {
            $query->where('statistics_date', '<=', $endDate);
        }

        return $query->get();
    }
}
