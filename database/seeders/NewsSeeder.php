<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\Pages;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Factories\PagesFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('news')->delete();
        DB::table('news_translations')->delete();
        News::factory()->count(100)->create();

    }
}
