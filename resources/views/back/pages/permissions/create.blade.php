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
                        <h4 class="mb-0 font-size-18">Permission Management</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Dashboard</a></li>
                                <li class="breadcrumb-item">Permission Management</li>
                                <li class="breadcrumb-item active">Create Permission</li>
                            </ol>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            Create Permission
                            <a href="{{URL::previous()}}" class="btn btn-outline-primary btn-sm float-right ml-2" title="New" ><i class="fas fa-arrow-left"></i></a>
                            @include('components.modalform')
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.permissions.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Role Name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter a Role Name">
                                </div>

                                <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Save Role</button>
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

<script >
    $(document).ready(function() {
        $('#datatable').DataTable();
    } );
</script>
<script >

</script>
@endsection
