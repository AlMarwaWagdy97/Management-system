<?php

namespace Database\Seeders;

use App\Models\CharityTag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CharityTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('charity_tags')->delete();
        DB::table('charity_tag_translations')->delete();

        CharityTag::factory()->count(100)->create();
    }
}
