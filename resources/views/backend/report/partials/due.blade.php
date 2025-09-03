<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th><th>Date</th><th>Invoice</th><th>Customer</th><th>Due Amount</th>
        </tr>
    </thead>
    <tbody>
        @foreach($dueSales as $key => $sale)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $sale->sold_at }}</td>
            <td>{{ $sale->invoice_no }}</td>
            <td>{{ $sale->customer->name ?? 'N/A' }}</td>
            <td>{{ $sale->due_amount }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
