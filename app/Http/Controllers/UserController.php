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
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Mail\TestEmail;
use Illuminate\Support\Facades\Mail;
class UserController extends Controller
{

    public function index()  {
        if (! Gate::allows('administrator') ||  !Gate::allows('user_module')||  !Gate::allows('access_all')) {
            return abort(401);
        }

        $superAdminRole = Role::where('name', 'Super Admin')->first();

        if ($superAdminRole) {

            $users = User::whereDoesntHave('roles', function ($query) use ($superAdminRole) {
                $query->where('name', $superAdminRole->name);
            })->get();
        } else {

            $users = User::all();
        }

        return view('back.pages.userlist.index',compact('users'));

    }

    public function create()  {

        $roles = Role::get()->pluck('name', 'name');

        return view('back.pages.userlist.create',compact('roles'));

    }

    public function store(Request $request)  {
// return "Tes";
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

            $token =  bin2hex(random_bytes(32));

            DB::table('password_resets')->insert([
                'email' => $validatedData['email'],
                'token' => $token,
                'created_at' => now()
              ]);
              $email = $request->email;
            //    Mail::send('email.forgetPassword', ['token' => $token], function($message) use($request){
            //     $message->to($request->email);
            //     $message->subject('Reset Password');
            // });
            $resetToken = bin2hex(random_bytes(32));

        // Replace 'your_app_url' with your actual app's URL
            $appUrl = config('app.url'); // Get the base URL from the configuration

        // Construct the reset link using the app URL
              $resetLink = "{$appUrl}/password/reset/{$resetToken}";

            Mail::send('emails.password-send', ['username' =>$validatedData['email'], 'email' => $validatedData['email'], 'resetLink' => $resetLink], function($message) use($email){
                $message->to($email);
                $message->subject('Reset Password');
            });
            

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

        return redirect()->route('admin.profile.show')->with('switchRole', 'You are currently viewing ' . $name . '.');
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
                $user->original_id = null;
                $user->save();
                session()->flash('success', 'You have switched back to your Role. !!');
                return redirect()->route('admin.user-list.index')->with('sucess', 'You have switched back to back to your Role.');

            } else {
                session()->flash('info', 'You are already in your Role. !!');
                return redirect()->route('admin.user-list.index')->with('info', 'You are already in Super Admin mode.');
            }
        } else {
            return redirect()->route('login'); // Redirect to the login page if not authenticated
        }



    }


}
