<?php

namespace App\Http\Livewire\Site;

use Livewire\Component;
use App\Models\Subscribe;

class FormSubscribe extends Component
{
    public $email;
    public function send(){
        $data = $this->validate([
            'email'=> 'required|email'
        ]);
        Subscribe::create($data);
       session()->flash('success' , trans('message.site.message_sucessfully') );
        $this->email = null;
    }
    public function render()
    {
        return view('livewire.site.form-subscribe');
    }
}
