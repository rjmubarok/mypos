@extends('layouts.app')
@section('title', 'supplier')
@section('content')

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('supplier.create') }}" class="btn btn-info btn-sm"><i
                                    class="bi bi-plus-circle"></i> Add New Supplier</a>

                        </div>

                    </div>
                    <div class="card-body">
                        <h5 class="card-title"> list</h5>
                        <!-- Table with stripped rows -->
                        <table id="myTable" class=" display table datatable table-bordered  table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Shopname</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($suppliers as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><img class="" style="max-width: 60px; "src="{{ asset($data->photo) }}">
                                        </td>
                                        <td>{{ $data->name ?? '' }}</td>
                                        <td>{{ $data->email ?? '' }}</td>
                                        <td>{{ $data->phone ?? '' }}</td>
                                        <td>{{ $data->shopname ?? '' }}</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input status-toggle" type="checkbox"
                                                    data-id="{{ $data->id }}" {{ $data->status == 1 ? 'checked' : '' }}>
                                                <label
                                                    class="form-check-label {{ $data->status == 1 ? 'text-success' : 'text-danger' }}">
                                                    {{ $data->status == 1 ? 'Active' : 'Inactive' }}
                                                </label>
                                            </div>
                                        </td>

                                        <td class="d-flex ">
                                            <a href="{{ route('supplier.edit', $data->id) }}"
                                                class="btn btn-info btn-sm mr-2"><i class="bi bi-pencil-square"></i></a>
                                            <a href="{{ route('supplier.show', $data->id) }}"
                                                class="btn btn-secondary btn-sm mr-2"><i class="bi bi-eye"></i></a>
                                            {{--  <form action="{{ route('supplier.destroy', $data->id) }}" method="POST"
                                                class=" mr-2">
                                                @method('DELETE')
                                                @csrf
                                                <a href="" data-id=" {{ $data->id }} " data-toggle="tooltip"
                                                    title="Delete" data-placement="bottom"
                                                    class="dltbtn btn btn-danger btn-sm"> <i class="bi bi-trash"></i></a>
                                            </form>  --}}
                                            <button class="deleteBtn btn btn-danger btn-sm"
                                                data-url="{{ route('supplier.destroy', $data->id) }}"> <i
                                                    class="bi bi-trash"></i></button>
                                        </td>


                                    </tr>
                                @empty
                                @endforelse


                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>


            </div>
        </div>
    </section>

@endsection
@section('scripts')


    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
    <script>
        // Delete Brand
        $(document).on('click', '.deleteBtn', function() {
            let id = $(this).data('id');
            let url = $(this).data("url");
            Swal.fire({
                title: "Are you sure?",
                text: "This action cannot be undone!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            _method: "DELETE"
                        },
                        success: function(res) {
                            Swal.fire("Deleted!", res.message, "success");
                            // Optionally remove row from table
                            location.reload();
                        },
                        error: function(xhr) {
                            Swal.fire("Error!", "Something went wrong.", "error");
                        }
                    });
                }
            });

        });
        $(document).on('change', '.status-toggle', function() {
            let id = $(this).data('id');
            let status = $(this).is(':checked') ? 1 : 0;
            let label = $(this).closest('.form-check').find('.form-check-label');

            $.post('/supplier/status-update', {
                _token: '{{ csrf_token() }}',
                id: id,
                status: status
            }, function(res) {
                label.text(status == 1 ? 'Active' : 'Inactive')
                    .removeClass('text-success text-danger')
                    .addClass(status == 1 ? 'text-success' : 'text-danger');
            });
        });
    </script>
@endsection
