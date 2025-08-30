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

    function updatePaidAndDue() {
    let grand = parseFloat($('#grand_total').val()) || 0;

    if ($('#paid').is(':checked')) {
        $('#paidAmountBox').show();
        $('#paid_amount').val(grand.toFixed(2)); // Paid = Grand Total
        $('#due_amount').val('0.00');            // Due = 0
    } else {
        $('#paidAmountBox').hide();
        $('#paid_amount').val(0);
        $('#due_amount').val(grand.toFixed(2));
    }
}

    // product select change
    $(document).on('change', '.product-select', function() {
        let price = parseFloat($(this).find(':selected').data('price')) || 0;
        let tr = $(this).closest('tr');
        tr.find('.unit-price').val(price);
        recalc();
    });

    // qty/discount/tax/shipping/paid_amount change
    $(document).on('input', '.qty, #discount, #tax, #shipping, #paid_amount', recalc);

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

    // Validate at least one product
    $('#saleForm').submit(function (e) {
        if ($('.product-select').filter(function() { return $(this).val(); }).length === 0) {
            e.preventDefault();
            alert("Please select at least one product.");
        }
    });

    // Category change → fetch products
    $('#category_id').on('change', function () {
        var cat_id = this.value;

        $.ajax({
            url: "{{ route('fetch_product_by_category') }}",
            type: "POST",
            data: {
                category_id: cat_id,
                _token: '{{ csrf_token() }}'
            },
            success: function (result) {
                $('.product-select').each(function () {
                    let select = $(this);
                    select.html('<option value="">Select Product</option>');
                    $.each(result, function (key, value) {
                        select.append('<option value="' + value.id + '" data-price="' + value.selling_price + '">' + value.name + '</option>');
                    });
                });
            }
        });
    });

    // init
    recalc();
</script>
