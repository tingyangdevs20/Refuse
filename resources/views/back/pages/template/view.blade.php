@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet"/>
    
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
                        <h4 class="mb-0 font-size-18">Template Messages</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Dashboard</a></li>
                                <li class="breadcrumb-item">Lead Generations</li>
                                <li class="breadcrumb-item active">Templates</li>
                            </ol>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            Template Messages
                            <button class="btn btn-outline-primary btn-sm float-right" title="New" data-toggle="modal"
                                    data-target="#newModal"><i class="fas fa-plus-circle"></i></button>


                             <button class="btn btn-outline-primary btn-sm float-right" title="helpModal" data-toggle="modal"
                                    data-target="#helpModal">Use this Section</button>
                        </div>
                        <div class="card-body">
                        <input id="tmp_type" style="display:none" value="{{ $type }}"/>
                            <table class="table table-striped table-bordered" id="datatable">
                                <thead>
                                <tr>
                                   
                                    <th scope="col">Message Title</th>
                                    <th scope="col">Content</th>
                                   
                                    
                                  
                                    
                                    <!--<th scope="col">Media URL</th>-->
                                    <th scope="col">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @if($templates!=null)
                                   
                                @foreach($templates as $template)
                                    <tr>
                                    
                                        <td>{{ $template->msg_title }}</td>
                                        <td>{{ strip_tags($template->msg_content) }}</td>
                                        
                                        
                                       
                                        <td>
                                            <button class="btn btn-outline-primary btn-sm edit-template" title="Edit {{ $template->msg_title }}" data-title="{{ $template->msg_title }}" data-mediaurl="{{ $template->mediaUrl }}"   data-subject="{{ $template->subject }}" data-body="{{ htmlspecialchars_decode(stripslashes($template->message_content)) }}" data-id="{{ $template->id }}"  data-toggle="modal" data-target="#editModal"><i class="fas fa-edit"></i></button>
                                            -
                                            <button class="btn btn-outline-danger btn-sm" title="Remove {{ $template->msg_title }}" data-id="{{ $template->id }}" data-toggle="modal" data-target="#deleteModal"><i class="fas fa-times-circle"></i></button>
                                        </td>
                                    </tr>
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
    {{--Modals--}}
    {{--Modal New--}}
    <div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                
                    <h5 class="modal-title" id="exampleModalLabel">Add New Message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.template.savemsg') }}" method="POST" enctype="multipart/form-data">

                    <div class="modal-body">
                        @csrf
                        @method('POST')
                        <input name="tmpid" style="display:none" value="{{ $id }}"/>
                        <input name="type" style="display:none" value="{{ $type }}"/>
                        <div class="form-group">
                            <label>Message Title</label>
                            <input type="text" class="form-control" name="title" placeholder="Enter Message Title"
                                   required>
                        </div>
                       
                      
                      
                        
                        
                        <div class="show_media_mms" style="display:none;">
                            <div class="form-group">
                                <label>Media File (<small class="text-danger">Disregard if not sending MMS</small>)</label>
                                <input type="file" class="form-control-file" name="media_file_mms">
                            </div>
                            <div class="form-group">
                                <label>Content</label>
                                <textarea class="form-control text111 mms_body" name="mms_body" rows="10"></textarea>
                                <div id='count111' class="float-lg-right"></div>
                            </div>
                            <div class="form-group">
    
                                <small class="text-danger"><b>Use {name} {street} {city} {state} {zip} to substitute the
                                        respective fields</b></small>
                            </div>
                        </div>
                        <div class="show_sms" style="display:none;">
                            <div class="form-group">
                                <label>Content</label>
                                <textarea class="form-control text1 body_sms" name="body" rows="10"></textarea>
                                <div id='count' class="float-lg-right"></div>
                            </div>
                            <div class="form-group">
    
                                <small class="text-danger"><b>Use {name} {street} {city} {state} {zip} to substitute the
                                        respective fields</b></small>
                            </div>
                        </div>
                        <div class="show_email" style="display:none;">
                            <div class="form-group">
                                <label>Subject</label>
                                <input type="text" class="form-control email_body" name="subject" placeholder="Enter Subject" >
                            </div>
                            <div class="form-group">
                                <label>Content</label>
                                <textarea class="form-control email_body summernote-usage" name="email_body" rows="10"></textarea>
                                <!--<div id='count11' class="float-lg-right"></div>-->
                            </div>
                            <div style="display:none" class="form-group">
    
                                <small class="text-danger"><b>Use {name} {street} {city} {state} {zip} to substitute the
                                        respective fields</b></small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--End Modal New--}}

    {{--Modal Add on 31-08-2023--}}
    <div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Use this Section</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        
      </div>
     
      <div class="modal-body">
            
        <div style="position:relative;height:0;width:100%;padding-bottom:65.5%">
        
        </div>
        <form action="" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input id="tmpid" style="display:none" value="{{ $id }}"/>
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
    {{--End Modal on 31-08-2023--}}

    {{--Modal Edit--}}
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Template</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.template.update','test') }}" method="post" id="editForm" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <input id="tmpid" style="display:none" value="{{ $id }}"/>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Message Title</label>
                            <input type="hidden" id="id" name="id" value="">
                            <input type="text" class="form-control" name="title" id="title" required>
                        </div>
                        
                        <div class="email_body_edit" style="display:none;">
                            
                            <div class="form-group">
                                <label>Content</label>
                                <textarea class="form-control text112 mms_body" id="mms_body_edit" name="mms_body" rows="10"></textarea>
                                <div id='count112' class="float-lg-right"></div>
                            </div>
                            <div class="form-group">
    
                                <small class="text-danger"><b>Use {name} {street} {city} {state} {zip} to substitute the
                                        respective fields</b></small>
                            </div>
                        </div>
                       
                        <!--//////-->
                       
                        <div class="show_media_mms_edit" style="display:none;">
                            <div class="form-group">
                                <label>Media File (<small class="text-danger">Disregard if not sending MMS</small>)</label>
                                <input type="file" class="form-control-file" name="media_file_mms">
                                <label>(<small class="text-danger font-weight-bold file-name"></small>)</label>
                            </div>
                            <div class="form-group">
                                <label>Content</label>
                                <textarea class="form-control text112 mms_body" id="mms_body_edit" name="mms_body" rows="10"></textarea>
                                <div id='count112' class="float-lg-right"></div>
                            </div>
                            <div class="form-group">
    
                                <small class="text-danger"><b>Use {name} {street} {city} {state} {zip} to substitute the
                                        respective fields</b></small>
                            </div>
                        </div>
                        <div class="show_sms_edit" style="display:none;">
                            <div class="form-group">
                                <label>Content</label>
                                <textarea class="form-control text2 body_sms_edit" id="body_sms" name="body" rows="10"></textarea>
                                <div id='count2' class="float-lg-right"></div>
                            </div>
                            <div class="form-group">
    
                                <small class="text-danger"><b>Use {name} {street} {city} {state} {zip} to substitute the
                                        respective fields</b></small>
                            </div>
                        </div>
                       

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--End Modal Edit--}}
    {{--Modal Delete--}}
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Template</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.template.msg.destroy') }}" method="post" id="editForm">
                    @method('DELETE')
                    @csrf
                    <div class="modal-body">
                        <div class="modal-body">
                            <p class="text-center">
                                Are you sure you want to delete this?
                            </p>
                            <input type="hidden" id="id" name="id" value="">
                            <input name="tmpid" style="display:none" value="{{ $id }}"/>
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
    {{--End Modal Delete--}}

    {{--End Modals--}}
@endsection
@section('scripts')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    <link rel="stylesheet" href="{{asset('/summernote/dist/summernote-bs4.css')}}" />
    <script src="{{asset('/summernote/dist/summernote-bs4.min.js')}}"></script>
    <script>
        var typ=$("#tmp_type").val();
        messageType(typ);
        messageTypeEdit(typ);
        //alert(typ);
        $(".summernote-usage").summernote({
    	    height: 200,
    	});
        function messageType(val){
            if(val === 'SMS'){
                $(".email_body").removeAttr("required");
                $(".body_sms").attr("required", "true");
                
                $('.show_media').hide();
                $('.show_email').hide();
              
                $('.show_media_mms').hide();
                $('.show_sms').show();
            }else if(val === 'MMS'){
                $(".body_sms").removeAttr("required");
                $(".email_body").removeAttr("required");
                $('.show_email').hide();
                $('.show_sms').hide();
               
                $('.show_media_mms').show();
            }else if(val === 'Email'){
                $(".body_sms").removeAttr("required");
                $(".email_body").attr("required", "true");
                $('.show_sms').hide();
                $('.show_media').hide();
                
                $('.show_media_mms').hide();
                $('.show_email').show();
            }
        }
        function messageTypeEdit(val){
            if(val === 'SMS'){
                $(".email_body_edit").removeAttr("required");
                $(".body_sms_edit").attr("required", "true");
               
                $('.show_media_mms_edit').hide();
                $('.show_email_edit').hide();
                $('.show_sms_edit').show();
            }else if(val === 'MMS'){
                $(".body_sms_edit").removeAttr("required");
                $(".email_body_edit").removeAttr("required");
                $('.show_email_edit').hide();
                $('.show_sms_edit').hide();
               
                $('.show_media_mms_edit').show();
                
            }else if(val === 'Email'){
                $(".body_sms_edit").removeAttr("required");
                $(".email_body_edit").attr("required", "true");
                $('.show_sms_edit').hide();
               
                $('.show_media_mms_edit').hide();
                $('.show_email_edit').show();
            }
        }
        $(document).ready(function () {
            $('#datatable').DataTable();
        });
        
       
        
    </script>
    <script>
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);// Button that triggered the modal
            var title = button.data('title');
            var body = button.data('body');
            var id = button.data('id');
            var subject = button.data('subject');
            var mediaurl = button.data('mediaurl');
            var modal = $(this);
            if(typ === 'SMS'){
                $(".email_body").removeAttr("required");
                $(".body_sms").attr("required", "true");
        
                $('.show_media_mms_edit').hide();
                $('.show_email_edit').hide();
                $('.show_sms_edit').show();
                modal.find('.modal-body #body_sms').val(body);
            }else if(typ === 'MMS'){
                alert(body);
                $(".body_sms").removeAttr("required");
                $(".email_body").removeAttr("required");
                $('.show_email_edit').hide();
                $('.show_sms_edit').hide();
               
                $('.show_media_mms_edit').show();
                modal.find('.modal-body #mms_body_edit').val(body);
                $('.file-name').html(mediaurl);
            }else if(typ === 'Email'){
                $(".body_sms").removeAttr("required");
                $(".email_body").attr("required", "true");
                $('.show_sms_edit').hide();
                
                $('.show_media_mms_edit').hide();
                $('.show_email_edit').show();
                modal.find('.modal-body #subject').val(subject);
                $('#body_email').summernote ('code', body);
                //$('#body_email').val(body);
            }
            modal.find('.modal-body #title').val(title);
            
            modal.find('.modal-body #id').val(id);
            
           

        });
        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
        });

        const textarea1 = document.querySelector('.text1')
        const count = document.getElementById('count')
        textarea1.onkeyup = (e) => {
            count.innerHTML = "Characters: "+e.target.value.length+"/160";
        };

        const textarea2 = document.querySelector('.text2')
        const count2 = document.getElementById('count2')
        textarea2.onkeyup = (e) => {
            count2.innerHTML = "Characters: "+e.target.value.length+"/160";
        };
        
        // const textarea11 = document.querySelector('.text11')
        // const count11 = document.getElementById('count11')
        // textarea11.onkeyup = (e) => {
        //     count11.innerHTML = "Characters: "+e.target.value.length+"/160";
        // };
        const textarea111 = document.querySelector('.text111')
        const count111 = document.getElementById('count111')
        textarea111.onkeyup = (e) => {
            count111.innerHTML = "Characters: "+e.target.value.length+"/160";
        };
        const textarea112 = document.querySelector('.text112')
        const count112 = document.getElementById('count112')
        textarea112.onkeyup = (e) => {
            count112.innerHTML = "Characters: "+e.target.value.length+"/160";
        };
        
        
    </script>
@endsection
