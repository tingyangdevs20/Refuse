@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropzone@5.9.3/dist/min/dropzone.min.css">

    <style>
        /* Style the Select2 container to match Bootstrap form-control */
        .select2-container {
            width: 100%;
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
                    </div>
                </div>
                <div class="col-3"></div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-cog"></i> New List
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
                                <input type="text" class="form-control" required name="list_name"
                                    placeholder="Enter List Name" required>
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
                                <div id="my-dropzone" class="dropzone"></div>
                            </div>
                            <button type="button" style="float: right;" id="uploadButton" class="btn btn-primary">Read
                                CSV</button>
                            <div class="form-group" style="padding-top: 10px; display: none; float: right;"
                                id="readingCSVId">
                                <div class="d-flex align-items-center">
                                    <strong>Reading CSV...</strong>
                                    <div class="spinner-border spinner-border-sm ml-1" role="status" aria-hidden="true">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card" style="" id="csvMapCard">
                        <div class="card-header">
                            <i class="fas fa-cog"></i> Map CSV Fields
                        </div>
                        <div class="card-body">
                            {{-- Contact Details --}}
                            <h4>Contact Details</h4>
                            <div class="row" style="margin-top: 1rem;">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{-- <label for="name">First Name</label> --}}
                                        <input id="name" readonly type="text" class="form-control"
                                            name="name" placeholder="First Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{-- <label>Choose column from CSV</label> --}}
                                        <select name="name_header" id="name_select" class="form-control select2">
                                            <option value="">Chose Header</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 mt-2">
                                    <div class="form-group">
                                        {{-- <label for="last_name">Last Name</label> --}}
                                        <input id="last_name" readonly type="text" class="form-control"
                                            name="last_name" placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <div class="form-group">
                                        {{-- <label>Choose column from CSV</label> --}}
                                        <select name="last_name_header" id="last_name_select"
                                            class="form-control select2">
                                            <option value="">Chose Header</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 mt-2">
                                    <div class="form-group">
                                        {{-- <label for="street">Street</label> --}}
                                        <input id="street" readonly type="text" class="form-control"
                                            name="street" placeholder="Street">
                                    </div>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <div class="form-group">
                                        {{-- <label>Choose column from CSV</label> --}}
                                        <select name="street_header" id="street_select" class="form-control select2">
                                            <option value="">Chose Header</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 mt-2">
                                    <div class="form-group">
                                        {{-- <label for="city">City</label> --}}
                                        <input id="city" readonly type="text" class="form-control"
                                            name="city" placeholder="City">
                                    </div>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <div class="form-group">
                                        {{-- <label>Choose column from CSV</label> --}}
                                        <select name="city_header" id="city_select" class="form-control select2">
                                            <option value="">Chose Header</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 mt-2">
                                    <div class="form-group">
                                        {{-- <label for="state">State</label> --}}
                                        <input id="state" readonly type="text" class="form-control"
                                            name="state" placeholder="State">
                                    </div>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <div class="form-group">
                                        {{-- <label>Choose column from CSV</label> --}}
                                        <select name="state_header" id="state_select" class="form-control select2">
                                            <option value="">Chose Header</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 mt-2">
                                    <div class="form-group">
                                        {{-- <label for="zip">Zip</label> --}}
                                        <input id="zip" readonly type="text" class="form-control"
                                            name="zip" placeholder="Zip">
                                    </div>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <div class="form-group">
                                        {{-- <label>Choose column from CSV</label> --}}
                                        <select name="zip_header" id="zip_select" class="form-control select2">
                                            <option value="">Chose Header</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 mt-2">
                                    <div class="form-group">
                                        {{-- <label for="number">Phone number 1</label> --}}
                                        <input id="number" readonly type="text" class="form-control"
                                            name="number" placeholder="Phone number 1">
                                    </div>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <div class="form-group">
                                        {{-- <label>Choose column from CSV</label> --}}
                                        <select name="number_header" id="number_select" class="form-control select2">
                                            <option value="">Chose Header</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 mt-2">
                                    <div class="form-group">
                                        {{-- <label for="number2">Phone number 2</label> --}}
                                        <input id="number2" readonly type="text" class="form-control"
                                            name="number2" placeholder="Phone number 2">
                                    </div>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <div class="form-group">
                                        {{-- <label>Choose column from CSV</label> --}}
                                        <select name="number2_header" id="number2_select" class="form-control select2">
                                            <option value="">Chose Header</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 mt-2">
                                    <div class="form-group">
                                        {{-- <label for="email1">Email 1</label> --}}
                                        <input id="email1" readonly type="text" class="form-control"
                                            name="email1" placeholder="Email 1">
                                    </div>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <div class="form-group">
                                        {{-- <label>Choose column from CSV</label> --}}
                                        <select name="email1_header" id="email1_select" class="form-control select2">
                                            <option value="">Chose Header</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 mt-2">
                                    <div class="form-group">
                                        {{-- <label for="email2">Email 2</label> --}}
                                        <input id="email2" readonly type="text" class="form-control"
                                            name="email2" placeholder="Email 2">
                                    </div>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <div class="form-group">
                                        {{-- <label>Choose column from CSV</label> --}}
                                        <select name="email2_header" id="email2_select" class="form-control select2">
                                            <option value="">Chose Header</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <h4 style="margin-top: 1rem;">Contact's Lead Info</h4>
                            <div class="row" style="margin-top: 1rem;">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" readonly id="mailing_address" class="form-control"
                                            placeholder="Mailing Address" name="mailing_address">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{-- <label>Choose column from CSV</label> --}}
                                        <select name="mailing_address_header" id="mailing_address_select"
                                            class="form-control select2">
                                            <option value="">Chose Header</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" readonly id="mailing_city" class="form-control"
                                            placeholder="Mailing City" name="mailing_city">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{-- <label>Choose column from CSV</label> --}}
                                        <select name="mailing_city_header" id="mailing_city_select"
                                            class="form-control select2">
                                            <option value="">Chose Header</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" readonly id="mailing_state" class="form-control"
                                            placeholder="Mailing State" name="mailing_state">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{-- <label>Choose column from CSV</label> --}}
                                        <select name="mailing_state_header" id="mailing_state_select"
                                            class="form-control select2">
                                            <option value="">Chose Header</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" readonly id="mailing_zip" class="form-control"
                                            placeholder="Mailing Zip" name="mailing_zip">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{-- <label>Choose column from CSV</label> --}}
                                        <select name="mailing_zip_header" id="mailing_zip_select"
                                            class="form-control select2">
                                            <option value="">Chose Header</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- Property Info --}}
                            <h4 style="margin-top: 1rem;">Contact's Property Info</h4>
                            <div class="row" style="margin-top: 1rem;">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" readonly id="property_address" class="form-control"
                                            placeholder="Property Address" name="property_address">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{-- <label>Choose column from CSV</label> --}}
                                        <select name="property_address_header" id="property_address_select"
                                            class="form-control select2">
                                            <option value="">Chose Header</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" readonly id="property_city" class="form-control"
                                            placeholder="Property City" name="property_city">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{-- <label>Choose column from CSV</label> --}}
                                        <select name="property_city_header" id="property_city_select"
                                            class="form-control select2">
                                            <option value="">Chose Header</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" readonly id="property_state" class="form-control"
                                            placeholder="Property State" name="property_state">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{-- <label>Choose column from CSV</label> --}}
                                        <select name="property_state_header" id="property_state_select"
                                            class="form-control select2">
                                            <option value="">Chose Header</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" readonly id="property_zip" class="form-control"
                                            placeholder="Property Zip" name="property_zip">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{-- <label>Choose column from CSV</label> --}}
                                        <select name="property_zip_header" id="property_zip_select"
                                            class="form-control select2">
                                            <option value="">Chose Header</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" readonly id="property_type" class="form-control"
                                            placeholder="Property Type" name="property_type">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{-- <label>Choose column from CSV</label> --}}
                                        <select name="property_type_header" id="property_type_select"
                                            class="form-control select2">
                                            <option value="">Chose Header</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" readonly id="bedrooms" class="form-control"
                                            placeholder="Property Bedrooms" name="bedrooms">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{-- <label>Choose column from CSV</label> --}}
                                        <select name="bedrooms_header" id="bedrooms_select" class="form-control select2">
                                            <option value="">Chose Header</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" readonly id="bathrooms" class="form-control"
                                            placeholder="Property Bathrooms" name="bathrooms">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{-- <label>Choose column from CSV</label> --}}
                                        <select name="bathrooms_header" id="bathrooms_select"
                                            class="form-control select2">
                                            <option value="">Chose Header</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" readonly id="square_footage" class="form-control"
                                            placeholder="Property Square Footage" name="square_footage">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{-- <label>Choose column from CSV</label> --}}
                                        <select name="square_footage_header" id="square_footage_select"
                                            class="form-control select2">
                                            <option value="">Chose Header</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" readonly id="lot_size" class="form-control"
                                            placeholder="Property Lot size" name="lot_size">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{-- <label>Choose column from CSV</label> --}}
                                        <select name="lot_size_header" id="lot_size_select" class="form-control select2">
                                            <option value="">Chose Header</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" readonly id="garage_space" class="form-control"
                                            placeholder="Property Garage Space" name="garage_space">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{-- <label>Choose column from CSV</label> --}}
                                        <select name="garage_space_header" id="garage_space_select"
                                            class="form-control select2">
                                            <option value="">Chose Header</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" readonly id="lockbox_code" class="form-control"
                                            placeholder="Property Lockbox Code" name="lockbox_code">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{-- <label>Choose column from CSV</label> --}}
                                        <select name="lockbox_code_header" id="lockbox_code_select"
                                            class="form-control select2">
                                            <option value="">Chose Header</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- Property Expenses/Financing Info --}}
                            <h4 style="margin-top: 1rem;">Contact's Property Expenses/Financing Info</h4>
                            <div class="row" style="margin-top: 1rem;">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" readonly id="year_prop_tax" class="form-control"
                                            placeholder="Yearly Property Tax Amount" name="year_prop_tax">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{-- <label>Choose column from CSV</label> --}}
                                        <select name="year_prop_tax_header" id="year_prop_tax_select"
                                            class="form-control select2">
                                            <option value="">Chose Header</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- Value & Condition --}}
                            <h4 style="margin-top: 1rem;">Contact's Value & Condition</h4>
                            <div class="row" style="margin-top: 1rem;">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" readonly id="asking_price" class="form-control"
                                            placeholder="Asking Price" name="asking_price">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{-- <label>Choose column from CSV</label> --}}
                                        <select name="asking_price_header" id="asking_price_select"
                                            class="form-control select2">
                                            <option value="">Chose Header</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <button type="button" style="float: right;" class="btn btn-primary"
                                id="saveListButton">Save
                                List</button>
                        </div>
                    </div>
                </div>
                <div class="col-3"></div>
            </div>
        </div>
    @endsection
    @section('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/dropzone@5.9.3/dist/min/dropzone.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

        <script>
            $(document).ready(function() {
                // Inittialize Select2
                initializeSelect2();

            });
            // Get the CSRF token from the meta tag
            const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
            var csv_file; // Declare the csv_file variable outside the success event

            // Initialize Dropzone on the specified element
            var myDropzone = new Dropzone("#my-dropzone", {
                url: "{{ route('admin.group.map-csv') }}", // Replace with your upload endpoint
                paramName: "file",
                maxFilesize: 5,
                acceptedFiles: ".csv",
                autoProcessQueue: false,
                uploadMultiple: false,
                addRemoveLinks: true,
                dictDefaultMessage: "Drop files here or click to upload",
                dictFallbackMessage: "Your browser does not support drag and drop file uploads.",
                dictFallbackText: "Please use the fallback form below to upload your files.",
                dictRemoveFile: "Remove",
                dictCancelUpload: "Cancel",
                dictCancelUploadConfirmation: "Are you sure you want to cancel this upload?",
                init: function() {
                    this.on("addedfile", function(file) {
                        // Event handler when a file is added to the queue
                    });

                    this.on("success", function(file, response) {
                        // Event handler when a file upload is successful
                        console.log(response)
                        $('#readingCSVId').hide()
                        $('#csvMapCard').show()
                        if (response.status == true) {
                            toastr.success(response.message, {
                                timeOut: 10000,
                            });

                            // Assuming response.headers is an array of CSV headers
                            var csvHeaders = response.headers;

                            csv_file = file

                            // List of fields and their corresponding select box and input field IDs
                            var fieldMappings = [{
                                    field: "name",
                                    select: "name_select"
                                },
                                {
                                    field: "last_name",
                                    select: "last_name_select"
                                },
                                {
                                    field: "street",
                                    select: "street_select"
                                },
                                {
                                    field: "city",
                                    select: "city_select"
                                },
                                {
                                    field: "state",
                                    select: "state_select"
                                },
                                {
                                    field: "zip",
                                    select: "zip_select"
                                },
                                {
                                    field: "number",
                                    select: "number_select"
                                },
                                {
                                    field: "number2",
                                    select: "number2_select"
                                },
                                {
                                    field: "email1",
                                    select: "email1_select"
                                },
                                {
                                    field: "email2",
                                    select: "email2_select"
                                },
                                {
                                    field: "mailing_address",
                                    select: "mailing_address_select"
                                },
                                {
                                    field: "mailing_city",
                                    select: "mailing_city_select"
                                },
                                {
                                    field: "mailing_state",
                                    select: "mailing_state_select"
                                },
                                {
                                    field: "mailing_zip",
                                    select: "mailing_zip_select"
                                },
                                {
                                    field: "property_address",
                                    select: "property_address_select"
                                },
                                {
                                    field: "property_city",
                                    select: "property_city_select"
                                },
                                {
                                    field: "property_state",
                                    select: "property_state_select"
                                },
                                {
                                    field: "property_zip",
                                    select: "property_zip_select"
                                },
                                {
                                    field: "property_address",
                                    select: "property_address_select"
                                },
                                {
                                    field: "property_type",
                                    select: "property_type_select"
                                },
                                {
                                    field: "bedrooms",
                                    select: "bedrooms_select"
                                },
                                {
                                    field: "bathrooms",
                                    select: "bathrooms_select"
                                },
                                {
                                    field: "square_footage",
                                    select: "square_footage_select"
                                },
                                {
                                    field: "lot_size",
                                    select: "lot_size_select"
                                },
                                {
                                    field: "garage_space",
                                    select: "garage_space_select"
                                },
                                {
                                    field: "lockbox_code",
                                    select: "lockbox_code_select"
                                },
                                {
                                    field: "year_prop_tax",
                                    select: "year_prop_tax_select"
                                },
                                {
                                    field: "asking_price",
                                    select: "asking_price_select"
                                }
                            ];
                            // Populate the select boxes and assign headers to input fields
                            // populateSelectAndAssignHeaders('name_select', csvHeaders);
                            // populateSelectAndAssignHeaders('last_name_select', csvHeaders);
                            // populateSelectAndAssignHeaders('street_select', csvHeaders);
                            // populateSelectAndAssignHeaders('city_select', csvHeaders);
                            // populateSelectAndAssignHeaders('state_select', csvHeaders);
                            // populateSelectAndAssignHeaders('zip_select', csvHeaders);
                            // populateSelectAndAssignHeaders('number_select', csvHeaders);
                            // populateSelectAndAssignHeaders('number2_select', csvHeaders);
                            // populateSelectAndAssignHeaders('email1_select', csvHeaders);
                            // populateSelectAndAssignHeaders('email2_select', csvHeaders);

                            // Loop through the fieldMappings and populate select boxes and assign headers
                            fieldMappings.forEach(function(mapping) {
                                var selectBox = $('#' + mapping.select);
                                var inputField = $('#' + mapping.field);

                                selectBox.empty(); // Clear existing options
                                selectBox.append('<option value="">Choose Header</option>');

                                // Populate the select box with headers
                                for (var i = 0; i < csvHeaders.length; i++) {
                                    selectBox.append('<option value="' + i + '">' + csvHeaders[i] +
                                        '</option>');
                                }

                                // Assign the selected header to the input field
                                selectBox.on('change', function() {
                                    var selectedHeaderIndex = $(this).val();
                                    if (selectedHeaderIndex !== "") {
                                        inputField.val(csvHeaders[selectedHeaderIndex]);
                                    } else {
                                        inputField.val(
                                            ""
                                        ); // Clear the input field if "Choose Header" is selected
                                    }
                                });
                            });

                        } else {
                            toastr.error(response.message, {
                                timeOut: 9000, // Set the duration (5 seconds in this example)
                            });
                        }
                    });

                    this.on("removedfile", function(file) {
                        // Event handler when a file is removed from the queue
                    });

                    this.on("error", function(file, errorMessage) {
                        // Event handler when a file upload encounters an error
                        $('#readingCSVId').hide()
                        $('#csvMapCard').hide()
                        if (response.status == true) {
                            toastr.success(response.message, {
                                timeOut: 10000,
                            });
                        } else {
                            toastr.error(response.message, {
                                timeOut: 9000, // Set the duration (5 seconds in this example)
                            });
                        }
                        // Remove the uploaded file from Dropzone
                        this.removeFile(file);
                    });

                    // Set the CSRF token as a header for all AJAX requests
                    this.on('sending', function(file, xhr, formData) {
                        formData.append('_token', csrfToken);
                        $('#readingCSVId').show()
                        console.log('mapping csv!')
                    });
                }
            });

            // Handle manual upload when the button is clicked
            $("#uploadButton").click(function() {
                myDropzone.processQueue(); // Process the Dropzone queue
            });

            // Handle form submission
            myDropzone.on("sending", function(file, xhr, formData) {

                // Collect data from the input fields
                var listName = $("input[name='name']").val();
                var tagIds = $("select[name='tag_id[]']").val(); // Use 'select' for multi-select field
                var leadSource = $("select[name='lead_source']").val(); // Use 'select' for dropdowns
                var leadType = $("select[name='lead_type']").val(); // Use 'select' for dropdowns

                // Append the form data to the file upload
                formData.append('name', listName);
                // Append the selected 'tag_id' values one by one (if it's an array)
                if (tagIds && tagIds.length > 0) {
                    for (var i = 0; i < tagIds.length; i++) {
                        formData.append('tag_id[]', tagIds[i]);
                    }
                }
                formData.append('lead_source', leadSource)
                formData.append('lead_type', leadType)

                // Disable autoProcessQueue to prevent duplicate submissions
                myDropzone.options.autoProcessQueue = false;
            });

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

            // Function to populate select and assign headers to input fields
            function populateSelectAndAssignHeaders(selectId, headers) {
                var selectBox = $('#' + selectId);

                selectBox.empty(); // Clear existing options
                selectBox.append('<option value="">Choose Header</option>');

                // Populate the select box with headers
                for (var i = 0; i < headers.length; i++) {
                    selectBox.append('<option value="' + i + '">' + headers[i] + '</option>');
                }

                // Assign the selected header to the input field
                selectBox.on('change', function() {
                    var selectedHeaderIndex = $(this).val();
                    console.log(selectedHeaderIndex)
                    // if (selectedHeaderIndex !== "") {
                    //     inputField.val(headers[selectedHeaderIndex]);
                    // } else {
                    //     inputField.val(""); // Clear the input field if "Choose Header" is selected
                    // }
                });
            }

            // Save the complete form
            // Event handler for the "Save List" button click
            $("#saveListButton").on("click", function() {
                // Create a new FormData object
                var formData = new FormData();

                // Check if csv_file exists
                if (typeof csv_file !== 'undefined' && csv_file !== null) {
                    // Append CSV file uploaded
                    formData.append('file', csv_file);
                } else {
                    // Handle the case where the CSV file does not exist
                    alert("CSV file is missing. Please upload a CSV file.");
                    return; // Abort the form submission
                }

                // Collect data from the input fields
                var listName = $("input[name='name']").val();
                var tagIds = $("select[name='tag_id[]']").val();
                var leadSource = $("select[name='lead_source']").val();
                var leadType = $("select[name='lead_type']").val();

                if (!listName.trim()) {
                    // Handle the case where 'listName' is empty
                    alert("List Name is required.");
                    return; // Abort the form submission
                }

                if (!tagIds || tagIds.length === 0) {
                    // Handle the case where 'tagIds' is empty
                    alert("Select at least one Tag.");
                    return; // Abort the form submission
                }

                // Append the form data to the FormData object
                formData.append('name', listName);
                for (var i = 0; i < tagIds.length; i++) {
                    formData.append('tag_id[]', tagIds[i]);
                }
                formData.append('lead_source', leadSource);
                formData.append('lead_type', leadType);

                // Iterate over the form fields and select boxes
                $(".form-control").each(function() {
                    var fieldName = $(this).attr("name");
                    var fieldValue = $(this).val();

                    // Check if it's a select box and if it has a corresponding input field
                    if ($(this).is("select")) {
                        var inputFieldId = $(this).data("inputfield");
                        if (inputFieldId) {
                            // Use the value of the selected header for the input field
                            fieldValue = $("#" + inputFieldId).val();
                        }
                    }

                    // Add the field to the formData object
                    formData.append(fieldName, fieldValue);
                });

                var csrfToken = $('input[name="_token"]').val(); // Replace with your CSRF token input name

                // Send the data to the server via AJAX
                $.ajax({
                    method: "POST",
                    url: "{{ route('admin.group.store') }}", // Replace with your route
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        if (response.status === true) {
                            toastr.success(response.message, {
                                timeOut: 1000,
                            });
                            // Delay the redirection by 1 seconds (3000 milliseconds)
                            setTimeout(function() {
                                window.location.href =
                                    publicPath + 'group';
                            }, 1000);
                            // Redirect the user after a successful toastr message
                            // window.location.href = publicPath + 'group';
                        } else {
                            toastr.error(response.message, {
                                timeOut: 9000,
                            });
                        }
                    },
                    error: function(response) {
                        toastr.error('API Error: ' + response.responseText, 'API Response Error', {
                            timeOut: 9000,
                        });
                    }
                });
            });
        </script>
    @endsection
