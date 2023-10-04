<!-- resources/views/back/pages/campaign/index.blade.php -->

@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
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
                            Prospect Campaigns
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
                                    <th scope="col">Contact Campaign Name</th>
                                    
                                    <th scope="col">Contact list</th>
                                    <th scope="col">Created On</th>

                                    <th scope="col">Action</th>
                                    <th scope="col">Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($campaigns as $campaign)
                                    <tr>
                                        <td><a href="{{ route('admin.campaign.list',$campaign->id) }}">{{ $campaign->name }}</a></td>
                                     
                                        <td>{{ optional($campaign->group)->name ?? "N/A" }}</td>
                                        <td>{{ $campaign->created_at }}</td>
                                      
                                        <td>
                                            <a href="{{ route('admin.compaign.copy', $campaign->id) }}"><button data-toggle="modal" class="btn btn-outline-warning" >Copy</button></a>
                                            <button data-toggle="modal" class="btn btn-outline-primary" id="editModal" data-target="#editCampaignModal" data-name="{{ $campaign->name }}" data-type="{{ $campaign->type }}" data-template="{{ $campaign->template_id }}" data-sendafterdays="{{ $campaign->send_after_days }}" data-sendafterhours="{{ $campaign->send_after_hours }}"data-group="{{ $campaign->group_id }}"  data-id="{{ $campaign->id }}">Edit</button>
                                            {{-- <form action="{{ route('admin.campaigns.destroy', $campaign->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this game?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form> --}}
                                            <button class="btn btn-danger" title="Remove {{ $campaign->name }}" data-id="{{ $campaign->id }}" data-toggle="modal" data-target="#deleteModal">Delete</button>
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
                       

                        <!-- Add other fields for campaign details -->
                        <!-- For example, schedule, message content, etc. -->
                        

                        <button type="submit" class="btn btn-primary">Update Campaign</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{--Modal Delete--}}
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.campaigns.destroy','test') }}" method="post" id="editForm">
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
@endsection
@section('scripts')
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

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
            
                axios.post('campaign/changeStatus', data)
                    .then(response => {
                            if (response.data.status == 200) {
                               //alert("updated");
                            }
                                })
                            
                        }
                    )
                  
            
  
   
</script>
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
    $(document).ready(function(){
        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
        });
    });

</script>
@endsection
