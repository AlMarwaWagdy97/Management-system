<?php

namespace App\Http\Livewire\Admin\Charity\Projects\Form;

use Livewire\Component;
use App\Models\CharityTag;
use App\Models\ExtraFields;
use App\Models\PaymentMethod;
use Livewire\WithFileUploads;
use App\Models\CharityProject;
use App\Enums\LocationTypeEnum;
use App\Enums\ProjectTypesEnum;
use Illuminate\Validation\Rule;
use App\Models\CategoryProjects;
use App\Models\ExtraFieldValues;
use App\Traits\FileHandler;

class Info extends Component
{
    use WithFileUploads, FileHandler;

    public $categories = "", $payments = "", $projectTags = [],
     $donation_type = "", $share_name = [], $share_value = [], $fixed_value, $donation_name = [], $donation_value = [],
     $project_types = "", $type = "", $category_id = "", $tags = [], $paymentExist = false, $extrafields = [], $extrafieldsvalues = [];

    public $inputsShare = [], $inputsUnit = [];

    public function mount(){
        $this->categories = [];
        $this->projectTags = CharityTag::query()->with('trans')->get();
        $this->payments = PaymentMethod::query()->with('trans')->get();
    }


    public function render(){
        return view('livewire.admin.charity.form.info');
    }


    public function updated($field){
        $this->validateOnly($field);
    }

    // validate  -------------------------------------------------------------------------------------------------------------
    protected function rules() {
        $req = [];
        foreach (config('translatable.locales') as $locale) {
            $req += ['title.' .$locale => 'required'];
            $req += ['slug.' .$locale => 'nullable'];
            $req += ['description.' .$locale => 'nullable'];
            $req += ['meta_title.' .$locale => 'nullable'];
            $req += ['meta_description.' .$locale => 'nullable'];
            $req += ['meta_key.' .$locale => 'nullable'];
            $req += ['unit_price.' . $locale => 'nullable'];
        }
        $req += ['number'               => 'nullable'];
        $req += ['beneficiary'          => 'nullable'];
        $req += ['project_types'        => 'required|' . Rule::in(ProjectTypesEnum::values()) ];
        $req += ['category_id'          => 'required'];
        $req += ['tags'                 => 'nullable'];
        $req += ['sort'                 => 'nullable'];
        $req += ['start_date'           => 'nullable'];
        $req += ['end_date'             => 'nullable'];
        $req += ['status'               => 'nullable'];
        $req += ['feature'              => 'nullable'];
        $req += ['finished'             => 'nullable'];
        $req += ['extrafieldsvalues'    => 'nullable'];
        $req += ['extrafieldsvalues_old'=> 'nullable'];
        $req += ['type'                 => 'required|' . Rule::in(LocationTypeEnum::values()) ];
        if($this->type == "SINGLE"){
            $req += ['payment_method'   => 'required'];
        }
        $req += ['donation_type'        => 'required'];
        if($this->donation_type == "share"){
            $req += ['share_name'       => 'required'];
            $req += ['share_value'      => 'required'];
        }
        else if($this->donation_type == "unit"){
            $req += ['donation_name'    => 'required'];
            $req += ['donation_value'   => 'required'];
        }
        else if($this->donation_type == "fixed"){
            $req += ['fixed_value'      => 'required'];
        }
        $req += ['target_price'         => 'nullable'];
        $req += ['target_unit'          => 'nullable'];
        $req += ['fake_target'          => 'nullable'];
        $req += ['images'               => 'nullable|'];
        $req += ['cover_image'          => 'nullable'];
        $req += ['background_image'     => 'nullable'];
        $req += ['background_color'     => 'nullable'];
        return $req;
    }

    // getSanitized  ----------------------------------------------------------------------------------------------------------
    public function getSanitized(){
        $data = $this->validate();
        foreach(config('translatable.locales') as $locale){
            $data[$locale]['title'] = $data['title'][$locale];
            $data[$locale]['slug'] = $data['slug'][$locale] ?? null;
            $data[$locale]['description'] = @$data['description'][$locale] ?? null;
            $data[$locale]['meta_title'] = @$data['meta_title'][$locale] ?? null;
            $data[$locale]['meta_description'] = @$data['meta_description'][$locale]?? null;
            $data[$locale]['meta_key'] = @$data['meta_key'][$locale] ?? null;
            $data[$locale]['unit_price'] = @$data['unit_price'][$locale] ?? null;
        }
        unset($data['title']);  unset($data['slug']); unset($data['description']); unset($data['unit_price']);
        unset($data['meta_title']); unset($data['meta_description']); unset($data['meta_key']);

        $data['status'] = isset($data['status']) ? true : false;
        $data['feature'] = isset($data['feature']) ? true : false;
        $data['finished'] = isset($data['finished']) ? true : false;
        $data['created_by']  = @auth()->user()->id;
        if (request()->isMethod('PUT')) {
            $data['updated_by']  = @auth()->user()->id;
        } else {
            $data['created_by']  = @auth()->user()->id;
        }

        return $data;
    }

    public function store($submit){

        $data = $this->getSanitized();
        //  save imaages 
        if ($data['cover_image'] != null) {
            $data['cover_image'] = $this->upload_file($data['cover_image'], ('Charity_Project'), 'a');
        }
        if ($data['background_image'] != null) {
            $data['background_image'] = $this->upload_file($data['background_image'], ('Charity_Project'), 'b');
        }
      
        // Save donation_type
        $newarr = [];
        if ($data['donation_type'] != null) {
            if ($data['donation_type'] == 'share') {
                foreach ($data['share_name'] as $key => $value) {
                    $newarr['data'][] = [
                        'name' => $value,
                        'value' => $data['share_value'][$key],
                    ];
                }
                $newarr  = ["type" => $data['donation_type']] + $newarr;
            } elseif ($data['donation_type'] == 'unit') {

                foreach ($data['donation_name'] as $key => $value) {
                    $newarr['data'][] = [
                        'name' => $value,
                        'value' => $data['donation_value'][$key],
                    ];
                }
                $newarr  = ["type" => $data['donation_type']] + $newarr;
            } elseif ($data['donation_type'] == 'fixed') {
                $newarr['data'] = $data['fixed_value'];
                $newarr  = ["type" => $data['donation_type']] + $newarr;
            } elseif ($data['donation_type'] == 'open') {
                $newarr['type'] = $data['donation_type'];
            }
            $newarr =  json_encode($newarr);
        }
        $data['donation_type'] = $newarr;
        // store extra field
        $charity_project =  CharityProject::create($data);
        if($data['extrafieldsvalues'] != null){
            foreach($data['extrafieldsvalues']  as $key => $field){
                // check if is image
                if(is_file($data['extrafieldsvalues'][$key])){
                    $field = $this->upload_file($data['extrafieldsvalues'][$key] , ('Charity_Project'));
                }
                $extrafield = ExtraFields::query()->where('project_types', $data['project_types'])->where('title', $key )->get()->first();
                ExtraFieldValues::create([
                    'extra_field_id' => $extrafield->id,
                    'project_id' => $charity_project->id,
                    'value' =>  $field,
                ]);
            }
        }

        // insert to table charity_project_tags
        if ($this->tags != null) {
            $charity_project->tags()->attach($this->tags);
        }
        // insert to table charity_payment_projects
        if ($this->payment_method != null) {
            $charity_project->payment()->attach($this->payment_method);
        }
        session()->flash('success' , trans('message.admin.created_sucessfully') );
        $this->clearForm();
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        if ($submit != "save_new") {
            return redirect()->route('admin.charity.projects.index');
        }

    }

    public function edit(){
        $charityProject = $this->charityProject;
        foreach(config('translatable.locales') as $locale){
            dump($charityProject->translate($locale)->description);
            $this->title[$locale] = $charityProject->translate($locale)->title;
            $this->slug[$locale] = $charityProject->translate($locale)->slug;
            $this->description[$locale] = $charityProject->translate($locale)->description;
            $this->unit_price[$locale] = $charityProject->translate($locale)->unit_price;
            $this->meta_title[$locale] = $charityProject->translate($locale)->meta_title;
            $this->meta_key[$locale] = $charityProject->translate($locale)->meta_key;
            $this->meta_description[$locale] = $charityProject  ->translate($locale)->meta_description;
        }
        $this->number = @$charityProject->number;
        $this->beneficiary = @$charityProject->beneficiary;
        $this->sort = @$charityProject->sort;
        $this->start_date = @$charityProject->start_date;
        $this->end_date = @$charityProject->end_date;
        $this->status = @$charityProject->status;
        $this->feature = @$charityProject->feature;
        $this->finished = @$charityProject->finished;
        $this->target_price = @$charityProject->target_price;
        $this->target_unit = @$charityProject->target_unit;
        $this->fake_target = @$charityProject->fake_target;
        $this->images = @$charityProject->images;
        $this->cover_image = @$charityProject->cover_image;
        $this->background_image = @$charityProject->background_image;
        $this->background_color = @$charityProject->background_color;

        $this->project_types = @$charityProject->project_types;
        $this->category_id = @$charityProject->category_id;
        $this->donation_type = json_decode(@$charityProject->donation_type)->type;
        $this->type = @$charityProject->type;
        $this->tags = @$charityProject->tags?->pluck('id')->toArray();   
        
        if($this->type == "SINGLE"){
            $this->paymentExist = true; 
            $this->payment_method = @$charityProject->payment?->pluck('id')->toArray();
        }
        if($this->donation_type == "share"){
            $share = json_decode(@$charityProject->donation_type)->data;
            if($share){
                foreach($share as $item){
                    $this->inputsShare[] = '';
                    $this->share_name[] = $item->name;
                    $this->share_value[] = $item->value; 
                }

            }
        }
        if($this->donation_type == "fixed"){
            $this->fixed_value = json_decode(@$charityProject->donation_type)->data;
        }
        if($this->donation_type == "unit"){
            $share = json_decode(@$charityProject->donation_type)->data;
            if($share){
                foreach($share as $item){
                    $this->inputsUnit[] = '';
                    $this->donation_name[] = $item->name;
                    $this->donation_value[] = $item->value; 
                }

            }
        }
        $this->projectTags = CharityTag::query()->with('trans')->get();
        $this->payments = PaymentMethod::query()->with('trans')->get();
        $this->categories = CategoryProjects::query()->with('trans')->where('project_types', $this->project_types)->get();
        $this->extrafields = ExtraFields::query()->where('project_types', $this->project_types)->get();
        if($charityProject->extraFields != null){
            foreach( $charityProject->extraFields as $key => $field ){
                $this->extrafieldsvalues_old[$field->id] = $field->value;
            }
        }
    }

    public function update($submit ){
        $data = $this->getSanitized();

        $charityProject = $this->charityProject;
        if (is_file($data['cover_image'])) {
            $this->delete_file($charityProject->cover_image);
            $data['cover_image'] = $this->cover_image = $this->upload_file($data['cover_image'], ('Charity_Project'));
        }
        if (is_file($data['background_image'])) {
            $this->delete_file($charityProject->background_image);
            $data['background_image'] = $this->background_image = $this->upload_file($data['background_image'], ('Charity_Project'));
        }

        $newarr = [];
        if ($data['donation_type'] != null) {
            if ($data['donation_type'] == 'share') {
                foreach ($data['share_name'] as $key => $value) {
                    $newarr['data'][] = [
                        'name' => $value,
                        'value' => $data['share_value'][$key],
                    ];
                }
                $newarr  = ["type" => $data['donation_type']] + $newarr;
            } elseif ($data['donation_type'] == 'unit') {

                foreach ($data['donation_name'] as $key => $value) {
                    $newarr['data'][] = [
                        'name' => $value,
                        'value' => $data['donation_value'][$key],
                    ];
                }
                $newarr  = ["type" => $data['donation_type']] + $newarr;
            } elseif ($data['donation_type'] == 'fixed') {
                $newarr['data'] = $data['fixed_value'];
                $newarr  = ["type" => $data['donation_type']] + $newarr;
            } elseif ($data['donation_type'] == 'open') {
                $newarr['type'] = $data['donation_type'];
            }
            $newarr =  json_encode($newarr);
        }
        $data['donation_type'] = $newarr;
        $charityProject->update($data);
        if(isset($data['extrafieldsvalues_old'])){
            foreach($data['extrafieldsvalues_old']  as $key => $field){
                $extra = $charityProject->extraFields->where('id', $key)->first();
                if(is_file($data['extrafieldsvalues_old'][$key])){
                    $this->delete_file($extra->value);
                    $field = $this->upload_file($data['extrafieldsvalues_old'][$key] , ('Charity_Project'));
                }
                $extra->value  = $field;
                $extra->save();
            }
        }
        if($data['extrafieldsvalues'] != []){
            $charityProject->extraFields->each->delete();
            foreach($data['extrafieldsvalues']  as $key => $field){
                // check if is image
                if(is_file($data['extrafieldsvalues'][$key])){
                    $field = $this->upload_file($data['extrafieldsvalues'][$key] , ('Charity_Project'));
                }
                $extrafield = ExtraFields::query()->where('project_types', $data['project_types'])->where('title', $key )->get()->first();
                ExtraFieldValues::create([
                    'extra_field_id' => $extrafield->id,
                    'project_id' => $charityProject->id,
                    'value' =>  $field,
                ]);
            }
        }

        // insert to table charity_project_tags
        if ($this->tags != null) {
            $charityProject->tags()->sync($this->tags);
        }
        // insert to table charity_payment_projects
        if ($this->payment_method != null) {
            $charityProject->payment()->sync($this->payment_method);
        }

        session()->flash('success', trans('message.admin.updated_sucessfully'));
        if ($submit != "save_update") {
            return $this->mount();
        }
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
