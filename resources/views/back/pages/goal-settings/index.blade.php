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
                    <h5 class="modal-title" id="addCampaignModalLabel">Add Goals</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Add the form for adding the campaign here -->
                    <form action="{{ route('admin.savegoals') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">People to contact Per Day</label>
                            <input type="text" name="contact_people" id="contact_people" class="form-control numeric" value="{{$goalValue}}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Goal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add any required scripts for the popup here -->
    @section('scripts')
    <script>
        $(window).on('load', function() {
        $('#addCampaignModal').modal('show');
    });
            // $("#addCampaignModal").show();
        $(document).on("input", ".numeric", function (e) {
        this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');
    });

    </script>
    @endsection

@endsection
