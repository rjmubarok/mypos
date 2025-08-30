@extends('layouts.app')
@section('title', 'Multiple Product Add')
@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('product.create') }}" class="btn btn-info btn-sm"><i
                                    class="bi bi-plus-circle"></i>
                                Add New Product</a>
                            <a href="{{ route('product.index') }}" class="btn btn-info btn-sm"><i
                                    class="bi bi-list-task"></i>
                                Product List</a>
                            <a href="{{ route('multiproduct.add') }}" class="btn btn-info btn-sm"><i
                                    class="bi bi-list-task"></i>
                                Product List</a>
                        </div>

                    </div>
                    <div class="card-body">
                        <form action="{{ route('product.storeMultiple') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div id="products-wrapper">
                                <div class="row product-item border p-3 mb-3">
                                    <!-- Category -->
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Category <span class="text-danger">*</span></label>
                                        <select name="products[0][category_id]" class="form-select " required>
                                            <option value="">-- Select Category --</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Brand -->
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Brand</label>
                                        <select name="products[0][brand_id]" class="form-select ">
                                            <option value="">-- Select Brand --</option>
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Supplier -->
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Supplier</label>
                                        <select name="products[0][supplier_id]" class="form-select ">
                                            <option value="">-- Select Supplier --</option>
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Product Name -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Product Name <span class="text-danger">*</span></label>
                                        <input type="text" name="products[0][name]" class="form-control" required>
                                    </div>

                                    <!-- Purchase Price -->
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Purchase Price <span class="text-danger">*</span></label>
                                        <input type="number" name="products[0][purchase_price]" class="form-control"
                                            required>
                                    </div>

                                    <!-- Selling Price -->
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Selling Price <span class="text-danger">*</span></label>
                                        <input type="number" name="products[0][selling_price]" class="form-control"
                                            required>
                                    </div>

                                    <!-- Stock -->
                                    <div class="col-md-2 mb-3">
                                        <label class="form-label">Stock <span class="text-danger">*</span></label>
                                        <input type="number" name="products[0][stock]" class="form-control" required>
                                    </div>

                                    <!-- SKU -->
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">SKU</label>
                                        <input type="text" name="products[0][sku]" class="form-control">
                                    </div>

                                    <!-- Image -->
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Product Image</label>
                                        <input type="file" name="products[0][image]" class="form-control product-image"
                                            accept="image/*">
                                        <img src="" alt="Preview" class="img-thumbnail mt-2 d-none preview-img"
                                            style="width: 100px; height: 100px;">
                                    </div>

                                    <!-- Description -->
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea name="products[0][description]" rows="3" class="form-control"></textarea>
                                    </div>

                                    <!-- Alert Quantity -->
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Alert Quantity</label>
                                        <input type="number" name="products[0][alert_quantity]" class="form-control"
                                            value="2">
                                    </div>

                                    <!-- Status -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Status</label>
                                        <div class="form-check">
                                            <input type="radio" name="products[0][status]" value="1"
                                                class="form-check-input" checked>
                                            <label class="form-check-label">Active</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" name="products[0][status]" value="0"
                                                class="form-check-input">
                                            <label class="form-check-label">Inactive</label>
                                        </div>
                                    </div>

                                    <!-- Remove button -->
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="button" class="btn btn-danger remove-product">Remove</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Add More Button -->
                            <div class="mb-3">
                                <button type="button" class="btn btn-success" id="add-product">+ Add More</button>
                            </div>

                            <!-- Submit -->
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Save Products</button>
                            </div>
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </section>
@endsection


@section('scripts')
    <script>
       function handleImagePreview(input) {
    const file = input.files[0];
    const preview = input.closest('.col-md-4').querySelector('.preview-img');

    if (file) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    } else {
        preview.src = '';
        preview.classList.add('d-none');
    }
}

// First product image preview
document.addEventListener('change', function (e) {
    if (e.target.classList.contains('product-image')) {
        handleImagePreview(e.target);
    }
});

// Clone product item
let index = 1;
document.getElementById('add-product').addEventListener('click', function() {
    let wrapper = document.getElementById('products-wrapper');
    let newItem = document.querySelector('.product-item').cloneNode(true);

    // Clear input values
    newItem.querySelectorAll('input, textarea, select').forEach(input => {
        if (input.tagName === 'SELECT') {
            input.selectedIndex = 0;
        } else if (input.type !== 'radio') {
            input.value = '';
        }
        if (input.type === 'radio') {
            input.checked = input.value == 1; // default Active
        }
        input.name = input.name.replace(/\[\d+\]/, `[${index}]`);
    });

    // Reset preview image
    newItem.querySelectorAll('.preview-img').forEach(img => {
        img.src = '';
        img.classList.add('d-none');
    });

    wrapper.appendChild(newItem);
    index++;
});

// Remove product
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-product')) {
        if (document.querySelectorAll('.product-item').length > 1) {
            e.target.closest('.product-item').remove();
        }
    }
});
    </script>

@endsection
