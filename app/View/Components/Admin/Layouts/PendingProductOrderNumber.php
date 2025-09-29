<?php

namespace App\View\Components\Admin\Layouts;

use App\Models\OrderDetails;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PendingProductOrderNumber extends Component
{
    public $pendingNumber = 0;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->pendingNumber = OrderDetails::Has('order')->where('item_type', 'App\Models\Product')->shippingPending()->count();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.layouts.pending-product-order-number');
    }
}
