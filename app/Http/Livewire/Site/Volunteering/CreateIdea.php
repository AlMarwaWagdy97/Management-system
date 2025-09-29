<?php

namespace App\Http\Livewire\Site\Volunteering;

use App\Models\VolunteeringIdeas;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CreateIdea extends Component
{
    public  $name = "", $subject = "", $message = "";


    protected function rules()
    {
        return 
        [
            'name'         => 'required|min:3|string',
            'subject'      => 'required|min:3|string',
            'message'      => 'required|min:3|string',
        ];
    }

    public function updated($field)
    {
        $this->validateOnly($field);
    }

    public function submit()
    {
        DB::beginTransaction();

        $data = $this->validate();
        $data['status'] = 0;

        VolunteeringIdeas::create($data);

        DB::commit();
        DB::rollBack();
        
        session()->flash('success', trans('The idea has been successfully send'));
        $this->emptyForm();
    }

    public function emptyForm()
    {
        $this->name = "";
        $this->subject = "";
        $this->message = "";
    }

    public function render()
    {
        return view('livewire.site.volunteering.create-idea');
    }
}
