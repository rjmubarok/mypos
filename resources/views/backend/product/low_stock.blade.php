@extends('layouts.app')

@section('title', 'Low Stock Products')

@section('content')
    <div class="container">
        <h3 class="mb-3">⚠️ Low Stock Products</h3>

        @if($lowStockProducts->count())
            <table id="LowstockproductTable" class="table table-bordered striped align-middle">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Stock</th>
                        <th>Alert Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lowStockProducts as $key => $product)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>{{ $product->alert_quantity }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-danger">✅ বর্তমানে কোনো লো-স্টক প্রোডাক্ট নেই।</p>
        @endif
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#LowstockproductTable').DataTable();
        });
    </script>
@endsection
