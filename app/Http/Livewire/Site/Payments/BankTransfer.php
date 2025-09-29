<?php

namespace App\Http\Livewire\Site\Payments;

use Livewire\Component;
use App\Traits\FileHandler;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\Site\CheckoutController;
use App\Models\PaymentBank;
use App\Models\PaymentMethod;

class BankTransfer extends Component
{
    use WithFileUploads, FileHandler;

    protected $listeners = ['updateAuth'];

    public $payment_method_id = 3, $payment_method_key = 'Bank Transfer';
    public $bank_accounts;
    public $payment, $bankHoldName;
    public $bank_id = "", $image;
    public $account_type = "", $iban = "";


    protected function rules(){
        return [
            'bank_id' => 'required',
            'image'   => 'required|' . ImageValidate(null, true),
        ];
    }

    public function updateAuth()
    {
        if(@auth('account')->user()?->types->where('type', 'donor')->first() != null){
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
        $data['payment_method_key'] = @PaymentBank::find($this->bank_id)->payment_key ?? $this->payment_method_key;
        return $data;
    }

    public function checkout(){
        $data = $this->getSanitized();

        // Make Order ---
        $order = new CheckoutController();
        $process = $order->process( $data);

        if( $process['status'] == false){
            session()->flash('warning', $process['message']);
            if($missId = $process['data']['missData']){
                $this->emit('openModal', $missId);
            }
        }
        else{
            Cookie::queue('cart', "");
            Cookie::queue(Cookie::forget('cart'));
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
        return view('livewire.site.payments.bank-transfer');
    }
}
