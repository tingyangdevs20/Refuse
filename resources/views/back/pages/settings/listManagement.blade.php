@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

    <style>
        .checkbox label .toggle,
        .checkbox-inline .toggle {
            margin-left: -20px;
            margin-right: 5px
        }

        .toggle {
            position: relative;
            overflow: hidden
        }

        .toggle input[type=checkbox] {
            display: none
        }

        .toggle-group {
            position: absolute;
            width: 200%;
            top: 0;
            bottom: 0;
            left: 0;
            transition: left .35s;
            -webkit-transition: left .35s;
            -moz-user-select: none;
            -webkit-user-select: none
        }

        .toggle.off .toggle-group {
            left: -100%
        }

        .toggle-on {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 50%;
            margin: 0;
            border: 0;
            border-radius: 0
        }

        .toggle-off {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 50%;
            right: 0;
            margin: 0;
            border: 0;
            border-radius: 0
        }

        .toggle-handle {
            position: relative;
            margin: 0 auto;
            padding-top: 0;
            padding-bottom: 0;
            height: 100%;
            width: 0;
            border-width: 0 1px
        }

        .toggle.btn {
            min-width: 100px;
            min-height: 34px
        }

        .toggle-on.btn {
            padding-right: 24px
        }

        .toggle-off.btn {
            padding-left: 24px
        }

        .toggle.btn-lg {
            min-width: 79px;
            min-height: 45px
        }

        .toggle-on.btn-lg {
            padding-right: 31px
        }

        .toggle-off.btn-lg {
            padding-left: 31px
        }

        .toggle-handle.btn-lg {
            width: 40px
        }

        .toggle.btn-sm {
            min-width: 50px;
            min-height: 30px
        }

        .toggle-on.btn-sm {
            padding-right: 20px
        }

        .toggle-off.btn-sm {
            padding-left: 20px
        }

        .toggle.btn-xs {
            min-width: 35px;
            min-height: 22px
        }

        .toggle-on.btn-xs {
            padding-right: 12px
        }

        .toggle-off.btn-xs {
            padding-left: 12px
        }

        body {
            padding: 10px;

        }


        #exTab2 h3 {
            color: white;
            background-color: #428bca;
            padding: 5px 15px;
        }

        .nav-tabs .active a {
            background-color: #327cad;
            /* Change to your preferred button color */
            color: #fff;
            /* Text color for the active tab */
            border-color: #327cad;
            /* Border color for the active tab */
            border-radius: 5px;
            /* Optional: Add rounded corners */
            padding: 13px;
        }

        /* Add other CSS styles for the non-active tabs as needed */
        .nav-tabs li a {
            /* background-color: #fff; Default background color for non-active tabs */
            color: #333;
            /* Default text color for non-active tabs */
            border-color: #ddd;
            /* Default border color for non-active tabs */
            padding: 13px;
        }
    </style>

    <style>
        #hidden_div {
            display: none;
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
                        <h4 class="mb-0 font-size-18">Settings</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item">Settings</li>
                            </ol>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            <i class="fas fa-cog mr-1"></i>List Management
                            {{-- <button class="btn btn-outline-primary btn-sm float-right mr-2" title="helpModal"
                                data-toggle="modal" data-target="#helpModal">How to Use</button> --}}
                            @include('components.modalform')


                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header  bg-soft-dark  ">
                            <ul class="nav nav-tabs">
                                <li class="active mr-3">
                                    <a href="#tags" data-toggle="tab">Tags</a>
                                </li>
                                <li><a class="mr-3" href="#sms_templates" data-toggle="tab">Custom Fields</a>
                                </li>
                                <li><a class="mr-3" href="#dnc_keywords" data-toggle="tab">DNC Keywords</a>
                                </li>
                                <li><a class="mr-3" href="#dnc_database" data-toggle="tab">Blacklist Management</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content clearfix">
                                <div class="tab-pane active" id="tags">
                                    <div class="card">
                                        <div class="card-header bg-soft-dark ">
                                            <i class="fas fa-cog mr-1"></i>Tags
                                            <button class="btn btn-outline-primary btn-sm float-right" title="New"
                                                data-toggle="modal" data-target="#newTag    Modal"><i
                                                    class="fas fa-plus-circle"></i></button>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-striped table-bordered" id="datatable">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Number of Contacts</th>
                                                        <th scope="col">Actions</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($tags as $tag)
                                                        <tr>
                                                            <td>{{ $tag->name }}</td>
                                                            <td><a
                                                                    href="{{ route('admin.tags.contacts', $tag->id) }}">{{ $tag->contactCount }}</a>
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-outline-primary btn-sm"
                                                                    title="Edit {{ $tag->name }}"
                                                                    data-id="{{ $tag->id }}"
                                                                    data-tagname="{{ $tag->name }}" data-toggle="modal"
                                                                    data-target="#editTagModal"><i
                                                                        class="fas fa-edit"></i></button>
                                                                @if ($tag->id > 1)
                                                                    -
                                                                    <button class="btn btn-outline-danger btn-sm"
                                                                        title="Remove {{ $tag->name }}"
                                                                        data-tagid="{{ $tag->id }}" data-toggle="modal"
                                                                        data-target="#deleteTagModal"><i
                                                                            class="fas fa-times-circle"></i></button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                            {{-- Modal New --}}
                                            <div class="modal fade" id="newTag  Modal" tabindex="-1" role="dialog"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">New Tag</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('admin.tag.store') }}" method="POST">
                                                            <div class="modal-body">
                                                                @csrf
                                                                @method('POST')
                                                                <div class="form-group">
                                                                    <label>Name</label>
                                                                    <input type="text" class="form-control"
                                                                        name="name" placeholder="Enter Tag Name"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancel</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Create</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- End Modal New --}}

                                            {{-- Modal Edit --}}
                                            <div class="modal fade" id="editTagModal" tabindex="-1" role="dialog"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Edit Tag</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('admin.tag.update', 'test') }}"
                                                            method="post" id="editForm">
                                                            @method('PUT')
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label>Name</label>
                                                                    <input type="hidden" id="id" name="id"
                                                                        value="">
                                                                    <input type="text" class="form-control"
                                                                        name="tag_name" id="tag_name">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancel</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Edit</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- End Modal Edit --}}
                                            {{-- Modal Delete --}}
                                            <div class="modal fade" id="deleteTagModal" tabindex="-1" role="dialog"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Delete Tag</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('admin.tag.destroy', 'test') }}"
                                                            method="post" id="editForm">
                                                            @method('DELETE')
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="modal-body">
                                                                    <p class="text-center">
                                                                        Are you sure you want to delete this?
                                                                    </p>
                                                                    <input type="hidden" id="tag_id" name="tag_id"
                                                                        value="">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Cancel</button>
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Delete</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- End Modal Delete --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="sms_templates">
                                    <div class="card">
                                        <div class="card-header bg-soft-dark ">
                                            <i class="fas fa-cog mr-1"></i>Custom Fields

                                        </div>
                                        <div class="card-body">
                                            <form action="{{ route('admin.field.store') }}" method="post"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('POST')
                                                <div class="row">
                                                    <div class="col-md-2">
                                                    </div>
                                                    <div class="col-md-7">
                                                        <div class="card col-md-12">
                                                            @php
                                                                $count = 1;
                                                            @endphp
                                                            @if (count($customfields) > 0)
                                                                @foreach ($customfields as $field)
                                                                    <div id="rowCount{{ $count }}"
                                                                        class="col-lg-12">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <button type="button" class="close"
                                                                                    data-dismiss="modal"
                                                                                    aria-label="Close"
                                                                                    style="color: #f00;padding: 10px 5px;"
                                                                                    onclick="removeRow('{{ $count }}');">
                                                                                    <i class="fas fa-trash"></i>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <input type="hidden" class="form-control"
                                                                            placeholder="Days"
                                                                            value="{{ $field->id }}"
                                                                            name="field_list_id[]">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group mt-3">
                                                                                    <label>Select Section</label>
                                                                                    <select class="custom-select"
                                                                                        name="section_id[]" required>
                                                                                        @foreach ($sections as $section)
                                                                                            <option
                                                                                                value="{{ $section->id }}"
                                                                                                @if ($section->id == $field->section_id) selected @endif>
                                                                                                {{ $section->name }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group mt-3">
                                                                                    <label>Field Label</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="label[]"
                                                                                        placeholder="Field Label"
                                                                                        value="{{ $field->label }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group mt-3">
                                                                                    <label>Field Type</label>
                                                                                    <select class="custom-select"
                                                                                        name="type[]" required>
                                                                                        <option value="text"
                                                                                            @if ($field->type == 'text') selected="selected" @endif>
                                                                                            Text</option>
                                                                                        <option value="number"
                                                                                            @if ($field->type == 'number') selected="selected" @endif>
                                                                                            Number</option>
                                                                                        <option value="date"
                                                                                            @if ($field->type == 'date') selected="selected" @endif>
                                                                                            Date</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <div class="row">
                                                                                <div class="col-md-4 text-center">
                                                                                </div>
                                                                                <div class="col-md-4 text-center">
                                                                                    <hr>
                                                                                </div>
                                                                                <div class="col-md-4 text-center">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    @php
                                                                        $count++;
                                                                    @endphp
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                        <div class="addNewRow"></div>
                                                        {{-- Add Button --}}
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-md-3 text-center">
                                                                </div>
                                                                <div class="col-md-6 text-center">
                                                                    <button type="button" class="btn btn-primary mt-2"
                                                                        onclick="addNewRows(this.form);">Add New Custom
                                                                        Field</button>
                                                                </div>
                                                                <div class="col-md-3 text-center">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <button type="submit" class="btn btn-primary mt-2 btn-submit"
                                                        @if (count($customfields) == 0) disabled @endif>Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="dnc_keywords">
                                    <div class="card">
                                        <div class="card-header bg-soft-dark ">
                                            <i class="fas fa-cog mr-1"></i>DNC Keywords
                                            <button class="btn btn-outline-primary btn-sm float-right" title="New"
                                                data-toggle="modal" data-target="#newDNCKeywordsModal"><i
                                                    class="fas fa-plus-circle"></i></button>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-striped table-bordered" id="datatable">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Keyword</th>
                                                        <th scope="col">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($dncs as $dnc)
                                                        <tr>
                                                            <td>{{ $sr++ }}</td>
                                                            <td>{{ $dnc->keyword }}</td>
                                                            <td>
                                                                <button class="btn btn-outline-primary btn-sm"
                                                                    title="Edit {{ $dnc->keyword }}"
                                                                    data-keyword="{{ $dnc->keyword }}"
                                                                    data-id={{ $dnc->id }} data-toggle="modal"
                                                                    data-target="#editDNCKeywordsModal"><i
                                                                        class="fas fa-edit"></i></button> -
                                                                <button class="btn btn-outline-danger btn-sm"
                                                                    title="Remove {{ $dnc->keyword }}"
                                                                    data-id="{{ $dnc->id }}" data-toggle="modal"
                                                                    data-target="#deleteDNCKeywordsModal"><i
                                                                        class="fas fa-times-circle"></i></button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                            {{-- Modal New --}}
                                            <div class="modal fade" id="newDNCKeywordsModal" tabindex="-1"
                                                role="dialog" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">New Keyword
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('admin.dnc-database.store') }}"
                                                            method="POST">
                                                            <div class="modal-body">
                                                                @csrf
                                                                @method('POST')
                                                                <div class="form-group">
                                                                    <label>Keyword</label>
                                                                    <input type="text" class="form-control"
                                                                        name="keyword" placeholder="Enter Keyword"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancel</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Create</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- End Modal New --}}

                                            {{-- Modal Edit --}}
                                            <div class="modal fade" id="editDNCKeywordsModal" tabindex="-1"
                                                role="dialog" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Edit Keyword
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('admin.dnc-database.update', 'test') }}"
                                                            method="post" id="editForm">
                                                            @method('PUT')
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label>Keyword</label>
                                                                    <input type="hidden" id="id" name="id"
                                                                        value="">
                                                                    <input type="text" class="form-control"
                                                                        name="keyword" id="keyword" required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancel</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Edit</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- End Modal Edit --}}
                                            {{-- Modal Delete --}}
                                            <div class="modal fade" id="deleteDNCKeywordsModal" tabindex="-1"
                                                role="dialog" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Delete DNC Keyword</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('admin.dnc-database.destroy', 'test') }}"
                                                            method="post" id="editForm">
                                                            @method('DELETE')
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="modal-body">
                                                                    <p class="text-center">
                                                                        Are you sure you want to delete this?
                                                                    </p>
                                                                    <input type="hidden" id="id" name="id"
                                                                        value="">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Cancel</button>
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Delete</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- End Modal Delete --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="dnc_database">
                                    <div class="card">
                                        <div class="card-header bg-soft-dark ">
                                            <i class="fas fa-cog mr-1"></i>Blacklist Management
                                            <button class="btn btn-outline-primary btn-sm float-right" title="New"
                                                data-toggle="modal" data-target="#newBlacklistModal"><i
                                                    class="fas fa-plus-circle"></i></button>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-striped table-bordered" id="datatable">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Number</th>
                                                        <th scope="col">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($numbers as $number)
                                                        <tr>
                                                            <td>{{ $sr++ }}</td>
                                                            <td>{{ $number->number }}</td>
                                                            <td>
                                                                <button class="btn btn-outline-primary btn-sm"
                                                                    title="Edit {{ $number->number }}"
                                                                    data-number="{{ $number->number }}"
                                                                    data-id={{ $number->id }} data-toggle="modal"
                                                                    data-target="#editBlackListModal"><i
                                                                        class="fas fa-edit"></i></button> -
                                                                <button class="btn btn-outline-danger btn-sm"
                                                                    title="Remove {{ $number->number }}"
                                                                    data-id="{{ $number->id }}" data-toggle="modal"
                                                                    data-target="#deleteBlackListModal"><i
                                                                        class="fas fa-times-circle"></i></button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                            {{-- Modal New --}}
                                            <div class="modal fade" id="newBlacklistModal" tabindex="-1" role="dialog"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">New Blacklist
                                                                Number</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('admin.blacklist.store') }}"
                                                            method="POST">
                                                            <div class="modal-body">
                                                                @csrf
                                                                @method('POST')
                                                                <div class="form-group">
                                                                    <label>Blacklist Number</label>
                                                                    <input type="text" class="form-control"
                                                                        name="number" placeholder="Enter Number"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancel</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Create</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- End Modal New --}}

                                            {{-- Modal Edit --}}
                                            <div class="modal fade" id="editBlackListModal" tabindex="-1" role="dialog"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Edit Blacklist
                                                                Number</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('admin.blacklist.update', 'test') }}"
                                                            method="post" id="editForm">
                                                            @method('PUT')
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label>Number</label>
                                                                    <input type="hidden" id="id" name="id"
                                                                        value="">
                                                                    <input type="text" class="form-control"
                                                                        name="number" id="number" required>

                                                                </div>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancel</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Edit</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- End Modal Edit --}}
                                            {{-- Modal Delete --}}
                                            <div class="modal fade" id="deleteBlackListModal" tabindex="-1" role="dialog"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Delete Number</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('admin.blacklist.destroy', 'test') }}"
                                                            method="post" id="editForm">
                                                            @method('DELETE')
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="modal-body">
                                                                    <p class="text-center">
                                                                        Are you sure you want to delete this?
                                                                    </p>
                                                                    <input type="hidden" id="id" name="id"
                                                                        value="">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Cancel</button>
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Delete</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- End Modal Delete --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    <link rel="stylesheet" href="{{ asset('/summernote/dist/summernote.css') }}" />
    <script src="{{ asset('/summernote/dist/summernote.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();
        });

        $(".summernote-usage").summernote({
            height: 200,
        });

        var rowCount = {{ count($customfields) }}

        function addNewRows(frm) {
            rowCount++;
            var recRow = '<div id="rowCount' + rowCount +
                '" class="col-lg-12"><div class="row"><div class="col-md-12"><button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #f00;padding: 10px 5px;" onclick="removeRow(' +
                rowCount +
                ');"><i class="fas fa-trash"></i></button></div></div><div class="row"><input type="hidden"  class="form-control" placeholder="Days" value="0" name="field_list_id[]"><div class="col-md-12"><div class="form-group"><label>Select Section</label><select class="custom-select" name="section_id[]" required> @foreach ($sections as $section) <option value="{{ $section->id }}">{{ $section->name }}</option> @endforeach </select></div></div></div><div class="row"><div class="col-md-12"><div class="form-group mt-3"><label>Field Label</label><input type="text" class="form-control" name="label[]"></div></div></div><div class="row"><div class="col-md-12"><div class="form-group mt-3"><label>Field Type</label><select class="custom-select" name="type[]" required><option value="text" >Text</option><option value="number">Number</option><option value="date">Date</option></select></div></div></div><div class="col-md-12"><div class="row"><div class="col-md-4 text-center"></div><div class="col-md-4 text-center"><hr></div><div class="col-md-4 text-center"></div></div></div></div></div>';
            //var recRow = '<div id="rowCount'+rowCount+'" class="col-lg-12"><div class="card col-md-12"><div class="row"><div class="col-md-12"><button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #f00;" onclick="removeRow('+rowCount+');"><i class="fas fa-trash"></i></button><div class="form-group mt-3"><label>Campaign Type</label><select class="custom-select" name="type[]" onchange="" required><option value="sms">SMS</option><option value="email">Email</option><option value="mms">MMS</option><option value="rvm">RVM</option></select></div></div></div><div class="row"><div class="col-md-3"><div class="form-group text-right mt-2"><label>Delays</label></div></div><div class="col-md-3"><div class="form-group"><div class="input-group mb-2"><div class="input-group-prepend"><div class="input-group-text"><i class="fas fa-calendar"></i></div></div><input type="number" min="0" class="form-control" placeholder="Days" name="send_after_days[]"></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group mb-2"><div class="input-group-prepend"><div class="input-group-text"><i class="fas fa-calendar"></i></div></div><input type="number" min="0" class="form-control" placeholder="Hours" name="send_after_hours[]"></div></div></div><div class="col-md-3"></div></div><div class="row show_sms"><div class="col-md-12"><div class="form-group "><label >Message</label><textarea id="template_text" class="form-control"  rows="10" required name="message"></textarea><div id="count" class="float-lg-right"></div></div></div></div><div class="row show_email" style="display:none;"><div class="col-md-6"><div class="form-group"><label >Subject</label><input type="text"  class="form-control" placeholder="Subject" name="receiver_number" /></div></div><div class="col-md-12"><div class="form-group "><label >Message</label><textarea id="template_text" class="form-control"  rows="10" required name="message"></textarea><div id="count" class="float-lg-right"></div></div></div></div><div class="row show_mms" style="display:none;"><div class="col-md-6"><div class="form-group"><label>Media File (<small class="text-danger">Disregard if not sending MMS</small>)</label><input type="file" class="form-control-file" name="media_file"></div></div><div class="col-md-12"><div class="form-group "><label >Message</label><textarea id="template_text" class="form-control"  rows="10" required name="message"></textarea><div id="count" class="float-lg-right"></div></div></div></div><div class="row show_rvm" style="display:none;"><div class="col-md-6"><div class="form-group"><label>Media File (<small class="text-danger">Disregard if not sending MMS</small>)</label><input type="file" class="form-control-file" name="media_file[]"></div></div></div><div class="col-md-12"><div class="row"><div class="col-md-4 text-center"></div><div class="col-md-4 text-center"><hr></div><div class="col-md-4 text-center"></div></div></div></div></div>';
            jQuery('.addNewRow').append(recRow);
            jQuery(".btn-submit").removeAttr("disabled")
        }

        function removeRow(removeNum) {
            jQuery('#rowCount' + removeNum).remove();
        }

        $('#editTagModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var id = button.data('id');
            var tagname = button.data('tagname');
            var modal = $(this);

            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #tag_name').val(tagname);
        });
        $('#deleteTagModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var tagid = button.data('tagid');
            var modal = $(this);
            modal.find('.modal-body #tag_id').val(tagid);
        });

        $('#editDNCKeywordsModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var keyword = button.data('keyword');
            var id = button.data('id');

            var modal = $(this);

            modal.find('.modal-body #keyword').val(keyword);
            modal.find('.modal-body #id').val(id);

        });
        $('#deleteDNCKeywordsModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
        });

        $('#editBlackListModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var number = button.data('number');
            var id = button.data('id');

            var modal = $(this);

            modal.find('.modal-body #number').val(number);
            modal.find('.modal-body #id').val(id);

        });
        $('#deleteBlackListModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
        });
    </script>

    <script>
        function showDiv(divId, element) {
            document.getElementById(divId).style.display = element.value == 1 ? 'block' : 'none';
        }

        function templateId() {
            template_id = document.getElementById("template-select").value;
            setTextareaValue(template_id)
        }
    </script>
    <script>
        function setTextareaValue(id) {
            if (id > 0) {
                axios.get('/admin/template/' + id)
                    .then(response =>
                        document.getElementById("template_text").value = response.data['body'],
                    )
                    .catch(error => console.log(error));
            } else {
                document.getElementById("template_text").value = '';
            }


        }
        const textarea = document.querySelector('textarea')
        const count = document.getElementById('count')
        textarea.onkeyup = (e) => {
            count.innerHTML = "Characters: " + e.target.value.length + "/160";
        };

        function messageType(type, id) {
            $('.show_sms_' + id).html('');
            var url = '<?php echo url('/admin/get/message/'); ?>/' + type + '/' + id;
            //alert(url);
            $.ajax({
                type: 'GET',
                url: url,
                data: '',
                processData: false,
                contentType: false,
                success: function(d) {
                    $('.show_sms_' + id).html(d);
                }
            });
        }
    </script>
@endsection
