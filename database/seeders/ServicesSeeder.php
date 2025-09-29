<?php

namespace Database\Seeders;

use App\Models\Services;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('services')->delete();
        DB::table('services_translations')->delete();
        
        Services::factory(200)->create();

    }
}
