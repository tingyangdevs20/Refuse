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
                        <i class="fas fa-cog"></i> Google Calendar Settings
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
                                    <input type="text" class="form-control" placeholder="Google calendar ID" name="calendar_id"
                                        id="calendar_id" value="{{ $accounts->calendar_id }}" required>
                                </div>
                            </div>
                            
                            <input type="hidden" name="calendar_credentials_path" value="{{ $accounts->calendar_credentials_path }}">
                            
                            <div class="form-group">
                                <label>Calendar Status</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-check"></i></div>
                                    </div>
                                    <select class="input form-control" name="calendar_enable" required>
                                        <option value="Y" {{ $accounts->calendar_enable === "Y" ? "selected" : "" }}>Enable</option>
                                        <option value="N" {{ $accounts->calendar_enable === "N" ? "selected" : "" }}>Disable</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Calendar Credentials File <small>(if you don't want to update your credentials leave it blank)</small></label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-lock"></i></div>
                                    </div>
                                    <input type="file" class="form-control" accept="application/json" name="calendar_credentials_file"
                                        id="credentials">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Settings</button>

                        </form>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header bg-soft-dark ">
                        <i class="fas fa-cog"></i> Appointment Calendar Settings
                    </div>
                    <div class="card-body">
                        <form action="{{ url('admin/account/appointment-calendar-settings') }}" method="post"
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
                                        <option value="{{ $timezone }}" {{ $timezone === $appointmentSetting->timezone ? "selected" : "" }}>{{ $timezone }}</option>
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
                                    <input type="number" class="form-control" placeholder="Appointment Period Duration" name="period_duration"
                                        id="appointmentPeriodDuration" value="{{ $appointmentSetting->period_duration }}" required>
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
                                            <input type="time" class="form-control" name="monday_start_time" value="{{ $appointmentSetting->monday_start_time }}" />
                                        </td>
                                        <td>
                                            <input type="time" class="form-control" name="monday_end_time" value="{{ $appointmentSetting->monday_end_time }}" />
                                        </td>
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" {{ $appointmentSetting->monday_close == 1 ? "checked" : "" }} id="monday_close_yes" name="monday_close" value="1">
                                                <label class="form-check-label" for="monday_close_yes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" {{ $appointmentSetting->monday_close == 0 ? "checked" : "" }} id="monday_close_no" name="monday_close" value="0">
                                                <label class="form-check-label" for="monday_close_no">No</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tuesday</th>
                                        <td>
                                            <input type="time" class="form-control" name="tuesday_start_time" value="{{ $appointmentSetting->tuesday_start_time }}" />
                                        </td>
                                        <td>
                                            <input type="time" class="form-control" name="tuesday_end_time" value="{{ $appointmentSetting->tuesday_end_time }}" />
                                        </td>
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" {{ $appointmentSetting->tuesday_close == 1 ? "checked" : "" }} id="tuesday_close_yes" name="tuesday_close" value="1">
                                                <label class="form-check-label" for="tuesday_close_yes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" {{ $appointmentSetting->tuesday_close == 0 ? "checked" : "" }} id="tuesday_close_no" name="tuesday_close" value="0">
                                                <label class="form-check-label" for="tuesday_close_no">No</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Wednesday</th>
                                        <td>
                                            <input type="time" class="form-control" name="wednesday_start_time" value="{{ $appointmentSetting->wednesday_start_time }}" />
                                        </td>
                                        <td>
                                            <input type="time" class="form-control" name="wednesday_end_time" value="{{ $appointmentSetting->wednesday_end_time }}" />
                                        </td>
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" {{ $appointmentSetting->wednesday_close == 1 ? "checked" : "" }} id="wednesday_close_yes" name="wednesday_close" value="1">
                                                <label class="form-check-label" for="wednesday_close_yes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" {{ $appointmentSetting->wednesday_close == 0 ? "checked" : "" }} id="wednesday_close_no" name="wednesday_close" value="0">
                                                <label class="form-check-label" for="wednesday_close_no">No</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Thursday</th>
                                        <td>
                                            <input type="time" class="form-control" name="thursday_start_time" value="{{ $appointmentSetting->thursday_start_time }}" />
                                        </td>
                                        <td>
                                            <input type="time" class="form-control" name="thursday_end_time" value="{{ $appointmentSetting->thursday_end_time }}" />
                                        </td>
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" {{ $appointmentSetting->thursday_close == 1 ? "checked" : "" }} id="thursday_close_yes" name="thursday_close" value="1">
                                                <label class="form-check-label" for="thursday_close_yes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" {{ $appointmentSetting->thursday_close == 0 ? "checked" : "" }} id="thursday_close_no" name="thursday_close" value="0">
                                                <label class="form-check-label" for="thursday_close_no">No</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Friday</th>
                                        <td>
                                            <input type="time" class="form-control" name="friday_start_time" value="{{ $appointmentSetting->friday_start_time }}" />
                                        </td>
                                        <td>
                                            <input type="time" class="form-control" name="friday_end_time" value="{{ $appointmentSetting->friday_end_time }}" />
                                        </td>
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" {{ $appointmentSetting->friday_close == 1 ? "checked" : "" }} id="friday_close_yes" name="friday_close" value="1">
                                                <label class="form-check-label" for="friday_close_yes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" {{ $appointmentSetting->friday_close == 0 ? "checked" : "" }} id="friday_close_no" name="friday_close" value="0">
                                                <label class="form-check-label" for="friday_close_no">No</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Saturday</th>
                                        <td>
                                            <input type="time" class="form-control" name="saturday_start_time" value="{{ $appointmentSetting->saturday_start_time }}" />
                                        </td>
                                        <td>
                                            <input type="time" class="form-control" name="saturday_end_time" value="{{ $appointmentSetting->saturday_end_time }}" />
                                        </td>
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" {{ $appointmentSetting->saturday_close == 1 ? "checked" : "" }} id="saturday_close_yes" name="saturday_close" value="1">
                                                <label class="form-check-label" for="saturday_close_yes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" {{ $appointmentSetting->saturday_close == 0 ? "checked" : "" }} id="saturday_close_no" name="saturday_close" value="0">
                                                <label class="form-check-label" for="saturday_close_no">No</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Sunday</th>
                                        <td>
                                            <input type="time" class="form-control" name="sunday_start_time" value="{{ $appointmentSetting->sudnay_start_time }}" />
                                        </td>
                                        <td>
                                            <input type="time" class="form-control" name="sunday_end_time" value="{{ $appointmentSetting->sudnay_end_time }}"  />
                                        </td>
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" {{ $appointmentSetting->sunday_close == 1 ? "checked" : "" }} id="sunday_close_yes" name="sunday_close" value="1">
                                                <label class="form-check-label" for="sunday_close_yes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="sunday_close_no" {{ $appointmentSetting->sunday_close == 0 ? "checked" : "" }} name="sunday_close" value="0">
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