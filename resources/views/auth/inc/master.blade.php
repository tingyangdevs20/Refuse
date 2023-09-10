<!doctype html>
<html lang="en">


<!-- Mirrored from themesbrand.com/skote/layouts/vertical/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 15 Jul 2020 09:26:23 GMT -->
<head>

    <meta charset="utf-8" />
    <title>Login | Bulk SMS Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Bulk SMS Dashboard" name="oscar-tango.com" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('back/assets/images/sms.svg') }}">

    <!-- Bootstrap Css -->
    <link href="{{ asset('back/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('back/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('back/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

</head>

<body>
<div class="home-btn d-none d-sm-block">
    <a href="{{ route('login') }}" class="text-dark"><i class="fas fa-home h2"></i></a>
</div>

@yield('content')


<!-- JAVASCRIPT -->
<script src="{{ asset('back/assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('back/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('back/assets/libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('back/assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('back/assets/libs/node-waves/waves.min.js') }}"></script>

<!-- App js -->
<script src="{{ asset('back/assets/js/app.js') }}"></script>
</body>

<!-- Mirrored from themesbrand.com/skote/layouts/vertical/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 15 Jul 2020 09:26:23 GMT -->
</html>
