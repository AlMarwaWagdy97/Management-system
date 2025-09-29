<?php

namespace App\Http\Livewire\Site\Profile;

use App\Models\OrderDetails;
use App\Models\OrderView;
use Livewire\Component;

class GiftsOrder extends Component
{
    public  $pageCount = 10;
    public $selectedStatus = "";

    public $notes = [], $showNote = [];

    public $countOrders, $totalOrders;

    public $orderCarousels = [];
    public $ordersCount, $carouselIndex = 0;
    public $order_number = 0, $order_total = 0;

    public $search_identifier = "", $search_title = "", $search_created_from = "", $search_created_to = "", $search_status = "", $search_shipping = "";


    public function loadOrders($carouselIndex = 0)
    {
        if ($this->selectedStatus != "") {
            $query = OrderDetails::Has('order')->with('order', 'item', 'giver', 'giver.card')
                ->whereHas('order', function ($q) {
                    $q->where('donor_id', auth('account')->user()->donor->id);
                })->where('item_type', 'App\Models\Product')
                ->orderBy('created_at', 'desc')
                ->where('status', $this->selectedStatus);
        } else {
            $query = OrderDetails::Has('order')->with('order', 'item', 'giver', 'giver.card')
                ->whereHas('order', function ($q) {
                    $q->where('donor_id', auth('account')->user()->donor->id);
                })->where('item_type', 'App\Models\Product')
                ->orderBy('created_at', 'desc');
        }

        $this->ordersCount = $query->count();
        $this->orderCarousels[$carouselIndex] = $query->offset($carouselIndex * $this->pageCount)->limit($this->pageCount)->get()->toArray();
    }

    public function showMore()
    {
        $this->loadOrders(count($this->orderCarousels));
    }

    public function render()
    {
        $query = OrderDetails::Has('order')->with('order', 'item', 'giver', 'giver.card')
            ->whereHas('order', function ($q) {
                $q->where('donor_id', auth('account')->user()->donor->id);
            })->where('item_type', 'App\Models\Product')
            ->orderBy('created_at', 'desc');

        if ($this->search_identifier  != '') {
            $query = $query->whereHas('order', function ($q) {
                $q->where('identifier', 'like', '%' . $this->search_identifier . '%');
                $this->orderCarousels = [];
            });
        }
        if ($this->search_status  != '') {
            $query = $query->whereHas('order', function ($q) {
                $q->where('status', 'like', '%' . $this->search_status . '%');
                $this->orderCarousels = [];
            });
        }
       
        if ($this->search_title  != '') {
            $query = $query->where('item_name', 'like', '%' . $this->search_title . '%');
            $this->orderCarousels = [];
        }
        if ($this->search_created_from  != '') {
            $query = $query->whereDate('created_at', '>=', $this->search_created_from);
            $this->orderCarousels = [];
        }
        if ($this->search_created_to  != '') {
            $query = $query->whereDate('created_at', '<=', $this->search_created_to);
            $this->orderCarousels = [];
        }
        if ($this->search_shipping  != '') {
            $query = $query->where('shipping_status', $this->search_shipping);
            $this->orderCarousels = [];
        }
        $this->totalOrders =  (clone $query)->Sum('total');
        $this->ordersCount = $query->count();
        
        $this->orderCarousels[$this->carouselIndex] = $query->offset($this->carouselIndex * $this->pageCount)->limit($this->pageCount)->get()->toArray();

        return view('livewire.site.profile.gifts-order');
    }
}
