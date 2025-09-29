<?php

namespace App\Http\Livewire\Site\Volunteering;

use App\Charity\Settings\SettingSingleton;
use App\Models\Accounts;
use App\Models\LoginTypes;
use App\Models\Volunteers;
use App\Traits\FileHandler;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class JoinCommunity extends Component
{
    use WithFileUploads, FileHandler;


    public $type = "volunteer", $name, $identity, $mobile, $image, $team_name, $team_logo, $activity = "";
    public $nationality, $gender, $email, $date_of_birth, $educational_qualification, $preferred_fields = [], $preferred_times = [], $goal, $agreement = false;

    public $whatsapp = "";

    protected function rules()
    {
        $rule =  [
            'type' => 'required',
            'name' => 'required|min:3|string',
            'identity' => 'required|min:3|string',
            'mobile' => 'required|min:9|max:9',
            // 'image' => 'required|' . ImageValidate(),
            'nationality' => 'required|string',
            'gender' => 'required|string',
            'email' => 'required|email|unique:accounts,email',
            'date_of_birth' => 'required|date',
            'educational_qualification' => 'required|string',
            'preferred_fields' => 'nullable|array',
            'preferred_times' => 'nullable|array',
            'goal' => 'nullable|string',
            'agreement' => 'accepted',
        ];


        return $rule;
    }

    public function updated($field)
    {
        $this->validateOnly($field);
    }

    public function submit()
    {
        $data = $this->validate();

        DB::beginTransaction();

        if (@$data['image'] != null) {
            $data['image'] = $this->upload_file($data['image'], 'volunteer');
        }
        if (@$data['team_logo'] != null) {
            $data['team_logo'] = $this->upload_file($data['team_logo'], 'volunteer', 'team_');
        }

        $account = Accounts::where('mobile', $data['mobile'])->first();
        $data['account_id'] = $account ? $account->id : null;

        if ($data['account_id'] == null) {
            $account = Accounts::create([
                'mobile' => $data['mobile'],
                'email' => $data['email'],
                'name' => $data['name'],
            ]);
            $data['account_id'] = $account->id;
            $types = LoginTypes::whereIn('type', ['volunteers'])->pluck('id')->toArray();
            $account->types()->attach($types);
        }

        $data['status'] = 0;

        Volunteers::create([
            'account_id' => $data['account_id'],
            'type' => $data['type'],
            'name' => $data['name'],
            'identity' => $data['identity'],
            'mobile' => $data['mobile'],
            // 'image' => $data['image'],
            'team_name' => $data['team_name'] ?? null,
            'team_logo' => $data['team_logo'] ?? null,
            'email' => $data['email'],
            'nationality' => $data['nationality'],
            'gender' => $data['gender'],
            'date_of_birth' => $data['date_of_birth'],
            'educational_qualification' => $data['educational_qualification'],
            'preferred_fields' => json_encode($data['preferred_fields']),
            'preferred_times' => json_encode($data['preferred_times']),
            'goal' => $data['goal'],
            'status' => $data['status'],
        ]);

        DB::commit();

        session()->flash('success', trans('Thank you for contacting us. We will contact you as soon as possible'));
        $this->emptyForm();
        return redirect()->route('site.volunteering.index');
    }

    public function emptyForm()
    {
        $this->type = "";
        $this->name = "";
        $this->identity = "";
        $this->mobile = "";
        // $this->image = "";
        $this->team_name = "";
        $this->team_logo = "";
        $this->activity = "";
        $this->nationality = "";
        $this->gender = "";
        $this->email = "";
        $this->date_of_birth = "";
        $this->educational_qualification = "";
        $this->preferred_fields = [];
        $this->preferred_times = [];
        $this->goal = "";
        $this->agreement = false;
    }


    public function mount()
    {
        $settings = SettingSingleton::getInstance();
        $this->whatsapp = $settings->getVolunteeringData('whatsapp');
    }

    public function render()
    {
        return view('livewire.site.volunteering.join-community');
    }
}
