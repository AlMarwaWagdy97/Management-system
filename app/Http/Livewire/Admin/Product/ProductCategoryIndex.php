<?php

namespace App\Http\Livewire\Admin\Product;

use Livewire\Component;
use App\Models\Categories;
use Livewire\WithPagination;
use App\Models\ProductCategory;
use App\Models\CategoryProjects;
use App\Traits\FileHandler;
use Illuminate\Support\Facades\Log;

class ProductCategoryIndex extends Component
{
    use WithPagination, FileHandler;
    protected $paginationTheme = 'bootstrap';

    public $mySelected = [], $selectAll = false, $deleteId = '';

    public $search_title = "", $search_description = "", $search_status = "";

    public $items, $item, $message = "";

    public $lastQuery = '';
    public $lastBindings = [];

    protected $listeners = ['updateSellected', 'updateSession', 'updateDeleteId'];



    // delete selected item -------------------------------------------
    public function delete()
    {
        ProductCategory::findOrFail($this->deleteId)->delete();
        // session()->flash('success' , trans('message.admin.deleted_sucessfully') );

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
        $items = ProductCategory::findMany($this->mySelected);
        foreach ($items as $item) {
            $item->update(['status' => 1]);
        }
        session()->flash('success', trans('message.admin.status_changed_sucessfully'));
        $this->clearSelect();
        $this->emit('updatedSelectAll', $this->mySelected);
    }

    public function unpublishSelected()
    {
        $items = ProductCategory::findMany($this->mySelected);
        foreach ($items as $item) {
            $item->update(['status' => 0]);
        }
        session()->flash('success', trans('message.admin.status_changed_sucessfully'));
        $this->clearSelect();
        $this->emit('updatedSelectAll', $this->mySelected);
    }

    public function deleteSelected()
    {
        $items = ProductCategory::findMany($this->mySelected);
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

    public function mount()
    {
        $this->search();
    }

    public function search()
    {
        try {
            $query = ProductCategory::query()
                ->select('product_categories.*')
                ->leftJoin('product_category_translations as trans', function($join) {
                    $join->on('product_categories.id', '=', 'trans.category_id')
                         ->where('trans.locale', app()->getLocale());
                })
                ->orderBy('product_categories.created_at', 'DESC');

            // Search in translations using direct join for better performance
            if (!empty($this->search_title)) {
                $query->where(function($q) {
                    $q->where('trans.title', 'like', '%' . $this->search_title . '%')
                      ->orWhere('product_categories.id', 'like', '%' . $this->search_title . '%');
                });
            }

            if (!empty($this->search_description)) {
                $query->where(function($q) {
                    $q->where('trans.description', 'like', '%' . $this->search_description . '%');
                });
            }
            
            if (!empty($this->search_status) && $this->search_status !== '') {
                $query->where('product_categories.status', $this->search_status);
            }

            // Debug: log the SQL query only in debug mode
            if (config('app.debug')) {
                Log::info('Search Query: ' . $query->toSql());
                Log::info('Search Bindings: ' . json_encode($query->getBindings()));
            }

            $this->items = $query->paginate(pagination_count());
            
        } catch (\Exception $e) {
            Log::error('Search Error: ' . $e->getMessage());
            // Fallback to basic search if translation search fails
            $this->items = ProductCategory::query()
                ->orderBy('created_at', 'DESC')
                ->paginate(pagination_count());
        }
    }

    public function updatingSearchTitle()
    {
        $this->resetPage();
    }

    public function updatingSearchDescription()
    {
        $this->resetPage();
    }

    public function updatingSearchStatus()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->search();
        $links = $this->items;
        $this->items = collect($this->items->items());
        $items = $this->items;
        
        // select all empty when change page
        if (!array_intersect(@$this->items->pluck('id')->toArray(), @$this->mySelected) && @$this->mySelected != []) {
            $this->selectAll = false;
            $this->mySelected = [];
        }

        return view('livewire.admin.product.product-category-index', compact('items', 'links'));
    }
}
