<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Model\TimeZones;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $timezones = TimeZones::all();

        return view('back.pages.profile.show', compact('user','timezones'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|required|min:8|confirmed',
        ]);

        $user->email = $request->input('email');

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }
        $user->time_zone=$request->input('time_zone');
        $user->save();

        return redirect()->route('admin.profile.show')->with('success', 'Profile updated successfully.');
    }
}
