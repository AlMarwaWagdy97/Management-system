<?php

namespace App\Http\Livewire\Site\Vendor\Orders;

use App\Mail\ProductDeliveredMail;
use App\Models\OrderDetails;
use Livewire\Component;
use App\Models\OrderView;
use Illuminate\Support\Facades\Mail;

class Index extends Component
{
    public  $pageCount = 10;
    public $selectedStatus = "";
    
    public $notes = [], $showNote = []; 

    public $countOrders, $totalOrders;

    public $orderCarousels = [];
    public $ordersCount, $carouselIndex = 0;
    public $order_number = 0, $order_total = 0;

    public $search_identifier = "", $search_title = "", $search_created_from = "", $search_created_to = "", $search_status = "", $search_shipping = "";

    public function updateSelectStatus(){
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
            $query = OrderDetails::Has('order')->with('order', 'item', 'giver','giver.card')->where('vendor_id', auth('account')->user()->vendor->id)->orderBy('created_at', 'desc')->where('status', $this->selectedStatus);
        }
        else{
            $query = OrderDetails::Has('order')->with('order', 'item', 'giver','giver.card')->where('vendor_id', auth('account')->user()->vendor->id)->orderBy('created_at', 'desc');
        }

        $this->ordersCount = $query->count();
       $this->orderCarousels[$carouselIndex] = $query->offset($carouselIndex * $this->pageCount)->limit($this->pageCount)->get()->toArray();
    }

    public function showMore(){
        $this->loadOrders(count($this->orderCarousels));
    }

    public function changeShippingStatus($id, $val){
        $orderDetails = OrderDetails::find($id);
        $orderDetails->shipping_status = $val;
        $orderDetails->save();
        if($val == 'delivered'){
            $this->sendMail($orderDetails);
        }
        session()->flash('success', trans('message.admin.status_changed_sucessfully'));
    }

    public function sendMail($orderDetails){
        $email = $orderDetails->order?->donor?->account?->email;
        $mail =  Mail::to($email)->send(new ProductDeliveredMail($orderDetails));
    }

    public function updateComment($id){
        $orderDetails = OrderDetails::find($id);
        $orderDetails->note = $this->notes[$id];
        $orderDetails->save();
        $this->showNote[$id] = false;
        session()->flash('success', trans('message.admin.status_changed_sucessfully'));
    }
    
    public function updateShowNote($id){
        $this->showNote[$id] = true;
        $orderDetails = OrderDetails::find($id);
        $this->notes[$id] = $orderDetails->note;
    }

    public function updateHideNote($id){
        $this->showNote[$id] = false;
    }

    public function mount()
    {
        $query = OrderDetails::Has('order')->with('order', 'item', 'giver','giver.card')->where('vendor_id', auth('account')->user()->vendor->id)->orderBy('created_at', 'desc');
        $this->totalOrders =  ( clone $query)->Sum('total');
        $this->ordersCount = $query->count();
        $this->orderCarousels[$this->carouselIndex] = $query->offset($this->carouselIndex * $this->pageCount)->limit($this->pageCount)->get()->toArray();        
    }


    public function render()
    {
        $query = OrderDetails::Has('order')->with('order', 'item', 'giver','giver.card')->where('vendor_id', auth('account')->user()->vendor->id)->orderBy('created_at', 'desc');

        if ($this->search_identifier  != '') {
            $query = $query->whereHas('order', function($q){
                $q->where('identifier', 'like', '%'. $this->search_identifier.'%');
            });
        }
        if ($this->search_status  != '') {
            $query = $query->whereHas('order', function($q){
                $q->where('status', 'like', '%'. $this->search_status.'%');
            });
        }
        if ($this->search_title  != '') {
            $query = $query->where('item_name', 'like', '%'. $this->search_title.'%');
        }
        if ($this->search_created_from  != '') {
            $query = $query->whereDate('created_at', '>=', $this->search_created_from);
        }
        if ($this->search_created_to  != '') {
            $query = $query->whereDate('created_at', '<=', $this->search_created_to);
        }
        if ($this->search_shipping  != '') {
            $query = $query->where('shipping_status', $this->search_shipping);
        }

        $this->totalOrders =  ( clone $query) ->Sum('total');
        $this->ordersCount = $query->count();

        $this->orderCarousels[$this->carouselIndex] = $query->offset($this->carouselIndex * $this->pageCount)->limit($this->pageCount)->get()->toArray();        

        return view('livewire.site.vendor.orders.index');
    }
}
