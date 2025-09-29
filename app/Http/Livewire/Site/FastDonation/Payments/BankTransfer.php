<?php

namespace App\Http\Livewire\Site\FastDonation\Payments;

use App\Enums\SourcesEnum;
use App\Http\Controllers\Site\CheckoutController;
use App\Models\Order;
use App\Models\PaymentBank;
use App\Models\PaymentMethod;
use App\Traits\FileHandler;
use Illuminate\Support\Facades\Cookie;
use Livewire\WithFileUploads;
use Livewire\Component;

class BankTransfer extends Component
{
    use WithFileUploads, FileHandler;

    public $payment_method_id = 3;
    public $bank_accounts;
    public $payment, $bankHoldName;
    public $bank_id = "", $image;
    public $account_type = "", $iban = "";
    public $donationData;

    protected $listeners = ['getFastDonationData'];

    public function getFastDonationData($donationData)
    {
        $this->donationData = $donationData;
    }

    protected function rules()
    {
        return [
            'bank_id' => 'required',
            'bank_id' => 'required',
            'image'   => 'required|' . ImageValidate(),
        ];
    }

    public function updateAuth()
    {
        if (@auth('account')->user()?->types->where('type', 'donor')->first() != null) {
            $this->render();
        }
    }

    public function updated($field)
    {
        $this->validateOnly($field);
    }

    public function getSanitized()
    {
        $data = $this->validate();
        if ($data['image'] != null) {
            $data['banktransferproof'] = $this->upload_file($data['image'], ('orders'));
        }
        $data['payment_method_id'] = $this->payment_method_id;
        return $data;
    }

    public function checkout()
    {

        $data = $this->getSanitized();

        $data['mobile']       = @$this->donationData['mobile'];
        $data['name']         = @$this->donationData['name'];

        $data['total']        = $this->donationData['donationAmt'];
        $data['quantity']     = 1;
        $data['source']       = SourcesEnum::WEB;
        $data['refer_id']     = Cookie::get('referrer');

        $data['item_id']      =  $this->donationData['project']['id'];
        $data['item_name']    =  $this->donationData['project_name'];
        $data['item_type']    =  $this->donationData['donationtype'];

        if($data['mobile'] == ""){
            $this->emit('updateMessage', trans("Please fill in the mobile number to proceed."));
            return;
        }
        if($data['name'] == ""){
            $this->emit('updateMessage', trans("Please fill in the name to proceed."));
            return;
        }
        if($data['total'] == ""){
            $this->emit('updateMessage', trans("Please choose the donation amount"));
            return;
        }

        // Make Order ---
        $order = new CheckoutController();
        $process = $order->fastDonationProcess($data);

        if ($process['status'] == false) {
            session()->flash('warning', $process['message']);
        } else {
            session()->flash('success', trans('Your request has been successfully received and is being reviewed'));
            return redirect()->route('site.checkout.success',  $process['order']['identifier']);
        }
    }


    public function updatedbankID($val)
    {
        $selectAccount =  $this->bank_accounts->find($val);
        $this->account_type = $selectAccount['account_type'];
        $this->iban = $selectAccount['iban'];
    }


    public function mount()
    {
        $this->payment = PaymentMethod::find($this->payment_method_id);
        $this->bankHoldName = $this->payment->name_holder;
        $this->bank_accounts = PaymentBank::get();
    }

    public function render()
    {
        return view('livewire.site.fast-donation.payments.bank-transfer');
    }
}
