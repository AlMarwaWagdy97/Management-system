<?php
namespace App\Http\Controllers\Cashier\Site;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class CashierSiteController extends Controller
{
    public function home()
    {
    
        $categories = [
            ['id'=>1,'slug'=>'health','name'=>'الصحة','image'=>'/images/cat-health.jpg'],
            ['id'=>2,'slug'=>'education','name'=>'التعليم','image'=>'/images/cat-edu.jpg'],
            ['id'=>3,'slug'=>'food','name'=>'الغذاء','image'=>'/images/cat-food.jpg'],
        ];

        return view('cashier.site.home', compact('categories'));
    }

    public function categories()
    {
        $categories = [
            ['id'=>1,'slug'=>'health','name'=>'الصحة'],
            ['id'=>2,'slug'=>'education','name'=>'التعليم'], 
            ['id'=>3,'slug'=>'food','name'=>'الغذاء'],
        ];
        return view('cashier.site.categories', compact('categories'));
    }

    public function categoryShow($slug)
    {
     
        $projects = [
            ['id'=>101,'title'=>"مشروع 1 في {$slug}", 'summary'=>'وصف بسيط', 'amount'=>'2000'],
            ['id'=>102,'title'=>"مشروع 2 في {$slug}", 'summary'=>'وصف بسيط', 'amount'=>'3500'],
            ['id'=>103,'title'=>"مشروع 3 في {$slug}", 'summary'=>'وصف بسيط', 'amount'=>'500'],
        ];

        $category = ['slug'=>$slug, 'name'=>Str::title(str_replace('-', ' ', $slug))];

        return view('cashier.site.category_show', compact('category','projects'));
    }
}
