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
                                    <h4 class="mb-0 font-size-18">Custom Fields</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Dashboard</a></li>
                                            <li class="breadcrumb-item">Custom Fields</li>
                                            <li class="breadcrumb-item active">Custom Fields</li>
                                        </ol>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header bg-soft-dark ">
                                        <i class="fas fa-edit"></i> Custom Fields
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('admin.field.store') }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('POST')
                                            <div class="row">
                                                <div class="col-md-2">
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="card col-md-12">
                                                        @php
                                                            $count = 1;
                                                        @endphp
                                                        @if(count($customfields) > 0)
                                                            @foreach($customfields as $field)
                                                                <div id="rowCount{{ $count }}" class="col-lg-12">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #f00;padding: 10px 5px;" onclick="removeRow('{{ $count }}');">
                                                                                <i class="fas fa-trash"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <input type="hidden"  class="form-control" placeholder="Days" value="{{ $field->id }}" name="field_list_id[]">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="form-group mt-3">
                                                                                <label>Select Section</label>
                                                                                <select class="custom-select" name="section_id[]" required>
                                                                                @foreach($sections as $section)
                                                                                    <option value="{{ $section->id }}" @if($section->id == $field->section_id) selected @endif>{{ $section->name }}</option>
                                                                                @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="form-group mt-3">
                                                                            <label>Field Label</label>
                                                                            <input type="text" class="form-control" name="label[]" placeholder="Field Label" value="{{ $field->label }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="form-group mt-3">
                                                                                <label>Field Type</label>
                                                                                <select class="custom-select" name="type[]" required>
                                                                                    <option value="text" @if($field->type == 'text') selected="selected" @endif>Text</option>
                                                                                    <option value="number" @if($field->type == 'number') selected="selected" @endif>Number</option>
                                                                                    <option value="date" @if($field->type == 'date') selected="selected" @endif>Date</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
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
                                                    </div>
                                                    <div class="addNewRow"></div>
                                                    {{-- Add Button --}}
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3 text-center">
                                                            </div>
                                                            <div class="col-md-6 text-center">
                                                                <button type="button" class="btn btn-primary mt-2" onclick="addNewRows(this.form);">Add New Custom Field</button>
                                                            </div>
                                                            <div class="col-md-3 text-center">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <button type="submit" class="btn btn-primary mt-2 btn-submit"  @if(count($customfields) == 0) disabled @endif>Submit</button>
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
        var rowCount = {{ count($customfields)  }}
        function addNewRows(frm) {
            rowCount ++;
            var recRow = '<div id="rowCount'+rowCount+'" class="col-lg-12"><div class="row"><div class="col-md-12"><button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #f00;padding: 10px 5px;" onclick="removeRow('+rowCount+');"><i class="fas fa-trash"></i></button></div></div><div class="row"><input type="hidden"  class="form-control" placeholder="Days" value="0" name="field_list_id[]"><div class="col-md-12"><div class="form-group"><label>Select Section</label><select class="custom-select" name="section_id[]" required> @foreach($sections as $section) <option value="{{ $section->id }}">{{ $section->name }}</option> @endforeach </select></div></div></div><div class="row"><div class="col-md-12"><div class="form-group mt-3"><label>Field Label</label><input type="text" class="form-control" name="label[]"></div></div></div><div class="row"><div class="col-md-12"><div class="form-group mt-3"><label>Field Type</label><select class="custom-select" name="type[]" required><option value="text" >Text</option><option value="number">Number</option><option value="date">Date</option></select></div></div></div><div class="col-md-12"><div class="row"><div class="col-md-4 text-center"></div><div class="col-md-4 text-center"><hr></div><div class="col-md-4 text-center"></div></div></div></div></div>';
            //var recRow = '<div id="rowCount'+rowCount+'" class="col-lg-12"><div class="card col-md-12"><div class="row"><div class="col-md-12"><button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #f00;" onclick="removeRow('+rowCount+');"><i class="fas fa-trash"></i></button><div class="form-group mt-3"><label>Campaign Type</label><select class="custom-select" name="type[]" onchange="" required><option value="sms">SMS</option><option value="email">Email</option><option value="mms">MMS</option><option value="rvm">RVM</option></select></div></div></div><div class="row"><div class="col-md-3"><div class="form-group text-right mt-2"><label>Delays</label></div></div><div class="col-md-3"><div class="form-group"><div class="input-group mb-2"><div class="input-group-prepend"><div class="input-group-text"><i class="fas fa-calendar"></i></div></div><input type="number" min="0" class="form-control" placeholder="Days" name="send_after_days[]"></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group mb-2"><div class="input-group-prepend"><div class="input-group-text"><i class="fas fa-calendar"></i></div></div><input type="number" min="0" class="form-control" placeholder="Hours" name="send_after_hours[]"></div></div></div><div class="col-md-3"></div></div><div class="row show_sms"><div class="col-md-12"><div class="form-group "><label >Message</label><textarea id="template_text" class="form-control"  rows="10" required name="message"></textarea><div id="count" class="float-lg-right"></div></div></div></div><div class="row show_email" style="display:none;"><div class="col-md-6"><div class="form-group"><label >Subject</label><input type="text"  class="form-control" placeholder="Subject" name="receiver_number" /></div></div><div class="col-md-12"><div class="form-group "><label >Message</label><textarea id="template_text" class="form-control"  rows="10" required name="message"></textarea><div id="count" class="float-lg-right"></div></div></div></div><div class="row show_mms" style="display:none;"><div class="col-md-6"><div class="form-group"><label>Media File (<small class="text-danger">Disregard if not sending MMS</small>)</label><input type="file" class="form-control-file" name="media_file"></div></div><div class="col-md-12"><div class="form-group "><label >Message</label><textarea id="template_text" class="form-control"  rows="10" required name="message"></textarea><div id="count" class="float-lg-right"></div></div></div></div><div class="row show_rvm" style="display:none;"><div class="col-md-6"><div class="form-group"><label>Media File (<small class="text-danger">Disregard if not sending MMS</small>)</label><input type="file" class="form-control-file" name="media_file[]"></div></div></div><div class="col-md-12"><div class="row"><div class="col-md-4 text-center"></div><div class="col-md-4 text-center"><hr></div><div class="col-md-4 text-center"></div></div></div></div></div>';
            jQuery('.addNewRow').append(recRow);
            jQuery(".btn-submit").removeAttr("disabled")
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
            var url = '<?php echo url('/admin/get/message/') ?>/'+type+'/'+id;
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
