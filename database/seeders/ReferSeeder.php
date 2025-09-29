<?php

namespace Database\Seeders;


use App\Models\Refer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ReferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('refers')->delete();
        
        Refer::factory()->count(200)->create();
        
    }
}
