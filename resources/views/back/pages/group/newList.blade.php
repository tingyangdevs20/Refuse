@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
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
                        <h4 class="mb-0 font-size-18">LISTS MANAGEMENT</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.group.index') }}">LISTS MANAGEMENT</a>
                                </li>
                            </ol>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            <i class="fas fa-cog"></i> New List
                            <button class="btn btn-outline-primary btn-sm float-right mr-2" title="helpModal"
                                data-toggle="modal" data-target="#helpModal">How to Use</button>
                            @include('components.modalform')
                        </div>
                        <div class="card-body">

                            <div class="form-group" style="display: none">
                                <select class="from-control" style="width: 100%;" required id="optiontype"
                                    name="optiontype">
                                    <option value="0">Select Option</option>

                                    <option value="new" selected>Create New List</option>
                                    <option value="update">Update Existing List</option>

                                </select>
                            </div>

                            <div class="form-group">
                                <label style="margin-right:50px">List Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Enter List Name"
                                    required>
                            </div>

                            <div class="form-group" style="display: none">
                                <select class="from-control" style="width: 100%;" id="existing_group_id"
                                    name="existing_group_id">
                                    <option value="0">Select Existing List</option>
                                    @foreach ($groups as $group)
                                        <option value="{{ $group->id }}" selected>{{ $group->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group" style="display: none">
                                <label>Select Campaign</label>
                                <select class="custom-select" name="campaign_id" id="campaign_id">
                                    <option value="0">Select Campaign</option>
                                    @if (count($campaigns) > 0)
                                        @foreach ($campaigns as $campaign)
                                            <option value="{{ $campaign->id }}" selected>{{ $campaign->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="form-group pt-2" style="display: none">
                                <label>Market</label><br>
                                <select class="custom-select" style="width: 100%;" id="market" name="market_id" required>
                                    <option value="">Select Market</option>
                                    @foreach ($markets as $market)
                                        <option value="{{ $market->id }}" selected>{{ $market->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group pt-2">
                                <label>Select Tag</label><br>
                                <select class="custom-select select2" required multiple="multiple" style="width: 100%;"
                                    name="tag_id[]" id="tags">
                                    <option value="" disabled>Select Tag</option>
                                    @foreach ($tags as $tag)
                                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group" style="display: none">
                                <label>Select Email Template</label>
                                <select class="custom-select" name="email_template" id="email_template">
                                    @if (count($form_Template) > 0)
                                        @foreach ($form_Template as $email_template)
                                            <option value="{{ $email_template->id }}" selected>
                                                {{ $email_template->template_name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="form-group pt-2">
                                <label>Select Lead Source</label>
                                <select class="custom-select select2" name="lead_source" style="width: 100%;">
                                    <option value="">Lead Source</option>
                                    <option value="Bandit Signs">
                                        Bandit Signs
                                    </option>
                                    <option value="Billboards">Billboards
                                    </option>
                                    <option value="Cold Calling">Cold Calling
                                    </option>
                                    <option value="Direct Mail">
                                        Direct Mail
                                    </option>
                                    <option value="Door Knocking">
                                        Door Knocking
                                    </option>
                                    <option value="Email">
                                        Email
                                    </option>
                                    <option value="Facebook Ads">
                                        Facebook Ads
                                    </option>
                                    <option value="Flyers">
                                        Flyers
                                    </option>
                                    <option value="Instagram Ads">
                                        Instagram Ads
                                    </option>
                                    <option value="iSpeedToLead">
                                        iSpeedToLead
                                    </option>
                                    <option value="LinkedIn Ads">
                                        LinkedIn Ads
                                    </option>
                                    <option value="Magazine">
                                        Magazine
                                    </option>
                                    <option value="MMS">
                                        MMS
                                    </option>
                                    <option value="Newspaper">
                                        Newspaper
                                    </option>
                                    <option value="Phone Call (Incoming)">
                                        Phone Call (Incoming)
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

                            <div class="form-group pt-2">
                                <label>Select Lead Type</label>
                                <select class="custom-select select2" multiple name="lead_type" style="width: 100%;">
                                    <option value="">Lead
                                        Type
                                    </option>
                                    <option value="Agents">Agents
                                    </option>

                                    <option value="Attorney">Attorney
                                    </option>

                                    <option value="Buyer (Investors)">Buyer (Investors)
                                    </option>

                                    <option value="Buyer (Owner Financing)">Buyer (Owner Financing)
                                    </option>

                                    <option value="Buyer (Retail)">Buyer (Retail)
                                    </option>

                                    <option value="Code Enforcement">Code Enforcement
                                    </option>

                                    <option value="Mortgage Brokers">Mortgage Brokers
                                    </option>

                                    <option value="Seller">Seller
                                    </option>

                                    <option value="Title Company">Title Company
                                    </option>

                                    <option value="Wholesaler">Wholesaler
                                    </option>

                                    <option value="Other">Other
                                    </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="file">Select CSV to upload:</label>
                                <form action="/admin/google-drive-login" class="dropzone" name="file"
                                    id="my-awesome-dropzone" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="fallback">
                                    </div>
                                    <input type="hidden" name="hiddenFile" id="hidden-file">
                                </form>
                            </div>

                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/dropzone@5.9.3/dist/min/dropzone.min.js"></script>
    <script src="{{ asset('back/assets/js/pages/user-agreement.js?t=') }}<?= time() ?>"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();

            // initializeDropzone
            initializeDropzone();

            // Inittialize Select2
            initializeSelect2();
        });
    </script>

    <script>
        // intitialize dropzone
        function initializeDropzone() {

            Dropzone.options.myAwesomeDropzone = {
                url: "admin/google-drive-login", // URL where files will be uploaded (replace with your actual endpoint)
                paramName: "file", // The name that will be used for the uploaded file
                maxFilesize: 5, // Maximum file size (in MB)
                acceptedFiles: ".csv", // Accepted file types
                maxFiles: 1, // Maximum number of files that can be uploaded
                autoProcessQueue: true, // Automatically process the queue when files are added
                addRemoveLinks: true, // Show remove links on uploaded files
                dictDefaultMessage: "Drop files here or click to upload", // Default message displayed on the Dropzone area
                dictFallbackMessage: "Your browser does not support drag and drop file uploads.",
                dictFallbackText: "Please use the fallback form below to upload your files.",
                dictRemoveFile: "Remove", // Text for the remove file link
                dictCancelUpload: "Cancel", // Text for the cancel upload link
                dictCancelUploadConfirmation: "Are you sure you want to cancel this upload?",
                init: function() {
                    this.on("addedfile", function(file) {
                        // Event handler when a file is added to the queue
                    });

                    this.on("success", function(file, response) {
                        // Event handler when a file upload is successful
                    });

                    this.on("removedfile", function(file) {
                        // Event handler when a file is removed from the queue
                    });

                    this.on("error", function(file, errorMessage) {
                        // Event handler when a file upload encounters an error
                    });
                }
            };
        }

        // Initialize Select2
        function initializeSelect2() {
            // Initialize Select2
            $('.select2').select2({
                // placeholder: "Select options",
                allowClear: true, // Show a clear button to remove the selection
            });
            $('#tags').on('change', function() {
                // Remove the "Select Tags" option if any other option is selected
                if ($('#tags option:selected').length > 0) {
                    $('#tags option[value=""]').remove();
                } else {
                    // Add the "Select Tags" option back if no options are selected
                    $('#tags').prepend('<option value="" selected disabled>Select Tags</option>');
                }
            });

            // Refresh Select2 to apply the changes
            $('.select2').trigger('change.select2');
        }
    </script>
@endsection
