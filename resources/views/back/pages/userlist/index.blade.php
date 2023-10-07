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
                        <h4 class="mb-0 font-size-18">User Management</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Dashboard</a></li>
                                <li class="breadcrumb-item">User Management</li>
                                <li class="breadcrumb-item active">Users</li>
                            </ol>
                        </div>
                    </div>
                    @include('back.pages.partials.messages')
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            All Users
                            @if(auth()->user()->can('administrator') || auth()->user()->can('user_create'))
                            <a href="{{route('admin.user.create')}}" class="btn btn-outline-primary btn-sm float-right" title="New" ><i class="fas fa-plus-circle"></i></a>
                            @endif
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered" id="datatable">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Status</th>
                                    @if(auth()->user()->can('administrator') || auth()->user()->can('user_edit'))
                                    <th scope="col">Switch</th>
                                    @endif
                                    <th scope="col">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @foreach($user->roles()->pluck('name') as $role)
                                            <span class="badge badge-info">{{ $role }}</span>
                                        @endforeach
                                    </td>
                                    <td>@if ($user->status == 0)
                                                Invited
                                            @else
                                                User Terminated
                                            @endif</td>
                                    @if(auth()->user()->can('administrator') || auth()->user()->can('user_edit'))
                                   
                                    <td>
                                        @if(auth()->user()->email != $user->email)
                                        <a href="{{ route('admin.user.switch', $user->id) }}" class="btn btn-outline-info btn-sm" title="Switch Role">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @endif
                                    </td>
                                    @endif

                                    
                                    <td>
                                        @if(auth()->user()->can('administrator') || auth()->user()->can('user_edit'))
                                        <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-outline-primary btn-sm" title="Edit  User" ><i class="fas fa-edit"></i></a> -
                                        @endif
                                        @if(auth()->user()->can('administrator') || auth()->user()->can('user_delete'))
                                        <a href="{{ route('admin.user.destroy', $user->id) }}" class="btn btn-outline-danger btn-sm"
                                        title="Remove" onclick="event.preventDefault(); confirmDelete({{ $user->id }});">
                                        <i class="fas fa-times-circle"></i>
                                        </a>
                                        <form id="delete-form-{{ $user->id }}" action="{{ route('admin.user.destroy', $user->id) }}" method="POST" style="display: none;">
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
<script >

</script>
@endsection
