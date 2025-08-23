@extends('layouts.app')
@section('title', 'Product Add')
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
                        </div>

                    </div>
                    <div class="card-body">
                        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <!-- Category -->
                                <div class="col-md-4 mb-3">
                                    <label for="category_id" class="form-label">Category <span
                                            class="text-danger">*</span></label>
                                    <select name="category_id" id="category_id" class="form-select" required>
                                        <option value="">-- Select Category --</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Brand -->
                                <div class="col-md-4 mb-3">
                                    <label for="brand_id" class="form-label">Brand</label>
                                    <select name="brand_id" id="brand_id" class="form-select">
                                        <option value="">-- Select Brand --</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}"
                                                {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Supplier -->
                                <div class="col-md-4 mb-3">
                                    <label for="supplier_id" class="form-label">Supplier</label>
                                    <select name="supplier_id" id="supplier_id" class="form-select">
                                        <option value="">-- Select Supplier --</option>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}"
                                                {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                                {{ $supplier->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Product Name -->
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Product Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ old('name') }}" required>
                                </div>

                                <!-- Purchase Price -->
                                <div class="col-md-3 mb-3">
                                    <label for="purchase_price" class="form-label">Purchase Price <span
                                            class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="purchase_price" id="purchase_price"
                                        class="form-control" value="{{ old('purchase_price', '0.00') }}">
                                </div>

                                <!-- Selling Price -->
                                <div class="col-md-3 mb-3">
                                    <label for="selling_price" class="form-label">Selling Price <span
                                            class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="selling_price" id="selling_price"
                                        class="form-control" value="{{ old('selling_price', '0.00') }}">
                                </div>

                                <!-- Stock -->
                                <div class="col-md-2 mb-3">
                                    <label for="stock" class="form-label">Stock <span
                                            class="text-danger">*</span></label>
                                    <input type="number" name="stock" id="stock" class="form-control"
                                        value="{{ old('stock', '0') }}">
                                </div>

                                <!-- SKU -->
                                <div class="col-md-4 mb-3">
                                    <label for="sku" class="form-label">SKU</label>
                                    <input type="text" name="sku" id="sku" class="form-control"
                                        value="{{ old('sku') }}">
                                </div>

                                <!-- Image -->
                                <div class="col-md-4 mb-3">
                                    <label for="image" class="form-label">Product Image</label>
                                    <input type="file" name="image" id="image" class="form-control">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <img id="photo_preview-image" src="" alt="preview image"
                                        style="max-height: 100px; max-width: 100px;">
                                </div>

                                <!-- Description -->
                                <div class="col-md-12 mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" rows="3" class="form-control">{{ old('description') }}</textarea>
                                </div>

                                <!-- Alert Quantity -->
                                <div class="col-md-3 mb-3">
                                    <label for="alert_quantity" class="form-label">Alert Quantity</label>
                                    <input type="number" name="alert_quantity" id="alert_quantity" class="form-control"
                                        value="{{ old('alert_quantity', '5') }}">
                                </div>

                                <!-- Status -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <div class="form-check">
                                        <input type="radio" name="status" id="statusActive" value="1"
                                            class="form-check-input" {{ old('status', 1) == 1 ? 'checked' : '' }}>
                                        <label for="statusActive" class="form-check-label">Active</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" name="status" id="statusInactive" value="0"
                                            class="form-check-input" {{ old('status') == 0 ? 'checked' : '' }}>
                                        <label for="statusInactive" class="form-check-label">Inactive</label>
                                    </div>
                                </div>

                                <!-- Submit -->
                                <div class="col-md-12 text-end">
                                    <button type="submit" class="btn btn-primary">Save Product</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection


@section('scripts')
    <script type="text/javascript">
        $('#image').change(function() {

            let reader = new FileReader();
            reader.onload = (e) => {
                $('#photo_preview-image').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);

        });
    </script>
@endsection
