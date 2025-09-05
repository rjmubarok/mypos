<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>All Sales Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid #000; padding: 4px; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">All Sales Report</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Paid</th>
                <th>Due</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $i => $sale)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $sale->sold_at }}</td>
                    <td>{{ $sale->customer->name ?? 'Walk-in' }}</td>
                    <td>{{ number_format($sale->grand_total, 2) }}</td>
                    <td>{{ number_format($sale->paid_amount, 2) }}</td>
                    <td>{{ number_format($sale->due_amount, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
