<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoryProjects;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CharityCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            //Parent categories 1 - 4: 
            array('id' => '1', 'parent_id' => null, 'level' => '1', 'project_types' => 'normal project', 'background_color' => '#6ea570', 'feature' => '1', 'status' => '1', 'created_by' => '1',
                  'image' => 'https://pixabay.com/vectors/flat-design-symbol-icon-www-2126884/'), 
            array('id' => '2', 'parent_id' => null, 'level' => '1', 'project_types' => 'normal project', 'background_color' => '#eb9651', 'feature' => '1', 'status' => '1', 'created_by' => '1',
                  'image' => 'https://pixabay.com/vectors/flat-design-symbol-icon-www-2126879/'), 
            array('id' => '3', 'parent_id' => null, 'level' => '1', 'project_types' => 'normal project', 'background_color' => '#a7332a', 'feature' => '1', 'status' => '1', 'created_by' => '1',
                  'image' => 'https://pixabay.com/vectors/seo-search-engine-optimization-1970475/'), 
            array('id' => '4', 'parent_id' => null, 'level' => '1', 'project_types' => 'normal project', 'background_color' => '#6ea570', 'feature' => '1', 'status' => '1', 'created_by' => '1',
                  'image' => 'https://pixabay.com/vectors/flat-design-symbol-icon-www-2442462/'), 
            
            //Children of category #1
            array('id' => '5', 'parent_id' => '1', 'level' => '2', 'project_types' => 'normal project', 'feature' => '1', 'status' => '1', 'created_by' => '1'), 
            array('id' => '6', 'parent_id' => '1', 'level' => '2', 'project_types' => 'normal project', 'feature' => '1', 'status' => '1', 'created_by' => '1'), 
            array('id' => '7', 'parent_id' => '1', 'level' => '2', 'project_types' => 'normal project', 'feature' => '1', 'status' => '1', 'created_by' => '1'), 
            array('id' => '8', 'parent_id' => '1', 'level' => '2', 'project_types' => 'normal project', 'feature' => '1', 'status' => '1', 'created_by' => '1'), 
            array('id' => '9', 'parent_id' => '1', 'level' => '2', 'project_types' => 'normal project', 'feature' => '1', 'status' => '1', 'created_by' => '1'), 

            //Children of category #2
            array('id' => '10', 'parent_id' => '2', 'level' => '2', 'project_types' => 'normal project', 'feature' => '1', 'status' => '1', 'created_by' => '1'), 
            array('id' => '11', 'parent_id' => '2', 'level' => '2', 'project_types' => 'normal project', 'feature' => '1', 'status' => '1', 'created_by' => '1'), 
            array('id' => '12', 'parent_id' => '2', 'level' => '2', 'project_types' => 'normal project', 'feature' => '1', 'status' => '1', 'created_by' => '1'), 
        ]; 

        $categoriesTranslation = [
            //Parent categories 1 - 4:
            array('category_id' => '1', 'locale' => 'ar', 'title' => 'الكفالات', 'slug'=> 'الكفالات'),
            array('category_id' => '1', 'locale' => 'en', 'title' => 'Sponser', 'slug'=> 'Sponser'),
            
            array('category_id' => '2', 'locale' => 'ar', 'title' => 'السداد', 'slug'=> 'السداد'),
            array('category_id' => '2', 'locale' => 'en', 'title' => 'Repayment', 'slug'=> 'Repayment'),

            array('category_id' => '3', 'locale' => 'ar', 'title' => 'طارئ', 'slug'=> 'طارئ'),
            array('category_id' => '3', 'locale' => 'en', 'title' => 'Emergency', 'slug'=> 'Emergency'),

            array('category_id' => '4', 'locale' => 'ar', 'title' => 'وقف', 'slug'=> 'وقف'),
            array('category_id' => '4', 'locale' => 'en', 'title' => 'Waqf', 'slug'=> 'Waqf'),

            //Children of category #1
            array('category_id' => '5', 'locale' => 'ar', 'title' => 'يتيم', 'slug'=> 'يتيم'),
            array('category_id' => '5', 'locale' => 'en', 'title' => 'Orphans', 'slug'=> 'Orphans'),
            
            array('category_id' => '6', 'locale' => 'ar', 'title' => 'ارملة', 'slug'=> 'ارملة'),
            array('category_id' => '6', 'locale' => 'en', 'title' => 'Window', 'slug'=> 'Window'),

            array('category_id' => '7', 'locale' => 'ar', 'title' => 'أسرة', 'slug'=> 'أسرة'),
            array('category_id' => '7', 'locale' => 'en', 'title' => 'Family', 'slug'=> 'Family'),

            array('category_id' => '8', 'locale' => 'ar', 'title' => 'دراسة', 'slug'=> 'دراسة'),
            array('category_id' => '8', 'locale' => 'en', 'title' => 'School', 'slug'=> 'School'),

            array('category_id' => '9', 'locale' => 'ar', 'title' => 'علاج', 'slug'=> 'علاج'),
            array('category_id' => '9', 'locale' => 'en', 'title' => 'Treatment', 'slug'=> 'Treatment'),

            //Children of category #2
            array('category_id' => '10', 'locale' => 'ar', 'title' => 'ايجار', 'slug'=> 'ايجار'),
            array('category_id' => '10', 'locale' => 'en', 'title' => 'Rent', 'slug'=> 'Rent'),
            
            array('category_id' => '11', 'locale' => 'ar', 'title' => 'اقساط', 'slug'=> 'اقساط'),
            array('category_id' => '11', 'locale' => 'en', 'title' => 'Installments', 'slug'=> 'Installments'),

            array('category_id' => '12', 'locale' => 'ar', 'title' => 'دين', 'slug'=> 'دين'),
            array('category_id' => '12', 'locale' => 'en', 'title' => 'Debt', 'slug'=> 'Debt'),
        ];

        DB::table('category_projects')->delete();
        DB::table('category_projects_translations')->delete();

        // DB::table('category_projects')->insert($categories);
        // DB::table('category_projects_translations')->insert($categories);

        // CategoryProjects::factory()->count(5)->create();
        // CategoryProjects::factory()->count(100)->create();
        // CategoryProjects::factory()->count(100)->create();

    }
}
