@extends('layouts.app')
@section('title', 'Brands ')
@section('content')

    <div class="container">
        <h3>Brands</h3>
        <button type="button" class="btn btn-success btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#brandModal">
            Add New Brand
        </button>
        <table class="table table-bordered" id="brandTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Logo</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="brandTableBody">
                @foreach ($brands as $brand)
                    <tr id="row-{{ $brand->id }}">
                        <td>{{ $brand->id }}</td>
                        <td>{{ $brand->name }}</td>
                        <td>
                            @if ($brand->logo)
                                <img src="{{  $brand->logo }}" width="50" alt="">
                            @endif
                        </td>
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input status-toggle" type="checkbox" data-id="{{ $brand->id }}"
                                    {{ $brand->status == 1 ? 'checked' : '' }}>
                                <label class="form-check-label {{ $brand->status == 1 ? 'text-success' : 'text-danger' }}">
                                    {{ $brand->status == 1 ? 'Active' : 'Inactive' }}
                                </label>
                            </div>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-info editBrand" data-id="{{ $brand->id }}">Edit</button>
                            <button class="btn btn-sm btn-danger deleteBrand" data-id="{{ $brand->id }}">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="brandModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="brandForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="brand_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Add Brand</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" name="name" id="name" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Logo</label>
                            <input type="file" name="logo" id="logo" class="form-control">
                        </div>
                        <div class=" mb-3 form-check ">
                                        <input class="form-check-input" type="checkbox" name="status" id="status"
                                            value="{{ $brand->status }}"
                                            >
                                        <label class="form-check-label" for="status">Active</label>
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

            // Add Brand Modal
            $('#addBrandBtn').click(function() {
                $('#brandForm')[0].reset();
                $('#brand_id').val('');
                $('#modalTitle').text('Add Brand');
                $('#brandModal').modal('show');
            });

            // Save / Update Brand
            $('#brandForm').submit(function(e) {
                e.preventDefault();
                let id = $('#brand_id').val();
                let url = id ? '/brands/update/' + id : '/brands/store';
                let formData = new FormData(this);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(res) {

                        Swal.fire({
                            icon: "success",
                            title: "Success",
                            text: res.message,
                        });
                        $('#brandModal').modal('hide');
                        $("#brandForm")[0].reset();
                        location.reload();
                    },
                    error: function(xhr) {
                        // remove old errors
                        $(".text-danger").remove();

                        if (xhr.status === 422) { // Laravel validation error
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                // find input with matching name
                                let input = $(`[name="${key}"]`);

                                // show error message
                                input.after(
                                    `<span class="text-danger">${value[0]}</span>`);
                            });
                        }
                    }
                });
            });

            // Edit Brand
            $(document).on('click', '.editBrand', function() {
                let id = $(this).data('id');
                $.get('/brands/edit/' + id, function(data) {
                    $('#brand_id').val(data.id);
                    $('#name').val(data.name);
                    $('#status').val(data.status);
                    $('#modalTitle').text('Edit Brand');
                    $('#brandModal').modal('show');
                });
            });

            // Delete Brand
            $(document).on('click', '.deleteBrand', function() {
 let id = $(this).data('id');
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
                            url: '/brands/delete/' + id,
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

            // Status Toggle
            $(document).on('change', '.status-toggle', function() {
                let id = $(this).data('id');
                let status = $(this).is(':checked') ? 1 : 0;
                let label = $(this).closest('.form-check').find('.form-check-label');

                $.post('/brands/status-update', {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    status: status
                }, function(res) {
                    label.text(status == 1 ? 'Active' : 'Inactive')
                        .removeClass('text-success text-danger')
                        .addClass(status == 1 ? 'text-success' : 'text-danger');
                });
            });

        });
    </script>
@endsection
