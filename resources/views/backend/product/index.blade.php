@extends('layouts.app')
@section('title', 'Product list')
@section('content')

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('product.create') }}" class="btn btn-info btn-sm"><i
                                    class="bi bi-plus-circle"></i> Add New Product</a>

                        </div>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="productTable" class="table table-bordered table-striped align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Category</th>
                                        <th>Brand</th>
                                        <th>Supplier</th>
                                        <th>Product Name</th>
                                        <th>SKU</th>
                                        <th>Barcode</th>
                                        <th>Purchase Price</th>
                                        <th>Selling Price</th>
                                        <th>Stock</th>
                                        <th>Alert Qty</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($products as $key => $product)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>

                                            <!-- Image -->
                                            <td>
                                                @php
                                                    $img = $product->image ?? 'default.png';
                                                @endphp
                                                <img src="{{ asset($img) }}" alt="{{ $product->name ?? 'Product' }}"
                                                    width="50" height="50" class="rounded">
                                            </td>

                                            <!-- Relations -->
                                            <td>{{ $product->category->name ?? '—' }}</td>
                                            <td>{{ $product->brand->name ?? '—' }}</td>
                                            <td>{{ $product->supplier->name ?? '—' }}</td>

                                            <!-- Product Info -->
                                            <td>{{ $product->name ?? '—' }}</td>
                                            <td>{{ $product->sku ?? '—' }}</td>

                                            <!-- Barcode (safe) -->
                                            <td>
                                                @if (!empty($product->barcode))
                                                    {!! DNS1D::getBarcodeHTML('4445645656', 'PHARMA2T', 3, 40) !!}
                                                    <br>{{ $product->barcode }}
                                                @else
                                                    <span class="badge bg-secondary">No Barcode</span>
                                                @endif
                                            </td>

                                            <!-- Numbers -->
                                            <td>{{ number_format($product->purchase_price ?? 0, 2) }}</td>
                                            <td>{{ number_format($product->selling_price ?? 0, 2) }}</td>
                                            <td>{{ $product->stock ?? 0 }}</td>
                                            <td>
                                                @php
                                                    $alert = $product->alert_quantity ?? 5;
                                                    $stock = $product->stock ?? 0;
                                                @endphp
                                                @if ($stock <= $alert)
                                                    <span class="badge bg-danger">{{ $alert }}</span>
                                                @else
                                                    {{ $alert }}
                                                @endif
                                            </td>

                                            <!-- Status -->
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input status-toggle" type="checkbox"
                                                        data-id="{{ $product->id }}"
                                                        {{ $product->status == 1 ? 'checked' : '' }}>
                                                    <label
                                                        class="form-check-label {{ $product->status == 1 ? 'text-success' : 'text-danger' }}">
                                                        {{ $product->status == 1 ? 'Active' : 'Inactive' }}
                                                    </label>
                                                </div>
                                            </td>

                                            <!-- Action Buttons -->
                                            <td class="d-flex">
                                                <a href="{{ route('product.edit', $product->slug) }}"
                                                    class="btn btn-info btn-sm mr-2"><i class="bi bi-pencil-square"></i></a>
                                                <a href="{{ route('product.show', $product->slug) }}"
                                                    class="btn btn-secondary btn-sm mr-2"><i class="bi bi-eye"></i></a>
                                                <button class="deleteBtn btn btn-danger btn-sm"
                                                    data-url="{{ route('product.destroy', $product->id) }}"> <i
                                                        class="bi bi-trash"></i></button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="15" class="text-center text-muted">No products found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                        </div>

                    </div>
                </div>


            </div>
        </div>
    </section>

@endsection
@section('scripts')

    <script>
        // Delete Brand
        $(document).on('click', '.deleteBtn', function() {
            let id = $(this).data('id');
            let url = $(this).data("url");
            Swal.fire({
                title: "Are you sure?",
                text: "This action cannot be undone!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            _method: "DELETE"
                        },
                        success: function(res) {
                            Swal.fire("Deleted!", res.message, "success");
                            // Optionally remove row from table
                            location.reload();
                        },
                        error: function(xhr) {
                            Swal.fire("Error!", "Something went wrong.", "error");
                        }
                    });
                }
            });

        });
        $(document).on('change', '.status-toggle', function() {
            let id = $(this).data('id');
            let status = $(this).is(':checked') ? 1 : 0;
            let label = $(this).closest('.form-check').find('.form-check-label');

            $.post('/product/status-update', {
                _token: '{{ csrf_token() }}',
                id: id,
                status: status
            }, function(res) {
                label.text(status == 1 ? 'Active' : 'Inactive')
                    .removeClass('text-success text-danger')
                    .addClass(status == 1 ? 'text-success' : 'text-danger');
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#productTable').DataTable();
        });
    </script>
@endsection
