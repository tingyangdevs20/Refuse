@extends('back.inc.master')
@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" /> <script
    src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> <script
    src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js">
</script>
<style> /* Ensure the table takes the full width of its container */ .table-responsive { overflow-x: auto; } /* Add
    horizontal scrolling for the table on smaller screens */ /* .table { white-space: nowrap; } */ /* Add responsive
    breakpoints and adjust table font size and padding as needed */ @media (max-width: 768px) { .table { font-size:
    12px; } } .checkbox label .toggle, .checkbox-inline .toggle { margin-left: -20px; margin-right: 5px } .toggle {
    position: relative; overflow: hidden } .toggle input[type=checkbox] { display: none } .toggle-group { position:
    absolute; width: 200%; top: 0; bottom: 0; left: 0; transition: left .35s; -webkit-transition: left .35s;
    -moz-user-select: none; -webkit-user-select: none } .toggle.off .toggle-group { left: -100% } .toggle-on { position:
    absolute; top: 0; bottom: 0; left: 0; right: 50%; margin: 0; border: 0; border-radius: 0 } .toggle-off { position:
    absolute; top: 0; bottom: 0; left: 50%; right: 0; margin: 0; border: 0; border-radius: 0 } .toggle-handle {
    position: relative; margin: 0 auto; padding-top: 0; padding-bottom: 0; height: 100%; width: 0; border-width: 0 1px }
    .toggle.btn { min-width: 100px; min-height: 34px } .toggle-on.btn { padding-right: 24px } .toggle-off.btn {
    padding-left: 24px } .toggle.btn-lg { min-width: 79px; min-height: 45px } .toggle-on.btn-lg { padding-right: 31px }
    .toggle-off.btn-lg { padding-left: 31px } .toggle-handle.btn-lg { width: 40px } .toggle.btn-sm { min-width: 50px;
    min-height: 30px } .toggle-on.btn-sm { padding-right: 20px } .toggle-off.btn-sm { padding-left: 20px }
    .toggle.btn-xs { min-width: 35px; min-height: 22px } .toggle-on.btn-xs { padding-right: 12px } .toggle-off.btn-xs {
    padding-left: 12px } #exTab2 h3 { color: white; background-color: #428bca; padding: 5px 15px; } .nav-tabs .nav-item
    .nav-link.active { background-color: #38B6FF; /* Change to your preferred button color */ color: #fff; /* Text color
    for the active tab */ border-color: #38B6FF; /* Border color for the active tab */ border-radius: 5px; /* Optional:
    Add rounded corners */ /* padding: 13px; */ } /* Add other CSS styles for the non-active tab links as needed */
    .nav-tabs .nav-item .nav-link { /* Default text color for non-active tabs */ /* border-color: #38B6FF; */ } </style>

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
                        <h4 class="mb-0 font-size-18">3rd Party APIs</h4>

                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            <i class="fas fa-cog mr-1"></i>All APIs Settings
                            @include('components.modalform')
                        </div>
                    </div>


                    <!-- CONTENT SECTION DIV -->
                    <div class="card">
                        <!-- TABS HEADINGS SECTION -->
                        <div class="card-header  bg-soft-dark">
                            <div class="nav-tabs-wrapper">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item m-1">
                                        <a class="nav-link active" href="#GoogleCalendar" data-toggle="tab">Google
                                            Calendar</a>
                                    </li>
                                    <li class="nav-item m-1"><a class="nav-link" href="#SendGrid"
                                            data-toggle="tab">SendGrid</a>
                                    </li>
                                    <li class="nav-item m-1"><a class="nav-link" href="#Twilio"
                                            data-toggle="tab">Twilio</a>
                                    </li>
                                    <li class="nav-item m-1"><a class="nav-link" href="#Slybroadcast"
                                            data-toggle="tab">Slybroadcast</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- TABS HEADINGS SECTION ENDS -->
                        <!-- TABS CONTENT SECTION -->
                        <div class="card-body">
                            <div class="tab-content clearfix">
                                <!-- TAB 1 CONTENT -->
                                <div class="tab-pane active" id="GoogleCalendar">
                                    <div class="card">
                                        <div class="card-header bg-soft-dark ">
                                            <i class="fas fa-cog mr-1"></i>Google Calendar

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
                                                            <div class="input-group-text"><i class="fas fa-key"></i>
                                                            </div>
                                                        </div>
                                                        <input type="text" class="form-control"
                                                            placeholder="Google calendar ID" name="calendar_id"
                                                            id="calendar_id" value="{{ $accounts->calendar_id }}"
                                                            required>
                                                    </div>
                                                </div>

                                                <input type="hidden" name="calendar_credentials_path"
                                                    value="{{ $accounts->calendar_credentials_path }}">

                                                <div class="form-group">
                                                    <label>Calendar Status</label>
                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text"><i class="fas fa-check"></i>
                                                            </div>
                                                        </div>
                                                        <select class="input form-control" name="calendar_enable"
                                                            required>
                                                            <option value="Y" {{ $accounts->calendar_enable === 'Y' ?
                                                                'selected' : '' }}>
                                                                Enable</option>
                                                            <option value="N" {{ $accounts->calendar_enable === 'N' ?
                                                                'selected' : '' }}>
                                                                Disable</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label>Calendar Credentials File <small>(if you don't want to update
                                                            your
                                                            credentials leave it blank)</small></label>
                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text"><i class="fas fa-lock"></i>
                                                            </div>
                                                        </div>
                                                        <input type="file" class="form-control"
                                                            accept="application/json" name="calendar_credentials_file"
                                                            id="credentials">
                                                    </div>
                                                </div>

                                                <button type="submit" class="btn btn-primary"
                                                    style="background-color:#38B6FF;border-color:#38B6FF">Update
                                                    Settings</button>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- TAB 1 CONTENT ENDS -->

                                <!-- TAB 2 CONTENT -->
                                <div class="tab-pane" id="SendGrid">
                                    <div class="card">
                                        <div class="card-header bg-soft-dark ">
                                            <i class="fas fa-cog mr-1"></i>SendGrid

                                        </div>

                                        <div class="card-body">
                                            <form action="{{ route('admin.settings.update', $settings) }}" method="post"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')

                                                <div class="form-group">
                                                    <label>Send From Email (Send Grid)</label>
                                                    <div class="input-group mb-2">

                                                        <input type="text" class="form-control"
                                                            placeholder="Send From Email" name="sender_email"
                                                            id="sender_email" value="{{ $settings->sender_email }}"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>From Name (Send Grid)</label>
                                                    <div class="input-group mb-2">

                                                        <input type="text" class="form-control"
                                                            placeholder="Send From Name" name="sender_name"
                                                            id="sender_name" value="{{ $settings->sender_name }}"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Send Grid API Key</label>
                                                    <div class="input-group mb-2">


                                                        <input type="text" class="form-control"
                                                            placeholder="Enter Send Grid API Key" name="sendgrid_key"
                                                            name="sendgrid_key" value="{{ $settings->sendgrid_key }}"
                                                            required>
                                                    </div>
                                                </div>





                                                <button type="submit" class="btn btn-primary"
                                                    style="background-color:#38B6FF;border-color:#38B6FF">Update
                                                    Settings</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- TAB 2 CONTENT ENDS -->
                                <!-- TAB 3 CONTENT -->
                                <div class="tab-pane" id="Twilio">
                                    <div class="card">
                                        <div class="card-header bg-soft-dark ">
                                            <i class="fas fa-cog mr-1"></i>Twilio

                                        </div>

                                        <div class="card-body">
                                            <form action="{{ route('admin.settings.update', $settings) }}" method="post"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group">
                                    <label>Twilio Account SID</label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" placeholder="Enter Twilio Account SID"
                                            name="twilio_acc_sid" id="twilio_acc_sid"
                                            value="{{ $settings->twilio_acc_sid }}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Twilio API SID</label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" placeholder="Enter Twilio API SID"
                                            name="twilio_api_sid" id="twilio_api_sid"
                                            value="{{ $settings->twilio_api_sid }}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Twilio Auth Token</label>
                                    <div class="input-group mb-2">

                                        <input type="text" class="form-control" placeholder="Enter Twilio Auth Token"
                                            name="twilio_auth_token" id="twilio_auth_token"
                                            value="{{ $settings->twilio_auth_token }}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Twilio Secret Key</label>
                                    <div class="input-group mb-2">

                                        <input type="text" class="form-control" placeholder="Enter Twilio Secret Key"
                                            name="twilio_secret_key" id="twilio_secret_key"
                                            value="{{ $settings->twilio_secret_key }}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Twilio Twiml SID</label>
                                    <div class="input-group mb-2">

                                        <input type="text" class="form-control" placeholder="Enter Twilio Twiml SID"
                                            name="twiml_app_sid" id="twiml_app_sid"
                                            value="{{ $settings->twiml_app_sid }}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Twilio Messaging SID</label>
                                    <div class="input-group mb-2">

                                        <input type="text" class="form-control" placeholder="Enter Twilio Messaging SID"
                                            name="messaging_service_sid" id="messaging_service_sid"
                                            value="{{ $settings->messaging_service_sid }}" required>
                                    </div>
                                </div>




                                                <button type="submit" class="btn btn-primary"
                                                    style="background-color:#38B6FF;border-color:#38B6FF">Update
                                                    Settings</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- TAB 3 CONTENT ENDS -->
                                <!-- TAB 4 CONTENT -->
                                <div class="tab-pane" id="Slybroadcast">
                                    <div class="card">
                                        <div class="card-header bg-soft-dark ">
                                            <i class="fas fa-cog mr-1"></i>Slybroadcast

                                        </div>

                                        <div class="card-body">
                                            <form action="{{ route('admin.settings.update', $settings) }}" method="post"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group">
                                    <label>Username</label>
                                    <div class="input-group mb-2">

                                        <input type="text" class="form-control" placeholder="Enter Username"
                                            name="slybroad_username" id="slybroad_username"
                                            value="{{ $settings->slybroad_username }}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <div class="input-group mb-2">

                                        <input type="password" class="form-control" placeholder="Enter Password"
                                            name="slybroad_pass" id="slybroad_pass"
                                            value="{{ $settings->slybroad_pass }}" required>
                                    </div>
                                </div>

                                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <div class="input-group mb-2">

                                        <input type="text" class="form-control" placeholder="Enter Phone Number"
                                            name="slybroad_call_url" id="slybroad_call_url"
                                            value="{{ $settings->slybroad_number }}" required>
                                    </div>
                                </div>



                                                <button type="submit" class="btn btn-primary"
                                                    style="background-color:#38B6FF;border-color:#38B6FF">Update
                                                    Settings</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- TAB 4 CONTENT ENDS -->













                            </div>
                        </div>












                        <!-- TABS CONTENT SECTION ENDS -->
                    </div>
                    <!-- CONTENT SECTION DIV ENDS -->






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
    <script></script>
    @endsection