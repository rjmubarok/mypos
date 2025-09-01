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
use PDF;

class ProductController extends Controller
{
      public function fetchProduct(Request $request)
    {
        $data = Product::where('id', $request->product_id)->first();
        //return response()->json($products);
        return view('backend.product.stock_product', compact('data'))->render();
    }
    public function Productstock()
    {
        $products = Product::with('category', 'brand', 'supplier')->get();

      return view('backend.product.stock', compact('products'));
    }
 public function updateStock(Request $request)
{
    $validator = \Validator::make($request->all(), [
        'stock_status' => 'required|in:In,Out',
        'product_id' => 'required|exists:products,id',
        'stock' => 'required|numeric|min:1',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    $product = Product::find($request->product_id);
    $current_stock = $product->stock;
    $new_stock = $request->stock;

    if ($request->stock_status == 'In') {
        $product->stock = $current_stock + $new_stock;
        $product->save();
        return response()->json([
            'success' => true,
            'message' => 'Product Stock Incremented Successfully!',
            'new_stock' => $product->stock
        ]);
    }

    if ($request->stock_status == 'Out') {
        if ($new_stock <= $current_stock) {
            $product->stock = $current_stock - $new_stock;
            $product->save();
            return response()->json([
                'success' => true,
                'message' => 'Product Stock Decremented Successfully!',
                'new_stock' => $product->stock
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Product Stock Out Of Current Stock!'
            ]);
        }
    }

    return response()->json([
        'success' => false,
        'message' => 'Something Went Wrong!'
    ]);
}
    public function generateProductPDF()
    {
        $products = Product::with('category', 'brand', 'supplier')->get();

        //$pdf = Pdf::loadView('backend.product.pdf', compact('products'));
        $pdf = PDF::loadView('backend.product.pdf', compact('products'));
        return $pdf->download('products_list.pdf');
    }
    public function index()
    {
        return view('backend.product.index', [
            'products' => Product::with(['category', 'brand', 'supplier'])
                ->orderBy('id', 'desc')
                ->get()
        ]);
    }

    public function storeMultiple(Request $request)
    {
        $request->validate([
            'products.*.name'           => 'required|string|max:255',
            'products.*.purchase_price' => 'required|numeric|min:0',
            'products.*.selling_price'  => 'required|numeric|min:0',
            'products.*.stock'          => 'required|integer|min:0',
        ]);

        foreach ($request->products as $index => $productData) {
            $product = new Product();
            $product->category_id    = $productData['category_id'] ?? null;
            $product->brand_id       = $productData['brand_id'] ?? null;
            $product->supplier_id    = $productData['supplier_id'] ?? null;
            $product->name           = $productData['name'];
            $product->slug           = Str::slug($productData['name']) . '-' . time();
            $product->purchase_price = $productData['purchase_price'];
            $product->selling_price  = $productData['selling_price'];
            $product->stock          = $productData['stock'];
            $product->sku            = $productData['sku'] ?? null;
            $product->description    = $productData['description'] ?? null;
            $product->alert_quantity = $productData['alert_quantity'] ?? 2;
            $product->status         = $productData['status'] ?? 1;
            $product->barcode        = 'PROD-' . time();

            // Handle Image
            if ($request->hasFile("products.$index.image")) {
                $file = $request->file("products.$index.image");
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move('uploads/image/', $filename);
                $product->image = $filename;
            }

            $product->save();
        }

        return redirect()->route('product.index')->with('success', 'Products added successfully!');
    }
    public function create()
    {
        $categories = Category::all();
        $brands     = Brand::all();
        $suppliers  = Supplier::all();
        return view('backend.product.create', compact('categories', 'brands', 'suppliers'));
    }
    public function MultiProductAdd()
    {
        //return 'hrllo';
        $categories = Category::all();
        $brands     = Brand::all();
        $suppliers  = Supplier::all();
        return view('backend.product.multi_product_add', compact('categories', 'brands', 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //  return $request->all();
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
                'purchase_price' => 'required|numeric|min:0',
                'selling_price' => 'required|numeric|min:0',
                'stock'        => 'required|integer|min:0',
                'alert_quantity' => 'required|integer|min:0',
                'status'        => 'required|boolean',
            ]);

            $data = $request->all();
            $data['slug'] = Str::slug($request->name) . '-' . time();
            $data['barcode'] = 'PROD-' . time();

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $filename = uniqid() . '.' . $ext;
                $file->move('uploads/image/', $filename);
                $data['image'] = 'uploads/image/' . $filename;
            }
            $data['barcode'] = 'PROD-' . time();
            Product::create($data);
            toast('Product Added successfully', 'success');
            return redirect()->back();
        } catch (\Throwable $th) {
            toast('Something went wrong!', 'error');
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        return view('backend.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug)
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
        $status = $product->update($data);

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
    public function destroy($id)
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
                'text' => $product->name . ' (' . $product->selling_price . ')',
                'price' => $product->selling_price,
                'stock' => $product->stock,
            ];
        }

        return response()->json($result);
    }
}
