{{-- resources/views/products/show.blade.php --}}
@extends('layouts.app')

@section('title', $product->name . ' | Product Details')

@section('content')
<div class="container py-4">

    {{-- Breadcrumbs --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Products</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        {{-- Left: Image & Barcode --}}
        <div class="col-12 col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    {{-- Product Image --}}
                    @if(!empty($product->image))
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded mb-3" style="max-height: 260px; object-fit: contain;">
                    @else
                        <div class="border rounded d-flex align-items-center justify-content-center mb-3" style="height:260px;">
                            <span class="text-muted">No Image</span>
                        </div>
                    @endif

                    {{-- SKU --}}
                    <div class="small text-muted mb-1">SKU</div>
                    <div class="fw-semibold mb-3">{{ $product->sku ?? '—' }}</div>

                    {{-- Barcode (Milon/Barcode প্যাকেজ থাকলে) --}}
                    @if(!empty($product->barcode))
                        <div class="small text-muted mb-1">Barcode</div>
                        <div class="mb-2">
                            {{-- উদাহরণ: Code128 --}}
                            {!! DNS1D::getBarcodeHTML($product->barcode, 'C128', 2, 60) !!}
                        </div>
                        <div class="fw-semibold">{{ $product->barcode }}</div>
                    @else
                        <span class="badge bg-secondary">No Barcode</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Right: Details --}}
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    {{-- Header --}}
                    <div class="d-flex flex-wrap align-items-start justify-content-between mb-2">
                        <div>
                            <h4 class="mb-1">{{ $product->name }}</h4>
                            <div class="text-muted small">
                                Slug: <code>{{ $product->slug }}</code>
                            </div>
                        </div>
                        <div>
                            @if($product->status)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </div>
                    </div>

                    {{-- Meta chips --}}
                    <div class="mb-3">
                        <span class="badge bg-light text-dark me-2">
                            Category: {{ optional($product->category)->name ?? '—' }}
                        </span>
                        <span class="badge bg-light text-dark me-2">
                            Brand: {{ optional($product->brand)->name ?? '—' }}
                        </span>
                        <span class="badge bg-light text-dark me-2">
                            Supplier: {{ optional($product->supplier)->name ?? '—' }}
                        </span>
                    </div>

                    {{-- Price & Stock --}}
                    <div class="row g-3 mb-3">
                        <div class="col-6 col-md-4">
                            <div class="border rounded p-3 h-100">
                                <div class="text-muted small">Purchase Price</div>
                                <div class="fs-5 fw-semibold">৳ {{ number_format((float)$product->purchase_price, 2) }}</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="border rounded p-3 h-100">
                                <div class="text-muted small">Selling Price</div>
                                <div class="fs-5 fw-semibold">৳ {{ number_format((float)$product->selling_price, 2) }}</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="border rounded p-3 h-100">
                                <div class="text-muted small">Stock</div>
                                <div class="fs-5 fw-semibold">{{ (int)$product->stock }}</div>
                            </div>
                        </div>
                    </div>

                    {{-- Optional: Profit info --}}
                    @php
                        $profit = (float)$product->selling_price - (float)$product->purchase_price;
                        $margin = $product->selling_price > 0 ? ($profit / (float)$product->selling_price) * 100 : 0;
                    @endphp
                    <div class="alert alert-light border d-flex justify-content-between align-items-center">
                        <div>
                            <strong>Profit:</strong> ৳ {{ number_format($profit, 2) }}
                            <span class="text-muted">({{ number_format($margin, 1) }}%)</span>
                        </div>
                        @if($product->alert_quantity !== null)
                            <div>
                                <strong>Alert Qty:</strong> {{ (int)$product->alert_quantity }}
                                @if($product->stock <= $product->alert_quantity)
                                    <span class="badge bg-warning text-dark ms-2">Low stock</span>
                                @endif
                            </div>
                        @endif
                    </div>

                    {{-- Description --}}
                    <div class="mb-3">
                        <h6 class="mb-2">Description</h6>
                        <div class="text-secondary">
                            {!! nl2br(e($product->description ?? 'No description')) !!}
                        </div>
                    </div>

                    {{-- Created / Updated --}}
                    <div class="small text-muted">
                        Created: {{ optional($product->created_at)->format('M d, Y h:i A') ?? '—' }} |
                        Updated: {{ optional($product->updated_at)->format('M d, Y h:i A') ?? '—' }}
                    </div>
                </div>

                <div class="card-footer d-flex gap-2 justify-content-between flex-wrap">
                    <div class="d-flex gap-2">
                        {{-- Edit --}}
                        <a href="{{ route('product.edit', $product->slug) }}" class="btn btn-primary">
                            Edit
                        </a>

                        {{-- If you prefer slug-based edit route:
                        <a href="{{ route('product.edit', $product->slug) }}" class="btn btn-primary">Edit</a>
                        --}}

                        {{-- Back --}}
                        <a href="{{ route('product.index') }}" class="btn btn-outline-secondary">
                            Back to List
                        </a>
                    </div>

                    {{-- Delete --}}
                    <form action="{{ route('product.destroy', $product->id) }}" method="POST"
                          onsubmit="return confirm('Delete this product?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
