<?php

namespace App\Http\Livewire\Site\Manager;

use App\Models\OrderView;
use Livewire\Component;

class Orders extends Component
{
    public  $pageCount = 20;
    public $selectedStatus = "", $selectedRefer = "";

    public $countOrders, $totalOrders, $refers;
    
    
    public $orderCarousels = [];
    public $ordersCount, $carouselIndex = 0;

    public function search(){
        $query = OrderView::whereIn('refer_id',auth('account')->user()->manager?->refers?->pluck('id') ?? [])->orderBy('created_at', 'desc');

        if($this->selectedStatus != ""){
            $query =  $query->where('status', $this->selectedStatus);
        }
        if($this->selectedRefer != ""){
            $query =  $query->where('refer_id', $this->selectedRefer);
        }
        $this->orderCarousels = [];
        $this->ordersCount = $query->count();
        $this->orderCarousels[$this->carouselIndex] = $query->offset($this->carouselIndex * $this->pageCount)->limit($this->pageCount)->get()->toArray();

    }

    public function loadOrders($carouselIndex = 0)
    {
        $query = OrderView::whereIn('refer_id',auth('account')->user()->manager?->refers?->pluck('id') ?? [])->orderBy('created_at', 'desc');

        if($this->selectedStatus != ""){
            $query =  $query->where('status', $this->selectedStatus);
        }
        if($this->selectedRefer != ""){
            $query =  $query->where('refer_id', $this->selectedRefer);
        }

       $this->ordersCount = $query->count();
       $this->orderCarousels[$carouselIndex] = $query->offset($carouselIndex * $this->pageCount)->limit($this->pageCount)->get()->toArray();
    }

    public function showMore(){
        $this->loadOrders(count($this->orderCarousels));
    }

    public function mount(){
        $this->refers = auth('account')->user()->manager?->refers;
        $query = OrderView::whereIn('refer_id',$this->refers?->pluck('id') ?? [])->orderBy('created_at', 'desc');
        $this->totalOrders =  ( clone $query) ->Sum('total');
        $this->ordersCount = $query->count();
        $this->orderCarousels[$this->carouselIndex] = $query->offset($this->carouselIndex * $this->pageCount)->limit($this->pageCount)->get()->toArray();
    }

    
    public function render()
    {
        return view('livewire.site.manager.orders');
    }
}
