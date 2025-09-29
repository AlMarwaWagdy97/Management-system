<?php

namespace Database\Seeders;

use App\Models\Articles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ArticlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('articles')->delete();
        DB::table('article_translations')->delete();
        
        Articles::factory(200)->create();
    }
}
