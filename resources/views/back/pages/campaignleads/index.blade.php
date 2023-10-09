<!-- resources/views/back/pages/campaign/index.blade.php -->

@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">Lead Campaigns</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item">Lead Campaigns </li>
                                <li class="breadcrumb-item active">Campaigns</li>
                            </ol>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark">
                            All Lead Campaigns
                            <button class="btn btn-outline-primary btn-sm float-right" title="New" data-toggle="modal"
                                data-target="#createModal"><i class="fas fa-plus-circle"></i></button>
                                <button class="btn btn-outline-primary btn-sm float-right mr-2" title="helpModal" data-toggle="modal"
                        data-target="#helpModal">Use this Section</button>  
                        @include('components.modalform')
                        </div>
                        <div class="card-body">
                            @if ($campaigns->isEmpty())
                                <p>No campaigns available.</p>
                            @else
                                <table class="table table-striped table-bordered" id="datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <!--<th scope="col">Type</th>-->
                                            <!--<th scope="col">Send after days</th>-->
                                            <!--<th scope="col">Send after hours</th>-->
                                            <th scope="col">Contact list</th>
                                            <th scope="col">Action</th>
                                            <th scope="col">Status</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($campaigns as $campaign)
                                            <tr>
                                                <td><a
                                                        href="{{ route('admin.compaignlead.list', $campaign->id) }}">{{ $campaign->name }}</a>
                                                </td>
                                                <!--<td>{{ $campaign->type }}</td>-->
                                                <!--<td>{{ $campaign->send_after_days }}</td>-->
                                                <!--<td>{{ $campaign->send_after_hours }}</td>-->
                                                <td>{{ optional($campaign->group)->name ?? 'N/A' }}</td>
                                                <td>
                                                    <a href="{{ route('admin.compaignlead.copy', $campaign->id) }}"><button
                                                            data-toggle="modal"
                                                            class="btn btn-outline-warning">Copy</button></a>
                                                    <button data-toggle="modal" class="btn btn-outline-primary"
                                                        id="editModal" data-target="#editCampaignModal"
                                                        data-name="{{ $campaign->name }}" data-type="{{ $campaign->type }}"
                                                        data-template="{{ $campaign->template_id }}"
                                                        data-sendafterdays="{{ $campaign->send_after_days }}"
                                                        data-sendafterhours="{{ $campaign->send_after_hours }}"data-group="{{ $campaign->group_id }}"
                                                        data-id="{{ $campaign->id }}">Edit</button>
                                                    <form action="{{ route('admin.leadcampaign.destroy', $campaign->id) }}"
                                                        method="POST" class="delete-form" style="display: inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger delete-btn"
                                                            data-toggle="modal" data-target="#confirmationModal">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </td>
                                                <td>
                                                <input data-id="{{$campaign->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $campaign->active ? 'checked' : '' }}>
                    
</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
        </div> <!-- container-fluid -->
    </div>
    <!-- Add Campaign Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Create Campaign</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- For example, you can use Laravel Collective's Form or standard HTML form -->
                    <!-- Add the form for adding the campaign here -->
                    <form action="{{ route('admin.leadcampaign.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">Campaign Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="group_id">Select Group/Contact List</label>
                            <select name="group_id" id="group_id" class="form-control">
                                <option value="">Select Group/Contact List</option>
                                @if (isset($groups))
                                    @foreach ($groups as $group)
                                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                       
                        <button type="submit" class="btn btn-primary">Save Campaign</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Campaign Modal -->
    <div class="modal fade" id="editCampaignModal" tabindex="-1" role="dialog"
        aria-labelledby="editCampaignModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCampaignModalLabel">Edit Campaign</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @isset($campaign)
                        <!-- Add the form for editing the campaign here -->
                        <form action="{{ route('admin.leadcampaign.update', $campaign->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Campaign Name</label>
                                <input type="hidden" name="id" id="id_edit" class="form-control" value="0"
                                    required>
                                <input type="text" name="name" id="name_edit" class="form-control" value=""
                                    required>
                            </div>
                            
                            <div class="form-group">
                                <label for="group_id">Select Group/Contact List</label>
                                <select name="group_id" id="group_id_edit" class="form-control">
                                    <option value="">Select Group/Contact List</option>
                                    @if (isset($groups))
                                        @foreach ($groups as $group)
                                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <!-- Add other fields for campaign details -->
                            <!-- For example, schedule, message content, etc. -->
                          

                            <button type="submit" class="btn btn-primary">Update Campaign</button>
                        </form>
                        @endif
                    </div>
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
                        Are you sure you want to delete this lead campgain?
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>


<script>
    
    
         $('.toggle-class').change(function() { 
            var status = $(this).prop('checked') == true ? 1 : 0;  
           var camp_id = $(this).data('id');  
          // alert(camp_id);
        let data = {
            camp_id: camp_id,
                sts: status,
               
            }
            
                axios.post('leadcampaign/changeStatus', data)
                    .then(response => {
                            if (response.data.status == 200) {
                               //alert("updated");
                            }
                                })
                            
                        }
                    )
                  
            
  
   
</script>
<script>
            $(document).ready(function() {
                $(".delete-btn").click(function() {
                    // Get the form associated with this delete button
                    var form = $(this).closest(".delete-form");

                    // Set the form action URL to the delete route
                    var actionUrl = form.attr("action");

                    // When the user confirms deletion, send an AJAX request
                    $(".confirm-delete-btn").click(function() {
                        $.ajax({
                            url: actionUrl,
                            type: "POST",
                            data: {
                                "_method": "DELETE",
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function(res) {
                                if (res.status == true) {
                                    // Sends a notification
                                    // Customize the Toastr message based on your requirements
                                    toastr.success(res.message, {
                                        timeOut: 10000, // Set the duration (10 seconds in this example)
                                    });

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
            });

            function getTemplate(type) {
                var url = '<?php echo url('/admin/get/template/'); ?>/' + type;
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: '',
                    processData: false,
                    contentType: false,
                    success: function(d) {
                        $('#update-templates').html(d);
                    }
                });
            }


            $('#editCampaignModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var name = button.data('name');
                var type = button.data('type');
                var template_id = button.data('template');
                getTemplateEdit(type, template_id);
                var id = button.data('id');
                var sendafterdays = button.data('sendafterdays');
                var sendafterhours = button.data('sendafterhours');
                var group_id = button.data('group');
                var modal = $(this);

                $('#name_edit').val(name);
                $('#id_edit').val(id);
                $('#type_edit').val(type);
                $('#send_after_days_edit').val(sendafterdays);
                $('#send_after_hours_edit').val(sendafterhours);
                $('#group_id_edit').val(group_id);
            });

            function getTemplateEdit(type, template_id) {
                var url = '<?php echo url('/admin/get/template/'); ?>/' + type;
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: '',
                    processData: false,
                    contentType: false,
                    success: function(d) {
                        $('#update-templates-edit').html(d);
                        setTimeout(function() {
                            $('#template-select-edit').val(template_id);
                        }, 500);

                    }
                });
            }
        </script>
    @endsection
