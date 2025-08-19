@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<div class="pagetitle">
    <h1>Profile</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('Dashboard') }}">Home</a></li>
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

            <img src="{{ asset(Auth::user()->photo?? "assets/img/profile-img.jpg") }}" alt="Profile" class="rounded-circle">
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
                <a class="nav-link {{ request()->is('profile') ? 'active' : '' }}" href="{{ route('profile') }}">Overview</a>
              </li>

              <li class="nav-item">
                <a  href="{{ route('profile.edit') }}" class="nav-link {{ request()->is('profile.edit') ? 'active' : '' }}" >Edit Profile</a>
              </li>


              <li class="nav-item">
                <a href="{{ route('profile.change-password') }}" class="nav-link">Change Password</a>
              </li>

            </ul>
            <div class=" pt-3" id="profile-change-password">
                <!-- Change Password Form -->
                <form action="{{ route('profile.update-password') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')
<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                  <div class="row mb-3">
                    <label for="oldpassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="oldpassword" type="password" class="form-control" id="oldpassword">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="newpassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="newpassword" type="password" class="form-control" id="newpassword">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="renewpassword" type="password" class="form-control" id="renewPassword">
                    </div>
                  </div>

                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Change Password</button>
                  </div>
                </form><!-- End Change Password Form -->

              </div>

          </div>
        </div>

      </div>
    </div>

    </div>
  </section

@endsection

