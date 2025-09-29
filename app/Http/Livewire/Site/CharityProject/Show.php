<?php

namespace App\Http\Livewire\Site\CharityProject;

use Livewire\Component;
use App\Charity\Carts\Item;
use App\Models\CharityProject;
use App\Charity\Carts\DatabaseCart;
use App\Charity\Settings\SettingSingleton;
use App\Models\Settings;
use Intervention\Image\ImageManagerStatic as Image;

class Show extends Component
{
    public $project, $donation, $amount, $giftStatus = 0, $cards = [], $selectCardTitle;
    public $donationAmt = 0, $donationQty = 1, $donationtype;
    // public $senderName;

    public $progressBar = ['collected' => 0, 'reminder' => 0, 'percent' => 0];
    public $unitValueRadio, $unitValueInput;
    public $shareValue, $fixedValue, $openValue;
    public $msg = [];
    public $select_card = 0, $select_category = 0, $select_ocassion = 0;
    public $colors, $colorsAmount = ['bg-secound', 'bg-main', 'bg-dark'];
    public $info_gift, $donation_status = 0, $donation_gift = 0, $dynamicAmt = 0;
    public $giver_name = [], $giver_mobile = [], $giver_email = [];
    public $mustLogin = false;

    protected $listeners = [
        'updateGiftInfo',
        'donationStatus',
        'updateAuth',
        'updateDonationAmount',
        'updateDynamicGiftAmount'
    ];

    public function updatedUnitValueRadio($data)
    {
        $data = json_decode($data);
        $this->donationAmt    = $data->value;
        $this->donationtype   = $data->name;
        $this->donationQty    = 1;
        $this->unitValueInput = "";
        $this->clear();
    }

    public function updatedUnitValueInput($value)
    {
        $this->donationAmt    = $value;
        $this->donationtype   = $this->project['title'];
        $this->unitValueRadio = "";
        $this->clear();
    }

    public function updatedShareValue($data)
    {
        $data = json_decode($data);
        $this->donationAmt  = $data->value;
        $this->donationtype = $data->name;
        $this->clear();
    }

    public function updatedOpenValue($value)
    {
        $this->donationAmt  = $value;
        $this->donationtype = $this->project['title'];
        $this->clear();
    }

    public function updatedDonationQty()
    {
        if ($this->donation['type'] === 'fixed') {
            $this->donationtype = $this->project['title'];
        }
        $this->clear();
    }

    public function updateGiftInfo($info, $amount = 0)
    {
        if ($amount != 0) {
            $this->updateDonationAmount($amount);
        }
        $this->info_gift = $info;
    }

    public function updateDynamicGiftAmount($val)
    {
        $this->dynamicAmt = $val;
    }

    public function donationStatus($val)
    {
        $this->clear();
        $this->donationAmt     = 0;
        $this->donationtype    = "";
        $this->unitValueRadio  = "";
        $this->unitValueInput  = "";
        $this->shareValue      = "";
        $this->openValue       = "";
        if ($val == 0 && $this->donation['type'] === "fixed") {
            $this->donationAmt = $this->donation['data'];
        }
    }

    public function setShareValue($value)
    {
        $this->shareValue = $value;
    }

    public function addToCart($showModal = true)
    {
        $this->clear();

        if($this->project['finished'] || @$this->progressBar['avarge'] == 100){
            $this->msg = [
                'type' => 'warning',
                'value' => __('Sorry: Donations to this project have been closed')
            ];
            return 0;
        }


        if ($this->donationAmt === null || $this->donationAmt <= 0) {
            $this->msg = [
                'type'  => 'warning',
                'value' => __('The donation value must be greater than zero'),
            ];
        }

        if ($this->donationAmt > 0) {
            $item = new Item(CharityProject::class, $this->project['id'], $this->donationtype);
            $cart = new DatabaseCart();
            $this->msg = $cart->addItem($item, $this->donationQty, $this->donationAmt);
        }

        if ($this->info_gift != null) {
            foreach ($this->info_gift as $ind => $cardInfo) {
                if ($cardInfo['saved'] === false) {
                    $this->emit('updateMessageCard', $ind, trans('Please enter all fields'));
                    return false;
                }
            }
            $this->addCardsToCart();
        }

        $this->emit('cartUpdated');
        $this->openValue = 0;

        if (@$this->msg['type'] === "success" && $showModal) {
            $this->emit('showModel');
            $this->emit('UpdategiftStatus', 0);
            $this->clearGift();
        }

        return @$this->msg['type'] === "success";
    }

    public function addCardsToCart()
    {
        $cart        = new DatabaseCart();
        $settingMain = Settings::where('key', 'gift')->first();
        $settings    = $settingMain->values->pluck('value', 'key');

        $senderXPercent    = $settings['sender_x'] ?? 10;
        $senderYPercent    = $settings['sender_y'] ?? 20;
        $recipientXPercent = $settings['recipient_x'] ?? 10;
        $recipientYPercent = $settings['recipient_y'] ?? 80;

        foreach (session()->get('card', []) as $gift) {
            $item = new Item(CharityProject::class, $this->project['id'], $gift['donationtype']);

            $path = storage_path('app/public/' . $gift['image']);
            $info = getimagesize($path);
            $mime = $info['mime'];

            switch ($mime) {
                case 'image/png':
                    $img = imagecreatefrompng($path);
                    break;
                case 'image/jpeg':
                case 'image/jpg':
                    $img = imagecreatefromjpeg($path);
                    break;
                default:
                    throw new \Exception("Unsupported image type: {$mime}");
            }

            $white = imagecolorallocate($img, 255, 255, 255);
            $fontFile = public_path('fonts/4.TTF');
            $fontSize = 24;

            $width  = imagesx($img);
            $height = imagesy($img);

            $senderX    = intval(($senderXPercent / 100) * $width);
            $senderY    = intval(($senderYPercent / 100) * $height) + $fontSize;
            $recipientX = intval(($recipientXPercent / 100) * $width);
            $recipientY = intval(($recipientYPercent / 100) * $height) + $fontSize;

            $senderName    = optional(auth('account')->user())->donor->full_name ?? 'unknown';
            $recipientName = $gift['giver_name'];

            imagettftext(
                $img,
                $fontSize,
                0,
                $senderX,
                $senderY,
                $white,
                $fontFile,
                $senderName
            );

            imagettftext(
                $img,
                $fontSize,
                0,
                $recipientX,
                $recipientY,
                $white,
                $fontFile,
                $recipientName
            );



            $filename        = time() . '_' . uniqid() . '.png';
            $relativePath    = 'attachments/gifts/' . $filename;
            $fullServerPath  = public_path($relativePath);

            if (! file_exists(dirname($fullServerPath))) {
                mkdir(dirname($fullServerPath), 0755, true);
            }

            imagepng($img, $fullServerPath);
            imagedestroy($img);

            $info_gift = [
                'donationtype' => $gift['donationtype'],
                'donationAmt'  => $gift['donationAmt'],
                'giver_name'   => $gift['giver_name'],
                'giver_mobile' => $gift['giver_mobile'],
                'giver_email'  => $gift['giver_email'],
                'cardTitle'    => $gift['cardTitle'],
                'image'        => $relativePath,
                'sendCopy'     => $gift['sendCopy'],
            ];
    

            $this->msg = $cart->addItem($item, $this->donationQty, $gift['donationAmt'], $info_gift);
        }

        session()->put('card', []);
        $this->emit('finishedSaveGifts');
    }


    public function clear()
    {
        $this->msg = [];
    }

    public function clearGift()
    {
        $this->msg           = [];
        $this->donationAmt   = 0;
        $this->donation_gift = 0;
        $this->dynamicAmt    = 0;
        $this->donationtype  = "";
        $this->giftStatus    = false;
    }

    public function donateNow()
    {
        if ($this->addToCart(false)) {
            redirect()->route('site.checkout.show');
        }
    }

    public function updateAuth()
    {
        $mustLogin = SettingSingleton::getInstance()->getLoginStatus('show_login_project');
        $userType  = auth('account')->user()?->types->where('type', 'donor')->first()?->id;
        $this->mustLogin = $mustLogin && $userType === null;
    }

    public function updateDonationAmount($val)
    {
        $this->donation_gift += $val;
    }

    public function mount($project)
    {
        $settingsSingleton = SettingSingleton::getInstance();
        $this->colors = $settingsSingleton->getColor('donation_color') ?? ['#3B82F6', '#10B981', '#8B5CF6'];
        
        if (!is_array($this->colors)) {
            $this->colors = ['#3B82F6', '#10B981', '#8B5CF6'];
        }

        $this->project   = $project;
        $this->cards     = $settingsSingleton->getGift('gift_category');
        $this->donation  = json_decode($this->project['donation_type'], true);

        if ($this->donation['type'] === "fixed") {
            $this->donationAmt = $this->donation['data'];
        }
        if ($this->donation['type'] === "open") {
            $this->openValue   = $this->donationAmt = $this->amount;
        }
        if ($this->donation['type'] === "share") {
            foreach ($this->donation['data'] as $donshare) {
                if ($donshare['value'] == $this->amount) {
                    $this->donationAmt = $this->amount;
                }
            }
        }
        if ($this->donation['type'] === "unit") {
            $this->unitValueInput = $this->donationAmt = $this->amount;
            foreach ($this->donation['data'] as $donshare) {
                if ($donshare['value'] == $this->amount) {
                    $this->donationAmt     = $this->amount;
                    $this->unitValueInput = 0;
                }
            }
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


        // $project['collected_target'] = @$project['orderDetails']?->sum('total') ?? 0;
        // $target = $project['collected_target'] + $project['fake_target'];
        // $this->progressBar['collected'] = $project['fake_target'];
        // $this->progressBar['reminder']  = $project['target_price'] - $this->progressBar['collected'];
        // $this->progressBar['percent']   = ceil($target * 100 / max($project['target_price'], 1));

        $this->updateAuth();
    }

    public function getTotalAmtProperty()
    {
        return $this->donationAmt + $this->donation_gift;
    }

    public function render()
    {
        return view('livewire.site.charity-project.show');
    }
}
