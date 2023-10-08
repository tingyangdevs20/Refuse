@extends('back.inc.master')
@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    label span.required {
        color: red;
    }

    .select2-container {
        display: block !important;
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
                    <h4 class="mb-0 font-size-18">User Agreements</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item">Lead Generations</li>
                            <li class="breadcrumb-item active">Digital Signing</li>
                        </ol>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header bg-soft-dark ">
                        Digital Signing
                        <button class="btn btn-outline-primary btn-sm float-right addUserAgreement" title="New"><i
                                class="fas fa-plus-circle"></i></button>
                        <button class="btn btn-outline-primary btn-sm float-right" title="helpModal" data-toggle="modal"
                            data-target="#helpModal">How to use</button>
                    </div>

                    <?php
                    //print_r($userAgreements);

                    ?>
                    <div class="card-body">
                        <table class="table table-striped table-bordered" id="datatable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Agreement Date</th>
                                    <th scope="col">Form Template</th>
                                    <th scope="col">No. of Users </th>
                                    {{-- <th scope="col">Mail Sent </th> --}}
                                    <th scope="col">Contract Signed </th>
                                    <th scope="col">Contract PDF</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($userAgreements as $key=>$useragreement)
                                <tr>
                                    <td>{{ $key+1}}</td>
                                    <td>{{ $useragreement->agreement_date }}</td>
                                    <td>{{ $useragreement->template_name }}</td>
                                    <td>
                                        @if(isset($useragreement->userAgreementSeller) &&
                                        $useragreement->userAgreementSeller->count() > 0)
                                        <span class="badge badge-success">
                                            {{ $useragreement->userAgreementSeller->count() }} Seller
                                        </span>
                                        @else
                                        <span class="badge badge-danger">
                                            No Users
                                        </span>

                                        @endif
                                    </td>
                                    {{-- <td>{{$useragreement->is_send_mail}}</td> --}}
                                    <td> @if($useragreement->is_sign >=2 || $useragreement->pdf_path != "" ) <span
                                            class="badge badge-success">Completed</span> @else <span
                                            class="badge badge-danger">Pending</span> @endif
                                    </td>
                                    <td>
                                        @if(isset($useragreement->userAgreementSeller) &&
                                        $useragreement->userAgreementSeller->count() > 0)
                                            @foreach ($useragreement->userAgreementSeller as $pdf)
                                                @php
                                                    $path = $pdf->pdf_path;
                                                    $path_array = explode('/',$path);
                                                    $path = end($path_array);
                                                @endphp
                                                <a href="{{ asset('agreement_pdf/'.$path) }}" target="_blank"
                                                    class="btn btn-outline-primary btn-sm" title="View PDF"><i
                                                        class="fas fa-eye"></i>
                                                </a>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        @if($useragreement->pdf_path == "")
                                        <button class="btn btn-outline-primary btn-sm editUserAgreement" title="Edit"
                                            data-id="{{ $useragreement->id }}"><i class="fas fa-edit"></i></button>


                                        <button class="btn btn-outline-danger btn-sm deleteUserAgreement" title="Remove"
                                            data-id="{{ $useragreement->id }}" data-toggle="modal"
                                            data-target="#deleteModal{{ $useragreement->id }}">
                                            <i class="fas fa-times-circle"></i>
                                        </button>
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
@include('back.pages.user-agreement.modal')
@endsection
@push('js')
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('back/assets/js/pages/user-agreement.js?t=')}}<?= time() ?>"></script>
@endpush
