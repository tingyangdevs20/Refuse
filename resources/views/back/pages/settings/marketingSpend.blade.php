@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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
                        <h4 class="mb-0 font-size-18">Settings</h4>
                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            <i class="fas fa-cog mr-1"></i> Marketing Spend Settings
                            <button class="btn btn-outline-primary btn-sm float-right ml-1" title="New" data-toggle="modal"
                                data-target="#newModalMarketingSpend"><i class="fas fa-plus-circle"></i></button>
                            @include('components.modalform')
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered datatable" id="">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Lead Source</th>
                                            <th scope="col">Date Range</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $record)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $record->lead_source }}</td>
                                                <td>{{ $record->daterange }}</td>
                                                <td>${{ $record->amount }} </td>
                                                <td>
                                                    <button class="btn btn-outline-primary btn-sm"
                                                        title="Edit {{ $record->lead_source }}"
                                                        data-lead_source="{{ $record->lead_source }}"
                                                        data-daterange="{{ $record->daterange }}" data-amount="{{ $record->amount }}"
                                                        data-id={{ $record->id }} data-toggle="modal"
                                                        data-target="#editModalMarketingSpend"><i
                                                            class="fas fa-edit"></i></button> -
                                                    <button class="btn btn-outline-danger btn-sm"
                                                        title="Remove {{ $record->lead_source }}"
                                                        data-id="{{ $record->id }}" data-toggle="modal"
                                                        data-target="#deleteModalAutoRespond"><i
                                                            class="fas fa-times-circle"></i></button>
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

    {{-- Modal New --}}
    <div class="modal fade" id="newModalMarketingSpend" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Record</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.marketing-spend.store') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <label>Lead Source</label>
                            <select class="custom-select" name="lead_source"
                                onchange="updateValue(value,'lead_source','lead_info')" required>
                                <option value="">Lead Source</option>
                                <option value="Bandit Signs">Bandit Signs
                                </option>
                                <option value="Billboards">Billboards
                                </option>
                                <option value="Cold Calling">Cold Calling
                                </option>
                                <option value="Direct Mail">Direct Mail
                                </option>
                                <option value="Door Knocking">Door Knocking
                                </option>
                                <option value="Email">Email
                                </option>
                                <option value="Facebook Ads">Facebook Ads
                                </option>
                                <option value="Flyers">Flyers
                                </option>
                                <option value="Instagram Ads">Instagram Ads
                                </option>
                                <option value="iSpeedToLead">iSpeedToLead
                                </option>
                                <option value="LinkedIn Ads">LinkedIn Ads
                                </option>
                                <option value="Magazine">Magazine
                                </option>
                                <option value="MMS">MMS
                                </option>
                                <option value="Newspaper">Newspaper
                                </option>
                                <option value="Phone Call (Incoming)">Phone Call
                                    (Incoming)
                                </option>
                                <option value="Radio">Radio
                                </option>
                                <option value="Referral">Referral
                                </option>
                                <option value="Retargeting">Retargeting
                                </option>
                                <option value="RVM">RVM
                                </option>
                                <option value="SEO">SEO
                                </option>
                                <option value="SMS">SMS
                                </option>
                                <option value="Social Media">Social Media
                                </option>
                                <option value="Tiktok Ads">Tiktok Ads
                                </option>
                                <option value="Twitter Ads">Twitter Ads
                                </option>
                                <option value="Website">Website
                                </option>


                            </select>
                        </div>

                        <div class="form-group">
                            <label>Date Range</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-clock"></i></div>
                                </div>
                                <input type="date" required placeholder="Select custom date range" name="daterange"
                                    class="form-control" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Amount</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-dollar-sign"></i></div>
                                </div>
                                <input type="number" required placeholder="Enter Amount Spent" name="amount"
                                    class="form-control" />
                            </div>
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
    <div class="modal fade" id="editModalMarketingSpend" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Record</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.marketing-spend.update', 'test') }}" method="post" id="editForm">
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Lead Source</label>
                            <select class="custom-select" name="lead_source" id="lead_source" required>
                                <option value="">Lead Source</option>
                                <option value="Bandit Signs">Bandit Signs
                                </option>
                                <option value="Billboards">Billboards
                                </option>
                                <option value="Cold Calling">Cold Calling
                                </option>
                                <option value="Direct Mail">Direct Mail
                                </option>
                                <option value="Door Knocking">Door Knocking
                                </option>
                                <option value="Email">Email
                                </option>
                                <option value="Facebook Ads">Facebook Ads
                                </option>
                                <option value="Flyers">Flyers
                                </option>
                                <option value="Instagram Ads">Instagram Ads
                                </option>
                                <option value="iSpeedToLead">iSpeedToLead
                                </option>
                                <option value="LinkedIn Ads">LinkedIn Ads
                                </option>
                                <option value="Magazine">Magazine
                                </option>
                                <option value="MMS">MMS
                                </option>
                                <option value="Newspaper">Newspaper
                                </option>
                                <option value="Phone Call (Incoming)">Phone Call
                                    (Incoming)
                                </option>
                                <option value="Radio">Radio
                                </option>
                                <option value="Referral">Referral
                                </option>
                                <option value="Retargeting">Retargeting
                                </option>
                                <option value="RVM">RVM
                                </option>
                                <option value="SEO">SEO
                                </option>
                                <option value="SMS">SMS
                                </option>
                                <option value="Social Media">Social Media
                                </option>
                                <option value="Tiktok Ads">Tiktok Ads
                                </option>
                                <option value="Twitter Ads">Twitter Ads
                                </option>
                                <option value="Website">Website
                                </option>


                            </select>
                        </div>

                        <div class="form-group">
                            <label>Date Range</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-clock"></i></div>
                                </div>
                                <input type="date" required placeholder="Select custom date range" name="daterangeEdit"
                                    id="daterangeEdit" class="form-control" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Amount</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-dollar-sign"></i></div>
                                </div>
                                <input type="number" id="amount" required placeholder="Enter Amount Spent"
                                    name="amount" class="form-control" />
                            </div>
                        </div>
                        <input type="hidden" name="id" id="id" value="">
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
    <div class="modal fade" id="deleteModalAutoRespond" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Record</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.marketing-spend.destroy', 'test') }}" method="post" id="editForm">
                    @method('DELETE')
                    @csrf
                    <div class="modal-body">
                        <div class="modal-body">
                            <p class="text-center">
                                Are you sure you want to delete this record?
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
    {{-- End Modal Delete --}}
@endsection
@section('scripts')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $(document).ready(function() {
            setupDateInputHandling()
            $('.datatable').DataTable();
            $(".delete-btnn").click(function() {
                // Get the form associated with this delete button
                var form = $(this).closest(".delete-form");

                // Set the form action URL to the delete route
                var actionUrl = form.attr("action");

                // When the user confirms deletion, send an AJAX request
                $(".confirm-delete-btnn").click(function() {
                    $.ajax({
                        url: actionUrl,
                        type: "POST",
                        data: {
                            "_method": "DELETE",
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            // alert(res.status);
                            if (res.status == true) {
                                // Sends a notification
                                // Customize the Toastr message based on your requirements
                                // toastr.success(res.message, {
                                // timeOut: 10000, // Set the duration (10 seconds in this example)
                                // });

                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            } else {
                                toastr.error(res.message, {
                                    timeOut: 10000, // Set the duration (10 seconds in this example)
                                });

                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            }
                        },
                        error: function(res) {
                            toastr.error('Something went wrong the server!', {
                                timeOut: 10000, // Set the duration (10 seconds in this example)
                            });
                            // Handle errors, e.g., show an error message
                            console.log("Error:", res);
                        }
                    });

                    // Close the confirmation modal
                    $("#confirmationModal").modal("hide");
                });
            });

            setupDateRange()
        });

        function setupDateRange() {
            $('input[name="daterange"]').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                },
                showCustomRangeLabel: true,
                autoApply: true,
            });

            $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format(
                    'MM/DD/YYYY'));
            });

            $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });

            $('input[name="daterangeEdit"]').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                },
                showCustomRangeLabel: true,
                autoApply: true,
            });

            $('input[name="daterangeEdit"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format(
                    'MM/DD/YYYY'));
            });

            $('input[name="daterangeEdit"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        }

        function setupDateInputHandling() {
            // Get all input elements with type 'date'
            var dateInputs = document.querySelectorAll('input[type="date"]');
            // Add event listeners to each 'date' input
            dateInputs.forEach(function(dateInput) {

                if (dateInput.value === '' || dateInput.value === null) {
                    dateInput.type = 'text';
                } else {
                    dateInput.type = 'date';
                }
                dateInput.addEventListener('focus', function() {
                    if (this.value !== '' || this.value !== null) {
                        this.type = 'date';
                    }
                });
                dateInput.addEventListener('blur', function() {
                    if (this.value === '' || this.value === null) {
                        this.type = 'text';
                    } else {
                        this.type = 'date';
                    }
                });
            });
        }

        $('#editModalMarketingSpend').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var lead_source = button.data('lead_source');
            var amount = button.data('amount');
            var daterange = button.data('daterange');
            var id = button.data('id');

            var modal = $(this);

            modal.find('.modal-body #lead_source').val(lead_source);
            modal.find('.modal-body #amount').val(amount);
            modal.find('.modal-body #daterangeEdit').val(daterange)
            modal.find('.modal-body #id').val(id);

        });
        $('#deleteModalAutoRespond').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
        });
    </script>
@endsection
