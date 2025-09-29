<?php

namespace App\Http\Livewire\Site\FastDonation;

use App\Charity\Settings\SettingSingleton;
use App\Models\CategoryProjects;
use App\Models\CharityProject;
use App\Models\PaymentMethod;
use Livewire\Component;
use GuzzleHttp\Client;

class Index extends Component
{

    public $open = false, $productStatus, $productIcon;
    public  $colors = [], $colorsAmount = ['bg-secound', 'bg-main', 'bg-dark'];
    public  $visaStatus = false, $applePayStatus = false, $banktransferStatus = false;

    public $donor;
    public $mobile, $name, $dataDonation, $fast_status, $fast_color;
    public $categories = [], $projects = [], $project, $show_fast_donation = false;
    public $selectedCategory, $selectedProject, $countryCode = "966";

    public $donation, $donationAmt = 0, $paymentMethod, $donationtype, $msg;
    public $unitValueRadio, $unitValueInput, $shareValue, $fixedValue, $openValue, $mobileWithCode; // price values

    protected $listeners = ['updateMessage'];


    public function updateFastDonationData()
    {

        $this->dataDonation = [
            'mobile'        => $this->countryCode . $this->mobile,
            'name'          => $this->name,
            'donationAmt'   => $this->donationAmt,
            'donationtype'  => $this->donationtype,
            'project'       => $this->project,
            'project_name'  => @$this->project?->trans()->where('locale', app()->getLocale())->first()->title,
        ];
        $this->emit('getFastDonationData', $this->dataDonation);
    }

    public function updateMessage($msg)
    {
        $this->msg = $msg;
    }


    public function SelectPayment($val)
    {

        if ($this->mobile == "") {
            $this->msg = trans("Please fill in the mobile number to proceed.");
            return;
        }
        if ($this->name == "") {
            $this->msg = trans("Please fill in the name to proceed.");
            return;
        }
        $this->paymentMethod = $val;
        $this->clear();
    }

    public function toogleOpen()
    {

        $this->open = !$this->open;
    }

    public function SelectCategory($id)
    {
        $this->selectedCategory = $id;
        $this->projects = CharityProject::whereHas('categories', function ($q) use ($id) {
            $q->where('category_id', $id);
        })->fastDonation()->get();
        $this->donationAmt = 0;
        $this->donation = null;
    }

    public function SelectProject()
    {
        $this->donationAmt = 0;
        $this->project = CharityProject::find($this->selectedProject);
        $this->donation = json_decode(@$this->project['donation_type'], true);
        if (@$this->donation['type'] == "fixed") {
            $this->donationAmt = @$this->donation['data'];
        }
        $this->clear();
    }

    public function updatedUnitValueRadio($data)
    {
        $data = json_decode($data);
        $this->donationAmt = $data->value;
        $this->donationtype = $data->name;
        $this->unitValueInput = "";
        $this->clear();
    }

    public function updatedUnitValueInput($value)
    {
        $this->donationAmt = $value;
        $this->donationtype = $this->project['title'];
        $this->unitValueRadio = "";
        $this->clear();
    }

    public function updatedShareValue($data)
    {
        $data = json_decode($data);
        $this->donationAmt = $data->value;
        $this->donationtype = $data->name;
        $this->clear();
    }
    public function updatedOpenValue($value)
    {
        $this->donationtype = $this->project['title'];
        $this->donationAmt = $value;
        $this->clear();
    }
    public function updatedDonationQty()
    {
        if ($this->donation['type'] == 'fixed') {
            $this->donationtype = $this->project['title'];
        }
        $this->clear();
    }
    public function clear()
    {
        $this->msg = [];
        $this->updateFastDonationData();
    }

    public function mount()
    {
        // define color categories
        $settings = SettingSingleton::getInstance();

        $this->show_fast_donation = $settings->getItem('show_fast_donation');

        $this->colors = $settings->getColor('donation_color') ?? ['#3B82F6', '#10B981', '#8B5CF6'];
        // define projects data
        $this->categories = CategoryProjects::active()->fastDonation()->get();

        $this->donor = @auth('account')->user()->donor;
        $this->mobile = @$this->donor->mobile;
        $this->name = @$this->donor->full_name;

        $this->productStatus = $settings?->getProductsData('status');
        $this->fast_status = $settings?->getProductsData('fast_status');
        $this->fast_color = $settings?->getProductsData('background_color');
        $this->productIcon = $settings?->getProductsData('image');

        $paymentMethods = PaymentMethod::query();
        $this->visaStatus = (clone  $paymentMethods)->find(2)?->status;
        $this->applePayStatus = (clone  $paymentMethods)->find(4)?->status;
        $this->banktransferStatus = (clone  $paymentMethods)->find(3)?->status;
        
    }

    public function render()
    {
        $this->updateFastDonationData();

        $userAgentString = $_SERVER['HTTP_USER_AGENT'] ?? ''; // Get user agent string, or empty if not set
        $isIPhone = (strpos($userAgentString, 'iPhone') !== false);
        $isSafari = (strpos($userAgentString, 'Safari') !== false && strpos($userAgentString, 'Chrome') === false); // Basic check for Safari, trying to exclude Chrome

        return view('livewire.site.fast-donation.index', ['iphone' => $isIPhone, 'safari' => $isSafari]);
    }
}
