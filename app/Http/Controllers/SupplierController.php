<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.supplier.index', [
            'suppliers' => Supplier::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('backend.supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $rules = [
            'photo' => 'image|file|max:1024',
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:50|unique:suppliers,email',
            'phone' => 'required|string|max:25|unique:suppliers,phone',
            'shopname' => 'required|string|max:50',

            'address' => 'required|string|max:100',
        ];

        $validatedData = $request->validate($rules);
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $ext = $file->getClientOriginalExtension();
            $filename = uniqid() . '.' . $ext;
            $file->move('uploads/photo/', $filename);
            $validatedData['photo'] = 'uploads/photo/' . $filename;
        }

        $status = Supplier::create($validatedData);
        if ($status) {
            toast(' Supplier Added  Successfully!', 'success');
            return redirect()->route('supplier.index');
        } else {
            toast('shometing went wrong', 'error');
            return back();
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        return view('backend.supplier.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return view('backend.supplier.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
         $supplier = Supplier::where('id', $id)->first();
        $rules = [
            'photo' => 'image|file|max:1024',
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:50|unique:suppliers,email,' . $supplier->id,
            'phone' => 'required|string|max:25|unique:suppliers,phone,' . $supplier->id,
            'shopname' => 'required|string|max:50',

            'address' => 'required|string|max:100',
        ];

        $validatedData = $request->validate($rules);


        if ($request->hasFile('photo')) {
            $destanation = $supplier->photo;
            //return  $destanation;
            if (File::exists($destanation)) {
                File::delete($destanation);
            }
            $file = $request->file('photo');
            $ext = $file->getClientOriginalExtension();
            $filename = uniqid() . '.' . $ext;
            $file->move('uploads/photo/', $filename);
            $validatedData['photo'] = 'uploads/photo/' . $filename;
        } else {
            $supplier->photo = $supplier->photo;
        }

        $status = $supplier->update($validatedData);
        if ($status) {
            toast('Information Updated Successfully', 'success');
            return redirect()->route('supplier.index');
        } else {

            return back()->with('error', 'Something went wrong !');;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $supplier = Supplier::where('id', $id)->first();
        $destanation = $supplier->photo;
        //return  $destanation;
        if (File::exists($destanation)) {
            File::delete($destanation);
        }

        if ($supplier) {
            $status = $supplier->delete();
            if ($status) {
                toast(' Supplier Deleted Successfully!', 'success');
                return redirect()->route('supplier.index');
            } else {
                toast('shometing went wrong', 'error');
                return back();
            }
        } else {
            toast('shometing went wrong', 'error');
            return back();
        }
    }


    public function statusUpdate(Request $request)
    {
        $supplier = Supplier::findOrFail($request->id);
        $supplier->status = $request->status;
        $supplier->save();

        return response()->json(['success' => true, 'status' => $supplier->status]);
    }
}
