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
                    <h4 class="mb-0 font-size-18">Administrative Settings</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item">Administrative Settings</li>
                        </ol>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-soft-dark ">
                        <i class="fas fa-cog"></i> Google Calendar Settings
                        <button class="btn btn-outline-primary btn-sm float-right mr-2" title="helpModal" data-toggle="modal"
                        data-target="#helpModal">Use this Section</button>  
                        @include('components.modalform')
                    </div>
                    <div class="card-body">
                        <form action="{{ url('admin/account/google-calendar') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')


                            <div class="form-group">
                                <label>Calendar ID</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-key"></i></div>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Google calendar ID" name="calendar_id"
                                        id="calendar_id" value="{{ $accounts->calendar_id }}" required>
                                </div>
                            </div>
                            
                            <input type="hidden" name="calendar_credentials_path" value="{{ $accounts->calendar_credentials_path }}">
                            
                            <div class="form-group">
                                <label>Calendar Status</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-check"></i></div>
                                    </div>
                                    <select class="input form-control" name="calendar_enable" required>
                                        <option value="Y" {{ $accounts->calendar_enable === "Y" ? "selected" : "" }}>Enable</option>
                                        <option value="N" {{ $accounts->calendar_enable === "N" ? "selected" : "" }}>Disable</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Calendar Credentials File <small>(if you don't want to update your credentials leave it blank)</small></label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-lock"></i></div>
                                    </div>
                                    <input type="file" class="form-control" accept="application/json" name="calendar_credentials_file"
                                        id="credentials">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Settings</button>

                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-soft-dark ">
                        <i class="fas fa-cog"></i> Google Calendar Settings
                    </div>
                    <div class="card-body">
                        <form action="{{ url('admin/account/google-calendar') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')


                            <div class="form-group">
                                <label>Calendar ID</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-key"></i></div>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Google calendar ID" name="calendar_id"
                                        id="calendar_id" value="{{ $accounts->calendar_id }}" required>
                                </div>
                            </div>
                            
                            <input type="hidden" name="calendar_credentials_path" value="{{ $accounts->calendar_credentials_path }}">
                            
                            <div class="form-group">
                                <label>Calendar Status</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-check"></i></div>
                                    </div>
                                    <select class="input form-control" name="calendar_enable" required>
                                        <option value="Y" {{ $accounts->calendar_enable === "Y" ? "selected" : "" }}>Enable</option>
                                        <option value="N" {{ $accounts->calendar_enable === "N" ? "selected" : "" }}>Disable</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Calendar Credentials File <small>(if you don't want to update your credentials leave it blank)</small></label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-lock"></i></div>
                                    </div>
                                    <input type="file" class="form-control" accept="application/json" name="calendar_credentials_file"
                                        id="credentials">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Settings</button>

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