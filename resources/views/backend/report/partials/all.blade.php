<table id="sales-report" class="table table-bordered">
    <thead>
        <tr>
            <th>#</th><th>Date</th><th>Invoice</th><th>Customer</th><th>Products</th><th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($sales as $key => $sale)
        <tr>
            <td>{{ $key+1 }}</td>
        <td>{{ \Carbon\Carbon::parse($sale->sold_at)->format('d M, Y h:i A') }}</td>


            <td>{{ $sale->invoice_no }}</td>
            <td>{{ $sale->customer->name ?? 'N/A' }}</td>
            <td>
                <ul>
                    @foreach($sale->items as $item)
                        <li>{{ $item->product->name ?? 'N/A' }} ({{ $item->quantity }} * {{ $item->product->selling_price }})</li>
                    @endforeach
                </ul>
            </td>
            <td>{{ $sale->grand_total }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<script>
$(document).ready(function() {
    $('#sales-report').DataTable({
    });
});
</script>
