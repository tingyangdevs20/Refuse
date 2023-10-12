@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
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
                                    <h4 class="mb-0 font-size-18">Lead Campaigns</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Dashboard</a></li>
                                            <li class="breadcrumb-item">Lead Campaigns</li>
                                            <li class="breadcrumb-item active">{{$campaign_name->name}}</li>
                                        </ol>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header bg-soft-dark ">
                                        <i class="fas fa-edit"></i> {{$campaign_name->name}}
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('admin.campaignleadlist.store') }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('POST')
                                            <input type="hidden"  class="form-control" placeholder="Days" value="{{ $id }}" name="campaign_id">
                                            <div class="row">
                                                <div class="col-md-2">
                                                </div>
                                                <div class="col-md-7">
                                                    @php
                                                        $count = 1;      
                                                    @endphp
                                                    @if(count($campaignsList) > 0)
                                                        @foreach($campaignsList as $campaign)
                                                            <div class="card col-md-12" id="rowCount{{ $count }}">
                                                                <input type="hidden"  class="form-control" placeholder="Days" value="{{ $campaign->id }}" name="campaign_list_id[]">
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
                                                                                    <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                                                                                </div>
                                                                                <input type="number" min="0" class="form-control" placeholder="Days" value="{{ $campaign->send_after_days }}" name="send_after_days[]">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <div class="input-group mb-2">
                                                                                <div class="input-group-prepend">
                                                                                    <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                                                                                </div>
                                                                                <input type="number" min="0" class="form-control" placeholder="Hours" value="{{ $campaign->send_after_hours }}" name="send_after_hours[]">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #f00;padding: 10px 5px;" onclick="removeRow('{{ $count }}');">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group mt-3">
                                                                            <label>Campaign Type</label>
                                                                            <select class="custom-select" name="type[]" onchange="messageType(value,'{{ $count }}')" required>
                                                                                <option value="sms" @if($campaign->type == 'sms') selected @endif>SMS</option>
                                                                                <option value="email" @if($campaign->type == 'email') selected @endif>Email</option>
                                                                                <option value="mms" @if($campaign->type == 'mms') selected @endif>MMS</option>
                                                                                <option value="rvm" @if($campaign->type == 'rvm') selected @endif>RVM</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                {{-- <div class="form-group">
                                                                    <label>Media File (<small class="text-danger">Disregard if not sending MMS</small>)</label>
                                                                    <input type="file" class="form-control-file" name="media_file">
                                                                </div> --}}
                                                                <div class="show_sms_{{ $count }}">
                                                                    @if($campaign->type == 'sms')
                                                                        @php
                                                                            if($campaign->template_id > 0){
                                                                                $template = commonHelper::getBody($campaign->template_id);
                                                                                $body = $template->body;
                                                                            }else{
                                                                                $body = $campaign->body;
                                                                            }
                                                                        @endphp
                                                                        <div class="row">
                                                                            <div class="form-group" style=" display: none;">
                                                                                <label>Media File (<small class="text-danger">Disregard if not sending MMS</small>)</label>
                                                                                <input type="file" class="form-control-file" name="media_file{{ $count }}">
                                                                            </div>
                                                                            <input type="hidden" class="form-control" placeholder="Hours" value="" name="mediaUrl[]">
                                                                            <input type="hidden"  class="form-control" placeholder="Subject" value="" name="subject[]">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group ">
                                                                                    <label >Message</label>
                                                                                    <textarea id="template_text" class="form-control"  rows="10" name="body[]">{{ $body }}</textarea>
                                                                                    <div id='count' class="float-lg-right"></div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <small class="text-danger"><b>Use {name} {street} {city} {state} {zip} to substitute the respective fields</b></small>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @elseif($campaign->type == 'mms')
                                                                        @php
                                                                            if($campaign->template_id > 0){
                                                                                $template = commonHelper::getBody($campaign->template_id);
                                                                                $body = $template->body;
                                                                            }else{
                                                                                $body = $campaign->body;
                                                                            }
                                                                        @endphp
                                                                        <input type="hidden" class="form-control" placeholder="Hours" value="" name="mediaUrl[]">
                                                                        <input type="hidden"  class="form-control" placeholder="Subject" value="" name="subject[]">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label>Media File (<small class="text-danger">Disregard if not sending MMS</small>)</label>
                                                                                    <input type="file" class="form-control-file" name="media_file{{ $count }}">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <div class="form-group ">
                                                                                    <label >Message</label>
                                                                                    <textarea id="template_text" class="form-control"  rows="10" name="body[]">{{ $body }}</textarea>
                                                                                    <div id='count' class="float-lg-right"></div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <small class="text-danger"><b>Use {name} {street} {city} {state} {zip} to substitute the respective fields</b></small>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @elseif($campaign->type == 'email')
                                                                        @php
                                                                            if($campaign->template_id > 0){
                                                                                $template = commonHelper::getBody($campaign->template_id);
                                                                                $subject = $template->subject;
                                                                                $body = $template->body;
                                                                            }else{
                                                                                $subject = $campaign->subject;
                                                                                $body = $campaign->body;
                                                                            }
                                                                        @endphp
                                                                        <input type="hidden" class="form-control" placeholder="Hours" value="" name="mediaUrl[]">
                                                                        <div class="form-group" style=" display: none;">
                                                                            <label>Media File (<small class="text-danger">Disregard if not sending MMS</small>)</label>
                                                                            <input type="file" class="form-control-file" name="media_file{{ $count }}">
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group ">
                                                                                    <label >Subject</label>
                                                                                    <input type="text"  class="form-control" placeholder="Subject" value="{{ $subject }}" name="subject[]">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group ">
                                                                                    <label >Message</label>
                                                                                    <textarea id="template_text" class="form-control summernote-usage"  rows="10" name="body[]">{{ $body }}</textarea>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <small class="text-danger"><b>Use {name} {street} {city} {state} {zip} to substitute the respective fields</b></small>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @elseif($campaign->type == 'rvm')
                                                                        <input type="hidden" class="form-control" placeholder="Hours" value="" name="body[]">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group mt-3">
                                                                                    <label>RVM File</label>
                                                                                    <select class="custom-select" name="mediaUrl[]" required>
                                                                                        <option value="">Select RVM File</option>
                                                                                        @if(count($files) > 0)
                                                                                            @foreach($files as $file)
                                                                                                <option value="{{ $file->mediaUrl }}" @if($campaign->mediaUrl == $file->mediaUrl) selected @endif>{{ $file->name }}</option>
                                                                                            @endforeach
                                                                                        @endif
                                                                                        
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group" style=" display:none;">
                                                                            <label>Media File (<small class="text-danger">Disregard if not sending MMS</small>)</label>
                                                                            <input type="file" class="form-control-file" name="media_file{{ $count }}">
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="row">
                                                                        <div class="col-md-4 text-center">
                                                                        </div>
                                                                        <div class="col-md-4 text-center">
                                                                            <hr>
                                                                        </div>
                                                                        <div class="col-md-4 text-center">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @php
                                                                $count++;      
                                                            @endphp
                                                        @endforeach
                                                    @endif
                                                    <div class="addNewRow"></div>
                                                    {{-- Add Button --}}
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3 text-center">
                                                            </div>
                                                            <div class="col-md-6 text-center">
                                                                <button type="button" class="btn btn-primary mt-2" onclick="addNewRows(this.form);">Add new message to the sequence</button>
                                                            </div>
                                                            <div class="col-md-3 text-center">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <button type="submit" class="btn btn-primary mt-2" >Submit</button>
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
    <link rel="stylesheet" href="{{asset('/summernote/dist/summernote.css')}}" />
    <script src="{{asset('/summernote/dist/summernote.min.js')}}"></script>
    <script >
        $(".summernote-usage").summernote({
    	    height: 200,
    	});
        $(document).ready(function() {
            $('#datatable').DataTable();
        } );

        var rowCount = {{ count($campaignsList)  }}
        function addNewRows(frm) {
            rowCount ++;
            var recRow = '<div id="rowCount'+rowCount+'" class="col-lg-12"><div class="card col-md-12"><div class="row"><div class="col-md-3"><div class="form-group text-right mt-2"><label>Delay</label></div></div><div class="col-md-3"><div class="form-group"><div class="input-group mb-2"><div class="input-group-prepend"><div class="input-group-text"><i class="fas fa-calendar"></i></div></div><input type="number" min="0" class="form-control" placeholder="Days" name="send_after_days[]"></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group mb-2"><div class="input-group-prepend"><div class="input-group-text"><i class="fas fa-calendar"></i></div></div><input type="number" min="0" class="form-control" placeholder="Hours" name="send_after_hours[]"></div></div></div><div class="col-md-3"><button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #f00;padding: 10px 5px;" onclick="removeRow('+rowCount+');"><i class="fas fa-trash"></i></button></div></div><div class="row"><div class="col-md-12"><div class="form-group mt-3"><input type="hidden"  class="form-control" placeholder="Days" value="0" name="campaign_list_id[]"><label>Campaign Type</label><select class="custom-select" name="type[]"  onchange="messageType(value,'+rowCount+');" required><option value="sms">SMS</option><option value="email">Email</option><option value="mms">MMS</option><option value="rvm">RVM</option></select></div></div></div><div class="row show_sms_'+rowCount+'"><div class="col-md-12"><div class="form-group "><div class="form-group" style=" display: none;"><label>Media File (<small class="text-danger">Disregard if not sending MMS</small>)</label><input type="file" class="form-control-file" name="media_file'+rowCount+'"></div><input type="hidden" class="form-control" placeholder="Hours" value="" name="mediaUrl[]"><input type="hidden"  class="form-control" placeholder="Subject" value="" name="subject[]"><label >Message</label><textarea id="template_text" class="form-control"  rows="10" name="body[]"></textarea><div id="count" class="float-lg-right"></div></div><div class="form-group"><small class="text-danger"><b>Use {name} {street} {city} {state} {zip} to substitute the respective fields</b></small></div></div></div></div><div class="col-md-12"><div class="row"><div class="col-md-4 text-center"></div><div class="col-md-4 text-center"><hr></div><div class="col-md-4 text-center"></div></div></div></div></div>';
            //var recRow = '<div id="rowCount'+rowCount+'" class="col-lg-12"><div class="card col-md-12"><div class="row"><div class="col-md-12"><button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #f00;" onclick="removeRow('+rowCount+');"><i class="fas fa-trash"></i></button><div class="form-group mt-3"><label>Campaign Type</label><select class="custom-select" name="type[]" onchange="" required><option value="sms">SMS</option><option value="email">Email</option><option value="mms">MMS</option><option value="rvm">RVM</option></select></div></div></div><div class="row"><div class="col-md-3"><div class="form-group text-right mt-2"><label>Delays</label></div></div><div class="col-md-3"><div class="form-group"><div class="input-group mb-2"><div class="input-group-prepend"><div class="input-group-text"><i class="fas fa-calendar"></i></div></div><input type="number" min="0" class="form-control" placeholder="Days" name="send_after_days[]"></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group mb-2"><div class="input-group-prepend"><div class="input-group-text"><i class="fas fa-calendar"></i></div></div><input type="number" min="0" class="form-control" placeholder="Hours" name="send_after_hours[]"></div></div></div><div class="col-md-3"></div></div><div class="row show_sms"><div class="col-md-12"><div class="form-group "><label >Message</label><textarea id="template_text" class="form-control"  rows="10" required name="message"></textarea><div id="count" class="float-lg-right"></div></div></div></div><div class="row show_email" style="display:none;"><div class="col-md-6"><div class="form-group"><label >Subject</label><input type="text"  class="form-control" placeholder="Subject" name="receiver_number" /></div></div><div class="col-md-12"><div class="form-group "><label >Message</label><textarea id="template_text" class="form-control"  rows="10" required name="message"></textarea><div id="count" class="float-lg-right"></div></div></div></div><div class="row show_mms" style="display:none;"><div class="col-md-6"><div class="form-group"><label>Media File (<small class="text-danger">Disregard if not sending MMS</small>)</label><input type="file" class="form-control-file" name="media_file"></div></div><div class="col-md-12"><div class="form-group "><label >Message</label><textarea id="template_text" class="form-control"  rows="10" required name="message"></textarea><div id="count" class="float-lg-right"></div></div></div></div><div class="row show_rvm" style="display:none;"><div class="col-md-6"><div class="form-group"><label>Media File (<small class="text-danger">Disregard if not sending MMS</small>)</label><input type="file" class="form-control-file" name="media_file[]"></div></div></div><div class="col-md-12"><div class="row"><div class="col-md-4 text-center"></div><div class="col-md-4 text-center"><hr></div><div class="col-md-4 text-center"></div></div></div></div></div>';
            jQuery('.addNewRow').append(recRow);

        }

        function removeRow(removeNum) {
            jQuery('#rowCount'+removeNum).remove();
        }

    </script>
    <script>
        function showDiv(divId, element)
        {
            document.getElementById(divId).style.display = element.value == 1 ? 'block' : 'none';
        }
        function templateId() {
            template_id = document.getElementById("template-select").value;
           setTextareaValue(template_id)
        }
    </script>
    <script>
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
            var url = '<?php echo url('/admin/get/leadmessage/') ?>/'+type+'/'+id;
            //alert(url);
            $.ajax({
                type: 'GET',
                url: url,
                data: '',
                processData: false,
                contentType: false,
                success: function (d) {
                    $('.show_sms_'+id).html(d);
                }
            });
        }
    </script>
    @endsection
