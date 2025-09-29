<?php

namespace App\Http\Livewire\Admin\Badal\Substitutes;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Substitutes;
use App\Traits\FileHandler;

class Index extends Component
{
    use WithPagination, FileHandler;
    protected $paginationTheme = 'bootstrap';

    public $items, $item, $message = "", $categories;

    public $mySelected = [], $selectAll = false, $deleteId = '';

    public $search_full_name        = "",
           $search_email            = "",
           $search_mobile           = "",
           $search_identity         = "",
           $search_gender           = "",
           $search_status           = "",
           $search_proportion_from  = "",
           $search_proportion_to      = "";
            

    protected $listeners = ['updateSellected', 'updateSession', 'updateDeleteId'];

    public function mount(){
    }
    
    public function render()
    {
        $query = Substitutes::with('account')->orderBy('created_at', 'DESC');
        
        if ($this->search_full_name  != '') {
            $query->where('full_name', 'like', '%' . $this->search_full_name . '%');
            $this->resetPage();
        }
        if ( ( $email = $this->search_email )  != '') {
            $query->whereHas('account', function($q) use ($email){
                $q->where('email', 'like', '%' . $email . '%');
            });
            $this->resetPage();
        }
        if ( ( $mobile = $this->search_mobile )  != '') {
            $query->whereHas('account', function($q) use ($mobile){
                $q->where('mobile', 'like', '%' . $mobile . '%');
            });
            $this->resetPage();
        }
        if ($this->search_identity  != '') {
            $query = $query->where('identity', $this->search_identity);
            $this->resetPage();
        }
        if ($this->search_gender  != '') {
            $query = $query->where('gender', $this->search_gender);
            $this->resetPage();
        }
        if ($this->search_proportion_from  != '') {
            $query = $query->where('proportion', '>=', $this->search_proportion_from);
            $this->resetPage();
        }

        if ($this->search_proportion_to  != '') {
            $query = $query->where('proportion', '<=', $this->search_proportion_to);
            $this->resetPage();
        }
        if ($this->search_status  != '') {
            $query = $query->where('status', $this->search_status);
            $this->resetPage();
        }

        $this->items = $query->paginate(pagination_count());
        $links = $this->items;
        $this->items = collect($this->items->items());  
        // select all empty when change page 
        if(!array_intersect(@$this->items->pluck('id')->toArray(), @$this->mySelected) && @$this->mySelected != []){
            $this->selectAll = false;
            $this->mySelected = [];
        }
        $categories = $this->categories;

        return view('livewire.admin.badal.substitutes.index', compact('links'));
    }

    // delete selected item -------------------------------------------
    public function delete()
    {
        $items = Substitutes::findOrFail($this->deleteId);
        $this->delete_file($items->cover_image);
        $this->delete_file($items->background_image);
        $items->tags()->detach();
        $items->payment()->detach();
        $items->forceDelete();
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
        $items = Substitutes::findMany($this->mySelected);
        foreach ($items as $item) {
            $item->update(['status' => 1]);
        }
        session()->flash('success', trans('message.admin.status_changed_sucessfully'));
        $this->clearSelect();
        $this->emit('updatedSelectAll', $this->mySelected);
    }

    public function unpublishSelected()
    {
        $items = Substitutes::findMany($this->mySelected);
        foreach ($items as $item) {
            $item->update(['status' => 0]);
        }
        session()->flash('success', trans('message.admin.status_changed_sucessfully'));
        $this->clearSelect();
        $this->emit('updatedSelectAll', $this->mySelected);
    }

    public function deleteSelected()
    {
        $items = Substitutes::findOrFail($this->mySelected);
        foreach ($items as $item) {
            $this->delete_file($item->image);
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

    //  nested function component ----------------------------------------------------------
    public function updateSellected($selected)
    {
        if (in_array(@$selected, @$this->mySelected)) {
            $this->mySelected = array_diff($this->mySelected, [$selected]);
        } else {
            array_push($this->mySelected, $selected);
        }
        if (count($this->mySelected) == pagination_count()) $this->selectAll = true;
        else $this->selectAll = false;
        // $this->emit('AllupdatedSelect', $this->selectAll);

    }

    public function updateSession($msg)
    {
        session()->flash('success', $msg);
    }

    public function updateDeleteId($id)
    {
        $this->deleteId = $id;
    }
}