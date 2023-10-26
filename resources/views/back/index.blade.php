@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="sha512-o9b12nEp6qOBHnpd3b05NUOBtJ9osd/Jfnvs59GpTcf6bd3NUGw+XtfPpCUVHsWqvyd2uuOVxOwXaVRoO2s2KQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">Command Central</h4>

                    </div>
                    @include('back.pages.partials.messages')
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            Goals Data
                            @if (auth()->user()->can('administrator'))
                                <a href="{{ route('admin.create.goals') }}" style="display:none"
                                    class="btn btn-outline-primary btn-sm float-right" title="New"><i
                                        class="fas fa-plus-circle"></i></a>
                            @endif
                            {{-- <button class="btn btn-outline-primary btn-sm float-right mr-2" title="helpModal"
                                                    data-toggle="modal" data-target="#helpModal">How To Use</button> --}}
                            @include('components.modalform')

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-5"></div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" placeholder="Select custom date range" class="form-control"
                                            name="datefilter" />
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">Metric</th>
                                            <th scope="col">Monthly Goal</th>
                                            <th scope="col">Today</th>
                                            <th scope="col">Past 7 days</th>
                                            <th scope="col">Past 30 days</th>
                                            <th scope="col">Past 90 days</th>
                                            <th scope="col">Past Year</th>
                                            <th scope="col">Lifetime</th>
                                            <th scope="col">Custom date range</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="col">People Touched</th>
                                            <td>{{ $goalValue ?? '0' }}</td>
                                            <td>{{ $people_touched_today ?? '0' }}</td>
                                            <td>{{ $people_touched_seven_days ?? '0' }}</td>
                                            <td>{{ $people_touched_month ?? '0' }}</td>
                                            <td>{{ $people_touched_ninety_days ?? '0' }}</td>
                                            <td>{{ $people_touched_year ?? '0' }}</td>
                                            <td>{{ $people_touched_lifetime ?? '0' }} </td>
                                            <td id="people_touched_count">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="col">#Lead</th>
                                            <td>{{ $goal_lead ?? '0' }}</td>
                                            <td>{{ $leads_count_today ?? '0' }}</td>
                                            <td>{{ $leads_count_seven_days ?? '0' }} </td>
                                            <td>{{ $leads_count_month ?? '0' }}</td>
                                            <td>{{ $leads_count_ninety_days ?? '0' }}</td>
                                            <td>{{ $leads_count_year ?? '0' }}</td>
                                            <td>{{ $leads_count_lifetime ?? '0' }}</td>
                                            <td id="leads_count">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="col">#Leads - Scheduled Appointments</th>
                                            <td>{{ $goal_appointment ?? '0' }}</td>
                                            <td>{{ $scheduled_appointments_count_today ?? '0' }}</td>
                                            <td>{{ $scheduled_appointments_count_seven_days ?? '0' }}</td>
                                            <td>{{ $scheduled_appointments_count_month ?? '0' }}</td>
                                            <td>{{ $scheduled_appointments_count_ninety_days ?? '0' }}</td>
                                            <td>{{ $scheduled_appointments_count_year ?? '0' }}</td>
                                            <td>{{ $scheduled_appointments_count_lifetime ?? '0' }}</td>
                                            <td id="lead_scheduled_count">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="col">#Appointments Show Up/Sellers Talked To</th>
                                            <td>{{ $goal_appointment ?? '0' }}</td>
                                            <td>{{ $appointments_showup_count_today ?? '0' }}</td>
                                            <td>{{ $appointments_showup_count_seven_days ?? '0' }}</td>
                                            <td>{{ $appointments_showup_count_month ?? '0' }}</td>
                                            <td>{{ $appointments_showup_count_ninety_days ?? '0' }}</td>
                                            <td>{{ $appointments_showup_count_year ?? '0' }}</td>
                                            <td>{{ $appointments_showup_count_lifetime ?? '0' }}</td>
                                            <td id="appointments_showup_count">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="col">Call No Show</th>
                                            <td>{{ $contacts_out ?? '0' }}</td>
                                            <td>{{ $call_no_show_count_today ?? '0' }}</td>
                                            <td>{{ $call_no_show_count_seven_days ?? '0' }}</td>
                                            <td>{{ $call_no_show_count_month ?? '0' }}</td>
                                            <td>{{ $call_no_show_count_ninety_days ?? '0' }}</td>
                                            <td>{{ $call_no_show_count_year ?? '0' }}</td>
                                            <td>{{ $call_no_show_count_lifetime ?? '0' }}</td>
                                            <td id="call_no_show_count">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="col">Contracts Signed</th>
                                            <td>{{ $contacts_signed ?? '0' }}</td>
                                            <td>{{ $contracts_signed_count_today ?? '0' }}</td>
                                            <td>{{ $contracts_signed_count_seven_days ?? '0' }}</td>
                                            <td>{{ $contracts_signed_count_month ?? '0' }}</td>
                                            <td>{{ $contracts_signed_count_ninety_days ?? '0' }}</td>
                                            <td>{{ $contracts_signed_count_year ?? '0' }}</td>
                                            <td>{{ $contracts_signed_count_lifetime ?? '0' }}</td>
                                            <td id="contracts_signed_count">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="col">Deals Closed</th>
                                            <td>{{ $deal_closed ?? '0' }}</td>
                                            <td>{{ $deal_closed_count_today ?? '0' }}</td>
                                            <td>{{ $deal_closed_count_seven_days ?? '0' }}</td>
                                            <td>{{ $deal_closed_count_month ?? '0' }}</td>
                                            <td>{{ $deal_closed_count_ninety_days ?? '0' }}</td>
                                            <td>{{ $deal_closed_count_year ?? '0' }}</td>
                                            <td>{{ $deal_closed_count_lifetime ?? '0' }}</td>
                                            <td id="deals_count">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="col">Profit Expected</th>
                                            <td>${{ number_format($money_expected, 2) }}</td>
                                            <td>${{ number_format(@$profit_expected_count_today, 2) }}</td>
                                            <td>${{ number_format(@$profit_expected_count_seven_days, 2) }}</td>
                                            <td>${{ number_format(@$profit_expected_count_month, 2) }}</td>
                                            <td>${{ number_format(@$profit_expected_count_ninety_days, 2) }}</td>
                                            <td>${{ number_format(@$profit_expected_count_year, 2) }}</td>
                                            <td>${{ number_format(@$profit_expected_count_lifetime, 2) }}</td>
                                            <td id="profit_expected_count">$0.00</td>
                                        </tr>
                                        <tr>
                                            <th scope="col">Profit Collected</th>
                                            <td>${{ number_format(@$money_collected, 2) }}</td>
                                            <td>${{ number_format(@$money_collected_todays, 2) }}</td>
                                            <td>${{ number_format(@$money_collected_seven_day, 2) }}</td>
                                            <td>${{ number_format(@$money_collected_month, 2) }}</td>
                                            <td>${{ number_format(@$money_collected_ninety_day, 2) }}</td>
                                            <td>${{ number_format(@$money_collected_year, 2) }}</td>
                                            <td>${{ number_format(@$money_collected_lifetime, 2) }}</td>
                                            <td id="money_collected_count">$0.00</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-soft-dark">
                            Leads Statistics
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-5"></div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" placeholder="Select custom date range" class="form-control"
                                            name="datefilter" />
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">Metric</th>
                                            <th scope="col">% of Your Leads</th>
                                            <th scope="col">% of Your Deals</th>
                                            <th scope="col">% of Your Profit</th>
                                            <th scope="col">Cost per Lead</th>
                                            <th scope="col">Cost per Appointment</th>
                                            <th scope="col">Cost per Call</th>
                                            <th scope="col">Cost per Purchase Agreement</th>
                                            <th scope="col">Cost per Deal</th>
                                            <th scope="col">Average Profit per Deal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Bandit Signs</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                        </tr>
                                        <tr>
                                            <td>Billboards</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                        </tr>
                                        <tr>
                                            <td>Cold Calling</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                        </tr>
                                        <tr>
                                            <td>Direct Mail</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                        </tr>
                                        <tr>
                                            <td>Door Knocking</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                        </tr>
                                        <tr>
                                            <td>Facebook Ads</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                        </tr>
                                        <tr>
                                            <td>Flyers</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                        </tr>
                                        <tr>
                                            <td>Google Ads</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                        </tr>
                                        <tr>
                                            <td>Instagram Ads</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                        </tr>
                                        <tr>
                                            <td>iSpeedToLead</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                        </tr>
                                        <tr>
                                            <td>LinkedIn Ads</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                        </tr>
                                        <tr>
                                            <td>Magazine</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                        </tr>
                                        <tr>
                                            <td>MMS</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                        </tr>
                                        <tr>
                                            <td>Newspaper</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                        </tr>
                                        <tr>
                                            <td>Phone Call (Incoming)</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                        </tr>
                                        <tr>
                                            <td>Radio</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                        </tr>
                                        <tr>
                                            <td>Referral</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                        </tr>
                                        <tr>
                                            <td>Retargeting</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                        </tr>
                                        <tr>
                                            <td>RVM</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                        </tr>
                                        <tr>
                                            <td>SEO</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                        </tr>
                                        <tr>
                                            <td>SMS</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                        </tr>
                                        <tr>
                                            <td>Social Media</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                        </tr>
                                        <tr>
                                            <td>Tiktok Ads</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                        </tr>
                                        <tr>
                                            <td>Twitter Ads</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                        </tr>
                                        <tr>
                                            <td>Website</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                        </tr>
                                        <tr>
                                            <td>TOTAL</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            Task List
                        </div>
                        <div class="card-body">
                            <div id="task-list-container">


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
                                                            auth()->user()->can('user_task_edit'))
    -->
                                                    <button class="btn btn-outline-primary btn-sm edit-task"
                                                        data-task-id="{{ @$task->id }}"
                                                        data-task-name="{{ @$task->tast }}"
                                                        data-assignee-id="{{ @$task->user->id }}" title="Edit Task"><i
                                                            class="fas fa-edit"></i></button>
                                        @endif
                                        </td>
                                        <td class="drag-handle"><i class="fas fa-arrows-alt"></i></td>
                                        <!-- Drag handle icon -->
                                        </tr>
                                        <!--
    @endforeach -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="row">
                                                                                    <div class="col-xl-12">
                                                                                        <div class="row">
                                                                                            <div class="col-sm-3">
                                                                                                <div class="card">
                                                                                                    <div class="card-body">
                                                                                                        <div class="d-flex align-items-center mb-3">
                                                                                                            <div class="avatar-xs mr-3">
                                                                                                                            <span
                                                                                                                                class="avatar-title rounded-circle bg-soft-primary text-primary font-size-18">
                                                                                                                                <i class="bx bx-message-alt-dots"></i>
                                                                                                                            </span>
                                                                                                            </div>
                                                                                                            <h5 class="font-size-14 mb-0">People to Reach (Goals)</h5>
                                                                                                        </div>
                                                                                                        <div class="text-muted mt-4">
                                                                                                            <h4>{{ $goalValue }}</h4>

                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-sm-3">
                                                                                                <div class="card">
                                                                                                    <div class="card-body">
                                                                                                        <div class="d-flex align-items-center mb-3">
                                                                                                            <div class="avatar-xs mr-3">
                                                                                                                            <span
                                                                                                                                class="avatar-title rounded-circle bg-soft-primary text-primary font-size-18">
                                                                                                                                <i class="bx bx-message-alt-dots"></i>
                                                                                                                            </span>
                                                                                                            </div>
                                                                                                            <h5 class="font-size-14 mb-0">People Reached (Today)</h5>
                                                                                                        </div>
                                                                                                        <div class="text-muted mt-4">
                                                                                                            <h4>{{ $messages_sent_today_goals }}</h4>

                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-sm-3">
                                                                                                <div class="card">
                                                                                                    <div class="card-body">
                                                                                                        <div class="d-flex align-items-center mb-3">
                                                                                                            <div class="avatar-xs mr-3">
                                                                                                                            <span
                                                                                                                                class="avatar-title rounded-circle bg-soft-primary text-primary font-size-18">
                                                                                                                                <i class="bx bx-message-alt-dots"></i>
                                                                                                                            </span>
                                                                                                            </div>
                                                                                                            <h5 class="font-size-14 mb-0">People Reached (In 7 Days)</h5>
                                                                                                        </div>
                                                                                                        <div class="text-muted mt-4">
                                                                                                            <h4>{{ $messages_sent_seven_days_goals }}</h4>

                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-sm-3">
                                                                                                <div class="card">
                                                                                                    <div class="card-body">
                                                                                                        <div class="d-flex align-items-center mb-3">
                                                                                                            <div class="avatar-xs mr-3">
                                                                                                                            <span
                                                                                                                                class="avatar-title rounded-circle bg-soft-primary text-primary font-size-18">
                                                                                                                                <i class="bx bx-message-alt-dots"></i>
                                                                                                                            </span>
                                                                                                            </div>
                                                                                                            <h5 class="font-size-14 mb-0">People Reached (In 30 Days)</h5>
                                                                                                        </div>
                                                                                                        <div class="text-muted mt-4">
                                                                                                            <h4>{{ $messages_sent_month_days_goals }}</h4>

                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-sm-3">
                                                                                                <div class="card">
                                                                                                    <div class="card-body">
                                                                                                        <div class="d-flex align-items-center mb-3">
                                                                                                            <div class="avatar-xs mr-3">
                                                                                                                            <span
                                                                                                                                class="avatar-title rounded-circle bg-soft-primary text-primary font-size-18">
                                                                                                                                <i class="bx bx-message-alt-dots"></i>
                                                                                                                            </span>
                                                                                                            </div>
                                                                                                            <h5 class="font-size-14 mb-0">People Reached (In 90 Days)</h5>
                                                                                                        </div>
                                                                                                        <div class="text-muted mt-4">
                                                                                                            <h4>{{ $messages_sent_ninety_days_goals }}</h4>

                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-sm-3">
                                                                                                <div class="card">
                                                                                                    <div class="card-body">
                                                                                                        <div class="d-flex align-items-center mb-3">
                                                                                                            <div class="avatar-xs mr-3">
                                                                                                                            <span
                                                                                                                                class="avatar-title rounded-circle bg-soft-primary text-primary font-size-18">
                                                                                                                                <i class="bx bx-message-alt-dots"></i>
                                                                                                                            </span>
                                                                                                            </div>
                                                                                                            <h5 class="font-size-14 mb-0">People Reached (Lifetime)</h5>
                                                                                                        </div>
                                                                                                        <div class="text-muted mt-4">
                                                                                                            <h4>{{ $total_sent_lifetime }}</h4>

                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div> -->

            <!-- <div class="row">
                                                                                    <div class="col-xl-12">
                                                                                        <div class="row">
                                                                                            <div class="col-sm-4">
                                                                                                <div class="card">
                                                                                                    <div class="card-body">
                                                                                                        <div class="d-flex align-items-center mb-3">
                                                                                                            <div class="avatar-xs mr-3">
                                                                                                                            <span
                                                                                                                                class="avatar-title rounded-circle bg-soft-primary text-primary font-size-18">
                                                                                                                                <i class="bx bx-message-alt-dots"></i>
                                                                                                                            </span>
                                                                                                            </div>
                                                                                                            <h5 class="font-size-14 mb-0">Received Today</h5>
                                                                                                        </div>
                                                                                                        <div class="text-muted mt-4">
                                                                                                            <h4>{{ $messages_sent_today }}</h4>

                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="col-sm-4">
                                                                                                <div class="card">
                                                                                                    <div class="card-body">
                                                                                                        <div class="d-flex align-items-center mb-3">
                                                                                                            <div class="avatar-xs mr-3">
                                                                                                                            <span
                                                                                                                                class="avatar-title rounded-circle bg-soft-primary text-primary font-size-18">
                                                                                                                                <i class="bx bx-message-alt"></i>
                                                                                                                            </span>
                                                                                                            </div>
                                                                                                            <h5 class="font-size-14 mb-0">Sent Today</h5>
                                                                                                        </div>
                                                                                                        <div class="text-muted mt-4">
                                                                                                            <h4>{{ $messages_sent_today }}</h4>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>


                                                                                            <div class="col-sm-4">
                                                                                                <div class="card">
                                                                                                    <div class="card-body">
                                                                                                        <div class="d-flex align-items-center mb-3">
                                                                                                            <div class="avatar-xs mr-3">
                                                                                                                            <span
                                                                                                                                class="avatar-title rounded-circle bg-soft-primary text-primary font-size-18">
                                                                                                                                <i class="bx bxs-dollar-circle"></i>
                                                                                                                            </span>
                                                                                                            </div>
                                                                                                            <h5 class="font-size-14 mb-0">Cost Today</h5>
                                                                                                        </div>
                                                                                                        <div class="text-muted mt-4">
                                                                                                            <h4>
                                                                                                                ${{ ($messages_sent_today + $messages_received_today) * $settings->sms_rate }}</h4>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div> -->


            <!-- <div class="row">
                                                                                    <div class="col-xl-12">
                                                                                        <div class="row">
                                                                                            <div class="col-sm-4">
                                                                                                <div class="card">
                                                                                                    <div class="card-body">
                                                                                                        <div class="d-flex align-items-center mb-3">
                                                                                                            <div class="avatar-xs mr-3">
                                                                                                                            <span
                                                                                                                                class="avatar-title rounded-circle bg-soft-primary text-primary font-size-18">
                                                                                                                                <i class="bx bx-message-alt-dots"></i>
                                                                                                                            </span>
                                                                                                            </div>
                                                                                                            <h5 class="font-size-14 mb-0">Received Today</h5>
                                                                                                        </div>
                                                                                                        <div class="text-muted mt-4">
                                                                                                            {{--                                        <h4>{{ $messages_received }}</h4> --}}

                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="col-sm-4">
                                                                                                <div class="card">
                                                                                                    <div class="card-body">
                                                                                                        <div class="d-flex align-items-center mb-3">
                                                                                                            <div class="avatar-xs mr-3">
                                                                                                                            <span
                                                                                                                                class="avatar-title rounded-circle bg-soft-primary text-primary font-size-18">
                                                                                                                                <i class="bx bx-message-alt"></i>
                                                                                                                            </span>
                                                                                                            </div>
                                                                                                            <h5 class="font-size-14 mb-0">Sent Today</h5>
                                                                                                        </div>
                                                                                                        <div class="text-muted mt-4">
                                                                                                            {{--                                        <h4>{{ $messages_sent }}</h4> --}}
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>


                                                                                            <div class="col-sm-4">
                                                                                                <div class="card">
                                                                                                    <div class="card-body">
                                                                                                        <div class="d-flex align-items-center mb-3">
                                                                                                            <div class="avatar-xs mr-3">
                                                                                                                            <span
                                                                                                                                class="avatar-title rounded-circle bg-soft-primary text-primary font-size-18">
                                                                                                                                <i class="bx bxs-dollar-circle"></i>
                                                                                                                            </span>
                                                                                                            </div>
                                                                                                            <h5 class="font-size-14 mb-0">Cost Today</h5>
                                                                                                        </div>
                                                                                                        <div class="text-muted mt-4">
                                                                                                            <h4>$51.04</h4>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div> -->


            <!-- <div class="row">
                                                                                    <div class="col-xl-12">
                                                                                        <div class="row">
                                                                                            <div class="col-sm-4">
                                                                                                <div class="card">
                                                                                                    <div class="card-body">
                                                                                                        <div class="d-flex align-items-center mb-3">
                                                                                                            <div class="avatar-xs mr-3">
                                                                                                                            <span
                                                                                                                                class="avatar-title rounded-circle bg-soft-primary text-primary font-size-18">
                                                                                                                                <i class="bx bx-message-alt-dots"></i>
                                                                                                                            </span>
                                                                                                            </div>
                                                                                                            <h5 class="font-size-14 mb-0">Received Today</h5>
                                                                                                        </div>
                                                                                                        <div class="text-muted mt-4">
                                                                                                            {{--                                        <h4>{{ $messages_received }}</h4> --}}

                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="col-sm-4">
                                                                                                <div class="card">
                                                                                                    <div class="card-body">
                                                                                                        <div class="d-flex align-items-center mb-3">
                                                                                                            <div class="avatar-xs mr-3">
                                                                                                                            <span
                                                                                                                                class="avatar-title rounded-circle bg-soft-primary text-primary font-size-18">
                                                                                                                                <i class="bx bx-message-alt"></i>
                                                                                                                            </span>
                                                                                                            </div>
                                                                                                            <h5 class="font-size-14 mb-0">Sent Today</h5>
                                                                                                        </div>
                                                                                                        <div class="text-muted mt-4">
                                                                                                            {{--                                        <h4>{{ $messages_sent }}</h4> --}}
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>


                                                                                            <div class="col-sm-4">
                                                                                                <div class="card">
                                                                                                    <div class="card-body">
                                                                                                        <div class="d-flex align-items-center mb-3">
                                                                                                            <div class="avatar-xs mr-3">
                                                                                                                            <span
                                                                                                                                class="avatar-title rounded-circle bg-soft-primary text-primary font-size-18">
                                                                                                                                <i class="bx bxs-dollar-circle"></i>
                                                                                                                            </span>
                                                                                                            </div>
                                                                                                            <h5 class="font-size-14 mb-0">Cost Today</h5>
                                                                                                        </div>
                                                                                                        <div class="text-muted mt-4">
                                                                                                            <h4>$51.04</h4>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div> -->
            {{--
                        <div class="card">
                            <div class="card-header bg-soft-dark">
                                Latest Replies
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="container">
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Order ID</th>
                                                    <th scope="col">User Name</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Total</th>
                                                    <th scope="col">Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                <tr>
                                                    <th>1</th>
                                                    <th>1</th>
                                                    <td>1</td>
                                                    <td>1</td>
                                                    <td>$1</td>
                                                    <td>
                                                        <a class="btn btn-outline-primary btn-sm text-primary" href="#" title="View1"><i class="fas fa-eye"></i></a>
                                                    </td>
                                                </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
            --}}
        </div> <!-- container-fluid -->
    </div>
@endsection
@section('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        $(function() {
            $('input[name="datefilter"]').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                },
                showCustomRangeLabel: true,
                autoApply: true,
                opens: 'left'
            });

            $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format(
                    'MM/DD/YYYY'));
                fetchCustomRangeStats(picker.startDate, picker.endDate)
            });

            $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });

        function blink_text() {
            $('.blink').fadeOut(500);
            $('.blink').fadeIn(500);
        }

        function fetchCustomRangeStats(start_date, end_date) {
            var formData = new FormData();
            formData.append('start_date', start_date)
            formData.append('end_date', end_date)

            // if (!start_date.trim() || !end_date.trim()) {
            //     // Handle the case where 'listName' is empty
            //     alert("Date range is required.");
            //     return; // Abort the form submission
            // }

            var csrfToken = $('input[name="_token"]').val(); // Replace with your CSRF token input name

            // Send the data to the server via AJAX
            $.ajax({
                method: "POST",
                url: "{{ route('admin.goals') }}", // Replace with your route
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    if (response.status === true) {
                        toastr.success(response.message, {
                            timeOut: 1000,
                        });

                        // Loop through the data and update the corresponding <td> elements
                        Object.keys(response.data).forEach(function(id) {
                            var td = document.getElementById(id);
                            if (td) {
                                td.textContent = response.data[id];
                            }
                        });

                    } else {
                        toastr.error(response.message, {
                            timeOut: 9000,
                        });
                    }
                },
                error: function(response) {
                    toastr.error('API Error: ' + response.responseText, 'API Response Error', {
                        timeOut: 9000,
                    });
                }
            });
        }

        setInterval(blink_text, 1000);
    </script>
@endsection
