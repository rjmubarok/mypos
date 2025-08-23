@include('layouts.head')

<body>
    {{-- <div class="loader">
        <img src="{{ asset('assets/img/preloader.gif')}}" alt="load">
    </div> --}}
    @include('sweetalert::alert')

    @include('layouts.header')
    @include('layouts.sidebar')

    <main id="main" class="main">

        @yield('content')

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    @include('layouts.footer')

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    @include('layouts.script')

    @yield('scripts')
</body>

</html>
