<script>
    let row = 1;
    let currentCategoryId = null;
    const productsCache = {}; // {catId: [{id, name, selling_price}, ...]}

    function two(x){ return (parseFloat(x)||0).toFixed(2); }

    function recalc() {
        let subtotal = 0;
        $('#sale-items tbody tr').each(function() {
            let qty  = parseFloat($(this).find('.qty').val()) || 0;
            let unit = parseFloat($(this).find('.unit-price').val()) || 0;
            let total = qty * unit;
            $(this).find('.total').val(two(total));
            subtotal += total;
        });

        $('#subtotal').val(two(subtotal));

        let discount = Math.max(0, parseFloat($('#discount').val()) || 0);
        let tax      = Math.max(0, parseFloat($('#tax').val()) || 0);
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
        let paid  = parseFloat($('#paid_amount').val()) || 0;

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
                $select.append('<option value="'+v.id+'" data-price="'+v.selling_price+'">'+v.name+'</option>');
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
            data: { category_id: catId, _token: '{{ csrf_token() }}' },
            success: function (result) {
                productsCache[catId] = result || [];
                populate(productsCache[catId]);
            }
        });
    }

    // When Category changes: only update the FIRST EMPTY product-select; do not touch already selected ones
    $('#category_id').on('change', function () {
        currentCategoryId = this.value;

        // find first empty product-select; if none exists, optionally add a new row
        let $emptySelect = $('.product-select').filter(function(){ return !$(this).val(); }).first();

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
    $(document).on('input', '.qty, #discount, #tax, #shipping, #paid_amount', function(){
        recalc();
    });

    // Paid checkbox change
    $('#paid').change(function () { updatePaidAndDue(); });

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

    $('#add-row').click(function(){ addRow(); });

    // remove row
    $(document).on('click', '.remove-row', function() {
        if ($('#sale-items tbody tr').length > 1) {
            $(this).closest('tr').remove();
            recalc();
        }
    });

    // Validate at least one product selected before submit
    $('#saleForm').submit(function (e) {
        const hasAny = $('.product-select').filter(function(){ return $(this).val(); }).length > 0;
        if (!hasAny) {
            e.preventDefault();
            alert("Please select at least one product.");
        }
    });

    // Initial calc
    recalc();
</script>