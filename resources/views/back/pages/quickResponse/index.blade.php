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
                        <h4 class="mb-0 font-size-18">Quick Response Management</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Dashboard</a></li>
                                <li class="breadcrumb-item">Quick Response Management</li>
                                <li class="breadcrumb-item active">Quick Responses</li>
                            </ol>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            All Responses
                            <button class="btn btn-outline-primary btn-sm float-right" title="New" data-toggle="modal"
                                    data-target="#newModal"><i class="fas fa-plus-circle"></i></button>
                                    <button class="btn btn-outline-primary btn-sm float-right mr-2" title="helpModal" data-toggle="modal"
                                    data-target="#helpModal">How to use</button>        
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered" id="datatable">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Message</th>
                                    <th scope="col">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($quickResponses as $quickResponse)
                                    <tr>
                                        <td>{{ $sr++ }}</td>
                                        <td>{{ $quickResponse->title }}</td>
                                        <td>{{ $quickResponse->body}}</td>
                                        <td>
                                            <button class="btn btn-outline-primary btn-sm"
                                                    title="Edit {{ $quickResponse->title }}"
                                                    data-title="{{ $quickResponse->title }}"
                                                    data-body="{{ $quickResponse->body }}"
                                                    data-id={{ $quickResponse->id }}  data-toggle="modal"
                                                    data-target="#editModal"><i class="fas fa-edit"></i></button>
                                            -
                                            <button class="btn btn-outline-danger btn-sm"
                                                    title="Remove {{ $quickResponse->title }}" data-id="{{ $quickResponse->id }}"
                                                    data-toggle="modal" data-target="#deleteModal"><i
                                                    class="fas fa-times-circle"></i></button>
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
         <iframe src="{{ helpvideolink()->links }}" frameBorder="0" style="position:absolute;width:100%;height:100%;border-radius:6px;left:0;top:0" allowfullscreen="" allow="autoplay">
         </iframe>
        </div>
        <form action="{{ route('admin.helpvideo.updates',helpvideolink()->id) }}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
            <div class="form-group">
                <label>Video Url</label>
                <input type="url" class="form-control" placeholder="Enter link" name="video_url" value="{{ helpvideolink()->links }}" id="video_url" >
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



    {{--Modal New--}}
    <div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Quick Response</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.quick-response.store') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" name="title" placeholder="Enter Response Title"
                                   required>
                        </div>
                        <div class="form-group">
                            <label>Message</label>
                            <textarea class="form-control" name="body" rows="5" required></textarea>
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
                    <h5 class="modal-title" id="exampleModalLabel">Edit Response</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.quick-response.update','test') }}" method="post" id="editForm">
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="hidden" id="id" name="id" value="">
                            <input type="text" class="form-control" name="title" id="title" required>
                        </div>
                        <div class="form-group">
                            <label>Body</label>
                            <textarea class="form-control" name="body" id="body" rows="3"></textarea>
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
                    <h5 class="modal-title">Delete Response</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.quick-response.destroy','test') }}" method="post" id="editForm">
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
    <script>
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

            var modal = $(this);

            modal.find('.modal-body #title').val(title);
            modal.find('.modal-body #body').val(body);
            modal.find('.modal-body #id').val(id);

        });
        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
        });
    </script>
@endsection
