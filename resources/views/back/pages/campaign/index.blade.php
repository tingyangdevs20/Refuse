<!-- resources/views/back/pages/campaign/index.blade.php -->

@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet"/>
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">Campaigns</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Dashboard</a></li>
                                <li class="breadcrumb-item">Lead Generation </li>
                                <li class="breadcrumb-item active">Campaigns</li>
                            </ol>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark">
                            All Campaigns
                            <button class="btn btn-outline-primary btn-sm float-right" title="New" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus-circle"></i></button>
                            <button class="btn btn-outline-primary btn-sm float-right" title="helpModal" data-toggle="modal"
    data-target="#helpModal">How to use</button>  
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
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($campaigns as $campaign)
                                    <tr>
                                        <td><a href="{{ route('admin.campaign.list',$campaign->id) }}">{{ $campaign->name }}</a></td>
                                        <!--<td>{{ $campaign->type }}</td>-->
                                        <!--<td>{{ $campaign->send_after_days }}</td>-->
                                        <!--<td>{{ $campaign->send_after_hours }}</td>-->
                                        <td>{{ optional($campaign->group)->name ?? "N/A" }}</td>
                                        <td>
                                            <a href="{{ route('admin.compaign.copy', $campaign->id) }}"><button data-toggle="modal" class="btn btn-outline-warning" >Copy</button></a>
                                            <button data-toggle="modal" class="btn btn-outline-primary" id="editModal" data-target="#editCampaignModal" data-name="{{ $campaign->name }}" data-type="{{ $campaign->type }}" data-template="{{ $campaign->template_id }}" data-sendafterdays="{{ $campaign->send_after_days }}" data-sendafterhours="{{ $campaign->send_after_hours }}"data-group="{{ $campaign->group_id }}"  data-id="{{ $campaign->id }}">Edit</button>
                                            <form action="{{ route('admin.campaigns.destroy', $campaign->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
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



       {{--Modal Add on 31-08-2023--}}
    <div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">How to Use</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        
      </div>
     
      <div class="modal-body">
            
        <div style="position:relative;height:0;width:100%;padding-bottom:65.5%">
         <iframe src="" frameBorder="0" style="position:absolute;width:100%;height:100%;border-radius:6px;left:0;top:0" allowfullscreen="" allow="autoplay">
         </iframe>
        </div>
        <form action="" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
            <div class="form-group">
                <label>Video Url</label>
                <input type="url" class="form-control" placeholder="Enter link" name="video_url" value="" id="video_url" >
            </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
    {{--End Modal on 31-08-2023--}}


    <!-- Add Campaign Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
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
                    <form action="{{ route('admin.campaigns.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">Campaign Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <!--<div class="form-group">-->
                        <!--    <label for="type">Campaign Type</label>-->
                        <!--    <select name="type" id="type" class="form-control" onchange="getTemplate(value)" required>-->
                        <!--        <option value="sms">SMS</option>-->
                        <!--        <option value="email">Email</option>-->
                        <!--        <option value="mms">MMS</option>-->
                        <!--        <option value="rvm">RVM</option>-->
                        <!--    </select>-->
                        <!--</div>-->
                        <!--<div class="form-group" id="update-templates">-->
                        <!--    <label>Select Template</label>-->
                        <!--    <select class="custom-select" name="template_id" id="template-select">-->
                        <!--        <option value="0">Select Template</option>-->
                        <!--        @foreach($templates as $template)-->
                        <!--            <option value="{{ $template->id }}">{{ $template->title }}</option>-->
                        <!--        @endforeach-->
                        <!--    </select>-->
                        <!--</div>-->
                         <!-- Add schedule field -->
                        <!--<div class="form-group">-->
                        <!--    <label for="send_after_days">Send After Days</label>-->
                        <!--    <input type="number" name="send_after_days" id="send_after_days" class="form-control" required>-->
                        <!--</div>-->
                        
                        <!--<div class="form-group">-->
                        <!--    <label for="send_after_hours">Send After Hours</label>-->
                        <!--    <input type="number" name="send_after_hours" id="send_after_hours" class="form-control" required>-->
                        <!--</div>-->
                        <div class="form-group">
                            <label for="group_id">Select Group/Contact List</label>
                            <select name="group_id" id="group_id" class="form-control">
                                <option value="">Select Group/Contact List</option>
                                @if(isset($groups))
                                    @foreach ($groups as $group)
                                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="active">Active Status</label>
                            <select name="active" id="active" class="form-control" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Save Campaign</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Campaign Modal -->
    <div class="modal fade" id="editCampaignModal" tabindex="-1" role="dialog" aria-labelledby="editCampaignModalLabel"
        aria-hidden="true">
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
                        <form action="{{ route('admin.campaigns.update', $campaign->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Campaign Name</label>
                            <input type="hidden" name="id" id="id_edit" class="form-control" value="0" required>
                            <input type="text" name="name" id="name_edit" class="form-control" value="" required>
                        </div>
                        <!--<div class="form-group">-->
                        <!--    <label for="type">Campaign Type</label>-->
                        <!--    <select name="type" id="type_edit" class="form-control" onchange="getTemplateEdit(value)" required>-->
                        <!--        <option value="sms" >SMS</option>-->
                        <!--        <option value="email">Email</option>-->
                        <!--        <option value="mms">MMS</option>-->
                        <!--        <option value="rvm">RVM</option>-->
                        <!--    </select>-->
                        <!--</div>-->
                        <!--<div class="form-group" id="update-templates-edit">-->
                        <!--    <label>Select Template</label>-->
                        <!--    <select class="custom-select" name="template_id" id="template-select-edit">-->
                        <!--        <option value="0">Select Template</option>-->
                        <!--        @foreach($templates as $template)-->
                        <!--            <option value="{{ $template->id }}">{{ $template->title }}</option>-->
                        <!--        @endforeach-->
                        <!--    </select>-->
                        <!--</div>-->
                        <!-- Edit schedule field -->
                        <!--<div class="form-group">-->
                        <!--    <label for="send_after_days">Send After Days</label>-->
                        <!--    <input type="number" name="send_after_days" id="send_after_days_edit" class="form-control" value="" required>-->
                        <!--</div>-->
                        
                        <!--<div class="form-group">-->
                        <!--    <label for="send_after_hours">Send After Hours</label>-->
                        <!--    <input type="number" name="send_after_hours" id="send_after_hours_edit" class="form-control" value="" required>-->
                        <!--</div>-->
                        <div class="form-group">
                            <label for="group_id">Select Group/Contact List</label>
                            <select name="group_id" id="group_id_edit" class="form-control">
                                <option value="">Select Group/Contact List</option>
                                @if(isset($groups))
                                    @foreach ($groups as $group)
                                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <!-- Add other fields for campaign details -->
                        <!-- For example, schedule, message content, etc. -->
                        <div class="form-group">
                            <label for="active">Active Status</label>
                            <select name="active" id="active" class="form-control" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Campaign</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    function getTemplate(type){
        var url = '<?php echo url('/admin/get/template/') ?>/'+type;
        $.ajax({
            type: 'GET',
            url: url,
            data: '',
            processData: false,
            contentType: false,
            success: function (d) {
                $('#update-templates').html(d);
            }
        });
    }
    
    
    $('#editCampaignModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);// Button that triggered the modal
        var name = button.data('name');
        var type = button.data('type');
        var template_id = button.data('template');
        getTemplateEdit(type,template_id);
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
    
    function getTemplateEdit(type,template_id){
        var url = '<?php echo url('/admin/get/template/') ?>/'+type;
        $.ajax({
            type: 'GET',
            url: url,
            data: '',
            processData: false,
            contentType: false,
            success: function (d) {
                $('#update-templates-edit').html(d);
                setTimeout(function() {
                    $('#template-select-edit').val(template_id);
                }, 500);
                
            }
        });
    }
</script>
@endsection
