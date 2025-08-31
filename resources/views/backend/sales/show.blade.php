@extends('layouts.app')
@section('title', 'Sales Show')

@section('styles')
<style>
    .invoice-box {
        background: #fff;
        border: 1px solid #e5e5e5;
        padding: 25px;
        border-radius: 10px;
    }
    .invoice-header {
        border-bottom: 2px solid #f0f0f0;
        margin-bottom: 20px;
        padding-bottom: 10px;
    }
    .table th {
        background: #f8f9fa;
    }
    .table-dark th {
        background: #343a40 !important;
        color: #fff !important;
    }
    .summary-table th {
        width: 50%;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">🧾 Invoice #{{ $sale->invoice_no }}</h3>
        <a href="{{ route('sale.index') }}" class="btn btn-outline-secondary btn-sm">← Back to Sales</a>
    </div>

    <div class="invoice-box shadow-sm">
        <!-- Header -->
        <div class="row invoice-header">
            <div class="col-md-6">
                <h6 class="text-uppercase fw-bold">Customer Info</h6>
                <p class="mb-0">
                    <strong>{{ $sale->customer->name ?? 'Walk-in Customer' }}</strong><br>
                    {{ $sale->customer->phone ?? '' }} <br>
                    {{ $sale->customer->email ?? '' }}
                </p>
            </div>
            <div class="col-md-6 text-end">
                <h6 class="text-uppercase fw-bold">Sale Info</h6>
                <p class="mb-0">
                    Date: <strong>{{ \Carbon\Carbon::parse($sale->sold_at)->format('d M Y, h:i A') }}</strong><br>
                    Status:
                    @if ($sale->status == 'completed')
                        <span class="badge bg-primary">Completed</span>
                    @elseif ($sale->status == 'draft')
                        <span class="badge bg-secondary">Draft</span>
                    @else
                        <span class="badge bg-danger">Void</span>
                    @endif
                    <br>
                    Payment:
                    @if ($sale->payment_status == 'paid')
                        <span class="badge bg-success">Paid</span>
                    @elseif ($sale->payment_status == 'partial')
                        <span class="badge bg-warning text-dark">Partial</span>
                    @elseif ($sale->payment_status == 'unpaid')
                        <span class="badge bg-danger">Unpaid</span>
                    @else
                        <span class="badge bg-secondary">Refunded</span>
                    @endif
                </p>
            </div>
        </div>

        <!-- Items -->
        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th class="text-start">Product</th>
                        <th>Qty</th>
                        <th>Unit</th>
                        <th>Unit Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sale->items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-start">{{ $item->product_name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->product->unit ?? '-' }}</td>
                            <td>{{ number_format($item->unit_price ?? 0, 2) }}</td>
                            <td><strong>{{ number_format($item->total ?? 0, 2) }}</strong></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Notes & Summary -->
        <div class="row mt-4">
            <div class="col-md-6">
                <h6 class="fw-bold">Notes</h6>
                <div class="border rounded p-2" style="min-height:80px;">
                    {{ $sale->note ?? '---' }}
                </div>
            </div>
            <div class="col-md-6">
                <table class="table summary-table">
                    <tr>
                        <th class="text-end">Subtotal:</th>
                        <td class="text-end">{{ number_format($sale->subtotal, 2) }}</td>
                    </tr>
                    <tr>
                        <th class="text-end">Discount:</th>
                        <td class="text-end">-{{ number_format($sale->discount, 2) }}</td>
                    </tr>
                    <tr>
                        <th class="text-end">Tax:</th>
                        <td class="text-end">{{ number_format($sale->tax, 2) }}</td>
                    </tr>
                    <tr>
                        <th class="text-end">Shipping:</th>
                        <td class="text-end">{{ number_format($sale->shipping, 2) }}</td>
                    </tr>
                    <tr class="table-dark">
                        <th class="text-end">Grand Total:</th>
                        <td class="text-end"><strong>{{ number_format($sale->grand_total, 2) }}</strong></td>
                    </tr>
                    <tr>
                        <th class="text-end">Paid:</th>
                        <td class="text-end text-success fw-bold">{{ number_format($sale->paid_amount, 2) }}</td>
                    </tr>
                    <tr>
                        <th class="text-end">Due:</th>
                        <td class="text-end text-danger fw-bold">{{ number_format($sale->due_amount, 2) }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
