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
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item">Scraping Data</li>
                                Scraping Request
                            </ol>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            Add Scraping Request
                            <a href="{{ URL::previous() }}" class="btn btn-outline-primary btn-sm float-right ml-2"
                                title="New"><i class="fas fa-arrow-left"></i></a>
                            @include('components.modalform')
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3"></div>
                                <div class="col-6">
                                    <form method="post" action="{{ route('admin.scraping.store') }}"
                                        enctype="multipart/form-data">
                                        @csrf <!-- CSRF Token -->

                                        <div class="form-group mt-4">
                                            {{-- <label for="job_name">Job Name</label> --}}
                                            <input type="text"
                                                class="form-control @error('job_name') is-invalid @enderror" id="job_name"
                                                name="job_name" value="{{ old('job_name') }}" placeholder="Job Name *">
                                            @error('job_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            {{-- <label for="state">State</label> --}}
                                            <input type="text" class="form-control @error('state') is-invalid @enderror"
                                                placeholder="Enter State *" id="state" name="state"
                                                value="{{ old('state') }}">
                                            @error('state')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mt-4">
                                            {{-- <label for="city_county_zip">Country</label> --}}
                                            <input type="text"
                                                class="form-control @error('city_county_zip') is-invalid @enderror"
                                                placeholder="Enter City/County/Zip Codes *" id="city_county_zip"
                                                name="city_county_zip" value="{{ old('city_county_zip') }}">
                                            @error('city_county_zip')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mt-4">
                                            {{-- <label for="listing_type">Listing Type</label> --}}
                                            <select class="form-control @error('listing_type') is-invalid @enderror"
                                                id="listing_type" name="listing_type[]" multiple>
                                                <option value="For Sale (by Owner)"
                                                    {{ old('For Sale (by Owner)') ? 'selected' : '' }}>For Sale (by Owner)
                                                </option>
                                                <option value="Sale (By Agent)"
                                                    {{ old('Sale (By Agent)') ? 'selected' : '' }}>Sale (By Agent)
                                                </option>
                                            </select>
                                            @error('listing_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mt-4">
                                            {{-- <label for="price_range">Price Range</label> --}}
                                            <select class="form-control @error('price_range') is-invalid @enderror"
                                                id="price_range" name="price_range">
                                                <option value="">Select Price Range *</option>
                                                <option value="100000-300000">100k-300k</option>
                                                <option value="300000-600000">300k-600k</option>
                                                <option value="600000-900000">600k-900k</option>

                                            </select>
                                            @error('price_range')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mt-4">
                                            {{-- <label for="property_type">Property Type</label> --}}
                                            <select class="form-control @error('property_type') is-invalid @enderror"
                                                id="property_type" name="property_type[]" multiple>
                                                <option value="">Select Property Type</option>
                                                <option value="Houses">Houses</option>
                                                <option value="Townhomes">Townhomes</option>
                                                <option value="Multi-Family">Multi-Family</option>
                                                <option value="Condos/Co-ops">Condos/Co-ops</option>
                                                <option value="Lots/Land">Lots/Land</option>
                                                <option value="Apartments">Apartments</option>
                                                <option value="Manufactured">Manufactured</option>

                                            </select>
                                            @error('property_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mt-4">
                                            {{-- <label for="no_of_bathrooms">No of bathrooms</label> --}}
                                            <select class="form-control @error('no_of_bathrooms') is-invalid @enderror"
                                                id="no_of_bathrooms" name="no_of_bathrooms">
                                                <option value="">Select No of Bathrooms *</option>
                                                <option value="1+">1</option>
                                                <option value="2+">2</option>
                                                <option value="3+">3</option>
                                                <option value="4+">4</option>
                                                <option value="5+">5</option>

                                            </select>
                                            @error('no_of_bathrooms')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mt-4">
                                            {{-- <label for="no_of_bedrooms">No of Bedrooms</label> --}}
                                            <select class="form-control @error('no_of_bedrooms') is-invalid @enderror"
                                                id="no_of_bedrooms" name="no_of_bedrooms">
                                                <option value="">Select No of Bedrooms *</option>
                                                <option value="1+">1</option>
                                                <option value="2+">2</option>
                                                <option value="3+">3</option>
                                                <option value="4+">4</option>
                                                <option value="5+">5</option>

                                            </select>
                                            @error('no_of_bedrooms')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mt-4">
                                            {{-- <label for="filters">Filters</label> --}}
                                            <select class="form-control @error('filters') is-invalid @enderror"
                                                id="filters" name="filters[]" multiple>
                                                <option value="">Select Filters *</option>
                                                <option value="CHECK Pre Foreclousers">Pre Foreclousers</option>
                                                <option value="CHECK Coming Soon">Coming Soon</option>
                                                <option value="CHECK Auctions">Auctions</option>

                                            </select>
                                            @error('filters')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <button type="submit" class="btn btn-primary" style="float: right;">Add
                                            Data</button>
                                    </form>
                                </div>
                                <div class="col-3"></div>
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
            $('select').select2();

            var listingType = $('#listing_type');
            listingType.prepend('<option value="" selected disabled>Select Listing Types *</option>');
            $('#listing_type').on('change', function() {
                // Remove the "Select Listing Types *" option if any other option is selected
                if ($('#listing_type option:selected').length > 0) {
                    $('#listing_type option[value=""]').remove();
                } else {
                    // Add the "Select Listing Types *" option back if no options are selected
                    $('#listing_type').prepend(
                        '<option value="" selected disabled>Select Listing Types *</option>');
                }
            });

            var propertyType = $('#property_type')
            propertyType.prepend('<option value="" selected disabled>Select Property Types *</option>');
            $('#property_type').on('change', function() {
                // Remove the "Select Property Types *" option if any other option is selected
                if ($('#property_type option:selected').length > 0) {
                    $('#property_type option[value=""]').remove();
                } else {
                    // Add the "Select Property Types *" option back if no options are selected
                    $('#property_type').prepend(
                        '<option value="" selected disabled>Select Property Types *</option>');
                }
            });

            var filters = $('#filters')
            filters.prepend('<option value="" selected disabled>Select Filters *</option>');
            $('#filters').on('change', function() {
                // Remove the "Select Filters *" option if any other option is selected
                if ($('#filters option:selected').length > 0) {
                    $('#filters option[value=""]').remove();
                } else {
                    // Add the "Select Filters *" option back if no options are selected
                    $('#filters').prepend(
                        '<option value="" selected disabled>Select Filters *</option>');
                }
            });

            // Refresh Select2 to apply the changes
            $('.select2').trigger('change.select2');
        });
    </script>
    <script></script>
@endsection
