<table id="myTable" class=" display table datatable table-bordered  table-hover">
    <thead>
        <tr>

         <th>Image</th>
         <th>Product Name</th>
         <th>Selling Price</th>
         <th>Purchase Price</th>
         <th>Stock</th>
         <th>Category</th>

        </tr>
    </thead>
    <tbody>

            <tr>

                <td><img class=""
                        style="max-width: 60px; "src="{{ asset($data->image ?? '') }}">
                </td>
                <td>{{ $data->name ?? '' }}</td>
                <td>{{ $data->selling_price ?? '' }}</td>
                <td>{{ $data->purchase_price ?? '' }}</td>
                <td>{{ $data->stock ?? '' }}</td>
                <td>{{ $data->category->name ?? '' }}</td>
                




            </tr>



    </tbody>
</table>
