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
                                    <h4 class="mb-0 font-size-18">Group Management</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Dashboard</a></li>
                                            <li class="breadcrumb-item">Group Management</li>
                                            <li class="breadcrumb-item active">Numbers</li>
                                        </ol>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header bg-soft-dark ">
                                        All Numbers
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-striped table-bordered" id="datatable">
                                            <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">First Name</th>
                                                <th scope="col">Last Name</th>
                                                <th scope="col">Street</th>
                                                <th scope="col">City</th>
                                                <th scope="col">State</th>
                                                <th scope="col">Zip</th>
                                                <th scope="col">Numbers</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Lead Category</th>
                                                <th scope="col">Mail Sent</th>
                                                <th scope="col">Contract Verified</th>
                                                <th scope="col">Message Sent</th>
                                                <th scope="col">DNC</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($contacts as $contact)
                                            <tr>
                                                <td>{{ $sr++ }}</td>
                                                <td>{{ $contact->name }}</td>
                                                <td>{{ $contact->last_name }}</td>
                                                <td>{{ $contact->street }}</td>
                                                <td>{{ $contact->city }}</td>
                                                <td>{{ $contact->state }}</td>
                                                <td>{{ $contact->zip }}</td>
                                                <td>
                                                    Number1:{{ $contact->number }}<br>
                                                    Number2:{{ $contact->number2 }}<br>
                                                    Number3:{{ $contact->number3 }}
                                                </td>
                                                <td>
                                                    Email1:{{ $contact->email1 }}<br>
                                                    Email2:{{ $contact->email2 }}
                                                </td>
                                                <td>{{ $contact->getLeadCategory()}}</td>
                                                <td>{{ $contact->mail_sent?"YES":"NO" }}</td>
                                                <td>{{ $contact->contract_verified?"YES":"NO" }}</td>
                                                <td>{{ $contact->msg_sent?"YES":"NO" }}</td>
                                                <td>{{ $contact->is_dnc?"YES":"NO" }}</td>
                                            </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
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
    <script >
        $(document).ready(function() {
            $('#datatable').DataTable();
        } );
    </script>

    @endsection
