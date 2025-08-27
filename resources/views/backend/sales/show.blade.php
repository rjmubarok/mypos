@extends('layouts.app')
@section('title', 'Sales Show')
@section('content')
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Invoice #{{ $sale->invoice_no }}</h4>
            <a href="{{ route('sale.index') }}" class="btn btn-secondary">← Back to Sales</a>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6>Customer</h6>
                        <p>
                            {{ $sale->customer->name ?? 'Walk-in Customer' }} <br>
                            {{ $sale->customer->phone ?? '' }} <br>
                            {{ $sale->customer->email ?? '' }}
                        </p>
                    </div>
                    <div class="col-md-6 text-end">
                        <h6>Sale Info</h6>
                        <p>
                            Date:{{ \Carbon\Carbon::parse($sale->sold_at)->format('d M Y, h:i A') }}<br>
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
                                <span class="badge bg-warning">Partial</span>
                            @elseif ($sale->payment_status == 'unpaid')
                                <span class="badge bg-danger">Unpaid</span>
                            @else
                                <span class="badge bg-secondary">Refunded</span>
                            @endif
                        </p>
                    </div>
                </div>

                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            
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
                                <td>{{ $item->product_name }}</td>
                                
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->product->unit ?? '-' }}</td>
                                <td>{{ number_format($item->unit_price ?? 0, 2) }}</td>
                                <td>{{ number_format($item->total ?? 0, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <h6>Notes</h6>
                        <p>{{ $sale->note ?? '---' }}</p>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm">
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
                                <td class="text-end">{{ number_format($sale->paid_amount, 2) }}</td>
                            </tr>
                            <tr>
                                <th class="text-end">Due:</th>
                                <td class="text-end">{{ number_format($sale->due_amount, 2) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
