<!DOCTYPE html>
<html>
<head>
    <title>Products List</title>
    <style>
        body { 
            font-family: "Times New Roman", serif; 
            font-size: 12px; 
            margin: 20px;
        }
        h2 { 
            text-align: center; 
            margin-bottom: 20px; 
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
        }
        th, td { 
            border: 1px solid #333; 
            padding: 8px 10px; 
            text-align: left; 
        }
        th { 
            background-color: #f0f0f0; 
            font-weight: bold; 
        }
        tbody tr:nth-child(even) { 
            background-color: #f9f9f9; 
        }
    </style>
</head>
<body>
    <h2>Products List</h2>
    <table>
        <thead>
            <tr>
                <th style="width:5%;">#</th>
                <th style="width:25%;">Name</th>
                <th style="width:20%;">Category</th>
                <th style="width:15%;">Purchase Price</th>
                <th style="width:15%;">Selling Price</th>
                <th style="width:10%;">Stock</th>
                <th style="width:10%;">Total </th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $index => $product)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category ? $product->category->name : '-' }}</td>
                <td>{{ number_format($product->purchase_price, 2) }}</td>
                <td>{{ number_format($product->selling_price, 2) }}</td>
                <td>{{ $product->stock }}</td>
                <td>{{ $product->stock*$product->purchase_price }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
