<?php

namespace App\Http\Livewire\Admin\Product;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Vendor;
use App\Traits\FileHandler;
use Livewire\Component;
use Livewire\WithPagination;

class ProductTableIndex extends Component
{
    use WithPagination, FileHandler;
    protected $paginationTheme = 'bootstrap';

    public $mySelected = [], $selectAll = false, $deleteId = '';

    public $search_title = "", $search_description = "", $search_status = "", $search_price_from = "", $search_price_to = "", $search_quantity_from = "", $search_quantity_to = "",
            $search_created_from = "", $search_created_to = "",$search_vendor = "", $search_category = "";

    public $items, $item, $message = "";

    public $vendors, $cateories;

    protected $listeners = ['updateSellected', 'updateSession', 'updateDeleteId'];
    
    // delete selected item -------------------------------------------
    public function delete()
    {
        $items = Product::query()->with('trans')->findOrFail($this->deleteId);
        $items->tags()->detach();
        if (file_exists(getImage($items->cover_image)) ){
            unlink(getImage($items->cover_image)); 
        }
        $items->delete();
        // $item->tags()->detach();

        $items->delete();
        session()->flash('success' , trans('message.admin.deleted_sucessfully') );
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
        $items = Product::findMany($this->mySelected);
        foreach ($items as $item) {
            $item->update(['status' => "published"]);
        }
        session()->flash('success', trans('message.admin.status_changed_sucessfully'));
        $this->clearSelect();
        $this->emit('updatedSelectAll', $this->mySelected);
        $this->emit('refreshTable');
        }

    public function unpublishSelected()
    {
        $items = Product::findMany($this->mySelected);
        foreach ($items as $item) {
            $item->update(['status' => "unpublished"]);
        }
        session()->flash('success', trans('message.admin.status_changed_sucessfully'));
        $this->clearSelect();
        $this->emit('updatedSelectAll', $this->mySelected);
    }

    public function deleteSelected()
    {
        $items = Product::query()->with('trans')->findOrFail($this->mySelected);
        foreach ($items as $item) {
            $this->delete_file($item->cover_image); 
            $item->delete();
            // $item->tags()->detach();
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

    public function mount()
    {
        $this->vendors = Vendor::with('trans')->get('id');
        $this->cateories = ProductCategory::with('trans')->get('id');
    }
    
    public function render()
    {
        $query = Product::query()->with('trans')->product()->orderBy('created_at', 'DESC');

        if ($this->search_title  != '') {
            $query = $query->WhereTranslationLike('title', '%' . $this->search_title . '%');
            $this->resetPage();
        }
        if ($this->search_price_from  != '') {
            $query = $query->where('price', '>=',  $this->search_price_from);
            $this->resetPage();
        }
        if ($this->search_price_to  != '') {
            $query = $query->where('price', '<=',  $this->search_price_to);
            $this->resetPage();
        }
        if ($this->search_quantity_from  != '') {
            $query = $query->where('quantity', '>=',  $this->search_quantity_from);
            $this->resetPage();
        }
        if ($this->search_quantity_to  != '') {
            $query = $query->where('quantity', '<=',  $this->search_quantity_to);
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
        if ($this->search_vendor  != '') {
            $query = $query->where('vendor_id', $this->search_vendor);
            $this->resetPage();
        }
        if ($this->search_category  != '') {
            $query = $query->where('category_id', $this->search_category);
            $this->resetPage();
        }
        if ($this->search_status  != '') {
            $query = $query->where('status', $this->search_status);
            $this->resetPage();
        }

        $this->items = $query->paginate(pagination_count());

        $links = $this->items;
        $this->items = collect($this->items->items());
        $items = $this->items;
        // select all empty when change page 
        if (!array_intersect(@$this->items->pluck('id')->toArray(), @$this->mySelected) && @$this->mySelected != []) {
            $this->selectAll = false;
            $this->mySelected = [];
        }
        return view('livewire.admin.product.product-table-index', compact('items', 'links'));
    }
}
