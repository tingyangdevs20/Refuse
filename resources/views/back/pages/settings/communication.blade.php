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
                            <i class="fas fa-cog"></i> Communication Settings
                            <button class="btn btn-outline-primary btn-sm float-right mr-2" title="helpModal"
                                data-toggle="modal" data-target="#helpModal">How to Use</button>
                            @include('components.modalform')


                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header  bg-soft-dark  ">
                            <ul class="nav nav-tabs">
                                <li class="active mr-3">
                                    <a href="#AutoRespond" data-toggle="tab"> Auto Responder</a>
                                </li>
                                <li><a class="mr-3" href="#AutoReply" data-toggle="tab">AutoReply</a>
                                </li>
                                <li><a class="mr-3" href="#CallForward" data-toggle="tab">Call Forward Number</a>
                                </li>
                                <li><a class="mr-3" href="#PhoneNumber" data-toggle="tab">Phone Number</a>
                                </li>
                                <li><a class="mr-3"href="#markets" data-toggle="tab">Markets</a>
                                </li>
                                <li><a class="mr-3"href="#Rvms" data-toggle="tab">RVMs</a>
                                </li>
                                <li><a class="mr-3" href="#QuickResponse" data-toggle="tab">Quick Response</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content clearfix">
                                <div class="tab-pane active" id="AutoRespond">
                                    <div class="card">
                                        <div class="card-header bg-soft-dark ">
                                            <i class="fas fa-cog"></i> Auto Respond
                                            <button class="btn btn-outline-primary btn-sm float-right" title="New"
                                                data-toggle="modal" data-target="#newModalAutoRespond"><i
                                                    class="fas fa-plus-circle"></i></button>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-striped table-bordered" id="datatable">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Keyword</th>
                                                        <th scope="col">Response</th>
                                                        <th scope="col">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($responders as $respond)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $respond->keyword }}</td>
                                                            <td>{{ $respond->response }}</td>
                                                            <td>
                                                                <button class="btn btn-outline-primary btn-sm"
                                                                    title="Edit {{ $respond->keyword }}"
                                                                    data-keyword="{{ $respond->keyword }}"
                                                                    data-response="{{ $respond->response }}"
                                                                    data-id={{ $respond->id }} data-toggle="modal"
                                                                    data-target="#editModalAutoRespond"><i
                                                                        class="fas fa-edit"></i></button> -
                                                                <button class="btn btn-outline-danger btn-sm"
                                                                    title="Remove {{ $respond->keyword }}"
                                                                    data-id="{{ $respond->id }}" data-toggle="modal"
                                                                    data-target="#deleteModalAutoRespond"><i
                                                                        class="fas fa-times-circle"></i></button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="AutoReply">
                                    <div class="card">
                                        <div class="card-header bg-soft-dark ">
                                            <i class="fas fa-cog"></i> Auto Reply
                                            <button class="btn btn-outline-primary btn-sm float-right" title="New"
                                                data-toggle="modal" data-target="#newModalAutoReply"><i
                                                    class="fas fa-plus-circle"></i></button>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-striped table-bordered" id="datatable">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Category</th>
                                                        <th scope="col">Message</th>
                                                        <th scope="col">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($autoReplies as $autoreply)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $autoreply->category->name }}</td>
                                                            <td>{{ $autoreply->message }}</td>
                                                            <td>
                                                                <button class="btn btn-outline-primary btn-sm"
                                                                    title="Edit" data-message="{{ $autoreply->message }}"
                                                                    data-id={{ $autoreply->id }} data-toggle="modal"
                                                                    data-target="#editModalAutoReply"><i
                                                                        class="fas fa-edit"></i></button>

                                                                @if ($autoreply->category_id > 1)
                                                                    -
                                                                    <button class="btn btn-outline-danger btn-sm"
                                                                        title="Remove" data-id="{{ $autoreply->id }}"
                                                                        data-toggle="modal"
                                                                        data-target="#deleteModalAutoReply"><i
                                                                            class="fas fa-times-circle"></i></button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="PhoneNumber">
                                    <div class="card">
                                        <div class="card-header bg-soft-dark ">
                                            <i class="fas fa-cog"></i> Active Twilio Phone Numbers
                                        </div>
                                        <div class="card-body">
                                            @if ($all_phone_nums->isEmpty())
                                                <p>No Active Twilio Phone Numbers.</p>
                                            @else
                                                <table class="table table-striped table-bordered" id="datatable">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Phone Number</th>
                                                            <th scope="col">Capabilities</th>
                                                            <th scope="col">A2P Compliance</th>
                                                            <th scope="col">Phone Number type</th>
                                                            <th scope="col">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $count = 1;
                                                        @endphp
                                                        @foreach ($all_phone_nums as $p_num)
                                                            <tr>
                                                                <td>{{ $p_num->number }}</td>
                                                                <td>{{ $p_num->capabilities }}</td>
                                                                <td>{{ $p_num->a2p_compliance == 1 ? 'true' : 'false' }}
                                                                </td>

                                                                <td>
                                                                    <input style="width: 100%;" type="checkbox"
                                                                        data-id="{{ $p_num->id }}"
                                                                        class="toggle-phone-system" data-toggle="toggle"
                                                                        data-onstyle="success" data-offstyle="warning"
                                                                        {{ $p_num->system_number ? 'checked' : '' }}
                                                                        data-on="System Number"
                                                                        data-off="Marketing Number">
                                                                </td>
                                                                <td>
                                                                    <input data-id="{{ $p_num->id }}"
                                                                        class="toggle-class" type="checkbox"
                                                                        data-onstyle="success" data-offstyle="danger"
                                                                        data-toggle="toggle" data-on="Active"
                                                                        data-off="InActive"
                                                                        {{ $p_num->is_active ? 'checked' : '' }}>
                                                                </td>
                                                            </tr>
                                                            @php
                                                                $count++;
                                                            @endphp
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="CallForward">
                                    <div class="card">
                                        <div class="card-header bg-soft-dark ">
                                            <i class="fas fa-cog"></i> Call Forward Number
                                        </div>
                                        <div class="card-body">
                                           
                                                <table class="table table-striped table-bordered" id="datatable">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Number</th>
                                                            <th scope="col">Action</th>
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                       
                                                       
                                                            <tr>
                                                                <td>{{ $Settings->call_forward_number }}</td>
                                                                <td>
                                                                <button class="btn btn-outline-primary btn-sm"
                                                                    title="Edit {{ $Settings->call_forward_number }}"
                                                                    data-name="{{ $Settings->call_forward_number }}"
                                                                    data-id="{{ $Settings->id }}" data-toggle="modal"
                                                                    data-target="#editModalCallForward"><i
                                                                        class="fas fa-edit"></i></button>
                                                                -
                                                                <button class="btn btn-outline-danger btn-sm"
                                                                    title="Remove {{ $Settings->call_forward_number }}"
                                                                    data-id="{{ $Settings->id }}" data-toggle="modal"
                                                                    data-target="#deleteModalCallForward"><i
                                                                        class="fas fa-times-circle"></i></button>
                                                            </td>

                                                               
                                                               
                                                            </tr>
                                                           
                                                    </tbody>
                                                </table>
                                           
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="tab-pane" id="markets">
                                    <div class="card">
                                        <div class="card-header bg-soft-dark ">
                                            <i class="fas fa-cog"></i> Markets
                                            <button class="btn btn-outline-primary btn-sm float-right " title="New"
                                                data-toggle="modal" data-target="#newModalmarkets"><i
                                                    class="fas fa-plus-circle"></i></button>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-striped table-bordered" id="datatable">
                                                <thead>
                                                    <tr>

                                                        <th scope="col">Name</th>
                                                        <th scope="col">Associated Numbers</th>
                                                        <th scope="col">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($markets as $market)
                                                        <tr>

                                                            <td>{{ $market->name }}</td>
                                                            @if ($market->numbers()->get()->isEmpty())
                                                                <td>None</td>
                                                            @else
                                                                <td>
                                                                    @foreach ($market->numbers()->get() as $number)
                                                                        {{ $market->numbers()->get()->count() == 1? $number->number: $number->number . ', ' }}
                                                                    @endforeach
                                                                </td>
                                                            @endif
                                                            <td>
                                                                <button class="btn btn-outline-primary btn-sm"
                                                                    title="Edit {{ $market->name }}"
                                                                    data-name="{{ $market->name }}"
                                                                    data-id={{ $market->id }} data-toggle="modal"
                                                                    data-target="#editModalmarkets"><i
                                                                        class="fas fa-edit"></i></button>
                                                                -
                                                                <button class="btn btn-outline-danger btn-sm"
                                                                    title="Remove {{ $market->name }}"
                                                                    data-id="{{ $market->id }}" data-toggle="modal"
                                                                    data-target="#deleteModalmarkets"><i
                                                                        class="fas fa-times-circle"></i></button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="Rvms">
                                    <div class="card">
                                        <div class="card-header bg-soft-dark ">
                                            <i class="fas fa-cog"></i> RVMS
                                            <button class="btn btn-outline-primary btn-sm float-right" title="New"
                                                data-toggle="modal" data-target="#newModalrvms   "><i
                                                    class="fas fa-plus-circle"></i></button>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-striped table-bordered" id="datatable">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Media Url</th>
                                                        <th scope="col">Actions</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($rvms as $rvm)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $rvm->name }}</td>
                                                            <td>{{ $rvm->mediaUrl }}</td>
                                                            <td>
                                                                <button class="btn btn-outline-primary btn-sm"
                                                                    title="Edit {{ $rvm->name }}"
                                                                    data-id="{{ $rvm->id }}"
                                                                    data-rvmname="{{ $rvm->name }}"
                                                                    data-toggle="modal" data-target="#editModalrvms"><i
                                                                        class="fas fa-edit"></i></button>
                                                                @if ($rvm->id > 1)
                                                                    -
                                                                    <button class="btn btn-outline-danger btn-sm"
                                                                        title="Remove {{ $rvm->name }}"
                                                                        data-rvmid="{{ $rvm->id }}"
                                                                        data-toggle="modal"
                                                                        data-target="#deleteModalrvms"><i
                                                                            class="fas fa-times-circle"></i></button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="QuickResponse">
                                    <div class="card">
                                        <div class="card-header bg-soft-dark ">
                                            All Responses
                                            <button class="btn btn-outline-primary btn-sm float-right" title="New"
                                                data-toggle="modal" data-target="#newModalquickresponse"><i
                                                    class="fas fa-plus-circle"></i></button>

                                        </div>
                                        <div class="card-body">
                                            <table class="table table-striped table-bordered" id="datatable">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Title</th>
                                                        <th scope="col">Message</th>
                                                        <th scope="col">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($quickResponses as $quickResponse)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $quickResponse->title }}</td>
                                                            <td>{{ $quickResponse->body }}</td>
                                                            <td>
                                                                <button class="btn btn-outline-primary btn-sm"
                                                                    title="Edit {{ $quickResponse->title }}"
                                                                    data-title="{{ $quickResponse->title }}"
                                                                    data-body="{{ $quickResponse->body }}"
                                                                    data-id={{ $quickResponse->id }} data-toggle="modal"
                                                                    data-target="#editModalquickresponse"><i
                                                                        class="fas fa-edit"></i></button>
                                                                -
                                                                <button class="btn btn-outline-danger btn-sm"
                                                                    title="Remove {{ $quickResponse->title }}"
                                                                    data-id="{{ $quickResponse->id }}"
                                                                    data-toggle="modal"
                                                                    data-target="#deleteModalquickresponse"><i
                                                                        class="fas fa-times-circle"></i></button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            {{-- Modals Auto Respond --}}
            {{-- Modal New --}}
            <div class="modal fade" id="newModalAutoRespond" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">New Respond</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.auto-responder.store') }}" method="POST">
                            <div class="modal-body">
                                @csrf
                                @method('POST')
                                <div class="form-group">
                                    <label>Keyword</label>
                                    <input type="text" class="form-control" name="keyword"
                                        placeholder="Enter Keyword" required>
                                </div>
                                <div class="form-group">
                                    <label>Response</label>
                                    <textarea class="form-control" name="response" rows="5" required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- End Modal New --}}

            {{-- Modal Edit --}}
            <div class="modal fade" id="editModalAutoRespond" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Response</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.auto-responder.update', 'test') }}" method="post" id="editForm">
                            @method('PUT')
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Keyword</label>
                                    <input type="hidden" id="id" name="id" value="">
                                    <input type="text" class="form-control" name="keyword" id="keyword" required>
                                </div>
                                <div class="form-group">
                                    <label>Response</label>
                                    <textarea class="form-control" name="response" id="response" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Edit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- End Modal Edit --}}
            {{-- Modal Delete --}}
            <div class="modal fade" id="deleteModalAutoRespond" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete Response</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.auto-responder.destroy', 'test') }}" method="post"
                            id="editForm">
                            @method('DELETE')
                            @csrf
                            <div class="modal-body">
                                <div class="modal-body">
                                    <p class="text-center">
                                        Are you sure you want to delete this?
                                    </p>
                                    <input type="hidden" id="id" name="id" value="">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- End Modal Delete --}}

            {{-- End Modals Auto Respond --}}


            <!-- Model Auto Reply -->
            {{-- Modal New --}}
            <div class="modal fade" id="newModalAutoReply" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">New Auto Reply</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.auto-reply.store') }}" method="POST">
                            <div class="modal-body">
                                @csrf
                                @method('POST')
                                <div class="form-group">
                                    <label>Message</label>
                                    <textarea class="form-control text1" name="message" rows="5" required></textarea>
                                    <div id='count' class="float-lg-right"></div>
                                </div>
                                <div class="form-group pt-2">
                                    <label>Category</label><br>
                                    <select class="from-control" style="width: 100%;" id="categories" name="category_id"
                                        required>
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="active">Active Status</label>
                                    <select name="is_active" id="is_active" class="form-control" required>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- End Modal New --}}

            {{-- Modal Edit --}}
            <div class="modal fade" id="editModalAutoReply" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Auto Reply</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.auto-reply.update', 'test') }}" method="post" id="editForm">
                            @method('PUT')
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <input type="hidden" id="id" name="id" value="">
                                    <label>Message</label>
                                    <textarea class="form-control text2" name="message" id="message" rows="5"></textarea>
                                    <div id='count2' class="float-lg-right"></div>
                                </div>
                                <div class="form-group pt-2">
                                    <label>Category</label><br>
                                    <select class="from-control" style="width: 100%;" id="categories2"
                                        name="category_id" required>
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="active">Active Status</label>
                                    <select name="is_active" id="is_active2" class="form-control" required>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Edit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- End Modal Edit --}}
            {{-- Modal Delete --}}
            <div class="modal fade" id="deleteModalAutoReply" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete Auto Reply</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.auto-reply.destroy', 'test') }}" method="post" id="editForm">
                            @method('DELETE')
                            @csrf
                            <div class="modal-body">
                                <div class="modal-body">
                                    <p class="text-center">
                                        Are you sure you want to delete this?
                                    </p>
                                    <input type="hidden" id="id" name="id" value="">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- End Modal Delete --}}


            <!-- Model Auto Reply End -->


            {{-- Modals --}}
            {{-- Modal New --}}
            <div class="modal fade" id="newModalmarkets" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">New Market</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.market.store') }}" method="POST">
                            <div class="modal-body">
                                @csrf
                                @method('POST')
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name"
                                        placeholder="Enter Market Name" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- End Modal New --}}

            {{-- Modal Edit --}}
            <div class="modal fade" id="editModalmarkets" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Market</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.market.update', 'test') }}" method="post" id="editForm">
                            @method('PUT')
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="hidden" id="id" name="id" value="">
                                    <input type="text" class="form-control" name="name" id="name" required>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Edit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- End Modal Edit --}}
            {{-- Modal Delete --}}
            <div class="modal fade" id="deleteModalmarkets" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete Market</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.market.destroy', 'test') }}" method="post" id="editForm">
                            @method('DELETE')
                            @csrf
                            <div class="modal-body">
                                <div class="modal-body">
                                    <p class="text-center">
                                        Are you sure you want to delete this?
                                    </p>
                                    <input type="hidden" id="id" name="id" value="">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- End Modal Delete --}}
            {{-- Modal Edit --}}
            <div class="modal fade" id="editModalCallForward" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Call Forward Number</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.market.update', 'test') }}" method="post" id="editForm">
                            @method('PUT')
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="hidden" id="id" name="id" value="">
                                    <input type="text" class="form-control" name="phone" id="phone" required>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Edit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- End Modal Edit --}}
            {{-- Modal Delete --}}
            <div class="modal fade" id="deleteModalCallFroward" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete Call Forward Number</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.market.destroy', 'test') }}" method="post" id="editForm">
                            @method('DELETE')
                            @csrf
                            <div class="modal-body">
                                <div class="modal-body">
                                    <p class="text-center">
                                        Are you sure you want to delete this?
                                    </p>
                                    <input type="hidden" id="id" name="id" value="">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- End Modal Delete --}}



            {{-- Modal New --}}
            <div class="modal fade" id="newModalrvms" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">New RVM</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form action="{{ route('admin.rvm.store') }}" method="POST" enctype="multipart/form-data" />

                        <div class="modal-body">
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Enter RVM Name"
                                    required>
                            </div>
                            <div class="form-group">
                                <label>Rvm</label>
                                <input type="file" class="form-control" name="mediaUrl" placeholder="Enter RVM Name"
                                    required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- End Modal New --}}
            {{-- Modal Edit --}}
            <div class="modal fade" id="editModalrvms" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit RVM</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.rvm.update', 'test') }}" method="post" id="editForm"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="hidden" id="id" name="id" value="">
                                    <input type="text" class="form-control" name="name" id="name">
                                </div>
                                <div class="form-group">
                                    <label>Rvm</label>
                                    <input type="hidden" id="id" name="id" value="">
                                    <input type="file" class="form-control" required name="mediaUrl" id="mediaUrl">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Edit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- End Modal Edit --}}
            {{-- Modal Delete --}}
            <div class="modal fade" id="deleteModalrvms" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete RVM</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.rvm.destroy', 'test') }}" method="post" id="editForm">
                            @method('DELETE')
                            @csrf
                            <div class="modal-body">
                                <div class="modal-body">
                                    <p class="text-center">
                                        Are you sure you want to delete this?
                                    </p>
                                    <input type="hidden" id="rvm_id" name="rvm_id" value="">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- End Modal Delete --}}
            {{-- Modal New --}}
            <div class="modal fade" id="newModalquickresponse" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">New Quick Response</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.quick-response.store') }}" method="POST">
                            <div class="modal-body">
                                @csrf
                                @method('POST')
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" class="form-control" name="title"
                                        placeholder="Enter Response Title" required>
                                </div>
                                <div class="form-group">
                                    <label>Message</label>
                                    <textarea class="form-control" name="body" rows="5" required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- End Modal New --}}

            {{-- Modal Edit --}}
            <div class="modal fade" id="editModalquickresponse" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Response</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.quick-response.update', 'test') }}" method="post" id="editForm">
                            @method('PUT')
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="hidden" id="id" name="id" value="">
                                    <input type="text" class="form-control" name="title" id="title" required>
                                </div>
                                <div class="form-group">
                                    <label>Body</label>
                                    <textarea class="form-control" name="body" id="body" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- End Modal Edit --}}
            {{-- Modal Delete --}}
            <div class="modal fade" id="deleteModalquickresponse" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete Response</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.quick-response.destroy', 'test') }}" method="post"
                            id="editForm">
                            @method('DELETE')
                            @csrf
                            <div class="modal-body">
                                <div class="modal-body">
                                    <p class="text-center">
                                        Are you sure you want to delete this?
                                    </p>
                                    <input type="hidden" id="id" name="id" value="">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- End Modal Delete --}}
        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
@endsection
@section('scripts')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();
        });
        $('#editModalAutoRespond').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var keyword = button.data('keyword');
            var response = button.data('response');
            var id = button.data('id');

            var modal = $(this);

            modal.find('.modal-body #keyword').val(keyword);
            modal.find('.modal-body #response').val(response);
            modal.find('.modal-body #id').val(id);

        });
        $('#deleteModalAutoRespond').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
        });
        $('#editModalAutoReply').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var message = button.data('message');
            var id = button.data('id');
            var is_active = button.data('is_active');

            var modal = $(this);

            modal.find('.modal-body #message').val(message);
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #is_active2').val(is_active).trigger('change');;
        });
        $('#deleteModalAutoReply').on('show.bs.modal', function(event) {
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
        $('#editModalmarkets').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var name = button.data('name');
            var id = button.data('id');

            var modal = $(this);

            modal.find('.modal-body #name').val(name);
            modal.find('.modal-body #id').val(id);

        });
        $('#editModalCallForward').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var phone = button.data('phone');
            
            var id = button.data('id');

            var modal = $(this);

            modal.find('.modal-body #phone').val(phone);
            modal.find('.modal-body #id').val(id);

        });
        $('#deleteModalCallForward').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
        });
        $('#deleteModalmarkets').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
        });
        $('#editModalrvms').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var id = button.data('id');
            var rvmname = button.data('rvmname');
            var modal = $(this);

            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #rvm_name').val(rvmname);
        });
        $('#deleteModalrvms').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var rvmid = button.data('rvmid');
            var modal = $(this);
            modal.find('.modal-body #rvm_id').val(rvmid);
        });
        $('#editModalquickresponse').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var title = button.data('title');
            var body = button.data('body');
            var id = button.data('id');

            var modal = $(this);

            modal.find('.modal-body #title').val(title);
            modal.find('.modal-body #body').val(body);
            modal.find('.modal-body #id').val(id);

        });
        $('#deleteModalquickresponse').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
        });
        // $('.toggle-class').change(function() {
        //         var status = $(this).prop('checked') == true ? 1 : 0;
        //         var phn_id = $(this).data('id');
        //         let data = {
        //             phn_id: phn_id,
        //             sts: status,

        //         }
        //         axios.post('phone/changeStatus', data)
        //             .then(response => {
        //                 if (response.data.status == 200) {
        //                     alert("updated");
        //                 }
        //             })
        //     })
        //     .catch(error => console.log(error));


        $('.toggle-phone-system').on('change', function() {
            var numberId = $(this).data('id');
            var isPhoneSystem = $(this).prop('checked') ? 1 : 0;

            $.ajax({
                type: 'PUT',
                url: '/admin/communication-setting-update', // Update with your route URL
                data: {
                    numberId: numberId,
                    isPhoneSystem: isPhoneSystem,
                    isStatus: false
                },
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token
                },
                success: function(response) {
                    if (response.status === 200) {
                        // alert("Updated successfully");
                    } else {
                        console.log(response);
                    }
                },
                error: function(error) {
                    console.log(error);
                    alert("Error occurred during the update.");
                }
            });
        });


        $('.toggle-class').on('change', function() {
            var numberId = $(this).data('id');
            var isActive = $(this).prop('checked') ? 1 : 0;

            $.ajax({
                type: 'PUT', // or 'GET' based on your requirements
                url: '/admin/communication-setting-update',
                data: {
                    _token: '{{ csrf_token() }}',
                    numberId: numberId,
                    isActive: isActive,
                    isStatus: true
                },
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token
                },
                success: function(response) {
                    if (response.status === 200) {
                        // alert("Updated successfully");
                    } else {
                        console.log(response);
                    }
                },
                error: function(error) {
                    console.log(error);
                    alert("Error occurred during the update.");
                }
            });
        });
    </script>
@endsection
