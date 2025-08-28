<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Supplier;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use PhpParser\Node\Stmt\TryCatch;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.product.index', [
            'products' => Product::with(['category', 'brand', 'supplier'])->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $categories = Category::all();
        $brands     = Brand::all();
        $suppliers  = Supplier::all();
        return view('backend.product.create', compact('categories', 'brands', 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
            'name'          => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'brand_id'      => 'required|exists:brands,id',
            'supplier_id'   => 'required|exists:suppliers,id',
            'sku'           => 'nullable|string|max:100',
            'barcode'      => 'nullable|string|max:100',
            'description'   => 'nullable|string',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'purchase_price'=> 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            'alert_quantity'=> 'required|integer|min:0',
            'status'        => 'required|boolean',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

         if ($request->hasFile('image')) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = uniqid() . '.' . $ext;
            $file->move('uploads/image/', $filename);
            $data['image'] = 'uploads/image/' . $filename;
        }
        $data['barcode'] = 'PROD-' . time();
        Product::create($data);

        return redirect()->route('product.index')->with('success', 'Product created successfully.');
    } catch (\Throwable $th) {
            return back()->with('error', 'Something went wrong!');
    }
}

    /**
     * Display the specified resource.
     */
    public function show( $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        return view('backend.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $slug)
    {
         $product = Product::where('slug', $slug)->firstOrFail();
        $categories = Category::all();
        $brands     = Brand::all();
        $suppliers  = Supplier::all();
        return view('backend.product.edit', compact('product', 'categories', 'brands', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */


public function update(Request $request, Product $product)
{
    $request->validate([
        'name'           => 'required|string|max:255',
        'category_id'    => 'required|exists:categories,id',
        'brand_id'       => 'required|exists:brands,id',
        'supplier_id'    => 'required|exists:suppliers,id',
        'sku'            => 'nullable|string|max:100',
        'barcode'        => 'nullable|string|max:100',
        'description'    => 'nullable|string',
        'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'purchase_price' => 'required|numeric|min:0',
        'selling_price'  => 'required|numeric|min:0',
        'stock'          => 'required|integer|min:0',
        'alert_quantity' => 'required|integer|min:0',
        'status'         => 'required|boolean',
    ]);

    $data = $request->all();

    // Slug generate
    $data['slug'] = Str::slug($request->name);

    // Image upload handle
   if ($request->hasFile('image')) {
            $destanation = $product->image;
            //return  $destanation;
            if (File::exists($destanation)) {
                File::delete($destanation);
            }
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = uniqid() . '.' . $ext;
            $file->move('uploads/image/', $filename);
            $data['image'] = 'uploads/image/' . $filename;
        } else {
            $product->image = $product->image;
        }

    // Keep old barcode if exists, otherwise regenerate
    if (!$product->barcode) {
        $data['barcode'] = 'PROD-' . time();
    }

    // Update the product
    $status=$product->update($data);

        if ($status) {
            toast('Product updated successfully', 'success');
            return redirect()->route('product.index');
        } else {

            return back()->with('error', 'Something went wrong !');
        }

}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $product = Product::findOrFail($id);
        $destanation = $product->image;
        //return  $destanation;
        if (File::exists($destanation)) {
            File::delete($destanation);
        }
        $product->delete();
        toast('Product Deleted successfully', 'success');
        return redirect()->route('product.index');
    }
     public function statusUpdate(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->status = $request->status;
        $product->save();

        return response()->json(['success' => true, 'status' => $product->status]);
    }



    public function search(Request $request)
{
    $query = $request->get('q', '');

    $products = \App\Models\Product::where('name', 'like', "%{$query}%")
                 ->orWhere('sku', 'like', "%{$query}%")
                 ->limit(5)
                 ->get();

    $result = [];
    foreach ($products as $product) {
        $result[] = [
            'id' => $product->id,
            'text' => $product->name . ' ('.$product->selling_price.')',
            'price' => $product->selling_price,
            'stock' => $product->stock,
        ];
    }

    return response()->json($result);
}

}
