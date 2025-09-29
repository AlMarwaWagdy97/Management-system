<?php

namespace App\Http\Livewire\Site\Volunteering;

use App\Models\VolunteeringIdeas;
use App\Models\VoluntreerIdeaComments;
use App\Models\VoluntreerIdeaLoves;
use Livewire\Component;

class Idea extends Component
{
    public $pageCount = 2;
    public $ideaCarousels = [];
    public $ideasCount, $carouselIndex = 0;

    public $ipAddress = "";

    public $showModalComent = [], $loves = [], $name = "", $comment = "";


    public function loadOrders($carouselIndex = 0)
    {
        $query = VolunteeringIdeas::with('activeComments', 'loves', 'love_status')->active()->orderBy('sort', 'ASC')->orderBy('created_at', 'desc');

        $this->ideasCount = $query->count();
        $this->ideaCarousels[$carouselIndex] = $query->offset($carouselIndex * $this->pageCount)->limit($this->pageCount)->get()->toArray();
    }

    public function showMore()
    {
        $this->loadOrders(count($this->ideaCarousels));
    }



    public function showCommentModel($id)
    {
        $this->showModalComent[$id] = 1;
    }
    public function closeCommentModel($id)
    {
        $this->showModalComent[$id] = 0;
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

    public function addComment($id)
    {
        $data = $this->validate();
        $data['idea_id'] = $id;
        VoluntreerIdeaComments::create($data);
        $this->name =  "";
        $this->comment =  "";
        session()->flash('success', trans('You comment is added successfuly'));
        $this->showModalComent[$id] = 0;
    }


    public function updateLoves($ind, $key, $id)
    {
        $idea = VolunteeringIdeas::with('activeComments', 'loves', 'love_status')->find($id);
        $checkLove  = @$idea->love_status->first();
        
        if (!$checkLove) {
            $newlove = VoluntreerIdeaLoves::create([
                'ip_address' => $this->ipAddress,
                'idea_id' => $id
            ]);
           
        } else {
            $checkLove->delete();
        }
        $this->loves[$ind][$key] = VoluntreerIdeaLoves::where('idea_id', $id)->count();
    }


    public function mount()
    {
        $this->ipAddress = request()->ip();

        $query = VolunteeringIdeas::with('activeComments', 'loves', 'love_status')->active()->orderBy('sort', 'ASC')->orderBy('created_at', 'desc');

        $this->ideaCarousels = [];
        $this->ideasCount = $query->count();
        $this->ideaCarousels[$this->carouselIndex] = $query->offset($this->carouselIndex * $this->pageCount)->limit($this->pageCount)->get()->toArray();
    }

    public function render()
    {
        return view('livewire.site.volunteering.idea');
    }
}
