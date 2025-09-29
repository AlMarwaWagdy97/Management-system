<?php

namespace App\Http\Livewire\Site\CharityProduct;

use App\Charity\Carts\DatabaseCart;
use App\Charity\Carts\Item;
use App\Charity\Gifts\Cards;
use App\Charity\Gifts\Given;
use App\Charity\Gifts\Projects;
use App\Charity\Settings\SettingSingleton;
use App\Models\CharityProject;
use App\Models\GiftCards;
use App\Models\GiftCategories;
use App\Models\GiftOccasioins;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Show extends Component
{
    public $product, $project, $projects = [], $donation, $selectedProject;
    public $donationAmt = 0, $donationQty = 1, $donationtype;

    public $productPrice = 0, $mustLogin = false, $msg = "";

    public $giver_name, $giver_mobile, $giver_email, $giver_address, $giver_message;

    public $cardCategories, $cardOcassions, $cards = [];
    public $selectedCardCategories, $selectedCardOcassions, $selectedCard = "", $selectedCardPrice = 0;

    public  $colorsAmount = ['bg-secound', 'bg-main', 'bg-dark'];

    public $unitValueRadio, $unitValueInput, $shareValue, $fixedValue, $openValue;

    public $giftCartStatus = false, $giftProjectStatus = false;

    protected $listeners = ['updateAuth'];



    /**
     * rules validation
     */
    protected function rules()
    {
        $rules =  [
            'giver_name' => 'required|string',
            'giver_mobile' => 'required|min:9|max:9',
            'giver_email' => 'nullable|string|email',
            'giver_address' => 'required|string',
            'giver_message' => 'nullable|string',
        ];
        if ($this->project) {
            $rules['donationAmt'] = 'required|numeric|min:1';
        }
        if ($this->selectedCardCategories || $this->selectedCardOcassions) {
            $rules['selectedCard'] = 'required';
        }
        return $rules;
    }


    public function updatedUnitValueRadio($data)
    {
        $data = json_decode($data);
        $this->donationAmt = $data->value;
        $this->donationtype = $data->name;
        $this->donationQty = 1;
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

        $this->donationAmt = $value;
        $this->donationtype = $this->project['title'];
        $this->clear();
    }

    /**
     * @return [type]
     */
    public function updatedDonationQty()
    {
        if ($this->donation['type'] == 'fixed') {
            $this->donationtype = $this->project['title'];
        }
        $this->clear();
    }

    /**
     * update the donation Amount
     * @return [type]
     */
    public function updatedSelectedProject()
    {
        $this->donationAmt = 0;
        $this->donation = "";
        $this->project = "";
        if ($this->selectedProject) {
            $this->project = CharityProject::find($this->selectedProject);
            $this->donation = json_decode(($this->project?->donation_type) ?? [], true);
        }
    }

    /**
     * check if nedd auth or not
     * @return [type]
     */
    public function updateAuth()
    {
        $mustLogin = SettingSingleton::getInstance()->getLoginStatus('show_login_project');
        if ($mustLogin == true && @auth('account')->user()?->types->where('type', 'donor')->first()->id == null) {
            $this->mustLogin = true;
        } else {
            $this->mustLogin = false;
        }
    }

    /**
     * update the card when we change category or ocassions
     * @return [type]
     */
    public function updateCards()
    {
        $this->selectedCard = "";
        $ocations =  $this->selectedCardOcassions;
        $this->cards = GiftCards::with('category', 'occasioins')
            ->where('category_id', $this->selectedCardCategories)
            ->whereHas('occasioins', function ($q) use ($ocations) {
                $q->whereIn('occasioin_id', [$ocations]);
            })->get();

        $this->dispatchBrowserEvent('owlCarouselUpdate');
    }


    /**
     * Add to Cart
     * @return [type]
     */
    public function addToCart($showModal = true)
    {

        $data = $this->validate();

        $data['donationtype']  = $this->donationtype;
        $data['donationQty']  = $this->donationQty;
        $data['project'] = $this->selectedProject;
        $data['occasion'] = $this->selectedCardOcassions;
        $data['category'] = $this->selectedCardCategories;
        $data['card'] = $this->selectedCard;
        DB::beginTransaction();
        try {
            $item = new Item(Product::class, $this->product->id, 'Gift Product'); // create item data 
            // add to card 
            $cart = new DatabaseCart();
            $this->msg = $cart->addItem($item, $this->donationQty, $this->product->price, null, true);

            // get json Gift card details
            $givenDetails = new Given($data);
            $cart->addGivtenCard(@$this->msg['card_id'], $givenDetails->getData());

            if ($this->selectedCard) {
                $data['cardImage'] = $this->cards->where('id', $this->selectedCard)->first()->image;
                $data['occasionName'] = $this->cardCategories->where('id', $this->selectedCardCategories)->first()->trans?->where('locale', app()->getLocale())->first()->title;
                $data['categoryName'] = $this->cardOcassions->where('id', $this->selectedCardOcassions)->first()->trans?->where('locale', app()->getLocale())->first()->title;
                $givenDetails = new Cards($data);
                $cart->addGiftCard(@$this->msg['card_id'], $givenDetails->getData());
            }

            // store project data in cart in same row 
            if($this->donationAmt){
                $data['item_id'] = $this->selectedProject;
                $data['item_name'] = @$this->project->trans?->where('locale', app()->getLocale())->first()->title;
                $data['item_sub_type'] = $this->donationtype;
                $data['price'] = $this->donationAmt;
                $data['quantity'] = $this->donationQty;
                $projectDetails = new Projects($data);
                $cart->addProjectToCard(@$this->msg['card_id'], $projectDetails->getData());
            }

            // store project data in cart in  new row 
            // if ($this->donationAmt) {
            //     $item = new Item(CharityProject::class,  $this->selectedProject, $this->donationtype); // create item data 
            //     $cart = new DatabaseCart();
            //     $msg2 = $cart->addItem($item, $this->donationQty, $this->donationAmt, null);
            //     $cart->connectProjectToProduct(@$this->msg['card_id'], @$msg2['card_id']);
            // }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
        
        // show model & clear 
        if ($this->msg['type'] == "success" & $showModal) {
            $this->clearData();
            $this->clear();
            $this->emit('showModel');
        }
        return true;
    }

    public function donateNow()
    {
        $status = $this->addToCart(false);
        if ($status) redirect()->route('site.checkout.show');
    }



    /**
     * clear message
     * @return [type]
     */
    public function clear()
    {
        $this->msg = [];
    }
    /**
     * clear message
     * @return [type]
     */
    public function clearData()
    {
        $this->donationAmt = 0;
        $this->donationtype = "";
        $this->giver_name = "";
        $this->giver_mobile = "";
        $this->giver_message = "";
        $this->giver_email = "";
        $this->giver_address = "";
        $this->selectedCardCategories = "";
        $this->selectedCardOcassions = "";
        $this->selectedCard = "";
        $this->selectedCardPrice = "";
        $this->selectedProject = null;
        $this->donation = "";
        $this->cards = [];
    }

    public function mount($product)
    {
        $this->product = $product;
        $this->productPrice = $product->price;

        $this->cardCategories = GiftCategories::with('trans')->active()->orderBy('sort', 'asc')->get();
        $this->cardOcassions = GiftOccasioins::with('trans')->active()->orderBy('sort', 'asc')->get();

        $projects_ids = SettingSingleton::getInstance()->getProductsData('projects');
        $this->projects = CharityProject::with('trans')->active()->whereIn('id', json_decode($projects_ids ?? []))->get();

        $this->updateAuth();
    }

    public function render()
    {
        $this->dispatchBrowserEvent('owlCarouselUpdate');
        return view('livewire.site.charity-product.show');
    }
}
