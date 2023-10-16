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
                        <h4 class="mb-0 font-size-18">API Settings</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item">Settings</li>
                            </ol>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            <i class="fas fa-cog mr-1"></i>All APIs Settings
                            @include('components.modalform')
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.settings.update', $settings) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <!-- <div class="form-group"> -->
                                <!-- <label>Auto-Reply</label> -->
                                <select hidden class="custom-select" name="auto_reply" required>
                                    <option value="1" {{ $settings->auto_reply ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $settings->auto_reply ? '' : 'selected' }}>Not Active</option>
                                </select>
                                <!-- </div> -->
                                <!-- <div class="form-group"> -->
                                <!-- <label>Auto Keyword Responder</label> -->
                                <select hidden class="custom-select" name="auto_respond" required>
                                    <option value="1" {{ $settings->auto_responder ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $settings->auto_responder ? '' : 'selected' }}>Not Active
                                    </option>
                                </select>
                                <!-- </div> -->


                                <input type="hidden" class="form-control" placeholder="Auth. Name" name="auth_email"
                                    id="auth_email" value="{{ $settings->auth_email }}" required>


                                <input type="hidden" class="form-control" placeholder="Document Closed By"
                                    name="document_closed_by" id="document_closed_by"
                                    value="{{ $settings->document_closed_by }}" required>




                                <input type="hidden" class="form-control" placeholder="Reply To Email" name="reply_email"
                                    id="reply_email" value="{{ $settings->reply_email }}" required>


                                <div class="card-header bg-soft-dark ">
                                    <i class="fas fa-cog"></i> SendGrid API Settings

                                </div>
                                <br />
                                <div class="form-group">
                                    <label>Send From Email (Send Grid)</label>
                                    <div class="input-group mb-2">

                                        <input type="text" class="form-control" placeholder="Send From Email"
                                            name="sender_email" id="sender_email" value="{{ $settings->sender_email }}"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>From Name (Send Grid)</label>
                                    <div class="input-group mb-2">

                                        <input type="text" class="form-control" placeholder="Send From Name"
                                            name="sender_name" id="sender_name" value="{{ $settings->sender_name }}"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Send Grid API Key</label>
                                    <div class="input-group mb-2">


                                        <input type="text" class="form-control" placeholder="Enter Send Grid API Key"
                                            name="sendgrid_key" name="sendgrid_key" value="{{ $settings->sendgrid_key }}"
                                            required>
                                    </div>
                                </div>
                                <div class="card-header bg-soft-dark ">
                                    <i class="fas fa-cog"></i> Twilio API Settings

                                </div>
                                <br />
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




                                {{-- <div class="card-header bg-soft-dark ">
                                    <i class="fas fa-cog"></i> Google Drive Keys

                                </div>
                                <br />

                                <div class="form-group">
                                    <label>Google Drive Client Id</label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control"
                                            placeholder="Enter Google Drive Client Id" name="google_drive_client_id"
                                            id="google_drive_client_id" value="{{ $settings->google_drive_client_id }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Google Drive Client Secret </label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control"
                                            placeholder="Enter Google Drive Client Secret"
                                            name="google_drive_client_secret" id="google_drive_client_secret"
                                            value="{{ $settings->google_drive_client_secret }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Google Drive Developer Key </label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control"
                                            placeholder="Enter Google Drive Developer Key"
                                            name="google_drive_developer_key" id="google_drive_developer_key"
                                            value="{{ $settings->google_drive_developer_key }}">
                                    </div>
                                </div> --}}




                                <button type="submit" class="btn btn-primary">Update Settings</button>
                                <br />
                                <br />

                            </form>
                            <form>
                                <div class="card">
                                    <div class="card-header bg-soft-dark ">
                                        <i class="fas fa-cog"></i> Google Calendar Settings

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
                                                    <input type="text" class="form-control"
                                                        placeholder="Google calendar ID" name="calendar_id"
                                                        id="calendar_id" value="{{ $accounts->calendar_id }}" required>
                                                </div>
                                            </div>

                                            <input type="hidden" name="calendar_credentials_path"
                                                value="{{ $accounts->calendar_credentials_path }}">

                                            <div class="form-group">
                                                <label>Calendar Status</label>
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text"><i class="fas fa-check"></i></div>
                                                    </div>
                                                    <select class="input form-control" name="calendar_enable" required>
                                                        <option value="Y"
                                                            {{ $accounts->calendar_enable === 'Y' ? 'selected' : '' }}>
                                                            Enable</option>
                                                        <option value="N"
                                                            {{ $accounts->calendar_enable === 'N' ? 'selected' : '' }}>
                                                            Disable</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Calendar Credentials File <small>(if you don't want to update your
                                                        credentials leave it blank)</small></label>
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text"><i class="fas fa-lock"></i></div>
                                                    </div>
                                                    <input type="file" class="form-control" accept="application/json"
                                                        name="calendar_credentials_file" id="credentials">
                                                </div>
                                            </div>

                                            <button type="submit" class="btn btn-primary">Update Settings</button>

                                        </form>
                                    </div>
                                </div>
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
    <script></script>
@endsection
