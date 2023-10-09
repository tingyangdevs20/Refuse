@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet"/>

</head>
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
                                    <h4 class="mb-0 font-size-18">Auto Reply Management</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Dashboard</a></li>
                                            <li class="breadcrumb-item">Auto Reply</li>
                                            
                                        </ol>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header bg-soft-dark ">
                                        All Auto Repliers
                                        <button class="btn btn-outline-primary btn-sm float-right" title="New" data-toggle="modal" data-target="#newModal"><i class="fas fa-plus-circle"></i></button>
                                        <button class="btn btn-outline-primary btn-sm float-right mr-2" title="helpModal" data-toggle="modal"
                        data-target="#helpModal">Use this Section</button>  
                        @include('components.modalform')

                                    </div>
                                    <div class="card-body">
                                        <table class="table table-striped table-bordered" id="datatable">
                                            <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Category</th>
                                                <th scope="col">Message</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($autoReplies as $autoreply)
                                            <tr>
                                                <td>{{ $sr++ }}</td>
                                                <td>{{ $autoreply->category->name }}</td>
                                                <td>{{ $autoreply->message }}</td>
                                                <td>
                                                    <button class="btn btn-outline-primary btn-sm" title="Edit" data-message="{{ $autoreply->message }}" data-id={{ $autoreply->id }} data-toggle="modal" data-target="#editModal"><i class="fas fa-edit"></i></button>
                                                 
                                                    @if($autoreply->category_id>1)
                                                    -
                                                    <button class="btn btn-outline-danger btn-sm" title="Remove" data-id="{{ $autoreply->id }}" data-toggle="modal" data-target="#deleteModal"><i class="fas fa-times-circle"></i></button>
                                                     
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
                            <h5 class="modal-title" id="exampleModalLabel">New Auto Reply</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.auto-reply.store') }}" method="POST">
                            <div class="modal-body">
                                @csrf
                                @method('POST')
                                <div class="form-group">
                                    <label>Message</label>
                                    <textarea class="form-control text1" name="message" rows="5" required></textarea>
                                    <div id='count' class="float-lg-right"></div>
                                </div>
                                <div class="form-group pt-2">
                                    <label>Category</label><br>
                                    <select class="from-control" style="width: 100%;" id="categories" name="category_id"
                                            required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                            <label for="active">Active Status</label>
                            <select name="is_active" id="is_active" class="form-control" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
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

            {{--Modal Edit--}}
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog"  aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Auto Reply</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.auto-reply.update','test') }}" method="post" id="editForm">
                            @method('PUT')
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <input type="hidden" id="id" name="id" value="">
                                    <label>Message</label>
                                    <textarea class="form-control text2" name="message" id="message" rows="5"></textarea>
                                    <div id='count2' class="float-lg-right"></div>
                                </div>
                                <div class="form-group pt-2">
                                    <label>Category</label><br>
                                    <select class="from-control" style="width: 100%;" id="categories2" name="category_id"
                                            required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                       
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                            <label for="active">Active Status</label>
                            <select name="is_active" id="is_active2" class="form-control" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
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
                            <h5 class="modal-title">Delete Auto Reply</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.auto-reply.destroy','test') }}" method="post" id="editForm">
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
        <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script >
        $(document).ready(function() {
            $('#datatable').DataTable();
        } );
        $(document).ready(function () {
            $('#categories').select2();
        });
        $(document).ready(function () {
            $('#categories2').select2();
        });
    </script>
    <script >
    
   
    
    
    
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);// Button that triggered the modal
            var message = button.data('message');
            var id=button.data('id');
            var is_active=button.data('is_active');
           
            var modal = $(this);

            modal.find('.modal-body #message').val(message);
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #is_active2').val(is_active).trigger('change');;
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
    </script>
    @endsection
