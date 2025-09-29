<?php

namespace Database\Seeders;

use App\Models\Menue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MenueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menues')->delete();
        DB::table('menue_translations')->delete();
        // create Menus
        foreach(config('translatable.locales') as $locale){
            $langMenue[$locale]['title'] = 'Home';
            $langMenue[$locale]['slug'] = slug($langMenue[$locale]['title']);
        }
        $data = $langMenue + $langMenue + [
            'parent_id' => Null,
            'level' => 1,
            'type' => "static",
            'url' =>  "/",
        ];
        $menus = Menue::create(  $data +  ['position' =>  "main"] );
        $menus = Menue::create(  $data +  ['position' =>  "footer"] );

        foreach(config('translatable.locales') as $locale){
            $langMenue[$locale]['title'] = 'About Us';
            $langMenue[$locale]['slug'] = slug($langMenue[$locale]['title']);
        }
        $data = $langMenue + $langMenue + [
            'parent_id' => Null,
            'level' => 1,
            'type' => "dynamic",
            'dynamic_table' => "pages",
            'dynamic_url' => "/pages/about",
            'url' =>  "/",
        ];
        $menus = Menue::create(  $data +  ['position' =>  "main"] );
        $menus = Menue::create(  $data +  ['position' =>  "footer"] );
        foreach(config('translatable.locales') as $locale){
            $langMenue[$locale]['title'] = 'Offers';
            $langMenue[$locale]['slug'] = slug($langMenue[$locale]['title']);
        }
        $data = $langMenue + $langMenue + [
            'parent_id' => Null,
            'level' => 1,
            'type' => "dynamic",
            'dynamic_table' => "all offers",
            'dynamic_url' => "/offers",
            'url' =>  "/",
        ];
        $menus = Menue::create(  $data +  ['position' =>  "main"] );
        $menus = Menue::create(  $data +  ['position' =>  "footer"] );
        foreach(config('translatable.locales') as $locale){
            $langMenue[$locale]['title'] = 'Projects';
            $langMenue[$locale]['slug'] = slug($langMenue[$locale]['title']);
        }
        $data = $langMenue + $langMenue + [
            'parent_id' => Null,
            'level' => 1,
            'type' => "dynamic",
            'dynamic_table' => "projects",
            'dynamic_url' => "/projects",
            'url' =>  "/",
        ];
        
        Menue::factory()->count(5)->create();
        Menue::factory()->count(10)->create();
        Menue::factory()->count(100)->create();
    }
}
