@extends('layouts.app')
@section('title', 'Product Stock Add')
@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form id="stockForm" method="POST">
                        @csrf
                        <div class="row mt-3">

                            <div class="form-group col-md-6">
                                <label for="Product">Product <span class="text-danger">*</span></label>
                                <select class="form-control select2" name="product_id" id="product_id" required>
                                    <option selected disabled>-- Select Product --</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">
                                            {{ $product->name }}  ---  ({{ $product->stock }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="Product">Stock Status <span class="text-danger">*</span></label>
                                <select class="form-control" name="stock_status" id="stock_status" required>
                                    <option value="In">In</option>
                                    <option value="Out">Out</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="stock">Quantity</label>
                                <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock') }}" required min="1">
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="display_randData form-group col-md-12"></div>

                        </div>

                        <div class="row mt-3">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary" id="submitBtn">Update</button>
                            </div>
                        </div>
                    </form>

                    <div id="ajaxMessage" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
$('.select2').select2();

// Product select change AJAX (optional)
$('#product_id').on('change', function () {
    var prod_id = this.value;
    $.ajax({
        url: "{{ route('fetch_product') }}",
        type: "POST",
        data: { product_id: prod_id, _token: '{{ csrf_token() }}' },
        success: function(result){
            $('.display_randData').html(result);
        }
    });
});

// AJAX submit form
$(document).ready(function(){

    // prevent duplicate binds
    $('#stockForm').off('submit').on('submit', function(e){
        e.preventDefault(); // stop normal submit

        $('#submitBtn').attr('disabled', true);
        $('#ajaxMessage').html('');

        $.ajax({
            url: "{{ route('products.stock.update') }}",
            type: 'POST',
            data: $(this).serialize(),
            success: function(res){
                if(res.success){
                    $('#ajaxMessage').html('<div class="alert alert-success">'+res.message+'</div>');

                    // Update dropdown stock
                    let option = $('#product_id option:selected');
                    let name = option.text().split('---')[0].trim();
                    option.text(name + ' --- ('+res.new_stock+')');

                    $('#stock').val('');
                } else {
                    $('#ajaxMessage').html('<div class="alert alert-danger">'+res.message+'</div>');
                }
            },
            error: function(xhr){
                if(xhr.status === 422){
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value){
                        $('#'+key).siblings('.invalid-feedback').text(value[0]);
                    });
                } else {
                    $('#ajaxMessage').html('<div class="alert alert-danger">Something went wrong!</div>');
                }
            },
            complete: function(){
                $('#submitBtn').attr('disabled', false);
            }
        });
    });

});

</script>
@endsection
