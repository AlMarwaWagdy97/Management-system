<?php

namespace Database\Seeders;

use App\Models\Articles;
use App\Models\ArticleTags;
use App\Models\Categories;
use App\Models\Contactus;
use App\Models\Tag;
use App\Models\News;
use App\Models\Menue;
use App\Models\MenueTranslation;
use App\Models\Slider;
use App\Models\Portfolios;
use App\Models\Services;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CmsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(MenueSeeder::class);
        $this->call(PagesSeeder::class);
        $this->call(NewsSeeder::class);
        $this->call(SliderSeeder::class);
        $this->call(ContactUsSeeder::class);

        $this->call(CategoriesSeeder::class);
        $this->call(ArticlesSeeder::class);
        $this->call(TagSeeder::class);

        $this->call(PortfolioTagSeeder::class);
        $this->call(PortfolioSeeder::class);
        $this->call(ServicesSeeder::class);

    }
}
