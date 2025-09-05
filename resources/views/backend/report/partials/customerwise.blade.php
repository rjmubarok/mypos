<div class="table-responsive">
<table class="table table-bordered table-hover align-middle">
    <thead class="table-primary text-center">
        <tr>
            <th>#</th>
            <th>Invoice No</th>
            <th>Date</th>
            <th>Products</th>
            <th>Total</th>
            <th>Paid</th>
            <th>Due</th>
        </tr>
    </thead>
    <tbody>
        @forelse($sales as $sale)
            <tr class="text-center">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $sale->invoice_no }}</td>
                <td>{{ \Carbon\Carbon::parse($sale->sold_at)->format('d-M-Y') }}</td>
                <td>
                    @foreach($sale->items as $item)
                        {{ $item->product->name ?? 'N/A' }}@if(!$loop->last)<br>@endif
                    @endforeach
                </td>
                <td>{{ number_format($sale->total_amount, 2) }}</td>
                <td>{{ number_format($sale->paid_amount, 2) }}</td>
                <td>{{ number_format($sale->due_amount, 2) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center text-danger">No sales found for this customer</td>
            </tr>
        @endforelse
    </tbody>
</table>
</div>
