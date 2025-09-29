<?php

namespace App\Http\Livewire\Admin\Cms\ContactUs;

use Livewire\Component;
use App\Models\ContactUs;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $mySelected = [], $selectAll = false, $deleteId = '';

    public $search_name = "", $search_email = "", $search_phone = "", $title = "";

    public $items, $item, $message = "";

    protected $listeners = ['updateSellected', 'updateSession', 'updateDeleteId'];




    // delete selected item -------------------------------------------
    public function delete()
    {
        ContactUs::findOrFail($this->deleteId)->delete();
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
        $items = ContactUs::findMany($this->mySelected);
        foreach ($items as $item) {
            $item->update(['status' => 1]);
        }
        session()->flash('success', trans('message.admin.status_changed_sucessfully'));
        $this->clearSelect();
        $this->emit('updatedSelectAll', $this->mySelected);
    }

    public function unpublishSelected()
    {
        $items = ContactUs::findMany($this->mySelected);
        foreach ($items as $item) {
            $item->update(['status' => 0]);
        }
        session()->flash('success', trans('message.admin.status_changed_sucessfully'));
        $this->clearSelect();
        $this->emit('updatedSelectAll', $this->mySelected);
    }

    public function deleteSelected()
    {
        $items = ContactUs::findMany($this->mySelected);
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

    public function render()
    {
        $query = ContactUs::query()->orderBy('created_at', 'DESC');
        if ($this->search_name  != '') {
            $query->where('full_name', 'like', '%' . $this->search_name . '%');
            $this->resetPage();
        }

        if ($this->search_email  != '') {
            $query->where('email', 'like', '%' . $this->search_email . '%');
            $this->resetPage();
        }
        if ($this->title  != '') {
            $query->where('title', 'like', '%' . $this->title . '%');
            $this->resetPage();
        }
        if ($this->search_phone  != '') {
            $query->where('phone', 'like', '%' . $this->search_phone . '%');
            $this->resetPage();
        }

        $this->items = $query->paginate(pagination_count());
        $links = $this->items;
        $this->items = collect($this->items->items());
        
        // select all empty when change page 
        if (!array_intersect(@$this->items->pluck('id')->toArray(), @$this->mySelected) && @$this->mySelected != []) {
            $this->selectAll = false;
            $this->mySelected = [];
        }
        return view('livewire.admin.cms.contact-us.table', compact( 'links'));
    }
}
