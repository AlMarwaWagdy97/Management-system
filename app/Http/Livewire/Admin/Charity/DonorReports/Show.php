<?php

namespace App\Http\Livewire\Admin\Charity\DonorReports;

use App\Models\Order;
use App\Models\OrderView;
use Livewire\Component;

class Show extends Component
{
    public $show_details = false;
    public $donor_id;
    public $order_id;
    public $order;
    public $showGift = [];

    public function mount($donor_id)
    {
        $this->donor_id = $donor_id;
        // Get the first order for this donor
        $firstOrder = Order::where('donor_id', $this->donor_id)->first();
        if ($firstOrder) {
            $this->order_id = $firstOrder->id;
        }
    }

    public function toggleModal()
    {
        $this->show_details = !$this->show_details;
        if ($this->show_details && $this->order_id) {
            $this->order = Order::with([
                'paymentMethod.trans_ar',
                'statusOrder.trans_ar',
                'donor',
                'donor.account',
                'details.item',
                'details.giver',
                'details.giver.card',
                'referrer',
                'cart.items'
            ])->where('id', $this->order_id)->first();
        }
    }

    public function showGiftCart($id)
    {
        $this->showGift[$id] = @$this->showGift[$id] == 1 ? 0 : 1;
    }

    public function keyUp()
    {
        $this->show_details = false;
    }

    public function render()
    {
        return view('livewire.admin.charity.donor-reports.show');
    }
}
