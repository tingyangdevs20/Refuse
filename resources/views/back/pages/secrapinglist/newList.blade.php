@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
    <style>
        span.select2-selection.select2-selection--single {
            height: 40px;
        }
    </style>

    <style>
        /* Apply 100% width to the Select2 element */
        .select2 {
            width: 100%;
        }

        /* Style the Select2 container to match Bootstrap form-control */
        .select2-container {
            width: 100% !important;
        }

        /* Style the Select2 input element */
        .select2-selection {
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            padding: 0.23rem 0;
            min-height: 36px;
            line-height: 1.5;
            /* Adjust the line-height to vertically center the content */
        }

        /* Style the Select2 single selection text */
        .select2-selection__rendered {
            color: #333;
            /* Text color */
        }

        .select2-selection__arrow {
            top: 3px !important;
        }

        /* Style the Select2 dropdown to match Bootstrap styles */
        .select2-dropdown {
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
        }

        /* Style the Select2 option hover state to match Bootstrap styles */
        .select2-results__option--highlighted {
            background-color: #007bff;
            color: #fff;
        }

        /* Style the Select2 placeholder text */
        .select2-selection__placeholder {
            color: #6c757d;
            /* Set the color you prefer */
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
                        <h4 class="mb-0 font-size-18">Scraping Data</h4>
                       
                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            Push To Lists
                            <a href="{{ URL::previous() }}" class="btn btn-outline-primary btn-sm float-right ml-2"
                                title="New"><i class="fas fa-arrow-left"></i></a>
                            @include('components.modalform')
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-md-6">
                                    <form action="{{ route('admin.scraping.push', $scraping->id) }}" method="POST">
                                        @csrf
                                        <div class="form-group" style="display: none">
                                            <select class="from-control" style="width: 100%;" required id="optiontype"
                                                name="optiontype">
                                                <option value="0">Select Option</option>

                                                <option value="new" selected>Create New List</option>
                                                <option value="update">Update Existing List</option>

                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control" required name="list_name"
                                                placeholder="Enter List Name *" value="{{ $scraping->job_name }}" required>
                                        </div>

                                        <div class="form-group pt-2">
                                            <select class="custom-select select2" required multiple="multiple"
                                                style="width: 100%;" name="tag_id[]" id="tags">
                                                @foreach ($tags as $tag)
                                                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group pt-2">
                                            <select class="custom-select select2" name="lead_status" style="width: 100%;">
                                                <option value="">Select Lead Status *</option>
                                                <option value="None/Unknown">
                                                    None/Unknown
                                                </option>
                                                <option value="Prospect" selected>
                                                    Prospect
                                                </option>
                                                <option value="DNC">DNC</option>
                                                <option value="Lead-New">
                                                    Lead-New
                                                </option>

                                                <option value="Lead-Cold">
                                                    Lead-Cold
                                                </option>
                                                <option value="Lead-Warm">
                                                    Lead-Warm
                                                </option>
                                                <option value="Lead-Hot">
                                                    Lead-Hot
                                                </option>
                                                <option value="Send to Research">
                                                    Send to Research
                                                </option>

                                                <option value="Not Available - Not Selling">
                                                    Not Available -
                                                    Not Selling
                                                </option>

                                                <option value="Not Available - Sold Property">
                                                    Not Available -
                                                    Sold Property
                                                </option>

                                                <option value="Not Available - Under Contract w/3rd Party">
                                                    Not Available -
                                                    Under Contract w/3rd Party
                                                </option>

                                                <option value="Not Interested">
                                                    Not Interested
                                                </option>

                                                <option value="Non-Responsive">
                                                    Non-Responsive
                                                </option>

                                                <option value="Maybe to Our Offer">
                                                    Maybe to Our
                                                    Offer
                                                </option>

                                                <option value="Phone Call - Scheduled">
                                                    Phone Call -
                                                    Scheduled
                                                </option>

                                                <option value="Phone Call - Completed">
                                                    Phone Call -
                                                    Completed
                                                </option>

                                                <option value="Phone Call - No Show">
                                                    Phone Call - No
                                                    Show
                                                </option>

                                                <option value="Phone Call - Said No">
                                                    Phone Call -
                                                    Said No
                                                </option>

                                                <option value="Contract Out - Buy Side">
                                                    Contract Out -
                                                    Buy Side
                                                </option>

                                                <option value="Contract Out - Sell Side">
                                                    Contract Out -
                                                    Sell Side
                                                </option>

                                                <option value="Contract Signed - Buy Side">
                                                    Contract Signed
                                                    - Buy Side
                                                </option>

                                                <option value="Contract Signed - Sell Side">
                                                    Contract Signed
                                                    - Sell Side
                                                </option>

                                                <option value="Closed Deal - Buy Side">
                                                    Closed Deal -
                                                    Buy Side
                                                </option>
                                                <option value="Closed Deal - Sell Side">
                                                    Closed Deal -
                                                    Sell Side
                                                </option>
                                                <option value="Rehab in Process">
                                                    Rehab in Process
                                                </option>
                                                <option value="Hold - Rental">
                                                    Hold - Rental
                                                </option>
                                                <option value="For Sale (by Us)">
                                                    For Sale (by Us)
                                                </option>
                                                <option value="Closed Deal - Buy Side">
                                                    Closed Deal -
                                                    Buy Side
                                                </option>
                                                <option value="Closed Deal - Sell Side">
                                                    Closed Deal -
                                                    Sell Side
                                                </option>
                                            </select>
                                        </div>

                                        <div class="form-group pt-2">
                                            <select class="custom-select select2" name="lead_source" style="width: 100%;">
                                                <option value="">Select Lead Source</option>
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
                                            <select class="custom-select select2" name="lead_type" style="width: 100%;">
                                                <option value="">Select Lead
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

                                        <button type="submit" style="float: right;" id="uploadButton"
                                            class="btn btn-info">Push Excel to Lists</button>
                                    </form>
                                </div>
                                <div class="col-md-3"></div>
                            </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();
            // Inittialize Select2
            initializeSelect2();
        });

        // Initialize Select2
        function initializeSelect2() {
            // Initialize Select2
            $('.select2').select2({
                // placeholder: "Select Options", // Set your custom placeholder text
                allowClear: true, // Show a clear button to remove the selection
            });

            // Find the corresponding select element based on the name attribute
            var selectElement = $('#tags');
            selectElement.prepend('<option value="" selected disabled>Select Tags *</option>');
            $('#tags').on('change', function() {
                // Remove the "Select Tags *" option if any other option is selected
                if ($('#tags option:selected').length > 0) {
                    $('#tags option[value=""]').remove();
                } else {
                    // Add the "Select Tags *" option back if no options are selected
                    $('#tags').prepend('<option value="" selected disabled>Select Tags *</option>');
                }
            });

            // Refresh Select2 to apply the changes
            $('.select2').trigger('change.select2');
        }
    </script>
    <script></script>
@endsection
