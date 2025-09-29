<?php

namespace App\Http\Livewire\Site\Payments;

use App\Charity\Carts\DatabaseCart;
use App\Http\Controllers\Site\CheckoutController;
use App\Models\PaymentMethod;
use Livewire\Component;

class ApplePay extends Component
{


    public $payment_method_id = 4 , $payment_method_key = 'ApplePay';

    public $amount = 0;

    public $order;

    public $testMode = "", $url = "", $mechant_identifier = "", $access_code = "", $SHARequestPhrase = "", $SHAResponsePhrase = "";

    protected $listeners = ['updateAuth'];


    public function updateAuth()
    {
        if(@auth('account')->user()?->types->where('type', 'donor')->first() != null){
            $this->render();
        }
    }



    public function checkout(){
        $data['payment_method_id'] = $this->payment_method_id;
        $data['payment_method_key'] = $this->payment_method_key;

         // Make Order ---
        $order = new CheckoutController();
        $process = $order->process($data);
        $identifier = $process['order']->identifier;

         return redirect()->route('site.checkout.applepay', $identifier);
    }


    public function mount(){
        $data['payment_method_id'] = $this->payment_method_id;
        $data['payment_method_key'] = $this->payment_method_key;
        $data['payment_proof'] = "Select ApplePay Payment Only";
        $order = new CheckoutController();
        $process = $order->process($data);
        $identifier = $process['order']->identifier;
        $this->order = $process['order'];

        $this->testMode = config('app.TEST_MODE');
        if ($this->testMode) {
            $this->url = "https://sbcheckout.payfort.com/FortAPI/paymentPage";
            $this->mechant_identifier = "9cc5d3c5";
            $this->access_code = "lR3miH0aJZTNBCW5So7m";
            $this->SHARequestPhrase = "96o0CiKlNkSJO7/OJH8ALl$+";
            $this->SHAResponsePhrase =  "19LyOVjIq9cJDej0PQ.lNO{@";
        } else {
            $this->url = 'https://checkout.payfort.com/FortAPI/paymentPage';
            $this->mechant_identifier = config("payfort.mechant_identifier");
            $this->access_code = config("payfort.access_code");
            $this->SHARequestPhrase = config("payfort.SHARequestPhrase");
            $this->SHAResponsePhrase = config("payfort.SHAResponsePhrase");
        }

        $this->payment_method_key = @PaymentMethod::find($this->payment_method_id)->payment_key;
    }


    public function render()
    {
        return view('livewire.site.payments.apple-pay');
    }

}
