@extends('layouts.app')
@section('title', 'Institute')
@section('content')

<section class="section">
    <div class="row">

        <div class=" col col-lg-2">
        </div>
        <div class="col-lg-8">
            @include('sweetalert::alert')
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Institute Information</h5>

                    <!-- Vertical Form -->
                    <form action="{{route('institute.update')}}" id="image-upload-preview" method="POST"
                        enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="col-12">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" value="{{old('name',$institute->name??'')}}"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Name">
                            @error('name')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Email</label>
                            <input type="text" name="email" value="{{old('email',$institute->email??'')}}"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="Email">
                            @error('email')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" value="{{old('phone',$institute->phone??'')}}"
                                class="form-control @error('phone') is-invalid @enderror"
                                placeholder="Phone">
                            @error('phone')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">EIIN No</label>
                            <input type="text" name="eiin_no" value="{{old('eiin_no',$institute->eiin_no??'')}}"
                                class="form-control @error('eiin_no') is-invalid @enderror"
                                placeholder="EIIN No">
                            @error('eiin_no')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">About</label>
                            <input type="text" name="about" value="{{old('about',$institute->about??'')}}"
                                class="form-control @error('about') is-invalid @enderror"
                                placeholder="About">
                            @error('about')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Slogan</label>
                            <input type="text" name="slogan" value="{{old('slogan',$institute->slogan??'')}}"
                                class="form-control @error('slogan') is-invalid @enderror"
                                placeholder="Slogan">
                            @error('slogan')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" value="{{old('address',$institute->address??'')}}"
                                class="form-control @error('address') is-invalid @enderror"
                                placeholder="Address">
                            @error('address')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Facebook URL</label>
                            <input type="text" name="facebook_url"
                                value="{{old('facebook_url',$institute->facebook_url??'')}}"
                                class="form-control @error('facebook_url') is-invalid @enderror"
                                placeholder="Facebook URL">
                            @error('facebook_url')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Theme Color</label>
                            <select class="form-control" name="team_color">
                                <option {{$institute->team_color=='bg-gradient' ? 'selected':''}} value="bg-gradient">bg-gradient</option>
                                <option {{$institute->team_color??''=='bg-info' ? 'selected':''}} value="bg-info">bg-info</option>
                                <option {{$institute->team_color??''=='bg-dark' ? 'selected':''}} value="bg-dark">bg-dark</option>
                                <option {{$institute->team_color??''=='bg-success' ? 'selected':''}} value="bg-success">bg-success</option>
                            </select>
                            @error('team_color')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="col-12 mb-4 ">
                            <label>Favicon</label>
                            <input id="image" class="form-control" type="file" name="favicon">
                            <img id="preview-image" src="{{ asset($institute->favicon) }}" alt="preview image" style="max-height: 100px;">
                        </div>

                        <div class="col-12 mb-4 ">
                            <label>Logo</label>
                            <input id="logo" class="form-control" type="file" name="logo">
                            <img id="logo_preview-image" src="{{ asset($institute->logo) }}" alt="preview image" style="max-height: 100px;">
                        </div>

                        <div class="col-12 mb-4 ">
                            <label>Banner</label>
                            <input id="banner" class="form-control" type="file" name="banner">
                            <img id="banner_preview-image" src="{{ asset($institute->banner) }}" alt="preview image" style="max-height: 100px;">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="summernote w-100" placeholder="Description">{{$institute->description??''}}</textarea>
                            @error('description')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.summernote').summernote();
    });

    $('#image').change(function(){
        let reader = new FileReader();
        reader.onload = (e) => {
            $('#preview-image').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    });

    $('#banner').change(function(){
        let reader = new FileReader();
        reader.onload = (e) => {
            $('#banner_preview-image').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    });

    $('#logo').change(function(){
        let reader = new FileReader();
        reader.onload = (e) => {
            $('#logo_preview-image').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    });
</script>
@endsection
