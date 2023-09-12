<!-- resources/views/back/pages/campaign/create.blade.php -->
@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet"/>
@endsection
@section('content')
    <div class="modal fade" id="addCampaignModal" tabindex="-1" role="dialog" aria-labelledby="addCampaignModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCampaignModalLabel">Add Campaign</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Add the form for adding the campaign here -->
                    <form action="{{ route('admin.campaigns.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">Campaign Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="type">Campaign Type</label>
                            <select name="type" id="type" class="form-control" required>
                                <option value="email">Email</option>
                                <option value="sms">SMS</option>
                                <option value="mms">MMS</option>
                                <option value="rvm">RVM</option>
                            </select>
                        </div>
                        <!-- Add other fields for campaign details -->
                        <!-- For example, schedule, message content, etc. -->

                        <button type="submit" class="btn btn-primary">Save Campaign</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add any required scripts for the popup here -->
@endsection
