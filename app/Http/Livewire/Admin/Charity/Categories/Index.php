<?php

namespace App\Http\Livewire\Admin\Charity\Categories;

use Livewire\Component;
use App\Models\Categories;
use Livewire\WithPagination;
use App\Models\CategoryProjects;
use App\Traits\FileHandler;

class Index extends Component
{
    use WithPagination, FileHandler;
    protected $paginationTheme = 'bootstrap';

    public $mySelected = [], $selectAll = false, $deleteId = '';

    public $search_title = "", $search_description = "", $search_status = "";

    public $items, $item, $message=""; 

    protected $listeners = ['updateSellected', 'updateSession', 'updateDeleteId'];

    public function mount(){
    }

    public function render(){
        $query = CategoryProjects::with(['trans']);

        $search_ids = false;
        if($this->search_title  != ''){
            $query = $query->whereHas('trans', function($q) {
                $q->where('title', 'like', '%' . $this->search_title . '%');
            });
            $search_ids = true;
            $this->resetPage();
        }
        if($this->search_description  != ''){
            $query = $query->whereHas('trans', function($q) {
                $q->where('description', 'like', '%' . $this->search_description . '%');
            });
            $search_ids = true;
            $this->resetPage();
        }
        if($this->search_status  != ''){
            $query = $query->where('status' , $this->search_status);
            $search_ids = true;
            $this->resetPage();
        }

        $ids = arrang_records( $query->get(), $search_ids? $query->get()->pluck('id'):[]);
        $query = $query->whereIn('id', $ids)->orderByRaw("field(id,".implode(',', $ids).")");
        $this->items = $query->paginate(pagination_count());
        $links = $this->items;
        $this->items = collect($this->items->items());  
        $items = $this->items;
        // select all empty when change page 
        if(!array_intersect(@$this->items->pluck('id')->toArray(), @$this->mySelected) && @$this->mySelected != []){
            $this->selectAll = false;
            $this->mySelected = [];
        }

        return view('livewire.admin.charity.categories.index', compact('items', 'links'));
    }

    // delete selected item -------------------------------------------
    public function delete() {
        CategoryProjects::findOrFail( $this->deleteId)->delete();
        // session()->flash('success' , trans('message.admin.deleted_sucessfully') );
        
    }
 
    // Events All Selected ----------------------------------------------
    public function updatedSelectAll($value){
        if ($value) {
            $this->mySelected = $this->items->pluck('id')->toArray();
        } else {
            $this->mySelected = [];
        }
        $this->emit('updatedSelectAll', $this->mySelected);
    }

    public function publishSelected(){
        $items = CategoryProjects::findMany($this->mySelected);
        foreach ($items as $item){
            $item->update(['status' => 1]);
        }
        session()->flash('success' , trans('message.admin.status_changed_sucessfully') );
        $this->clearSelect();
        $this->emit('updatedSelectAll', $this->mySelected);

    }

    public function unpublishSelected(){
        $items = CategoryProjects::findMany($this->mySelected);
        foreach ($items as $item){
            $item->update(['status' => 0]);
        }
        session()->flash('success' , trans('message.admin.status_changed_sucessfully') );
        $this->clearSelect();
        $this->emit('updatedSelectAll', $this->mySelected);
    }

    public function deleteSelected(){
        $items = CategoryProjects::findMany($this->mySelected);
        foreach ($items as $item){
            $this->delete_file($item->image);
            $item->delete();
        }
        session()->flash('success' , trans('message.admin.delete_all_sucessfully') );
        $this->clearSelect();
        $this->emit('updatedSelectAll', $this->mySelected);
    }

    public function clearSelect(){
        $this->selectAll = false;
        $this->mySelected = [];
        $this->emit('updatedSelectAll', $this->mySelected);

    }



    //  nested function component ----------------------------------------------------------
    public function updateSellected($selected){
        if(in_array(@$selected, @$this->mySelected)){
            $this->mySelected = array_diff($this->mySelected, [$selected]);
        }
        else{
            array_push($this->mySelected, $selected);
        }
        if(count($this->mySelected) == pagination_count())$this->selectAll = true;
        else $this->selectAll = false;
        // $this->emit('AllupdatedSelect', $this->selectAll);

    }
    public function updateSession($msg){
        session()->flash('success' , $msg) ;
    }
    public function updateDeleteId($id){
        $this->deleteId = $id;
    }

    
    
}
