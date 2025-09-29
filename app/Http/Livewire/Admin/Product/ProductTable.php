<?php

namespace App\Http\Livewire\Admin\Product;

use Livewire\Component;

class ProductTable extends Component
{

    public $index, $item, $key, $sort, $status, $stock;
    public $mySelected, $selectAll, $deleteId = '', $selected;

    public $search_title = "", $search_description = "", $search_status = "";

    protected $listeners = ['updatedSelectAll', 'refreshTable' => '$refresh'];


   
    // Events ----------------------------------------------
    public function update_status($id)
    {
        $this->item->status == 'published' ? $this->item->status = 'unpublished' : $this->item->status = 'published';
        $this->item->save();
        $this->emit('updateSession',  trans('message.admin.status_changed_sucessfully'));

    }

    public function update_featured($id)
    {
        $this->item->feature == 1 ? $this->item->feature = 0 : $this->item->feature = 1;
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

    public function updatedstatus($val){
        $this->item->status  =  $val;
        $this->item->save();
        $this->status = $this->item->status;
        $this->emit('updateSession',  trans('message.admin.status_changed_sucessfully'));

    }

    public function mount($item)
    {
        $this->item = $item;
        $this->sort = $item->sort;
        $this->stock = $item->quantity? '<span class="label-success status-label">' . trans('products.in_stock') . ' </span>' : '<span class="label-danger status-label">' . trans('products.out_stock') . ' </span>';
    }

    public function render()
    {
        $this->status = $this->item->status;
        return view('livewire.admin.product.product-table');
    }
}
