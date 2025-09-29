<?php

namespace Database\Seeders;

use App\Models\GiftCards;
use App\Models\GiftCategories;
use App\Models\GiftOccasioins;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Factories\GiftOccasioinsFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GiftsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // gift categories ----------------------------------------
        DB::table('gift_categories')->delete();
        DB::table('gift_categories_translations')->delete();
        GiftCategories::factory()->count(5)->create();
        GiftCategories::factory()->count(100)->create();

        // gift categories ----------------------------------------
        DB::table('gift_occasioins')->delete();
        DB::table('gift_occasioins_translations')->delete();
        GiftOccasioins::factory()->count(100)->create();

        DB::table('gift_cards')->delete();
        GiftCards::factory()->count(100)->create();
    }
}
