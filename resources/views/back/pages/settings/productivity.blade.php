@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
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

        .checkbox label .toggle,
        .checkbox-inline .toggle {
            margin-left: -20px;
            margin-right: 5px
        }

        .toggle {
            position: relative;
            overflow: hidden
        }

        .toggle input[type=checkbox] {
            display: none
        }

        .toggle-group {
            position: absolute;
            width: 200%;
            top: 0;
            bottom: 0;
            left: 0;
            transition: left .35s;
            -webkit-transition: left .35s;
            -moz-user-select: none;
            -webkit-user-select: none
        }

        .toggle.off .toggle-group {
            left: -100%
        }

        .toggle-on {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 50%;
            margin: 0;
            border: 0;
            border-radius: 0
        }

        .toggle-off {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 50%;
            right: 0;
            margin: 0;
            border: 0;
            border-radius: 0
        }

        .toggle-handle {
            position: relative;
            margin: 0 auto;
            padding-top: 0;
            padding-bottom: 0;
            height: 100%;
            width: 0;
            border-width: 0 1px
        }

        .toggle.btn {
            min-width: 100px;
            min-height: 34px
        }

        .toggle-on.btn {
            padding-right: 24px
        }

        .toggle-off.btn {
            padding-left: 24px
        }

        .toggle.btn-lg {
            min-width: 79px;
            min-height: 45px
        }

        .toggle-on.btn-lg {
            padding-right: 31px
        }

        .toggle-off.btn-lg {
            padding-left: 31px
        }

        .toggle-handle.btn-lg {
            width: 40px
        }

        .toggle.btn-sm {
            min-width: 50px;
            min-height: 30px
        }

        .toggle-on.btn-sm {
            padding-right: 20px
        }

        .toggle-off.btn-sm {
            padding-left: 20px
        }

        .toggle.btn-xs {
            min-width: 35px;
            min-height: 22px
        }

        .toggle-on.btn-xs {
            padding-right: 12px
        }

        .toggle-off.btn-xs {
            padding-left: 12px
        }

        #exTab2 h3 {
            color: white;
            background-color: #428bca;
            padding: 5px 15px;
        }

        .nav-tabs .nav-item .nav-link.active {
            background-color: #38B6FF;
            /* Change to your preferred button color */
            color: #fff;
            /* Text color for the active tab */
            border-color: #38B6FF;
            /* Border color for the active tab */
            border-radius: 5px;
            /* Optional: Add rounded corners */
            /* padding: 13px; */
        }

        /* Add other CSS styles for the non-active tab links as needed */
        .nav-tabs .nav-item .nav-link {
            /* Default text color for non-active tabs */
            /* border-color: #38B6FF; */
        }
    </style>

    <style>
        #hidden_div {
            display: none;
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
                        <h4 class="mb-0 font-size-18">Productivity</h4>
                       
                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            <i class="fas fa-cog mr-1"></i>Productivity Settings

                            @include('components.modalform')
                        </div>
                    </div>

                        
                <!-- CONTENT SECTION DIV -->
                  <div class="card">
                        <!-- TABS HEADINGS SECTION -->
                        <div class="card-header  bg-soft-dark">
                            <div class="nav-tabs-wrapper">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item m-1">
                                        <a class="nav-link active" href="#TasksList" data-toggle="tab">Tasks List</a>
                                    </li>
                                  
                                  
                                    <li class="nav-item m-1"><a class="nav-link" href="#MarketingSpends"
                                            data-toggle="tab">Marketing Spends</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- TABS HEADINGS SECTION ENDS -->
                                <!-- TABS CONTENT SECTION -->
                                <div class="card-body">
                                   <div class="tab-content clearfix">
                                    <!-- TAB 1 CONTENT -->
                                      <div class="tab-pane active" id="TasksList">
                                          <div class="card">
                                               <div class="card-header bg-soft-dark ">
                                                  <i class="fas fa-cog mr-1"></i>Tasks List
                                                   <button id="add-task-button" class="btn btn-outline-primary btn-sm float-right ml-2" title="New" data-toggle="modal"
                                data-target="#newModal"><i class="fas fa-plus-circle"></i></button>
                                                </div>

                                                
                                <div class="card-body">
                                    <div id="task-list-container">

                                    <form id="task-form" action="{{ route('admin.task-list.store') }}" method="POST">
                                            @csrf
                                            <div class="row">
                                               
                                                <div class="col-12 mb-3">
                                                    @if (auth()->user()->can('administrator') ||
                                                            auth()->user()->can('user_task_create'))
                                                        <button type="submit" class="btn btn-danger"
                                                            id="delete-selected-button" style="display: none">Delete
                                                            List</button>
                                                    @endif
                                                </div>
                                            </div>
                                        </form>

                                        <table id="tasktable" class="table table-bordered table-task-list">
                                            <thead>
                                                <tr>
                                                    <th width="8%"><input type="checkbox" id="selectAll" class="task-checkbox"></th>
                                                    <!-- <th>S.No</th> -->
                                                    <th>Task</th>
                                                    <!-- <th>Assigned To</th> -->
                                                    <!-- <th>Status</th> -->
                                                    <th>Action</th>
                                                    {{-- <th width="8%">Drag</th> <!-- New drag handle column --> --}}
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
                                                        {{-- <td class="drag-handle"><i class="fas fa-arrows-alt"></i></td> --}}
                                                        <!-- Drag handle icon -->
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                          </div>
                                       </div>
                                      <!-- TAB 1 CONTENT ENDS -->
                                      {{-- Modal New --}}
            <div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Task List</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.task-list.store') }}" method="POST" enctype="multipart/form-data">
                            <div class="modal-body">
                                @csrf
                                @method('POST')
                                <div class="form-group">
                                    <label for="task">Task List Name</label>
                                    <input type="text" placeholder="Task List Name" name="task" id="task" class="form-control">
                                </div>
                               
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

                                       <!-- TAB 2 CONTENT -->
                                       <div class="tab-pane" id="MarketingSpends">
                                          <div class="card">
                                               <div class="card-header bg-soft-dark ">
                                                  <i class="fas fa-cog mr-1"></i>Marketing Spends
                                                  <button class="btn btn-outline-primary btn-sm float-right ml-1" title="New" data-toggle="modal"
                                data-target="#newModalMarketingSpend"><i class="fas fa-plus-circle"></i></button>
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
                                      <!-- TAB 2 CONTENT ENDS -->
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
                                       












                                 </div>
                             </div>




                    
                    
                    
                    
                    
                    
                    
                    
                         <!-- TABS CONTENT SECTION ENDS -->
                    </div>
                <!-- CONTENT SECTION DIV ENDS -->
                    

   


                    
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
  
   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
   
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
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
