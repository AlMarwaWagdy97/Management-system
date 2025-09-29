<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CharitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PaymentsSeeder::class);
        $this->call(CharityCategorySeeder::class);
        $this->call(CharityTagSeeder::class);
        $this->call(CharityProjectsSeeder::class);
     

    }
}
