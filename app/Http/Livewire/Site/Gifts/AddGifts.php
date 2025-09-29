<?php

namespace App\Http\Livewire\Site\Gifts;

use App\Charity\Settings\SettingSingleton;
use Livewire\Component;

class AddGifts extends Component
{

    public $cardFields = [], $fields = [], $cardInfo = [], $fieldInfo = [];

    public $cards, $cardImages = "", $cardInfoMessage, $errorIndex = "";
    public $project, $giftType, $donation, $colorsAmount, $giftStatus = 0, $colors;

    protected $listeners = ['updateMessageCard', 'finishedSaveGifts', 'UpdategiftStatus'];

    public function startGift()
    {
        // $this->emit('donationStatus', $this->giftStatus);
        if ($this->giftStatus) {
            $this->addField();
            $this->render();
        } else {
            $this->cardFields = [];
            $this->cardInfo = [];
            session()->put('card', []);
        }
        $this->emit('updateGiftInfo', $this->cardInfo);
    }

    public function addField()
    {
        foreach ($this->cardInfo as $index => $info) {
            if ($info['saved'] == false) {
                $this->cardInfoMessage = trans('Please save this card first');
                return $this->errorIndex = $index;
            }
        }
        $this->cardFields[] = $this->fields;
        $this->cardInfo[] = $this->fieldInfo;
        $this->emit('updateGiftInfo', $this->cardInfo);
    }

    public function selectGiftType($index)
    {
        if ($this->cardFields[$index]['giftType'] != "") {
            $selectedCard =  json_decode($this->cards, true)[$this->cardFields[$index]['giftType']];
            $this->cardFields[$index]['cardTitle'] = $selectedCard['title_' . app()->getLocale()];
            $this->cardInfo[$index]['cardImages'] =  $selectedCard['images'];
        } else {
            $this->cardFields[$index]['cardTitle'] = "";
            $this->cardInfo[$index]['cardImages'] = "";
        }
        $this->emit('updateGiftInfo', $this->cardInfo);
    }

    public function updateDonation($index)
    {
        switch ($this->donation['type']) {
            case ('unit'):
                if ($this->cardFields[$index]['unitValueInput'] != 0) {
                    $this->cardFields[$index]['donationAmt'] = $this->cardFields[$index]['unitValueInput'];
                    $this->cardFields[$index]['donationtype'] = @$this->project->trans->where('locale', app()->getLocale())->first()?->title;
                } else {
                    $data = json_decode($this->cardFields[$index]['unitValueRadio']);
                    $this->cardFields[$index]['donationAmt'] = @$data->value;
                    $this->cardFields[$index]['donationtype'] = @$data->name;
                }
                break;
            case ('share'):
                $data = json_decode($this->cardFields[$index]['shareValue']);
                $this->cardFields[$index]['donationAmt'] = @$data->value;
                $this->cardFields[$index]['donationtype'] = @$data->name;
                break;
            case ('open'):
                $this->cardFields[$index]['donationAmt'] = $this->cardFields[$index]['openValue'];
                break;
        }
        $this->emit('updateGiftInfo', $this->cardInfo);
        $this->emit('updateDynamicGiftAmount', $this->cardFields[$index]['donationAmt']);
    }

    public function removeField($index)
    {
        unset($this->cardFields[$index]);
        unset($this->cardInfo[$index]);
        $this->cardFields = array_values($this->cardFields);
        $this->cardInfo = array_values($this->cardInfo);
        $cards = session()->get('card');
        unset($cards[$index]);
        session()->put('card', $cards);
        if (count($this->cardFields) == 0) {
            $this->giftStatus = false;
        }
        if (@$this->cardInfo[$index]['saved']) {
            $amount = $this->cardFields[$index]['donationAmt'] == "" ? 0 : -$this->cardFields[$index]['donationAmt'] ?? 0;

            $this->emit('updateGiftInfo', $this->cardInfo, $amount);
        }
        $this->emit('updateDynamicGiftAmount', 0);
    }


    public function UpdategiftStatus($val)
    {
        $this->giftStatus = $val;
    }

    public function saveGiftInfo($index)
    {
        $card = $this->cardFields[$index];

        if (empty($card['giver_mobile']) || !preg_match('/^[0-9]{9}$/', $card['giver_mobile'])) {
            $this->cardInfoMessage = trans('رقم الجوال مطلوب');
            $this->errorIndex = $index;
            return;
        }

        if (!empty($card['giver_email']) && !filter_var($card['giver_email'], FILTER_VALIDATE_EMAIL)) {
            $this->cardInfoMessage = trans('بريد إلكتروني غير صحيح');
            $this->errorIndex = $index;
            return;
        }

        if (empty($card['donationAmt']) || empty($card['giver_name']) || empty($card['image'])) {
            $this->cardInfoMessage = trans('برجاء إدخال الاسم والمبلغ والصورة');
            $this->errorIndex = $index;
            return;
        }

        session()->put('card.' . $index, $card);
        $this->cardInfo[$index]['saved'] = true;
        $this->emit('updateGiftInfo', $this->cardInfo, $card['donationAmt']);
        $this->emit('updateDynamicGiftAmount', 0);
    }


    public function updateMessageCard($index, $msg)
    {
        $this->cardInfoMessage = $msg;
        $this->errorIndex = $index;
    }

    public function finishedSaveGifts()
    {
        $this->cardFields = [];
        $this->cardInfo = [];
        $this->render();
    }

    public function mount()
    {
        $settings = SettingSingleton::getInstance();
        $this->colors = $settings->getColor('donation_color');

        session()->put('card', []);

        $this->fields = [
            'donationAmt' => '',
            'donationtype' => '',
            'giver_name' => '',
            'giver_mobile' => '',
            'giver_email' => '',
            'image' => '',
            'cardTitle' => '',
            'sendCopy' => '',
        ];

        $this->fieldInfo = [
            'cardImages' => '',
            'saved' => false,
        ];

        switch ($this->donation['type']) {
            case ('unit'):
                $this->fields['unitValueRadio'] = 0;
                $this->fields['unitValueInput'] = 0;
                break;

            case ('share'):
                $this->fields['shareValue'] = 0;
                break;

            case ('fixed'):
                $this->fields['donationtype'] =  @$this->project->trans->where('locale', app()->getLocale())->first()?->title;
                $this->fields['donationAmt'] = $this->donation['data'];
                break;

            case ('open'):
                $this->fields['donationtype'] =  @$this->project->trans->where('locale', app()->getLocale())->first()?->title;
                $this->fields['openValue'] = 0;
                break;

            default:
        }
    }

    public function render()
    {
        return view('livewire.site.gifts.add-gifts');
    }
}
