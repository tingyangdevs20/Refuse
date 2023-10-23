@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" />
    <style>
        /* Apply 100% width to the Select2 element */
        .select2 {
            width: 100%;
        }

        /* Style the Select2 container to match Bootstrap form-control */
        .select2-container {
            width: 100% !important;
        }

        /* Style the Select2 input element */
        .select2-selection {
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            padding: 0.23rem 0;
            min-height: 36px;
            line-height: 1.5;
            /* Adjust the line-height to vertically center the content */
        }

        /* Style the Select2 single selection text */
        .select2-selection__rendered {
            color: #333;
            /* Text color */
        }

        .select2-selection__arrow {
            top: 3px !important;
        }

        /* Style the Select2 dropdown to match Bootstrap styles */
        .select2-dropdown {
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
        }

        /* Style the Select2 option hover state to match Bootstrap styles */
        .select2-results__option--highlighted {
            background-color: #007bff;
            color: #fff;
        }

        /* Style the Select2 placeholder text */
        .select2-selection__placeholder {
            color: #6c757d;
            /* Set the color you prefer */
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
                        <h4 class="mb-0 font-size-18">Contacts Management</h4>
                       
                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            All Contacts
                            @include('components.modalform')
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Search &amp; Filter</h4>
                            <form action="{{ url()->current() }}" method="GET" id="filterForm">

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-0 form-group">
                                            <select class="custom-select select2 actionSelect"
                                                onchange="delete_selected(this)">
                                                <option value="0" selected>Choose Action</option>
                                                <option value="1">Delete Selected</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select class="custom-select select2" name="lead_status"
                                                onchange="submitForm()">
                                                <option value="">Choose Lead Status</option>
                                                <option value="showAll"
                                                    {{ request('lead_status') == 'showAll' ? 'selected' : '' }}>Show All
                                                </option>
                                                <option value="None/Unknown"
                                                    {{ request('lead_status') == 'None/Unknown' ? 'selected' : '' }}>
                                                    None/Unknown</option>
                                                <option value="Prospect"
                                                    {{ request('lead_status') == 'Prospect' ? 'selected' : '' }}>Prospect
                                                </option>
                                                <option value="DNC"
                                                    {{ request('lead_status') == 'DNC' ? 'selected' : '' }}>DNC</option>
                                                <option value="Lead-New"
                                                    {{ request('lead_status') == 'Lead-New' ? 'selected' : '' }}>Lead-New
                                                </option>
                                                <option value="Lead-Cold"
                                                    {{ request('lead_status') == 'Lead-Cold' ? 'selected' : '' }}>Lead-Cold
                                                </option>
                                                <option value="Lead-Warm"
                                                    {{ request('lead_status') == 'Lead-Warm' ? 'selected' : '' }}>Lead-Warm
                                                </option>
                                                <option value="Lead-Hot"
                                                    {{ request('lead_status') == 'Lead-Hot' ? 'selected' : '' }}>Lead-Hot
                                                </option>
                                                <option value="Send to Research"
                                                    {{ request('lead_status') == 'Send to Research' ? 'selected' : '' }}>
                                                    Send to Research</option>
                                                <option value="Not Available - Not Selling"
                                                    {{ request('lead_status') == 'Not Available - Not Selling' ? 'selected' : '' }}>
                                                    Not Available - Not Selling</option>
                                                <option value="Not Available - Sold Property"
                                                    {{ request('lead_status') == 'Not Available - Sold Property' ? 'selected' : '' }}>
                                                    Not Available - Sold Property</option>
                                                <option value="Not Available - Under Contract w/3rd Party"
                                                    {{ request('lead_status') == 'Not Available -Under Contract w/3rd Party' ? 'selected' : '' }}>
                                                    Not Available -Under Contract w/3rd Party</option>
                                                <option value="Not Interested"
                                                    {{ request('lead_status') == 'Not Interested' ? 'selected' : '' }}>Not
                                                    Interested</option>
                                                <option value="Non-Responsive"
                                                    {{ request('lead_status') == 'Non-Responsive' ? 'selected' : '' }}>
                                                    Non-Responsive</option>
                                                <option value="Maybe to Our Offer"
                                                    {{ request('lead_status') == 'Maybe to Our Offer' ? 'selected' : '' }}>
                                                    Maybe to Our Offer</option>
                                                <option value="Phone Call - Scheduled"
                                                    {{ request('lead_status') == 'Phone Call - Scheduled' ? 'selected' : '' }}>
                                                    Phone Call - Scheduled</option>
                                                <option value="Phone Call - Completed"
                                                    {{ request('lead_status') == 'Phone Call - Completed' ? 'selected' : '' }}>
                                                    Phone Call - Completed</option>
                                                <option value="Phone Call - No Show"
                                                    {{ request('lead_status') == 'Phone Call - No Show' ? 'selected' : '' }}>
                                                    Phone Call - No Show</option>
                                                <option value="Phone Call - Said No"
                                                    {{ request('lead_status') == 'Phone Call - Said No' ? 'selected' : '' }}>
                                                    Phone Call - Said No</option>
                                                <option value="Contract Out - Buy Side"
                                                    {{ request('lead_status') == 'Contract Out - Buy Side' ? 'selected' : '' }}>
                                                    Contract Out - Buy Side</option>
                                                <option value="Contract Out - Sell Side"
                                                    {{ request('lead_status') == 'Contract Out - Sell Side' ? 'selected' : '' }}>
                                                    Contract Out - Sell Side</option>
                                                <option value="Contract Signed - Buy Side"
                                                    {{ request('lead_status') == 'Contract Signed - Buy Side' ? 'selected' : '' }}>
                                                    Contract Signed - Buy Side</option>
                                                <option value="Contract Signed - Sell Side"
                                                    {{ request('lead_status') == 'Contract Signed - Sell Side' ? 'selected' : '' }}>
                                                    Contract Signed - Sell Side</option>
                                                <option value="Closed Deal - Buy Side"
                                                    {{ request('lead_status') == 'Closed Deal - Buy Side' ? 'selected' : '' }}>
                                                    Closed Deal - Buy Side</option>
                                                <option value="Closed Deal - Sell Side"
                                                    {{ request('lead_status') == 'Closed Deal - Sell Side' ? 'selected' : '' }}>
                                                    Closed Deal - Sell Side</option>
                                                <option value="Rehab in Process"
                                                    {{ request('lead_status') == 'Rehab in Process' ? 'selected' : '' }}>
                                                    Rehab in Process</option>
                                                <option value="Hold - Rental"
                                                    {{ request('lead_status') == 'Hold - Rental' ? 'selected' : '' }}>Hold
                                                    - Rental</option>
                                                <option value="For Sale (by Us)"
                                                    {{ request('lead_status') == 'For Sale (by Us)' ? 'selected' : '' }}>
                                                    For Sale (by Us)</option>
                                                <option value="Hold - Sold"
                                                    {{ request('lead_status') == 'Hold - Sold' ? 'selected' : '' }}>Hold -
                                                    Sold</option>
                                                <option value="Partnership"
                                                    {{ request('lead_status') == 'Partnership' ? 'selected' : '' }}>
                                                    Partnership</option>
                                            </select>

                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select class="custom-select select2" name="lead_type" onchange="submitForm()">
                                                <option value="">Choose Lead Type</option>
                                                <option value="showAll"
                                                    {{ request('lead_type') == 'showAll' ? 'selected' : '' }}>Show All
                                                </option>
                                                <option value="Agents"
                                                    {{ request('lead_type') == 'Agents' ? 'selected' : '' }}>Agents
                                                </option>
                                                <option value="Attorney"
                                                    {{ request('lead_type') == 'Attorney' ? 'selected' : '' }}>Attorney
                                                </option>
                                                <option value="Buyer (Investors)"
                                                    {{ request('lead_type') == 'Buyer (Investors)' ? 'selected' : '' }}>
                                                    Buyer (Investors)</option>
                                                <option value="Buyer (Owner Financing)"
                                                    {{ request('lead_type') == 'Buyer (Owner Financing)' ? 'selected' : '' }}>
                                                    Buyer (Owner Financing)</option>
                                                <option value="Buyer (Retail)"
                                                    {{ request('lead_type') == 'Buyer (Retail)' ? 'selected' : '' }}>Buyer
                                                    (Retail)</option>
                                                <option value="Code Enforcement"
                                                    {{ request('lead_type') == 'Code Enforcement' ? 'selected' : '' }}>Code
                                                    Enforcement</option>
                                                <option value="Mortgage Brokers"
                                                    {{ request('lead_type') == 'Mortgage Brokers' ? 'selected' : '' }}>
                                                    Mortgage Brokers</option>
                                                <option value="Seller"
                                                    {{ request('lead_type') == 'Seller' ? 'selected' : '' }}>Seller
                                                </option>
                                                <option value="Tenant"
                                                    {{ request('lead_type') == 'Tenant' ? 'selected' : '' }}>Tenant
                                                </option>
                                                <option value="Title Company"
                                                    {{ request('lead_type') == 'Title Company' ? 'selected' : '' }}>Title
                                                    Company</option>
                                                <option value="Wholesaler"
                                                    {{ request('lead_type') == 'Wholesaler' ? 'selected' : '' }}>Wholesaler
                                                </option>
                                                <option value="Other"
                                                    {{ request('lead_type') == 'Other' ? 'selected' : '' }}>Other</option>
                                            </select>

                                        </div>
                                    </div>

                                    <div class="col-md-3">

                                        <div class="form-group">
                                            <select class="custom-select select2" name="lead_assigned_to"
                                                onchange="submitForm()">
                                                <option value="">Choose Lead Assigned To</option>
                                                <option value="showAll"
                                                    {{ request('lead_assigned_to') == 'showAll' ? 'selected' : '' }}>Show
                                                    All</option>
                                                @if (count($leads) > 0)
                                                    @foreach ($leads as $lead)
                                                        <option value="{{ $lead->id }}"
                                                            {{ request('lead_assigned_to') == $lead->id ? 'selected' : '' }}>
                                                            {{ $lead->title }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card">
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
                                            <td>
                                                <button class="btn btn-outline-danger btn-sm"
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

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tasktable').DataTable();

            $('.select2').select2();
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

        function submitForm() {
            document.getElementById("filterForm").submit();
        }

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
            } else if (selectedValue === "1" && selectedTaskIds.length == 0) {
                $('.actionSelect').val(0).trigger('change');
                alert('Select the contact to be deleted!')
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
