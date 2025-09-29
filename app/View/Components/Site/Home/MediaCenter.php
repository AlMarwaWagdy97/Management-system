<?php

namespace App\View\Components\Site\Home;

use App\Models\Articles;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MediaCenter extends Component
{
    public $mediaItems;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->mediaItems = Articles::active()->feature()->orderBy('sort', 'ASC')
       ->with(['trans' => function($query){
            $query->where('locale', app()->getLocale());
        }])->take(4)->get();

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.site.home.media-center');
    }
}
