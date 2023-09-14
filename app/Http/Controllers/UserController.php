<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; // Import DB facade
use Illuminate\Support\Facades\Storage; // Import Storage facade
use Spatie\Permission\Models\Role; // Import the Role model from Spatie
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Admin\StoreUsersRequest;
use App\Http\Requests\Admin\UpdateUsersRequest;

class UserController extends Controller
{
    public function index()  {
        if (! Gate::allows('administrator') ||  !Gate::allows('user_module')||  !Gate::allows('access_all')) {
            return abort(401);
        }

        $users = User::all();

        return view('back.pages.userlist.index',compact('users'));

    }

    public function create()  {
       
        $roles = Role::get()->pluck('name', 'name');

        return view('back.pages.userlist.create',compact('roles'));

    }

    public function store(Request $request)  {

            // Validate the form data
            $validatedData = $request->validate([
                'username' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'roles' => 'required',
                'user_status' => 'required',
                'password' => 'required|min:6|confirmed',
                'roles' => 'array',
            ]);
            $validatedData['time_zone'] = 'Asia/Kolkata';

            // Create a new user instance
            $user = new User([
                'name' => $validatedData['username'],
                'email' => $validatedData['email'],
                'status' => $validatedData['user_status'],
                'password' => Hash::make($validatedData['password']),
                'time_zone' => $validatedData['time_zone'],
            ]);

            // Save the user data
            $user->save();

            // Assign roles using Spatie's role package
            if ($request->input('roles')) {
                $roles = $request->input('roles') ? $request->input('roles') : [];
                $user->assignRole($roles);
            }
            session()->flash('success', 'User has been created !!');
            return redirect()->route('admin.user-list.index');


    }

    public function edit( $id)
    {
      
        $user = User::find($id);
        $roles = Role::get()->pluck('name', 'name');

        return view('back.pages.userlist.edit', compact('user', 'roles'));

    }

    public function update(Request $request, $id)
    {

        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'user_status' => 'required|in:0,1',
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'array',
        ]);

        $user = User::findOrFail($id);

        $user->name = $validatedData['username'];
        $user->email = $validatedData['email'];
        $user->status = $validatedData['user_status'];

        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }

        // Save the user data
        $user->save();

        // Assign roles using Spatie's role package
        if ($request->input('roles')) {
            $roles = $request->input('roles') ? $request->input('roles') : [];
            $user->syncRoles($roles);
        }

        session()->flash('success', 'User has been updated !!');
        return redirect()->route('admin.user-list.index');
    }

    public function destroy( $id)
    {
        
        $user = User::find($id);
        $user->delete();
        session()->flash('success', 'User has been deleted !!');
        return redirect()->route('admin.user-list.index');
    }

    public function switchRole(User $user)
    {
        $superAdmin = Auth::user();

       

    // Ensure the user performing the switch is a super admin
    if ($superAdmin->hasRole('Administrator') && $superAdmin->id !== $user->id) {
       
        // Set the original_id to the super admin's ID
        $user->original_id = $superAdmin->id;
        $user->save();

        // Log the super admin out
        Auth::logout();

        // Log in as the selected user
        Auth::login($user);

        $name = auth()->user()->name;

        // Redirect to the dashboard or wherever you want
        
        return redirect()->route('admin.profile.show')->with('switchRole', 'You are currently viewing ' . $name . ' as an account administrator.');
    }

    return redirect()->back()->with('error', 'You do not have permission to switch roles.');
    }

    public function quitRole()
    {

        if (Auth::check()) {
            $user = Auth::user();
    
            if ($user->hasSwitchedRole()) {
                // Log out of the switched role and back to the super admin
                Auth::logout();
                Auth::loginUsingId($user->original_id);
                session()->flash('success', 'You have switched back to Super Admin. !!');
                return redirect()->route('admin.user-list.index')->with('sucess', 'You have switched back to Super Admin.');

            } else {
                session()->flash('info', 'You are already in Super Admin mode. !!');
                return redirect()->route('admin.user-list.index')->with('info', 'You are already in Super Admin mode.');
            }
        } else {
            return redirect()->route('login'); // Redirect to the login page if not authenticated
        }
      
    
        
    }


}
