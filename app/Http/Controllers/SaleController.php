<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use App\Models\Saleitem;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class SaleController extends Controller
{


    public function downloadInvoice($id)
    {
        //  return 'hello';
        $sale = Sale::with('customer', 'items')->where('id', $id)->firstOrFail();

        $pdf = PDF::loadView('backend.sales.invoice_pdf', compact('sale'));
        return $pdf->download('invoice_' . $sale->invoice_no . '.pdf');
    }


    public function fetchProductBycat(Request $request)
    {
        $product = Product::where('category_id', $request->category_id)->get();
        return response()->json($product);
    }





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
        $categories  = \App\Models\Category::all();
        return view('backend.sales.create', compact('customers', 'products', 'categories'));
    }

    public function store(Request $request)
    {
        try {
             if ($request->customer_id === 'guest') {
        // Guest customer create
        $customer = Customer::create([
            'name' => $request->guest_name ?? 'Walk-in Customer',
            'phone' => $request->guest_phone ?? null,
        ]);

        $customerId = $customer->id;
    } else {
        $customerId = $request->customer_id;
    }
            $sale = Sale::create([
                'user_id'     => auth()->id(),
                'customer_id' => $customerId,
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
        $customers = \App\Models\Customer::all();
        $products  = \App\Models\Product::all();
        $categories  = \App\Models\Category::all();
        return view('backend.sales.edit', compact('sale', 'customers', 'products', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([

            'sold_at'       => 'required|date',
            'payment_method' => 'required|string',
            'items'         => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'subtotal'      => 'required|numeric|min:0',
            'grand_total'   => 'required|numeric|min:0',
            'discount'      => 'nullable|numeric|min:0',
            'tax'           => 'nullable|numeric|min:0',
            'shipping'      => 'nullable|numeric|min:0',
            'paid_amount'   => 'nullable|numeric|min:0',
        ]);

        $sale = Sale::findOrFail($id);

        // Update sale main info

        $sale->sold_at       = $request->sold_at;
        $sale->payment_method = $request->payment_method;
        $sale->subtotal      = $request->subtotal;
        $sale->discount      = $request->discount ?? 0;
        $sale->tax           = $request->tax ?? 0;
        $sale->shipping      = $request->shipping ?? 0;
        $sale->grand_total   = $request->grand_total;
        $sale->paid_amount          = $request->has('paid') ? 1 : 0;
        $sale->paid_amount   = $request->paid ? ($request->paid_amount ?? $sale->grand_total) : 0;

        // $sale->due_amount    = $sale->grand_total - $sale->paid_amount;
        $sale->save();

        // Delete old items
        $sale->items()->delete();

        // Insert new items
        foreach ($request->items as $item) {
            $product = Product::findOrFail($item['product_id']);
            $sale->items()->create([
                'product_id' => $item['product_id'],
                'quantity'   => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'product_name' => $product->name,
                'total'      => $item['total'],
            ]);

            // Optional: stock update (if your system has stock management)
            Product::where('id', $item['product_id'])
                ->decrement('stock', $item['quantity']);
        }
         toast('Sale Update and stock updated successfully!', 'success');
        return redirect()->back()->with('success', 'Sale Update and stock updated successfully!');

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
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
}
