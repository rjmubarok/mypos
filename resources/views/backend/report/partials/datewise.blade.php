<a href="{{ route('sales.report.datewise.pdf', ['start_date' => request()->start_date, 'end_date' => request()->end_date]) }}" class="btn btn-primary mb-3">Download PDF</a>
<table id="AllproductTable" class="table table-striped table-bordered table-hover">
    <thead class="table-primary">
        <tr>
            <th>#</th>
            <th>Date & Time</th>
            <th>Invoice</th>
            <th>Customer</th>
            <th>Products</th>
            <th>Payment Status</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($sales as $key => $sale)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ \Carbon\Carbon::parse($sale->sold_at)->format('d M, Y h:i A') }}</td>
            <td>{{ $sale->invoice_no }}</td>
            <td>{{ $sale->customer->name ?? 'N/A' }}</td>
            <td>
                <ul class="mb-0 ps-3">
                    @foreach($sale->items as $item)
                        <li>
                            {{ $item->product->name ?? 'N/A' }} 
                            ({{ $item->quantity }} × {{ number_format($item->product->selling_price, 2) }})
                        </li>
                    @endforeach
                </ul>
            </td>
             <td>{{ $sale->payment_status }}</td>
            <td>{{ number_format($sale->grand_total, 2) }}</td>
           
        </tr>
        @endforeach
    </tbody>
</table>

@section('scripts')
<script>
$(document).ready(function() {
    $('#AllproductTable').DataTable({
        "responsive": true,
        "autoWidth": false,
        "pageLength": 10,
        "lengthMenu": [5, 10, 25, 50],
        "order": [[1, "desc"]], // sold_at date desc
        "columnDefs": [
            { "orderable": false, "targets": [0, 4] } // # এবং Products column sorting off
        ]
    });
});
</script>
@endsection
