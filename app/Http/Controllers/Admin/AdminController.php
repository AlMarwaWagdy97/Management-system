<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Accounts;
use App\Models\LoginTypes;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CMS\UserStoreRequest;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = Role::all();
        // $query = User::query()->type('admin')->with('roles')->orderBy('id','ASC');
        $query = Accounts::query()->type('admin')->with('roles')->orderBy('id','ASC');

        if($request->status  != ''){
            $query->where('status', $request->status );
        }
        if($request->name  != ''){
            $query->where('name','like','%'. $request->name .'%');
        }
        if($request->email  != ''){
            $query->where('email','like','%'. $request->email .'%');
        }
        if($request->mobile  != ''){
            $query->where('mobile','like','%'. $request->mobile .'%');
        }
        
        // $user->roles
        if($request->role  != ""){
            $rolesId = $request->role;
            $query->whereHas('roles', function($q) use ($rolesId){
                $q->where('id', $rolesId);
            });
        }

        $users = $query->paginate($this->pagination_count);

            
        return view('admin.dashboard.users.index',compact('users','roles'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::query()->select(['name'])->get();
        return view('admin.dashboard.users.create', compact('roles'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $data =$request->getSanitized();
        if($request->hasFile('image')){
            $data['image'] = $this->upload_file($request->file('image') , ('users'));
        }
        $data['password'] = bcrypt($data['password']);

        $user = Accounts::create($data);
        $types = LoginTypes::query()->whereIn('type', $data['type'])->pluck('id')->toArray();
        $user->types()->attach($types);

        $user->assignRole($data['roles']);
        
        session()->flash('success' , trans('message.admin.created_sucessfully') );
        if(request()->submit == "new"){ return  redirect()->back();}
        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Accounts $user)
    {
        $roles = Role::query()->select(['name'])->get();
        return view('admin.dashboard.users.edit',compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserStoreRequest $request, Accounts $user)
    {
        $data = $request->getSanitized();
        if($user->id == 1 && !in_array('administrator', $data['roles']) ){
            session()->flash('warning' , trans('message.admin.cant_update') );
            return redirect()->back();
        }
        $data['password'] = $data['password']? bcrypt($data['password']) : $user->password;
        if($request->hasFile('image')){
            $this->delete_file($user->image);
            $data['image'] = $this->upload_file($request->file('image') , ('users'));
        }
        $user->update($data);
        $user->syncRoles($data['roles']);
        session()->flash('success' , trans('message.admin.updated_sucessfully') );
        if(request()->submit == "update"){ return  redirect()->back();}
        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Accounts $user)
    {
        if($user->id == 1){
            session()->flash('warning' , trans('message.admin.cant_delete') );
            return redirect()->back();
        }
        $this->delete_file($user->image);
        $user->delete();
        session()->flash('success' , trans('message.admin.deleted_sucessfully') );
        return redirect()->back();
    }



    public function update_status($id){
        if($id == 1 ){
            session()->flash('warning' , trans('message.admin.cant_update') );
            return redirect()->back();
        }
        $user = Accounts::findOrfail($id);
        $user->status == 1 ? $user->status = 0 : $user->status = 1;
        $user->save();
        return redirect()->back();
    }

    public function actions(Request $request){
        if($request['publish'] == 1 ){
            $users = Accounts::findMany($request['record']);
            foreach ($users as $user){
                $user->update(['status' => 1]);
            }
            session()->flash('success' , trans('pages.status_changed_sucessfully') );
        }
        if($request['unpublish'] == 1 ){
            $users = Accounts::findMany($request['record']);
            foreach ($users as $user){
                $user->update(['status' => 0]);
            }
            session()->flash('success' , trans('pages.status_changed_sucessfully') );
        }
        if($request['delete_all'] == 1 ){
            $users = Accounts::findMany($request['record']);
            foreach ($users as $user){
                $this->delete_file($user->image);
                $user->delete();
            }
            session()->flash('success' , trans('pages.delete_all_sucessfully') );
        }
        return redirect()->back();
    }
}
