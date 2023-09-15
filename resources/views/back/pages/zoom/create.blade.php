@extends('back.inc.master')
@section('styles')
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
                        <h4 class="mb-0 font-size-18">Zoom Meeting Management</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Dashboard</a></li>
                                <li class="breadcrumb-item">Zoom Meeting  Management</li>
                                <li class="breadcrumb-item active">Zoom Meeting</li>
                            </ol>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            Create Zoom Meeting
                            <a href="{{URL::previous()}}" class="btn btn-outline-primary btn-sm float-right" title="New" ><i class="fas fa-arrow-left"></i></a>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('admin.zoom.store') }}" enctype="multipart/form-data">
                                @csrf <!-- CSRF Token -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="meeting_name">Meeting Topic <strong style="color:red;">*</strong></label>
                                        <input type="text" class="form-control @error('meeting_name') is-invalid @enderror" id="meeting_name" name="meeting_name" autocomplete="off" aria-autocomplete="none" value="{{ old('meeting_name') }}"  >
                                        @error('meeting_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="meeting_password">Meeting Password <strong style="color:red;">*</strong></label>
                                        <input type="password" class="form-control @error('meeting_password') is-invalid @enderror" id="meeting_password" autocomplete="off" aria-autocomplete="none" name="meeting_password"> <i class="fas fa-eye d-flex justify-content-end align-items-end" style="margin-top: -22px;
    margin-right: 12px;" onclick="ShowHidePassword();"></i>
                                        @error('meeting_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="meeting_date_timezone">Select Timezone <strong style="color:red;">*</strong></label>
                                        <select name="meeting_date_timezone" id="meeting_date_timezone" class="form-control" required>
    <option value="">Select</option>
    <option value="Pacific/Midway">Pacific/Midway</option>
<option value="America/Adak">America/Adak</option>
<option value="Etc/GMT+10">Etc/GMT+10</option>
<option value="Pacific/Marquesas">Pacific/Marquesas</option>
<option value="Pacific/Gambier">Pacific/Gambier</option>
<option value="America/Anchorage">America/Anchorage</option>
<option value="America/Ensenada">America/Ensenada</option>
<option value="Etc/GMT+8">Etc/GMT+8</option>
<option value="America/Los_Angeles">America/Los_Angeles</option>
<option value="America/Denver">America/Denver</option>
<option value="America/Chihuahua">America/Chihuahua</option>
<option value="America/Dawson_Creek">America/Dawson_Creek</option>
<option value="America/Belize">America/Belize</option>
<option value="America/Cancun">America/Cancun</option>
<option value="Chile/EasterIsland">Chile/EasterIsland</option>
<option value="America/Chicago">America/Chicago</option>
<option value="America/New_York">America/New_York</option>
<option value="America/Havana">America/Havana</option>
<option value="America/Bogota">America/Bogota</option>
<option value="America/Caracas">America/Caracas</option>
<option value="America/Santiago">America/Santiago</option>
<option value="America/La_Paz">America/La_Paz</option>
<option value="Atlantic/Stanley">Atlantic/Stanley</option>
<option value="America/Campo_Grande">America/Campo_Grande</option>
<option value="America/Goose_Bay">America/Goose_Bay</option>
<option value="America/Glace_Bay">America/Glace_Bay</option>
<option value="America/St_Johns">America/St_Johns</option>
<option value="America/Araguaina">America/Araguaina</option>
<option value="America/Montevideo">America/Montevideo</option>
<option value="America/Miquelon">America/Miquelon</option>
<option value="America/Godthab">America/Godthab</option>
<option value="America/Argentina/Buenos_Aires">America/Argentina/Buenos_Aires</option>
<option value="America/Sao_Paulo">America/Sao_Paulo</option>
<option value="America/Noronha">America/Noronha</option>
<option value="Atlantic/Cape_Verde">Atlantic/Cape_Verde</option>
<option value="Atlantic/Azores">Atlantic/Azores</option>
<option value="Europe/Belfast">Europe/Belfast</option>
<option value="Europe/Dublin">Europe/Dublin</option>
<option value="Europe/Lisbon">Europe/Lisbon</option>
<option value="Europe/London">Europe/London</option>
<option value="Africa/Abidjan">Africa/Abidjan</option>
<option value="Europe/Amsterdam">Europe/Amsterdam</option>
<option value="Europe/Belgrade">Europe/Belgrade</option>
<option value="Europe/Brussels">Europe/Brussels</option>
<option value="Africa/Algiers">Africa/Algiers</option>
<option value="Africa/Windhoek">Africa/Windhoek</option>
<option value="Asia/Beirut">Asia/Beirut</option>
<option value="Africa/Cairo">Africa/Cairo</option>
<option value="Asia/Gaza">Asia/Gaza</option>
<option value="Africa/Blantyre">Africa/Blantyre</option>
<option value="Asia/Jerusalem">Asia/Jerusalem</option>
<option value="Europe/Minsk">Europe/Minsk</option>
<option value="Asia/Damascus">Asia/Damascus</option>
<option value="Europe/Moscow">Europe/Moscow</option>
<option value="Africa/Addis_Ababa">Africa/Addis_Ababa</option>
<option value="Asia/Tehran">Asia/Tehran</option>
<option value="Asia/Dubai">Asia/Dubai</option>
<option value="Asia/Yerevan">Asia/Yerevan</option>
<option value="Asia/Kabul">Asia/Kabul</option>
<option value="Asia/Yekaterinburg">Asia/Yekaterinburg</option>
<option value="Asia/Tashkent">Asia/Tashkent</option>
<option value="Asia/Kolkata">Asia/Kolkata</option>
<option value="Asia/Katmandu">Asia/Katmandu</option>
<option value="Asia/Dhaka">Asia/Dhaka</option>
<option value="Asia/Novosibirsk">Asia/Novosibirsk</option>
<option value="Asia/Rangoon">Asia/Rangoon</option>
<option value="Asia/Bangkok">sia/Bangkok</option>
<option value="Asia/Krasnoyarsk">Asia/Krasnoyarsk</option>
<option value="Asia/Hong_Kong">Asia/Hong_Kong</option>
<option value="Asia/Irkutsk">Asia/Irkutsk</option>
<option value="Australia/Perth">Australia/Perth</option>
<option value="Australia/Eucla">Australia/Eucla</option>
<option value="Asia/Tokyo">Asia/Tokyo</option>
<option value="Asia/Seoul">Asia/Seoul</option>
<option value="Asia/Yakutsk">Asia/Yakutsk</option>
<option value="Australia/Adelaide">Australia/Adelaide</option>
<option value="Australia/Darwin">Australia/Darwin</option>
<option value="Australia/Brisbane">Australia/Brisbane</option>
<option value="Australia/Hobart">Australia/Hobart</option>
<option value="Asia/Vladivostok">Asia/Vladivostok</option>
<option value="Australia/Lord_Howe">Australia/Lord_Howe</option>
<option value="Etc/GMT-11">Etc/GMT-11</option>
<option value="Asia/Magadan">Asia/Magadan</option>
<option value="Pacific/Norfolk">Pacific/Norfolk</option>
<option value="Asia/Anadyr">Asia/Anady</option>
<option value="Pacific/Auckland">Pacific/Auckland</option>
<option value="Etc/GMT-12">Etc/GMT-12</option>
<option value="Pacific/Chatham">Pacific/Chatham</option>
<option value="Pacific/Tongatapu">Pacific/Tongatapu</option>
<option value="Pacific/Kiritimati">Pacific/Kiritimati</option>
</select>
                                        @error('meeting_date_timezone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="meeting_date">Meeting Date Time <strong style="color:red;">*</strong></label>
                                        <input type="text" class="form-control @error('meeting_date') is-invalid @enderror" id="meeting_date" name="meeting_date" value="{{ old('meeting_date') }}"  >
                                        @error('meeting_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="duration_minute">Meeting Duration (Minutes) <strong style="color:red;">*</strong></label>
                                        <input type="tel" class="form-control @error('duration_minute') is-invalid @enderror" id="duration_minute" name="duration_minute" value="{{ old('duration_minute') }}"  >
                                        @error('start_time')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="host_video">Host Video</label>
                                        <select name="host_video" id="host_video" class="form-control" required>
                                <option value="">Select</option>
                                <option value="0">Enable</option>
                                <option value="1">Disable</option>
                            </select>
                                        @error('host_video')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="host_video">Participant Video</label>
                                        <select name="client_video" id="client_video" class="form-control" required>
                                <option value="">Select</option>
                                <option value="0">Enable</option>
                                <option value="1">Disable</option>
                            </select>
                                        @error('client_video')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="meeting_status">Status <strong style="color:red;">*</strong></label>
                                        <select name="meeting_status" id="meeting_status" class="form-control" required>
                                <option value="">Select</option>
                                <option value="0">Awaited</option>
                                <option value="1">Finished</option>
                                <option value="2">Cancelled</option>
                            </select>
                                        @error('meeting_status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="meeting_note">Meeting Agenda</label>
                                        <textarea class="form-control @error('meeting_note') is-invalid @enderror" id="meeting_note" name="meeting_note" value="">{{ old('meeting_note') }}</textarea>
                                        @error('meeting_note')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                               





                                <div class="col-md-6 d-flex justify-content-end align-items-end">
                                    <div class="form-group">
                                <button type="submit" class="btn btn-primary">Create Meeting</button>
</div>
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
<!-- jQuery CDN -->
<script src=
"https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js">
    </script>
    <!-- CSS CDN -->
    <link rel="stylesheet"
          href=
"https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css"
    />
    <!-- datetimepicker jQuery CDN -->
    <script src=
"https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js">
   </script>
 <script>
  
  function ShowHidePassword() {
  var x = document.getElementById("meeting_password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}   
 $("#meeting_date").datetimepicker({
  format: 'Y-m-d H:i',
  minDate: 0
});
    </script>
@endsection