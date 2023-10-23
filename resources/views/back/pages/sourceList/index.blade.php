@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">

                        <h4 class="mb-0 font-size-18">Source List</h4>
                       
                    </div>
                    <div class="ct_message_text">

                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            How To Source A List



                            {{-- <button class="btn btn-outline-primary btn-sm float-right" title="helpModal" data-toggle="modal"
                                    data-target="#helpModal">How to Use</button> --}}
                            @include('components.modalform')

                        </div>
                    </div>
                    <link href="https://widget.groovevideo.com/widget/app.css" rel="stylesheet"><groovevideo-widget
                        id="220865" permalink="YTQTSyJxr36QdX94aRh6"></groovevideo-widget>
                    <script src="https://widget.groovevideo.com/widget/app.js"></script>
                    <br />

                    <div style="font-size:18px;margin-top:10px;font-weight:bold;text-align:center">To signup for a
                        PropStream account, please click here to get a 7 day free trial.</div>
                </div>

            </div>
        </div>
        <!-- end page title -->

    </div> <!-- container-fluid -->
    </div>
@endsection
