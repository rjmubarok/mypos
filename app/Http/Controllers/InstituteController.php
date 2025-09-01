<?php

namespace App\Http\Controllers;

use App\Models\Institute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
class InstituteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
      public function index()
    {
        $institute = Institute::first();
        return view('backend.institute.institute', compact('institute'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Institute $institute)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Institute $institute)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //dd( $request->all());
        $data = Institute::get()->first();
        // return $data;
        if ($request->hasFile('favicon')) {
            $destanation = $data->favicon;
            // return  $destanation;
            if (File::exists($destanation)) {
                File::delete($destanation);
            }
            $file = $request->file('favicon');
            $ext = $file->getClientOriginalExtension();
            $filename = uniqid() . '.' . $ext;
            $file->move('uploads/favicon/', $filename);
            $data->favicon = 'uploads/favicon/' . $filename;
        } else {
            $data->favicon = $data->favicon;
        }
        if ($request->hasFile('logo')) {
            $destanation = $data->logo;
            //return  $destanation;
            if (File::exists($destanation)) {
                File::delete($destanation);
            }
            $file = $request->file('logo');
            $ext = $file->getClientOriginalExtension();
            $filename = uniqid() . '.' . $ext;
            $file->move('uploads/logo/', $filename);
            $data->logo = 'uploads/logo/' . $filename;
        } else {
            $data->logo = $data->logo;
        }
        if ($request->hasFile('banner')) {
            $destanation = $data->banner;
            //return  $destanation;
            if (File::exists($destanation)) {
                File::delete($destanation);
            }
            $file = $request->file('banner');
            $ext = $file->getClientOriginalExtension();
            $filename = uniqid() . '.' . $ext;
            $file->move('uploads/banner/', $filename);
            $data->banner = 'uploads/banner/' . $filename;
        } else {
            $data->banner = $data->banner;
        }
        $data->name = $request->name;
        $data->address = $request->address;
        $data->about = $request->about;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->eiin_no = $request->eiin_no;
        $data->slogan = $request->slogan;
        $data->facebook_url = $request->facebook_url;
        $data->team_color = $request->team_color;
        $data->description = $request->description;

        $status = $data->update();
        if ($status) {
            toast('Information Updated Successfully', 'success');
            return back();
        } else {

            return back()->with('error', 'Something went wrong !');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Institute $institute)
    {
        //
    }
}
