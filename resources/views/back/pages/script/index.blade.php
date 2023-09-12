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
                        <h4 class="mb-0 font-size-18">Script Management</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Dashboard</a></li>
                                <li class="breadcrumb-item">Script Management</li>
                                <li class="breadcrumb-item active">Scripts</li>
                            </ol>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            All Scripts
                            <button class="btn btn-outline-primary btn-sm float-right" title="New" data-toggle="modal"
                                    data-target="#newModal"><i class="fas fa-plus-circle"></i></button>

                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered" id="datatable">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Scripts</th>
                                    <!--<th scope="col">Media URL</th>-->
                                    <th scope="col">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($scripts as $script)
                                    <tr>
                                        <td>{{ $sr++ }}</td>
                                        <td>{{ $script->name }}</td>
                                        <td>
                                            <?php echo htmlspecialchars_decode(stripslashes($script->scripts)); ?>
                                            <!--{{ $script->body}}-->
                                        </td>
                                        <td>
                                            <button class="btn btn-outline-primary btn-sm edit-Script" title="Edit {{ $script->name }}" data-name="{{ $script->name }}" data-body="{{ htmlspecialchars_decode(stripslashes($script->scripts)) }}" data-id="{{ $script->id }}"  data-toggle="modal" data-target="#editModal"><i class="fas fa-edit"></i></button>
                                            -
                                            <button class="btn btn-outline-danger btn-sm" title="Remove {{ $script->name }}" data-id="{{ $script->id }}" data-toggle="modal" data-target="#deleteModal"><i class="fas fa-times-circle"></i></button>
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
                    <h5 class="modal-title" id="exampleModalLabel">New Script</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.script.store') }}" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter Script Title"
                                   required>
                        </div>
                        <div class="show_email">
                            <div class="form-group">
                                <label>Script</label>
                                <textarea class="form-control email_body summernote-usage" name="scripts" rows="10"></textarea>
                                <!--<div id='count11' class="float-lg-right"></div>-->
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
        <h4 class="modal-title" id="myModalLabel">How to Use</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        
      </div>
      <div class="modal-body">
            
      <div style="position:relative;height:0;width:100%;padding-bottom:65.5%">
         <iframe src="https://sendspark.com/embed/jsz2ir9n0eggupucwdbj79prfn1lvukj" frameBorder="0" style="position:absolute;width:100%;height:100%;border-radius:6px;left:0;top:0" allowfullscreen="">
         </iframe>
        </div>

        <div class="form-group">
                <label>Video Url</label>
                <input type="text" class="form-control" name="video_url" id="video_url" >
            </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
    {{--End Modal on 31-08-2023--}}

    {{--Modal Edit--}}
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Script</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.script.update','test') }}" method="post" id="editForm" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="hidden" id="id" name="id" value="">
                            <input type="text" class="form-control" name="name" id="name_edit" required>
                        </div>
                        <div class="show_email_edit">
                            <div class="form-group">
                                <label>Body</label>
                                <textarea class="form-control text12333 email_body_edit summernote-usage" name="scripts" id="body_email" rows="10"></textarea>
                                <!--<div id='count12' class="float-lg-right"></div>-->
                            </div>
                        </div>
                        <!--//////-->
                        <!--<div class="form-group">-->
                        <!--    <label>Media File (<small class="text-danger">Disregard if not sending MMS</small>)</label>-->
                        <!--    <input type="file" class="form-control-file" name="media_file">-->
                        <!--    <label>(<small class="text-danger font-weight-bold">if uploading new file, remove the old link from body</small>)</label>-->
                        <!--</div>-->
                        <!--<div class="form-group">-->
                        <!--    <label>Body</label>-->
                        <!--    <textarea class="form-control message text2" name="body" id="body" rows="10"></textarea>-->
                        <!--    <div id='count2' class="float-lg-right"></div>-->

                        <!--</div>-->
                        <!--<div class="form-group">-->
                        <!--    <small class="text-danger"><b>Use {name} {street} {city} {state} {zip} to substitute the-->
                        <!--            respective fields</b></small>-->
                        <!--</div>-->

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
                    <h5 class="modal-title">Delete Script</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.script.destroy','test') }}" method="post" id="editForm">
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
    <link rel="stylesheet" href="{{asset('/summernote/dist/summernote.css')}}" />
    <script src="{{asset('/summernote/dist/summernote.min.js')}}"></script>
    <script>
        $(".summernote-usage").summernote({
    	    height: 200,
    	});
        $(document).ready(function () {
            $('#datatable').DataTable();
        });
        $(document).ready(function () {
            $('#categories').select2();
        });
        $(document).ready(function () {
            $('#type').select2();
        });
        $(document).ready(function () {
            $('#categories2').select2();
        });
        
    </script>
    <script>
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);// Button that triggered the modal
            var name = button.data('name');
            var script = button.data('body');
            var id = button.data('id');
            var modal = $(this);
            $('#name_edit').val(name);
            
            $('#body_email').summernote ('code', script);
            
            $('#id').val(id);

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
