<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Database\Seeders\TestDataSeeder;

class CreateTestData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:create-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create test domains and statistics data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creating test data...');
        
        $seeder = new TestDataSeeder();
        $seeder->setCommand($this);
        $seeder->run();
        
        $this->info('Test data created successfully!');
        $this->info('You can now check the dashboard to see the statistics.');
        
        return Command::SUCCESS;
    }
}
