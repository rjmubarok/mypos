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
                                    <th>Name</th>
                                    <th>Parent Category</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->parent ? $category->parent->name : 'N/A' }}</td>
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
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form id="categoryForm" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="categoryModalLabel">Add Category</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="name" class="form-label">Category Name</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    required>
                                            </div>



                                            <div class="col-md-6">
                                                <label for="parent_id" class="form-label">Parent Category</label>
                                                <select class="form-select" name="parent_id" id="parent_id">
                                                    <option value="">-- None --</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-3 d-flex align-items-center">

                                                <div class="form-check ">
                                                    <input class="form-check-input" type="checkbox" name="status"
                                                        id="status" value="1" checked>
                                                    <label class="form-check-label" for="status">Active</label>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-9">
                                                <label for="description" class="form-label">Description</label>
                                                <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="image" class="form-label">Category Image</label>
                                                <input type="file" class="form-control" id="image" name="image">
                                            </div>
                                            <div class="col-md-6">

                                                <div class="mt-2">
                                                    <img id="imagePreview" src="#" alt="Preview"
                                                        class="img-thumbnail" style="display:none; max-height:150px;">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save Category</button>
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
        $("#categoryForm").on("submit", function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('category.store') }}", // or update
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(res) {
                    if (res.status) {
                        Swal.fire({
                            icon: "success",
                            title: "Success",
                            text: res.message,
                        });
                        $("#categoryForm")[0].reset();
                        $("#categoryModal").modal('hide');
                        $(".text-danger").remove(); // clear old errors
                        location.reload();
                    }
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
                            input.after(`<span class="text-danger">${value[0]}</span>`);
                        });
                    }
                }
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
            if(res.success){
                label.text(res.status == 1 ? 'Active' : 'Inactive');
                label.removeClass('text-success text-danger')
                     .addClass(res.status == 1 ? 'text-success' : 'text-danger');
            }
        }
    });
});
</script>
@endsection
