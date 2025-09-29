<?php

namespace App\Http\Livewire\Admin\Charity\Orders;

use App\Events\OrderConfirmationEvent;
use App\Models\Order;
use Livewire\Component;
use App\Models\OrderView;
use App\Models\PaymentMethod;
use App\Models\Refer;
use App\Models\Status;
use Livewire\WithPagination;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrderExport;



class Index extends Component
{
    use WithPagination;




    protected $paginationTheme = 'bootstrap';
    public $msg_type;
    public $donor_id;

    public $message = false;
    public $mySelected = [], $selectAll = false, $deleteId = '';
    public $customer_mobile = '';
    public $order_status_type = '';
    //searchfilters
    public $search_name = "", $search_email = "", $search_mobile = "", $search_identifier = "",
        $search_source = "", $search_payment_id = "", $search_total_from = 0, $search_total_to = 0,
        $search_status_id = "", $search_status = "", $search_refer,
        $search_price_from, $search_price_to, $search_created_from, $search_created_to;

    public $paymentMethods, $refers;

    public $items, $item, $orderStatus, $selectOrderStatus = "";

    protected $listeners = ['updateSellected', 'updateSession'];


    // delete selected item -------------------------------------------
    public function delete($id)
    {
        Order::findOrFail($id)->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
    }

    public function filters()
    {
        $this->alert("clear search filtrats", 'info');
    }
    function alert($message, $type = '')
    {
        $this->message = $message;
        empty($type) ? $this->msg_type = "info" : $this->msg_type = $type;
    }
    /**
     * reset the variables that needs to be reset after request
     *
     * @return void
     */
    function dehydrate()
    {
        $this->message = false;
    }
    // Events All Selected ----------------------------------------------
    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->mySelected = $this->items->pluck('id')->toArray();
        } else {
            $this->mySelected = [];
        }
        $this->emit('updatedSelectAll', $this->mySelected);
    }

    public function publishSelected()
    {
        $orders = Order::with(['donor', 'details'])->findMany($this->mySelected);

        foreach ($orders as $order) {
            $order->status = 1;
            $order->save();
            event(new OrderConfirmationEvent($order));
        }
        session()->flash('success', trans('message.admin.status_changed_sucessfully'));
        $this->clearSelect();
        $this->emit('updatedSelectAll', $this->mySelected);
    }

    public function unpublishSelected()
    {
        $orders = Order::findMany($this->mySelected);
        foreach ($orders as $order) {
            $order->status = 0;
            $order->save();
        }
        session()->flash('success', trans('message.admin.status_changed_sucessfully'));
        $this->clearSelect();
        $this->emit('updatedSelectAll', $this->mySelected);
    }

    public function exportExcel()
    {
        $query = $this->filterTable();

        return Excel::download(new OrderExport($query->get()), 'orders.xlsx');
    }
    
    public function waitingSelected()
    {
        $orders = Order::findMany($this->mySelected);
        foreach ($orders as $order) {
            $order->status = 3;
            $order->save();
        }
        session()->flash('success', trans('message.admin.status_changed_sucessfully'));
        $this->clearSelect();
        $this->emit('updatedSelectAll', $this->mySelected);
    }
    public function cancelSelected()
    {
        $orders = Order::findMany($this->mySelected);
        foreach ($orders as $order) {
            $order->status = 4;
            $order->save();
        }
        session()->flash('success', trans('message.admin.status_changed_sucessfully'));
        $this->clearSelect();
        $this->emit('updatedSelectAll', $this->mySelected);
    }
    public function deleteSelected()
    {
        $items = Order::findMany($this->mySelected);
        foreach ($items as $item) {
            $item->delete();
        }
        session()->flash('success', trans('message.admin.delete_all_sucessfully'));
        $this->clearSelect();
        $this->emit('updatedSelectAll', $this->mySelected);
    }
    public function updatedSelectOrderStatus($val)
    {
        $items = Order::findMany($this->mySelected);
        foreach ($items as $item) {
            $item->status_id = $val;
            $item->save();
        }
        $this->clearSelect();
        $this->selectOrderStatus = "";
        session()->flash('success', trans('message.admin.status_changed_sucessfully'));
        $this->emit('updatedSelectAll', $this->mySelected);
    }

    public function clearSelect()
    {
        $this->selectAll = false;
        $this->mySelected = [];
        $this->emit('updatedSelectAll', $this->mySelected);
    }
    public function updateSellected($selected)
    {
        if (in_array(@$selected, @$this->mySelected)) {
            $this->mySelected = array_diff($this->mySelected, [$selected]);
        } else {
            array_push($this->mySelected, $selected);
        }
        if (count($this->mySelected) == pagination_count()) $this->selectAll = true;
        else $this->selectAll = false;
        $this->emit('AllupdatedSelect', $this->selectAll);
    }
    public function updateDeleteId($id)
    {
        $this->deleteId = $id;
    }
    public function updateSession($msg)
    {
        session()->flash('success', $msg);
    }

    public function clearSearch()
    {
        $this->search_name = $this->search_status_id = $this->search_status = $this->search_price_from = $this->search_price_to
            = $this->search_created_from = $this->search_created_to = $this->search_email = $this->search_mobile = $this->search_identifier
            = $this->search_source = $this->search_payment_id = "";
        $this->search_total_from = $this->search_total_to = 0;
    }

    public function mount(Request $request)
    {
        $this->customer_mobile = $request->input('customer_mobile', '');
        $this->search_refer = $request->input('search_refer', '');
        $this->order_status_type = $request->input('order_status_type', '');

        if ($this->customer_mobile) {
            $this->search_mobile = $this->customer_mobile;
        }

        $this->orderStatus = Status::with('trans')->active()->get();
        $this->paymentMethods = PaymentMethod::with('trans')->active()->get();
        $this->refers = Refer::get();
    }


    public function filterTable(){
        $query = OrderView::with(['paymentMethodTranslationEn'])->orderBy('created_at', 'DESC');


        if ($this->customer_mobile) {
            $query->where('donor_mobile', 'like', '%' . $this->customer_mobile . '%');
        }

        if ($this->order_status_type === 'completed') {
            $query->where('status', 1);
        } elseif ($this->order_status_type === 'incomplete') {
            $query->where('status', '!=', 1);
        }

        // Filter
        $filters = [
            'identifier' => $this->search_identifier,
            'full_name' => $this->search_name,
            'donor_email'       => $this->search_email,
            'donor_mobile' => $this->search_mobile,
            'source' => $this->search_source,
            'refer_id' => $this->search_refer,
            'payment_method_id' => $this->search_payment_id,
        ];
        foreach ($filters as $key => $value) {
            if (!empty($value)) $query->where($key, 'like', '%' . $value . '%');
        }

        if ($this->search_status_id  != '') {
            $query = $query->where('status_id', $this->search_status_id);
            $this->resetPage();
        }
        if ($this->search_status  != '') {
            $query = $query->where('status', $this->search_status);
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
        if ($this->search_price_from  != '') {
            $query = $query->where('total', '>=',  $this->search_price_from);
            $this->resetPage();
        }
        if ($this->search_price_to  != '') {
            $query = $query->where('total', '<=',  $this->search_price_to);
            $this->resetPage();
        }
        return $query;
    }

    public function render()
    {
        $query = $this->filterTable();

        $links = $this->items = $query->paginate(pagination_count());
        $items = $this->items = collect($this->items->items());

        // select all empty when change page
        if (!array_intersect(@$this->items->pluck('id')->toArray(), @$this->mySelected) && @$this->mySelected != []) {
            $this->selectAll = false;
            $this->mySelected = [];
        }
        return view('livewire.admin.charity.orders.index', compact('items', 'links'));
    }
}
