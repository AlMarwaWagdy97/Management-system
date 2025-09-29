<?php

namespace App\Http\Livewire\Site\Home;

use Livewire\Component;
use App\Charity\Carts\Item;
use App\Models\CharityProject;
use App\Charity\Carts\DatabaseCart;
use App\Charity\Settings\SettingSingleton;

class RequestedProject extends Component
{
    public $project;
    public $progressBar = [];
    public $donation;
    public $msg = [];

    public $unitValueRadio, $unitValueInput, $shareValue, $fixedValue, $openValue; // price values

    public $donationAmt,  $donationtype = "", $donationQty = 1; // cart info

    public  $colors = [], $colorsAmount = ['bg-secound', 'bg-main', 'bg-dark'];


    public function mount($project)
    {
        // define color categories
        $settings = SettingSingleton::getInstance();
        $this->colors = $settings->getColor('donation_color') ?? ['#3B82F6', '#10B981', '#8B5CF6'];
        // define projects data
        $this->project = $project;
        $this->donation = json_decode($this->project['donation_type'], true);
        if ($this->donation['type'] == "fixed") {
            $this->donationAmt = @$this->donation['data'];
        }
        //calculate the progress bar:
        $activeOrderDetails = 0;
        if (@$project['orderDetails'] != null) {
            $activeOrderDetails = @$project['orderDetails']->filter(function ($detail) {
                return $detail->order?->status === 1;
            })->sum('total') ;
        }

        $this->progressBar['target_price'] = $project['target_price'] == 0 ? 1 : $project['target_price'];
        $this->progressBar['collected'] = ($project['fake_target'] ?? 0) + ($activeOrderDetails?? 0);
        $this->progressBar['avarge'] =  ceil($this->progressBar['collected'] / $this->progressBar['target_price'] * 100) ?? 0;
        if ($this->progressBar['avarge'] > 100) $this->progressBar['avarge'] = 100;


        // $target = $project['collected_target'] + $project['fake_target'];
        // $this->progressBar['collected'] = $project['fake_target'];
        // $this->progressBar['reminder'] = $project['target_price'] - $this->progressBar['collected'];
        // $this->progressBar['percent'] = ceil($target * 100 / ($project['target_price'] == 0 ? 1 : $project['target_price']));
        // $this->progressBar['percent'] = $project['target_price'] <= 0 ? 0 : floor(($this->progressBar['collected'] /  $project['target_price']) * 100);

        $this->project['slug'] = $this->project['trans'][0]['slug'];
        $this->project['title'] = $this->project['trans'][0]['title'];
        $this->project['description'] = $this->project['trans'][0]['description'];
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
    public function donate($id)
    {
        return redirect()->route('site.charity-project.show', $this->project['id']);
    }

    public function addToCart()
    {
        $this->clear();
        if($this->project['finished'] || @$this->progressBar['avarge'] == 100){
            return $this->msg = [
                'type' => 'warning',
                'value' => __('Sorry: Donations to this project have been closed')
            ];
        }

        $item = new Item(CharityProject::class, $this->project['id'], $this->donationtype); // create item data
        // add to card
        $cart = new DatabaseCart();
        $this->msg = $cart->addItem($item, $this->donationQty, $this->donationAmt);
        // update in cart item
        $this->emit('cartUpdated');
        // show model
        if ($this->msg['type'] == "success") {
            $this->emit('showModel');
        }
    }

    public function clear()
    {
        $this->msg = [];
    }

    public function render()
    {
        return view('livewire.site.home.requested-project');
    }
}
