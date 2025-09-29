<?php

namespace App\Http\Livewire\Admin\gifts\Cards;

use Livewire\Component;
use App\Models\GiftCards;
use Livewire\WithPagination;
use App\Models\GiftCategories;
use App\Models\GiftOccasioins;
use App\Traits\FileHandler;

class Index extends Component
{
    use WithPagination, FileHandler;
    protected $paginationTheme = 'bootstrap';

    public $mySelected = [], $selectAll = false, $deleteId = '';

    public $search_category_id = "", $search_occasioin_id = "", $search_status = "";

    public $items, $item, $message=""; 
    public $categories, $occasioins; 

    protected $listeners = ['updateSellected', 'updateSession', 'updateDeleteId'];

    

    // delete selected item -------------------------------------------
    public function delete() {
        GiftCards::findOrFail( $this->deleteId)->delete();
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
        $items = GiftCards::findMany($this->mySelected);
        foreach ($items as $item){
            $item->update(['status' => 1]);
        }
        session()->flash('success' , trans('message.admin.status_changed_sucessfully') );
        $this->clearSelect();
        $this->emit('updatedSelectAll', $this->mySelected);

    }

    public function unpublishSelected(){
        $items = GiftCards::findMany($this->mySelected);
        foreach ($items as $item){
            $item->update(['status' => 0]);
        }
        session()->flash('success' , trans('message.admin.status_changed_sucessfully') );
        $this->clearSelect();
        $this->emit('updatedSelectAll', $this->mySelected);
    }

    public function deleteSelected(){
        $items = GiftCards::findMany($this->mySelected);
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

    public function mount(){
        $this->categories = GiftCategories::with('trans')->get();
        $this->occasioins = GiftOccasioins::with('trans')->get();
        
    }

    public function render(){
        $query = GiftCards::with(['category', 'category.trans',  'occasioins']);
       

        if($this->search_category_id  != ''){
            $query = $query->where('category_id', $this->search_category_id);
            $this->resetPage();
        }

        if($this->search_occasioin_id  != ''){
            $query = $query->whereHas('occasioins', function($q){
                $q->where('occasioin_id', $this->search_occasioin_id);
            });
            $this->resetPage();
        }
       
        if($this->search_status  != ''){
            $query = $query->where('status' , $this->search_status);
            $this->resetPage();
        }

        $this->items = $query->paginate(pagination_count());
        $links = $this->items;
        $this->items = collect($this->items->items());  
        $items = $this->items;
        // select all empty when change page 
        if(!array_intersect(@$this->items->pluck('id')->toArray(), @$this->mySelected) && @$this->mySelected != []){
            $this->selectAll = false;
            $this->mySelected = [];
        }

        return view('livewire.admin.gifts.cards.table', compact('items', 'links'));
    }
    
}
