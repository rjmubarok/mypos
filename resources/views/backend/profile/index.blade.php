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
            <div class="tab-content pt-2">

              <div class="  show active profile-overview" id="profile-overview">
                <h5 class="card-title">About</h5>
                <p class="small fst-italic">Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.</p>

                <h5 class="card-title">Profile Details</h5>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label ">Full Name</div>
                  <div class="col-lg-9 col-md-8">{{Auth::user()->name??''}}</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Company</div>
                  <div class="col-lg-9 col-md-8">Mubarok talecome</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Job</div>
                  <div class="col-lg-9 col-md-8">Retailer</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Country</div>
                  <div class="col-lg-9 col-md-8">Bangladesh</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Address</div>
                  <div class="col-lg-9 col-md-8">Bhalokber, Shohagi , Mymensingh</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">User Name</div>
                  <div class="col-lg-9 col-md-8">{{Auth::user()->username??''}}</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Email</div>
                  <div class="col-lg-9 col-md-8">{{Auth::user()->email??''}}</div>
                </div>

              </div>







            </div><!-- End Bordered Tabs -->

          </div>
        </div>

      </div>
    </div>

    </div>
  </section

@endsection

