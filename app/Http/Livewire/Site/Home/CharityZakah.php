<?php

namespace App\Http\Livewire\Site\Home;

use App\Charity\Carts\DatabaseCart;
use App\Charity\Carts\Item;
use App\Models\CharityProject;
use Livewire\Component;

class CharityZakah extends Component
{
    public $amount = 0, $qty = 1;
    public $project, $project_id = 1;
    public $zakah = "ذكاء المال";
    public $donationtype, $donationQty = 1, $donationAmt = 0;

    public $calcZakat = false, $money, $amountZakah, $zakatMonyMessage;

    public $zakatGold_gm = null, $zakatGold_amount = null, $zakatGoldFields = []; // Gold
    public $zakatSilver_gm = null, $zakatSilver_amount = null, $zakatSilverFields = []; // Silver
    public $zakatInvestment_gm = null, $zakatInvestment_amount = null, $zakatInvestmentFields = []; // Investment

    public $msg = [], $validateType = "";



    protected function rules() {
        switch ($this->validateType){
            case "zakatMony":
                return ['money' => 'required|numeric|min:0.1'];
            case "zakatGold":
                return [
                    'zakatGold_gm' => 'required|numeric|min:0.1',
                    'zakatGold_amount' => 'required|numeric|min:0.1',
                ];
            case "zakatSilver":
                return [
                    'zakatSilver_gm' => 'required|numeric|min:0.1',
                    'zakatSilver_amount' => 'required|numeric|min:0.1',
                ];
            case "zakatInvestment":
                return [
                    'zakatInvestment_gm' => 'required|numeric|min:0.1',
                    'zakatInvestment_amount' => 'required|numeric|min:0.1',
                ];
            default:
                return [ 'amount' => 'required|numeric|min:1']; // Default validation for zakat Gold  // change according to your validation rules  // example: ['amount' => 'required|numeric|min:1']  // change according to your validation rules  // example: ['amount' => 'required|numeric|min:1']  // change according to your validation rules  // example: ['amount' => 'required|numeric|min:1']  // change according to your validation rules  // example: ['amount' => 'required|numeric|min:1']  // change according to your validation rules  // example: ['amount' => 'required|numeric|min:1']  // change
        }
    }

    
       
    public function updated($field){
        $this->validateOnly($field);
    }

    public function submit(){
        $this->addProjectInCart();
        return redirect()->route('site.checkout.show');
    }

    public function addToCart(){
        $this->addProjectInCart();
        if($this->msg['type'] == "success"){ // show model
            $this->emit('showModel');
        }
    }

    public function addProjectInCart(){
        $this->validateType = "";
        $data = $this->validate();

        $this->donationAmt = $data['amount'];
        $item = new Item(CharityProject::class, $this->project->id, $this->zakah); // create item data 
        $cart = new DatabaseCart(); ;
        $this->msg = $cart->addItem($item, $this->donationQty, $this->donationAmt);
        // update in cart item 
        $this->emit('cartUpdated');
        $this->close();

    }
    
    public function calculatorZakah($val)
    {
        $this->calcZakat = $val;
        $this->amount = 0;
    }

    public function calculateMoney(){
        $this->amount  -= $this->amountZakah;

        $this->validateType = "zakatMony";
        $this->validate();

        if($this->money == null){
            return $this->zakatMonyMessage = trans('Please fill this field first');
        }
        $this->amount  += $this->amountZakah = round($this->money * 0.025, 2);
        $this->money = null;
    }
 

    // Gold -----------------------------------------------------------------------------------------------------------------
    /**
     * calculate Gold and add amount
     * @return [type]
     */
    public function calculateGold(){
        $this->validateType = "zakatGold";
        $this->validate();
        //  calculdate zakat gold amount
        $amountGold = $this->zakatGold_gm * $this->zakatGold_amount * 0.025;
        // save the zakat gold data
        $this->zakatGoldFields[] = [
            'gram' => $this->zakatGold_gm,
            'amount' =>  $this->zakatGold_amount,
            'total' =>  round($amountGold, 2),
            'calculated' => true,
        ];
        // add amount to total
        $this->amount += round($amountGold, 2);
        // clear data
        $this->zakatGold_gm = null;
        $this->zakatGold_amount = null;
    }

    // Silver -----------------------------------------------------------------------------------------------------------------
    /**
     * calculate Silver and add amount
     * @return [type]
     */
    public function calculateSilver(){
        // validate gram & amount
        $this->validateType = "zakatSilver";
        $data = $this->validate();
        //  calculdate zakat Silver amount
        $amountSilver = $this->zakatSilver_gm * $this->zakatSilver_amount * 0.025;
        // save the zakat Silver data
        $this->zakatSilverFields[] = [
            'gram' => $this->zakatSilver_gm,
            'amount' =>  $this->zakatSilver_amount,
            'total' => round($amountSilver, 2),
            'calculated' => true,
        ];
        // add amount to total
        $this->amount += round($amountSilver, 2);
        // clear data
        $this->zakatSilver_gm = null;
        $this->zakatSilver_amount = null;
    }
    

    // Investment -----------------------------------------------------------------------------------------------------------------
    /**
     * calculate Investment and add amount
     * @return [type]
     */
    public function calculateInvestment(){
        // validate gram & amount 
        $this->validateType = "zakatInvestment";
        $data = $this->validate();

        //  calculdate zakat Investment amount
        $amountInvestment = $this->zakatInvestment_gm * $this->zakatInvestment_amount * 0.025;
        // save the zakat Investment data
        $this->zakatInvestmentFields[] = [
            'gram' => $this->zakatInvestment_gm,
            'amount' =>  $this->zakatInvestment_amount,
            'total' =>  round($amountInvestment, 2),
            'calculated' => true,
        ];
        // add amount to total
        $this->amount += round($amountInvestment, 2);
        // clear data
        $this->zakatInvestment_gm = null;
        $this->zakatInvestment_amount = null;
    }


    // Delete Zakah ----------------------------------------------------------------------------------
    public function deleteZakah($val, $index = null, $type = null)  {
      
        switch ($type) {
            case 'Gold':
                if(isset($this->zakatGoldFields[$index])){$this->amount =  $this->amount - $val;}
                unset($this->zakatGoldFields[$index]);
                break;
            case 'Silver':
                if(isset($this->zakatSilverFields[$index])){$this->amount =  $this->amount - $val;}
                unset($this->zakatSilverFields[$index]);
                break;
            case 'Investment':
                if(isset($this->zakatInvestmentFields[$index])){$this->amount =  $this->amount - $val;}
                unset($this->zakatInvestmentFields[$index]);
                break;
            default:
                if($this->amountZakah > 0){$this->amount =  $this->amount - $val;}
                $this->amountZakah = null;
        }
       
    }
    

    public function close(){
        $this->amount = 0;
        $this->amountZakah = 0;
        $this->zakatGoldFields = [];
        $this->zakatSilverFields = [];
        $this->zakatInvestmentFields = [];
    }

    public function mount()
    {
        $this->project = CharityProject::find($this->project_id);
        
        // add fiels of zakah
        // $this->goldFields = [
        //     'gram' => '',
        //     'amount' => '',
        //     'total' => '',
        //     'calculated' => false,
        // ];
    }
    public function render()
    {
        return view('livewire.site.home.charity-zakah');
    }
}
