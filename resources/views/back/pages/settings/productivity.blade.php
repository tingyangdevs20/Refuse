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
                                                  
                                                </div>

                                                <div class="card-body">
                                                  <form action="{{ route('admin.settings.update', $settings) }}" method="post"
                                                      enctype="multipart/form-data">
                                                      @csrf
                                                      @method('PUT')
                                                      @include('back.pages.partials.messages')
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            Task Lists
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

                                            

                                            
                                                      <button type="submit" class="btn btn-primary" style="background-color:#38B6FF;border-color:#38B6FF">Update Settings</button>
                                                 </form>
                                                </div>
                                          </div>
                                       </div>
                                      <!-- TAB 1 CONTENT ENDS -->

                                       <!-- TAB 2 CONTENT -->
                                       <div class="tab-pane" id="MarketingSpends">
                                          <div class="card">
                                               <div class="card-header bg-soft-dark ">
                                                  <i class="fas fa-cog mr-1"></i>Marketing Spends
                                                  
                                                </div>

                                                <div class="card-body">
                                                  <form action="{{ route('admin.settings.update', $settings) }}" method="post"
                                                      enctype="multipart/form-data">
                                                      @csrf
                                                      @method('PUT')
                                           

                                            

                                            
                                                      <button type="submit" class="btn btn-primary" style="background-color:#38B6FF;border-color:#38B6FF">Update Settings</button>
                                                 </form>
                                                </div>
                                          </div>
                                       </div>
                                      <!-- TAB 2 CONTENT ENDS -->
                                      













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
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script></script>
@endsection
