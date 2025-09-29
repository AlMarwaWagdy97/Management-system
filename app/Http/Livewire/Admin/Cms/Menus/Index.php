<?php

namespace App\Http\Livewire\Admin\Cms\Menus;

use App\Models\Menue;
use App\Traits\FileHandler;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Cache;

class Index extends Component
{
    use WithPagination, FileHandler;
    protected $paginationTheme = 'bootstrap';

    public $mySelected = [], $selectAll = false, $deleteId = '';

    public $search_title = "", $search_description = "", $search_status = "", $search_position="";

    public $query, $items, $item, $message = ""; 

    protected $listeners = ['updateSellected', 'updateSession', 'updateDeleteId'];

    

    


    // delete selected item -------------------------------------------
    public function delete() {
        Cache::forget('menus');
        $menu =  Menue::findOrFail( $this->deleteId);
        if($menu->children != null &&  @$menu->children->first() != null){                  
              session()->flash('error' , trans('message.admin.cant_delete_parent') );
        }
        else{
            Menue::findOrFail( $this->deleteId)->delete();
            session()->flash('success' , trans('message.admin.deleted_sucessfully') );
        }
    }
 
    // Events All Selected ----------------------------------------------
    public function updatedSelectAll($value){
        Cache::forget('menus');
        if ($value) {
            $this->mySelected = $this->items->pluck('id')->toArray();
        } else {
            $this->mySelected = [];
        }
        $this->emit('updatedSelectAll', $this->mySelected);
    }

    public function publishSelected(){
        Cache::forget('menus');
        $items = Menue::findMany($this->mySelected);
        foreach ($items as $item){
            $item->update(['status' => 1]);
        }
        session()->flash('success' , trans('message.admin.status_changed_sucessfully') );
        $this->clearSelect();
        $this->emit('updatedSelectAll', $this->mySelected);

    }

    public function unpublishSelected(){
        Cache::forget('menus');
        $items = Menue::findMany($this->mySelected);
        foreach ($items as $item){
            $item->update(['status' => 0]);
        }
        session()->flash('success' , trans('message.admin.status_changed_sucessfully') );
        $this->clearSelect();
        $this->emit('updatedSelectAll', $this->mySelected);
    }

    public function deleteSelected(){
        Cache::forget('menus');
        $items = Menue::findMany($this->mySelected);
        if($items){
            foreach($items as $menu){
                if($menu->children != null &&  @$menu->children->first() != null){
                    session()->flash('error' , trans('message.admin.cant_delete_parent') );
                    // $this->clearSelect();
                    return ;
                }
            }
        }
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
    public function render(){
        $query = Menue::query()->with('trans');
        $search_ids = false;
        if($this->search_title  != ''){
            $query = $query->orWhereTranslationLike('title', '%' . $this->search_title . '%');
            $search_ids = true;
            $this->resetPage();
        }

        if($this->search_status  != ''){
            $query = $query->where('status' , $this->search_status);
            $search_ids = true;
            $this->resetPage();
        }

        if($this->search_position  != ''){
            $query = $query->where('position' , $this->search_position);
            $search_ids = true;
            $this->resetPage();
        }

        $ids = arrang_records( $query->get(), $search_ids? $query->get()->pluck('id'):[]);
        $query = $query->whereIn('id', $ids)->orderByRaw("field(id,".implode(',',$ids).")");
        $this->items = $query->paginate(pagination_count());
        
        $links = $this->items;
        $this->items = collect($this->items->items());  
        $items = $this->items;
        // select all empty when change page 
        if(!array_intersect(@$this->items->pluck('id')->toArray(), @$this->mySelected) && @$this->mySelected != []){
            $this->selectAll = false;
            $this->mySelected = [];
        }
      
        return view('livewire.admin.cms.menus.table', compact('links','items'));
    }

}
