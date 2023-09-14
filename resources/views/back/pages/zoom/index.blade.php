@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">

    <style>
      
        .status-span {
            background-color: red;
            color:#fff;
            border-radius: 5px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
            padding: 5px;
        }

        .no-status {
            /* Styles specific to 'No' status */
            background-color: #00ffe7;
            color:#fff;
            border-radius: 5px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
            padding: 5px;
            /* Add any other styles for 'No' status here */
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
                        <h4 class="mb-0 font-size-18">Zoom Management</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Dashboard</a></li>
                                <li class="breadcrumb-item">Zoom Management</li>
                                <li class="breadcrumb-item active">Zoom</li>
                            </ol>
                        </div>
                    </div>
                    @include('back.pages.partials.messages')
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            All Zoom Meeting List
                            @if(auth()->user()->can('administrator') || auth()->user()->can('zoom_create'))
                            <a href="{{route('admin.zoom.create')}}" class="btn btn-outline-primary btn-sm float-right" title="New" ><i class="fas fa-plus-circle"></i></a>
                            @endif
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered" id="datatable">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Topic</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Finished</th>
                                    <th scope="col">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($meetings as $meeting)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $meeting->meeting_name }}</td>
                                        @php $meeting_date = \Carbon\Carbon::parse($meeting->meeting_date) @endphp
                                        <td>{{ $meeting_date->format('j F Y') }}</td>
                                        <td>
                                            <span class="status-span{{ $meeting->status == 'No' ? ' no-status' : '' }}">
                                                {{ $meeting->status }}
                                            </span>
                                        </td>

                                        
                                        <td>
                                            @if(auth()->user()->can('administrator') || auth()->user()->can('meeting_edit'))
                                            <a href="{{ route('admin.zoom.edit', $meeting->id) }}" class="btn btn-outline-primary btn-sm" title="Edit  meeting" ><i class="fas fa-edit"></i></a> -
                                            @endif

                                            @if(auth()->user()->can('administrator') || auth()->user()->can('meeting_edit'))
                                            <!-- meeting url generate -->
                                            <a href="" class="btn btn-outline-primary btn-sm" title="Join meeting url" ><i class="fas fa-link"></i></a> -
                                            @endif

                                            @if(auth()->user()->can('administrator') || auth()->user()->can('meeting_delete'))
                                            <a href="{{ route('admin.zoom.destroy', $meeting->id) }}" class="btn btn-outline-danger btn-sm"
                                            title="Remove" onclick="event.preventDefault(); confirmDelete({{ $meeting->id }});">
                                            <i class="fas fa-times-circle"></i>
                                            </a>
                                            <form id="delete-form-{{ $meeting->id }}" action="{{ route('admin.zoom.destroy', $meeting->id) }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                            @endif

                                        </td>
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
        function confirmDelete(roleId) {
        if (confirm('Are you sure you want to delete this record?')) {
            document.getElementById('delete-form-' + roleId).submit();
        }
    }
</script>
@endsection
