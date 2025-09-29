<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Admin\StoreApiService;
use App\Models\Domain;

class TestYadbeyadApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'yadbeyad:test-api {--from-date=} {--to-date=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test yadbeyad API connection and fetch statistics';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $fromDate = $this->option('from-date') ?: now()->subMonth()->format('Y-m-d');
        $toDate = $this->option('to-date') ?: now()->format('Y-m-d');

        $this->info("Testing yadbeyad API from {$fromDate} to {$toDate}...");

        // Get yadbeyad domain
        $domain = Domain::where('domain_name', 'yadbeyad')->first();
        
        if (!$domain) {
            $this->error('yadbeyad domain not found! Please run: php artisan db:seed --class=YadbeyadSeeder');
            return Command::FAILURE;
        }

        $this->info("Domain URL: {$domain->domain_url}");
        $this->info("API Endpoint: {$domain->domain_url}/api/management/statistics/completed-orders");

        // Test API call
        $storeApiService = new StoreApiService();
        
        try {
            $statistics = $storeApiService->fetchDomainStatistics($domain, $fromDate, $toDate);
            
            if ($statistics) {
                $this->info('✅ API call successful!');
                $this->table(
                    ['Metric', 'Value'],
                    [
                        ['Orders Count', $statistics->orders_count],
                        ['Orders Total', number_format($statistics->orders_total, 2) . ' ريال'],
                        ['Statistics Date', $statistics->statistics_date],
                    ]
                );
            } else {
                $this->error('❌ API call failed or returned no data');
            }
        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
        }

        return Command::SUCCESS;
    }
}
