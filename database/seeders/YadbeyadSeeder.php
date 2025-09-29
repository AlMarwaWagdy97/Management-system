<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Domain;
use App\Models\StoreStatistics;
use Carbon\Carbon;

class YadbeyadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating yadbeyad domain...');

        // Create yadbeyad domain
        $yadbeyadDomain = Domain::firstOrCreate(
            ['domain_name' => 'yadbeyad'],
            [
                'domain_url' => 'http://127.0.0.1:8000',
                'status' => true,
                'token' => 'your_api_token_here', // Replace with real token
                'type' => 'yadbeyad',
            ]
        );

        $this->command->info('Created yadbeyad domain with ID: ' . $yadbeyadDomain->id);
        $this->command->info('Domain URL: ' . $yadbeyadDomain->domain_url);
        $this->command->info('API Endpoint: ' . $yadbeyadDomain->domain_url . '/api/management/statistics/completed-orders');
        
        $this->command->info('You can now test the API by visiting:');
        $this->command->info('http://127.0.0.1:8000/api/management/statistics/completed-orders');
        $this->command->info('http://127.0.0.1:8000/api/management/statistics/completed-orders?from_date=2025-01-01&to_date=2025-12-31');
    }
}
