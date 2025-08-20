<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\File;

class BrandController extends Controller
{
 public function index()
    {
        $brands = Brand::latest()->get();
        return view('backend.brand.index', compact('brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:brands,name',
            'logo' => 'nullable|image|max:2048'
        ]);

        $logoPath = null;
       if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $ext = $file->getClientOriginalExtension();
            $filename = uniqid() . '.' . $ext;
            $file->move('uploads/brand/logo/', $filename);
            $logoPath = 'uploads/brand/logo/' . $filename;
        }

        Brand::create([
            'name' => $request->name,
            'logo' => $logoPath,
            'status' => 1,
        ]);

        return response()->json(['success' => 'Brand Added Successfully']);
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return response()->json($brand);
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:brands,name,'.$brand->id,
            'logo' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('logo')) {
            $destanation = $brand->logo;
            //return  $destanation;
            if (File::exists($destanation)) {
                File::delete($destanation);
            }
            $file = $request->file('logo');
            $ext = $file->getClientOriginalExtension();
            $filename = uniqid() . '.' . $ext;
            $file->move('uploads/brand/logo/', $filename);
            $brand['logo'] = 'uploads/brand/logo/' . $filename;
        } else {
            $brand->logo = $brand->logo;
        }

        $brand->name = $request->name;
        $brand->save();

        return response()->json(['success' => 'Brand Updated Successfully']);
    }

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();
        return response()->json(['success' => 'Brand Deleted Successfully']);
    }

    public function statusUpdate(Request $request)
    {
        $brand = Brand::findOrFail($request->id);
        $brand->status = $request->status;
        $brand->save();

        return response()->json(['success' => true, 'status' => $brand->status]);
    }
}
