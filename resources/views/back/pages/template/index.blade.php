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
                        <h4 class="mb-0 font-size-18">SMS/MMS Templates</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Dashboard</a></li>
                                <li class="breadcrumb-item">Settings</li>
                                <li class="breadcrumb-item active">SMS/MMS Templates</li>
                            </ol>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            All Templates
                            <button class="btn btn-outline-primary btn-sm float-right" title="New" data-toggle="modal"
                                    data-target="#newModal"><i class="fas fa-plus-circle"></i></button>


                             <button class="btn btn-outline-primary btn-sm float-right" title="helpModal" data-toggle="modal"
                                    data-target="#helpModal">How to Use</button>
                                    @include('components.modalform')
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered" id="datatable">
                                <thead>
                                <tr>
                                   
                                    <th scope="col">Template Name</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Message Count</th>
                                  
                                    
                                    <!--<th scope="col">Media URL</th>-->
                                    <th scope="col">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($templates as $template)
                                    <tr>
                                        
                                        <td><a href="template/view/{{ $template->id }}">{{ $template->title }}</a></td>
                                        <td>{{ $template->type }}</td>
                                        
                                        <td>
                                        {{ $template->message_count }}
                                        </td>
                                       
                                        <td>
                                            <button class="btn btn-outline-primary btn-sm edit-template" title="Edit {{ $template->title }}" data-title="{{ $template->title }}" data-mediaurl="{{ $template->mediaUrl }}" data-category="{{ $template->category_id }}" data-type="{{ $template->type }}" data-subject="{{ $template->subject }}" data-body="{{ htmlspecialchars_decode(stripslashes($template->body)) }}" data-id="{{ $template->id }}"  data-toggle="modal" data-target="#editModal"><i class="fas fa-edit"></i></button>
                                            -
                                            <button class="btn btn-outline-danger btn-sm" title="Remove {{ $template->title }}" data-id="{{ $template->id }}" data-toggle="modal" data-target="#deleteModal"><i class="fas fa-times-circle"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
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
                    <h5 class="modal-title" id="exampleModalLabel">New Template</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.template.store') }}" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <label>Template Name</label>
                            <input type="text" class="form-control" name="title" placeholder="Enter Template Name"
                                   required>
                        </div>
                       
                      
                        <div class="form-group pt-2">
                            <label>Message Type</label><br>
                            <select class="from-control" style="width: 100%;" id="type" name="type"  required>
                                <option value="">Select Type</option>
                                <option value="SMS">SMS</option>
                                <option value="MMS">MMS</option>
                                <option value="Email">Email</option>
                              
                            </select>
                        </div>
                        
                        <div class="show_media_rvm" style="display:none;">
                            <div class="form-group">
                                <label>Media File (<small class="text-danger">Disregard if not sending MMS</small>)</label>
                                <input type="file" class="form-control-file" name="media_file">
                            </div>
                        </div>
                        <div class="show_media_mms" style="display:none;">
                            <div class="form-group">
                                <label>Media File (<small class="text-danger">Disregard if not sending MMS</small>)</label>
                                <input type="file" class="form-control-file" name="media_file_mms">
                            </div>
                            <div class="form-group">
                                <label>Body</label>
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
                                <label>Body</label>
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
                                <label>Body</label>
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
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Template Name</label>
                            <input type="hidden" id="id" name="id" value="">
                            <input type="text" class="form-control" name="title" id="title" required>
                        </div>
                        
                       
                        <div class="form-group pt-2">
                            <label>Message Type</label><br>
                            <select class="from-control" style="width: 100%;" id="type" name="type"  required>
                                <option value="">Select Type</option>
                                <option value="SMS">SMS</option>
                                <option value="MMS">MMS</option>
                                <option value="Email">Email</option>
                                
                            </select>
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
                <form action="{{ route('admin.template.destroy','test') }}" method="post" id="editForm">
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
        $(".summernote-usage").summernote({
    	    height: 200,
    	});
      
        $(document).ready(function () {
            $('#datatable').DataTable();
        });
      
        $(document).ready(function () {
            $('#type').select2();
        });
       
        
    </script>
    <script>
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var title = button.data('title');
            var id = button.data('id');
            var type = button.data('type');
            var modal = $(this);
            modal.find('.modal-body #title').val(title);
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #type').val(type);
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
