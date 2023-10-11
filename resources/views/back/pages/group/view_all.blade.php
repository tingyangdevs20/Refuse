@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.css" />
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
                        <h4 class="mb-0 font-size-18">Contacts Management</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item">Contacts Management</li>
                                <li class="breadcrumb-item active">All Contacts</li>
                            </ol>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            All Contacts
                            <span>
                                <select class="actionSelect" onchange="delete_selected(this)">
                                      <option value="0">Action</option>
                                      <option value="1">Delete Selected</option>
  
                                  </select>
                              </span>
                        </div>
                        <div class="card-body">
                            <table id="tasktable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="selectAll" class="task-checkbox"></th>
                                        <th scope="col">First Name</th>
                                        <th scope="col">Last Name</th>
                                        <th scope="col">Street</th>
                                        <th scope="col">City</th>
                                        <th scope="col">State</th>
                                        <th scope="col">Zip</th>
                                        <th scope="col">Numbers</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Lead Category</th>
                                        <th scope="col">No. Of Tags</th>
                                        <th scope="col">DNC</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($contacts as $contact)
                                        <tr data-task-id="{{ $contact->id }}">
                                            <td>
                                                <input type="checkbox" class="task-checkbox" name="contact[]"
                                                    value="{{ $contact->id }}">
                                            </td>
                                            <td>{{ $contact->name }}</td>
                                            <td>{{ $contact->last_name }}</td>
                                            <td>{{ $contact->street }}</td>
                                            <td>{{ $contact->city }}</td>
                                            <td>{{ $contact->state }}</td>
                                            <td>{{ $contact->zip }}</td>
                                            <td>
                                                {{ $contact->number }}<br>

                                               {{ $contact->number2 }}<br>
                                               {{ $contact->number3 }}
                                            </td>
                                            <td>
                                                {{ $contact->email1 }}<br>
                                               {{ $contact->email2 }}

                                            </td>
                                            <td>{{ $contact->getLeadCategory() }}</td>
                                            <td>
                                                {{ $group->getContactCountByEmailId($contact->email1, $contact->email2, $contact->number, $contact->number2, $contact->number3) }}<br>

                                            </td>
                                            <td>{{ $contact->is_dnc ? 'YES' : 'NO' }}</td>
                                            <td><button class="btn btn-outline-danger btn-sm"
                                                    title="Remove {{ $contact->name }}" data-id="{{ $contact->id }}"
                                                    data-toggle="modal" data-target="#deleteModal"><i
                                                        class="fas fa-times-circle"></i></button>
                                                <a href="{{ route('admin.group-contacts.edit', $contact->id) }}"
                                                    class="btn btn-outline-primary btn-sm" title="Edit  User"><i
                                                        class="fas fa-edit"></i></a> -
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
    <!-- Confirmation Modal -->
            <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Confirm Deletion</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete this?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger confirm-delete-btn">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
@endsection
@section('scripts')
        <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tasktable').DataTable();
        });


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


        function delete_selected(selectElement) {
                var selectedValue = selectElement.value;
                var selectedTaskIds = $('.task-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();

                // Check if the selected value is "delete"
                if (selectedValue === "1" && selectedTaskIds.length > 0) {
                    // Show the confirmation modal
                    $('#confirmationModal').modal('show');

                    // Set up the click handler for the "Delete" button in the modal
                    $('.confirm-delete-btn').click(function() {
                        // Perform the AJAX call to delete the selected items
                        $.ajax({
                            url: '{{ route('admin.delete-List') }}',
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

                        // Close the modal after the deletion
                        $('#confirmationModal').modal('hide');
                    });
                }
            }

        function toggleDeleteButtonVisibility() {
            var selectedCount = $('.task-checkbox:checked').length;
            if (selectedCount > 0) {
                $('#delete-selected-button').show();
            } else {

                $('#delete-selected-button').hide();
            }

            // Handle delete button click
            $('#delete-selected-button').click(function(e) {
                e.preventDefault();
                var selectedTaskIds = $('.task-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();
                console.log(selectedTaskIds);

                if (selectedTaskIds.length > 0) {
                    // Show confirmation modal if needed
                    if (confirm('Are you sure you want to delete the selected tasks?')) {

                        $.ajax({
                            url: '{{ route('admin.delete-List') }}',
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

        }
    </script>
@endsection
