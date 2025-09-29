<?php

namespace App\Http\Livewire\Admin\Charity\Projects\Form;

use Livewire\Component;
use App\Models\CharityTag;
use App\Models\ExtraFields;
use App\Models\PaymentMethod;
use Livewire\WithFileUploads;
use App\Models\CategoryProjects;

class InfoEdit extends Component
{
    use WithFileUploads;

    public $charityProject, $categories = "", $payments = "", $projectTags = [], $donation = [],
     $donation_type = "", $share_name = [], $share_value = [], $fixed_value, $donation_name = [], $donation_value = [],
     $project_types = "", $type = "", $category_id = "", $tags = [], $paymentExist = false, $extrafields = [], $extrafieldsvalues = [];

     public $inputsShare = [], $inputsUnit = [];

     
     public function mount(){
        $this->donation = json_decode( $this->charityProject->donation_type, true);
        $this->donation_type = @$this->donation["type"];
        $this->project_types = $this->charityProject->project_types;
        $this->category_id = $this->charityProject->category_id;
        $this->type          = $this->charityProject->type;

        if($this->type == "SINGLE") $this->paymentExist = true;
        else $this->paymentExist = false;

        if($this->donation_type == "share"){
            foreach($this->donation['data'] as $key => $item){
                $this->inputsShare[] = '';
                $this->share_name[] = $item['name'];
                $this->share_value[] = $item['value'];
            }
        }
        elseif($this->donation_type == "unit"){
            foreach($this->donation['data'] as $key => $item){
                $this->inputsUnit[] = '';
                $this->donation_name[] = $item['name'];
                $this->donation_value[] = $item['value'];
            }
        }
        elseif($this->donation_type == "fixed"){
            $this->fixed_value = $this->donation['data'];
        }
        $this->categories = CategoryProjects::query()->with('trans')->where('project_types', $this->project_types)->get();
        $this->projectTags = CharityTag::query()->with('trans')->get();
        $this->payments = PaymentMethod::query()->with('trans')->get();
    }

    public function render()
    {
        return view('livewire.admin.charity.form.info-edit');
    }

    public function updateProjectTypes(){
        $this->categories = CategoryProjects::query()->with('trans')->where('project_types', $this->project_types)->get();
        $this->extrafields = ExtraFields::query()->where('project_types', $this->project_types)->get();
    }
    
    public function updateType($value){
        if($value == "SINGLE") $this->paymentExist = true;
        else $this->paymentExist = false;
    }


     
    public function addShareInput()
    {
        $this->inputsShare[] = '';
    }
    
    public function removeShareInput($key)
    {
        unset($this->inputsShare[$key]);
    }

     
    public function addUnitInput()
    {
        $this->inputsUnit[] = '';
    }
    
    public function removeUnitInput($key)
    {
        unset($this->inputsUnit[$key]);
    }

}
