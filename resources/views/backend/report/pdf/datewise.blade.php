<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Date to Date Sales Report</title>
    <style>
        body { font-family: "DejaVu Sans", sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; }
        ul { margin: 0; padding-left: 18px; }
        h2, h4 { margin: 0; padding: 0; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Sales Report</h2>
    {{--  <h4 style="text-align:center;">
        From: {{ $start->format('d M, Y') }} To: {{ $end->format('d M, Y') }}
    </h4>  --}}

    <table>
        <thead>
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
                    <ul>
                        @foreach($sale->items as $item)
                            <li>{{ $item->product->name ?? 'N/A' }} 
                            ({{ $item->quantity }} × {{ number_format($item->product->selling_price, 2) }})</li>
                        @endforeach
                    </ul>
                </td>
                <td>{{ $sale->payment_status }}</td>
                <td>{{ number_format($sale->grand_total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
