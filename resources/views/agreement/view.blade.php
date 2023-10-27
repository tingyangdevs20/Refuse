<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Bulk SMS Dashboard </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Pet Store Dashboard" name="description" />
    <meta content="Themesbrand" name="author" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('back/assets/images/sms.svg') }}">

    <!-- Bootstrap Css -->
    <link href="{{ asset('back/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('back/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('back/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .pos-btn {
            position: fixed;
            bottom: 45px;
            right: 20px;
            z-index: 9;
            width: fit-content;
            width: -webkit-fit-content;
            width: -moz-fit-content;
            width: -ms-fit-content;
            width: -o-fit-content;
            height: fit-content;
            height: -webkit-fit-content;
            height: -moz-fit-content;
            height: -ms-fit-content;
            height: -o-fit-content;
        }

        .pos-btn button.btn-pos {
            display: inline-block;
            width: auto;
            height: 48px;
            line-height: 48px;
            padding: 0px 16px;
            text-align: center;
            color: #fff;
            font-size: 18px;
            border-radius: 5px;
            box-shadow: 0px 3px 8.46px 0.54px rgb(0 0 0 / 24%);
            text-transform: unset;
        }

        .myFooter {
            left: 0px;
        }

        .police-cnt-main {
            height: 750px;
            padding: 10px;
            display: flex;
            flex-wrap: wrap;
            flex-flow: column;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 5px 9px 1px rgb(0 0 0 / 10%);
            overflow-y: scroll;
        }

        .new-main-centent {
            margin-left: 0px;
        }

        .k-input-text {
            width: 100%;
            border: 1px dashed #2948df;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 5px 9px 1px rgb(0 0 0 / 10%);
        }

        #bcPaint-header {
            width: 100%;
            height: 25px;
        }

        #bcPaint-palette {
            text-align: center;
        }

        .bcPaint-palette-color {
            width: 20px;
            height: 20px;
            display: inline-block;
            cursor: pointer;
            border-radius: 15px;
            margin: 0 5px;
        }
    </style>
    @yield('styles')
</head>

<body data-sidebar="dark">

    <!-- Begin page -->
    <div id="layout-wrapper">
        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <div class="navbar-brand-box">
                        <a href="#" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="{{ asset('back/assets/images/sms.svg') }}" alt="" height="25">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('back/assets/images/sms.png') }}" alt="" height="30">
                            </span>
                        </a>

                        <a href="{{ route('admin.dashboard') }}" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="{{ asset('back/assets/images/sms.png') }}" alt="" height="58">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('back/assets/images/sms.png') }}" alt="" height="50">
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </header>
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content new-main-centent">
            <div class="page-content ">
                <div class="container-fluid police-cnt-main">
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <!-- Start Page-content -->
                            {!! stripslashes($content) !!}

                            @if ($userAgreement->sign == "" && $userAgreement->is_sign != "2" &&
                            $userAgreement->pdf_path == "")
                            <div class="pos-btn">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-pos btn-primary signContract"
                                    data-key="{{$agreementKey}}" data-toggle="modal" data-target="#modal-sign-contract">
                                    <i class="fas fa-signature"></i> I agree,I want to sign
                                </button>
                            </div>
                            @endif
                            <!-- End Page-content -->
                        </div>
                    </div>
                    <!-- end page title -->
                </div> <!-- container-fluid -->
            </div>
            <footer class="footer myFooter">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © REIFuze.
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!-- Modal -->
    <div class="modal fade" id="modal-sign-contract" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sign Agreement</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-contract-sign" name="form-contract-sign" enctype="multipart/form-data">
                        <div id="bcPaint-header">
                            <div id="bcPaint-palette">
                                <div class="bcPaint-palette-color changeColor" data-color="rgb(34, 147, 251)"
                                    style="background-color: rgb(34, 147, 251);">
                                </div>
                                <div class="bcPaint-palette-color changeColor" data-color="rgb(70, 54, 227)"
                                    style="background-color: rgb(70, 54, 227);">
                                </div>
                                <div class="bcPaint-palette-color changeColor" data-color="rgb(0, 0, 0)"
                                    style="background-color: rgb(0, 0, 0);">
                                </div>
                                <div class="bcPaint-palette-color changeColor" data-color="rgb(0, 8, 132)"
                                    style="background-color: rgb(0, 8, 132);"></div>
                                <div class="bcPaint-palette-color changeColor" data-color="rgb(0, 15, 255)"
                                    style="background-color: rgb(0, 15, 255);"></div>
                                <div class="bcPaint-palette-color changeColor" data-color="rgb(181, 112, 91)"
                                    style="background-color: rgb(181, 112, 91);"></div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12 k-input-text">
                                <canvas id="signature-pad" class="signature-pad" width="450" height="300">
                                </canvas>
                                <span class="error k-error" id="image_error"></span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer text-center">
                    <button type="submit" class="btn btn-primary" id="saveSign" data-key="{{ $agreementKey }}">
                        <i class="fas fa-signature"></i> Sign Agreement
                    </button>
                    <button type="button" class="btn btn-danger" id="clearSignature">
                        <i class="fas fa-eraser"></i> Clear Signature
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var publicPath = "{!! URL::to('/') !!}/";
    </script>

    <script src="{{asset('front/js/jquery-3.6.0.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('back/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{asset('front/js/signature_pad.min.js')}}"></script>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    <script src="{{ asset('front/js/sign.js?t=')}}<?= time() ?>"></script>
</body>

</html>