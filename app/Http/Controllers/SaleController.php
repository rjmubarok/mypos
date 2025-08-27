<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Saleitem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{











    /**
     * Show the form for creating a new resource.
     */
    public function index()
    {
        $customers = \App\Models\Customer::all();
        $products  = \App\Models\Product::all();
        $sales = Sale::all();
        return view('backend.sales.index', compact('customers', 'products', 'sales'));
    }
    public function create()
    {
        $customers = \App\Models\Customer::all();
        $products  = \App\Models\Product::all();
        return view('backend.sales.create', compact('customers', 'products'));
    }

public function store(Request $request)
    {
        try {
    // Sale create
    $sale = Sale::create([
        'user_id'     => auth()->id(),
        'customer_id' => $request->customer_id,
        'invoice_no'  => 'INV-' . now()->format('Ymd-His'),
        'sold_at'     => $request->sold_at,
        'subtotal'    => $request->subtotal,
        'discount'    => $request->discount ?? 0,
        'discount_type' => $request->discount_type ?? 'flat',
        'tax'         => $request->tax ?? 0,
        'shipping'    => $request->shipping ?? 0,
        'grand_total' => $request->grand_total,
        'paid_amount' => $request->paid_amount ?? 0,
        'payment_status' => ($request->paid_amount ?? 0) >= $request->grand_total ? 'paid' : 'partial',
        'status'      => 'completed',
        'payment_method' => $request->payment_method ?? 'cash',
    ]);

    foreach ($request->items as $item) {
        $product = \App\Models\Product::find($item['product_id']);
        if (!$product) {
            throw new \Exception("Product not found with ID: " . $item['product_id']);
        }

        // Sale item create
        SaleItem::create([
            'sale_id'      => $sale->id,
            'product_id'   => $product->id,
            'product_name' => $product->name,
            'quantity'     => $item['quantity'],
            'unit_price'   => $item['unit_price'],
            'total'        => $item['total'],
        ]);

        // Stock update - sale quantity কমানো
        $product->stock = $product->stock - $item['quantity'];
        $product->save();
    }
toast('success', 'Sale Created Successfully!');
    return redirect()->route('sale.index');

} catch (\Exception $e) {
    return redirect()->back()->withInput()->with('error', 'Something went wrong: ' . $e->getMessage());
}

    }



    public function show($id)
    {
        $sale = Sale::with('customer', 'items')->where('id', $id)->firstOrFail();
        //return $sale;
        return view('backend.sales.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(Sale $sale)
{
    try {
        // Sale item গুলো loop করে stock update
        foreach ($sale->items as $item) {
            $product = \App\Models\Product::find($item->product_id);
            if ($product) {
                $product->stock += $item->quantity; // stock increase
                $product->save();
            }
        }

        // Sale এবং related SaleItem delete
        $sale->items()->delete();
        $sale->delete();
toast('success', 'Sale deleted and stock updated successfully!');
        return redirect()->route('sale.index');
       
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
    }
}














}
