<?php

namespace App\Http\Livewire\Admin\Charity\Volunteers;

use App\Models\Accounts;
use Livewire\Component;

class Create extends Component
{
    public $new = false;
    public $volunteer;
    public $users = [];
    public $search_users;
    public $msg = null;

    public function Selectuser($user)
    {
        $this->volunteer =  $user;
        $this->reseting();
    }
    public function reseting()
    {
        $this->volunteer = null;
        $this->users = [];
        $this->search_users = null;
    }



    public function updatedSearchUsers()
    {
        if (strlen($this->search_users) > 3) {
            $this->users = Accounts::where('user_name', 'like', '%' . trim($this->search_users) . '%')->limit(6)->get();
            $this->new = false;
        }

        if (!$this->users) {
            $this->msg = 'user not found';
        }
    }

    public function NewUser()
    {
        $this->new = true;
    }

    public function render()
    {
        return view('livewire.admin.charity.volunteers.create');
    }
}
