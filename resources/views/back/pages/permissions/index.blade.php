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
                        <h4 class="mb-0 font-size-18">Permissions Management</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Dashboard</a></li>
                                <li class="breadcrumb-item">Permissions Management</li>
                                <li class="breadcrumb-item active">Permissions</li>
                            </ol>
                        </div>
                    </div>
                    @include('back.pages.partials.messages')
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            All Permissions
                            @if(auth()->user()->can('administrator') || auth()->user()->can('permissions_create'))
                            <a href="{{route('admin.permissions.create')}}" class="btn btn-outline-primary btn-sm float-right" title="New" ><i class="fas fa-plus-circle"></i></a>
                            @endif
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered" id="datatable">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Permissions</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($permissions as $permission)
                                    <tr>
                                         <td>{{ $loop->index+1 }}</td>
                                         <td>{{ $permission->name }}</td>

                                         <td>
                                            @if(auth()->user()->can('administrator') || auth()->user()->can('permissions_edit'))
                                             <a href="{{ route('admin.permissions.edit', $permission->id) }}" class="btn btn-outline-primary btn-sm" title="Edit  Permission" ><i class="fas fa-edit"></i></a> -
                                            @endif

                                             @if(auth()->user()->can('administrator') || auth()->user()->can('permissions_delete'))
                                             <a href="{{ route('admin.permissions.destroy', $permission->id) }}" class="btn btn-outline-danger btn-sm"
                                                title="Remove" onclick="event.preventDefault(); confirmDelete({{ $permission->id }});">
                                                <i class="fas fa-times-circle"></i>
                                                </a>
                                                <form id="delete-form-{{ $permission->id }}" action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST" style="display: none;">
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
</script>
<script >
function confirmDelete(roleId) {
    if (confirm('Are you sure you want to delete this record?')) {
        document.getElementById('delete-form-' + roleId).submit();
    }
}
</script>
@endsection
