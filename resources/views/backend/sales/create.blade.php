@extends('layouts.app')
@section('title', 'Sales Add')
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
    <h3>Create Sale</h3>
    <form action="{{ route('sale.store') }}" method="POST">
        @csrf

        <!-- Customer & Payment Info -->
        <div class="row mb-3">
            <div class="col-md-4">
                <label>Customer</label>
                <select name="customer_id" class="form-control">
                    <option value="">Walk-in Customer</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label>Sold At</label>
                <input type="datetime-local" name="sold_at" class="form-control"
                       value="{{ now()->format('Y-m-d\TH:i') }}">
            </div>
            <div class="col-md-4">
                <label>Payment Method</label>
                <select name="payment_method" class="form-control">
                    <option value="cash">Cash</option>
                    <option value="card">Card</option>
                    <option value="bkash">Bkash</option>
                    <option value="nagad">Nagad</option>
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
                <tr>
                    <td>
                        <select name="items[0][product_id]" class="form-control product-select">
                            <option value="">-- select --</option>
                            @foreach ($products as $p)
                                <option value="{{ $p->id }}" data-price="{{ $p->selling_price }}">
                                    {{ $p->name }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" name="items[0][quantity]" value="1" class="form-control qty">
                    </td>
                    <td>
                        <input type="number" name="items[0][unit_price]" class="form-control unit-price" readonly>
                    </td>
                    <td>
                        <input type="number" name="items[0][total]" class="form-control total" readonly>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger remove-row">&times;</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <button type="button" id="add-row" class="btn btn-sm btn-primary">+ Add Item</button>

        <!-- Totals -->
        <div class="row mt-3">
            <div class="col-md-3">
                <label>Subtotal</label>
                <input type="number" step="0.01" name="subtotal" id="subtotal" class="form-control" readonly>
            </div>
            <div class="col-md-3">
                <label>Discount</label>
                <input type="number" step="0.01" name="discount" id="discount" class="form-control" value="0">
            </div>
            <div class="col-md-3">
                <label>Tax</label>
                <input type="number" step="0.01" name="tax" id="tax" class="form-control" value="0">
            </div>
            <div class="col-md-3">
                <label>Shipping</label>
                <input type="number" step="0.01" name="shipping" id="shipping" class="form-control" value="0">
            </div>
            <div class="col-md-3 mt-2">
                <label>Grand Total</label>
                <input type="number" step="0.01" name="grand_total" id="grand_total" class="form-control" readonly>
            </div>

            <!-- Paid Section -->
            <div class="col-md-3 mt-2">
                <label for="paid">Paid</label><br>
                <input type="checkbox" id="paid" name="paid" value="1">
            </div>

            <div class="col-md-3 mt-2" id="paidAmountBox" style="display:none;">
                <label>Paid Amount</label>
                <input type="number" step="0.01" id="paid_amount" name="paid_amount" class="form-control" value="0" readonly>
            </div>

            <div class="col-md-3 mt-2">
                <label>Due Amount</label>
                <input type="number" step="0.01" name="due_amount" id="due_amount" class="form-control" readonly>
            </div>
        </div>

        <button type="submit" class="btn btn-success mt-3">Save Sale</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
    let row = 1;

    function recalc() {
        let subtotal = 0;
        $('#sale-items tbody tr').each(function() {
            let qty = parseFloat($(this).find('.qty').val()) || 0;
            let unit = parseFloat($(this).find('.unit-price').val()) || 0;
            let total = qty * unit;
            $(this).find('.total').val(total.toFixed(2));
            subtotal += total;
        });

        $('#subtotal').val(subtotal.toFixed(2));

        let discount = parseFloat($('#discount').val()) || 0;
        let tax = parseFloat($('#tax').val()) || 0;
        let shipping = parseFloat($('#shipping').val()) || 0;

        let grand = subtotal - discount + tax + shipping;
        $('#grand_total').val(grand.toFixed(2));

        updatePaidAndDue();
    }

    // Update Paid and Due
    function updatePaidAndDue() {
        let grand = parseFloat($('#grand_total').val()) || 0;

        if ($('#paid').is(':checked')) {
            $('#paidAmountBox').show();
            $('#paid_amount').val(grand.toFixed(2)); // Paid = Grand Total
            $('#due_amount').val(0);
        } else {
            $('#paidAmountBox').hide();
            $('#paid_amount').val(0);
            $('#due_amount').val(grand.toFixed(2)); // Due = Grand Total
        }
    }

    // product select change
    $(document).on('change', '.product-select', function() {
        let price = parseFloat($(this).find(':selected').data('price')) || 0;
        let tr = $(this).closest('tr');

        tr.find('.unit-price').val(price);
        recalc();
    });

    // qty/discount/tax/shipping change
    $(document).on('input', '.qty, #discount, #tax, #shipping', recalc);

    // add new row
    $('#add-row').click(function() {
        let raw = $('#sale-items tbody tr:first')[0].outerHTML;
        let $clone = $(raw);

        $clone.find('select').val('');
        $clone.find('.qty').val(1);
        $clone.find('.unit-price, .total').val('');

        $clone.find('input,select').each(function() {
            let name = $(this).attr('name');
            if (name) {
                $(this).attr('name', name.replace(/\[\d+\]/, '[' + row + ']'));
            }
        });

        $('#sale-items tbody').append($clone);
        row++;
    });

    // remove row
    $(document).on('click', '.remove-row', function() {
        if ($('#sale-items tbody tr').length > 1) {
            $(this).closest('tr').remove();
            recalc();
        }
    });

    // Paid checkbox change
    $('#paid').change(function () {
        updatePaidAndDue();
    });

    // init
    recalc();
</script>
@endsection
