<?php

namespace App\Http\Livewire\Site\Home;

use App\Charity\Settings\SettingSingleton;
use App\Models\CategoryProjects;
use App\Models\CharityProject;
use Livewire\Component;

class Projects extends Component
{
    public $projects, $showSection;

    public function mount()
    {
        // get the project
        $this->projects = CharityProject::with('trans', 'orderDetails')->active()->featuer()->Web()->orderBy('sort', 'ASC')->get();

        $settings = SettingSingleton::getInstance();
        $this->showSection = $settings->getItem('show_products');
    }


    public function render()
    {
        return view('livewire.site.home.projects');
    }
}
