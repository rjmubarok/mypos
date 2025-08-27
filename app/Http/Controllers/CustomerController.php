<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
   public function index()
{
    $customers = Customer::all();
   // return $customers;
    return view('backend.customer.index', compact('customers'));
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'phone' => 'nullable',
        'address' => 'nullable',
    ]);

    $customer =new Customer();
    $customer->name= $request->name;
    $customer->email= $request->email;
    $customer->phone= $request->phone;
    $customer->address= $request->address;
  if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $ext = $file->getClientOriginalExtension();
            $filename = uniqid() . '.' . $ext;
            $file->move('uploads/photo/', $filename);
            $customer->photo = 'uploads/photo/' . $filename;
        }
    $customer->save();
    return response()->json([
        'success' => true,
        'message' => 'Customer added successfully',
        'customer' => $customer
    ]);
}

public function show(Customer $customer)
{
    return response()->json($customer);
}

public function update(Request $request, Customer $customer)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'phone' => 'nullable',
        'address' => 'nullable',
    ]);

    $customer->update($request->all());

    return response()->json([
        'success' => true,
        'message' => 'Customer updated successfully',
        'customer' => $customer
    ]);
}

public function destroy(Customer $customer)
{
    $customer->delete();

    return response()->json([
        'success' => true,
        'message' => 'Customer deleted successfully'
    ]);
}
}
