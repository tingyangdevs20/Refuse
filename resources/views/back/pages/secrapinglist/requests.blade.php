@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="sha512-o9b12nEp6qOBHnpd3b05NUOBtJ9osd/Jfnvs59GpTcf6bd3NUGw+XtfPpCUVHsWqvyd2uuOVxOwXaVRoO2s2KQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
                        <h4 class="mb-0 font-size-18">Scraping Requests</h4>
                        
                    </div>
                    @include('back.pages.partials.messages')
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            All Requests
                            {{-- @if (auth()->user()->can('administrator') ||
    auth()->user()->can('scraping_create'))
                            @endif --}}
                            {{-- <button class="btn btn-outline-primary btn-sm float-right mr-2" title="helpModal" data-toggle="modal"
                        data-target="#helpModal">How to Use</button>   --}}
                            @include('components.modalform')
                        </div>
                    </div>
                    <div class="card">
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
                                                <select class="custom-select select2" name="status"
                                                    onchange="submitForm()">
                                                    <option value="">Choose Request Status</option>
                                                    <option value="showAll"
                                                        {{ request('status') == 'showAll' ? 'selected' : '' }}>Show All
                                                    </option>
                                                    <option value="data-ready"
                                                        {{ request('status') == 'data-ready' ? 'selected' : '' }}>Data-Ready
                                                    </option>
                                                    <option value="in-progress"
                                                        {{ request('status') == 'in-progress' ? 'selected' : '' }}>
                                                        In-Progress</option>
                                                    <option value="deleted"
                                                        {{ request('status') == 'deleted' ? 'selected' : '' }}>
                                                        Deleted/Paused</option>
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="datatable">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="selectAll" class="data-checkbox"></th>
                                            <th scope="col">Job Name</th>
                                            <th scope="col">State</th>
                                            <th scope="col">Price Range</th>
                                            <th scope="col">Property Type</th>
                                            <th scope="col">Beds</th>
                                            <th scope="col">Baths</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">File</th>
                                            <th scope="col">Upload</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="requests">
                                        @foreach ($scrapingdata as $data)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="data-checkbox" name="data[]"
                                                        value="{{ $data->id }}">
                                                </td>
                                                <td>{{ $data->job_name }}</td>
                                                <td>{{ $data->state }}</td>
                                                <td>{{ $data->formatted_price_range }}</td>
                                                <td>
                                                    @php
                                                        $propertyTypes = explode(', ', $data->property_type);
                                                    @endphp

                                                    @foreach ($propertyTypes as $property)
                                                        <span class="badge badge-info">{{ trim($property) }}</span>
                                                        @unless ($loop->last)
                                                            ,
                                                        @endunless
                                                    @endforeach
                                                </td>

                                                <td>{{ $data->no_of_bedrooms }}</td>
                                                <td>{{ $data->no_of_bathrooms }}</td>
                                                <td>
                                                    @if ($data->status == 0 && !$data->deleted_at)
                                                        <span>
                                                            <i class="fas fa-spinner fa-spin text-warning"></i> In-Process
                                                        </span>
                                                    @elseif (!$data->status && $data->deleted_at)
                                                        <span>
                                                            <i class="fas fa-pause text-warning"></i> Paused
                                                        </span>
                                                    @else
                                                        <span
                                                            style="border-radius: 6px; padding: 5px; background-color: transparent;">
                                                            <i class="fa fa-check-circle"></i> Data Ready
                                                        </span>
                                                    @endif
                                                </td>


                                                <td>
                                                    @if ($data->hasMedia('scraping_requests'))
                                                        @php
                                                            $media = $data->getFirstMedia('scraping_requests');
                                                        @endphp
                                                        @if ($media)
                                                            <a href="{{ $media->getUrl() }}" download target="_blank">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                    height="16" fill="currentColor"
                                                                    class="bi bi-download" viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M7.293 1.293a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L8 4.414V11a1 1 0 11-2 0V4.414L2.293 6.707a1 1 0 01-1.414-1.414l4-4z" />
                                                                    <path fill-rule="evenodd"
                                                                        d="M7 0a1 1 0 011 1v10a1 1 0 11-2 0V1a1 1 0 011-1z" />
                                                                </svg>
                                                                Download
                                                            </a>
                                                        @endif
                                                    @else
                                                        No File
                                                    @endif
                                                </td>

                                                <td>
                                                    <form method="POST"
                                                        action="{{ route('admin.scraping.upload', $data->id) }}"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="input-group input-group-sm">
                                                            <!-- Add input-group-sm to make it smaller -->
                                                            <div class="custom-file" style="width: 150px;">
                                                                <!-- Adjust the width as needed -->
                                                                <input type="file" class="custom-file-input"
                                                                    id="excelFileInput" name="excel_file"
                                                                    accept=".xlsx, .xls">
                                                                <label class="custom-file-label" for="excelFileInput">Choose
                                                                    file</label>
                                                            </div>
                                                            <div class="input-group-append">
                                                                <button type="submit"
                                                                    class="btn btn-outline-primary btn-sm">
                                                                    <i class="fas fa-upload"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </td>

                                                <td>
                                                    @if (auth()->user()->can('administrator') ||
                                                            auth()->user()->can('scraping_delete'))
                                                        {{-- <a href="{{ route('admin.scraping.force-delete', $data->id) }}"
                                                            class="btn btn-outline-danger btn-sm" title="Remove"
                                                            onclick="event.preventDefault(); confirmDelete({{ $data->id }});">
                                                            <i class="fas fa-times-circle"></i>
                                                        </a>
                                                        <form id="delete-form-{{ $data->id }}"
                                                            action="{{ route('admin.scraping.force-delete', $data->id) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                        </form> --}}
                                                        <button class="btn btn-outline-danger btn-sm"
                                                            title="Remove {{ $data->name }}"
                                                            data-id="{{ $data->id }}" data-toggle="modal"
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

    {{-- Modal Delete --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Record</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.scraping.force-delete') }}" method="post" id="editForm">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();

            // Initialize select2
            $('.select2').select2();
        });

        function confirmDelete(roleId) {
            if (confirm('Are you sure you want to delete this record?')) {
                document.getElementById('delete-form-' + roleId).submit();
            }
        }

        function submitForm() {
            document.getElementById("filterForm").submit();
        }

        var rowCount = $('#datatable tbody tr').length;
        if (rowCount > 0) {
            $('#selectAll').show();
        } else {

            $('#selectAll').hide();
        }

        // Select All checkbox click event
        $('#selectAll').change(function() {
            var isChecked = $(this).prop('checked');
            $('.data-checkbox').prop('checked', isChecked);
            toggleDeleteButtonVisibility();
        });

        function delete_selected(selectElement) {
            var selectedValue = selectElement.value;
            var selectedDataIds = $('.data-checkbox:checked').map(function() {
                return $(this).val();
            }).get();

            // Check if the selected value is "delete"
            if (selectedValue === "1" && selectedDataIds.length > 0) {
                // Show the confirmation modal
                $('#confirmationModal').modal('show');

                // Set up the click handler for the "Delete" button in the modal
                $('.confirm-delete-btn').click(function() {
                    // Perform the AJAX call to delete the selected items
                    $.ajax({
                        url: '{{ route('admin.scraping.multipledelete') }}',
                        method: 'POST',
                        data: {
                            ids: selectedDataIds,
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
            } else if (selectedValue === "1" && selectedDataIds.length == 0) {
                $('.actionSelect').val(0).trigger('change');
                alert('Select the record to be deleted!')
            }
        }

        // function toggleDeleteButtonVisibility() {
        //     var selectedCount = $('.data-checkbox:checked').length;
        //     if (selectedCount > 0) {
        //         $('#delete-selected-button').show();
        //     } else {

        //         $('#delete-selected-button').hide();
        //     }

        //     // Handle delete button click
        //     $('#delete-selected-button').click(function(e) {
        //         e.preventDefault();
        //         var selectedDataIds = $('.data-checkbox:checked').map(function() {
        //             return $(this).val();
        //         }).get();
        //         console.log(selectedDataIds);

        //         if (selectedDataIds.length > 0) {
        //             // Show confirmation modal if needed
        //             if (confirm('Are you sure you want to delete the selected tasks?')) {

        //                 $.ajax({
        //                     url: '{{ route('admin.scraping.multipledelete') }}',
        //                     method: 'POST',

        //                     data: {
        //                         ids: selectedDataIds,
        //                         _token: '{{ csrf_token() }}', // Add CSRF token
        //                     },
        //                     success: function(response) {
        //                         // Handle success, e.g., refresh the page or update the table
        //                         toastr.success(response.message, 'Success');
        //                         // window.location.reload();
        //                     },
        //                     error: function(error) {
        //                         // Handle error
        //                         toastr.error(error, 'Error');
        //                         console.error(error);
        //                     }
        //                 });
        //             }
        //         }
        //     });

        // }
    </script>
    <script>
        $('#deleteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
        });
    </script>
@endsection
