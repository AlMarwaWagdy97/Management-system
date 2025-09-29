<?php

namespace App\Http\Livewire\Site;

use App\Models\ContactUs as ModelsContactus;
use Livewire\Component;

class ContactUs extends Component
{

    public $full_name = "", $phone = "", $email = "", $type = "", $title = "", $city = "", $message = "";

    protected function rules(){
        return [
            'full_name'     => 'required|min:3',
            'phone'         => 'required|min:9|max:9',
            'email'         => 'required|email',
            'type'          => 'required|min:3',
            'title'         => 'required|min:3',
            'city'          => 'required|min:3',
            'message'       => 'required|min:3|string',
        ];
    }

    public function updated($field)
    {
        $this->validateOnly($field);
    }

    public function send(){
        $data = $this->validate();
        ModelsContactus::create($data);
        session()->flash('success', trans('Thank you for contacting us. We will contact you as soon as possible'));
        $this->emptyForm();
    }

    public function emptyForm(){
        $this->full_name = "";
        $this->phone = "";
        $this->email = "";
        $this->type = "";
        $this->title = "";
        $this->city = "";
        $this->message = "";
    }

    public function render()
    {
        return view('livewire.site.contact-us');
    }

    
}
