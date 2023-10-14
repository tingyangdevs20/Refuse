@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" />

    <style>
        /* Adjust the margin between the input and dropdown arrow */
        .select2-container .select2-selection--multiple .select2-selection__rendered {
            margin-right: 10px;
        }

        /* Remove the blinking line under the input */
        .select2-container .select2-selection--multiple .select2-selection__rendered {

            margin-right: 10px;
        }

        .select2-container--default .select2-search--inline .select2-search__field {
            background: transparent;
            border: none;
            outline: 0;
            display: none;
            box-shadow: none;
            -webkit-appearance: textfield;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__display {
            cursor: default;
            padding-left: 22px !important;
            padding-right: 1px !important;
        }

        .select2-container--default .select2-selection--multiple {
            width: 100%;
            padding: 5px;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
        }

        .select2-container--default .select2-selection__choice {
            background-color: #007bff;
            color: #000;
            padding: 3px 10px;
            /* Adjust padding to separate text and remove button */
            margin: 2px;
            border-radius: 20px;
            /* Round the corners of the tags */
        }

        .select2-container--default .select2-selection__choice__remove {
            margin-left: 5px;
            /* Add margin between text and remove button */
            color: #fff;
            cursor: pointer;
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
                        <h4 class="mb-0 font-size-18">Lists Management</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item">Lead Generation</li>
                                <li class="breadcrumb-item active">My Lists</li>
                            </ol>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            All Lists
                            {{-- <button class="btn btn-outline-primary btn-sm float-right" title="New" data-toggle="modal"
                                data-target="#newModal"><i class="fas fa-plus-circle"></i></button> --}}
                            <a href="{{ route('admin.group.list.create') }}"
                                class="btn btn-outline-primary btn-sm float-right" title="New List"><i
                                    class="fas fa-plus-circle"></i></a>
                            <a href="{{ asset('uploads/examplenew.csv') }}" download
                                class="btn btn-success btn-sm float-right mr-3"><i class="fas fa-download"></i> Download
                                Sample</a>

                            {{-- <button class="btn btn-outline-primary btn-sm float-right mr-2" title="helpModal"
                                data-toggle="modal" data-target="#helpModal">How to Use</button> --}}
                            @include('components.modalform')

                        </div>
                        <div class="card-body">
                            @if (Session::has('payment_success'))
                                <div class="alert alert-success text-center">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                    <p>{{ Session::get('payment_success') }}</p><br>
                                </div>
                            @endif

                            @if (Session::has('payment_error'))
                                <div class="alert alert-success text-center">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                    <p>{{ Session::get('payment_error') }}</p><br>
                                </div>
                            @endif

                            @if (Session::has('payment_infoo'))
                                <div class="alert alert-success text-center">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                    <p>{{ Session::get('payment_infoo') }}</p><br>
                                </div>
                            @endif
                            <table class="table table-striped table-bordered" id="datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">List Name</th>
                                        <th scope="col">Contact</th>
                                        <th scope="col">Pushed To Campaign</th>
                                        <th scope="col">Pushed To Campaign Date</th>
                                        <th scope="col">Date of Last Email Skip Trace</th>
                                        <th scope="col">Date of Last Phone Skip Trace</th>
                                        <th scope="col">Date of Last Name Skip Trace</th>
                                        <th scope="col">Date of Last Email Verification</th>
                                        <th scope="col">Date of Last Phone Scrub </th>
                                        <th scope="col">% with Phone Numbers </th>
                                        <th scope="col">Created On</th>
                                        <th scope="col">Skip Trace</th>
                                        <th scope="col">Push to</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($groups as $group)
                                        <tr>
                                            <td>{{ $group->name }}</td>
                                            <td><a href="{{ route('admin.group.show', $group->id) }}"
                                                    id="trigger-startup-button">View ({{ $group->getContactsCount() }}) </a>
                                            </td>
                                            <td>


                                                @if ($group->campaign_name)
                                                    {{ $group->campaign_name }}
                                                @else
                                                    <span style="color:#efefef"> Not Pushed Yet</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($group->pushed_to_camp_date)
                                                    {{ \Carbon\Carbon::parse($group->pushed_to_camp_date)->format('m/d/Y') }}
                                                @else
                                                    <span style="color:#efefef">NA</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($group->email_skip_trace_date)
                                                    {{ \Carbon\Carbon::parse($group->email_skip_trace_date)->format('m/d/Y') }}
                                                @else
                                                    {{ $group->email_skip_trace_date }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($group->phone_skip_trace_date)
                                                    {{ \Carbon\Carbon::parse($group->phone_skip_trace_date)->format('m/d/Y') }}
                                                @else
                                                    {{ $group->phone_skip_trace_date }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($group->name_skip_trace_date)
                                                    {{ \Carbon\Carbon::parse($group->name_skip_trace_date)->format('m/d/Y') }}
                                                @else
                                                    {{ $group->name_skip_trace_date }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($group->email_verification_date)
                                                    {{ \Carbon\Carbon::parse($group->email_verification_date)->format('m/d/Y') }}
                                                @else
                                                    {{ $group->email_verification_date }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($group->phone_scrub_date)
                                                    {{ \Carbon\Carbon::parse($group->phone_scrub_date)->format('m/d/Y') }}
                                                @else
                                                    {{ $group->phone_scrub_date }}
                                                @endif
                                            </td>
                                            <td>{{ number_format($groupCounts[$loop->index]['percentage'], 2) }}%</td>

                                            <td>{{ $group->created_at->format('m/d/Y') }}</td>

                                            <td>

                                                <button class="btn btn-outline-primary btn-sm model"
                                                    data-group-id="{{ $group->id }}"
                                                    title="Skip Trace {{ $group->name }}" data-toggle="modal"
                                                    data-target="#skiptracingModal"><i class="fas fa-search"></i></button>

                                            </td>

                                            <td>
                                                <button class="btn btn-primary btn-sm push-to-campaign" data-toggle="modal"
                                                    data-target="#campaignModal" data-group-id="{{ $group->id }}"
                                                    data-group-name="{{ implode(', ', $group->contacts->pluck('name')->toArray()) }}"
                                                    data-group-email="{{ implode(', ', $group->contacts->pluck('email1')->toArray()) }}">Campaign
                                                </button>
                                            </td>

                                            <td>
                                                <button class="btn btn-outline-danger btn-sm"
                                                    title="Remove {{ $group->name }}" data-id="{{ $group->id }}"
                                                    data-toggle="modal" data-target="#deleteModal"><i
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
            <!-- end page title -->

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    {{-- Modal New --}}
    <div class="modal fade" id="newModal" tabindex="-1" role="" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.group.store') }}" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        @method('POST')
                        <div class="form-group" style="display: none">
                            <select class="from-control" style="width: 100%;" required id="optiontype"
                                name="optiontype">
                                <option value="0">Select Option</option>

                                <option value="new" selected>Create New List</option>
                                <option value="update">Update Existing List</option>

                            </select>
                        </div>
                        <div class="form-group">
                            <label style="margin-right:50px">List Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter List Name"
                                required>
                        </div>
                        <div class="form-group" style="display: none">
                            <select class="from-control" style="width: 100%;" id="existing_group_id"
                                name="existing_group_id">
                                <option value="0">Select Existing List</option>
                                @foreach ($groups as $group)
                                    <option value="{{ $group->id }}" selected>{{ $group->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="customFile" name="file" required>
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                        <div class="form-group" style="display: none">
                            <label>Select Campaign</label>
                            <select class="custom-select" name="campaign_id" id="campaign_id">
                                <option value="0">Select Campaign</option>
                                @if (count($campaigns) > 0)
                                    @foreach ($campaigns as $campaign)
                                        <option value="{{ $campaign->id }}" selected>{{ $campaign->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group pt-2" style="display: none">
                            <label>Market</label><br>
                            <select class="custom-select" style="width: 100%;" id="market" name="market_id" required>
                                <option value="">Select Market</option>
                                @foreach ($markets as $market)
                                    <option value="{{ $market->id }}" selected>{{ $market->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group pt-2">
                            <label>Select Tag</label><br>
                            <select class="custom-select select2" required multiple="multiple" style="width: 100%;"
                                name="tag_id[]" id="tag">
                                <option value="" disabled>Select Tag</option>
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" style="display: none">
                            <label>Select Email Template</label>
                            <select class="custom-select" name="email_template" id="email_template">
                                @if (count($form_Template) > 0)
                                    @foreach ($form_Template as $email_template)
                                        <option value="{{ $email_template->id }}" selected>
                                            {{ $email_template->template_name }}
                                        </option>
                                    @endforeach
                                @endif
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
    {{-- End Modal New --}}


    {{-- Modal Delete --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.group.destroy', 'test') }}" method="post" id="editForm">
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

    {{-- Push Campaign Modal --}}
    <div class="modal fade first-modal" id="campaignModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Push to campaign</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="post" id="campaginFormId">
                    @csrf
                    @method('POST')
                    <div class="modal-body">

                        <div class="form-group">
                            <label>Select Campaign</label>
                            <select class="custom-select" name="campaign_id" id="modal_campaign_id" required>
                                <option value="">Select Campaign</option>
                                @if (count($campaigns) > 0)
                                    @foreach ($campaigns as $campaign)
                                        <option value="{{ $campaign->id }}" data-campaign-name="{{ $campaign->name }}">
                                            {{ $campaign->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group pt-2">
                            <label>Market</label><br>
                            <select class="custom-select" style="width: 100%;" id="modal_market" name="market_id"
                                required>
                                <option value="">Select Market</option>
                                @foreach ($markets as $market)
                                    <option value="{{ $market->id }}" data-market-name="{{ $market->name }}">
                                        {{ $market->name }}
                                    </option>
                                @endforeach
                            </select>

                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary push_to_campaign_btn">Push</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- Skip Tracing Modal --}}
    <div class="modal fade" id="skiptracingModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Skip Trace</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.group.destroy', 'test') }}" method="post" id="editFormSkip">
                    @csrf
                    @method('POST')
                    <div class="modal-body">

                        <div class="form-group">
                            <select class="from-control select2 skip_trace_option" style="width: 100%;" required
                                name="skip_trace_option" data-group-id="{{ $group->id }}">

                                <option value="">Select an Option</option>
                                <option value="skip_entire_list_phone"
                                    data-amount="${{ @$account->phone_cell_append_rate }}">Skip Trace Phone Numbers
                                    (Entire
                                    List) (${{ $account->phone_cell_append_rate }})</option>
                                <option value="skip_records_without_numbers_phone"
                                    data-amount="${{ @$account->phone_cell_append_rate }}">Skip Trace Phone Numbers
                                    (Records
                                    Without Numbers)(${{ $account->phone_cell_append_rate }})</option>
                                <option value="skip_entire_list_email" data-amount="${{ @$account->email_append_rate }}">
                                    Skip Trace Emails (Entire List)</option>
                                <option value="skip_records_without_emails"
                                    data-amount="${{ @$account->email_append_rate }}">Skip Trace Emails (Records Without
                                    Emails)(${{ $account->email_append_rate }})</option>
                                <option value="append_names" data-amount="${{ @$account->name_append_rate }}">Append Name
                                    (Records Without Name)(${{ $account->name_append_rate }})</option>
                                <option value="append_emails" data-amount="${{ @$account->name_append_rate }}">Append
                                    Email
                                    (Records Without Email)(${{ $account->name_append_rate }})</option>
                                <option value="email_verification_entire_list"
                                    data-amount="${{ @$account->email_verification_rate }}">Email Verification (Entire
                                    List)(${{ $account->email_verification_rate }})
                                </option>
                                <option value="email_verification_non_verified"
                                    data-amount="${{ @$account->email_verification_rate }}">Email Verification
                                    (Non-Verified
                                    Emails)(${{ $account->email_verification_rate }})</option>
                                <option value="phone_scrub_entire_list" data-amount="${{ @$account->phone_scrub_rate }}">
                                    Phone Scrub (Entire List)(${{ $account->phone_scrub_rate }})</option>
                                <option value="phone_scrub_non_scrubbed_numbers"
                                    data-amount="${{ @$account->phone_scrub_rate }}">Phone Scrub (Non-Scrubbed Phone
                                    Numbers)(${{ $account->phone_scrub_rate }})</option>


                            </select>
                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary skip_tracing_btn"
                                data-group-id="">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Confirmaion Modal --}}
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirm Action</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-center">
                        Are you sure you want to push data to the campaign?
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="confirmButton">Confirm</button>
                </div>
            </div>
        </div>
    </div>



    {{-- End Modals --}}
@endsection
@section('scripts')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();

            $('.select2').select2({
                theme: 'bootstrap4',
            });


            $('.select2').select2();
            $('#datatable').DataTable();

            let groupId = 0;

            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            $('.model').click(function() {
                let group_id = $(this).data('group-id');
                $('.skip_tracing_btn').attr('data-group-id', group_id);
                groupId = group_id;
            });

            // Handle when the "Skip Trace" button is clicked
            $('.skip_tracing_btn').on('click', function(e) {
                e.preventDefault(); // Prevent the default form submission behavior

                var selectedOption = $('.skip_trace_option').val();
                var selectedOptionText = $('.skip_trace_option :selected').data('amount');

                if (selectedOption) {
                    // var groupId = $(this).data('group-id');

                    var confirmation = confirm(
                        'Are you sure you want to perform skip tracing with the selected option? ' +
                        selectedOptionText + ' will be deducted from your account.');

                    // Make an AJAX request to perform skip tracing
                    if (confirmation) {
                        $('#skiptracingModal').modal('hide');
                        $('.skip_trace_option').val('');
                        $('.skip_tracing_btn').removeAttr('data-group-id');

                        $.ajax({
                            type: 'POST',
                            url: '{{ route('admin.skip-trace') }}', // Define the skip tracing route
                            data: {
                                _token: '{{ csrf_token() }}',
                                group_id: groupId,
                                skip_trace_option: selectedOption,
                            },
                            success: function(response) {
                                $('#skiptracingModal').modal('hide');
                                $('.skip_trace_option').val('');
                                $('.skip_tracing_btn').removeAttr('data-group-id');

                                if (response.error) {
                                    // Handle the error, e.g., display an error message
                                    toastr.error(': ' + response.error, '', {
                                        timeOut: 9000, // Set the duration (5 seconds in this example)
                                    });

                                } else if (response.data) {
                                    // Capture the values from the response object

                                    // var skipTraceRate = response.data.skip_trace_rate;
                                    // var groupId = response.data.group_id;
                                    // var skipTraceOption = response.data.skip_trace_option;

                                    // // Create a string containing the parameters
                                    // var parameters = skipTraceRate + '-' + groupId + '-' + skipTraceOption;

                                    // // Encrypt the parameters to create a secure token
                                    // var encryptedToken = btoa(parameters);

                                    // // Construct the URL with the token
                                    // var redirectURL = '/secure-payment/' + encryptedToken;

                                    // // Redirect to the secure URL
                                } else if (response.modal) {
                                    toastr.info('Low Balance: ' + response.modal, {
                                        timeOut: 9000, // Set the duration (5 seconds in this example)
                                    });

                                    setTimeout(function() {
                                        window.location.href =
                                            '{{ route('admin.account.detail') }}';
                                    }, 3000); // 3000 milliseconds (3 seconds)
                                }
                                // Check if the API response indicates success (you may need to adjust this condition)
                                else if (response.Status === true || response.header.Status ===
                                    0) {
                                    // Iterate through the 'Data' array in the response and display each entry using Toastr
                                    if (response.ResponseDetail.OrderAmount != '$0') {
                                        // Show a success message when the 'Data' array is empty


                                        response.ResponseDetail.Data.forEach(function(
                                            dataEntry) {
                                            var email = dataEntry.Email;
                                            var status = dataEntry.Status;

                                            // Customize the Toastr message based on your requirements
                                            toastr.success('Email: ' + email +
                                                '<br>Status: ' + status,
                                                'API Response', {
                                                    timeOut: 10000, // Set the duration (10 seconds in this example)
                                                });

                                            var fullName = dataEntry.FirstName + ' ' +
                                                dataEntry.LastName;
                                            var address = dataEntry.Address + ', ' +
                                                dataEntry.City + ', ' + dataEntry.Zip;
                                            var email = dataEntry.Email;

                                            // Customize the Toastr message based on your requirements
                                            toastr.success('Full Name: ' + fullName +
                                                '<br>Address: ' + address +
                                                '<br>Email: ' + email,
                                                'API Response', {
                                                    timeOut: 10000, // Set the duration (10 seconds in this example)
                                                });


                                        });
                                        toastr.success('Sucess', 'API Response', {
                                            timeOut: 5000, // Set the duration (5 seconds in this example)
                                        });

                                    } else {
                                        // Iterate through the 'Data' array in the response and display each entry using Toastr
                                        response.ResponseDetail.Data.forEach(function(
                                            dataEntry) {
                                            var fullName = dataEntry.FirstName + ' ' +
                                                dataEntry.LastName;
                                            var address = dataEntry.Address + ', ' +
                                                dataEntry.City + ', ' + dataEntry.Zip;
                                            var email = dataEntry.Email;

                                            // Customize the Toastr message based on your requirements
                                            toastr.success('Full Name: ' + fullName +
                                                '<br>Address: ' + address +
                                                '<br>Email: ' + email,
                                                'API Response', {
                                                    timeOut: 10000, // Set the duration (10 seconds in this example)
                                                });
                                        });
                                    }

                                    //  You can display additional information or messages using Toastr here
                                    // toastr.success('Order Amount: ' + response.ResponseDetail.OrderAmount, 'API Response', {
                                    //     timeOut: 9000, // Set the duration (5 seconds in this example)
                                    // });
                                } else {
                                    // Display an error message using Toastr for failed API responses
                                    toastr.error('API Error: ' + response.Message,
                                        'API Response Error', {
                                            timeOut: 9000, // Set the duration (5 seconds in this example)
                                        });
                                }
                            },
                            error: function(error) {
                                // Handle AJAX errors here and display using Toastr if needed
                                toastr.error('AJAX Error: ' + error.statusText, 'AJAX Error', {
                                    timeOut: 9000, // Set the duration (5 seconds in this example)
                                });
                            },
                        });
                    } else {
                        console.log('User canceled the operation.');
                    }
                }
            });

            // When the modal is shown, update its data attributes based on the button clicked
            $('#campaignModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var groupId = button.data('group-id');
                var groupName = button.data('group-name');
                var email = button.data('group-email');

                // Update the form's data attributes with the values from the button
                $('#modal_campaign_id').data('group-id', groupId);
                $('#modal_market').data('group-name', groupName);
                $('#modal_market').data('group-email', email);
            });

            // When the form inside the modal is submitted
            $('#campaginFormId').submit(function(event) {
                event.preventDefault(); // Prevent the default form submission

                // Retrieve data from the form and data attributes
                var groupId = $('#modal_campaign_id').data('group-id');
                var groupName = $('#modal_market').data('group-name');
                var email = $('#modal_market').data('group-email');
                var campaignId = $('#modal_campaign_id').val();
                var marketId = $('#modal_market').val();
                var campaignName = $('#modal_campaign_id option:selected').data('campaignName');
                var marketName = $('#modal_market option:selected').data('marketName');

                // console.log('campaignId',campaignId );
                // console.log('marketId',marketId );
                // console.log('campaignName',campaignName );
                // console.log('marketName',marketName );
                // console.log('groupId',groupId );
                // console.log('groupName',groupName );
                // console.log('email',email );

                var confirmationModal = $('#confirmationModal');
                var campaignModal = $('#campaignModal');

                // Hide the first modal when the confirmation modal is shown
                confirmationModal.on('show.bs.modal', function() {
                    campaignModal.addClass('d-none'); // Add a class to hide the first modal
                });

                // Restore the first modal's opacity when the confirmation modal is hidden
                confirmationModal.on('hidden.bs.modal', function() {
                    campaignModal.removeClass('d-none'); // Remove the class to show the first modal
                });



                // Show the modal
                confirmationModal.modal('show');

                // Listen for the confirmation button click in the modal
                confirmationModal.find('#confirmButton').off('click').on('click', function() {
                    // Close the modal
                    confirmationModal.modal('hide');

                    // Disable the submit button
                    $('.push_to_campaign_btn').prop('disabled', true);

                    // Perform the AJAX request
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('admin.push-to-campaign') }}',
                        data: {
                            _token: '{{ csrf_token() }}',
                            group_id: groupId,
                            group_name: groupName,
                            email: email,
                            campaign_id: campaignId,
                            market_id: marketId,
                            campaign_name: campaignName,
                            market_name: marketName,
                        },
                        success: function(data) {
                            // Handle success response
                            //alert(data);
                            if (data.success) {

                                toastr.success(
                                    'Data pushed to campaign successfully.', {
                                        timeOut: 9000,
                                    });
                            } else {
                                // alert(data);
                                toastr.error('Data already exists.', {
                                    timeOut: 9000,
                                });
                            }
                        },
                        error: function(error) {
                           // alert(data);
                            toastr.error('AJAX Error: ' + error.statusText, {
                                timeOut: 9000,
                            });
                        },
                        complete: function() {
                           // alert(data);
                            // Enable the submit button after the request is complete (success or error)
                            $('.push_to_campaign_btn').prop('disabled', false);
                            // Close the modal
                            $('#campaignModal').modal('hide');
                        }
                    });
                });
            });


        });
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
