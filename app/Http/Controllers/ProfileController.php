<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
class ProfileController extends Controller
{
    public function profile(){
       return view('backend.user.profile');
    }
     public function update(Request $request)
    {
        $user = User::find(auth()->id()); // current logged in user update করব

        // validation
        // $request->validate([
        //     'name' => 'required|string|max:100',
        //     'phone' => 'nullable|string|max:20',
        //     'gender' => 'nullable|string',
        //     'dob' => 'nullable|date',
        //     'address' => 'nullable|string|max:255',
        //     'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        // ]);

        // basic info update
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->gender = $request->gender;
        $user->dob = $request->dob;
        $user->address = $request->address;

        // photo upload
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/users'), $filename);

            // পুরানো ছবি থাকলে unlink করতে পারেন
            if ($user->photo && file_exists(public_path('uploads/users/'.$user->photo))) {
                unlink(public_path('uploads/users/'.$user->photo));
            }

            $user->photo = $filename; // database এ save হবে
        }

        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'User info updated successfully',
            'user' => $user
        ]);
    }
}
