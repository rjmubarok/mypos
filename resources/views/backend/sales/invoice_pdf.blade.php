<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $sale->invoice_no }}</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 13px;
            color: #333;
            margin: 0;
            padding: 0;
            background: #f6f7fb;
        }

        .invoice-box {
            max-width: 850px;
            margin: 20px auto;
            background: #fff;
            padding: 25px 35px;
            border-radius: 8px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.15);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 3px solid #3498db;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .company h2 {
            margin: 0;
            color: #3498db;
            font-size: 22px;
            font-family: "Times New Roman", Times, serif;
        }

        .company p {
            margin: 2px 0;
            font-size: 12px;
            color: #666;
        }

        .invoice-title {
            font-size: 20px;
            color: #444;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .invoice-meta {
            font-size: 13px;
            color: #666;
        }

        .section {
            margin-bottom: 20px;
        }

        h4 {
            margin: 0 0 6px;
            color: #3498db;
            border-bottom: 1px solid #ddd;
            padding-bottom: 3px;
            font-family: "Times New Roman", Times, serif;
        }

        .customer,
        .sale-info {
            width: 48%;
            display: inline-block;
            vertical-align: top;
            font-size: 13px;
            color: #444;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            font-size: 13px;
        }

        .table th {
            background: #3498db;
            color: #fff;
            font-weight: bold;
            font-family: "Times New Roman", Times, serif;
        }

        .table tbody tr:nth-child(even) {
            background: #f9f9f9;
        }

        .totals {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .totals td {
            padding: 6px;
            font-size: 13px;
        }

        .totals .label {
            text-align: right;
            font-weight: bold;
            color: #444;
        }

        .totals .amount {
            text-align: right;
        }

        .grand-total td {
            background: #3498db;
            color: #fff;
            font-size: 14px;
            font-weight: bold;
            border-radius: 4px;
        }

        .notes {
            margin-top: 20px;
            font-size: 12px;
            color: #555;
            border-left: 3px solid #3498db;
            padding-left: 10px;
            font-style: italic;
        }

        .signature {
            margin-top: 10px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            /* নিচের দিকে align */
            font-family: "Times New Roman", Times, serif;
        }

        .signature-box {
            width: 40%;
            /* দুই সাইডে সমান */
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid #000;
            padding-top: 5px;
            margin-top: 20px;
            /* লাইনের আগে ফাঁকা জায়গা */
            font-size: 14px;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #888;
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <!-- Header -->
        <div class="header">
            <div class="company">
                <h2>My Company</h2>
                <p>123 Main Street, Dhaka</p>
                <p>Phone: +880123456789</p>
            </div>
            <div>
                <div class="invoice-title">INVOICE</div>
                <div class="invoice-meta">
                    Invoice #: {{ $sale->invoice_no }}<br>
                    Date: {{ \Carbon\Carbon::parse($sale->sold_at)->format('d M Y, h:i A') }}
                </div>
            </div>
        </div>

        <!-- Customer & Sale Info -->
        <div class="section">
            <div class="customer">
                <h4>Bill To</h4>
                <p>
                    {{ $sale->customer->name ?? 'Walk-in Customer' }}<br>
                    {{ $sale->customer->phone ?? '' }}<br>
                    {{ $sale->customer->email ?? '' }}
                </p>
            </div>
            <div class="sale-info">
                <h4>Sale Info</h4>
                <p>
                    Sale Status: <b>{{ ucfirst($sale->status) }}</b><br>
                    Payment Status: <b>{{ ucfirst($sale->payment_status) }}</b>
                </p>
            </div>
        </div>

        <!-- Products Table -->
        <table class="table">
            <thead>
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
                        <td>{{ number_format($item->unit_price, 2) }}</td>
                        <td>{{ number_format($item->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <table class="totals">
            <tr>
                <td class="label">Subtotal:</td>
                <td class="amount">{{ number_format($sale->subtotal, 2) }}</td>
            </tr>
            <tr>
                <td class="label">Discount:</td>
                <td class="amount">-{{ number_format($sale->discount, 2) }}</td>
            </tr>
            <tr>
                <td class="label">Tax:</td>
                <td class="amount">{{ number_format($sale->tax, 2) }}</td>
            </tr>
            <tr>
                <td class="label">Shipping:</td>
                <td class="amount">{{ number_format($sale->shipping, 2) }}</td>
            </tr>
            <tr class="grand-total">
                <td class="label">Grand Total:</td>
                <td class="amount">{{ number_format($sale->grand_total, 2) }}</td>
            </tr>
            <tr>
                <td class="label">Paid:</td>
                <td class="amount">{{ number_format($sale->paid_amount, 2) }}</td>
            </tr>
            <tr>
                <td class="label">Due:</td>
                <td class="amount">{{ number_format($sale->due_amount, 2) }}</td>
            </tr>
        </table>

        <!-- Notes -->
        {{--  <div class="notes">
            <strong>Notes:</strong><br>
            {{ $sale->note ?? '---' }}
        </div>  --}}

        <!-- Signature -->
       <div class="signature">
    <div class="signature-box">
        <div class="signature-line">Customer Signature</div>
    </div>
    <div class="signature-box">
        <div class="signature-line">Authorized Signature</div>
    </div>
</div>


        <!-- Footer -->
        <div class="footer">
            Thank you for your business! <br>
            This is a computer generated invoice.
        </div>
    </div>
</body>

</html>
