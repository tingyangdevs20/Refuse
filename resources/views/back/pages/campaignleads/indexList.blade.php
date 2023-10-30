@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
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
                        <h4 class="mb-0 font-size-18">Lead Campaign Messages</h4>
                       
                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                         {{ $campaign_name->name }}
                            <button class="btn btn-outline-primary btn-sm float-right" title="New" data-toggle="modal"
                                data-target="#newModal"><i class="fas fa-plus-circle"></i></button>


                            {{-- <button class="btn btn-outline-primary btn-sm float-right" title="helpModal" data-toggle="modal"
                                    data-target="#helpModal">How to Use</button> --}}
                            @include('components.modalform')
                        </div>
                        <div class="card-body">
                            <input id="tmp_type" style="display:none" value="" />
                            <table class="table table-striped table-bordered" id="datatable">
                                <thead>
                                    <tr>

                                    <th scope="col">Order</th>
                                        <th scope="col">Delay</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Message</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php 
                                    $cnt=1
                                    @endphp

                                    @if ($campaignsList != null)
                                    
                                        @foreach ($campaignsList as $campaignsLst)
                                            <tr>
                                                <td>{{$cnt}}</td>
                                                <td>{{ $campaignsLst->send_after_days }} Days - {{ $campaignsLst->send_after_hours }} Hours</td>
                                                <td>{{ strip_tags($campaignsLst->type) }}</td>
                                                @if($campaignsLst->type=='rvm')
                                                <td>{{$campaignsLst->subject}}</td>
                                                @elseif($campaignsLst->type!='rvm')
                                                <td>{{ strip_tags($campaignsLst->body) }}</td>
                                                @endif
                                                <td>
                                                    <button class="btn btn-outline-primary btn-sm edit-template"
                                                       
                                                        data-id="{{ $campaignsLst->id }}" data-toggle="modal"
                                                        data-type="{{ $campaignsLst->type }}"
                                                                    data-body="{{ $campaignsLst->body }}"
                                                                    data-subject="{{ $campaignsLst->subject }}" 
                                                                    data-send_after_days="{{ $campaignsLst->send_after_days }}"
                                                                    data-send_after_hours="{{ $campaignsLst->send_after_hours }}"
                                                                    
                                                        data-target="#editModal"><i class="fas fa-edit"></i></button>
                                                    -
                                                    <button class="btn btn-outline-danger btn-sm"
                                                       
                                                        data-id="{{ $campaignsLst->id }}" data-toggle="modal"
                                                        data-target="#deleteModal"><i
                                                            class="fas fa-times-circle"></i></button>
                                                </td>
                                            </tr>
                                            @php 
                                            $cnt++
                                            @endphp
                                        @endforeach
                                    @endif
                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
    {{-- Modals --}}
    {{-- Modal New --}}
    <div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="exampleModalLabel">Add New Message To Sequence</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.campaignleadlist.store') }}" method="POST" enctype="multipart/form-data">

                    <div class="modal-body">
                        @csrf
                        @method('POST')
                        <input name="camp_id" style="display:none" value="{{ $id }}" />
                        <input name="type" style="display:none" value="" />
                        <div class="form-group">
                        <div class="row">
                                                                    <div class="col-md-3">
                                                                        <div class="form-group text-right mt-2">
                                                                            <label>Delay</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group" style="width:115px">
                                                                            <div class="input-group mb-3">
                                                                                <div class="input-group-prepend">
                                                                                    <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                                                                                </div>
                                                                                <input  type="number" min="0" class="form-control" placeholder="Days" value="0" name="send_after_days">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group" style="width:120px">
                                                                            <div class="input-group mb-3">
                                                                                <div class="input-group-prepend">
                                                                                    <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                                                                                </div>
                                                                                <input type="number" min="0" class="form-control" placeholder="Hours" value="0" name="send_after_hours">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                  
                                                                </div>
                        </div>
                        <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group mt-3">
                                                                            <label>Select Message Type</label>
                                                                            <select class="custom-select" name="type" onchange="check_type(this)" required>
                                                                            
                                                                            <option value="sms">SMS</option>
                                                                                <option value="email">Email</option>
                                                                                <option value="mms">MMS</option>
                                                                                <option value="rvm">RVM</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row" id="dvSubject" style="display:none">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group ">
                                                                                    <label >Subject</label>
                                                                                    <input type="text"  class="form-control" required placeholder="Subject" value="" name="subject">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row" id="dvMessage">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label >Message</label>
                                                                                    <textarea id="body" class="form-control summernote-usage" required  rows="10" name="body"></textarea>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <small class="text-danger"><b>Use {name} {street} {city} {state} {zip} to substitute the respective fields</b></small>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                       
                                                                        <div class="form-group" style=" display: none;">
                                                                            <label>Media File (<small class="text-danger">Disregard if not sending MMS</small>)</label>
                                                                            <input type="file" class="form-control-file" name="media_file">
                                                                        </div>
                                                                     </div>
                                                                <div class="row" id="dvRvm" style="display:none">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group mt-3">
                                                                            <label>Select RVM</label>
                                                                            <select class="custom-select" name="rvm"  required>
                                                                            <option value="0">Select RVM File</option>
                                                                            @foreach ($files as $rvm)
                                                                            <option value="{{$rvm->name}}">{{$rvm->name}}</option>
                                                                            @endforeach
                                                                                
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                        <div class="show_media_mms" id="dvMediaFile" style="display:none;">
                            <div class="form-group">
                                <label>Media File (<small class="text-danger">Disregard if not sending MMS</small>)</label>
                                <input type="file" class="form-control-file" name="media_file_mms">
                            </div>
                           
                            
                        </div>
                       
                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- End Modal New --}}
    {{-- Modal Edit --}}
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="exampleModalLabel">Update Message To Sequence</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.campaignleadlist.update') }}" method="POST" enctype="multipart/form-data">

                    <div class="modal-body">
                        @csrf
                        @method('POST')
                        <input name="cid" id="cid" style="display:none" value="" />
                        
                        <div class="form-group">
                        <div class="row">
                                                                    <div class="col-md-3">
                                                                        <div class="form-group text-right mt-2">
                                                                            <label>Delay</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group" style="width:115px">
                                                                            <div class="input-group mb-3">
                                                                                <div class="input-group-prepend">
                                                                                    <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                                                                                </div>
                                                                                <input  type="number" min="0" class="form-control" placeholder="Days" value="" name="send_after_days_edit" id="send_after_days_edit">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group" style="width:120px">
                                                                            <div class="input-group mb-3">
                                                                                <div class="input-group-prepend">
                                                                                    <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                                                                                </div>
                                                                                <input type="number" min="0" class="form-control" placeholder="Hours" value="" id="send_after_hours_edit" name="send_after_hours_edit">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                  
                                                                </div>
                        </div>
                        <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group mt-3">
                                                                            <label>Select Message Type</label>
                                                                            <select class="custom-select" name="type_edit" id="type_edit" onchange="check_type_edit(this)" required>
                                                                            
                                                                            <option value="sms">SMS</option>
                                                                                <option value="email">Email</option>
                                                                                <option value="mms">MMS</option>
                                                                                <option value="rvm">RVM</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row" id="dvSubject2" style="display:none">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group ">
                                                                                    <label >Subject</label>
                                                                                    <input type="text"  class="form-control" required placeholder="Subject" value="" name="subject_edit" id="subject_edit">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row" id="dvMessage2">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label >Message</label>
                                                                                    <textarea id="body" class="form-control summernote-usage" required  rows="10" id="body_edit"  name="body_edit"></textarea>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <small class="text-danger"><b>Use {name} {street} {city} {state} {zip} to substitute the respective fields</b></small>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                       
                                                                        <div class="form-group" style=" display: none;">
                                                                            <label>Media File (<small class="text-danger">Disregard if not sending MMS</small>)</label>
                                                                            <input type="file" class="form-control-file" name="media_file_edit" id="media_file_edit">
                                                                        </div>
                                                                     </div>
                                                                <div class="row" id="dvRvm2" style="display:none">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group mt-3">
                                                                            <label>Select RVM</label>
                                                                            <select class="custom-select" name="rvm_edit" id="rvm_edit"  required>
                                                                            <option value="0">Select RVM File</option>
                                                                            @foreach ($files as $rvm)
                                                                            <option value="{{$rvm->name}}">{{$rvm->name}}</option>
                                                                            @endforeach
                                                                                
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                        <div class="show_media_mms" id="dvMediaFile2" style="display:none;">
                            <div class="form-group">
                                <label>Media File (<small class="text-danger">Disregard if not sending MMS</small>)</label>
                                <input type="file" class="form-control-file" name="media_file_mms">
                            </div>
                           
                            
                        </div>
                       
                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- End Modal Edit --}}

    {{-- Modal Add on 31-08-2023 --}}
    <div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">How to Use</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>

                </div>

                <div class="modal-body">

                    <div style="position:relative;height:0;width:100%;padding-bottom:65.5%">

                    </div>
                    <form action="" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input id="tmpid" style="display:none" value="{{ $id }}" />
                        <div class="form-group">
                            <label>Video Url</label>
                        </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    {{-- End Modal on 31-08-2023 --}}

    {{-- Modal Delete --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Campaign Message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.campaignlead.remove') }}" method="post" id="editForm">
                    @method('POST')
                    @csrf
                    <div class="modal-body">
                        <div class="modal-body">
                            <p class="text-center">
                                Are you sure you want to delete this?
                            </p>
                            <input type="hidden" id="id" name="id" value="">
                            <input name="tmpid" style="display:none" value="{{ $id }}" />
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
   

    {{-- End Modals --}}
@endsection
@section('scripts')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    <link rel="stylesheet" href="{{ asset('/summernote/dist/summernote-bs4.css') }}" />
    <script src="{{ asset('/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script>

        function check_type(ctrl)
        {
            //alert(ctrl.value);
            if(ctrl.value=='rvm')
            {
                $("#dvRvm").show();
                $("#dvMediaFile").hide();
                $("#dvSubject").hide();
                $("#dvMessage").hide();
            }
            else if(ctrl.value=='mms')//
            {
                $("#dvMediaFile").show();
                $("#dvRvm").hide();
                $("#dvSubject").hide();
                $("#dvMessage").show();
            }
            else if(ctrl.value=='sms')//
            {
                $("#dvMediaFile").hide();
                $("#dvRvm").hide();
                $("#dvSubject").hide();
                $("#dvMessage").show();
            }
            else
            {
                $("#dvMessage").show();
                $("#dvRvm").hide();
                $("#dvMediaFile").hide();
                $("#dvSubject").show();
            }
        }
        function check_type_edit(ctrl)
        {
           // alert(ctrl.value);
            if(ctrl.value=='rvm')
            {
                $("#dvRvm2").show();
                $("#dvMediaFile2").hide();
                $("#dvSubject2").hide();
                $("#dvMessage2").hide();
            }
            else if(ctrl.value=='mms')//
            {
                $("#dvMediaFile2").show();
                $("#dvRvm2").hide();
                $("#dvSubject2").hide();
                $("#dvMessage2").show();
            }
            else if(ctrl.value=='sms')//
            {
                $("#dvMediaFile2").hide();
                $("#dvRvm2").hide();
                $("#dvSubject2").hide();
                $("#dvMessage2").show();
            }
            else
            {
                $("#dvSubject2").show();
                $("#dvMessage2").show();
                $("#dvRvm2").hide();
                $("#dvMediaFile2").hide();
                
            }
        }
        
        

        
        $(document).ready(function() {
            $('#datatable').DataTable();
        });
    </script>
    <script>
        $('#editModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var body = button.data('body');
            var type = button.data('type');
            var id = button.data('id');
            var subject = button.data('subject');
            var send_after_days=button.data('send_after_days');
            var send_after_hours=button.data('send_after_hours');
            var mediaurl = button.data('mediaurl');

            if(type=="email")
            {
                $("#dvSubject2").show();
                $("#dvMessage2").show();
                $("#dvRvm2").hide();
                $("#dvMediaFile2").hide();
            }
            else if(type=="sms" )
            {
                $("#dvSubject2").hide();
                $("#dvMessage2").show();
                $("#dvRvm2").hide();
                $("#dvMediaFile2").hide();
            }
            else if(type=="mms")
            {
                $("#dvSubject2").hide();
                $("#dvMessage2").show();
                $("#dvRvm2").hide();
                $("#dvMediaFile2").show();
            }
            else 
            {
                $("#dvSubject2").hide();
                $("#dvMessage2").hide();
                $("#dvRvm2").show();
                $("#dvMediaFile2").hide();
            }
           

           // alert(type);
            
            var modal = $(this);
            modal.find('.modal-body #send_after_days').val(send_after_days);
            modal.find('.modal-body #send_after_hours').val(send_after_hours);
            modal.find('.modal-body #subject').val(subject);
            modal.find('.modal-body #body').val(body);
            modal.find('.modal-body #type').val(type);
            modal.find('.modal-body #cid').val(id);
           
         


        });
        $('#deleteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
        });

      

       
    </script>
@endsection
