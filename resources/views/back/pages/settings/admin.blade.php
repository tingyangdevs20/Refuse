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
                       
                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            <i class="fas fa-cog"></i> Administrative Settings
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.settings.update',$settings) }}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label>Auto-Reply</label>
                                    <select class="custom-select" name="auto_reply" required>
                                        <option value="1" {{ $settings->auto_reply?"selected":"" }}>Active</option>
                                        <option value="0" {{ $settings->auto_reply?"":"selected" }}>Not Active</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Auto Keyword Responder</label>
                                    <select class="custom-select" name="auto_respond" required>
                                        <option value="1" {{ $settings->auto_responder?"selected":"" }}>Active</option>
                                        <option value="0" {{ $settings->auto_responder?"":"selected" }}>Not Active
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>SMS Rate</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-dollar-sign"></i></div>
                                        </div>
                                        <input type="number" class="form-control" placeholder="Per SMS Rate"
                                               name="sms_rate" value="{{ $settings->sms_rate }}" step="0.00001" min="0" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>SMS Allowed Per Day</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-envelope"></i></div>
                                        </div>
                                        <input type="number" class="form-control" placeholder="Per SMS Rate"
                                               name="sms_allowed" value="{{ $settings->sms_allowed }}" step="1" min="1" required>
                                    </div>
                                </div>
                                
                                 <div class="card-header bg-soft-dark ">
                            <i class="fas fa-cog"></i> Email Settings
                          
                        </div>
                          <br/>
                            
                         <div class="form-group">
                                    <label>Send From Email</label>
                                    <div class="input-group mb-2">
                                      
                                        <input type="text" class="form-control" placeholder="Send From Email"
                                               name="sender_email" id="sender_email" value="{{ $settings->sender_email }}"  required>
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label>Reply To Email</label>
                                    <div class="input-group mb-2">
                                      
                                        <input type="text" class="form-control" placeholder="Reply To Email"
                                               name="reply_email" id="reply_email" value="{{ $settings->reply_email }}"  required>
                                    </div>
                                </div>
                                
                                   <div class="card-header bg-soft-dark ">
                            <i class="fas fa-cog"></i> Third Party APIs Settings
                          
                        </div>
                          <br/>
                            
                         <div class="form-group">
                                    <label>Send Grid API Key</label>
                                    <div class="input-group mb-2">
                                      
                                        <input type="text" class="form-control" placeholder="Enter new key to update"
                                               name="sendgrid_key" name="sendgrid_key" value=""  required>
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label>Twilio API Key</label>
                                    <div class="input-group mb-2">
                                      
                                        <input type="text" class="form-control" placeholder="Enter new key to update"
                                               name="twilio_api_key" id="twilio_api_key" value=""  required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Twilio Account Secret Key</label>
                                    <div class="input-group mb-2">
                                      
                                        <input type="text" class="form-control" placeholder="Enter new key to update"
                                               name="twilio_secret" id="twilio_secret" value=""  required>
                                    </div>
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
