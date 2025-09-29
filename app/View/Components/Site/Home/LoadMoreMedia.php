<?php

namespace App\View\Components\Site\Home;

use App\Models\Articles;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LoadMoreMedia extends Component
{

    public $items;
    public $start = 0, $count = 8;

    /**
     * Create a new component instance.
     */
    public function __construct($start = 0, $count = 6)
    {
        $this->start = $start;
        $this->count = $count;

        $this->items = Articles::with('trans')->orderBy('sort', 'ASC')->active()->offset($start)->limit($count)->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.site.home.load-more-media');
    }
}
