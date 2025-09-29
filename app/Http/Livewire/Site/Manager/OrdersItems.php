<?php

namespace App\Http\Livewire\Site\Manager;

use App\Models\Order;
use Livewire\Component;

class OrdersItems extends Component
{
    public $show_details = false;
    public $order_id;
    public $order;
    public $showGift = [];


    public function mount() {}

    public function toggleModal()
    {
        $this->show_details = !$this->show_details;
        if ($this->show_details) {
            $this->order =  Order::with(['paymentMethod.trans_ar', 'statusOrder.trans_ar', 'donor', 'details.item', 'details.giver', 'details.giver.card', 'referrer','donor.account'])->where('id', $this->order_id)->first();
        }
    }

    public function showGiftCart($id){
        $this->showGift[$id] =  @$this->showGift[$id] == 1 ? 0 : 1;
    }

    public function keyUp()
    {
        $this->show_details = false;
    }

    public function render()
    {
        return view('livewire.site.manager.orders-items');
    }
}
