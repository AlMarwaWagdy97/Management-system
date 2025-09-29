<?php

namespace App\Http\Controllers\Admin\Authorizations;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CMS\RolesRequest;

class RolesController extends Controller
{
    public function __construct()
    {
        $model = Permission::query()->get();
        syncPermisions($model);
    }

    public function index()
    {
        $items = Role::query()->with('permissions:name')->paginate($this->pagination_count);
        return view('admin.dashboard.authorization.roles.index' , compact('items')); 
       }


    public function create()
    {
        $permissions = Permission::query()->get();
        return view('admin.dashboard.authorization.roles.create', compact('permissions') );
    }

    public function store(RolesRequest $request)
    {
        $data = $request->getSanitized();
        $role = Role::create(['name'=>$data['name'], 'guard_name'=> 'account']);
        $role->permissions()->attach($data['permissions']);
        session()->flash('success' , trans('message.admin.created_sucessfully') );
        if(request()->submit == "new"){ return  redirect()->back();}
        return redirect()->route('admin.roles.index');    
    }


    public function show(Role $Role)
    {
        return view('admin.dashboard.authorization.roles.show' , compact('Role'));
    }


    public function edit(Role $Role)
    {
        $permissions = Permission::with('permissions')->get();
        return view('admin.dashboard.authorization.roles.edit' , compact('Role','permissions'));
    }


    public function update(RolesRequest $request,Role $Role)
    {
        $data = $request->getSanitized();
        $Role->update( $data);
        $Role->syncPermissions( $data['permissions']);
        session()->flash('success' , trans('message.admin.updated_sucessfully') );
        if(request()->submit == "update"){ return  redirect()->back();}
        return redirect()->route('admin.roles.index');  
    }


    public function destroy(Role $Role)
    {
        if($Role->id == 1 ){
            session()->flash('warning' , trans('message.admin.cant_delete') );
            return redirect()->back();
        }
        try {
            $Role->delete();
        } catch (\Exception $e) {
        }
        session()->flash('success' , trans('message.admin.deleted_sucessfully') );
        return back();   
     }
}
