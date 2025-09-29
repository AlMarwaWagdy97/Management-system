<?php

namespace App\Http\Livewire\Site;

use App\Models\Volunteers as ModelsVolunteers;
use Livewire\Component;

class Volunteers extends Component
{
    public $name = "", $identity = "", $mobile = "", $nationality = "", $gender = "", $email = "";

    protected function rules(){
        return [
            'name'           => 'required|min:3',
            'identity'       => 'required|min:3',
            'mobile'         => 'required|min:9|max:9',
            'nationality'    => 'required|min:3',
            'gender'         => 'required|min:3',
            'email'          => 'required|email',
        ];
    }

    public function updated($field)
    {
        $this->validateOnly($field);
    }


    public function send(){
        $data = $this->validate();
        ModelsVolunteers::create($data);
        session()->flash('success', trans('Thank you for contacting us. We will contact you as soon as possible'));
        $this->emptyForm();
    }


    public function emptyForm(){
        $this->name = "";
        $this->identity = "";
        $this->mobile = "";
        $this->nationality = "";
        $this->gender = "";
        $this->email = "";
    }

    public function render()
    {
        return view('livewire.site.volunteers');
    }
}
