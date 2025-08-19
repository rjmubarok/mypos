<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center ">

    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center">
            {{--  <img src="{{ \App\Models\Institute::value('logo') }}" alt="">  --}}
            <span class="d-none d-lg-block">POS</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->



    <nav class="header-nav ms-auto ">
        <ul class="d-flex align-items-center">


             {{--  <div class="col-md-6">
                <select class="form-control changeLang">
                    <option value="en" {{ session()->get('locale') == 'en' ? 'selected' : '' }}>English</option>
                    <option value="bn" {{ session()->get('locale') == 'bn' ? 'selected' : '' }}>বাংলা</option>
                </select>
            </div>  --}}

            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-2" href="#" data-bs-toggle="dropdown">
                    <img src="{{ asset(auth()->user()->photo ?? "assets/img/profile-img.jpg") }}" alt="Profile" class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2">{{auth()->user()->name ?? ''}}</span>
                </a><!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">


                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('profile') }}">
                            <i class="bi bi-person"></i>
                            <span>My Profile</span>
                        </a>
                    </li>


                    <li>
                        <hr class="dropdown-divider">
                    </li>


                    <li>

                        <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}" onclick="event.preventDefault();
                	         document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                        <form id="logout-form" action="{{route('logout')}}" method="POST">
                            @csrf
                        </form>
                    </li>



                </ul><!-- End Profile Dropdown Items -->
            </li>

        </ul>
    </nav>

</header>

@section('scripts')
<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
{{--  <script type="text/javascript">

    var url = "{{ route('changeLang') }}";

    $(".changeLang").change(function(){
        window.location.href = url + "?lang="+ $(this).val();
    });

</script>  --}}
@endsection



