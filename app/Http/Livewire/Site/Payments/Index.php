<?php

namespace App\Http\Livewire\Site\Payments;

use App\Models\PaymentMethod;
use Faker\Provider\UserAgent;
use Livewire\Component;

class Index extends Component
{
    public  $paymentMethod = "visa";
    public  $visaStatus = false, $applePayStatus = false, $banktransferStatus = false;

    protected $listeners = ['updateAuth'];

    public function updateAuth()
    {
        if (@auth('account')->user()?->types->where('type', 'donor')->first() != null) {
            $this->render();
        }
    }

    public function SelectPayment($val)
    {
        $this->paymentMethod = $val;
    }

    public function mount()
    {

        $paymentMethods = PaymentMethod::query();
        $this->visaStatus = (clone  $paymentMethods)->find(2)?->status;
        $this->applePayStatus = (clone  $paymentMethods)->find(4)?->status;
        $this->banktransferStatus = (clone  $paymentMethods)->find(3)?->status;
    }

    public function render()
    {

        $userAgentString = $_SERVER['HTTP_USER_AGENT'] ?? ''; // Get user agent string, or empty if not set
        $isIPhone = (strpos($userAgentString, 'iPhone') !== false);
        $isSafari = (strpos($userAgentString, 'Safari') !== false && strpos($userAgentString, 'Chrome') === false); // Basic check for Safari, trying to exclude Chrome
        
        return view('livewire.site.payments.index', ['iphone' => $isIPhone, 'safari' => $isSafari]);
    }
}
