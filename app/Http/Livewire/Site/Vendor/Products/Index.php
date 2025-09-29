<?php

namespace App\Http\Livewire\Site\Vendor\Products;

use App\Models\Product;
use App\Models\Vendor;
use App\Traits\FileHandler;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, FileHandler;

    protected $paginationTheme = 'bootstrap';

    public $deleteId = '';

    public $search_title = "", $search_description = "", $search_status = "", $search_price_from = "", $search_price_to = "", $search_quantity_from = "", $search_quantity_to = "",
        $search_created_from = "", $search_created_to = "";

    public $items, $item, $message = "";

    protected $listeners = ['updateSellected', 'updateSession', 'updateDeleteId'];


    // delete selected item -------------------------------------------
    public function delete()
    {
        $items = Product::query()->with('trans')->findOrFail($this->deleteId);
        $this->delete_file($items->cover_image);
        $items->tags()->detach();
        $items->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
    }

    public function updateSession($msg)
    {
        session()->flash('success', $msg);
    }

    public function updateDeleteId($id)
    {
        $this->deleteId = $id;
    }

    public function render()
    {
        $vendor = auth('account')->user()->vendor;
        $query = Product::with('trans')->where('vendor_id', $vendor->id)->orderBy('created_at', 'DESC');

        if ($this->search_title  != '') {
            $query = $query->WhereTranslationLike('title', '%' . $this->search_title . '%');
            $this->resetPage();
        }
        if ($this->search_price_from  != '') {
            $query = $query->where('vendor_price', '>=',  $this->search_price_from);
            $this->resetPage();
        }
        if ($this->search_price_to  != '') {
            $query = $query->where('vendor_price', '<=',  $this->search_price_to);
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
        if ($this->search_status  != '') {
            $query = $query->where('status', $this->search_status);
            $this->resetPage();
        }

        $this->items = $query->paginate(pagination_count());

        $links = $this->items;
        $this->items = collect($this->items->items());
        $items = $this->items;

        return view('livewire.site.vendor.products.index', compact('items', 'links'));
    }
}
