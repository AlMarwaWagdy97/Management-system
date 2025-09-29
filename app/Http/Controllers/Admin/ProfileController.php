<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfileRequest;
use App\Models\Accounts;

class ProfileController extends Controller
{

    public function index()
    {
        if($auth = auth('account')->user()?->types->where('type', 'admin')->first()){
            $user = Accounts::findOrFail($auth->id);
        }
        else{
            return abort(404);
        }
        $roles = Role::query()->select(['name'])->get();
        return view('admin.dashboard.profile.index',compact('user', 'roles'));
    }

    public function update(ProfileRequest $request)
    {
        if($auth = auth('account')->user()?->types->where('type', 'admin')->first()){
            $user = Accounts::findOrFail($auth->id);
            $data = $request->getSanitized();
            $data['password'] = $data['password']? bcrypt($data['password']) : $user->password;
            if($request->hasFile('image')){
                $this->delete_file($user->image);
                $data['image'] = $this->upload_file($request->file('image') , ('users'));
            }
            $user->update($data);
            session()->flash('success' , trans('message.admin.updated_sucessfully') );
            return  redirect()->back();
        }
        else{
            return abort(404);
        }
    }

}
