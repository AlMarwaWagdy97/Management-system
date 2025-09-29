<?php

namespace App\Http\Livewire\Site\Carts;

use Livewire\Component;

class AddModal extends Component
{
    protected $listeners = ['showModel'];

    public $showModal = false;
    
    public $message = null;

    
    public function showModel($message = null)
    {
        $this->message = $message;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    
    public function render()
    {
        return view('livewire.site.carts.add-modal');
    }
}
