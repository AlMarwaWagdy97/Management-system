<?php

namespace App\View\Components\Admin\Layouts;

use App\Models\Order;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PendingOrderNumber extends Component
{
    public $pendingNumber = 0;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->pendingNumber = Order::Pending()->count();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.layouts.pending-order-number');
    }
}
