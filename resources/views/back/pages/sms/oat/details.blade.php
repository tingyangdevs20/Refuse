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
                        <h4 class="mb-0 font-size-18">Send SMS One At Time</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Dashboard</a></li>
                                <li class="breadcrumb-item">Bulk SMS</li>
                                <li class="breadcrumb-item active">Send SMS One At Time</li>
                            </ol>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            SMS Details
                        </div>
                        <div class="card-body">

                            <div class="container">
                                <div class="row">
                                    <div class="col-md-2">
                                    </div>
                                    <div class="col-md-8" style="text-align: center">
                                        Send SMS To <br>
                                        <form action="{{ route('admin.one-at-time.store') }}" method="post">
                                            @csrf
                                            @method('POST')
                                            <input type="hidden" name="group" value="{{ $request->group }}">
                                            <input type="hidden" name="sender_market" value="{{ $request->sender_market }}">
                                            <input type="hidden" name="category" value="{{ $request->category }}">
                                            <input type="hidden" name="number" value="{{ $contact->number }}">
                                            @if($contact->name!=null)
                                            <label for="name" class="font-weight-bold">{{ $contact->name }}</label><br>
                                            @endif
                                            @if($contact->city!=null)
                                            <label for="name"class="font-weight-bold">{{ $contact->city }}</label><br>
                                            @endif
                                            @if($contact->state!=null)
                                            <label for="name"class="font-weight-bold">{{ $contact->state }}</label><br>
                                            @endif
                                            @if($contact->zip!=null)
                                            <label for="name"class="font-weight-bold">{{ $contact->zip }}</label><br>
                                            @endif
                                                @if($contact->street!=null)
                                            <label for="name"class="font-weight-bold">{{ $contact->street }}</label><br>
                                            @endif
                                            <label for="name"class="font-weight-bold">{{ $contact->number }}</label><br>
                                            <button type="submit" class="btn btn-primary mt-3">Send SMS</button>
                                            <a href="{{ route('admin.one-at-time.index') }}" class="btn btn-warning mt-3">Close</a>
                                        </form>

                                    </div>
                                    <div class="col-md-2">

                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
    {{--Modals--}}

  {{--  --}}{{--Modal New--}}{{--
    <div class="modal fade" id="newModal" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.category.store') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter Category Name" required>
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
    --}}{{--End Modal New--}}{{--
    --}}{{--Modal Edit--}}{{--
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.category.update','test') }}" method="post" id="editForm">
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="hidden" id="id" name="id" value="">
                            <input type="text" class="form-control"  name="category_name" id="category_name">
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
    --}}{{--End Modal Edit--}}{{--
    --}}{{--Modal Delete--}}{{--
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.category.destroy','test') }}" method="post" id="editForm">
                    @method('DELETE')
                    @csrf
                    <div class="modal-body">
                        <div class="modal-body">
                            <p class="text-center">
                                Are you sure you want to delete this?
                            </p>
                            <input type="hidden" id="category_id" name="category_id" value="">
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
    --}}{{--End Modal Delete--}}

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
            var id = button.data('id');
            var categoryname = button.data('categoryname');
            var modal = $(this);

            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #category_name').val(categoryname);
        });
        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var categoryid = button.data('categoryid');
            var modal = $(this);
            modal.find('.modal-body #category_id').val(categoryid);
        });
    </script>
@endsection
