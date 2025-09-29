<?php

namespace Database\Seeders;

use App\Models\HomeSettingPage;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HomeSettingPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $title_settings = [
        'about',
        'vission',
        'mission',
        'our-message',
        'offers',
        'projects',
        'book',
        'news',
        'services',
        'contact-us',
        'footer',
        ];

        foreach($title_settings as $title){
            foreach(config('translatable.locales') as $locale){
                $dataTrans[$locale]['title'] = $title;
                $dataTrans[$locale]['description'] = 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit praesentium blanditiis dolore repellat quam! Minima corporis corrupti blanditiis est in, atque excepturi, ipsam voluptate molestiae dignissimos magni recusandae praesentium modi.';
            }
            HomeSettingPage::create(['title_section'=>$title] + $dataTrans);
        }
    }
}
