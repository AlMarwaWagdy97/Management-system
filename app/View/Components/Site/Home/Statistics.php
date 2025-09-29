<?php

namespace App\View\Components\Site\Home;

use App\Charity\Settings\SettingSingleton;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Statistics extends Component
{
    public $categoryStats, $showSection;

    public function __construct()
    {
        
        // show section
        $settings = SettingSingleton::getInstance();
        $this->showSection = $settings->getItem('show_statistics');

        $this->categoryStats = json_decode($settings->getItem('cats_statistics') ?? [], true,);
        
    }

    public function render(): View|Closure|string
    {
        return view('components.site.home.statistics', [
            'categoryStats' => $this->categoryStats,
            'showSection' => $this->showSection,
        ]);
    }
}
