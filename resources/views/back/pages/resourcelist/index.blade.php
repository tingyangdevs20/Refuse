@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet"/>

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
                        <h4 class="mb-0 font-size-18">Source List Management</h4>
                       
                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            All Source List
                            <button class="btn btn-outline-primary btn-sm float-right" title="New" data-toggle="modal"
                                    data-target="#newModal"><i class="fas fa-plus-circle"></i></button>

                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
@endsection
