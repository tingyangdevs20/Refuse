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
                            <i class="fas fa-cog mr-1"></i> Templates
                            {{-- <button class="btn btn-outline-primary btn-sm float-right mr-2" title="helpModal"
                                data-toggle="modal" data-target="#helpModal">How to Use</button> --}}
                            @include('components.modalform')


                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header  bg-soft-dark  ">
                            <ul class="nav nav-tabs">
                                <li class="active mr-3">
                                    <a href="#scripts2" data-toggle="tab"> Scripts</a>
                                </li>
                                <li><a class="mr-3" href="#sms_templates" data-toggle="tab">SMS/MMS Templates</a>
                                </li>
                                <li><a class="mr-3" href="#digital_sign_templates" data-toggle="tab">Digital Sign.
                                        Templates</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content clearfix">
                                <div class="tab-pane active" id="scripts2">
                                    <div class="card">
                                        <div class="card-header bg-soft-dark ">
                                            <i class="fas fa-cog mr-1"></i>Scripts>
                                            <button class="btn btn-outline-primary btn-sm float-right" title="New"
                                                data-toggle="modal" data-target="#newScriptodal"><i
                                                    class="fas fa-plus-circle"></i></button>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-striped table-bordered" id="datatable">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Name</th>

                                                        <!--<th scope="col">Media URL</th>-->
                                                        <th scope="col">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($scripts as $script)
                                                        <tr>
                                                            <td>{{ $sr++ }}</td>
                                                            <td>{{ $script->name }}</td>
                                                            <td>

                                                            </td>
                                                            <td>
                                                                <button class="btn btn-outline-primary btn-sm edit-Script"
                                                                    title="Edit {{ $script->name }}"
                                                                    data-name="{{ $script->name }}"
                                                                    data-body="{{ htmlspecialchars_decode(stripslashes($script->scripts)) }}"
                                                                    data-id="{{ $script->id }}" data-toggle="modal"
                                                                    data-target="#editScriptModal"><i
                                                                        class="fas fa-edit"></i></button>
                                                                -
                                                                <button class="btn btn-outline-danger btn-sm"
                                                                    title="Remove {{ $script->name }}"
                                                                    data-id="{{ $script->id }}" data-toggle="modal"
                                                                    data-target="#deleteScriptModal"><i
                                                                        class="fas fa-times-circle"></i></button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            {{-- Modals --}}
                                            {{-- Modal New --}}
                                            <div class="modal fade" id="newScriptodal" tabindex="-1" role="dialog"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">New Script</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('admin.script.store') }}" method="POST"
                                                            enctype="multipart/form-data">
                                                            <div class="modal-body">
                                                                @csrf
                                                                @method('POST')
                                                                <div class="form-group">
                                                                    <label>Title</label>
                                                                    <input type="text" class="form-control"
                                                                        name="name" placeholder="Enter Script Title"
                                                                        required>
                                                                </div>
                                                                <div class="show_email">
                                                                    <div class="form-group">
                                                                        <label>Script</label>
                                                                        <textarea class="form-control email_body summernote-usage" name="scripts" rows="10"></textarea>
                                                                        <!--<div id='count11' class="float-lg-right"></div>-->
                                                                    </div>
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
                                            <div class="modal fade" id="editScriptModal" tabindex="-1" role="dialog"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Edit Script
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('admin.script.update', 'test') }}"
                                                            method="post" id="editForm" enctype="multipart/form-data">
                                                            @method('PUT')
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label>Name</label>
                                                                    <input type="hidden" id="id" name="id"
                                                                        value="">
                                                                    <input type="text" class="form-control"
                                                                        name="name" id="name_edit" required>
                                                                </div>
                                                                <div class="show_email_edit">
                                                                    <div class="form-group">
                                                                        <label>Body</label>
                                                                        <textarea class="form-control text12333 email_body_edit summernote-usage" name="scripts" id="body_email"
                                                                            rows="10"></textarea>
                                                                        <!--<div id='count12' class="float-lg-right"></div>-->
                                                                    </div>
                                                                </div>
                                                                <!--//////-->
                                                                <!--<div class="form-group">-->
                                                                <!--    <label>Media File (<small class="text-danger">Disregard if not sending MMS</small>)</label>-->
                                                                <!--    <input type="file" class="form-control-file" name="media_file">-->
                                                                <!--    <label>(<small class="text-danger font-weight-bold">if uploading new file, remove the old link from body</small>)</label>-->
                                                                <!--</div>-->
                                                                <!--<div class="form-group">-->
                                                                <!--    <label>Body</label>-->
                                                                <!--    <textarea class="form-control message text2" name="body" id="body" rows="10"></textarea>-->
                                                                <!--    <div id='count2' class="float-lg-right"></div>-->

                                                                <!--</div>-->
                                                                <!--<div class="form-group">-->
                                                                <!--    <small class="text-danger"><b>Use {name} {street} {city} {state} {zip} to substitute the-->
                                                                <!--            respective fields</b></small>-->
                                                                <!--</div>-->

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancel</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Update</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- End Modal Edit --}}
                                            {{-- Modal Delete --}}
                                            <div class="modal fade" id="deleteScriptModal" tabindex="-1" role="dialog"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Delete Script</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('admin.script.destroy', 'test') }}"
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
                                <div class="tab-pane" id="sms_templates">
                                    <div class="card">
                                        <div class="card-header bg-soft-dark ">
                                            <i class="fas fa-cog mr-1"></i> SMS/MMS Templates
                                            <button class="btn btn-outline-primary btn-sm float-right" title="New"
                                                data-toggle="modal" data-target="#newSMSModal"><i
                                                    class="fas fa-plus-circle"></i></button>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-striped table-bordered" id="datatable">
                                                <thead>
                                                    <tr>

                                                        <th scope="col">Template Name</th>
                                                        <th scope="col">Type</th>
                                                        <th scope="col">Message Count</th>


                                                        <!--<th scope="col">Media URL</th>-->
                                                        <th scope="col">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($templates as $template)
                                                        <tr>

                                                            <td><a
                                                                    href="template/view/{{ $template->id }}">{{ $template->title }}</a>
                                                            </td>
                                                            <td>{{ $template->type }}</td>

                                                            <td>
                                                                {{ $template->message_count }}
                                                            </td>

                                                            <td>
                                                                <button
                                                                    class="btn btn-outline-primary btn-sm edit-template"
                                                                    title="Edit {{ $template->title }}"
                                                                    data-title="{{ $template->title }}"
                                                                    data-mediaurl="{{ $template->mediaUrl }}"
                                                                    data-category="{{ $template->category_id }}"
                                                                    data-type="{{ $template->type }}"
                                                                    data-subject="{{ $template->subject }}"
                                                                    data-body="{{ htmlspecialchars_decode(stripslashes($template->body)) }}"
                                                                    data-id="{{ $template->id }}" data-toggle="modal"
                                                                    data-target="#editSMSModal"><i
                                                                        class="fas fa-edit"></i></button>
                                                                -
                                                                <button class="btn btn-outline-danger btn-sm"
                                                                    title="Remove {{ $template->title }}"
                                                                    data-id="{{ $template->id }}" data-toggle="modal"
                                                                    data-target="#deleteSMSModal"><i
                                                                        class="fas fa-times-circle"></i></button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <!-- End Page-content -->
                                            {{-- Modals --}}
                                            {{-- Modal New --}}
                                            <div class="modal fade" id="newSMSModal" tabindex="-1" role="dialog"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">New Template
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('admin.template.store') }}" method="POST"
                                                            enctype="multipart/form-data">
                                                            <div class="modal-body">
                                                                @csrf
                                                                @method('POST')
                                                                <div class="form-group">
                                                                    <label>Template Name</label>
                                                                    <input type="text" class="form-control"
                                                                        name="title" placeholder="Enter Template Name"
                                                                        required>
                                                                </div>


                                                                <div class="form-group pt-2">
                                                                    <label>Message Type</label><br>
                                                                    <select class="from-control" style="width: 100%;"
                                                                        id="type" name="type" required>
                                                                        <option value="">Select Type</option>
                                                                        <option value="SMS">SMS</option>
                                                                        <option value="MMS">MMS</option>
                                                                        <option value="Email">Email</option>

                                                                    </select>
                                                                </div>

                                                                <div class="show_media_rvm" style="display:none;">
                                                                    <div class="form-group">
                                                                        <label>Media File (<small
                                                                                class="text-danger">Disregard if not
                                                                                sending MMS</small>)</label>
                                                                        <input type="file" class="form-control-file"
                                                                            name="media_file">
                                                                    </div>
                                                                </div>
                                                                <div class="show_media_mms" style="display:none;">
                                                                    <div class="form-group">
                                                                        <label>Media File (<small
                                                                                class="text-danger">Disregard if not
                                                                                sending MMS</small>)</label>
                                                                        <input type="file" class="form-control-file"
                                                                            name="media_file_mms">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Body</label>
                                                                        <textarea class="form-control text111 mms_body" name="mms_body" rows="10"></textarea>
                                                                        <div id='count111' class="float-lg-right"></div>
                                                                    </div>
                                                                    <div class="form-group">

                                                                        <small class="text-danger"><b>Use {name} {street}
                                                                                {city} {state} {zip} to substitute the
                                                                                respective fields</b></small>
                                                                    </div>
                                                                </div>
                                                                <div class="show_sms" style="display:none;">
                                                                    <div class="form-group">
                                                                        <label>Body</label>
                                                                        <textarea class="form-control text1 body_sms" name="body" rows="10"></textarea>
                                                                        <div id='count' class="float-lg-right"></div>
                                                                    </div>
                                                                    <div class="form-group">

                                                                        <small class="text-danger"><b>Use {name} {street}
                                                                                {city} {state} {zip} to substitute the
                                                                                respective fields</b></small>
                                                                    </div>
                                                                </div>
                                                                <div class="show_email" style="display:none;">
                                                                    <div class="form-group">
                                                                        <label>Subject</label>
                                                                        <input type="text"
                                                                            class="form-control email_body" name="subject"
                                                                            placeholder="Enter Subject">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Body</label>
                                                                        <textarea class="form-control email_body summernote-usage" name="email_body" rows="10"></textarea>
                                                                        <!--<div id='count11' class="float-lg-right"></div>-->
                                                                    </div>
                                                                    <div style="display:none" class="form-group">

                                                                        <small class="text-danger"><b>Use {name} {street}
                                                                                {city} {state} {zip} to substitute the
                                                                                respective fields</b></small>
                                                                    </div>
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
                                            <div class="modal fade" id="editSMSModal" tabindex="-1" role="dialog"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Edit Template
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('admin.template.update', 'test') }}"
                                                            method="post" id="editForm" enctype="multipart/form-data">
                                                            @method('PUT')
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label>Template Name</label>
                                                                    <input type="hidden" id="id" name="id"
                                                                        value="">
                                                                    <input type="text" class="form-control"
                                                                        name="title" id="title" required>
                                                                </div>


                                                                <div class="form-group pt-2">
                                                                    <label>Message Type</label><br>
                                                                    <select class="from-control" style="width: 100%;"
                                                                        id="type" name="type" required>
                                                                        <option value="">Select Type</option>
                                                                        <option value="SMS">SMS</option>
                                                                        <option value="MMS">MMS</option>
                                                                        <option value="Email">Email</option>

                                                                    </select>
                                                                </div>


                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancel</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Update</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- End Modal Edit --}}
                                            {{-- Modal Delete --}}
                                            <div class="modal fade" id="deleteSMSModal" tabindex="-1" role="dialog"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Delete Template</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('admin.template.destroy', 'test') }}"
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
                                <div class="tab-pane" id="digital_sign_templates">
                                    <div class="card">
                                        <div class="card-header bg-soft-dark ">
                                            <i class="fas fa-cog mr-1"></i> Digital Sign. Templates
                                            <button class="btn btn-outline-primary btn-sm float-right" title="New"
                                                data-toggle="modal" data-target="#newModal">
                                                <i class="fas fa-plus-circle"></i>
                                            </button>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-striped table-bordered" id="datatable">
                                                <thead>
                                                    <tr>

                                                        <th scope="col"> Template Name </th>
                                                        <th scope="col"> Status </th>

                                                        <th scope="col">Created On</th>
                                                        <th scope="col">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($groups as $group)
                                                        <tr>

                                                            <td>{{ $group->template_name }}</td>


                                                            <td>
                                                                @if ($group->status == 0)
                                                                    {{ 'Active' }}
                                                                @else
                                                                    {{ 'Deactive' }}
                                                                @endif
                                                            </td>
                                                            <td>{{ \Carbon\Carbon::parse($group->created_at)->format('m/d/Y') }}
                                                            </td>
                                                            <td>
                                                                <button
                                                                    class="btn btn-outline-primary btn-sm edit-template"
                                                                    data-html="{{ $group->content }}"
                                                                    onclick="autofill($(this), '{{ json_encode(['id' => $group->id, 'template_name' => $group->template_name, 'status' => $group->status]) }}')"
                                                                    title="Edit {{ $group->name }}"
                                                                    data-id="{{ $group->id }}" data-toggle="modal"
                                                                    data-target="#editModal">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>

                                                                <button class="btn btn-outline-danger btn-sm"
                                                                    title="Remove {{ $group->name }}"
                                                                    data-id="{{ $group->id }}" data-toggle="modal"
                                                                    data-target="#deleteDigitalModal{{ $group->id }}">
                                                                    <i class="fas fa-times-circle"></i>
                                                                </button>
                                                            </td>

                                                            <!-- Edit Modal -->

                                                            {{-- Edit Modal New --}}

                                                            {{-- End Modal New --}}

                                                            <!-- End Edit Modal -->

                                                            {{-- Modal Delete --}}
                                                            <div class="modal fade"
                                                                id="deleteDigitalModal{{ $group->id }}" tabindex="-1"
                                                                role="dialog" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Delete List</h5>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <form
                                                                            action="{{ route('admin.delete-form-templates') }}"
                                                                            method="post" id="editForm">
                                                                            @method('POST') @csrf <div
                                                                                class="modal-body">
                                                                                <div class="modal-body">
                                                                                    <p class="text-center"> Are you sure
                                                                                        you want to delete
                                                                                        this? </p>
                                                                                    <input type="hidden" id="id"
                                                                                        name="id"
                                                                                        value="{{ $group->id }}">
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button"
                                                                                        class="btn btn-secondary"
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

                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                            {{-- Modal New --}}
                                            <div class="modal fade" id="newModal" tabindex="-1" role="dialog"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel"> New Template
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('admin.form-templates-store') }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            <div class="modal-body"> @csrf @method('POST')

                                                                <div class="form-group">
                                                                    <label style="margin-right:50px">Template Name</label>
                                                                    <input type="text" class="form-control"
                                                                        name="template_name"
                                                                        placeholder="Enter Template Name" required>
                                                                </div>

                                                                {{-- <div class="form-group pt-2">
            <label> Template Content </label>
            <br>
            <textarea class="form-control ckeditor" style="width: 100%;" id="market" name="content"
              required> </textarea>
          </div> --}}
                                                                <div class="row">
                                                                    <div class="col-8">
                                                                        <div class="form-group pt-2">
                                                                            <label> Template Content </label>
                                                                            <br>
                                                                            <textarea class="form-control ckeditor" style="width: 100%;" id="addcontent" name="content" required> </textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <div class="form-group pt-2">
                                                                            <label>Insert Short Codes</label>
                                                                            <br>
                                                                            <select class="form-control insert_code"
                                                                                name="short_code" id="insert_code"
                                                                                data-type = "add">
                                                                                <option value="">Select Code</option>
                                                                                @foreach ($short_code as $key => $code)
                                                                                    <option value="{{ $key }}">
                                                                                        {{ $code }} </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group pt-2">
                                                                    <label>Document Type</label>
                                                                    <br>
                                                                    <select class="form-control" name="status" required>
                                                                        <option value="">Select Document Type
                                                                        </option>
                                                                        <option value="Miscellaneous" selected>
                                                                            Miscellaneous. </option>

                                                                    </select>
                                                                </div>

                                                                <div class="form-group pt-2">
                                                                    <label>Status</label>
                                                                    <br>
                                                                    <select class="form-control" name="status" required>
                                                                        <option value="">Select Status</option>
                                                                        <option value="0" selected> Active </option>
                                                                        <option value="1"> Deactive </option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group pt-2" style="display:none">
                                                                    <label>Sortcode For Variables</label>
                                                                    <br>
                                                                    {{ '{' . implode('} ,{', $short_code) . '}' }}
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

                                            {{-- Edit Model --}}
                                            <div class="modal fade" id="editModal" tabindex="-1" role="dialog"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel"> Edit Form
                                                                Template </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('admin.update-form-templates') }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            <div class="modal-body"> @csrf @method('POST')
                                                                <input type="hidden" name="id" id="editrecid">
                                                                <div class="form-group">
                                                                    <label style="margin-right:50px">Template Name</label>
                                                                    <input type="text" class="form-control"
                                                                        name="template_name" id="edittemplate_name"
                                                                        placeholder="Enter Template Name" required>
                                                                </div>

                                                                {{-- <div class="form-group pt-2">
              <label> Template Content </label>
              <br>
              <textarea class="form-control ckeditor" style="width: 100%;" id="editcontent" name="content"
                required> </textarea>
            </div> --}}
                                                                <div class="row">
                                                                    <div class="col-8">
                                                                        <div class="form-group pt-2">
                                                                            <label> Template Content </label>
                                                                            <br>
                                                                            <textarea class="form-control ckeditor" style="width: 100%;" id="editcontent" name="content" required> </textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <div class="form-group pt-2">
                                                                            <label>Insert Short Codes</label>
                                                                            <br>
                                                                            <select class="form-control insert_code"
                                                                                name="short_code" id="insert_code"
                                                                                data-type = "update">
                                                                                <option value="">Select Code</option>
                                                                                @foreach ($short_code as $key => $code)
                                                                                    <option value="{{ $key }}">
                                                                                        {{ $code }} </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group pt-2">
                                                                    <label>Status</label>
                                                                    <br>
                                                                    <select class="form-control" name="status"
                                                                        id="editstatus" required>
                                                                        <option value="">Select Status</option>
                                                                        <option value="0"> Active </option>
                                                                        <option value="1"> Deactive </option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group pt-2">
                                                                    <label>Sortcode For Variables</label>
                                                                    <br>
                                                                    {{ '{' . implode('} ,{', $short_code) . '}' }}
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancel</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Update</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- Edit Model end --}}
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
        $(".summernote-usage").summernote({
            height: 200,
        });

        $(document).ready(function() {
            $('#datatable').DataTable();
        });

        $(document).ready(function() {
            $('#type').select2();
        });

        $(document).ready(function() {
            $('#categories').select2();
        });

        $(document).ready(function() {
            $('#categories2').select2();
        });
    </script>
    <script>
        $('#editSMSModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var title = button.data('title');
            var id = button.data('id');
            var type = button.data('type');
            var modal = $(this);
            modal.find('.modal-body #title').val(title);
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #type').val(type);
        });

        $('#deleteSMSModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
        });

        const textarea1 = document.querySelector('.text1')
        const count = document.getElementById('count')
        textarea1.onkeyup = (e) => {
            count.innerHTML = "Characters: " + e.target.value.length + "/160";
        };

        const textarea2 = document.querySelector('.text2')
        const count2 = document.getElementById('count2')
        textarea2.onkeyup = (e) => {
            count2.innerHTML = "Characters: " + e.target.value.length + "/160";
        };

        // const textarea11 = document.querySelector('.text11')
        // const count11 = document.getElementById('count11')
        // textarea11.onkeyup = (e) => {
        //     count11.innerHTML = "Characters: "+e.target.value.length+"/160";
        // };
        const textarea111 = document.querySelector('.text111')
        const count111 = document.getElementById('count111')
        textarea111.onkeyup = (e) => {
            count111.innerHTML = "Characters: " + e.target.value.length + "/160";
        };
        const textarea112 = document.querySelector('.text112')
        const count112 = document.getElementById('count112')
        textarea112.onkeyup = (e) => {
            count112.innerHTML = "Characters: " + e.target.value.length + "/160";
        };
    </script>

    <script>
        $('#editScriptModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var name = button.data('name');
            var script = button.data('body');
            var id = button.data('id');
            var modal = $(this);
            $('#name_edit').val(name);

            $('#body_email').summernote('code', script);

            $('#id').val(id);

        });
        $('#deleteScriptModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
        });
    </script>

    <script>
        function autofill(elem, obj) {
            var params = JSON.parse(obj);
            $('#editrecid').val(params.id);
            $('#edittemplate_name').val(params.template_name);
            $('#editcontent').html(elem.data('html'));
            CKEDITOR.instances.editcontent.setData(elem.data('html'));
            $('#editstatus').val(params.status);

        }

        $('#deleteDigitalModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
        });
        $('.insert_code').on('change', function() {
            if ($(this).val() != '') {

                if ($(this).attr('data-type') == 'add') {
                    var text_area_value = CKEDITOR.instances.addcontent.getData();
                    text_area_value += ' {' + $(this).val() + '}';
                    $(this).closest("form").find("#addcontent").html(text_area_value);
                    CKEDITOR.instances.addcontent.setData(text_area_value);
                } else {
                    var text_area_value = CKEDITOR.instances.editcontent.getData();
                    text_area_value += ' {' + $(this).val() + '}';
                    $(this).closest("form").find("#editcontent").html(text_area_value);
                    CKEDITOR.instances.editcontent.setData(text_area_value);
                }



                $(this).val('');
            }
        });
    </script>
    <script></script>
    <!-- Sachin 08-09-2023 -->

    <script src="{{ asset('back/assets/ckeditor/ckeditor.js') }}"></script>
@endsection
