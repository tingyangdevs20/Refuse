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
                                        <input type="text" class="form-control @error('country') is-invalid @enderror" id="goal" name="goal" placeholder="10">
                                        @error('goal')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="money_per_month">How much money do you want to make per month?</label>
                                        <input type="text" class="form-control @error('money_per_month') is-invalid @enderror" id="money_per_month" name="money_per_month" placeholder="10000">
                                        @error('money_per_month')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gross_profit">What is your average gross profit per deal?</label>
                                        <input type="text" class="form-control @error('gross_profit') is-invalid @enderror" id="gross_profit" name="gross_profit" placeholder="1000">
                                        @error('gross_profit')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact_trun_into_lead">What percentage of the people you contact turn into leads?</label>
                                        <input type="text" class="form-control @error('contact_trun_into_lead') is-invalid @enderror" id="contact_trun_into_lead" name="contact_trun_into_lead" placeholder="10">
                                        @error('contact_trun_into_lead')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="leads_into_phone">What percentage of your leads are you able to get on the phone?</label>
                                        <input type="text" class="form-control @error('leads_into_phone') is-invalid @enderror" id="leads_into_phone" name="leads_into_phone" placeholder="10">
                                        @error('leads_into_phone')
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
                                            <option value="{{$data->id}}">{{$data->attribute}}</option>
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
                                            @foreach($users as $data)
                                            <option value="{{$data->id}}">{{$data->name}}</option>
                                            @endforeach


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
