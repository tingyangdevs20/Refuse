<!doctype html>
<html lang="en">
<head>

    <meta charset="utf-8" />
    <title>Bulk SMS Dashboard </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Pet Store Dashboard" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('back/assets/images/sms.svg') }}">

    <!-- Bootstrap Css -->
    <link href="{{ asset('back/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('back/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('back/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
@yield('styles')
</head>

<body data-sidebar="dark">

<!-- Begin page -->
<div id="layout-wrapper">


   

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

       @yield('content')
        <!-- End Page-content -->


        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <script>document.write(new Date().getFullYear())</script> © REIFuze.
                    </div>
                    <div class="col-sm-6">
                        <div class="text-sm-right d-none d-sm-block">
                            
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->



<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<!-- JAVASCRIPT -->
<script src="{{ asset('back/assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('back/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('back/assets/libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('back/assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('back/assets/libs/node-waves/waves.min.js') }}"></script>

<!-- apexcharts -->
{{--<script src="{{ asset('back/assets/libs/apexcharts/apexcharts.min.js') }}"></script>--}}

<!-- Saas dashboard init -->
{{--<script src="{{ asset('back/assets/js/pages/saas-dashboard.init.js') }}"></script>--}}

<script src="{{ asset('back/assets/js/app.js') }}"></script>
@include('sweetalert::alert')

@yield('scripts')
</body>
</html>
