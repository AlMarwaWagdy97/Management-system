<?php

namespace Database\Seeders;

use App\Models\Themes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ThemesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(Themes::query()->where('key', 'login_dashboard')->get()->first() == null){
            Themes::create([
                'key' => 'login_dashboard',
                'type' => '1',
                'value' => '{"box_color":"#666666","font_color":"#eeeeee","button_color":"#38761d","logo_image":"","background":""}',
            ]);
        }
        if(Themes::query()->where('key', 'dashboard')->get()->first() == null){
            Themes::create([
                'key' => 'dashboard',
                'type' => '1',
                'value' => '{"navbar_background":"#f3f6f4","navbar_color":"#206279","side_navbar_background":"#263238","side_navbar_color":"#f3f6f4","icon":"","logo":""}',
            ]);
        }
    }
}
