@extends('backend.layouts.app')
@section('title', 'My Profile')
@section('content')
    <div class="container-fluid">

        <div class="block-header">
            <div class="row">
                <div class="col-12 col-md-8 col-lg-5">
                    <h2>
                        <a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
                            <i class="fa fa-arrow-left"></i>
                        </a> User Profile
                    </h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item active">{{ auth()->user()->name ?? '' }} Profile</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row clearfix">

            <!-- Left Sidebar -->
            <div class="col-12 col-lg-4 col-md-12 mb-3">
                <div class="card profile-header">
                    <div class="body text-center">
                        <div class="profile-image mb-3">
                            <img src="{{ auth()->user()->photo ?? '/assets/images/user.png' }}" class="rounded-circle w-50"
                                alt="">
                        </div>
                        <h4 class="m-b-0"><strong>{{ auth()->user()->name ?? '' }}</strong></h4>
                        <span>{{ auth()->user()->location ?? 'Unknown' }}</span>
                    </div>
                </div>

                <div class="card">
                    <div class="header">
                        <h2>Info</h2>
                    </div>
                    <div class="body">
                        <h6 class="text-muted">Address:</h6>
                        <p>{{ auth()->user()->address ?? 'Update Address' }}</p>
                        <hr>
                        <small class="text-muted">Email:</small>
                        <p>{{ auth()->user()->email ?? '' }}</p>
                        <hr>
                        <small class="text-muted">Mobile:</small>
                        <p>{{ auth()->user()->phone ?? 'Update Mobile Number' }}</p>
                        <hr>
                        <small class="text-muted">Birth Date:</small>
                        <p>{{ auth()->user()->dob ?? 'Update Birth Date' }}</p>
                    </div>
                </div>
            </div>

            <!-- Right Content -->
            <div class="col-12 col-lg-8 col-md-12">

                <!-- Basic Information -->
                <div class="card mb-3 shadow-sm">
                    <form id="userForm">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        <div class="card-body">
                            <h6 class="mb-3">Basic Information</h6>
                            <div class="row">

                                <div class="col-12 col-md-6 mb-3">
                                    <label for="name" class="form-label"> Name</label>
                                    <input type="text" id="name" value="{{ auth()->user()->name ?? '' }}"
                                        name="name" class="form-control" placeholder="Enter  Name">
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="text" name="phone" id="phone" class="form-control"
                                        placeholder="Enter Phone Number" value="{{ auth()->user()->phone ?? '' }}">
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label class="form-label d-block">Gender</label>
                                    <label class="fancy-radio me-3">
                                        <input name="gender" value="male" type="radio" checked>
                                        <span><i></i>Male</span>
                                    </label>
                                    <label class="fancy-radio">
                                        <input name="gender" value="female" type="radio">
                                        <span><i></i>Female</span>
                                    </label>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label for="birthdate" class="form-label"> Date Of Birth</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        <input type="date" id="birthdate" name="dob" class="form-control"
                                            value="{{ auth()->user()->dob ?? '' }}">
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 mb-3">
                                    <label for="address1" class="form-label">Photo </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-file-upload"></i></span>
                                        <input class="form-control " type="file"
                                            value="{{ auth()->user()->photo ?? '' }}" name="photo" id="formFile"
                                            accept="image/*" onchange="previewFile(this)">

                                    </div>
                                </div>


                                <div class="col-12 col-md-6 mb-3">
                                    <label for="address1" class="form-label">Address Line </label>
                                    <input type="text" id="address1" value="{{ auth()->user()->address ?? '' }}"
                                        name="address" class="form-control" placeholder="Enter Address">
                                </div>
                                <div class="mb-3">
                                    <img id="previewImg" src="{{ auth()->user()->photo ?? '/assets/images/user.png' }}"
                                        class="rounded-circle img-thumbnail" alt="Profile Picture" width="150"
                                        height="150">
                                </div>


                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary me-2">Update</button>
                                <button type="button" class="btn btn-secondary">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Account Data & Password -->
                

            </div>


        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Image preview function
        function previewFile(input) {
            let file = input.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById("previewImg").setAttribute("src", e.target.result);
                };
                reader.readAsDataURL(file);
            }
        }



        $("#userForm").on("submit", function(e) {
            e.preventDefault();

            let formData = new FormData(this); // file সহ সব data যাবে

            $.ajax({
                url: "/password/update", // আপনার backend route
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: res.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                    location.reload();
                },
                error: function(xhr) {
                    alert("Update failed!");
                    console.log(xhr.responseText);
                }
            });
        });
    </script>



@endsection
