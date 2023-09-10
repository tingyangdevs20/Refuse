@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
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
                        <h4 class="mb-0 font-size-18">System Messages</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Dashboard</a></li>
                                <li class="breadcrumb-item">System Messages</li>
                            </ol>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            <i class="fas fa-cog"></i> Control Messages Settings
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.systemmsg.updates',1) }}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                               
                                <div class="form-group">
                                    <label>Change Message</label>
                                    <div class="input-group mb-2">
                                        <!-- <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-envelope"></i></div>
                                        </div> -->
                                        <textarea class="ct_text_area" name="systemsg" id="systemmsg" cols="30" rows="10">{{ $systemsgResponses[0]->message }}</textarea>
                                        <!-- <input type="text" class="form-control" placeholder="System Messages"
                                               name="systemmsg" required> -->
                                    </div>
                                </div>
                                
                                
                          
                          
                       


                                <button type="submit" class="btn btn-primary">Update Messages</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

@endsection
@section('scripts')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#datatable').DataTable();
        });
    </script>
@endsection
