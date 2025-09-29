<?php

namespace App\Http\Livewire\Site\Refer;

use App\Models\Refer;
use Livewire\Component;
use App\Models\OrderView;
use Illuminate\Support\Facades\DB;

class Orders extends Component
{
    public  $pageCount = 10;
    public $selectedStatus = "";
    protected $referesIds = [];
    public $refersList = [];
    public $selectedRefer = "All";
    public $countOrders, $totalOrders;

    public $orderCarousels = [];
    public $ordersCount, $carouselIndex = 0;

    public function updateSelectStatus()
    {
        $this->orderCarousels = [];
        $this->carouselIndex = 0;
        $this->getData();
    }

    public function loadOrders($carouselIndex = 0)
    {
        $query = $this->buildQueryForCurrentFilters();
        $this->ordersCount = $query->count();
        $this->orderCarousels[$carouselIndex] = $query->offset($carouselIndex * $this->pageCount)
            ->limit($this->pageCount)
            ->get()
            ->toArray();
    }

    public function showMore()
    {
        $this->loadOrders(count($this->orderCarousels));
    }

    protected function getDescendantReferIds($startId)
    {
        $ids = [$startId];
        $queue = [$startId];

        while (!empty($queue)) {
            $children = DB::table('refer_refer')
                ->whereIn('parent_id', $queue)
                ->pluck('child_id')
                ->toArray();

            $children = array_diff($children, $ids);

            if (empty($children)) {
                break;
            }

            $ids = array_values(array_merge($ids, $children));
            $queue = $children;
        }
        return $ids;
    }

    public function mount()
    {
        $account = auth('account')->user();
        $currentRefer = $account->referer ?? null;

        if ($currentRefer) {
            // refers ids
            $this->referesIds = $this->getDescendantReferIds($currentRefer->id);
            // refers data by ids
            $this->refersList = Refer::whereIn('id', $this->referesIds)
                ->orderBy('name')
                ->get()
                ->toArray();
        } else {
            $this->referesIds = [];
            $this->refersList = [];
        }

        $this->getData();
    }

    public function getData()
    {
        $query = $this->buildQueryForCurrentFilters();

        $this->totalOrders = (clone $query)->sum('total');
        $this->ordersCount = $query->count();
        $this->orderCarousels = []; // Reset carousels
        $this->carouselIndex = 0; // Reset index
        $this->orderCarousels[$this->carouselIndex] = $query->offset($this->carouselIndex * $this->pageCount)
            ->limit($this->pageCount)
            ->get()
            ->toArray();
    }

    protected function buildQueryForCurrentFilters()
    {
        $query = OrderView::query()->orderBy('created_at', 'desc');
        
      
        if (empty($this->referesIds)) {
  
            $account = auth('account')->user();
            $currentRefer = $account->referer ?? null;
            if ($currentRefer) {
                $this->referesIds = $this->getDescendantReferIds($currentRefer->id);
            }
        }

        if ($this->selectedRefer !== "All" && $this->selectedRefer !== null && $this->selectedRefer !== "") {
            $query->where('refer_id', (int) $this->selectedRefer);
        } else {
          
            
            if (!empty($this->referesIds)) {
                $query->whereIn('refer_id', $this->referesIds);
            } else {
               
                $query->where('refer_id', -1);
            }
        }

        if ($this->selectedStatus !== "" && $this->selectedStatus !== null) {
            $query->where('status', $this->selectedStatus);
        }

        return $query;
    }

    public function updateSelectRefer()
    {
        $this->orderCarousels = [];
        $this->carouselIndex = 0;
        $this->getData();
    }

    public function render()
    {
        return view('livewire.site.refer.orders');
    }
}