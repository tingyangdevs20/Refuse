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
                                    <h4 class="mb-0 font-size-18">DNC Keywords Management</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Dashboard</a></li>
                                            <li class="breadcrumb-item">DNC Keywords</li>
                                        </ol>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header bg-soft-dark ">
                                        All DNC Keywords
                                        <button class="btn btn-outline-primary btn-sm float-right" title="New" data-toggle="modal" data-target="#newModal"><i class="fas fa-plus-circle"></i></button>
                                        <button class="btn btn-outline-primary btn-sm float-right mr-2" title="helpModal" data-toggle="modal"
                        data-target="#helpModal">How to use</button>  
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
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-striped table-bordered" id="datatable">
                                            <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Keyword</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($dncs as $dnc)
                                            <tr>
                                                <td>{{ $sr++ }}</td>
                                                <td>{{ $dnc->keyword }}</td>
                                                <td>
                                                    <button class="btn btn-outline-primary btn-sm" title="Edit {{ $dnc->keyword }}" data-keyword="{{ $dnc->keyword }}" data-id={{ $dnc->id }} data-toggle="modal" data-target="#editModal"><i class="fas fa-edit"></i></button> -
                                                    <button class="btn btn-outline-danger btn-sm" title="Remove {{ $dnc->keyword }}" data-id="{{ $dnc->id }}" data-toggle="modal" data-target="#deleteModal"><i class="fas fa-times-circle"></i></button>
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
            <div class="modal fade" id="newModal" tabindex="-1" role="dialog"  aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">New Keyword</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.dnc-database.store') }}" method="POST">
                            <div class="modal-body">
                                @csrf
                                @method('POST')
                                <div class="form-group">
                                    <label>Keyword</label>
                                    <input type="text" class="form-control" name="keyword" placeholder="Enter Keyword" required>
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
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog"  aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Keyword</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.dnc-database.update','test') }}" method="post" id="editForm">
                            @method('PUT')
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Keyword</label>
                                    <input type="hidden" id="id" name="id" value="">
                                    <input type="text" class="form-control"  name="keyword" id="keyword" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Edit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{--End Modal Edit--}}
            {{--Modal Delete--}}
            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"  aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete DNC Keyword</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.dnc-database.destroy','test') }}" method="post" id="editForm">
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
    <script >
        $(document).ready(function() {
            $('#datatable').DataTable();
        } );
    </script>
    <script >
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);// Button that triggered the modal
            var keyword = button.data('keyword');
            var id=button.data('id');

            var modal = $(this);

            modal.find('.modal-body #keyword').val(keyword);
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
