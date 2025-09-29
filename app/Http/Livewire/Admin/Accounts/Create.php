<?php

namespace App\Http\Livewire\Admin\Accounts;

use App\Models\Accounts;
use Livewire\Component;

class Create extends Component
{
    public $new = false;
    public $show_password = false;
    public $user;
    public $accounts = [];
    public $search_accounts ="";
    public $msg = "";
    public $mobile = ""; 
    public $mobileWithCode = ""; 

    // Khadija Ismaile
    public function mount($id = null, $passwordShow = true){   
        $this->user = Accounts::find($id);
        $this->show_password = $passwordShow; 
    }

    public function selectAccount($user)
    {
        $this->user =  $user;
        $this->reseting();
    }
    public function reseting()
    {
        $this->accounts = [];
        $this->search_accounts = null;
    }

    public function updatedSearchAccounts(
        
    )
    {
        if (strlen($this->search_accounts) > 3) {
            $this->accounts = Accounts::where('user_name', 'like', '%' . trim($this->search_accounts) . '%')
            ->orWhere('email', trim($this->search_accounts))->orWhere('mobile', 'like', '%'. trim($this->search_accounts). '%')->limit(6)->get();
            $this->new = false;
        }

        if (!$this->accounts) {
            $this->msg = 'user not found';
        }
    }

    public function newAccount()
    {
        $this->new = true;
        $this->msg = "";
        $this->reseting();
    }

    public function render()
    {
        return view('livewire.admin.accounts.create');
    }
}
