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
        }

        .invoice-box {
            width: 100%;
            padding: 20px;
        }

        .header {
            width: 100%;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .company {
            float: left;
            width: 60%;
        }

        .logo {
            margin-bottom: 5px;
        }

        .logo img {
            max-height: 60px;
            max-width: 150px;
            object-fit: contain;
        }

        .invoice-title {
            float: right;
            text-align: right;
        }

        .invoice-title h2 {
            margin: 0;
            color: #3498db;
            font-size: 20px;
        }

        .invoice-meta {
            font-size: 13px;
            color: #555;
        }

        .clearfix {
            clear: both;
        }

        h4 {
            font-size: 14px;
            margin: 8px 0 5px;
            border-bottom: 1px solid #ccc;
            color: #3498db;
        }

        .customer,
        .sale-info {
            width: 48%;
            display: inline-block;
            vertical-align: top;
            font-size: 13px;
        }

        table.table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.table th,
        table.table td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: center;
            font-size: 12px;
        }

        table.table th {
            background: #3498db;
            color: #fff;
        }

        table.totals {
            width: 100%;
            border-collapse: collapse;
        }

        table.totals td {
            padding: 5px;
            font-size: 12px;
        }

        .label {
            text-align: right;
            font-weight: bold;
        }

        .grand-total td {
            background: #3498db;
            color: #fff;
            font-weight: bold;
        }

        .signature {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .signature-box {
            width: 40%;
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid #000;
            margin-top: 60px;
            padding-top: 5px;
            font-size: 13px;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 11px;
            color: #888;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <!-- Header -->
        <div class="header">
            <div class="company">
                <div class="logo">
                    <img src="{{ \App\Models\Institute::value('logo') }}" alt="Logo" style="height:60px; width:auto;">
                </div>
                <h2> Company Name: {{ \App\Models\Institute::value('name') }}</h2>
                <p>Email: {{ \App\Models\Institute::value('email') }}</p>
                <p>Address: {{ \App\Models\Institute::value('address') }}</p>
                <p>Phone: {{ \App\Models\Institute::value('phone') }}</p>
            </div>
            <div class="invoice-title">
                <h2>INVOICE</h2>
                <div class="invoice-meta">
                    Invoice #: {{ $sale->invoice_no }}<br>
                    Date: {{ \Carbon\Carbon::parse($sale->sold_at)->format('d M Y, h:i A') }}
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        <!-- Customer & Sale Info -->
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
        <div class="clearfix"></div>

        <!-- Product Table -->
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
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->product->unit ?? '-' }}</td>
                        <td>{{ number_format($item->unit_price, 2) }}</td>
                        <td>{{ number_format($item->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals on Right -->
        <div style="width: 40%; float: right; margin-top: 15px;">
            <table class="totals">
                <tr>
                    <td class="label">Subtotal:</td>
                    <td>{{ number_format($sale->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td class="label">Discount:</td>
                    <td>-{{ number_format($sale->discount, 2) }}</td>
                </tr>
                <tr>
                    <td class="label">Tax:</td>
                    <td>{{ number_format($sale->tax, 2) }}</td>
                </tr>
                <tr>
                    <td class="label">Shipping:</td>
                    <td>{{ number_format($sale->shipping, 2) }}</td>
                </tr>
                <tr class="grand-total">
                    <td class="label">Grand Total:</td>
                    <td>{{ number_format($sale->grand_total, 2) }}</td>
                </tr>
                <tr>
                    <td class="label">Paid:</td>
                    <td>{{ number_format($sale->paid_amount, 2) }}</td>
                </tr>
                <tr>
                    <td class="label">Due:</td>
                    <td>{{ number_format($sale->due_amount, 2) }}</td>
                </tr>
            </table>
        </div>
        <div style="clear: both;"></div>

        <!-- Signature -->
        <table style="width:100%; margin-top:50px; text-align:center;">
            <tr>
                <td style="width:50%;">
                    <div style="border-top:1px solid #000; margin-top:60px; padding-top:5px;">Customer Signature</div>
                </td>
                <td style="width:50%;">
                    <div style="border-top:1px solid #000; margin-top:60px; padding-top:5px;">Authorized Signature</div>
                </td>
            </tr>
        </table>

        <!-- Footer -->
        <div class="footer">
            Thank you for your business! <br>
            This is a computer generated invoice.
        </div>
    </div>
</body>

</html>
