<?php

namespace App\Http\Livewire\Site\Volunteering;

use App\Models\VolunteeringIdeas;
use App\Models\VoluntreerIdeaComments;
use App\Models\VoluntreerIdeaLoves;
use Livewire\Component;

class InfoIdea extends Component
{
    public $idea;
    public $ipAddress = "";
    public $showModalComent = [], $loves = [], $name = "", $comment = "";


    public function showCommentModel()
    {
        $this->showModalComent = 1;
    }
    public function closeCommentModel()
    {
        $this->showModalComent = 0;
    }
    
    protected function rules()
    {
        return [
            'name'         => 'required|min:3|string',
            'comment'      => 'required|min:3|string',
        ];
    }

    public function updated($field)
    {
        $this->validateOnly($field);
    }

    public function addComment()
    {
        $data = $this->validate();
        $data['idea_id'] = $this->idea->id;
        VoluntreerIdeaComments::create($data);
        $this->name =  "";
        $this->comment =  "";
        session()->flash('success', trans('You comment is added successfuly'));
        $this->showModalComent = 0;
        $this->idea =  VolunteeringIdeas::with('activeComments', 'loves', 'love_status')->find($this->idea->id);

    }

    public function loves()
    {
        $idea = $this->idea;//VolunteeringIdeas::with('activeComments', 'loves', 'love_status')->find($this->idea->id);
        $checkLove  = @$idea->love_status->first();
        if (!$checkLove) {
            $newlove = VoluntreerIdeaLoves::create([
                'ip_address' => $this->ipAddress,
                'idea_id' => $this->idea->id
            ]);
        } else {
            $checkLove->delete();
        }
        $this->idea =  VolunteeringIdeas::with('activeComments', 'loves', 'love_status')->find($this->idea->id);
    }


    public function mount($idea)
    {
        $this->idea = $idea;
        $this->ipAddress = request()->ip();
    }

    public function render()
    {
        return view('livewire.site.volunteering.info-idea');
    }
}
