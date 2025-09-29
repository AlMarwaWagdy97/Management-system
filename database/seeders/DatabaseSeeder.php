<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Database\Seeders\AdminSeeder;
use Database\Seeders\ThemesSeeder;
use Database\Seeders\SettingSeeder;
use Database\Seeders\ServicesSeeder;
use Database\Seeders\ContactUsSeeding;
use Database\Seeders\HomeSettingPageSeeder;
use Database\Seeders\DomainSeeder;
use Database\Seeders\StoreStatisticsSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(SettingSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(AdminSeeder::class);
        
        $this->call(CmsSeeder::class);
        
        $this->call(CharitySeeder::class);

        $this->call(ReferSeeder::class);

        $this->call(GiftsSeeder::class);

        // Add domains and store statistics
        // During local testing with a single store, only seed yadbeyad
        // Comment the following two and seed only Yadbeyad to avoid multiple stores showing up
        // $this->call(DomainSeeder::class);
        // $this->call(StoreStatisticsSeeder::class);
        if (class_exists(\Database\Seeders\YadbeyadSeeder::class)) {
            $this->call(YadbeyadSeeder::class);
        }

    }
}
