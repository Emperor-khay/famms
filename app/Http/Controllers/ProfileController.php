<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    public function profile(){
        return view('custom-profile.profile');
    }

    public function edit_profile(){
        if(Auth::check()){
            $userid = Auth::user()->id;
            $user = User::where('id', '=', $userid)->first();
        }
        return view('custom-profile.profile-form', compact('user'));
    }

    public function update_profile(Request $request){
        if(Auth::check()){
            $userid = Auth::user()->id;
            $user = User::where('id', '=', $userid)->first();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->save();
            Alert::success('User Updated Successfully', 'We have effected the requested changes on your details.');
            return redirect()->route('profile');
        }
    }

}
