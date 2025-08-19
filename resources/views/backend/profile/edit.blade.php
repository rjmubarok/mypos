@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<div class="pagetitle">
    <h1>Profile</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item">Users</li>
        <li class="breadcrumb-item active">Profile</li>
      </ol>
    </nav>
</div><!-- End Page Title -->

  <section class="section profile">
    <div class="row">
      <div class="col-xl-4">

        <div class="card">
          <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

            <img src="{{ asset(Auth::user()->photo?? "assets/img/profile-img.jpg") }} " alt="Profile" class="rounded-circle">
            <h2>{{ Auth::user()->name }}</h2>
            <h3>{{Auth::user()->roles->pluck('name') }}</h3>
            <div class="social-links mt-2">
              <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
              <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
              <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
              <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
            </div>
          </div>
        </div>

      </div>
      <div class="col-xl-8">

        <div class="card">
          <div class="card-body pt-3">
            <!-- Bordered Tabs -->
            <ul class="nav nav-tabs nav-tabs-bordered">

              <li class="nav-item">
                <a class="nav-link  {{ request()->is('/profile') ? 'active' : '' }}" href="{{ route('profile') }}">Overview</a>
              </li>

              <li class="nav-item">
                <a  href="{{ route('profile.edit') }} " class="nav-link {{ request()->is('/profile/edit') ? 'active' : '' }}" >Edit Profile</a>
              </li>



              <li class="nav-item">
                <li class="nav-item">
                    <a href="{{ route('profile.change-password') }}" class="nav-link {{ request()->is('/change-password') ? 'active' : '' }}">Change Password</a>
                  </li>
              </li>

            </ul>
            <div class="tab-content pt-2">

                <div class=" profile-edit pt-3" id="profile-edit">

                    <!-- Profile Edit Form -->
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                      <div class="row mb-3">
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                        <div class="col-md-8 col-lg-9">
                          <img   id="photo_preview-image" src="{{ asset(Auth::user()->photo?? "assets/img/profile-img.jpg") }}" alt="Profile">
                          <div class="pt-2">

                        <input id="photo" placeholder="Choose image" class="form-control" type="file"
                        name="photo" value="{{ Auth::user()->photo }}" >

                          </div>
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="name" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="name" type="text" class="form-control" id="name" value="{{ Auth::user()->name }}">
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label for="name" class="col-md-4 col-lg-3 col-form-label">Email</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="email" type="text" class="form-control" id="name" value="{{ Auth::user()->email }}">
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label for="name" class="col-md-4 col-lg-3 col-form-label">Email</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="username" type="text" class="form-control" id="name" value="{{ Auth::user()->username }}">
                        </div>
                      </div>

                      <div class="text-center">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                      </div>
                    </form><!-- End Profile Edit Form -->

                  </div>







            </div><!-- End Bordered Tabs -->

          </div>
        </div>

      </div>
    </div>

    </div>
  </section

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
