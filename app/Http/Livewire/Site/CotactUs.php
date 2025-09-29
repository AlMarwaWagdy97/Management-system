<?php

namespace App\Http\Livewire\Site;

use App\Models\User;
use Livewire\Component;
use App\Models\ContactUs;
use App\Notifications\createContact;
use Illuminate\Support\Facades\Notification;

class CotactUs extends Component
{
    public $full_name, $email, $subject, $message;


    public function sendForm(){
        $data =  $this->validate([
            'full_name'  => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);
        $contact_us = ContactUs::create($data);
       $this->clearForm();
       $users = User::all();
       Notification::send($users, new createContact($contact_us->id,$contact_us->email,$contact_us->subject));
       session()->flash('success' , trans('message.site.message_sucessfully') );

    }
    public function clearForm(){
        $this->full_name = '';
        $this->email = '';
        $this->subject = '';
        $this->message = '';

    }
    public function render()
    {
        return view('livewire.site.cotact-us');
    }
}
