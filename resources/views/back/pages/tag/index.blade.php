@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <style>
        /* Ensure the table takes the full width of its container */
        .table-responsive {
            overflow-x: auto;
        }

        /* Add horizontal scrolling for the table on smaller screens */
        /* .table {
                            white-space: nowrap;
                        } */

        /* Add responsive breakpoints and adjust table font size and padding as needed */
        @media (max-width: 768px) {
            .table {
                font-size: 12px;
            }
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
                        <h4 class="mb-0 font-size-18">Tag Management</h4>
<<<<<<< HEAD
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item">Tag Management</li>
                                <li class="breadcrumb-item active">Tags</li>
                            </ol>
                        </div>
=======
                       
>>>>>>> 6da0dfed6002badc556f10928e1a5933ea4bb8c9
                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            All Tags
                            <button class="btn btn-outline-primary btn-sm float-right" title="New" data-toggle="modal"
                                data-target="#newModal"><i class="fas fa-plus-circle"></i></button>
                            {{-- <button class="btn btn-outline-primary btn-sm float-right mr-2" title="helpModal" data-toggle="modal"
                          data-target="#helpModal">How to Use</button>  --}}
                            @include('components.modalform')
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Number of Contacts</th>
                                            <th scope="col">Actions</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tags as $tag)
                                            <tr>
                                                <td>{{ $tag->name }}</td>
                                                <td><a
                                                        href="{{ route('admin.tags.contacts', $tag->id) }}">{{ $tag->contactCount }}</a>
                                                </td>
                                                <td>
                                                    <button class="btn btn-outline-primary btn-sm"
                                                        title="Edit {{ $tag->name }}" data-id="{{ $tag->id }}"
                                                        data-tagname="{{ $tag->name }}" data-toggle="modal"
                                                        data-target="#editModal"><i class="fas fa-edit"></i></button>
                                                    @if ($tag->id > 1)
                                                        -
                                                        <button class="btn btn-outline-danger btn-sm"
                                                            title="Remove {{ $tag->name }}"
                                                            data-tagid="{{ $tag->id }}" data-toggle="modal"
                                                            data-target="#deleteModal"><i
                                                                class="fas fa-times-circle"></i></button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
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
                    <h5 class="modal-title" id="exampleModalLabel">New Tag</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.tag.store') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter Tag Name" required>
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
    {{-- End Modal New --}}
    {{-- Modal Edit --}}
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Tag</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.tag.update', 'test') }}" method="post" id="editForm">
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="hidden" id="id" name="id" value="">
                            <input type="text" class="form-control" name="tag_name" id="tag_name">
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
    {{-- End Modal Edit --}}
    {{-- Modal Delete --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Tag</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.tag.destroy', 'test') }}" method="post" id="editForm">
                    @method('DELETE')
                    @csrf
                    <div class="modal-body">
                        <div class="modal-body">
                            <p class="text-center">
                                Are you sure you want to delete this?
                            </p>
                            <input type="hidden" id="tag_id" name="tag_id" value="">
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
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();
        });
    </script>
    <script>
        $('#editModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var id = button.data('id');
            var tagname = button.data('tagname');
            var modal = $(this);

            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #tag_name').val(tagname);
        });
        $('#deleteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var tagid = button.data('tagid');
            var modal = $(this);
            modal.find('.modal-body #tag_id').val(tagid);
        });
    </script>
@endsection
