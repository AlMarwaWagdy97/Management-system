<?php

namespace App\Http\Controllers\Site;

use App\Charity\Settings\SettingSingleton;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index(){

        $campaign = SettingSingleton::getInstance();

        return view('site.pages.campaigns.index', compact('campaign'));
    }
}
