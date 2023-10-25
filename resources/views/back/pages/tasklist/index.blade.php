@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css" rel="stylesheet">


    <style>
        .active-status {
            background-color: lightgreen;
            border-radius: 5px;
            /* Adjust the radius as needed */
            color: white;
            padding: 2px;
        }

        .inactive-status {
            background-color: rgb(245, 93, 93);
            /* Change to your desired color */
            border-radius: 5px;
            /* Adjust the radius as needed */
            color: black;
            /* Change to your desired text color */
            padding: 2px;
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
                        <h4 class="mb-0 font-size-18">Task List</h4>
                      
                    </div>
                    @include('back.pages.partials.messages')
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            Task List
                            <button id="add-task-button" class="btn btn-outline-primary btn-sm float-right ml-2" title="New" data-toggle="modal"
                                data-target="#newModal"><i class="fas fa-plus-circle"></i></button>
                            @include('components.modalform')

                        </div>
                        <div class="card-body">
                            <div class="card">

                                <div class="card-body">
                                    <div id="task-list-container">
                                        
                                    <form id="task-form" action="{{ route('admin.task-list.store') }}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <!-- <div class="col-md-6 col-12 mb-3">
                                                    <label for="task">Task</label>
                                                    <input type="text" name="task" id="task"
                                                        class="form-control">
                                                </div>
                                                <div class="col-md-6 col-12 mb-3">
                                                    <label for="assignee">Assign To</label>
                                                    <select class="form-control select2" id="assignee" name="assignee">
                                                        <option value="">Select User</option>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div> -->
                                                <div class="col-12 mb-3">
                                                    @if (auth()->user()->can('administrator') ||
                                                            auth()->user()->can('user_task_create'))
                                                        <button type="submit" class="btn btn-danger"
                                                            id="delete-selected-button" style="display: none">Delete
                                                            Task</button>
                                                    @endif
                                                </div>
                                            </div>
                                        </form>

                                        <table id="tasktable" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th><input type="checkbox" id="selectAll" class="task-checkbox"></th>
                                                    <!-- <th>S.No</th> -->
                                                    <th>Task</th>
                                                    <!-- <th>Assigned To</th> -->
                                                    <!-- <th>Status</th> -->
                                                    <th>Action</th>
                                                    <th>Drag</th> <!-- New drag handle column -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($tasks as $key => $task)
                                                    <tr data-task-id="{{ $task->id }}">
                                                        <!-- Add data-task-id attribute -->
                                                        <td>
                                                            <input type="checkbox" class="task-checkbox" name="task_id[]"
                                                                value="{{ $task->id }}">
                                                        </td>
                                                        <!-- <td>{{ @$loop->iteration }}</td> -->
                                                        <td><a href="{{ route('admin.task-list.show', $task->id) }}"
                                                                id="trigger-startup-button">{{ @$task->tast }} </a> </td>
                                                        <!-- <td>{{ @$task->user->name }}</td> -->
                                                        <!-- <td>{{ @$task->status }}</td> -->
                                                        <td>
                                                            <!-- @if (auth()->user()->can('administrator') ||
                                                                    auth()->user()->can('user_task_edit'))-->
                                                            <button class="btn btn-outline-primary btn-sm edit-task"
                                                                data-task-id="{{ @$task->id }}"
                                                                data-task-name="{{ @$task->tast }}"
                                                                data-toggle="modal"
                                                                data-target="#newModal"
                                                                title="Edit Task"><i class="fas fa-edit"></i></button>
                                                        <!-- @endif -->
                                                        </td>
                                                        <td class="drag-handle"><i class="fas fa-arrows-alt"></i></td>
                                                        <!-- Drag handle icon -->
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            {{-- Modal New --}}
            <div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Task Form</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.task-list.store') }}" method="POST" enctype="multipart/form-data">
                            <div class="modal-body">
                                @csrf
                                @method('POST')
                                <div class="form-group">
                                    <label for="task">Task</label>
                                    <input type="text" name="task" id="task" class="form-control">
                                </div>
                                <!-- <div class="form-group">
                                    <label for="task">Description</label>
                                    <textarea type="text" name="description" id="description" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="assignee">Assign To</label>
                                    <select class="form-control select2" id="assignee" name="assignee">
                                        <option value="">Select User</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div> -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button id="save-task-button" type="submit" class="btn btn-primary">Save Task</button>
                                <button id="update-task-button" type="button" class="btn btn-primary">Update Task</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- End Modal New --}}
        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
@endsection
@section('scripts')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>

    <script>
        $(document).ready(function() {

            // Handle checkbox selection
            $('#delete-selected-button').hide();

            var rowCount = $('#tasktable tbody tr').length;
            if (rowCount > 0) {
                $('#selectAll').show();
            } else {

                $('#selectAll').hide();
            }

            // Select All checkbox click event
            $('#selectAll').change(function() {
                var isChecked = $(this).prop('checked');
                $('.task-checkbox').prop('checked', isChecked);
                toggleDeleteButtonVisibility();
            });

            // Individual checkbox change event
            $('.task-checkbox').change(function() {
                toggleDeleteButtonVisibility();
            });

            // Function to toggle delete button visibility
            function toggleDeleteButtonVisibility() {
                var selectedCount = $('.task-checkbox:checked').length;
                if (selectedCount > 0) {
                    $('#delete-selected-button').show();
                } else {

                    $('#delete-selected-button').hide();
                }
            }

            // Handle delete button click
            $('#delete-selected-button').click(function(e) {
                e.preventDefault();
                var selectedTaskIds = $('.task-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();

                if (selectedTaskIds.length > 0) {
                    // Show confirmation modal if needed
                    if (confirm('Are you sure you want to delete the selected tasks?')) {

                        $.ajax({
                            url: '{{ route('admin.delete-tasks') }}',
                            method: 'POST',

                            data: {
                                task_id: selectedTaskIds,
                                _token: '{{ csrf_token() }}', // Add CSRF token
                            },
                            success: function(response) {
                                // Handle success, e.g., refresh the page or update the table
                                toastr.success(response.message, 'Success');
                                window.location.reload();
                            },
                            error: function(error) {
                                // Handle error
                                toastr.error(error, 'Error');
                                console.error(error);
                            }
                        });
                    }
                }
            });

            $('#add-task-button').click(function() {
                $("#save-task-button").show();
                $("#update-task-button").hide();
                $('#task').val("");
            });

            // Handle edit button click
            $('.edit-task').click(function() {
                var taskId = $(this).data('task-id');
                var taskName = $(this).data('task-name');
                // var assigneeId = $(this).data('assignee-id');

                // Populate form fields with task data
                $('#task').val(taskName);
                // $('#assignee').val(assigneeId);
                $("#save-task-button").hide();
                $("#update-task-button").show();

                // Handle update button click
                $('#update-task-button').click(function(e) {
                    e.preventDefault(); // Prevent form submission

                    var taskName = $('#task').val();
                    // var assigneeId = $('#assignee').val();

                    if (taskName /*&& assigneeId*/) {

                        $.ajax({

                            url: '{{ route('admin.update-task') }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}', // Add CSRF token
                                task: taskName,
                                id: taskId,
                                // assignee: assigneeId,
                                // Add other fields as needed
                            },
                            success: function(response) {
                                // Handle success, e.g., display a success message
                                toastr.success(response.message, 'Success');
                                window.location.reload();
                            },
                            error: function(error) {
                                // Handle error
                                console.error(error);
                                toastr.error(error, 'Error');
                            }
                        });

                    } else {
                        toastr.error('Some fields are empty!', 'Error');
                    }

                });
            });
            // Initialize SortableJS
            //   new Sortable(document.getElementById('tasktable').querySelector('tbody'), {
            //     animation: 150, // Animation speed
            //     handle: '.drag-handle', // Specify the class for the drag handle
            //   });

            const sortableList = new Sortable(document.getElementById('tasktable').getElementsByTagName('tbody')[
            0], {
                handle: '.drag-handle', // Specify the handle element for dragging
                animation: 150,
                onEnd: function(evt) {
                    console.log('Sortable onEnd called');
                    // Get the new order of tasks
                    const newOrder = Array.from(evt.from.children).map(row => row.getAttribute(
                        'data-task-id'));

                    // Update the task order in the database via AJAX
                    console.log(newOrder);
                    updateTaskOrder(newOrder);
                },
            });

            // Function to update task order via AJAX
            function updateTaskOrder(newOrder) {
                $.ajax({
                    url: '{{ route('admin.update.task.order') }}', // Use the route() helper to generate the URL
                    method: 'POST',
                    data: {
                        newOrder: newOrder, // Send the updated order to the server
                        _token: '{{ csrf_token() }}', // Include the CSRF token
                    },
                    success: function(response) {
                        // Handle the response from the server (e.g., show a success message)
                    },
                    error: function(error) {
                        // Handle any errors that occur during the AJAX request
                    },
                });
            }
        });
    </script>
@endsection
