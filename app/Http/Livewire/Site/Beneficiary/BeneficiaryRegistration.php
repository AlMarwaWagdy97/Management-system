<?php

namespace App\Http\Livewire\Site\Beneficiary;

use Livewire\Component;
use App\Models\Beneficiaries;
use App\Models\Accounts;
use App\Models\LoginTypes;
use Illuminate\Support\Facades\DB;

class BeneficiaryRegistration extends Component
{
    public $first_name, $middle_name, $last_name, $gender, $nationality, $marital_status, $phone, 
           $date_of_birth, $family_members, $education_level, $city, $district, $id_number, 
           $civil_register, $email, $housing_status, $job_type, $monthly_income, 
           $previous_registration, $chronic_diseases, $special_needs, $other_income, 
           $additional_notes, $agreement;

    protected $rules = [
        'first_name' => 'required|string|max:255',
        'middle_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'gender' => 'required|in:male,female',
        'nationality' => 'required|string',
        'marital_status' => 'required|string',
        'phone' => 'required|string|max:20',
        'date_of_birth' => 'required|date',
        'family_members' => 'required|string',
        'education_level' => 'required|string',
        'city' => 'required|string',
        'district' => 'required|string',
        'id_number' => 'required|string|max:20',
        'civil_register' => 'required|string|max:20',
        'email' => 'nullable|email|max:255',
        'housing_status' => 'required|string',
        'job_type' => 'nullable|string',
        'monthly_income' => 'required|string',
        'previous_registration' => 'required|in:yes,no',
        'chronic_diseases' => 'required|in:yes,no',
        'special_needs' => 'required|in:yes,no',
        'other_income' => 'nullable|string',
        'additional_notes' => 'nullable|string',
        'agreement' => 'accepted',
    ];

    public function updated($field)
    {
        $this->validateOnly($field);
    }

    public function submit()
    {
        $this->validate();

        DB::beginTransaction();

        $account = Accounts::where('mobile', $this->phone)->first();

        if (!$account) {
            $full_name = $this->first_name . ' ' . $this->middle_name . ' ' . $this->last_name;
            $account = Accounts::create([
                'mobile' => $this->phone,
                'email' => $this->email,
                'name' => $full_name,
            ]);

            $types = LoginTypes::whereIn('type', ['beneficiaries'])->pluck('id')->toArray();
            $account->types()->attach($types);
        }

        Beneficiaries::create([
            'account_id' => $account->id,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'gender' => $this->gender,
            'nationality' => $this->nationality,
            'marital_status' => $this->marital_status,
            'phone' => $this->phone,
            'date_of_birth' => $this->date_of_birth,
            'family_members' => $this->family_members,
            'education_level' => $this->education_level,
            'city' => $this->city,
            'district' => $this->district,
            'id_number' => $this->id_number,
            'civil_register' => $this->civil_register,
            'email' => $this->email,
            'housing_status' => $this->housing_status,
            'job_type' => $this->job_type,
            'monthly_income' => $this->monthly_income,
            'previous_registration' => $this->previous_registration,
            'chronic_diseases' => $this->chronic_diseases,
            'special_needs' => $this->special_needs,
            'other_income' => $this->other_income,
            'additional_notes' => $this->additional_notes,
            'status' => 0, 
        ]);



        DB::commit();
        $this->emptyForm();

        session()->flash('success', 'تم تسجيل المستفيد بنجاح.');
            return redirect()->route('site.volunteering.index');


    }

public function emptyForm()
{
    $this->first_name = '';
    $this->middle_name = '';
    $this->last_name = '';
    $this->gender = '';
    $this->nationality = '';
    $this->marital_status = '';
    $this->phone = '';
    $this->date_of_birth = '';
    $this->family_members = '';
    $this->education_level = '';
    $this->city = '';
    $this->district = '';
    $this->id_number = '';
    $this->civil_register = '';
    $this->email = '';
    $this->housing_status = '';
    $this->job_type = '';
    $this->monthly_income = '';
    $this->previous_registration = '';
    $this->chronic_diseases = '';
    $this->special_needs = '';
    $this->other_income = '';
    $this->additional_notes = '';
    $this->agreement = false;
}


    public function render()
    {
        return view('livewire.site.beneficiary.beneficiary-registration');
    }
}