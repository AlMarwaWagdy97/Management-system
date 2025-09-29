<?php

namespace Database\Seeders;

use App\Models\Portfolios;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PortfolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('portfolios')->delete();
        DB::table('portfolios_translations')->delete();
        
        Portfolios::factory()->count(100)->create();
    }
}
