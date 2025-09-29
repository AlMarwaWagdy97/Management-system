<?php

namespace App\Http\Livewire\Admin\Reports;

use App\Models\OrderDetails;
use App\Models\OrderView;
use App\Models\Vendor;
use Livewire\Component;
use Livewire\WithPagination;

class ProdcutsOrderReport extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $vendors;

    public $items, $item;
    public $order_number = 0, $order_total = 0;

    public $search_identifier = "", $search_title = "", $search_created_from = "", $search_created_to = "", $search_vendor = "", $search_status = "", $search_shipping = "";


    public function showMore(){
        $this->loadOrders(count($this->orderCarousels));
    }

    public function changeShippingStatus($id, $val){
        $orderDetails = OrderDetails::find($id);
        $orderDetails->shipping_status = $val;
        $orderDetails->save();
        session()->flash('success', trans('message.admin.status_changed_sucessfully'));
    }
    
    public function clearSearch(){
        $this->search_identifier = ""; 
        $this->search_vendor = "";
        $this->search_title = ""; 
        $this->search_created_from = ""; 
        $this->search_created_to = "";
        $this->search_shipping = ""; 
    }

    public function mount(){
        $this->vendors = Vendor::orderBy('created_at', 'desc')->get();
    }

    public function render()
    {
        $query = OrderDetails::Has('order')->with('order', 'item', 'giver','giver.card', 'vendor')->where('item_type', 'App\Models\Product')->orderBy('created_at', 'DESC');

        if ($this->search_identifier  != '') {
            $query = $query->whereHas('order', function($q){
                $q->where('identifier', 'like', '%'. $this->search_identifier.'%');
            });
        }
        if ($this->search_status  != '') {
            $query = $query->whereHas('order', function($q){
                $q->where('status', 'like', '%'. $this->search_status.'%');
                $this->resetPage();
            });
        }
        if ($this->search_vendor  != '') {
            $query = $query->where('vendor_id', 'like', '%'. $this->search_vendor .'%');
            $this->resetPage();
        }
        if ($this->search_title  != '') {
            $query = $query->where('item_name', 'like', '%'. $this->search_title.'%');
            $this->resetPage();
        }
        if ($this->search_created_from  != '') {
            $query = $query->whereDate('created_at', '>=', $this->search_created_from);
            $this->resetPage();
        }
        if ($this->search_created_to  != '') {
            $query = $query->whereDate('created_at', '<=', $this->search_created_to);
            $this->resetPage();
        }
        if ($this->search_shipping  != '') {
            $query = $query->where('shipping_status', $this->search_shipping);
            $this->resetPage();
        }
        $this->order_number = $query->count();
        $this->order_total = $query->sum('total');

        $links = $this->items = $query->paginate(pagination_count());
        $items = $this->items = collect($this->items->items());

        return view('livewire.admin.reports.prodcuts-order-report', compact('items', 'links'));
    }
}
