@extends('back.inc.master')
@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
<style>
span.select2-selection.select2-selection--single {
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
                    <h4 class="mb-0 font-size-18">Goals</h4>
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
                        Create Your Goal
                       <!-- <a href="{{URL::previous()}}" class="btn btn-outline-primary btn-sm float-right" title="New"><i
                                class="fas fa-arrow-left"></i></a>-->
                                <button class="btn btn-outline-primary btn-sm float-right mr-2" title="helpModal" data-toggle="modal"
                        data-target="#helpModal">How To Use</button>  
                        @include('components.modalform')
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('admin.savegoals') }}" enctype="multipart/form-data">
                            @csrf
                            <!-- CSRF Token -->
                            <div class="col-md-6" style="display:none">
                                <div class="form-group">
                                    <label for="goal">Goal</label>
                                    <input type="text" class="form-control @error('country') is-invalid @enderror"
                                        id="goal" name="goal" placeholder="10000">
                                    @error('goal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="money_per_month">How much money do you want to make per month? (can be
                                        ambitious but attainable) </label>
                                    <input type="number"
                                        class="form-control @error('money_per_month') is-invalid @enderror"
                                        id="money_per_month" name="money_per_month" placeholder="10000" step="any">
                                    @error('money_per_month')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="gross_profit">What is your average gross profit per deal?</label>
                                    <input type="number"
                                        class="form-control @error('gross_profit') is-invalid @enderror"
                                        id="gross_profit" name="gross_profit" placeholder="1000" step="any">
                                    @error('gross_profit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contact_trun_into_lead">What percentage of the people you contact turn into leads? (a lead is a person at least open to the idea of selling their property…not a phone lead… just someone that said they might be open to selling) (if you don’t know, our user average is 1.5%)</label>
                                    <input type="number"
                                        class="form-control @error('contact_trun_into_lead') is-invalid @enderror"
                                        id="contact_trun_into_lead" step="any" name="contact_trun_into_lead"
                                        placeholder="10">
                                    @error('contact_trun_into_lead')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="leads_into_phone">What percentage of your leads are you able to get on the phone? (if you don’t know, our user average is 50%)</label>
                                    <input type="number"
                                        class="form-control @error('leads_into_phone') is-invalid @enderror"
                                        id="leads_into_phone" step="any" name="leads_into_phone" placeholder="10">
                                    @error('leads_into_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="signed_agreements">Of the people you talk to on the phone, what percentage will you get a signed contract from? (if you don’t know, our user average is 10%)</label>
                                    <input type="number"
                                        class="form-control @error('signed_agreements') is-invalid @enderror"
                                        id="signed_agreements" step="any" name="signed_agreements" step="any"
                                        placeholder="10%">
                                    @error('signed_agreements')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="escrow_closure">Of the signed contracts you get back, what percentage close escrow? (if you don’t know, our user average 80%)</label>
                                    <input type="number"
                                        class="form-control @error('escrow_closure') is-invalid @enderror"
                                        id="escrow_closure" step="any" name="escrow_closure" step="any"
                                        placeholder="80%">
                                    @error('escrow_closure')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6" style="display:none">
                                <div class="form-group">
                                    <label for="escrow_closure">Passed Inspection </label>
                                    <input type="number"
                                        class="form-control @error('passed_inspection') is-invalid @enderror"
                                        id="passed_inspection" step="any" name="passed_inspection" step="any"
                                        placeholder="">
                                    @error('passed_inspection')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6" style="display:none">
                                <div class="form-group">
                                    <label for="escrow_closure">Passed Title Search </label>
                                    <input type="number"
                                        class="form-control @error('passed_title_search') is-invalid @enderror"
                                        id="passed_title_search" step="any" name="passed_title_search" step="any"
                                        placeholder="">
                                    @error('passed_title_search')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6" style="display:none">
                                <div class="form-group">
                                    <label for="escrow_closure">Deal Closed</label>
                                    <input type="number" class="form-control @error('deal_closed') is-invalid @enderror"
                                        id="deal_closed" step="any" name="deal_closed" step="any" placeholder="5">
                                    @error('deal_closed')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>






                            <div class="col-md-6" style="display:none">
                                <div class="form-group">
                                    <label for="attribute">Attribute</label>
                                    <select class="form-control @error('attribute') is-invalid @enderror" id="attribute"
                                        name="attribute">
                                        <option value="">Select Attribute</option>

                                        @foreach($attributes as $data)
                                        <option value="{{$data->id}}">{{$data->attribute}}</option>
                                        @endforeach

                                    </select>
                                    @error('attribute')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group" style="display:none">
                                    <label for="user">User</label>
                                    <select class="form-control @error('user') is-invalid @enderror" id="user"
                                        name="user">
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
<script>
$(document).ready(function() {
    $('#datatable').DataTable();
    $('select').select2();

});
</script>
<script>

</script>
@endsection