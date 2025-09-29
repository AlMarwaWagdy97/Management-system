<?php

namespace App\Http\Livewire\Admin\Deceases\Projects;

use Livewire\Component;
use App\Models\CharityProject;

class Table extends Component
{

    public $index, $item, $key, $sort;
    public $mySelected, $selectAll, $deleteId = '', $selected;

    public $search_title = "", $search_description = "", $search_status = "";

    protected $listeners = ['updatedSelectAll'];


    // Events ----------------------------------------------
    public function update_status($id)
    {
        $this->item->status == 1 ? $this->item->status = 0 : $this->item->status = 1;
        $this->item->save();
        $this->emit('updateSession',  trans('message.admin.status_changed_sucessfully'));
    }

    public function update_featured($id)
    {
        $this->item->featuer == 1 ? $this->item->featuer = 0 : $this->item->featuer = 1;
        $this->item->save();
        $this->emit('updateSession',  trans('message.admin.featured_changed_sucessfully'));
    }

    public function deleteId($id)
    {
        $this->emit('updateDeleteId', $id);
    }

    // Nested function ----------------------------------------------
    public function updateSellected($selected)
    {
        $this->emit('updateSellected', $selected);
    }

    public function updatedSelectAll($selectes)
    {
        $this->mySelected = $selectes;
    }

    public function update_sort($id)
    {
        $this->item->sort  =  $this->sort;
        $this->item->save();
        $this->emit('updateSession',  trans('message.admin.sort_changed_sucessfully'));
    }

    
    public function mount($item)
    {
        $this->item = $item;
        $this->sort = $item->sort;
    }

    public function render()
    {
        return view('livewire.admin.deceases.projects.table');
    }
}
