<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
 public function index()
    {
        $users = User::with('roles')->get();
        // return $users;
        return view('backend.users.index', compact('users'));
    }


    public function create()
    {
        $roles = Role::all();
        return view('backend.users.create', compact('roles'));
    }


    public function store(User $user, Request $request)
    {
        $data = $request->all();
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:4'],
            'status' => 'required',
            'roles' => 'required',
        ]);



        $users = User::create([
            'name' => $data['name'],

            'email' => $data['email'],
            'status' => $data['status'],
            'password' => Hash::make($data['password']),
        ]);
        // $users->syncRoles($request->roles);
        $users->syncRoles($request->roles);
        // $user->assignRole($role);
        if ($users) {

            toast(' Created Successfully!', 'success');
            return redirect()->route('users.index');
        } else {
            toast(' Created Successfully!', 'success');
            return back();
        }


    }
public function statusUpdate(Request $request)
{
    $user = User::find($request->id);
    if($user){
        $user->status = $request->status;
        $user->save();
        return response()->json(['success' => true]);
    }
    return response()->json(['success' => false], 404);
}

    /**
     * Show user data
     *
     * @param User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        // $user = $user;
        return view('backend.users.show', [
            'user' => $user
        ]);
    }

    /**
     * Edit user data
     *
     * @param User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::where('id', $id)->first();
        //return $user->roles;
        return view('backend.users.edit', [
            'user' => $user,
            'userRole' => $user->roles->pluck('name')->toArray(),
            'roles' => Role::latest()->get()
        ]);
    }

    /**
     * Update user data
     *
     * @param User $user
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       // return 'hello';
            // ✅ Validation
        $request->validate([
        'name'  => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
        'role'  => 'required|exists:roles,name',
    ]);

    $user = User::findOrFail($id);

    // user info update
    $user->update([
        'name'  => $request->name,
        'email' => $request->email,
    ]);

    // role sync
    $user->syncRoles([$request->role]);

    return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    /**
     * Delete user data
     *
     * @param User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        toast(' Deleted Successfully!', 'success');
        return redirect()->route('users.index');
    }
}
