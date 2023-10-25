@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <style>
        /* Ensure the table takes the full width of its container */
        .table-responsive {
            overflow-x: auto;
        }

        /* Add horizontal scrolling for the table on smaller screens */
        /* .table {
                white-space: nowrap;
            } */

        /* Add responsive breakpoints and adjust table font size and padding as needed */
        @media (max-width: 768px) {
            .table {
                font-size: 12px;
            }
        }
    </style>
@endsection
@section('content')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <form name="bulk_action_form" action="#" method="post" class="col-lg-12" /><!-- oldmailurl working -->
                <!-- <form name="bulk_action_form" action="{{ url('api/contactmail') }}" method="post" class="col-lg-12" > -->
                @csrf
                @method('POST')
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">Contract View</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item">Contract View</li>
                            </ol>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"
                                style="float: right;"> Add Contract</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="datatable">
                                    <thead>
                                        <tr>
                                            {{-- <th scope="col">#</th> --}}
                                            <th scope="col">Content</th>
                                            <th scope="col">Type Contract</th>
                                            <th scope="col">File</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($contractres as $value)
                                            <tr>

                                                <td>{{ $value->content }}</td>
                                                <td>{{ $value->type_contract }}</td>
                                                <td>{{ $value->file }}</td>
                                                <td> <button type="button" class="btn btn-primary" data-toggle="modal"
                                                        data-target="#exampleModal{{ $value->id }}" style="float: right;">
                                                        Edit Contract</button> </td>

                                            </tr>
                                            </form>
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal{{ $value->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Edit Contract </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('admin.uploadcontractedit') }}"
                                                                method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('POST')
                                                                <div class="form-group">
                                                                    <input type="hidden" name="userid"
                                                                        value="{{ $value->id }}">
                                                                    <input type="text" class="form-control"
                                                                        style="width: 100%;" required id="optiontype"
                                                                        name="optiontype" value="{{ $value->type_contract }}">
                                                                </div>
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input"
                                                                        id="customFile" name="file" required>
                                                                    <label class="custom-file-label" for="customFile">Choose
                                                                        file</label>
                                                                </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- end page title -->

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->



    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Contract </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.uploadcontract') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <!-- <select class="form-control" style="width: 100%;" required id="optiontype" name="optiontype">
                                            <option value="">Type of contract</option>

                                            <option value="11">contract 1</option>
                                            <option value="22">contract 2</option>
                                            <option value="33">contract 3</option>

                                        </select> -->
                            <input type="text" class="form-control" style="width: 100%;" required id="optiontype"
                                name="optiontype" placeholder="Enter Contract Name">

                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="customFile" name="file" required>
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();
        });

        $(document).ready(function() {
            $("#select_all").click(function() {
                if (this.checked) {
                    $('.checkbox').each(function() {
                        $(".checkbox").prop('checked', true);
                    })
                } else {
                    $('.checkbox').each(function() {
                        $(".checkbox").prop('checked', false);
                    })
                }
            });
        });
    </script>
@endsection
