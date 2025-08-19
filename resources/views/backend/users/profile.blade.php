@extends('layouts.app')
@section('title', 'My Profile')
@section('styles')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
@endsection
@section('content')

    <section class="section">
        <div class="row">
            <div class="container p-5">

                
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="container">

                        <ul class="nav nav-pills">
                            <li class="active"><a data-toggle="pill" href="#home">Profile</a></li>
                            <li><a data-toggle="pill" href="#menu1">Edit Profile Information</a></li>
                            <li><a data-toggle="pill" href="#menu2">Password</a></li>
                        </ul>

                        <div class="tab-content">
                            <div id="home" class="tab-pane fade in active">
                                <h3>Profile</h3>
                                <div class="card profile-card p-3">

                                    <!-- Profile Header -->
                                    <div class="profile-header">
                                        <img src="{{ asset(auth()->user()->photo ?? 'https://via.placeholder.com/120') }}"
                                            alt="Profile Picture">
                                        <h3 class="mb-0">{{ auth()->user()->name }}</h3>
                                        <p class="mb-0">{{ auth()->user()->role }}</p>
                                    </div>

                                    <!-- Profile Body -->
                                    <div class="card-body">
                                        <h5 class="mb-3">Basic Information</h5>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <p><span class="info-label">Email:</span> {{ auth()->user()->email }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><span class="info-label">Phone:</span> {{ auth()->user()->phone }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><span class="info-label">Gender:</span> {{ auth()->user()->gender }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><span class="info-label">Address:</span> {{ auth()->user()->address }}
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><span class="info-label">Date Of Birth:</span>
                                                    {{ optional(auth()->user()->dob)->format('M-d-Y') }}

                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><span class="info-label">Joined:</span>
                                                    {{ auth()->user()->created_at->format('M Y') }}</p>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <div id="menu1" class="tab-pane fade">
                                <h3>Edit Profile Information</h3>
                                <div class="card mb-3 shadow-sm">
                                    <form id="userForm">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                        <div class="card-body">
                                            <h6 class="mb-3">Basic Information</h6>
                                            <div class="row">

                                                <div class="col-12 col-md-6 mb-3">
                                                    <label for="name" class="form-label"> Name</label>
                                                    <input type="text" id="name"
                                                        value="{{ auth()->user()->name ?? '' }}" name="name"
                                                        class="form-control" placeholder="Enter  Name">
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label for="phone" class="form-label">Phone Number</label>
                                                    <input type="text" name="phone" id="phone" class="form-control"
                                                        placeholder="Enter Phone Number"
                                                        value="{{ auth()->user()->phone ?? '' }}">
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

                                                        <input type="date" id="birthdate" name="dob"
                                                            class="form-control" value="{{ auth()->user()->dob ?? '' }}">
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6 mb-3">
                                                    <label for="address1" class="form-label">Photo </label>
                                                    <div class="input-group">

                                                        <input class="form-control " type="file"
                                                            value="{{ auth()->user()->photo ?? '' }}" name="photo"
                                                            id="formFile" accept="image/*" onchange="previewFile(this)">

                                                    </div>
                                                </div>


                                                <div class="col-12 col-md-6 mb-3">
                                                    <label for="address1" class="form-label">Address Line </label>
                                                    <input type="text" id="address1"
                                                        value="{{ auth()->user()->address ?? '' }}" name="address"
                                                        class="form-control" placeholder="Enter Address">
                                                </div>
                                                <div class="mb-3">
                                                    <img id="previewImg"
                                                        src="{{ auth()->user()->photo ?? '/assets/images/user.png' }}"
                                                        class="rounded-circle img-thumbnail" alt="Profile Picture"
                                                        width="150" height="150">
                                                </div>


                                            </div>
                                            <div class="mt-3">
                                                <button type="submit" class="btn btn-primary me-2">Update</button>
                                                <button type="button" class="btn btn-secondary">Cancel</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div id="menu2" class="tab-pane fade">
                                <h3>Password</h3>
                                <div class="card mb-3 shadow-sm">
                                    <form id="UserPassword">

                                        <div class="card-body">
                                            <h3 class="mb-3">Account Data</h3>
                                            <div class="row">
                                                <div class="col-12 mb-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" id="email" class="form-control"
                                                        value="{{ auth()->user()->email ?? '' }}" disabled>
                                                </div>
                                            </div>
                                            <h4 class="mt-4 mb-3">Change Password</h4>
                                            <div class="row">
                                                <div class="col-12 col-md-4 mb-3">
                                                    <label for="current_password" class="form-label">Current
                                                        Password</label>
                                                    <input type="password" name="oldpassword" id="current_password"
                                                        class="form-control" placeholder="Enter Current Password">
                                                </div>
                                                <div class="col-12 col-md-4 mb-3">
                                                    <label for="new_password" class="form-label">New Password</label>
                                                    <input type="password" name="newpassword" id="new_password"
                                                        class="form-control" placeholder="Enter New Password">
                                                </div>
                                                <div class="col-12 col-md-4 mb-3">
                                                    <label for="confirm_password" class="form-label">Confirm New
                                                        Password</label>
                                                    <input type="password" name="newpassword_confirmation"
                                                        id="confirm_password" class="form-control"
                                                        placeholder="Confirm New Password">
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                <button type="submit" class="btn btn-primary me-2">Update</button>
                                                <button type="button" class="btn btn-secondary">Cancel</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>



    </section>

@endsection
@section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script>
        // Custom scripts can be added here
        $(document).ready(function() {
            // Example: Show alert on profile tab click
            $('#profile-tab').on('click', function() {
                alert('Profile tab clicked!');
            });
        });
    </script>
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
                url: "/profile/update", // আপনার backend route
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
    <script>
$("#UserPassword").on("submit", function(e) {
    e.preventDefault();

    let formData = $(this).serialize(); // file নেই, serialize ঠিক
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
    $.ajax({
        url: "{{ route('profilepasswordUpadte') }}", // route name ঠিক আছে কিনা চেক করুন
        type: "POST",
        data: formData,
        success: function(res) {
            if (res.status) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: res.message,
                    timer: 2000,
                    showConfirmButton: false
                });
                $("#UserPassword")[0].reset();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: res.message,
                });
            }
        }, // ✅ এখানে comma লাগবে
        error: function(xhr) {
            let err = JSON.parse(xhr.responseText);
            alert(err.message || 'Something went wrong!');
        }
    });
});
</script>
@endsection
