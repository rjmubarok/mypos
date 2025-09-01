<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
class PermissionsController extends Controller
{
      public function index()
    {
        $permissions = Permission::all();

        return view('backend.permissions.index', [
            'permissions' => $permissions
        ]);
    }


    public function create()
    {
        return view('backend.permissions.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'addMoreInputFields.*.name' => 'required'
        ]);

        foreach ($request->addMoreInputFields as $key => $value) {
            Permission::create($value);
        }
        toast('Successfully Created!', 'success');
        return back();
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  Permission  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        return view('backend.permissions.edit', [
            'permission' => $permission
        ]);
    }
    public function show(Permission $permission)
    {
        $singlepermission = $permission;
        // $rolePermissions = $role->permissions;
        return view('backend.permissions.show', [
            'singlepermission' => $singlepermission
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id
        ]);

        $permission->update($request->only('name'));
        toast(' Updated Successfully!', 'success');
        return redirect()->route('permissions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        toast(' Deleted Successfully!', 'success');
        return redirect()->route('permissions.index');
    }
}
