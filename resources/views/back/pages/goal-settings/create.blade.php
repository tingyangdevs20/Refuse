@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
    <style>
        span.select2-selection.select2-selection--single{
            height: 40px;
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
                        <h4 class="mb-0 font-size-18">Data Management</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Dashboard</a></li>
                                <li class="breadcrumb-item">Data Management</li>
                                <li class="breadcrumb-item active">Data</li>
                            </ol>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            Create Goal 
                            <a href="{{URL::previous()}}" class="btn btn-outline-primary btn-sm float-right" title="New" ><i class="fas fa-arrow-left"></i></a>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('admin.savegoals') }}" enctype="multipart/form-data">
                                @csrf <!-- CSRF Token -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="goal">Goal</label>
                                        <input type="text" class="form-control @error('country') is-invalid @enderror" id="goal" name="goal">
                                        @error('goal')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="attribute">Attribute</label>
                                        <select class="form-control @error('attribute') is-invalid @enderror" id="attribute" name="attribute"  >
                                            <option value="">Select Attribute</option>
                                            
                                            @foreach($attributes as $data)
                                            <option value="$data->id">$data->attribute</option>
                                            @endforeach

                                        </select>
                                        @error('attribute')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="user">User</label>
                                        <select class="form-control @error('user') is-invalid @enderror" id="user" name="user"  >
                                            <option value="">Select User</option>
                                            <option value="1">100k-300k</option>
                                            <option value="2">300k-600k</option>

                                        </select>
                                        @error('user')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    
                                </div>
                                <button type="submit" class="btn btn-primary">Add Data</button>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
<script >
    $(document).ready(function() {
        $('#datatable').DataTable();
        $('select').select2();

    } );
</script>
<script >

</script>
@endsection
