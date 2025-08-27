@extends('layouts.app')
@section('title', 'Customer Management')
@section('content')

    <div class="container">
        <h3>Customer</h3>
        <button type="button" class="btn btn-success btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#customerModal"
            id="addNewCustomer">
            Add Customer
        </button>

        <table class="table table-bordered" id="customerTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $customer)
                    <tr id="row-{{ $customer->id }}">
                        <td>{{ $customer->id }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->phone }}</td>
                        <td>{{ $customer->address }}</td>
                        <td>
                            <button class="btn btn-info btn-sm editCustomer" data-id="{{ $customer->id }}">Edit</button>
                            <button class="btn btn-danger btn-sm deleteCustomer"
                                data-id="{{ $customer->id }}">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="customerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="customerForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Add Customer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" name="name" id="name" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="text" name="email" id="email" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Phone</label>
                            <input type="text" name="phone" id="phone" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Address</label>
                            <input type="text" name="address" id="address" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Photo</label>
                            <input type="file" name="photo" id="photo" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            // ----------------- Add / Update Customer -----------------
            $('#customerForm').off('submit').on('submit', function(e) {
                e.preventDefault();
                let formData = $(this).serialize();
                let id = $('#id').val();
                let url = id ? "{{ route('customer.update', '') }}/" + id : "{{ route('customer.store') }}";
                let method = id ? 'PUT' : 'POST';

                $.ajax({
                    url: url,
                    method: method,
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: "success",
                                title: "Success",
                                text: response.message,
                            });
                            $("#customerForm")[0].reset();
                            $("#customerModal").modal('hide');
                            $(".text-danger").remove(); // clear old errors
                            //   alert(response.message);

                            let customer = response.customer;
                            let row = `
                        <tr id="row-${customer.id}">
                            <td>${customer.id}</td>
                            <td>${customer.name}</td>
                            <td>${customer.email}</td>
                            <td>${customer.phone}</td>
                            <td>${customer.address}</td>
                            <td>
                                <button class="btn btn-info btn-sm editCustomer" data-id="${customer.id}">Edit</button>
                                <button class="btn btn-danger btn-sm deleteCustomer" data-id="${customer.id}">Delete</button>
                            </td>
                        </tr>
                    `;

                            if (id) {
                                $('#row-' + id).replaceWith(row); // Update row
                            } else {
                                $('#customerTable tbody').append(row); // Add new row
                            }

                            $('#customerForm')[0].reset();
                            $('#id').val('');
                            $('#customerModal').modal('hide');
                        } else {
                            alert("Error saving customer");
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert("Validation / Server Error");
                    }
                });
            });

            // ----------------- Edit Customer -----------------
            $(document).on('click', '.editCustomer', function() {
                let id = $(this).data('id');
                $.get("{{ route('customer.index') }}/" + id, function(customer) {
                    $('#modalTitle').text('Edit Customer');
                    $('#id').val(customer.id);
                    $('#name').val(customer.name);
                    $('#email').val(customer.email);
                    $('#phone').val(customer.phone);
                    $('#address').val(customer.address);
                    $('#customerModal').modal('show');
                });
            });

            // ----------------- Delete Customer -----------------
            $(document).on('click', '.deleteCustomer', function() {
                //if(!confirm("Are you sure want to delete?")) return;
                let id = $(this).data('id');
                $.ajax({
                    url: "{{ route('customer.destroy', '') }}/" + id,
                    method: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#row-' + id).remove();
                            Swal.fire({
                                icon: "success",
                                title: "Success",
                                text: response.message,
                            });
                        } else {
                            alert("Delete failed");
                        }
                    }
                });
            });

            // ----------------- Reset Modal on Add -----------------
            $('#addNewCustomer').click(function() {
                $('#customerForm')[0].reset();
                // $('#id').val('');
                $('#modalTitle').text('Add Customer');
            });

        });
    </script>
@endsection
