<!doctype html>
<html lang="en">


<!-- Mirrored from www.wrraptheme.com/templates/lucid/html/light/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 13 Mar 2022 17:20:26 GMT -->
@include('backend.layouts.head')
<body class="theme-cyan">

<!-- Page Loader -->
{{--  <div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30"><img src="https://www.wrraptheme.com/templates/lucid/html/assets/images/logo-icon.svg" width="48" height="48" alt="Lucid"></div>
        <p>Please wait...</p>        
    </div>
</div>  --}}
<!-- Overlay For Sidebars -->

<div id="wrapper">

    @include('backend.layouts.navbar')

    @include('backend.layouts.sidebar')

    <div id="main-content">
        @yield('content')
    </div>
    
</div>

<!-- Javascript -->
@include('backend.layouts.script')
</body>

<!-- Mirrored from www.wrraptheme.com/templates/lucid/html/light/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 13 Mar 2022 17:20:57 GMT -->
</html>
