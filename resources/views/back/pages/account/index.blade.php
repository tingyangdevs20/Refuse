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
                        <i class="fas fa-cog"></i> Control SMS Settings
                        <button class="btn btn-outline-primary btn-sm float-right mr-2" title="helpModal" data-toggle="modal"
                        data-target="#helpModal">Use this Section</button>  
                        @include('components.modalform')

                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.account.update',$accounts) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')


                            <div class="form-group">
                                <label>SMS Rate</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-dollar-sign"></i></div>
                                    </div>
                                    <input type="number" class="form-control" placeholder="Per SMS Rate" name="sms_rate"
                                        id="sms_rate" value="{{ $accounts->sms_rate }}" step="0.00001" min="0" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>MMS Rate</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-dollar-sign"></i></div>
                                    </div>
                                    <input type="number" class="form-control" placeholder="Per MMS Rate" name="mms_rate"
                                        id="mms_rate" value="{{ $accounts->mms_rate }}" step="0.00001" min="0" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Email Rate</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-dollar-sign"></i></div>
                                    </div>
                                    <input type="number" class="form-control" placeholder="Per SMS Rate" name="email_rate"
                                        id="email_rate" value="{{ $accounts->email_rate }}" step="0.00001" min="0" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>RVM Rate</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-dollar-sign"></i></div>
                                    </div>
                                    <input type="number" class="form-control" placeholder="Per SMS Rate" name="rvm_rate"
                                        id="rvm_rate" value="{{ $accounts->rvm_rate }}" step="0.00001" min="0" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>SMS Allowed Per Day</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-envelope"></i></div>
                                    </div>
                                    <input type="number" class="form-control" placeholder="Per SMS Rate"
                                        name="sms_allowed" id="sms_allowed" value="{{ $accounts->sms_allowed }}"
                                        step="1" min="1" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Phone Cell Append</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-dollar-sign"></i></div>
                                    </div>
                                    <input type="number" class="form-control" placeholder="Per Phone Cell Append Rate" name="phone_cell_append_rate"
                                        id="phone_cell_append_rate" value="{{ $accounts->phone_cell_append_rate }}" step="0.00001" min="0" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Email Append</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-dollar-sign"></i></div>
                                    </div>
                                    <input type="number" class="form-control" placeholder="Per Email Append Rate" name="email_append_rate"
                                        id="email_append_rate" value="{{ $accounts->email_append_rate }}" step="0.00001" min="0" required>
                                </div>
                            </div>


                            <div class="form-group">
                                <label>Name Append</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-dollar-sign"></i></div>
                                    </div>
                                    <input type="number" class="form-control" placeholder="Per Name Append Rate" name="name_append_rate"
                                        id="name_append_rate" value="{{ $accounts->name_append_rate }}" step="0.00001" min="0" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Email Verification </label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-dollar-sign"></i></div>
                                    </div>
                                    <input type="number" class="form-control" placeholder="Per Email Verification Rate" name="email_verification_rate"
                                        id="email_verification_rate" value="{{ $accounts->email_verification_rate }}" step="0.00001" min="0" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Phone Scrub </label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-dollar-sign"></i></div>
                                    </div>
                                    <input type="number" class="form-control" placeholder="Per Phone Scrub Rate" name="phone_scrub_rate"
                                        id="phone_scrub_rate" value="{{ $accounts->phone_scrub_rate }}" step="0.00001" min="0" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Scraping Charge Per Record </label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-dollar-sign"></i></div>
                                    </div>
                                    <input type="number" class="form-control" placeholder="Per Record Scraping Rate" name="scraping_charge_per_record"
                                        id="scraping_charge_per_record" value="{{ $accounts->scraping_charge_per_record }}" step="0.00001" min="0" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Settings</button>

                        </form>
                       
                    </div>
                </div>
                <div class="card">
                    <div class="card-header bg-soft-dark ">
                        <i class="fas fa-cog"></i> API Settings
                      
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
 

                           

                                    <input type="hidden" class="form-control" placeholder="Reply To Email"
                                        name="reply_email" id="reply_email" value="{{ $settings->reply_email }}"
                                        required>
                               

                            <div class="card-header bg-soft-dark ">
                                <i class="fas fa-cog"></i> Third Party APIs Settings

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
                                        name="sender_name" id="sender_name" value="{{ $settings->sender_name}}"
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

                            <div class="form-group">
                                <label>Twilio Account SID</label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" placeholder="Enter Twilio Account SID"
                                        name="twilio_api_key" id="twilio_api_key"
                                        value="{{ $settings->twilio_api_key }}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Twilio Auth Token</label>
                                <div class="input-group mb-2">

                                    <input type="text" class="form-control" placeholder="Enter Twilio Auth Token"
                                        name="twilio_secret" id="twilio_secret"
                                        value="{{ $settings->twilio_acc_secret }}" required>
                                </div>
                            </div>
                            <div class="card-header bg-soft-dark ">
                                <i class="fas fa-cog"></i> Slybroadcast Settings

                            </div>
                            <br />

                            <div class="form-group">
                                <label>Post Call URL</label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" placeholder="Enter new key to update"
                                        name="slybroad_call_url" name="slybroad_call_url"
                                        value="{{ $settings->slybroad_call_url }}" required>
                                </div>
                            </div>

                            <div class="card-header bg-soft-dark ">
                                <i class="fas fa-cog"></i> Call Forward Settings

                            </div>
                            <br />

                            <div class="form-group">
                                <label>Call Forward Number</label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" placeholder="Enter new key to update"
                                        name="call_forward_number" id="call_forward_number"
                                        value="{{ $settings->call_forward_number }}" required>
                                </div>
                            </div>

                            <div class="card-header bg-soft-dark ">
                                <i class="fas fa-cog"></i> Campaign Schedule Settings

                            </div>
                            <br />

                            <div class="form-group">
                                <label>Scheduled Hours</label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control"
                                        placeholder="Enter Hours value ex. 11 AM EST - 8 PM EST" name="schedule_hours"
                                        id="schedule_hours" value="{{ $settings->schedule_hours }}" required>
                                </div>
                            </div>


                            <div class="card-header bg-soft-dark ">
                                <i class="fas fa-cog"></i> Google Drive Keys

                            </div>
                            <br />

                            <div class="form-group">
                                <label>Google Drive Client Id</label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" placeholder="Enter Google Drive Client Id"
                                        name="google_drive_client_id" id="google_drive_client_id"
                                        value="{{ $settings->google_drive_client_id }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Google Drive Client Secret </label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control"
                                        placeholder="Enter Google Drive Client Secret" name="google_drive_client_secret"
                                        id="google_drive_client_secret"
                                        value="{{ $settings->google_drive_client_secret }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Google Drive Developer Key </label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control"
                                        placeholder="Enter Google Drive Developer Key" name="google_drive_developer_key"
                                        id="google_drive_developer_key"
                                        value="{{ $settings->google_drive_developer_key }}">
                                </div>
                            </div>

                            <div class="card-header bg-soft-dark ">
                                <i class="fas fa-cog"></i> Stripe Keys

                            </div>
                            <br />

                            <div class="form-group">
                                <label>Stripe Secret Key</label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" placeholder="Enter Stripe Secret Key"
                                        name="stripe_screct_key" id="stripe_screct_key"
                                        value="{{ $settings->stripe_screct_key }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Stripe Publishable Key </label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" placeholder="Enter Stripe Publishable Key"
                                        name="strip_publishable_key" id="strip_publishable_key"
                                        value="{{ $settings->strip_publishable_key }}">
                                </div>
                            </div>

                            <div class="card-header bg-soft-dark ">
                                <i class="fas fa-cog"></i> PayPal Keys

                            </div>
                            <br />

                            <div class="form-group">
                                <label>PayPal Client ID</label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" placeholder="Enter PayPal Client ID"
                                        name="paypal_client_id" id="paypal_client_id"
                                        value="{{ $settings->paypal_client_id }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>PayPal Secret Key </label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" placeholder="Enter PayPal Secret Key"
                                        name="paypal_secret_key" id="paypal_secret_key"
                                        value="{{ $settings->paypal_secret_key }}">
                                </div>
                            </div>


                            <div class="card-header bg-soft-dark ">
                                <i class="fas fa-cog"></i> Connect Gmail
                            </div>
                            <br />

                            <div class="form-group">
                                @if(LaravelGmail::check())
                                <a href="{{ route('gmail.logout') }}" class="btn btn-secondary">Logout From Gmail</a>
                                @else
                                <a href="{{ route('gmail.login') }}" class="btn btn-secondary">Login to Gmail</a>
                                @endif
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