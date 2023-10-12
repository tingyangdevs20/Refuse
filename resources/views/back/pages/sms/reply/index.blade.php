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
                                    <h4 class="mb-0 font-size-18">Conversations</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Dashboard</a></li>
                                            <li class="breadcrumb-item">Conversations</li>
                                            <li class="breadcrumb-item active">Replies</li>
                                        </ol>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header bg-soft-dark ">
                                        All Conversations
                                        <button class="btn btn-outline-primary btn-sm float-right mr-2" title="helpModal" data-toggle="modal"
                        data-target="#helpModal">How to Use</button>  
                        @include('components.modalform')
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-striped table-bordered" id="datatable">
                                            <thead>
                                            <tr>
                                                
                                                 <th scope="col">Name</th>
                                                <th scope="col">Number</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Replies</th>
                                                <th scope="col">Lead Category</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($msg as $sms)
                                            <tr>
                                                
                                                 <td>{{ $sms->lname }} {{ $sms->fname }}</td>
                                                <td>{{ $sms->client_number }}</td>
                                                <td>{{ $sms->email }}</td>
                                                <td>{{ $sms->replies()->count() }}</td>
                                                <td>{{ $sms->getLeadName() }}</td>
                                                <td>
                     <a href="{{ route('admin.sms.show',$sms) }}" class="btn btn-outline-warning btn-sm" title="Reply" >View Replies</a> -
                                                    <button data-toggle="modal" data-target="#saveModal" class="btn btn-outline-success btn-sm" title="Change Lead Category" data-id="{{ $sms->id }}" data-number="{{ $sms->client_number }}" >Change Lead Category</button> -
                                                    <button data-toggle="modal" data-target="#deleteModal" class="btn btn-outline-danger btn-sm" title="Delete" data-id="{{ $sms->id }}" >Delete</button>

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

            {{--Modal New--}}
            <div class="modal fade" id="saveModal" tabindex="-1" role="dialog"  aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Lead Category</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.thread.save') }}" method="POST">
                            <div class="modal-body">
                                @csrf
                                @method('POST')
                                <div class="form-group pt-2">
                                    <input type="hidden" id="id" name="id" value="">
                                    <input type="hidden" id="number" name="number" value="">
                                    <select class="from-control" style="width: 100%;" id="lead" name="lead_id"
                                            required>
                                        <option value="">Select Lead Category</option>
                                        @foreach($leads as $lead)
                                            <option value="{{ $lead->id }}">{{ $lead->title }}</option>
                                        @endforeach
                                    </select>
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
            {{--Modal Delete--}}
            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"  aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete Conversation</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.reply.destroy','test') }}" method="post" id="editForm">
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

    <script >
        $(document).ready(function () {
            $('#lead').select2();
        });
        $('#saveModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var number = button.data('number');
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #number').val(number);
        });
        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
        });
        $(document).ready(function() {
            $('#datatable').DataTable();
        } );
    </script>

    @endsection
