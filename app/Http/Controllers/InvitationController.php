<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Invitation;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; // Import DB facade
use Illuminate\Support\Facades\Storage; // Import Storage facade
use Spatie\Permission\Models\Role;
use App\Mail\TestEmail;
use Illuminate\Support\Facades\Mail;

class InvitationController extends Controller
{
    public function index()
    {
        $invitation = user::all();
        return view('back.pages.invitation.index', compact('invitation'));
    }


    public function create()
{
    return view('invitation.create');
}

public function store(Request $request)
{
    $request->validate([
        'email' => 'required|email|unique:invitations',
    ]);

    $token =  bin2hex(random_bytes(32));
    $invitation = Invitation::create([
        'email' => $request->email,
        'token' => $token,
    ]);
    $user = new User([
        'name' => $request->name,
        'email' => $request->email,
        'remember_token'=> $token,
         'status' => '1',
        'password' => Hash::make($request['username'].'123456'),
        'time_zone' => now(),
    ]);



     // Save the user data
     $user->save();


     DB::table('password_resets')->insert([
         'email' => $request->email,
         'token' => $token,
         'created_at' => now()
       ]);
       $email = $request->email;
    
     $resetToken = bin2hex(random_bytes(32));

 // Replace 'your_app_url' with your actual app's URL
     $appUrl = config('app.url'); // Get the base URL from the configuration

 // Construct the reset link using the app URL
       $resetLink = "{$appUrl}/password/reset/{$resetToken}";

     Mail::send('emails.password-send', ['username' =>$request->name, 'email' => $request->email, 'resetLink' => $resetLink], function($message) use($email){
         $message->to($email);
         $message->subject('Reset Your Password');
     });

     $roles = 'Subscriber';
     $user->assignRole($roles);
    
     session()->flash('success', 'Invitation  has been Sent Successfully !!');


    // Send the invitation email

    return redirect()->route('admin.invitation.index')->with('success', 'Invitation  has been Sent Successfully !!');
}

public function accept($token)
{
    $invitation = Invitation::where('token', $token)->first();

    if (!$invitation) {
        return redirect()->route('admin.invitation.create')->with('error', 'Invalid invitation token');
    }

    $invitation->update(['accepted' => true]);

    // Additional logic for handling the invitation acceptance

    return redirect()->route('home')->with('success', 'Invitation accepted');
}   

public function destroy(Request $request)
{
    $user = User::find($request->user_id);
    $user->delete();
    session()->flash('success', 'User has been deleted !!');
    return redirect()->route('admin.invitation.index')->with('success', 'Invitation accepted');;
}
}