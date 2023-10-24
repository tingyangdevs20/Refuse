@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <style>
        #hidden_div {
            display: none;
        }
        .popover .arrow {
            display: none !important;
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
                        <h4 class="mb-0 font-size-18">Appointment Reminder</h4>
                        
                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            <i style="" class="fas fa-edit mr-1"></i>
                            {{-- @include('components.modalform') --}}
                        </div>
                        <div class="card-body" >

                            <div class="row">
                                <div class="col-md-2" style="padding: 0px 10px 10px 0px;"></div>
                                <div class="col-md-7" style="padding: 0px 10px 10px 0px; color: #495057;">
                                    <form id="messageForm" method="POST" action="{{ route('appointments.sendReminder') }}" class="form-group" style="padding: 0 10px;">
                                        @csrf
                                        <input type="hidden" name="user_id"  value="{{ $user_id }}">

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group text-right mt-2">
                                                    <label>Delay</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text"><i class="fas fa-calendar"></i>
                                                            </div>
                                                        </div>
                                                        <input type="number" min="0" class="form-control"
                                                            placeholder="Days" value="" name="send_after_days">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text"><i class="fas fa-calendar"></i>
                                                            </div>
                                                        </div>
                                                        <input type="number" min="0" class="form-control"
                                                            placeholder="Hours" value="" name="send_after_hours">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" style="padding: 0 10px;">
                                            {{-- <label>Select Message Type:</label> --}}
                                            <select id="messageType" name="type" onchange="showMessageTypeData()" class="custom-select">
                                                <option value="">Select Message Type
                                                </option>
                                                <option value="sms">SMS</option>
                                                <option value="email">Email</option>
                                                <option value="mms">MMS</option>
                                                <option value="rvm">RVM</option>
                                            </select>
                                        </div>

                                        <div id="smsData" style="display: none; padding: 0 10px;">
                                            <h3>SMS Data</h3>
                                            <div class="row">
                                                <div class="form-group" style=" display: none; padding: 0 10px;">
                                                    
                                                    {{-- <input type="file" class="form-control-file" name="media_file{{ $count }}"> --}}
                                                </div>
                                                {{-- <input type="hidden" class="form-control" placeholder="Hours"
                                                    value="" name="mediaUrl[]">
                                                <input type="hidden" class="form-control" placeholder="Subject"
                                                    value="" name="subject[]"> --}}
                                                <div class="col-md-12">
                                                    <div class="form-group ">
                                                        <label>Message</label>
                                                        <textarea id="template_text" class="form-control" rows="10" name="sms_body"></textarea>
                                                        <div id='count' class="float-lg-right"></div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>

                                        <div id="emailData" style="display: none; padding: 0 10px;">
                                            {{-- <input type="hidden" class="form-control" placeholder="Hours" value=""
                                                name="mediaUrl[]"> --}}
                                            <div class="form-group" style=" display: none;">
                                                {{-- <label>Media File (<small class="text-danger">Disregard if not sending MMS</small>)</label> --}}
                                                {{-- <input type="file" class="form-control-file" name="media_file{{ $count }}"> --}}
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group ">
                                                        <label>Subject</label>
                                                        <input type="text" class="form-control" placeholder="Subject"
                                                            value="" name="email_subject">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group ">
                                                        <label>Message</label>
                                                        <textarea id="body" class="form-control summernote-usage" rows="10" name="email_body"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div id="mmsData" style="display: none; padding: 0 10px;">
                                            <h3>MMS Data</h3>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Media File (<small class="text-danger">Disregard
                                                                if not sending
                                                                MMS</small>)</label>
                                                        <input type="file" class="form-control-file"
                                                            name="media_file">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group ">
                                                        <label>Message</label>
                                                        <textarea id="template_text" class="form-control" rows="10" name="mms_body"></textarea>
                                                        <div id='count' class="float-lg-right"></div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div id="rvmData" style="display: none; padding: 0 10px;">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group mt-3">
                                                        <label>Rvm Files</label>
                                                        <select class="custom-select" name="rvm_mediaUrl">
                                                            <option value="">Rvm
                                                                File</option>
                                                                
                                                            @if (count($files) > 0)
                                                                @foreach ($files as $file)
                                                                    <option value="{{ $file->mediaUrl }}">
                                                                        {{ $file->name }}
                                                                    </option>
                                                                @endforeach
                                                            @endif

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="form-group" style="padding: 0 10px;">

                                            <button type="submit" class="btn btn-primary">Send
                                                Reminder</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-3"></div>
                            </div>



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
    <link rel="stylesheet" href="{{ asset('/summernote/dist/summernote.css') }}" />
    <script src="{{ asset('/summernote/dist/summernote.min.js') }}"></script>
    <script>
        $(".summernote-usage").summernote({
            height: 200,
        });
        $(document).ready(function() {
            $('#datatable').DataTable();
        });


        // function addNewRows(frm) {
        //     rowCount ++;
        //     var recRow = '<div id="rowCount'+rowCount+'" class="col-lg-12"><div class="card col-md-12"><div class="row"><div class="col-md-3"><div class="form-group text-right mt-2"><label>Delay</label></div></div><div class="col-md-3"><div class="form-group"><div class="input-group mb-2"><div class="input-group-prepend"><div class="input-group-text"><i class="fas fa-calendar"></i></div></div><input type="number" min="0" class="form-control" placeholder="Days" name="send_after_days[]"></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group mb-2"><div class="input-group-prepend"><div class="input-group-text"><i class="fas fa-calendar"></i></div></div><input type="number" min="0" class="form-control" placeholder="Hours" name="send_after_hours[]"></div></div></div><div class="col-md-3"><button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #f00;padding: 10px 5px;" onclick="removeRow('+rowCount+');"><i class="fas fa-trash"></i></button></div></div><div class="row"><div class="col-md-12"><div class="form-group mt-3"><input type="hidden"  class="form-control" placeholder="Days" value="0" name="campaign_list_id[]"><label>Campaign Type</label><select class="custom-select" name="type[]"  onchange="messageType(value,'+rowCount+');" required><option value="sms">SMS</option><option value="email">Email</option><option value="mms">MMS</option><option value="rvm">RVM</option></select></div></div></div><div class="row show_sms_'+rowCount+'"><div class="col-md-12"><div class="form-group "><div class="form-group" style=" display: none;"><label>Media File (<small class="text-danger">Disregard if not sending MMS</small>)</label><input type="file" class="form-control-file" name="media_file'+rowCount+'"></div><input type="hidden" class="form-control" placeholder="Hours" value="" name="mediaUrl[]"><input type="hidden"  class="form-control" placeholder="Subject" value="" name="subject[]"><label >Message</label><textarea id="template_text" class="form-control"  rows="10" name="body[]"></textarea><div id="count" class="float-lg-right"></div></div><div class="form-group"><small class="text-danger"><b>Use {name} {street} {city} {state} {zip} to substitute the respective fields</b></small></div></div></div></div><div class="col-md-12"><div class="row"><div class="col-md-4 text-center"></div><div class="col-md-4 text-center"><hr></div><div class="col-md-4 text-center"></div></div></div></div></div>';

        //     jQuery('.addNewRow').append(recRow);

        // }

        // function removeRow(removeNum) {
        //     jQuery('#rowCount'+removeNum).remove();
        // }
        function showMessageTypeData() {
            var messageType = document.getElementById("messageType").value;
            // Hide all message data sections
            document.getElementById("smsData").style.display = "none";
            document.getElementById("emailData").style.display = "none";
            document.getElementById("mmsData").style.display = "none";
            document.getElementById("rvmData").style.display = "none";

            // Show the selected message data section
            if (messageType === "sms") {
                document.getElementById("smsData").style.display = "block";
            } else if (messageType === "email") {
                $(".summernote-usage").summernote({
                    height: 200,
                });
                document.getElementById("emailData").style.display = "block";
            } else if (messageType === "mms") {
                document.getElementById("mmsData").style.display = "block";
            } else if (messageType === "rvm") {
                document.getElementById("rvmData").style.display = "block";

                // Get the checkboxList element by its ID


            }
        }
    </script>
    {{-- <script>
        function showDiv(divId, element)
        {
            document.getElementById(divId).style.display = element.value == 1 ? 'block' : 'none';
        }
        function templateId() {
            template_id = document.getElementById("template-select").value;
           setTextareaValue(template_id)
        }
    </script> --}}
    {{-- <script>
        function setTextareaValue(id)
        {
            if(id>0){
                axios.get('/admin/template/'+id)
                    .then(response =>
                        document.getElementById("template_text").value = response.data['body'],
                    )
                    .catch(error => console.log(error));
            }
            else{
                document.getElementById("template_text").value = '';
            }


        }
        const textarea = document.querySelector('textarea')
        const count = document.getElementById('count')
        textarea.onkeyup = (e) => {
            count.innerHTML = "Characters: "+e.target.value.length+"/160";
        };

        function messageType(type,id){
            $('.show_sms_'+id).html('');
            var url = '<?php echo url('/admin/get/leadmessage/'); ?>/'+type+'/'+id;
            //alert(url);
            $.ajax({
                type: 'GET',
                url: url,
                data: '',
                processData: false,
                contentType: false,
                success: function (d) {
                    alert(d);
                    $('.show_sms_'+id).html(d);
                }
            });
        }
    </script> --}}
@endsection
