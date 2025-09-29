<?php

namespace App\Http\Livewire\Admin\Charity\CharityReports;

use App\Models\OrderDetails;
use Livewire\Component;

class Table extends Component
{
    public $item;
    public $index;
    public $selected = [];
    public $selectAll = false;
    public $mySelected = [];
    public $current_lang;
    public $order_count;
    public $total_amount;
    public $last_order_time;


    public function mount()
    {
        $this->current_lang = app()->getLocale();

        // $this->order_count = OrderDetails::where('item_id', $this->item->id)
        //     ->where('item_type', 'App\Models\CharityProject')
        //     ->count();

        // $this->total_amount = OrderDetails::where('item_id', $this->item->id)
        //     ->where('item_type', 'App\Models\CharityProject')
        //     ->sum('total');
    }

    public function updateSellected($id)
    {
        if (in_array($id, $this->mySelected)) {
            $this->mySelected = array_diff($this->mySelected, [$id]);
        } else {
            $this->mySelected[] = $id;
        }
        $this->emit('selectedItem', $this->mySelected);
    }

    public function render()
    {
        return view('livewire.admin.charity.charity-reports.table');
    }
}
