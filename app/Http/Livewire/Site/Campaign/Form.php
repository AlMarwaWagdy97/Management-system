<?php

namespace App\Http\Livewire\Site\Campaign;

use App\Models\Decease;
use App\Traits\FileHandler;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads, FileHandler;

    public $name = "", $mobile = "", $email = "", $deceased_name = "", $relative_relation = "", $project_id = "", $target_price = "", $deceased_image = "", $description = "";

    protected function rules(){
        return [
            'name'              => 'required|min:3|string',
            'mobile'            => 'required|min:3|max:9',
            'email'             => 'required|email',
            'deceased_name'     => 'required|min:3|string',
            'relative_relation' => 'required|string',
            'project_id'        => 'required',
            'target_price'      => 'required',
            'deceased_image'    => 'required|min:3|' . ImageValidate(),
            'description'       => 'nullable|min:3|string',
        ];
    }

    public function updated($field)
    {
        $this->validateOnly($field);
    }

    public function send(){
        $data = $this->validate();
        if (isset($data['deceased_image'])){
            $data['deceased_image'] = $this->upload_file($data['deceased_image'], 'deceases', "2");
        }
        Decease::create($data);
        session()->flash('success', trans('Thank you for contacting us. We will contact you as soon as possible'));
        $this->emptyForm();
    }

    public function emptyForm(){
        $this->name = "";
        $this->mobile = "";
        $this->email = "";
        $this->deceased_name = "";
        $this->relative_relation = "";
        $this->project_id = "";
        $this->target_price = "";
        $this->deceased_image = "";
        $this->description = "";
    }

    public function render()
    {
        return view('livewire.site.campaign.form');
    }
}
