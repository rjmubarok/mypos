@extends('layouts.app')
@section('title', 'categories ')
@section('content')

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <button type="button" class="btn btn-success btn-sm mb-3" data-bs-toggle="modal"
                            data-bs-target="#categoryModal">
                            Add New Category
                        </button>

                    </div>
                    <div class="card-body">
                        <table id="myTable" class=" display table datatable table-bordered  table-hover">
                            <thead>
                                <tr>
                                    <th>Sr</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $category->name }}</td>

                                        <td>{{ $category->description }}</td>
                                        <td><img src="{{ $category->image }}" alt="" width="50"></td>
                                        <td>
                                            @if ($category->status == 1)
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input status-toggle" type="checkbox"
                                                        role="switch" data-id="{{ $category->id }}" checked>
                                                    <label class="form-check-label text-success">Active</label>
                                                </div>
                                            @else
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input status-toggle" type="checkbox"
                                                        role="switch" data-id="{{ $category->id }}">
                                                    <label class="form-check-label text-danger">Inactive</label>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('category.edit', $category->slug) }}"
                                                class="btn btn-warning btn-sm">Edit</a>
                                            {{--  <form action="{{ route('category.destroy', $category->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>  --}}
                                            <button type="button" class="btn btn-danger btn-sm deleteBtn"
                                                data-id="{{ $category->id }}">
                                                Delete
                                            </button>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                    <!-- Category Modal -->
                    <div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <form id="categoryForm" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="categoryModalLabel">Add Categories</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <table class="table table-bordered" id="categoryTable">
                                            <thead>
                                                <tr>
                                                    <th>Category Name</th>
                                                    <th>Description</th>
                                                    <th>Status</th>
                                                    <th>Image</th>
                                                    <th>Preview</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="categoryRows">
                                                <tr>
                                                    <td><input type="text" name="categories[0][name]"
                                                            class="form-control" required></td>
                                                    <td>
                                                        <textarea name="categories[0][description]" class="form-control"></textarea>
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="checkbox" name="categories[0][status]" value="1"
                                                            checked>
                                                    </td>
                                                    <td><input type="file" name="categories[0][image]"
                                                            class="form-control image-input"></td>
                                                    <td><img src="#" class="img-thumbnail preview"
                                                            style="display:none; max-height:80px;"></td>
                                                    <td><button type="button"
                                                            class="btn btn-danger btn-sm removeRow">X</button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <button type="button" class="btn btn-success btn-sm" id="addRow">+ Add
                                            More</button>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save Categories</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('scripts')
    <script>
        document.getElementById('image').addEventListener('change', function(event) {
            let input = event.target;
            let preview = document.getElementById('imagePreview');

            if (input.files && input.files[0]) {
                let reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.src = '#';
                preview.style.display = 'none';
            }
        });
    </script>
    <script>
        let rowIndex = 1;

        $(document).ready(function() {

            // Add new row
            $('#addRow').click(function() {
                let newRow = `
        <tr>
            <td><input type="text" name="categories[${rowIndex}][name]" class="form-control" required></td>
            <td><textarea name="categories[${rowIndex}][description]" class="form-control"></textarea></td>
            <td class="text-center">
                <input type="checkbox" name="categories[${rowIndex}][status]" value="1" checked>
            </td>
            <td><input type="file" name="categories[${rowIndex}][image]" class="form-control image-input"></td>
            <td><img src="#" class="img-thumbnail preview" style="display:none; max-height:80px;"></td>
            <td><button type="button" class="btn btn-danger btn-sm removeRow">X</button></td>
        </tr>`;
                $('#categoryRows').append(newRow);
                rowIndex++;
            });

            // Remove row
            $(document).on('click', '.removeRow', function() {
                $(this).closest('tr').remove();
            });

            // Preview image
            $(document).on('change', '.image-input', function() {
                let input = this;
                let reader = new FileReader();
                reader.onload = function(e) {
                    $(input).closest('tr').find('.preview').attr('src', e.target.result).show();
                };
                if (input.files[0]) {
                    reader.readAsDataURL(input.files[0]);
                }
            });

            // AJAX Submit
            $('#categoryForm').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('category.store') }}", // custom route
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#categoryModal').modal('hide');
                        $('#categoryForm')[0].reset();
                        $('#categoryRows').html(""); // clear table
                        rowIndex = 1;
                        Swal.fire({
                            icon: "success",
                            title: "Success",
                            text: response.message,
                        });
                        location.reload();
                        // reload table dynamically if needed
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert("Something went wrong!");
                    }
                });
            });
        });
    </script>
    <script>
        $(document).on("click", ".deleteBtn", function(e) {
            e.preventDefault();
            let id = $(this).data("id");

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
                        url: "/category/delete/" + id,
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
    </script>
    <script>
        $(document).on('change', '.status-toggle', function() {
            let id = $(this).data('id');
            let status = $(this).is(':checked') ? 1 : 0;
            let label = $(this).closest('.form-check').find('.form-check-label');

            $.ajax({
                url: "{{ route('category.status.update') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    status: status
                },
                success: function(res) {
                    if (res.success) {
                        label.text(res.status == 1 ? 'Active' : 'Inactive');
                        label.removeClass('text-success text-danger')
                            .addClass(res.status == 1 ? 'text-success' : 'text-danger');
                    }
                }
            });
        });
    </script>
@endsection
