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
                        <h4 class="mb-0 font-size-18">SMS</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Dashboard</a></li>
                                <li class="breadcrumb-item">Bulk SMS</li>
                                <li class="breadcrumb-item active">Bulk SMS By Category</li>
                            </ol>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            <i class="fas fa-edit"></i> Compose Message
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.bulksmscategory.store') }}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text"><i
                                                        class="fas fa-mobile text-warning"></i></label>
                                            </div>
                                            <select class="custom-select" required name="sender_number">
                                                <option value="">Sender's Number</option>
                                                @foreach($numbers as $number)
                                                    <option
                                                        value="{{ $number->number.'|'.$number->account->account_id.'|'.$number->account->account_token }}">{{ $number->number }}
                                                        - {{ $number->account->account_name }} - Available Sends: {{ $number->sms_allowed - $number->sms_count }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text">Group</label>
                                            </div>
                                            <select class="custom-select" id="group" name="group" required>
                                                @foreach($groups as $group)
                                                    <option value="">Select Group</option>
                                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group pt-2">
                                    <label>Message Category</label>
                                    <select class="custom-select" name="category" required>
                                        @foreach($categories as $category)
                                            <option value="">Select Message Category</option>
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary" {{ $number->sms_allowed ==$number->sms_count?'disabled':'' }}>Send SMS</button>
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
