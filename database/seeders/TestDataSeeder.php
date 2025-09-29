<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Domain;
use App\Models\StoreStatistics;
use Carbon\Carbon;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating test domains and statistics...');

        // Create yadbeyad domain
        $yadbeyadDomain = Domain::firstOrCreate(
            ['domain_name' => 'yadbeyad'],
            [
                'domain_url' => 'https://yadbeyad.com',
                'status' => true,
                'token' => 'test_token_123',
                'type' => 'yadbeyad',
            ]
        );

        $this->command->info('Created yadbeyad domain with ID: ' . $yadbeyadDomain->id);

        // Create test-store domain
        $testDomain = Domain::firstOrCreate(
            ['domain_name' => 'test-store'],
            [
                'domain_url' => 'https://test-store.com',
                'status' => true,
                'token' => 'test_token_456',
                'type' => 'test',
            ]
        );

        $this->command->info('Created test-store domain with ID: ' . $testDomain->id);

        // Clear existing statistics
        StoreStatistics::truncate();

        // Add sample statistics for yadbeyad
        $yadbeyadStats = [
            ['orders_count' => 150, 'orders_total' => 75000.50, 'days_ago' => 0],
            ['orders_count' => 200, 'orders_total' => 95000.75, 'days_ago' => 1],
            ['orders_count' => 300, 'orders_total' => 125000.00, 'days_ago' => 2],
            ['orders_count' => 180, 'orders_total' => 85000.25, 'days_ago' => 3],
            ['orders_count' => 220, 'orders_total' => 110000.00, 'days_ago' => 4],
        ];

        foreach ($yadbeyadStats as $stat) {
            StoreStatistics::create([
                'store_id' => $yadbeyadDomain->id,
                'store_name' => 'yadbeyad',
                'api_url' => 'https://yadbeyad.com/api/statistics',
                'orders_count' => $stat['orders_count'],
                'orders_total' => $stat['orders_total'],
                'statistics_date' => Carbon::now()->subDays($stat['days_ago'])->format('Y-m-d'),
            ]);
        }

        // Add sample statistics for test-store
        $testStats = [
            ['orders_count' => 75, 'orders_total' => 45000.25, 'days_ago' => 0],
            ['orders_count' => 100, 'orders_total' => 60000.00, 'days_ago' => 1],
            ['orders_count' => 120, 'orders_total' => 72000.50, 'days_ago' => 2],
            ['orders_count' => 90, 'orders_total' => 54000.75, 'days_ago' => 3],
            ['orders_count' => 110, 'orders_total' => 66000.00, 'days_ago' => 4],
        ];

        foreach ($testStats as $stat) {
            StoreStatistics::create([
                'store_id' => $testDomain->id,
                'store_name' => 'test-store',
                'api_url' => 'https://test-store.com/api/statistics',
                'orders_count' => $stat['orders_count'],
                'orders_total' => $stat['orders_total'],
                'statistics_date' => Carbon::now()->subDays($stat['days_ago'])->format('Y-m-d'),
            ]);
        }

        $this->command->info('Created ' . (count($yadbeyadStats) + count($testStats)) . ' statistics records');
        $this->command->info('Test data created successfully!');
    }
}
