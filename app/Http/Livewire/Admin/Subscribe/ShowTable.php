<?php

namespace App\Http\Livewire\Admin\Subscribe;

use Livewire\Component;

class ShowTable extends Component
{
    public $index, $item, $key;
    public $mySelected, $selectAll, $deleteId = '', $selected;
    public  $search_email = "";
    protected $listeners = ['updatedSelectAll'];
    public function mount($item){
        $this->item = $item;
    }
    
    public function render()
    {
        return view('livewire.admin.subscribe.show-table');
    }


    public function deleteIdRow($id){
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




