<?php

namespace App\Http\Livewire\Admin\Charity\Orders;

use App\Models\Order;
use Livewire\Component;
use App\Charity\Notfications\WhatsappService;

class Table extends Component
{
    public $index, $item, $key;
    public $mySelected, $selectAll, $deleteId = '', $selected;

    public $search_title = "", $search_description = "", $search_status = "";

    protected $listeners = ['updatedSelectAll'];


    public function mount($item){
        $this->item = $item;
    }

    public function render()
    {
        return view('livewire.admin.charity.orders.table');
    }
    // Events ----------------------------------------------
    public function update_status($id, $val){
        $order = Order::find($id);
        $order->status =  $val;
        $order->save();

         // TO DO
         if($order->status == 0){
            $parameters = [
                ["name" => "name", "value" => $this->item->full_name],
                ["name" => "order", "value" => $this->item->identifier],
                ["name" => "amount", "value" => $this->item->total],
                ["name" => "placeholder", "value" => "test"]
            ];
        }
        $this->emit('updateSession',  trans('message.admin.status_changed_sucessfully'));
    }


    public function deleteId($id){
        $this->emit('updateDeleteId', $id);
    }

    // Nested function ----------------------------------------------
    public function updateSellected($selected){
        $this->emit('updateSellected', $selected);
    }

    public function updatedSelectAll($selectes){
        $this->mySelected = $selectes;
    }

}
