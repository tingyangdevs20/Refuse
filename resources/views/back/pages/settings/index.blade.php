@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
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

        #exTab2 h3 {
            color: white;
            background-color: #428bca;
            padding: 5px 15px;
        }

        .nav-tabs .nav-item .nav-link.active {
            background-color: #38B6FF;
            /* Change to your preferred button color */
            color: #fff;
            /* Text color for the active tab */
            border-color: #38B6FF;
            /* Border color for the active tab */
            border-radius: 5px;
            /* Optional: Add rounded corners */
            /* padding: 13px; */
        }

        /* Add other CSS styles for the non-active tab links as needed */
        .nav-tabs .nav-item .nav-link {
            /* Default text color for non-active tabs */
            /* border-color: #38B6FF; */
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
                        <h4 class="mb-0 font-size-18">General Settings</h4>
                       
                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            <i class="fas fa-cog mr-1"></i>All General Settings
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
                                        <a class="nav-link active" href="#General" data-toggle="tab">General</a>
                                    </li>
                                    <li class="nav-item m-1"><a class="nav-link" href="#Activity"
                                            data-toggle="tab">Activity</a>
                                    </li>
                                    <li class="nav-item m-1"><a class="nav-link" href="#Appointments"
                                            data-toggle="tab">Appointments</a>
                                    </li>
                                    <li class="nav-item m-1"><a class="nav-link" href="#Digital"
                                            data-toggle="tab">Digital Signing</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- TABS HEADINGS SECTION ENDS -->
                                <!-- TABS CONTENT SECTION -->
                                <div class="card-body">
                                   <div class="tab-content clearfix">
                                    <!-- TAB 1 CONTENT -->
                                      <div class="tab-pane active" id="General">
                                          <div class="card">
                                               <div class="card-header bg-soft-dark ">
                                                  <i class="fas fa-cog mr-1"></i>General
                                                  
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
                            <div class="form-group">
                                <label>Reply To Email</label>
                                <div class="input-group mb-2">

                                    <input type="text" class="form-control" placeholder="Reply To Email"
                                        name="reply_email" id="reply_email" value="{{ $settings->reply_email }}"
                                        required>
                                </div>
                            </div>
                                           

                                            

                                            
                                                      <button type="submit" class="btn btn-primary" style="background-color:#38B6FF;border-color:#38B6FF">Update Settings</button>
                                                 </form>
                                                </div>
                                          </div>
                                       </div>
                                      <!-- TAB 1 CONTENT ENDS -->

                                       <!-- TAB 2 CONTENT -->
                                       <div class="tab-pane" id="Activity">
                                          <div class="card">
                                               <div class="card-header bg-soft-dark ">
                                                  <i class="fas fa-cog mr-1"></i>Activity
                                                  
                                                </div>

                                                <div class="card-body">
                                                
                                                      <div class="row">
                <div class="col-12">
                   
                    <div class="card">
                        
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Client#</th>
                                            <th scope="col">Twilio#</th>
                                            <th scope="col">Media</th>
                                            <th scope="col">Message</th>
                                            <th scope="col">Error</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($messages as $msg)
                                            <tr>
                                                <td>{{ $sr++ }}</td>
                                                <td>{{ $msg->client_number }}</td>
                                                <td>{{ $msg->twilio_number }}</td>
                                                @if ($msg->media != 'No')
                                                    <td><a href="{{ asset($msg->media) }}" target="_blank">Yes</a></td>
                                                @else
                                                    <td><a href="#">No</a></td>
                                                @endif
                                                <td>{{ $msg->message }}</td>
                                                <td>{{ $msg->error }}</td>
                                                <td>
                                                    <button data-toggle="modal" data-target="#deleteModal"
                                                        class="btn btn-outline-danger btn-sm" title="Remove"
                                                        data-id="{{ $msg->id }}"><i class="fas fa-trash"></i></button>

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

                                            

                                           
            {{-- Modal Delete --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Conversation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.failed-sms.destroy', 'test') }}" method="post" id="editForm">
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
                                                </div>
                                          </div>
                                       </div>
                                      <!-- TAB 2 CONTENT ENDS -->
                                       <!-- TAB 3 CONTENT -->
                                       <div class="tab-pane" id="Appointments">
                                          <div class="card">
                                               

                                                <div class="card-body">
                                                 
                                                      <div class="card">
                        <div class="card-header bg-soft-dark ">
                            <i class="fas fa-cog mr-1"></i> Appointment Calendar Settings
                            @include('components.modalform')
                        </div>
                        <div class="card-body">
                            <form action="{{ url('admin/settings/appointment-calendar-settings') }}" method="post"
                                enctype="multipart/form-data">

                                @csrf
                                @method('PUT')
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

                                <button type="submit" class="btn btn-primary" style="background-color:#38B6FF;border-color:#38B6FF">Update Settings</button>

                            </form>
                        </div>
                    </div>

                                            

                                            
                                                     
                                                
                                                </div>
                                          </div>
                                       </div>
                                      <!-- TAB 3 CONTENT ENDS -->
                                       <!-- TAB 4 CONTENT -->
                                       <div class="tab-pane" id="Digital">
                                          <div class="card">
                                               <div class="card-header bg-soft-dark ">
                                                  <i class="fas fa-cog mr-1"></i>Digital Signing
                                                  
                                                </div>

                                                <div class="card-body">
                                                  <form action="{{ route('admin.settings.update', $settings) }}" method="post"
                                                      enctype="multipart/form-data">
                                                      @csrf
                                                      @method('PUT')
                                                      
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


                                            

                                            
                                                      <button type="submit" class="btn btn-primary" style="background-color:#38B6FF;border-color:#38B6FF">Update Settings</button>
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
    <script>
         $('#deleteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
        });
        $(document).ready(function() {
            $('#datatable').DataTable();
        });
    </script>
@endsection
