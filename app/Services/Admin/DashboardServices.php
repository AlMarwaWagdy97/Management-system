<?php

namespace App\Services\Admin;

use App\Models\Projects;
use App\Models\ContactUs;
use App\Models\Donor;
use App\Models\OrderView;
use App\Models\Store;
use App\Models\Domain;
use App\Services\Admin\StoreApiService;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

class DashboardServices
{
    public  $orders, $ordersView, $projects, $donors, $contactUs, $storeApiService;

    public $currentMonth, $currentYear, $previousMonth, $previousYear;

    public $filter_start_date, $filter_end_date, $filter_status;

    public function __construct()
    {

        $this->orders = new OrderView();
        $this->projects = new Projects();
        $this->donors = new Donor();
        $this->contactUs = new ContactUs();
        $this->storeApiService = new StoreApiService();

        // get request filter 
        $this->filter_start_date = request('start_date');
        $this->filter_end_date = request('end_date');
        $this->filter_status = request('order_status');

        // Define Date Format
        $this->currentMonth = Carbon::now()->month;
        $this->currentYear = Carbon::now()->year;
        if ($this->filter_start_date !== null) {
            $this->currentMonth = Carbon::parse($this->filter_start_date)->month;
            $this->currentYear = Carbon::parse($this->filter_start_date)->year;
        }
        $this->previousMonth = $this->currentMonth - 1;
        $this->previousYear = $this->currentYear;
        // If current month is January, so get the previous month and year
        if ($this->currentMonth === 1) {
            $this->previousMonth = 12;
            $this->previousYear--;
        }
    }

    // get Data --------------------------------------------------------------------------------------------------

    /**
     * Get the count of pending orders.
     */
    public function getOrder()
    {
        $query = $this->orders;
        if ($this->filter_status !== null) {
            $query = $query->where('status',  $this->filter_status);
        }
        if ($this->filter_start_date !== null) {
            $query = $query->whereDate('created_at', '>=', $this->filter_start_date);
        }
        if ($this->filter_end_date !== null) {
            $query = $query->whereDate('created_at', '<=', $this->filter_end_date);
        }

        return $query->get();
    }

    /**
     * Get the count of donors.
     */
    public function donorCount()
    {
        $query = $this->donors;

        if ($this->filter_start_date !== null) {
            $query = $query->whereDate('created_at', '>=', $this->filter_start_date);
        }
        if ($this->filter_end_date !== null) {
            $query = $query->whereDate('created_at', '<=', $this->filter_end_date);
        }

        return count($query->get());
    }

    /**
     * Get the count of messages.
     */
    public function contactsCount()
    {
        $query = $this->contactUs;

        if ($this->filter_start_date !== null) {
            $query = $query->whereDate('created_at', '>=', $this->filter_start_date);
        }
        if ($this->filter_end_date !== null) {
            $query = $query->whereDate('created_at', '<=', $this->filter_end_date);
        }

        return count($query->get());
    }

     /**
     * Get the count of project.
     */
    public function projectsCount()
    {
        $query = $this->projects;
        if ($this->filter_start_date !== null) {
            $query = $query->whereDate('created_at', '>=', $this->filter_start_date);
        }
        if ($this->filter_end_date !== null) {
            $query = $query->whereDate('created_at', '<=', $this->filter_end_date);
        }

        return count($query->get());
    }


    /**
     * Get the last 6 orders sorted by creation date in descending order.
     *
     * @return \Illuminate\Database\Eloquent\Collection|\App\Models\OrderView[]
     */
    public function getLastOrders()
    {
        $query = $this->orders->orderBy('created_at', 'DESC');

        if ($this->filter_status !== null) {
            $query = $query->where('status',  $this->filter_status);
        }
        if ($this->filter_start_date !== null) {
            $query->whereDate('created_at', '>=', $this->filter_start_date);
        }
        if ($this->filter_end_date !== null) {
            $query->whereDate('created_at', '<=', $this->filter_end_date);
        }

        return $query->limit(6)->get();
    }

    /**
     * Get the count of orders grouped by their status.
     *
     * @return \Illuminate\Database\Eloquent\Collection|\App\Models\OrderView[]
     * 
     */
    public function getStatusCountOrders()
    {
        $query = $this->orders->select('status', DB::raw('count(id) as count'));

        if ($this->filter_status !== null) {
            $query = $query->where('status',  $this->filter_status);
        }
        if ($this->filter_start_date !== null) {
            $query->whereDate('created_at', '>=', $this->filter_start_date);
        }
        if ($this->filter_end_date !== null) {
            $query->whereDate('created_at', '<=', $this->filter_end_date);
        }

        return  $query->groupBy('status')->get();
    }

    /**
     * Get the count of orders grouped by their source.
     *
     * @return \Illuminate\Database\Eloquent\Collection|\App\Models\OrderView[]
     * 
     */
    public function getSourceCountOrders()
    {
        $query = $this->orders->select('source', DB::raw('count(id) as count'));

        if ($this->filter_status !== null) {
            $query = $query->where('status',  $this->filter_status);
        }
        if ($this->filter_start_date !== null) {
            $query->whereDate('created_at', '>=', $this->filter_start_date);
        }
        if ($this->filter_end_date !== null) {
            $query->whereDate('created_at', '<=', $this->filter_end_date);
        }

        return  $query->groupBy('source')->get();
    }

    /**
     * Get the Top Projects Which is most ordered 
     *
     */
    public function getTopProjects()
    {
        return collect([]);
    }


    /**
     * Calculate the difference in total amount of orders between the current and previous month.
     */
    function calculateAmountFromPreviousMounth()
    {
        $currentMonthOrders = $this->orders->Confirmed()->forMonth($this->currentYear, $this->currentMonth)->SUM('total'); // Replace null with your model if using scope
        $previousMonthOrders = $this->orders->Confirmed()->forMonth($this->previousYear, $this->previousMonth)->SUM('total'); // Replace null with your model if using scope
        $orderCountDifference = $currentMonthOrders - $previousMonthOrders;
        
        return $orderCountDifference;
        if ($previousMonthOrders === 0) {
            return 0; // Handle division by zero
        } else {
            $result = $previousMonthOrders > $currentMonthOrders ? '-' : '+';
            return   abs(number_format((($orderCountDifference / $previousMonthOrders) * 100), 2)) . '%' . $result;
        }
    }

    /**
     * Calculate the difference in total number of donors between the current and previous month.
     */
    function calculateDonorFromPreviousMounth()
    {
        $currentMonthDonor = $this->donors->forMonth($this->currentYear, $this->currentMonth)->count(); // Replace null with your model if using scope
        $previousMonthDonor = $this->donors->forMonth($this->previousYear, $this->previousMonth)->count(); // Replace null with your model if using scope
        $donorCountDifference = $currentMonthDonor - $previousMonthDonor;
        return $donorCountDifference;
        // dd( $donorCountDifference,  $currentMonthDonor ,  $previousMonthDonor, ($donorCountDifference / $previousMonthDonor));
        if ($previousMonthDonor === 0) {
            return 0; // Handle division by zero
        } else {
            $result = $previousMonthDonor > $currentMonthDonor ? '-' : '+';
            return   abs(number_format((($donorCountDifference / $previousMonthDonor) * 100), 2)) . '%' . $result;
        }
    }

    /**
     * Generate a line chart for monthly orders donations.
     */
    function donationsChart()
    {
        $orders = clone ($this->orders->confirmed())->get();
        if ($this->filter_status !== null) {
            $orders = clone ($this->orders->where('status',  $this->filter_status))->get();
        }
        $start = Carbon::parse($orders->min("created_at"));
        $end = Carbon::now();
        if ($this->filter_start_date !== null) {
            $start = Carbon::parse($this->filter_start_date);
        }
        if ($this->filter_end_date !== null) {
            $end = Carbon::parse($this->filter_end_date);
        }
        $period = CarbonPeriod::create($start, "1 month", $end);
        $usersPerMonth = collect($period)->map(function ($date) use ($orders) {
            $endDate = $date->copy()->endOfMonth();
            return [
                "count" => count($orders->where("created_at", "<=", $endDate)),
                "amount" => $orders->where("created_at", "<=", $endDate)->SUM('total'),
                "month" => $endDate->format("Y-m-d")
            ];
        });
        // dd($period,  $start, $end);

        $chartdata = $usersPerMonth->pluck("amount")->toArray();
        $labels = $usersPerMonth->pluck("month")->toArray();

        return app()
            ->chartjs->name("DonationsChart")
            ->type("line")
            ->size(["width" => 770, "height" => 260])
            ->labels($labels)
            ->datasets([
                [
                    "label" => trans('dashboard.order_donations'),
                    "backgroundColor" => "rgba(38, 185, 154, 0.31)",
                    "borderColor" => "rgba(38, 185, 154, 0.7)",
                    "data" => $chartdata
                ]
            ])
            ->options([
                'scales' => [
                    'x' => [
                        'type' => 'time',
                        'time' => [
                            'unit' => 'month'
                        ],
                        'min' => $start->format("Y-m-d"),
                    ]
                ],
                'plugins' => [
                    'title' => [
                        'display' => true,
                        'text' => trans('dashboard.monthly_donation')
                    ]
                ]
            ]);
    }


    /**
     * Get the donations data for the last 30 days.
     */
    function donationsData()
    {
        $subtractedTime = Carbon::now()->subSeconds(2592000);
        $now =  Carbon::now();
        if ($this->filter_start_date !== null) {
            $subtractedTime = Carbon::parse($this->filter_start_date);
        }
        if ($this->filter_end_date !== null) {
            $now = Carbon::parse($this->filter_end_date);
        }
        // dd($subtractedTime, Carbon::now());
        $query = $this->orders->confirmed();
        if ($this->filter_status !== null) {
            $query = $this->orders->where('status',  $this->filter_status);
        }
        $donations =  $query
            ->whereBetween('created_at', [$subtractedTime, $now ])
            ->orderBy('created_date', 'ASC')
            ->selectRaw('DATE(created_at) as created_date, SUM(total) as total, COUNT(*) as count')
            ->groupBy('created_date')
            ->get()
            ->toArray();
        return $donations;
    }
    // End get Data --------------------------------------------------------------------------------------------------

    // Multi-Store Statistics Methods ------------------------------------------------------------

    /**
     * Get statistics from all stores via APIs
     */
    public function getMultiStoreStatistics()
    {
        return $this->storeApiService->fetchAllStoresStatistics(
            $this->filter_start_date,
            $this->filter_end_date
        );
    }

    /**
     * Get aggregated statistics from all stores
     */
    public function getAggregatedStoreStatistics()
    {
        return $this->storeApiService->getAggregatedStatistics(
            $this->filter_start_date,
            $this->filter_end_date
        );
    }

    /**
     * Get domains list for dropdown
     */
    public function getStoresList()
    {
        return Domain::where('status', 1)
            ->get()
            ->map(function ($domain) {
                return [
                    'id' => $domain->id,
                    'name' => $domain->domain_name,
                    'api_url' => $domain->domain_url,
                    'type' => $domain->type,
                ];
            });
    }

    // End Multi-Store Statistics Methods --------------------------------------------------------

    function index()
    {
        // Get and assign all data
        $data['orderCount'] = count($this->getOrder());
        $data['orderTotal'] = $this->getOrder()->sum('total');
        $data['lastMonthPercent'] = $this->calculateAmountFromPreviousMounth();
        $data['donorCount'] = $this->donorCount();
        $data['DonorMonth'] = $this->calculateDonorFromPreviousMounth();
        $data['contactsCount'] = $this->contactsCount();
        $data['projectsCount'] = $this->projectsCount();

        // $data['donationsChart'] = $this->donationsChart();
        $data['donationsData'] = $this->donationsData();

        $data['topProjects'] = $this->getTopProjects();
        $data['lastOrders'] = $this->getLastOrders();
        $data['orderStatusCount'] = $this->getStatusCountOrders();
        $data['orderSourceCount'] = $this->getSourceCountOrders();

        // Multi-Store Statistics
        $data['multiStoreStats'] = $this->getAggregatedStoreStatistics();
        $data['storesList'] = $this->getStoresList();

        $data['colors'] = ['success', 'danger', 'primary', 'warning'];

        return $data;
    }
}
