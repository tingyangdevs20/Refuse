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
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item">Task List</li>
                            <li class="breadcrumb-item active">Task</li>
                        </ol>
                    </div>
                </div>
                @include('back.pages.partials.messages')
                <div class="card">
                    <div class="card-header bg-soft-dark ">
                        Task List

                    </div>
                    <div class="card-body">
                        <div class="card">

                            <div class="card-body">
                                <div id="task-list-container">
                                    <form id="task-form" action="{{ route('admin.task-list.store') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 col-12 mb-3">
                                                <label for="task">Task</label>
                                                <input type="text" name="task" id="task" class="form-control">
                                            </div>
                                            <div class="col-md-6 col-12 mb-3">
                                                <label for="assignee">Assign To</label>
                                                <select class="form-control select2" id="assignee" name="assignee">
                                                    <!-- Populate this select box with user options -->
                                                    <option value="">Select User</option>
                                                    @foreach($users as $user)

                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-12 mb-3">
                                                @if(auth()->user()->can('administrator') ||
                                                auth()->user()->can('user_task_create'))

                                                <button type="submit" class="btn btn-primary" id="add-task-button">Add
                                                    Task</button>
                                                <button type="submit" class="btn btn-danger" id="delete-selected-button"
                                                    style="display: none">Delete Task</button>
                                                @endif
                                            </div>
                                        </div>
                                    </form>

                                    <table id="tasktable" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="selectAll" class="task-checkbox"></th>
                                                <th>S.No</th>
                                                <th>Task</th>
                                                <th>Assigned To</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($tasks as $key => $task)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="task-checkbox" name="task_id[]"
                                                        value="{{ $task->id }}">
                                                </td>
                                                <td>{{@$loop->iteration}}</td>
                                                <td>{{@$task->tast}}</td>
                                                <td>{{@$task->user->name}}</td>
                                                <td>{{@$task->status}}</td>
                                                <td>
                                                    @if(auth()->user()->can('administrator') ||
                                                    auth()->user()->can('user_task_edit'))
                                                    <button class="btn btn-outline-primary btn-sm edit-task"
                                                        data-task-id="{{ @$task->id }}"
                                                        data-task-name="{{ @$task->tast }}"
                                                        data-assignee-id="{{ @$task->user->id }}" title="Edit Task"><i
                                                            class="fas fa-edit"></i></button>

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
            </div>
        </div>
        <!-- end page title -->

    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

@endsection
@section('scripts')
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.js"></script>


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

    // Handle edit button click
    $('.edit-task').click(function() {
        var taskId = $(this).data('task-id');
        var taskName = $(this).data('task-name');
        var assigneeId = $(this).data('assignee-id');


        // Populate form fields with task data
        $('#task').val(taskName);
        $('#assignee').val(assigneeId);

        // Update form action URL for updating the specific task
        // $('#task-form').attr('action', 'admin/update-task/' + taskId);

        // Change submit button text and handler
        $('#add-task-button').text('Update Task');
        $('#add-task-button').attr('id', 'update-task-button');


        // Handle update button click
        $('#update-task-button').click(function(e) {
            e.preventDefault(); // Prevent form submission


            var taskName = $('#task').val();
            var assigneeId = $('#assignee').val();

            if (taskName && assigneeId) {

                $.ajax({

                    url: '{{ route('admin.update-task')}}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // Add CSRF token
                        task: taskName,
                        id: taskId,
                        assignee: assigneeId,
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
});
</script>

@endsection