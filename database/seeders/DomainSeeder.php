<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Domain;

class DomainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Add yadbeyad domain
        Domain::create([
            'domain_name' => 'yadbeyad',
            'domain_url' => 'https://yadbeyad.com',
            'status' => true,
            'token' => 'your_api_token_here',
            'type' => 'yadbeyad',
        ]);

        // Add another test domain
        Domain::create([
            'domain_name' => 'test-store',
            'domain_url' => 'https://test-store.com',
            'status' => true,
            'token' => 'test_token_here',
            'type' => 'test',
        ]);
    }
}
