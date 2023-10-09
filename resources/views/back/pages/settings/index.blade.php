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
                        <i class="fas fa-cog"></i> General Settings
                        <button class="btn btn-outline-primary btn-sm float-right mr-2" title="helpModal"
                            data-toggle="modal" data-target="#helpModal">Use this Section</button>
                            @include('components.modalform')
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.settings.update', $settings) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label>Auto-Reply</label>
                                <select class="custom-select" name="auto_reply" required>
                                    <option value="1" {{ $settings->auto_reply ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $settings->auto_reply ? '' : 'selected' }}>Not Active</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Auto Keyword Responder</label>
                                <select class="custom-select" name="auto_respond" required>
                                    <option value="1" {{ $settings->auto_responder ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $settings->auto_responder ? '' : 'selected' }}>Not Active
                                    </option>
                                </select>
                            </div>

                            <div class="card-header bg-soft-dark ">
                                <i class="fas fa-cog"></i> Digital Signing

                            </div>
                            <br />
                            <div class="form-group">
                                <label>Authorized Name</label>
                                <div class="input-group mb-2">

                                    <input type="text" class="form-control" placeholder="Auth. Name" name="auth_email"
                                        id="auth_email" value="{{ $settings->auth_email }}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Documents Closed By</label>
                                <div class="input-group mb-2">

                                    <input type="text" class="form-control" placeholder="Document Closed By"
                                        name="document_closed_by" id="document_closed_by"
                                        value="{{ $settings->document_closed_by }}" required>
                                </div>
                            </div>

                            <div class="card-header bg-soft-dark ">
                                <i class="fas fa-cog"></i> Email Settings

                            </div>
                            <br />


                            <div class="form-group">
                                <label>Reply To Email</label>
                                <div class="input-group mb-2">

                                    <input type="text" class="form-control" placeholder="Reply To Email"
                                        name="reply_email" id="reply_email" value="{{ $settings->reply_email }}"
                                        required>
                                </div>
                            </div>

                            <!-- <div class="card-header bg-soft-dark ">
                                <i class="fas fa-cog"></i> Third Party APIs Settings

                            </div>
                            <br /> -->
                      

                                    <input type="hidden" class="form-control" placeholder="Send From Email"
                                        name="sender_email" id="sender_email" value="{{ $settings->sender_email }}"
                                        required>
                               
                      

                                    <input type="hidden" class="form-control" placeholder="Send From Name"
                                        name="sender_name" id="sender_name" value="{{ $settings->sender_name}}"
                                        required>
                               
                      


                                    <input type="hidden" class="form-control" placeholder="Enter Send Grid API Key"
                                        name="sendgrid_key" name="sendgrid_key" value="{{ $settings->sendgrid_key }}"
                                        required>
                               

                      
                                    <input type="hidden" class="form-control" placeholder="Enter Twilio Account SID"
                                        name="twilio_api_key" id="twilio_api_key"
                                        value="{{ $settings->twilio_api_key }}" required>
                               
                      

                                    <input type="hidden" class="form-control" placeholder="Enter Twilio Auth Token"
                                        name="twilio_secret" id="twilio_secret"
                                        value="{{ $settings->twilio_acc_secret }}" required>
                               
                            

                      
                                    <input type="hidden" class="form-control" placeholder="Enter new key to update"
                                        name="slybroad_call_url" name="slybroad_call_url"
                                        value="{{ $settings->slybroad_call_url }}" required>
                               
                      
                                    <input type="hidden" class="form-control" placeholder="Enter new key to update"
                                        name="call_forward_number" id="call_forward_number"
                                        value="{{ $settings->call_forward_number }}" required>
                               


                      
                                    <input type="hidden" class="form-control"
                                        placeholder="Enter Hours value ex. 11 AM EST - 8 PM EST" name="schedule_hours"
                                        id="schedule_hours" value="{{ $settings->schedule_hours }}" required>
                               

                      
                                    <input type="hidden" class="form-control" placeholder="Enter Google Drive Client Id"
                                        name="google_drive_client_id" id="google_drive_client_id"
                                        value="{{ $settings->google_drive_client_id }}">
                               

                      
                                    <input type="hidden" class="form-control"
                                        placeholder="Enter Google Drive Client Secret" name="google_drive_client_secret"
                                        id="google_drive_client_secret"
                                        value="{{ $settings->google_drive_client_secret }}">
                               

                      
                                    <input type="hidden" class="form-control"
                                        placeholder="Enter Google Drive Developer Key" name="google_drive_developer_key"
                                        id="google_drive_developer_key"
                                        value="{{ $settings->google_drive_developer_key }}">
                               

                      
                                    <input type="hidden" class="form-control" placeholder="Enter Stripe Secret Key"
                                        name="stripe_screct_key" id="stripe_screct_key"
                                        value="{{ $settings->stripe_screct_key }}">
                               

                      
                                    <input type="hidden" class="form-control" placeholder="Enter Stripe Publishable Key"
                                        name="strip_publishable_key" id="strip_publishable_key"
                                        value="{{ $settings->strip_publishable_key }}">
                               
                      
                                    <input type="hidden" class="form-control" placeholder="Enter PayPal Client ID"
                                        name="paypal_client_id" id="paypal_client_id"
                                        value="{{ $settings->paypal_client_id }}">
                               

                      
                                    <input type="hidden" class="form-control" placeholder="Enter PayPal Secret Key"
                                        name="paypal_secret_key" id="paypal_secret_key"
                                        value="{{ $settings->paypal_secret_key }}">
                               

                           

                            <button type="submit" class="btn btn-primary">Update Settings</button>

                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-soft-dark ">
                        <i class="fas fa-cog"></i> Appointment Calendar Settings
                    </div>
                    <div class="card-body">
                        <form action="{{ url('admin/settings/appointment-calendar-settings') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf


                            <div class="form-group">
                                <label>Timezone</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-clock"></i></div>
                                    </div>

                                    <select class="input form-control timezones" name="timezone" required>
                                        @foreach($timezones as $timezone)
                                        <option value="{{ $timezone }}"
                                            {{ $timezone === $appointmentSetting->timezone ? "selected" : "" }}>
                                            {{ $timezone }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Appointment Period Duration <small>(in minutes)</small></label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-clock"></i></div>
                                    </div>
                                    <input type="number" class="form-control" placeholder="Appointment Period Duration"
                                        name="period_duration" id="appointmentPeriodDuration"
                                        value="{{ $appointmentSetting->period_duration }}" required>
                                </div>
                            </div>

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Day</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Closed</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>Monday</th>
                                        <td>
                                            <input type="time" class="form-control" name="monday_start_time"
                                                value="{{ $appointmentSetting->monday_start_time }}" />
                                        </td>
                                        <td>
                                            <input type="time" class="form-control" name="monday_end_time"
                                                value="{{ $appointmentSetting->monday_end_time }}" />
                                        </td>
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    {{ $appointmentSetting->monday_close == 1 ? "checked" : "" }}
                                                    id="monday_close_yes" name="monday_close" value="1">
                                                <label class="form-check-label" for="monday_close_yes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    {{ $appointmentSetting->monday_close == 0 ? "checked" : "" }}
                                                    id="monday_close_no" name="monday_close" value="0">
                                                <label class="form-check-label" for="monday_close_no">No</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tuesday</th>
                                        <td>
                                            <input type="time" class="form-control" name="tuesday_start_time"
                                                value="{{ $appointmentSetting->tuesday_start_time }}" />
                                        </td>
                                        <td>
                                            <input type="time" class="form-control" name="tuesday_end_time"
                                                value="{{ $appointmentSetting->tuesday_end_time }}" />
                                        </td>
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    {{ $appointmentSetting->tuesday_close == 1 ? "checked" : "" }}
                                                    id="tuesday_close_yes" name="tuesday_close" value="1">
                                                <label class="form-check-label" for="tuesday_close_yes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    {{ $appointmentSetting->tuesday_close == 0 ? "checked" : "" }}
                                                    id="tuesday_close_no" name="tuesday_close" value="0">
                                                <label class="form-check-label" for="tuesday_close_no">No</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Wednesday</th>
                                        <td>
                                            <input type="time" class="form-control" name="wednesday_start_time"
                                                value="{{ $appointmentSetting->wednesday_start_time }}" />
                                        </td>
                                        <td>
                                            <input type="time" class="form-control" name="wednesday_end_time"
                                                value="{{ $appointmentSetting->wednesday_end_time }}" />
                                        </td>
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    {{ $appointmentSetting->wednesday_close == 1 ? "checked" : "" }}
                                                    id="wednesday_close_yes" name="wednesday_close" value="1">
                                                <label class="form-check-label" for="wednesday_close_yes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    {{ $appointmentSetting->wednesday_close == 0 ? "checked" : "" }}
                                                    id="wednesday_close_no" name="wednesday_close" value="0">
                                                <label class="form-check-label" for="wednesday_close_no">No</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Thursday</th>
                                        <td>
                                            <input type="time" class="form-control" name="thursday_start_time"
                                                value="{{ $appointmentSetting->thursday_start_time }}" />
                                        </td>
                                        <td>
                                            <input type="time" class="form-control" name="thursday_end_time"
                                                value="{{ $appointmentSetting->thursday_end_time }}" />
                                        </td>
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    {{ $appointmentSetting->thursday_close == 1 ? "checked" : "" }}
                                                    id="thursday_close_yes" name="thursday_close" value="1">
                                                <label class="form-check-label" for="thursday_close_yes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    {{ $appointmentSetting->thursday_close == 0 ? "checked" : "" }}
                                                    id="thursday_close_no" name="thursday_close" value="0">
                                                <label class="form-check-label" for="thursday_close_no">No</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Friday</th>
                                        <td>
                                            <input type="time" class="form-control" name="friday_start_time"
                                                value="{{ $appointmentSetting->friday_start_time }}" />
                                        </td>
                                        <td>
                                            <input type="time" class="form-control" name="friday_end_time"
                                                value="{{ $appointmentSetting->friday_end_time }}" />
                                        </td>
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    {{ $appointmentSetting->friday_close == 1 ? "checked" : "" }}
                                                    id="friday_close_yes" name="friday_close" value="1">
                                                <label class="form-check-label" for="friday_close_yes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    {{ $appointmentSetting->friday_close == 0 ? "checked" : "" }}
                                                    id="friday_close_no" name="friday_close" value="0">
                                                <label class="form-check-label" for="friday_close_no">No</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Saturday</th>
                                        <td>
                                            <input type="time" class="form-control" name="saturday_start_time"
                                                value="{{ $appointmentSetting->saturday_start_time }}" />
                                        </td>
                                        <td>
                                            <input type="time" class="form-control" name="saturday_end_time"
                                                value="{{ $appointmentSetting->saturday_end_time }}" />
                                        </td>
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    {{ $appointmentSetting->saturday_close == 1 ? "checked" : "" }}
                                                    id="saturday_close_yes" name="saturday_close" value="1">
                                                <label class="form-check-label" for="saturday_close_yes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    {{ $appointmentSetting->saturday_close == 0 ? "checked" : "" }}
                                                    id="saturday_close_no" name="saturday_close" value="0">
                                                <label class="form-check-label" for="saturday_close_no">No</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Sunday</th>
                                        <td>
                                            <input type="time" class="form-control" name="sunday_start_time"
                                                value="{{ $appointmentSetting->sudnay_start_time }}" />
                                        </td>
                                        <td>
                                            <input type="time" class="form-control" name="sunday_end_time"
                                                value="{{ $appointmentSetting->sudnay_end_time }}" />
                                        </td>
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    {{ $appointmentSetting->sunday_close == 1 ? "checked" : "" }}
                                                    id="sunday_close_yes" name="sunday_close" value="1">
                                                <label class="form-check-label" for="sunday_close_yes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="sunday_close_no"
                                                    {{ $appointmentSetting->sunday_close == 0 ? "checked" : "" }}
                                                    name="sunday_close" value="0">
                                                <label class="form-check-label" for="sunday_close_no">No</label>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

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