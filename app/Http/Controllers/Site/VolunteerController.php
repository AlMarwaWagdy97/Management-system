<?php

namespace App\Http\Controllers\Site;

use App\Charity\Settings\SettingSingleton;
use App\Http\Controllers\Controller;
use App\Models\VolunteeringIdeas;
use App\Models\Volunteers;
use Illuminate\Http\Request;

class VolunteerController extends Controller
{
    public function index(){
        $voluntrees = Volunteers::with('account')->active() ->orderBy('medal', 'ASC')
        ->get()
        ->sortBy(function ($volunteer) {
            return $volunteer->medal !== 0 ? 1 : 0;
            return $volunteer->medal !== 0 ? 1 : 0;
        })->take(10);
        return view('site.volunteering.index', compact('voluntrees'));
    }
    
    public function volunteers(){
        return view('site.volunteering.volunteers');
    }

    public function joinCommunity(){
        return view('site.volunteering.join-community');
    }

    public function informations(){
        $settings = SettingSingleton::getInstance();
        $achievements = json_decode($settings->getVolunteeringData('achievements'), true);
        $initiatives = json_decode($settings->getVolunteeringData('initiative'), true);
        return view('site.volunteering.informations', compact('achievements', 'initiatives'));
    }
    
    public function ideas(){
        return view('site.volunteering.ideas');
    }
    
    public function createIdeas(){
        return view('site.volunteering.ideas-create');
    }

    public function infoIdeas($id){
        $idea = VolunteeringIdeas::with('activeComments', 'loves', 'love_status')->find($id);
        return view('site.volunteering.idea-info', compact('idea'));
    }
}
