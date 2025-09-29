<?php

namespace App\Http\Livewire\Admin\Charity\Orders;

use App\Models\Order;
use Livewire\Component;
use App\Models\OrderView;
use Livewire\WithPagination;

class Index2 extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $mySelected = [], $selectAll = false, $deleteId = '';

    public $search_name = "", $search_email = "", $search_phone = "";

    public $items, $message = "";

    protected $listeners = ['updateSellected', 'updateSession', 'updateDeleteId'];


    public function checkItem($selected)
    {
        if (in_array(@$selected, @$this->mySelected)) {
            $this->mySelected = array_diff($this->mySelected, [$selected]);
        } else {
            array_push($this->mySelected, $selected);
        }
        if (count($this->mySelected) == pagination_count()) $this->selectAll = true;
        else $this->selectAll = false;

    }

    // delete selected item -------------------------------------------
    public function delete()
    {
        Order::findOrFail($this->deleteId)->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
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
        $orders = Order::findMany($this->mySelected);
dd($orders, $this->mySelected);
        foreach ($orders as $order) {
            $order->status =  1;
            $order->save();

            // TO DO  send Data
            if($order->status == 0){
                $parameters = [
                    ["name" => "name", "value" => $order->full_name],
                    ["name" => "order", "value" => $order->identifier],
                    ["name" => "amount", "value" => $order->total],
                    ["name" => "placeholder", "value" => "test"]
                ];
                // $email = new WhatsappService($order->mobile, $parameters , "birrukum.org", "taam_takeed");
                // $email = $email->send();
            }
        }
        session()->flash('success', trans('message.admin.status_changed_sucessfully'));
        $this->clearSelect();
        $this->emit('updatedSelectAll', $this->mySelected);
    }

    public function unpublishSelected()
    {
        $items = Order::findMany($this->mySelected);
        foreach ($items as $item) {
            $item->update(['status' => 0]);
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

    public function clearSelect()
    {
        $this->selectAll = false;
        $this->mySelected = [];
        $this->emit('updatedSelectAll', $this->mySelected);
    }


    public function updateDeleteId($id)
    {
        $this->deleteId = $id;
    }
    public function updateSession($msg)
    {
        session()->flash('success', $msg);
    }

    public function mount()
    {

    }

    public function render()
    {
        $query = OrderView::query()->orderBy('created_at', 'DESC');

        $links = $this->items = $query->paginate(pagination_count());
        $items = $this->items = collect($this->items->items());

        // select all empty when change page
        if (!array_intersect(@$this->items->pluck('id')->toArray(), @$this->mySelected) && @$this->mySelected != []) {
            $this->selectAll = false;
            $this->mySelected = [];
        }
        return view('livewire.admin.charity.orders.index2', compact('items', 'links'));
    }
}
