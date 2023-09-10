<!-- resources/views/back/pages/campaign/edit.blade.php -->
@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet"/>
@endsection
@section('content')
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
                    <!-- Add the form for editing the campaign here -->
                    <form action="{{ route('admin.campaigns.update', $campaign->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Campaign Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $campaign->name }}"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="type">Campaign Type</label>
                            <select name="type" id="type" class="form-control" required>
                                <option value="email" {{ $campaign->type === 'email' ? 'selected' : '' }}>Email</option>
                                <option value="sms" {{ $campaign->type === 'sms' ? 'selected' : '' }}>SMS</option>
                                <option value="mms" {{ $campaign->type === 'mms' ? 'selected' : '' }}>MMS</option>
                                <option value="rvm" {{ $campaign->type === 'rvm' ? 'selected' : '' }}>RVM</option>
                            </select>
                        </div>
                        <!-- Add other fields for campaign details -->
                        <!-- For example, schedule, message content, etc. -->

                        <button type="submit" class="btn btn-primary">Update Campaign</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add any required scripts for the popup here -->
@endsection
