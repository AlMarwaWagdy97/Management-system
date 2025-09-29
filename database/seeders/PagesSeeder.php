<?php

namespace Database\Seeders;

use App\Models\Pages;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Factories\PagesFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pages')->delete();
        DB::table('pages_translations')->delete();

        $req = [
            $about = [
                'en' => [
                    'title' => 'About',
                    'slug' => 'about'
                ],
                'ar' => [
                    'title' => 'نبذه عنا',
                    'slug' => 'نبذه-عنا'
                ],
            ],
            $blogs = [
                'en' => [
                    'title' => 'Blogs',
                    'slug' => 'blogs'
                ],
                'ar' => [
                    'title' => 'مقالات ',
                    'slug' => 'مقالات'
                ],
            ],
            $terms = [
                'en' => [
                    'title' => 'Terms of service',
                    'slug' => 'terms-of-service'
                ],
                'ar' => [
                    'title' => 'شروط الخدمة',
                    'slug'  => 'شروط-الخدمة',
                ],
            ],
            $policy = [
                'en' => [
                    'title' => 'Privacy policy',
                    'slug'  => 'privacy-policy'
                ],
                'ar' => [
                    'title' => 'سياسة الخصوصية',
                    'slug'  => 'سياسة-الخصوصية',
                ],
            ],
        ];
        // if (Pages::query()->get()->count() == 0) {
        //     foreach ($req as $rq) {
        //         Pages::create($rq);
        //     }
        // }

        Pages::factory()->count(100)->create();

    }
}
