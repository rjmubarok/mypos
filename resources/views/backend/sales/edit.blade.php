@extends('layouts.app')
@section('title', 'Edit Sale')
@section('styles')
<style>
    .select2-container .select2-selection--single {
        height: 34px !important;
    }
    .select2-container--default .select2-selection--single {
        border: 1px solid #ccc !important;
        border-radius: 0px !important;
    }
</style>
@endsection

@section('content')
<div class="container">
    <h3>Edit Sale</h3>
    <form action="{{ route('sale.update', $sale->id) }}" method="POST" id="saleForm">
        @csrf
        @method('PUT')

        <!-- Customer & Payment Info -->
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="category_id">Category <span class="text-danger">*</span></label>
                <select class="form-control select2" id="category_id" name="category_id" required>
                    <option disabled>-- Select Category --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ $sale->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label>Customer</label>
                <select name="customer_id" class="form-control">
                    <option value="">Walk-in Customer</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}"
                            {{ $sale->customer_id == $customer->id ? 'selected' : '' }}>
                            {{ $customer->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label>Sold At</label>
                <input type="datetime-local" name="sold_at" class="form-control"
                       value="{{ \Carbon\Carbon::parse($sale->sold_at)->format('Y-m-d\TH:i') }}">
            </div>

            <div class="col-md-4">
                <label>Payment Method</label>
                <select name="payment_method" class="form-control">
                    <option value="cash"  {{ $sale->payment_method == 'cash' ? 'selected' : '' }}>Cash</option>
                    <option value="card"  {{ $sale->payment_method == 'card' ? 'selected' : '' }}>Card</option>
                    <option value="bkash" {{ $sale->payment_method == 'bkash' ? 'selected' : '' }}>Bkash</option>
                    <option value="nagad" {{ $sale->payment_method == 'nagad' ? 'selected' : '' }}>Nagad</option>
                </select>
            </div>
        </div>

        <!-- Products Table -->
        <h5>Sale Items</h5>
        <table class="table table-bordered" id="sale-items">
            <thead>
                <tr>
                    <th>Product</th>
                    <th width="120">Quantity</th>
                    <th width="120">Unit Price</th>
                    <th width="120">Total</th>
                    <th width="50">#</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sale->items as $i => $item)
                <tr>
                    <td>
                        <select name="items[{{ $i }}][product_id]" class="form-control product-select">
                            <option value="">-- select --</option>
                            @foreach ($products as $p)
                                <option value="{{ $p->id }}"
                                    data-price="{{ $p->selling_price }}"
                                    {{ $item->product_id == $p->id ? 'selected' : '' }}>
                                    {{ $p->name }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" name="items[{{ $i }}][quantity]"
                               value="{{ $item->quantity }}" class="form-control qty">
                    </td>
                    <td>
                        <input type="number" name="items[{{ $i }}][unit_price]"
                               value="{{ $item->unit_price }}" class="form-control unit-price" readonly>
                    </td>
                    <td>
                        <input type="number" name="items[{{ $i }}][total]"
                               value="{{ $item->total }}" class="form-control total" readonly>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger remove-row">&times;</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button type="button" id="add-row" class="btn btn-sm btn-primary">+ Add Item</button>

        <!-- Totals -->
        <div class="row mt-3">
            <div class="col-md-3">
                <label>Subtotal</label>
                <input type="number" name="subtotal" id="subtotal"
                       class="form-control" value="{{ $sale->subtotal }}" readonly>
            </div>
            <div class="col-md-3">
                <label>Discount</label>
                <input type="number" name="discount" id="discount"
                       class="form-control" value="{{ $sale->discount }}">
            </div>
            <div class="col-md-3">
                <label>Tax</label>
                <input type="number" name="tax" id="tax"
                       class="form-control" value="{{ $sale->tax }}">
            </div>
            <div class="col-md-3">
                <label>Shipping</label>
                <input type="number" name="shipping" id="shipping"
                       class="form-control" value="{{ $sale->shipping }}">
            </div>
            <div class="col-md-3 mt-2">
                <label>Grand Total</label>
                <input type="number" name="grand_total" id="grand_total"
                       class="form-control" value="{{ $sale->grand_total }}" readonly>
            </div>

            <!-- Paid Section -->
            <div class="col-md-3 mt-2">
                <label for="paid">Paid</label><br>
                <input type="checkbox" id="paid" name="paid" value="1"
                       {{ $sale->paid ? 'checked' : '' }}>
            </div>

            <div class="col-md-3 mt-2" id="paidAmountBox" style="{{ $sale->paid ? '' : 'display:none;' }}">
                <label>Paid Amount</label>
                <input type="number" id="paid_amount" name="paid_amount"
                       class="form-control" value="{{ $sale->paid_amount }}">
            </div>

            <div class="col-md-3 mt-2">
                <label>Due Amount</label>
                <input type="number" name="due_amount" id="due_amount"
                       class="form-control" value="{{ $sale->due_amount }}" readonly>
            </div>
        </div>

        <button type="submit" class="btn btn-success mt-3">Update Sale</button>
    </form>
</div>
@endsection

@section('scripts')
@include('backend.sales.partials._script')
@endsection
