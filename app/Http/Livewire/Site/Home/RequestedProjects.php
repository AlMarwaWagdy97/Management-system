<?php

namespace App\Http\Livewire\Site\Home;

use App\Charity\Settings\SettingSingleton;
use App\Models\CharityProject;
use Livewire\Component;

class RequestedProjects extends Component
{
    public $projects, $showSection;

    public function mount()
    {
        // show section
        $settings = SettingSingleton::getInstance();
        $this->showSection = $settings->getItem('show_most_order');

        // get the project
        $this->projects = CharityProject::where('most_sell', 1)->with('trans')->active()->featuer()->Web()->orderBy('sort', 'ASC')->get();
    }


    public function render()
    {
        return view('livewire.site.home.requested-projects');
    }
}
