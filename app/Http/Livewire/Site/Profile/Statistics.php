<?php

namespace App\Http\Livewire\Site\Profile;

use App\Models\CategoryProjects;
use App\Models\OrderView;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Statistics extends Component
{

    public $items;
    public $donor;
    public $selectedStatus, $selectedYear;
    public $totalOrders,  $ordersCount;


    public function mount()
    {
        $query = OrderView::where('donor_id', auth('account')->user()->donor->id);
        $this->ordersCount = $query->count();
        $this->totalOrders =  $query->Sum('total');
        $this->donor = auth('account')->user()->donor;
        $this->getData();
    }

    public function getData()
    {
        $this->items = CategoryProjects::select(['category_projects.id', 'cpt.title', 'category_projects.image', DB::raw('SUM(od.total) AS total'),])
            ->leftJoin('category_projects_translations AS cpt', 'cpt.category_id', '=', 'category_projects.id')
            ->leftJoin('charity_projects AS chp', 'chp.category_id', '=', 'category_projects.id')
            ->leftJoin('order_details AS od', 'od.item_id', '=', 'chp.id')
            ->leftJoin('orders AS o', 'o.id', '=', 'od.order_id')
            ->where('o.donor_id', $this->donor->id) // Use donor ID directly
            ->where('cpt.locale', app()->getLocale()) // Use locale helper
            ->when($this->selectedStatus !== null, function (Builder $query) {
                return $query->where('o.status', $this->selectedStatus);
            })
            ->when($this->selectedYear !== null, function (Builder $query) {
                return $query->whereRaw('YEAR(o.created_at) = ?', [$this->selectedYear]);
            })
            ->groupBy('category_projects.id', 'cpt.title', 'category_projects.image')
            ->get();
    }


    public function updateSelectStatus()
    {
        $this->getData();
    }
    public function render()
    {
        return view('livewire.site.profile.statistics');
    }
}
