<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StoreStatistics;
use App\Models\Domain;
use Carbon\Carbon;

class StoreStatisticsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get yadbeyad domain
        $yadbeyadDomain = Domain::where('domain_name', 'yadbeyad')->first();
        
        if ($yadbeyadDomain) {
            // Add sample statistics for yadbeyad
            StoreStatistics::create([
                'store_id' => $yadbeyadDomain->id,
                'store_name' => 'yadbeyad',
                'api_url' => 'https://yadbeyad.com/api/statistics',
                'orders_count' => 150,
                'orders_total' => 75000.50,
                'statistics_date' => Carbon::now()->format('Y-m-d'),
            ]);

            // Add more sample data for different dates
            StoreStatistics::create([
                'store_id' => $yadbeyadDomain->id,
                'store_name' => 'yadbeyad',
                'api_url' => 'https://yadbeyad.com/api/statistics',
                'orders_count' => 200,
                'orders_total' => 95000.75,
                'statistics_date' => Carbon::now()->subDays(1)->format('Y-m-d'),
            ]);

            StoreStatistics::create([
                'store_id' => $yadbeyadDomain->id,
                'store_name' => 'yadbeyad',
                'api_url' => 'https://yadbeyad.com/api/statistics',
                'orders_count' => 300,
                'orders_total' => 125000.00,
                'statistics_date' => Carbon::now()->subDays(2)->format('Y-m-d'),
            ]);
        }

        // Get test-store domain
        $testDomain = Domain::where('domain_name', 'test-store')->first();
        
        if ($testDomain) {
            // Add sample statistics for test-store
            StoreStatistics::create([
                'store_id' => $testDomain->id,
                'store_name' => 'test-store',
                'api_url' => 'https://test-store.com/api/statistics',
                'orders_count' => 75,
                'orders_total' => 45000.25,
                'statistics_date' => Carbon::now()->format('Y-m-d'),
            ]);

            StoreStatistics::create([
                'store_id' => $testDomain->id,
                'store_name' => 'test-store',
                'api_url' => 'https://test-store.com/api/statistics',
                'orders_count' => 100,
                'orders_total' => 60000.00,
                'statistics_date' => Carbon::now()->subDays(1)->format('Y-m-d'),
            ]);
        }
    }
}
