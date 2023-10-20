<!-- resources/views/back/pages/campaign/index.blade.php -->

@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">Prospect Campaigns</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item">Lead Generation </li>
                                <li class="breadcrumb-item active">Prospect Campaigns</li>
                            </ol>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark">
                            All Campaigns
                            <button class="btn btn-outline-primary btn-sm float-right ml-2" title="New"
                                data-toggle="modal" data-target="#createModal"><i class="fas fa-plus-circle"></i></button>
                            {{-- <button class="btn btn-outline-primary btn-sm float-right mr-2" title="helpModal" data-toggle="modal"
                                data-target="#helpModal">How to Use</button>   --}}
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
                                            <th scope="col">Contact list</th>
                                            <th scope="col">No. Of Contacts</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($campaigns as $campaign)
                                            <tr>
                                                <td><a
                                                        href="{{ route('admin.campaign.list', $campaign->id) }}">{{ $campaign->name }}</a>
                                                </td>


                                                <td>{{ optional($campaign->group)->name ?? 'N/A' }}</td>
                                                <td>{{ optional($campaign->group)->getContactsCount() }}</td>
                                                <td>
                                                    <a href="{{ route('admin.compaign.copy', $campaign->id) }}"><button
                                                            data-toggle="modal"
                                                            class="btn btn-outline-warning">Copy</button></a>
                                                    <button data-toggle="modal" class="btn btn-outline-primary"
                                                        id="editModal" data-target="#editCampaignModal"
                                                        data-name="{{ $campaign->name }}" data-type="{{ $campaign->type }}"
                                                        data-template="{{ $campaign->template_id }}"
                                                        data-sendafterdays="{{ $campaign->send_after_days }}"
                                                        data-sendafterhours="{{ $campaign->send_after_hours }}"data-group="{{ $campaign->group_id }}"
                                                        data-id="{{ $campaign->id }}">Edit</button>
                                                    <form action="{{ route('admin.campaigns.destroy', $campaign->id) }}"
                                                        method="POST" style="display: inline-block;">
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
                    <form action="{{ route('admin.campaigns.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">Campaign Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
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
                                <input type="hidden" name="id" id="id_edit" class="form-control" value="0"
                                    required>
                                <input type="text" name="name" id="name_edit" class="form-control" value=""
                                    required>
                            </div>






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
