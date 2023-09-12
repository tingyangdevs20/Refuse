<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Admin\StoreRolesRequest;
use App\Http\Requests\Admin\UpdateRolesRequest;
use RealRashid\SweetAlert\Facades\Alert;

class RoleController extends Controller
{

    


    public function index()
    {
        // if (! Gate::allows('users_manage')) {
        //     return abort(401);
        // }

        $roles = Role::all();
        return view('back.pages.roles.index',compact('roles'));
      
    }

    /**
     * Show the form for creating new Role.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // if (! Gate::allows('users_manage')) {
        //     return abort(401);
        // }
        $permissions = Permission::get()->pluck('name', 'name');

        return view('back.pages.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created Role in storage.
     *
     * @param  \App\Http\Requests\StoreRolesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRolesRequest $request)
    {

      
        // if (! Gate::allows('users_manage')) {
        //     return abort(401);
        // }
        $role = Role::create($request->except('permission'));
        $permissions = $request->input('permission') ? $request->input('permission') : [];
        $role->givePermissionTo($permissions);
        session()->flash('success', 'Role has been created !!');

        return redirect()->route('admin.roles.index');
    }


    /**
     * Show the form for editing Role.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // if (! Gate::allows('users_manage')) {
        //     return abort(401);
        // }
       $role = Role::find($id);
        $permissions = Permission::get()->pluck('name', 'name');
      
        return view('back.pages.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update Role in storage.
     *
     * @param  \App\Http\Requests\UpdateRolesRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRolesRequest $request,  $id)
    {
        // if (! Gate::allows('users_manage')) {
        //     return abort(401);
        // }
        $role = Role::find($id);
        $role->update($request->except('permission'));
        $permissions = $request->input('permission') ? $request->input('permission') : [];
        $role->syncPermissions($permissions);
        session()->flash('success', 'Role has been updated !!');
        return redirect()->route('admin.roles.index');
    }

    public function show(Role $role)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }

        $role->load('permissions');

        return view('admin.roles.show', compact('role'));
    }


    /**
     * Remove Role from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        // if (! Gate::allows('users_manage')) {
        //     return abort(401);
        // }
        $role = Role::find($id);
        $role->delete();
        session()->flash('success', 'Role has been deleted !!');
        return redirect()->route('admin.roles.index');
    }

    /**
     * Delete all selected Role at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        Role::whereIn('id', request('ids'))->delete();

        return response()->noContent();
    }

}
