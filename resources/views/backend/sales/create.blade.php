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

        .table td,
        .table th {
            vertical-align: middle;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <h3>Create Sale</h3>

        <form action="{{ route('sale.store') }}" method="POST" id="saleForm">
            @csrf

            <!-- Customer & Payment Info -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="category_id">Category <span class="text-danger">*</span></label>
                    <select class="form-control select2" id="category_id" name="category_id" required>
                        <option selected disabled>-- Select Category --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label>Customer</label>
                    <select id="customerSelect" name="customer_id" class="form-control">
                        <option value="">Select Customer</option>
                        <option value="guest">Walk-in Customer (Guest)</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Extra fields (hidden by default) -->
                <div class="col-md-4 d-none" id="guestFields">
                    <label>Guest Name</label>
                    <input type="text" name="guest_name" class="form-control" placeholder="Enter Guest Name">
                </div>

                <div class="col-md-4 d-none" id="guestPhoneField">
                    <label>Guest Phone</label>
                    <input type="text" name="guest_phone" class="form-control" placeholder="Enter Guest Phone">
                </div>

                <div class="col-md-4">
                    <label>Sold At</label>
                    <input type="datetime-local" name="sold_at" class="form-control"
                        value="{{ now()->format('Y-m-d\TH:i') }}">
                </div>

                <div class="col-md-4 mt-2">
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
                        <th width="140">Unit Price</th>
                        <th width="140">Total</th>
                        <th width="50">#</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <select name="items[0][product_id]" class="form-control product-select" required>
                                <option value="">-- select --</option>
                                @foreach ($products as $p)
                                    <option value="{{ $p->id }}" data-price="{{ $p->selling_price }}">
                                        {{ $p->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" name="items[0][quantity]" value="1" class="form-control qty"
                                min="1">
                        </td>
                        <td>
                            <input type="number" name="items[0][unit_price]" class="form-control unit-price" step="0.01"
                                readonly>
                        </td>
                        <td>
                            <input type="number" name="items[0][total]" class="form-control total" step="0.01" readonly>
                        </td>
                        <td class="text-center">
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
                    <input type="number" step="0.01" min="0" name="discount" id="discount" class="form-control"
                        value="0">
                </div>
                <div class="col-md-3">
                    <label>Tax</label>
                    <input type="number" step="0.01" min="0" name="tax" id="tax" class="form-control"
                        value="0">
                </div>
                <div class="col-md-3">
                    <label>Shipping</label>
                    <input type="number" step="0.01" min="0" name="shipping" id="shipping"
                        class="form-control" value="0">
                </div>
                <div class="col-md-3 mt-2">
                    <label>Grand Total</label>
                    <input type="number" step="0.01" name="grand_total" id="grand_total" class="form-control"
                        readonly>
                </div>

                <!-- Paid Section -->
                <div class="col-md-3 mt-2">
                    <label for="paid">Paid</label><br>
                    <input type="checkbox" id="paid" name="paid" value="1">
                </div>

                <div class="col-md-3 mt-2" id="paidAmountBox" style="display:none;">
                    <label>Paid Amount</label>
                    <input type="number" step="0.01" id="paid_amount" name="paid_amount" class="form-control"
                        value="0">
                </div>

                <div class="col-md-3 mt-2">
                    <label>Due Amount</label>
                    <input type="number" step="0.01" name="due_amount" id="due_amount" class="form-control"
                        readonly>
                </div>
            </div>

            <button type="submit" class="btn btn-success mt-3">Save Sale</button>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        let row = 1;
        let currentCategoryId = null;
        const productsCache = {}; // {catId: [{id, name, selling_price}, ...]}

        function two(x) {
            return (parseFloat(x) || 0).toFixed(2);
        }

        function recalc() {
            let subtotal = 0;
            $('#sale-items tbody tr').each(function() {
                let qty = parseFloat($(this).find('.qty').val()) || 0;
                let unit = parseFloat($(this).find('.unit-price').val()) || 0;
                let total = qty * unit;
                $(this).find('.total').val(two(total));
                subtotal += total;
            });

            $('#subtotal').val(two(subtotal));

            let discount = Math.max(0, parseFloat($('#discount').val()) || 0);
            let tax = Math.max(0, parseFloat($('#tax').val()) || 0);
            let shipping = Math.max(0, parseFloat($('#shipping').val()) || 0);

            $('#discount').val(two(discount));
            $('#tax').val(two(tax));
            $('#shipping').val(two(shipping));

            let grand = subtotal - discount + tax + shipping;
            $('#grand_total').val(two(grand));

            updatePaidAndDue();
        }

        function updatePaidAndDue() {
            let grand = parseFloat($('#grand_total').val()) || 0;
            let paid = parseFloat($('#paid_amount').val()) || 0;

            if ($('#paid').is(':checked')) {
                $('#paidAmountBox').show();

                // default first time to full paid if 0 and grand > 0
                if (paid === 0 && grand > 0) {
                    $('#paid_amount').val(two(grand));
                    paid = grand;
                }
                let due = Math.max(0, grand - paid);
                $('#due_amount').val(two(due));
            } else {
                $('#paidAmountBox').hide();
                $('#paid_amount').val(two(0));
                $('#due_amount').val(two(grand));
            }
        }

        // Load products for a given select (single dropdown), by category id
        function loadProductsForSelect($select, catId) {
            if (!catId) return;

            function populate(list) {
                const prevVal = $select.val(); // keep as-is if already chosen (we only call on empty selects)
                $select.html('<option value="">Select Product</option>');
                $.each(list, function(_, v) {
                    $select.append('<option value="' + v.id + '" data-price="' + v.selling_price + '">' + v.name +
                        '</option>');
                });
                // do not override if there was a value (safety); but normally we'll call only on empty selects
                if (!prevVal) $select.val('');
            }

            if (productsCache[catId]) {
                populate(productsCache[catId]);
                return;
            }

            $.ajax({
                url: "{{ route('fetch_product_by_category') }}",
                type: "POST",
                data: {
                    category_id: catId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(result) {
                    productsCache[catId] = result || [];
                    populate(productsCache[catId]);
                }
            });
        }

        // When Category changes: only update the FIRST EMPTY product-select; do not touch already selected ones
        $('#category_id').on('change', function() {
            currentCategoryId = this.value;

            // find first empty product-select; if none exists, optionally add a new row
            let $emptySelect = $('.product-select').filter(function() {
                return !$(this).val();
            }).first();

            if ($emptySelect.length === 0) {
                // no empty row → add a new one and populate it
                addRow();
                $emptySelect = $('#sale-items tbody tr:last').find('.product-select');
            }
            loadProductsForSelect($emptySelect, currentCategoryId);
        });

        // on product change → set unit price and recalc
        $(document).on('change', '.product-select', function() {
            let price = parseFloat($(this).find(':selected').data('price')) || 0;
            let tr = $(this).closest('tr');
            tr.find('.unit-price').val(two(price));
            recalc();
        });

        // qty/discount/tax/shipping/paid_amount change
        $(document).on('input', '.qty, #discount, #tax, #shipping, #paid_amount', function() {
            recalc();
        });

        // Paid checkbox change
        $('#paid').change(function() {
            updatePaidAndDue();
        });

        // Add new row
        function addRow() {
            let raw = $('#sale-items tbody tr:first')[0].outerHTML;
            let $clone = $(raw);

            // reset fields
            $clone.find('.product-select').html('<option value="">-- select --</option>').val('');
            $clone.find('.qty').val(1);
            $clone.find('.unit-price, .total').val('');

            // rename inputs with next index
            $clone.find('input,select').each(function() {
                let name = $(this).attr('name');
                if (name) $(this).attr('name', name.replace(/\[\d+\]/, '[' + row + ']'));
            });

            $('#sale-items tbody').append($clone);
            row++;

            // populate by current category if set
            if (currentCategoryId) {
                loadProductsForSelect($('#sale-items tbody tr:last').find('.product-select'), currentCategoryId);
            }
        }

        $('#add-row').click(function() {
            addRow();
        });

        // remove row
        $(document).on('click', '.remove-row', function() {
            if ($('#sale-items tbody tr').length > 1) {
                $(this).closest('tr').remove();
                recalc();
            }
        });

        // Validate at least one product selected before submit
        $('#saleForm').submit(function(e) {
            const hasAny = $('.product-select').filter(function() {
                return $(this).val();
            }).length > 0;
            if (!hasAny) {
                e.preventDefault();
                alert("Please select at least one product.");
            }
        });

        // Initial calc
        recalc();
    </script>
<script>
    document.getElementById('customerSelect').addEventListener('change', function () {
        let guestFields = document.getElementById('guestFields');
        let guestPhone = document.getElementById('guestPhoneField');

        if (this.value === 'guest') {
            guestFields.classList.remove('d-none');
            guestPhone.classList.remove('d-none');
        } else {
            guestFields.classList.add('d-none');
            guestPhone.classList.add('d-none');
        }
    });
</script>
@endsection
