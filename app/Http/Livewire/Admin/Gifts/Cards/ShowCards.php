<?php

namespace App\Http\Livewire\Admin\gifts\Cards;

use Livewire\Component;

class ShowCards extends Component
{
    public $index, $item, $key;
    public $mySelected, $selectAll, $deleteId = '', $selected;

    public $search_title = "", $search_description = "", $search_status = "";

    protected $listeners = ['updatedSelectAll'];

    
 


    // Events ----------------------------------------------
    public function update_status($id){
        $this->item->status == 1 ? $this->item->status = 0 : $this->item->status = 1;
        $this->item->save();
        $this->emit('updateSession',  trans('message.admin.status_changed_sucessfully'));
    }

    public function update_featured($id){
        $this->item->feature == 1 ? $this->item->feature = 0 : $this->item->feature = 1;
        $this->item->save();
        $this->emit('updateSession',  trans('message.admin.featured_changed_sucessfully'));
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

    public function mount($item){
        $this->item = $item;
    }

    public function render()   {
        return view('livewire.admin.gifts.cards.show-cards');
    }
}
