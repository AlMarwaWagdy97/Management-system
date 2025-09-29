<?php

namespace App\Http\Livewire\Site\Volunteering;

use App\Models\Volunteers;
use DateTime;
use IntlDateFormatter;
use Livewire\Component;

class Index extends Component
{
    public $pageCount = 12;
    public $selectedStatus = "", $months;

    public $volunteerCarousels = [];
    public $volunteerCount, $carouselIndex = 0;
    public $filterByTeam = "", $filterByVolunteer = "", $filterMonth = "";

    public $sortByWorkingHours = "", $sortByEffective = "";


    public function loadOrders($carouselIndex = 0)
    {
        $query = Volunteers::with('account')->active()->orderBy('created_at', 'desc');

        $this->volunteerCount = $query->count();
        $this->volunteerCarousels[$carouselIndex] = $query->offset($carouselIndex * $this->pageCount)->limit($this->pageCount)->get()->toArray();
    }

    public function showMore()
    {
        $this->loadOrders(count($this->volunteerCarousels));
    }


    public function mount()
    {
        $currentDate = new DateTime();
        $twelveMonthsAgo = clone $currentDate;
        $twelveMonthsAgo->modify('-11 months');
        
        $formatter = new IntlDateFormatter('ar_EG', IntlDateFormatter::FULL, IntlDateFormatter::NONE);
        $en_formatter = new IntlDateFormatter('en_EG', IntlDateFormatter::FULL, IntlDateFormatter::NONE);
        $formatter->setPattern('MMMM yyyy');
        $en_formatter->setPattern('MM-yyyy');
        
        $months = [];
        while ($twelveMonthsAgo <= $currentDate) {
            $arabicDate = $formatter->format($twelveMonthsAgo);
            $englishDate = $en_formatter->format($twelveMonthsAgo);
            $months[$englishDate] = $arabicDate;
            $twelveMonthsAgo->modify('+1 month');
        }
        
        $this->months = $months;
    }

    public function render()
    {
        $query = Volunteers::with('account')->active();
        if ($this->filterByTeam  != "" && $this->filterByVolunteer  != "") {
            $query = $query->whereIn('type', [$this->filterByTeam, $this->filterByVolunteer]);
        } else if ($this->filterByTeam) {
            $query = $query->where('type', $this->filterByTeam);
        } else if ($this->filterByVolunteer) {
            $query = $query->where('type', $this->filterByVolunteer);
        }


        if ($this->sortByWorkingHours  != "") {
            $query = $query->orderBy('working_hours');
        }
        if ($this->sortByEffective  != "") {
            $query = $query->orderBy('effective');
        }
        
        if ($this->filterMonth != "") {
            $startDate = new DateTime('01-' . $this->filterMonth );
            $endDate = clone $startDate;
            $endDate->modify('last day of this month');
            $query = $query->whereBetween('created_at', [$startDate, $endDate]);
        }



        $this->volunteerCount = $query->count();
        $this->volunteerCarousels[$this->carouselIndex] = $query->offset($this->carouselIndex * $this->pageCount)->limit($this->pageCount)->get()->toArray();
        return view('livewire.site.volunteering.index');
    }
}
