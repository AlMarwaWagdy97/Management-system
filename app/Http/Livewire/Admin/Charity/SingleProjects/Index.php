<?php

namespace App\Http\Livewire\Admin\Charity\SingleProjects;

use Livewire\Component;
use App\Models\CharityProject;
use App\Models\CategoryProjects;
use App\Traits\FileHandler;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, FileHandler;
    protected $paginationTheme = 'bootstrap';

    public $mySelected = [], $selectAll = false, $deleteId = '';

    public $search_title = "",
        $search_price_from = "",
        $search_price_to = "",
        $search_status = "",
        $search_number = "",
        $search_created_from = "",
        $search_created_to = "",
        $search_hidden = "",
        $search_isdeceasesd = "",
        $category_search = "",
        $search_location_type = "";


    public $items, $item, $message = "", $categories;

    protected $listeners = ['updateSellected', 'updateSession', 'updateDeleteId'];

    public function mount(){ 
        $this->categories = CategoryProjects::with('trans')->single()->orderBy('created_at', 'DESC')->get();
    }
    
    public function render()
    {

        $query = CharityProject::with(['trans', 'category' ,'category.trans'])->single()->orderBy('created_at', 'DESC');
        
        // dd($this->category_search);
        if ($this->search_title  != '') {
            $query = $query->WhereTranslationLike('title', '%' . $this->search_title . '%');
            $this->resetPage();
        }
        if ($this->search_price_from  != '') {
            $query = $query->where('target_price', '>=',  $this->search_price_from);
            $this->resetPage();
        }
        if ($this->search_price_to  != '') {
            $query = $query->where('target_price', '<=',  $this->search_price_to);
            $this->resetPage();
        }
        if ($this->search_number  != '') {
            $query = $query->where('number', 'like', '%' . $this->search_number . '%');
            $this->resetPage();
        }
        if ($this->search_created_from  != '') {
            $query = $query->whereDate('created_at', '>=', $this->search_created_from);
            $this->resetPage();
        }
        if ($this->search_created_to  != '') {
            $query = $query->whereDate('created_at', '<=', $this->search_created_to);
            $this->resetPage();
        }
        if ($this->search_status  != '') {
            $query = $query->where('status', $this->search_status);
            $this->resetPage();
        }
      
        if ($this->search_hidden  != '') {
            $query = $query->whereHas('singleField', function($q){
                $q->where('hidden', $this->search_hidden );
            });
            $this->resetPage();
        }
        if ($this->category_search  != "" ){
            $query = $query->where('category_id', $this->category_search);
            $this->resetPage();
        }
        if ($this->search_location_type  != "" ){
            $query = $query->where('location_type', $this->search_location_type);
            $this->resetPage();
        }


        $this->items = $query->paginate(pagination_count());        $links = $this->items;
        $this->items = collect($this->items->items());
        $items = $this->items;
        // select all empty when change page 
        if (!array_intersect(@$this->items->pluck('id')->toArray(), @$this->mySelected) && @$this->mySelected != []) {
            $this->selectAll = false;
            $this->mySelected = [];
        }
        $categories = $this->categories;
        return view('livewire.admin.charity.single-projects.index', compact('items', 'links', 'categories'));
    }

    // delete selected item -------------------------------------------
    public function delete()
    {
        $items = CharityProject::with(['trans', 'category' ,'category.trans'])->findOrFail($this->deleteId);
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
        $items = CharityProject::findMany($this->mySelected);
        foreach ($items as $item) {
            $item->update(['status' => 1]);
        }
        session()->flash('success', trans('message.admin.status_changed_sucessfully'));
        $this->clearSelect();
        $this->emit('updatedSelectAll', $this->mySelected);
    }

    public function unpublishSelected()
    {
        $items = CharityProject::findMany($this->mySelected);
        foreach ($items as $item) {
            $item->update(['status' => 0]);
        }
        session()->flash('success', trans('message.admin.status_changed_sucessfully'));
        $this->clearSelect();
        $this->emit('updatedSelectAll', $this->mySelected);
    }

    public function deleteSelected()
    {
        $items = CharityProject::with(['trans', 'category' ,'category.trans'])->findOrFail($this->mySelected);
        foreach ($items as $item) {
            $this->delete_file($item->cover_image);
            $this->delete_file($item->background_image);            
            $item->forceDelete();
            $item->tags()->detach();
            $item->payment()->detach();
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
