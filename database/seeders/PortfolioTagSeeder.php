<?php

namespace Database\Seeders;

use App\Models\PortfolioTags;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PortfolioTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('portfolio_tags')->delete();
        DB::table('portfolio_tags_translations')->delete();
        
        PortfolioTags::factory()->count(100)->create();
    }
}
