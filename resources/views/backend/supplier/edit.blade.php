@extends('layouts.app')
@section('title', 'Supplier Edit')
@section('content')
    <section class="section">
        <div class="row">


            <div class="col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('supplier.create') }}" class="btn btn-info btn-sm"><i
                                    class="bi bi-plus-circle"></i>
                                Create</a>
                            <a href="{{ route('supplier.index') }}" class="btn btn-info btn-sm"><i
                                    class="bi bi-list-task"></i>
                               List</a>
                        </div>

                    </div>
                    <div class="card-body">
                        <!-- Vertical Form -->
                        <form action="{{ route('supplier.update', $supplier->id) }}" id="image-upload-preview"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row mt-3">

                                <div class="col-sm-6">
                                    <label for="inputText" class="form-label">Supplier Name</label>
                                    <input type="text" name="name" value="{{ old('name', $supplier->name) }}"
                                        class="form-control @error('name') is-invalid @enderror" id="inputNanme4"
                                        placeholder="Supplier Name">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-sm-6">
                                    <label for="inputText" class="form-label">Supplier Email</label>
                                    <input type="text" name="email" value="{{ old('email', $supplier->email) }}"
                                        class="form-control @error('email') is-invalid @enderror" id="inputNanme4"
                                        placeholder="Supplier Email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-3">

                                <div class="col-sm-6">
                                    <label for="inputText" class="form-label">Phone</label>
                                    <input type="text" name="phone" value="{{ old('phone', $supplier->phone) }}"
                                        class="form-control @error('phone') is-invalid @enderror" id="inputNanme4"
                                        placeholder="Phone">
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-sm-6">
                                    <label for="inputText" class="form-label">Address</label>
                                    <input type="text" name="address" value="{{ old('address', $supplier->address) }}"
                                        class="form-control @error('address') is-invalid @enderror" id="inputNanme4"
                                        placeholder="Address">
                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-3">

                                <div class="col-sm-6">
                                    <label for="inputText" class="form-label">Shop Name</label>
                                    <input type="text" name="shopname"
                                        value="{{ old('shopname', $supplier->shopname) }}"
                                        class="form-control @error('shopname') is-invalid @enderror" id="inputNanme4"
                                        placeholder="Shop Name">
                                    @error('shopname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-12 mb-4 ">
                                    <label for="">Supplier Photo</label>

                                    <input id="photo" placeholder="Choose image" class="form-control" type="file"
                                        name="photo" value="{{ $supplier->photo }}">

                                    <img id="photo_preview-image" src="{{ asset($supplier->photo) }}"
                                        alt="preview image" style="max-height: 100px;">

                                </div>
                                <div class="col-12 col-md-6 mb-4 ">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="status"
                                        class="form-select @error('status') is-invalid @enderror">
                                        <option value="1" {{ old('status', $supplier->status) == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status', $supplier->status) == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                </div>
                            </div>
                        </form><!-- Vertical Form -->

                    </div>
                </div>

            </div>

        </div>
    </section>
@endsection
@section('scripts')
    <script type="text/javascript">
        $('#photo').change(function() {

            let reader = new FileReader();
            reader.onload = (e) => {
                $('#photo_preview-image').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);

        });
    </script>
@endsection
