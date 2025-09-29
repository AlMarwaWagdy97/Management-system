<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Admin\StoreApiService;

class FetchStoreStatistics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stores:fetch-statistics {--start-date=} {--end-date=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch statistics from all store APIs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $startDate = $this->option('start-date');
        $endDate = $this->option('end-date');

        $this->info('Fetching statistics from all stores...');

        $storeApiService = new StoreApiService();
        $statistics = $storeApiService->fetchAllStoresStatistics($startDate, $endDate);

        $this->info('Statistics fetched successfully!');
        $this->info('Total statistics records: ' . count($statistics));

        // Display aggregated statistics
        $aggregated = $storeApiService->getAggregatedStatistics($startDate, $endDate);
        
        $this->table(
            ['Metric', 'Value'],
            [
                ['Total Orders', $aggregated['total_orders']],
                ['Total Amount', number_format($aggregated['total_amount'], 2) . ' ريال'],
                ['Stores Count', $aggregated['stores_count']],
            ]
        );

        return Command::SUCCESS;
    }
}
