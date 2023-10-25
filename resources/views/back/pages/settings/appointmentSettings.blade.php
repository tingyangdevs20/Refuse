@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <style>
        /* Ensure the table takes the full width of its container */
        .table-responsive {
            overflow-x: auto;
        }

        /* Add horizontal scrolling for the table on smaller screens */
        /* .table {
                            white-space: nowrap;
                        } */

        /* Add responsive breakpoints and adjust table font size and padding as needed */
        @media (max-width: 768px) {
            .table {
                font-size: 12px;
            }
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
                       
                    </div>

                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            <i class="fas fa-cog mr-1"></i> Appointment Calendar Settings
                            @include('components.modalform')
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
                                            @foreach ($timezones as $timezone)
                                                <option value="{{ $timezone }}"
                                                    {{ $timezone === $appointmentSetting->timezone ? 'selected' : '' }}>
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
                                <div class="form-group">
                                    <label>Maximum number of days <small>(in days)</small></label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-clock"></i></div>
                                        </div>
                                        <input type="number" class="form-control" placeholder="Advance booking duration"
                                            name="advance_booking_duration" id="advanceBookingDuration"
                                            value="{{ $appointmentSetting->advance_booking_duration }}">
                                    </div>
                                </div>

                                <div class="table-responsive">
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
                                                            {{ $appointmentSetting->monday_close == 1 ? 'checked' : '' }}
                                                            id="monday_close_yes" name="monday_close" value="1">
                                                        <label class="form-check-label" for="monday_close_yes">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            {{ $appointmentSetting->monday_close == 0 ? 'checked' : '' }}
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
                                                            {{ $appointmentSetting->tuesday_close == 1 ? 'checked' : '' }}
                                                            id="tuesday_close_yes" name="tuesday_close" value="1">
                                                        <label class="form-check-label" for="tuesday_close_yes">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            {{ $appointmentSetting->tuesday_close == 0 ? 'checked' : '' }}
                                                            id="tuesday_close_no" name="tuesday_close" value="0">
                                                        <label class="form-check-label" for="tuesday_close_no">No</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Wednesday</th>
                                                <td>
                                                    <input type="time" class="form-control"
                                                        name="wednesday_start_time"
                                                        value="{{ $appointmentSetting->wednesday_start_time }}" />
                                                </td>
                                                <td>
                                                    <input type="time" class="form-control" name="wednesday_end_time"
                                                        value="{{ $appointmentSetting->wednesday_end_time }}" />
                                                </td>
                                                <td>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            {{ $appointmentSetting->wednesday_close == 1 ? 'checked' : '' }}
                                                            id="wednesday_close_yes" name="wednesday_close"
                                                            value="1">
                                                        <label class="form-check-label"
                                                            for="wednesday_close_yes">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            {{ $appointmentSetting->wednesday_close == 0 ? 'checked' : '' }}
                                                            id="wednesday_close_no" name="wednesday_close"
                                                            value="0">
                                                        <label class="form-check-label"
                                                            for="wednesday_close_no">No</label>
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
                                                            {{ $appointmentSetting->thursday_close == 1 ? 'checked' : '' }}
                                                            id="thursday_close_yes" name="thursday_close" value="1">
                                                        <label class="form-check-label"
                                                            for="thursday_close_yes">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            {{ $appointmentSetting->thursday_close == 0 ? 'checked' : '' }}
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
                                                            {{ $appointmentSetting->friday_close == 1 ? 'checked' : '' }}
                                                            id="friday_close_yes" name="friday_close" value="1">
                                                        <label class="form-check-label" for="friday_close_yes">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            {{ $appointmentSetting->friday_close == 0 ? 'checked' : '' }}
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
                                                            {{ $appointmentSetting->saturday_close == 1 ? 'checked' : '' }}
                                                            id="saturday_close_yes" name="saturday_close" value="1">
                                                        <label class="form-check-label"
                                                            for="saturday_close_yes">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            {{ $appointmentSetting->saturday_close == 0 ? 'checked' : '' }}
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
                                                            {{ $appointmentSetting->sunday_close == 1 ? 'checked' : '' }}
                                                            id="sunday_close_yes" name="sunday_close" value="1">
                                                        <label class="form-check-label" for="sunday_close_yes">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            id="sunday_close_no"
                                                            {{ $appointmentSetting->sunday_close == 0 ? 'checked' : '' }}
                                                            name="sunday_close" value="0">
                                                        <label class="form-check-label" for="sunday_close_no">No</label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
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
        $(document).ready(function() {
            $('#datatable').DataTable();
        });
    </script>
@endsection
