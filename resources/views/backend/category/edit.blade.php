@extends('layouts.app')
@section('title', 'categories ')
@section('content')

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Edit Category</h5>
                    </div>
                    <form id="categoryUpdateForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{ $category->id }}" name="id">
                        <div class="card-body">

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Category Name</label>
                                    <input type="text" class="form-control" value="{{ $category->name }}" id="name"
                                        name="name" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="parent_id" class="form-label">Parent Category</label>
                                    <select name="parent_id" id=""
                                        class="form-control @error('parent_id') is-invalid @enderror">
                                        <option value="" selected>@lang('student.session_name')</option>
                                        @foreach ($categories as $session)
                                            <option @if ($category->parent_id == $session->id) selected @endif
                                                {{ old('parent_id') == $session->id ? 'selected' : '' }}
                                                value="{{ $session->id }}">{{ $session->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3 d-flex align-items-center">

                                    <div class="form-check ">
                                        <input class="form-check-input" type="checkbox" name="status" id="status"
                                            value="{{ $category->status }}"
                                            @if ($category->status == '1') checked @endif>
                                        <label class="form-check-label" for="status">Active</label>
                                    </div>
                                </div>

                                <div class="col-12 col-md-9">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" name="description" id="description" rows="3">{{ $category->description }}</textarea>
                                </div>

                                <div class="col-md-6">
                                    <label for="image" class="form-label">Category Image</label>
                                    <input type="file" class="form-control" id="image" name="image"
                                        value="{{ $category->image }} ">
                                </div>
                                <div class="col-md-6">
                                    <img src="{{ $category->image }}" alt="" width="50">
                                    <div class="mt-2">
                                        <img id="imagePreview" src="#" alt="Preview" class="img-thumbnail"
                                            style="display:none; max-height:50px;">

                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-secondary">Close</button>
                            <button type="submit" class="btn btn-primary">Save Category</button>
                        </div>
                    </form>
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
        $(document).ready(function() {
            $('#categoryUpdateForm').submit(function(e) {
                e.preventDefault(); // Prevent default form submit

                let formData = new FormData(this); // Support file upload

                $.ajax({
                    url: "{{ route('category.update') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.status) {
                            // Close modal

                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: res.message,

                            });
                            $("#categoryUpdateForm")[0].reset();
                            //  location.reload(); // Refresh table
                        } else {
                            alert('Error: ' + res.message);
                        }
                    },
                    error: function(err) {
                        alert('AJAX error. Check console for details.');
                        console.log(err);
                    }
                });
            });
        });
    </script>

@endsection
