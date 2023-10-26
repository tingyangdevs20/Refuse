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
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">Received SMS</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item">Leads</li>
                                <li class="breadcrumb-item active">Received SMS</li>
                            </ol>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            All Messages
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Client#</th>
                                            <th scope="col">Twilio#</th>
                                            <th scope="col">Media</th>
                                            <th scope="col">Message</th>
                                            <th scope="col">Replies</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($messages as $msg)
                                            <tr>
                                                <td>{{ $sr++ }}</td>
                                                <td>{{ $msg->client_number }}</td>
                                                <td>{{ $msg->twilio_number }}</td>
                                                @if ($msg->media != 'No')
                                                    <td><a href="{{ asset($msg->media) }}" target="_blank">Yes</a></td>
                                                @else
                                                    <td><a href="#">No</a></td>
                                                @endif
                                                <td>{{ $msg->message }}</td>
                                                <td><a
                                                        href="{{ route('admin.sms.show', $msg) }}">{{ $msg->replies()->count() }}</a>
                                                </td>
                                            </tr>
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
@endsection
@section('scripts')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();
        });
    </script>
@endsection
