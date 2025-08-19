<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function profile(){
       return view('backend.users.profile');
    }
    public function passwordChange(){
       return view('backend.user.change_password');
    }
     public function update(Request $request)
    {
        $user = User::find(auth()->id()); // current logged in user update করব


        // basic info update
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->gender = $request->gender;
        $user->dob = $request->dob;
        $user->address = $request->address;


         if ($request->hasFile('photo')) {
            $destanation = $user->photo;
            //return  $destanation;
            if (File::exists($destanation)) {
                File::delete($destanation);
            }
            $file = $request->file('photo');
            $ext = $file->getClientOriginalExtension();
            $filename = uniqid() . '.' . $ext;
            $file->move('uploads/user/photo/', $filename);
            $user['photo'] = 'uploads/user/photo/' . $filename;
        } else {
            $user->photo = $user->photo;
        }
        // $userData->update($validatedData);

        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'User info updated successfully',
            'user' => $user
        ]);
    }

     public function PasswordUpdate(Request $request)
{
    $request->validate([
        'oldpassword' => 'nullable',
        'newpassword' => 'nullable|min:8|confirmed', // confirmed চাইলে name="newpassword_confirmation"
    ]);

    $user = Auth::user(); // current logged in user
    $hashpassword = $user->password;

    // যদি দুইটা ফিল্ড null হয়, কিছু change নেই
    if (empty($request->oldpassword) && empty($request->newpassword)) {
        return response()->json([
            'status' => false,
            'message' => 'No password entered'
        ]);
    }

    // old password check
    if (!Hash::check($request->oldpassword, $hashpassword)) {
        return response()->json([
            'status' => false,
            'message' => 'Old password does not match'
        ]);
    }

    // new password check (old password same না হতে হবে)
    if (Hash::check($request->newpassword, $hashpassword)) {
        return response()->json([
            'status' => false,
            'message' => 'New password cannot be same as old password'
        ]);
    }

    // update password
    $user->password = Hash::make($request->newpassword);
    $user->save(); // ✅ save() use করুন, empty update() নয়

    return response()->json([
        'status' => true,
        'message' => 'Password updated successfully',
    ]);

    }
}
