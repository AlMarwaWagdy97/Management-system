<?php

namespace App\Http\Livewire\Site\Profile;

use Livewire\Component;
use App\Models\OrderView;

class Orders extends Component
{
    public  $pageCount = 10;
    public $selectedStatus = "";

    public $countOrders, $totalOrders;

    public $orderCarousels = [];
    public $ordersCount, $carouselIndex = 0;


    public function updateSelectStatus($id){
        if($id != "All"){
            $this->selectedStatus = $id;
        }
        else{
            $this->selectedStatus= "";
        }
        if($this->selectedStatus != ""){
            $query = OrderView::where('donor_id', auth('account')->user()->donor->id)->orderBy('created_at', 'desc')->where('status', $this->selectedStatus);
        }
        else{
            $query = OrderView::where('donor_id', auth('account')->user()->donor->id)->orderBy('created_at', 'desc');
        }
        $this->orderCarousels = [];
        $this->ordersCount = $query->count();
        $this->orderCarousels[$this->carouselIndex] = $query->offset($this->carouselIndex * $this->pageCount)->limit($this->pageCount)->get()->toArray();
    }

    public function loadOrders($carouselIndex = 0)
    {
        if($this->selectedStatus != ""){
            $query = OrderView::where('donor_id', auth('account')->user()->donor->id)->orderBy('created_at', 'desc')->where('status', $this->selectedStatus);
        }
        else{
            $query = OrderView::where('donor_id', auth('account')->user()->donor->id)->orderBy('created_at', 'desc');
        }

        $this->ordersCount = $query->count();
       $this->orderCarousels[$carouselIndex] = $query->offset($carouselIndex * $this->pageCount)->limit($this->pageCount)->get()->toArray();

    }

    public function showMore(){
        $this->loadOrders(count($this->orderCarousels));

    }

    public function mount(){
        $query = OrderView::where('donor_id', auth('account')->user()->donor->id)->orderBy('created_at', 'desc');
        $this->totalOrders =  ( clone $query) ->Sum('total');
        $this->ordersCount = $query->count();
        $this->orderCarousels[$this->carouselIndex] = $query->offset($this->carouselIndex * $this->pageCount)->limit($this->pageCount)->get()->toArray();
    }

    public function render()
    {
        return view('livewire.site.profile.orders');
    }
}
