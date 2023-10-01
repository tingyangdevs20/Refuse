@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <style>
        #hidden_div {
            display: none;
        }

        .content-div {
            min-height: 500px;
            border: 1px solid #eee;
            max-height: 500px;
            overflow: scroll;
        }

        .form-group.lead-heading {
            padding: 10px;
            border-bottom: 1px solid #eee;
            font-weight: bold;
        }

        .lead-heading>label {
            margin: 0px;
            font-size: 22px;
            font-weight: bold;
        }

        hr {
            margin-top: 1rem;
            margin-bottom: 0px;
            border: 0;
            border-top-width: 0px;
            border-top-style: none;
            border-top-color: currentcolor;
            border-top: 1px solid rgba(0, 0, 0, .1);
        }

        .dropdown-menu-new li {
            list-style: none;
            display: inline;
            padding: 10px !important;
            background: #ccc;
            border-radius: 5px;
            line-height: 44px;
        }

        .dropdown-item {
            display: inline;
            width: auto;
            padding: .35rem 1.5rem;
            clear: both;
            font-weight: 400;
            color: #212529;
            text-align: inherit;
            white-space: nowrap;
            background-color: transparent;
            border: 0;
        }
    </style>
@endsection
@section('content')
    <input type="hidden" id="_token" value="{{ csrf_token() }}">
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">

                    <div class="page-title-box d-flex align-items-center justify-content-between">

                        <h4 class="mb-0 font-size-18">Contact Record</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item">Contact</li>
                                <li class="breadcrumb-item active">Contact Record</li>
                            </ol>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            <i class="fas fa-edit"></i> Contact
                        </div>
                        <div class="card-body">
                            @if (session('upload'))
                                <div class="alert alert-success">
                                    {{ session('upload') }}
                                </div>
                            @endif

                            @if (session('notupload'))
                                <div class="alert alert-danger">
                                    {{ session('notupload') }}
                                </div>
                            @endif
                            <form id="main_form" action="{{ route('admin.single-sms.store') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                <input hidden name="contact_id" value="{{ $contact->id }}">
                                @if (count($sections) > 0)
                                    <div class="row">
                                        <div class="col-md-12">
                                            <ul class="dropdown-menu-new" style="padding-left: 0;">
                                                @foreach ($sections as $section)
                                                    <li><a class="dropdown-item"
                                                            href="#{{ $section->id }}">{{ $section->name }}</a></li>
                                                @endforeach
                                                {{-- <li><a class="dropdown-item" href="#PROPERTY">PROPERTY INFO</a></li>
                                                        <li><a class="dropdown-item" href="#CONDITION">VALUE & CONDITION</a></li>
                                                        <li><a class="dropdown-item" href="#FINANCING">PROPERTY EXPENSES/FINANCING INFO</a></li>
                                                        <li><a class="dropdown-item" href="#MOTIVATION">SELLING MOTIVATION</a></li>
                                                        <li><a class="dropdown-item" href="#NEGOTIATIONS">NEGOTIATIONS</a></li>
                                                        <li><a class="dropdown-item" href="#CALCULATOR">OFFER CALCULATOR</a></li>
                                                        <li><a class="dropdown-item" href="#OBJECTIONS">OBJECTIONS</a></li>
                                                        <li><a class="dropdown-item" href="#COMMITMENT">COMMITMENT</a></li>
                                                        <li><a class="dropdown-item" href="#STUFF">STUFF TO GO THROUGH</a></li>
                                                        <li><a class="dropdown-item" href="#AGENT">AGENT INFO</a></li>
                                                        <li><a class="dropdown-item" href="#SEQUENCE">START FOLLOW UP SEQUENCE</a></li>
                                                        <li><a class="dropdown-item" href="#APPOINTMENTS">APPOINTMENTS</a></li>
                                                        <li><a class="dropdown-item" href="#COMMUNICATIONS">SEND COMMUNICATIONS</a></li>
                                                        <li><a class="dropdown-item" href="#HISTORY">COMMUNICATIONS HISTORY</a></li>
                                                        <li><a class="dropdown-item" href="#SECTION">FILES/PHOTOS SECTION</a></li>
                                                        <li><a class="dropdown-item" href="#COMPANY">TITLE COMPANY INFORMATION</a></li>
                                                        <li><a class="dropdown-item" href="#INSURANCE">PROPERTY INSURANCE INFO</a></li>
                                                        <li><a class="dropdown-item" href="#HOA">HOA INFO</a></li>
                                                        <li><a class="dropdown-item" href="#FUTURE">FUTURE SELLER CONTACT INFO</a></li>
                                                        <li><a class="dropdown-item" href="#DEPARTMENT">UTILITY DEPARTMENT INFORMATION</a></li> --}}
                                            </ul>
                                        </div>
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="card content-div">
                                            @if (count($sections) > 0)
                                                @foreach ($sections as $section)
                                                    @if ($section->id == '1')
                                                        <div class="col-md-12" style="padding:0px;">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group lead-heading"
                                                                        id="{{ $section->id }}">
                                                                        <label>{{ $section->name }}</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Date Added</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="date" class="form-control"
                                                                                placeholder="Date Added" name="date_added"
                                                                                value="{{ $leadinfo->date_added == '' ? '' : $leadinfo->date_added }}"
                                                                                table="lead_info">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Lead Status</label> --}}
                                                                        <select class="custom-select" name="lead_status"
                                                                            table="lead_info"
                                                                            onchange="">
                                                                            <option value="">Lead Status</option>
                                                                            <option value="None"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'New Lead')  @endif
                                                                                @endif>New Lead</option>
                                                                            <option value="None/Unknown"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'None/Unknown')  @endif
                                                                                @endif>None/Unknown
                                                                            </option>
                                                                            <option value="Cold Lead"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'Cold Lead')  @endif
                                                                                @endif>Cold Lead
                                                                            </option>
                                                                            <option value="Warm Lead"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'Warm Lead')  @endif
                                                                                @endif>Warm Lead</option>
                                                                            <option value="No Longer for Sale"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'No Longer for Sale')  @endif
                                                                                @endif>No Longer for Sale
                                                                            </option>
                                                                            <option value="Not Interested in Our Offer"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'Not Interested in Our Offer')  @endif
                                                                                @endif>Not Interested in Our Offer</option>
                                                                            <option value="Maybe to Our Offer"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'Maybe to Our Offer')  @endif
                                                                                @endif>Maybe to Our Offer
                                                                            </option>
                                                                            <option value="Non-Responsive"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'Non-Responsive')  @endif
                                                                                @endif>Non-Responsive
                                                                            </option>
                                                                            <option value="Sold Property"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'Sold Property')  @endif
                                                                                @endif>Sold Property
                                                                            </option>
                                                                            <option value="Our Contract Out to Seller"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'Our Contract Out to Seller')  @endif
                                                                                @endif>Our Contract Out to Seller
                                                                            </option>
                                                                            <option value="Under Contract (with 3rd Party)"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'Under Contract (with 3rd Party)')  @endif
                                                                                @endif>Under Contract (with 3rd Party)
                                                                            </option>
                                                                            <option value="We Have Under Contract to Buy"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'We Have Under Contract to Buy')  @endif
                                                                                @endif>We Have Under Contract to Buy
                                                                            </option>
                                                                            <option value="Closed Deal - Buy Side"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'Closed Deal - Buy Side')  @endif
                                                                                @endif>Closed Deal - Buy Side
                                                                            </option>
                                                                            <option value="Rehab in Process"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'Rehab in Process')  @endif
                                                                                @endif>Rehab in Process
                                                                            </option>
                                                                            <option value="Hold - Rental"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'Hold - Rental')  @endif
                                                                                @endif>Hold - Rental
                                                                            </option>
                                                                            <option value="For Sale (by Us)"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'For Sale (by Us)')  @endif
                                                                                @endif>For Sale (by Us)
                                                                            </option>
                                                                            <option value="We Have Under Contract to Sell"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'We Have Under Contract to Sell')  @endif
                                                                                @endif>We Have Under Contract to Sell
                                                                            </option>
                                                                            <option value="Closed Deal - Sell Side"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'Closed Deal - Sell Side')  @endif
                                                                                @endif>Closed Deal - Sell Side
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Lead Assigned To</label> --}}
                                                                        <select class="custom-select"
                                                                            name="lead_assigned_to"
                                                                            onchange="updateValue(value,'lead_assigned_to','lead_info')">
                                                                            <option value="">Lead Assigned To</option>
                                                                            @if (count($leads) > 0)
                                                                                @foreach ($leads as $lead)
                                                                                    <option value="{{ $lead->id }}"
                                                                                        @if (isset($leadinfo)) @if ($lead->id == $leadinfo->lead_assigned_to) selected @endif
                                                                                        @endif
                                                                                        >{{ $lead->title }}</option>
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Lead Type</label> --}}
                                                                        <select class="custom-select" name="lead_type"
                                                                            onchange="">
                                                                            <option value="">Lead Type</option>
                                                                            <option value="Agents"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_type == 'Agents')  @endif
                                                                                @endif>Agents
                                                                            </option>

                                                                            <option value="Attorney"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_type == 'Attorney')  @endif
                                                                                @endif>Attorney
                                                                            </option>

                                                                            <option value="Buyer (Investors)"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_type == 'Buyer (Investors)') selected @endif
                                                                                @endif>Buyer (Investors)
                                                                            </option>

                                                                            <option value="Buyer (Owner Financing)"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_type == 'Buyer (Owner Financing)')  @endif
                                                                                @endif>Buyer (Owner Financing)
                                                                            </option>

                                                                            <option value="Buyer (Retail)"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_type == 'Buyer (Retail)')  @endif
                                                                                @endif>Buyer (Retail)
                                                                            </option>

                                                                            <option value="Code Enforcement"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_type == 'Code Enforcement')  @endif
                                                                                @endif>Code Enforcement
                                                                            </option>

                                                                            <option value="Mortgage Brokers"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_type == 'Mortgage Brokers')  @endif
                                                                                @endif>Mortgage Brokers
                                                                            </option>

                                                                            <option value="Seller"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_type == 'Seller')  @endif
                                                                                @endif>Seller
                                                                            </option>

                                                                            <option value="Title Company"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_type == 'Title Company')  @endif
                                                                                @endif>Title Company
                                                                            </option>

                                                                            <option value="Wholesaler"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_type == 'Wholesaler')  @endif
                                                                                @endif>Wholesaler
                                                                            </option>

                                                                            <option value="Other"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_type == 'Other')  @endif
                                                                                @endif>Other
                                                                            </option>




                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Lead Source</label> --}}
                                                                        <select class="custom-select" name="lead_source"
                                                                            onchange="">
                                                                            <option value="">Lead Source</option>
                                                                            <option value="Bandit Signs"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'Bandit Signs')  @endif
                                                                                @endif>Bandit Signs
                                                                            </option>
                                                                            <option value="Billboards"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'Billboards')  @endif
                                                                                @endif>Billboards
                                                                            </option>
                                                                            <option value="Cold Calling"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'Cold Calling')  @endif
                                                                                @endif>Cold Calling
                                                                            </option>
                                                                            <option value="Direct Mail"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'Direct Mail')  @endif
                                                                                @endif>Direct Mail
                                                                            </option>
                                                                            <option value="Door Knocking"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'Door Knocking')  @endif
                                                                                @endif>Door Knocking
                                                                            </option>
                                                                            <option value="Email"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'Email')  @endif
                                                                                @endif>Email
                                                                            </option>
                                                                            <option value="Facebook Ads"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'Facebook Ads')  @endif
                                                                                @endif>Facebook Ads
                                                                            </option>
                                                                            <option value="Flyers"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'Flyers')  @endif
                                                                                @endif>Flyers
                                                                            </option>
                                                                            <option value="Instagram Ads"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'Instagram Ads')  @endif
                                                                                @endif>Instagram Ads
                                                                            </option>
                                                                            <option value="iSpeedToLead"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'iSpeedToLead')  @endif
                                                                                @endif>iSpeedToLead
                                                                            </option>
                                                                            <option value="LinkedIn Ads"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'LinkedIn Ads')  @endif
                                                                                @endif>LinkedIn Ads
                                                                            </option>
                                                                            <option value="Magazine"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'Magazine')  @endif
                                                                                @endif>Magazine
                                                                            </option>
                                                                            <option value="MMS"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'MMS')  @endif
                                                                                @endif>MMS
                                                                            </option>
                                                                            <option value="Newspaper"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'Newspaper')  @endif
                                                                                @endif>Newspaper
                                                                            </option>
                                                                            <option value="Phone Call (Incoming)"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'Phone Call (Incoming)')  @endif
                                                                                @endif>Phone Call (Incoming)
                                                                            </option>
                                                                            <option value="Referral"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'Referral')  @endif
                                                                                @endif>Referral
                                                                            </option>
                                                                            <option value="Retargeting"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'Retargeting')  @endif
                                                                                @endif>Retargeting
                                                                            </option>
                                                                            <option value="RVM"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'Retargeting')  @endif
                                                                                @endif>RVM
                                                                            </option>
                                                                            <option value="SEO"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'SEO')  @endif
                                                                                @endif>SEO
                                                                            </option>
                                                                            <option value="SMS"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'SMS')  @endif
                                                                                @endif>SMS
                                                                            </option>
                                                                            <option value="Social Media"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'Social Media')  @endif
                                                                                @endif>Social Media
                                                                            </option>
                                                                            <option value="Tiktok Ads"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'Tiktok Ads')  @endif
                                                                                @endif>Tiktok Ads
                                                                            </option>
                                                                            <option value="Twitter Ads"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'Twitter Ads')  @endif
                                                                                @endif>Twitter Ads
                                                                            </option>
                                                                            <option value="Website"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'Website')  @endif
                                                                                @endif>Website
                                                                            </option>

                                                                           
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Mailing Address</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <textarea id="template_text" class="form-control" rows="2" placeholder="Mailing Address" name="mailing_address"
                                                                                table="lead_info"> {{ $leadinfo->mailing_address == '' ? '' : $leadinfo->mailing_address }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Mailing City</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Mailing City"
                                                                                name="mailing_city"
                                                                                value="{{ $leadinfo->mailing_city == '' ? '' : $leadinfo->mailing_city }}"
                                                                                table="lead_info">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Mailing State</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Mailing State"
                                                                                name="mailing_state"
                                                                                value="{{ $leadinfo->mailing_state == '' ? '' : $leadinfo->mailing_state }}"
                                                                                table="lead_info">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Mailing Zip</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Mailing Zip"
                                                                                name="mailing_zip" table="lead_info">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- Owner info 1 --}}
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group"
                                                                        style="padding: 0 10px;border-bottom: 1px solid #eee;">
                                                                        <label>Owner info 1</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>First Name</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="First Name"
                                                                                name="owner1_first_name" table="lead_info"
                                                                                value="{{ $leadinfo->mailing_state == '' ? '' : $leadinfo->mailing_state }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Last Name</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Last Name"
                                                                                name="owner1_last_name" table="lead_info"
                                                                                value="{{ $leadinfo->mailing_state == '' ? '' : $leadinfo->mailing_state }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Email 1</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Email 1" name="owner1_email1"
                                                                                table="lead_info"
                                                                                value="{{ $leadinfo->mailing_state == '' ? '' : $leadinfo->mailing_state }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Email 2</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Email 2" name="owner1_email2"
                                                                                table="lead_info"
                                                                                value="{{ $leadinfo->mailing_state == '' ? '' : $leadinfo->mailing_state }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Primary Number</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Primary Number"
                                                                                name="owner1_primary_number"
                                                                                table="lead_info"
                                                                                value="{{ $leadinfo->owner1_primary_number == '' ? '' : $leadinfo->owner1_primary_number }}">
                                                                            @if ($leadinfo->owner1_primary_number)
                                                                                <a id="button-call" class="m-1"
                                                                                    href="javascript:void(0)"
                                                                                    phone-number="{{ $leadinfo->owner1_primary_number == '' ? '' : $leadinfo->owner1_primary_number }}"><i
                                                                                        class="fas fa-phone whatsapp-icon"
                                                                                        style="padding: 24%"></i></a>
                                                                                <button id="button-hangup-outgoing"
                                                                                    class='d-none'>
                                                                                    <i class="fas fa-phone whatsapp-icon hangupicon"
                                                                                        style="padding: 24%"></i>
                                                                                </button>
                                                                            @endif
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Number 2</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Number 2"
                                                                                name="owner1_number2" table="lead_info"
                                                                                value="{{ $leadinfo->owner1_number2 == '' ? '' : $leadinfo->owner1_number2 }}">
                                                                            @if ($leadinfo->owner1_number2)
                                                                                <a id="button-call" class=" m-1"
                                                                                    href="javascript:void(0)"
                                                                                    phone-number="{{ $leadinfo->owner1_number2 == '' ? '' : $leadinfo->owner1_number2 }}"><i
                                                                                        class="fas fa-phone whatsapp-icon"
                                                                                        style="padding: 24%"></i></a>
                                                                                <button id="button-hangup-outgoing"
                                                                                    class='d-none'>
                                                                                    <i class="fas fa-phone whatsapp-icon hangupicon"
                                                                                        style="padding: 24%"></i>
                                                                                </button>
                                                                            @endif
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Number 3</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Number 3"
                                                                                name="owner1_number3" table="lead_info"
                                                                                value="{{ $leadinfo->owner1_number3 == '' ? '' : $leadinfo->owner1_number3 }}">
                                                                            @if ($leadinfo->owner1_number3)
                                                                                <a id="button-call" class="m-1"
                                                                                    href="javascript:void(0)"
                                                                                    phone-number="{{ $leadinfo->owner1_number3 == '' ? '' : $leadinfo->owner1_number3 }}"><i
                                                                                        class="fas fa-phone whatsapp-icon"
                                                                                        style="padding: 24%"></i></a>
                                                                                <button id="button-hangup-outgoing"
                                                                                    class='d-none'>
                                                                                    <i class="fas fa-phone whatsapp-icon hangupicon"
                                                                                        style="padding: 24%"></i>
                                                                                </button>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Owner 1 Social Security #</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Social Security #"
                                                                                name="owner1_social_security"
                                                                                table="lead_info"
                                                                                value="{{ $leadinfo->owner1_social_security == '' ? '' : $leadinfo->owner1_social_security }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Owner 1 Date of Birth</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="date" class="form-control"
                                                                                placeholder="Date of Birth"
                                                                                name="owner1_dob" table="lead_info"
                                                                                value="{{ $leadinfo->owner1_dob == '' ? '' : $leadinfo->owner1_dob }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Owner 1 Mother’s Maiden Name</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Mother’s Maiden Name"
                                                                                name="owner1_mother_name"
                                                                                table="lead_info"
                                                                                value="{{ $leadinfo->owner1_mother_name == '' ? '' : $leadinfo->owner1_mother_name }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            {{-- Owner info 2  --}}
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group"
                                                                        style="padding: 0 10px;border-bottom: 1px solid #eee;">
                                                                        <label>Owner info 2</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label> First Name</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder=" First Name"
                                                                                name="owner2_first_name" table="lead_info"
                                                                                value="{{ $leadinfo->owner2_first_name == '' ? '' : $leadinfo->owner2_first_name }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label> Last Name</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder=" Last Name"
                                                                                name="owner2_last_name" table="lead_info"
                                                                                value="{{ $leadinfo->owner2_last_name == '' ? '' : $leadinfo->owner2_last_name }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label> Email 1</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder=" Email 1"
                                                                                name="owner2_email1" table="lead_info"
                                                                                value="{{ $leadinfo->owner2_email1 == '' ? '' : $leadinfo->owner2_email1 }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label> Email 2</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder=" Email 2"
                                                                                name="owner2_email2" table="lead_info"
                                                                                value="{{ $leadinfo->owner2_email2 == '' ? '' : $leadinfo->owner2_email2 }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label> Primary Number</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder=" Primary Number"
                                                                                name="owner2_primary_number"
                                                                                table="lead_info"
                                                                                value="{{ $leadinfo->owner2_primary_number == '' ? '' : $leadinfo->owner2_primary_number }}">
                                                                            @if ($leadinfo->owner2_primary_number)
                                                                                <a id="button-call"
                                                                                    class="outgoing-call m-1"
                                                                                    href="javascript:void(0)"
                                                                                    phone-number="{{ $leadinfo->owner2_primary_number == '' ? '' : $leadinfo->owner2_primary_number }}"><i
                                                                                        class="fas fa-phone whatsapp-icon"
                                                                                        style="padding: 24%"></i></a>
                                                                                <button id="button-hangup-outgoing"
                                                                                    class='d-none'>
                                                                                    <i class="fas fa-phone whatsapp-icon hangupicon"
                                                                                        style="padding: 24%"></i>
                                                                                </button>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label> Number 2</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder=" Number 2"
                                                                                name="owner2_number2" table="lead_info"
                                                                                value="{{ $leadinfo->owner2_number2 == '' ? '' : $leadinfo->owner2_number2 }}">
                                                                            @if ($leadinfo->owner2_number2)
                                                                                <a id="button-call"
                                                                                    class="outgoing-call m-1"
                                                                                    href="javascript:void(0)"
                                                                                    phone-number="{{ $leadinfo->owner2_number2 == '' ? '' : $leadinfo->owner2_number2 }}"><i
                                                                                        class="fas fa-phone whatsapp-icon"
                                                                                        style="padding: 24%"></i></a>
                                                                                <button id="button-hangup-outgoing"
                                                                                    class='d-none'>
                                                                                    <i class="fas fa-phone whatsapp-icon hangupicon"
                                                                                        style="padding: 24%"></i>
                                                                                </button>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label> Number 3</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder=" Number 3"
                                                                                name="owner2_number3" table="lead_info"
                                                                                value="{{ $leadinfo->owner2_number3 == '' ? '' : $leadinfo->owner2_number3 }}">
                                                                            @if ($leadinfo->owner2_number3)
                                                                                <a id="button-call"
                                                                                    class="outgoing-call m-1"
                                                                                    href="javascript:void(0)"
                                                                                    phone-number="{{ $leadinfo->owner2_number3 == '' ? '' : $leadinfo->owner2_number3 }}"><i
                                                                                        class="fas fa-phone whatsapp-icon"
                                                                                        style="padding: 24%"></i></a>
                                                                                <button id="button-hangup-outgoing"
                                                                                    class='d-none'>
                                                                                    <i class="fas fa-phone whatsapp-icon hangupicon"
                                                                                        style="padding: 24%"></i>
                                                                                </button>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Owner 2 Social Security #</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Social Security #"
                                                                                name="owner2_social_security"
                                                                                table="lead_info"
                                                                                value="{{ $leadinfo->owner2_social_security == '' ? '' : $leadinfo->owner2_social_security }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Owner 2 Date of Birth</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="date" class="form-control"
                                                                                placeholder="Date of Birth"
                                                                                name="owner2_dob" table="lead_info"
                                                                                value="{{ $leadinfo->owner2_dob == '' ? '' : $leadinfo->owner2_dob }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Owner 2 Mother’s Maiden Name</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Mother’s Maiden Name"
                                                                                name="owner2_mother_name"
                                                                                table="lead_info"
                                                                                value="{{ $leadinfo->owner2_mother_name == '' ? '' : $leadinfo->owner2_mother_name }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            {{-- Owner info 3  --}}
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group"
                                                                        style="padding: 0 10px;border-bottom: 1px solid #eee;">
                                                                        <label>Owner info 3</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label> First Name</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder=" First Name"
                                                                                name="owner3_first_name" table="lead_info"
                                                                                value="{{ $leadinfo->owner3_first_name == '' ? '' : $leadinfo->owner3_first_name }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label> Last Name</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder=" Last Name"
                                                                                name="owner3_last_name" table="lead_info"
                                                                                value="{{ $leadinfo->owner3_last_name == '' ? '' : $leadinfo->owner3_last_name }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label> Email 1</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder=" Email 1"
                                                                                name="owner3_email1" table="lead_info"
                                                                                value="{{ $leadinfo->owner3_email1 == '' ? '' : $leadinfo->owner3_email1 }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label> Email 2</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder=" Email 2"
                                                                                name="owner3_email2" table="lead_info"
                                                                                value="{{ $leadinfo->owner3_email2 == '' ? '' : $leadinfo->owner3_email2 }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label> Primary Number</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder=" Primary Number"
                                                                                name="owner3_primary_number"
                                                                                table="lead_info"
                                                                                value="{{ $leadinfo->owner3_primary_number == '' ? '' : $leadinfo->owner3_primary_number }}">
                                                                            @if ($leadinfo->owner3_primary_number)
                                                                                <a id="button-call"
                                                                                    class="outgoing-call m-1"
                                                                                    href="javascript:void(0)"
                                                                                    phone-number="{{ $leadinfo->owner3_primary_number == '' ? '' : $leadinfo->owner3_primary_number }}"><i
                                                                                        class="fas fa-phone whatsapp-icon"
                                                                                        style="padding: 24%"></i></a>
                                                                                <button id="button-hangup-outgoing"
                                                                                    class='d-none'>
                                                                                    <i class="fas fa-phone whatsapp-icon hangupicon"
                                                                                        style="padding: 24%"></i>
                                                                                </button>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label> Number 2</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder=" Number 2"
                                                                                name="owner3_number2" table="lead_info"
                                                                                value="{{ $leadinfo->owner3_number2 == '' ? '' : $leadinfo->owner3_number2 }}">
                                                                            @if ($leadinfo->owner3_number2)
                                                                                <a id="button-call"
                                                                                    class="outgoing-call m-1"
                                                                                    href="javascript:void(0)"
                                                                                    phone-number="{{ $leadinfo->owner3_number2 == '' ? '' : $leadinfo->owner3_number2 }}"><i
                                                                                        class="fas fa-phone whatsapp-icon"
                                                                                        style="padding: 24%"></i></a>
                                                                                <button id="button-hangup-outgoing"
                                                                                    class='d-none'>
                                                                                    <i class="fas fa-phone whatsapp-icon hangupicon"
                                                                                        style="padding: 24%"></i>
                                                                                </button>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label> Number 3</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder=" Number 3"
                                                                                name="owner3_number2" table="lead_info"
                                                                                value="{{ $leadinfo->owner3_number2 == '' ? '' : $leadinfo->owner3_number2 }}">
                                                                            @if ($leadinfo->owner3_number3)
                                                                                <a id="button-call"
                                                                                    class="outgoing-call m-1"
                                                                                    href="javascript:void(0)"
                                                                                    phone-number="{{ $leadinfo->owner3_number3 == '' ? '' : $leadinfo->owner3_number3 }}"><i
                                                                                        class="fas fa-phone whatsapp-icon"
                                                                                        style="padding: 24%"></i></a>
                                                                                <button id="button-hangup-outgoing"
                                                                                    class='d-none'>
                                                                                    <i class="fas fa-phone whatsapp-icon hangupicon"
                                                                                        style="padding: 24%"></i>
                                                                                </button>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Owner 3 Social Security #</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Social Security #"
                                                                                name="owner3_social_security"
                                                                                table="lead_info"
                                                                                value="{{ $leadinfo->owner3_social_security == '' ? '' : $leadinfo->owner3_social_security }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Owner 3 Date of Birth</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="date" class="form-control"
                                                                                placeholder="Date of Birth"
                                                                                name="owner3_dob" table="lead_info"
                                                                                value="{{ $leadinfo->owner3_dob == '' ? '' : $leadinfo->owner3_dob }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Owner 3 Mother’s Maiden Name</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Mother’s Maiden Name"
                                                                                name="owner3_mother_name"
                                                                                table="lead_info"
                                                                                value="{{ $leadinfo->owner3_mother_name == '' ? '' : $leadinfo->owner3_mother_name }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Tags </label> --}}
                                                                        <select class="custom-select" name="tag_id"
                                                                            table="lead_info"
                                                                            onchange="updateValue(value,'tag_id','lead_info')">
                                                                            <option value="">Select Tag</option>
                                                                            @if (count($tags) > 0)
                                                                                @foreach ($tags as $tag)
                                                                                    <option value="{{ $tag->id }}"
                                                                                        @if (isset($leadinfo)) @if ($tag->id == $leadinfo->tag_id) selected @endif
                                                                                        @endif
                                                                                        >{{ $tag->name }}</option>
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @php
                                                                $customeFields = getsectionsFields($section->id);
                                                            @endphp
                                                            <div class="row">
                                                                @if (count($customeFields) > 0)
                                                                    <div class="col-md-12">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;border-bottom: 1px solid #eee;">
                                                                            <label>{{ $section->name }} (Custom
                                                                                Fields)</label>
                                                                        </div>
                                                                    </div>
                                                                    @foreach ($customeFields as $field)
                                                                        @php
                                                                            $customeFieldValue = getsectionsFieldValue($id, $field->id);
                                                                        @endphp
                                                                        <div class="col-md-4">
                                                                            <div class="form-group"
                                                                                style="padding: 0 10px;">
                                                                                {{-- <label>Owner 3 Social Security #</label> --}}
                                                                                <div class="input-group mb-2">
                                                                                    <input type="{{ $field->type }}"
                                                                                        class="form-control"
                                                                                        placeholder="{{ $field->label }}"
                                                                                        name="feild_value"
                                                                                        section_id="{{ $section->id }}"
                                                                                        id="{{ $field->id }}"
                                                                                        table="custom_field_values"
                                                                                        value="{{ $customeFieldValue }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <hr>
                                                    @elseif($section->id == '2')
                                                        <div class="col-md-12" style="padding:0px;">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group lead-heading"
                                                                        id="{{ $section->id }}">
                                                                        <label>{{ $section->name }}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Property Address</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <textarea id="template_text" class="form-control" rows="2" placeholder="Property Address"
                                                                                name="property_address" table="property_infos">{{ $property_infos->property_address == '' ? '' : $property_infos->property_address }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Property City</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Property City"
                                                                                name="property_city"
                                                                                table="property_infos"
                                                                                value="{{ $property_infos->property_city == '' ? '' : $property_infos->property_city }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Property State</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Property State"
                                                                                name="property_state"
                                                                                table="property_infos"
                                                                                value="{{ $property_infos->property_state == '' ? '' : $property_infos->property_state }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Property Zip</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Property Zip"
                                                                                name="property_zip" table="property_infos"
                                                                                value="{{ $property_infos->property_zip == '' ? '' : $property_infos->property_zip }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Google Maps Link</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Google Maps Link"
                                                                                name="map_link" table="property_infos"
                                                                                value="{{ $property_infos->map_link == '' ? '' : $property_infos->map_link }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Zillow Link to Address</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Zillow Link to Address"
                                                                                name="zillow_link" table="property_infos"
                                                                                value="{{ $property_infos->zillow_link == '' ? '' : $property_infos->zillow_link }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Property Type</label> --}}
                                                                        <select class="custom-select" name="property_type"
                                                                            onchange="updateValue(value,'property_type','property_infos')">
                                                                            <option value="">Property Type</option>
                                                                            <option value="SFR"
                                                                                @if (isset($property_infos)) @if ($property_infos->property_type == 'SFR') selected @endif
                                                                                @endif>SFR</option>
                                                                            <option value="townhouse"
                                                                                @if (isset($property_infos)) @if ($property_infos->property_type == 'townhouse') selected @endif
                                                                                @endif>townhouse
                                                                            </option>
                                                                            <option value="condo"
                                                                                @if (isset($property_infos)) @if ($property_infos->property_type == 'condo') selected @endif
                                                                                @endif>condo</option>
                                                                            <option value="land"
                                                                                @if (isset($property_infos)) @if ($property_infos->property_type == 'land') selected @endif
                                                                                @endif>land</option>
                                                                            <option value="multi-family"
                                                                                @if (isset($property_infos)) @if ($property_infos->property_type == 'multi-family') selected @endif
                                                                                @endif>multi-family
                                                                            </option>
                                                                            <option value="other"
                                                                                @if (isset($property_infos)) @if ($property_infos->property_type == 'other') selected @endif
                                                                                @endif>other</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Bedrooms</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Bedrooms" name="bedrooms"
                                                                                table="property_infos"
                                                                                value="{{ $property_infos->bedrooms == '' ? '' : $property_infos->bedrooms }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Bathrooms</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Bathrooms" name="bathrooms"
                                                                                table="property_infos"
                                                                                value="{{ $property_infos->bathrooms == '' ? '' : $property_infos->bathrooms }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Square Footage</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Square Footage"
                                                                                name="square_footage"
                                                                                table="property_infos"
                                                                                value="{{ $property_infos->square_footage == '' ? '' : $property_infos->square_footage }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Lot Size</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Lot Size" name="lot_Size"
                                                                                table="property_infos"
                                                                                value="{{ $property_infos->lot_size == '' ? '' : $property_infos->lot_size }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Garage space</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Garage space"
                                                                                name="garage_space" table="property_infos"
                                                                                value="{{ $property_infos->garage_space == '' ? '' : $property_infos->garage_space }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Lockbox Code</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Lockbox Code"
                                                                                name="lockbox_code" table="property_infos"
                                                                                value="{{ $property_infos->lockbox_code == '' ? '' : $property_infos->lockbox_code }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @php
                                                                $customeFields = getsectionsFields($section->id);
                                                            @endphp
                                                            <div class="row">
                                                                @if (count($customeFields) > 0)
                                                                    <div class="col-md-12">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;border-bottom: 1px solid #eee;">
                                                                            <label>{{ $section->name }} (Custom
                                                                                Fields)</label>
                                                                        </div>
                                                                    </div>
                                                                    @foreach ($customeFields as $field)
                                                                        @php
                                                                            $customeFieldValue = getsectionsFieldValue($id, $field->id);
                                                                        @endphp
                                                                        <div class="col-md-4">
                                                                            <div class="form-group"
                                                                                style="padding: 0 10px;">
                                                                                {{-- <label>Owner 3 Social Security #</label> --}}
                                                                                <div class="input-group mb-2">
                                                                                    <input type="{{ $field->type }}"
                                                                                        class="form-control"
                                                                                        placeholder="{{ $field->label }}"
                                                                                        name="feild_value"
                                                                                        section_id="{{ $section->id }}"
                                                                                        id="{{ $field->id }}"
                                                                                        table="custom_field_values"
                                                                                        value="{{ $customeFieldValue }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <hr>
                                                    @elseif($section->id == '3')
                                                        <div class="col-md-12" style="padding:0px;">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group lead-heading"
                                                                        id="{{ $section->id }}">
                                                                        <label>{{ $section->name }}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Asking Price</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Asking Price"
                                                                                name="asking_price"
                                                                                table="values_conditions"
                                                                                value="{{ $values_conditions->asking_price == '' ? '' : $values_conditions->asking_price }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Best Price</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Best Price" name="best_price"
                                                                                table="values_conditions"
                                                                                value="{{ $values_conditions->best_price == '' ? '' : $values_conditions->best_price }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Comp Value</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Comp Value" name="comp_value"
                                                                                table="values_conditions"
                                                                                value="{{ $values_conditions->comp_value == '' ? '' : $values_conditions->comp_value }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Repair Details</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <textarea id="template_text" class="form-control" rows="2" placeholder="Repair Details" name="repair_detail"
                                                                                table="values_conditions"> {{ $values_conditions->repair_detail == '' ? '' : $values_conditions->repair_detail }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Repair Cost</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Repair Cost"
                                                                                name="repair_cost"
                                                                                table="values_conditions"
                                                                                value="{{ $values_conditions->repair_cost == '' ? '' : $values_conditions->repair_cost }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Why Not Sold</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Why Not Sold"
                                                                                name="why_not_sold"
                                                                                table="values_conditions"
                                                                                value="{{ $values_conditions->why_not_sold == '' ? '' : $values_conditions->why_not_sold }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Occupancy Status</label> --}}
                                                                        <select class="custom-select"
                                                                            name="occupancy_status"
                                                                            onchange="updateValue(value,'occupancy_status','values_conditions')">
                                                                            <option value="">Occupancy Status
                                                                            </option>
                                                                            <option value="owner occupied"
                                                                                @if (isset($values_conditions)) @if ($values_conditions->occupancy_status == 'owner occupied') selected @endif
                                                                                @endif>owner occupied
                                                                            </option>
                                                                            <option value="tenant occupied"
                                                                                @if (isset($values_conditions)) @if ($values_conditions->occupancy_status == 'tenant occupied') selected @endif
                                                                                @endif>tenant occupied
                                                                            </option>
                                                                            <option value="family/friends"
                                                                                @if (isset($values_conditions)) @if ($values_conditions->occupancy_status == 'family/friends') selected @endif
                                                                                @endif>family/friends
                                                                            </option>
                                                                            <option value="squatters"
                                                                                @if (isset($values_conditions)) @if ($values_conditions->occupancy_status == 'squatters') selected @endif
                                                                                @endif>squatters
                                                                            </option>
                                                                            <option value="multi-family"
                                                                                @if (isset($values_conditions)) @if ($values_conditions->occupancy_status == 'multi-family') selected @endif
                                                                                @endif>multi-family
                                                                            </option>
                                                                            <option value="vacant"
                                                                                @if (isset($values_conditions)) @if ($values_conditions->occupancy_status == 'vacant') selected @endif
                                                                                @endif>vacant</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Notes About Condition</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <textarea id="template_text" class="form-control" rows="2" placeholder="Notes About Condition"
                                                                                table="values_conditions" name="notes_condition">{{ $values_conditions->notes_condition == '' ? '' : $values_conditions->notes_condition }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        <div class="input-group mb-2">
                                                                            <button type="button"
                                                                                id="fetch-realtor-estimates-button"
                                                                                class="btn btn-primary">Get Property
                                                                                Estimates</button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group"
                                                                        style="padding: 0 10px; display: none;"
                                                                        id="propertyEstimatesFetchingId">
                                                                        <div class="d-flex align-items-center">
                                                                            <strong>Fetching Property ID...</strong>
                                                                            <div class="spinner-border spinner-border-sm ml-1"
                                                                                role="status" aria-hidden="true"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group"
                                                                        style="padding: 0 10px; display: none;"
                                                                        id="propertyEstimatesFetchingEstimates">
                                                                        <div class="d-flex align-items-center">
                                                                            <strong>Fetching Property Estimates...</strong>
                                                                            <div class="spinner-border spinner-border-sm ml-1"
                                                                                role="status" aria-hidden="true"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group" style="padding: 0 10px;"
                                                                        id="estimateContainer">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Comp 1</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Comp 1" name="comp2"
                                                                                table="values_conditions"
                                                                                value="{{ $values_conditions->comp2 == '' ? '' : $values_conditions->comp2 }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Comp 2</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Comp 2" name="comp2"
                                                                                table="values_conditions"
                                                                                value="{{ $values_conditions->comp2 == '' ? '' : $values_conditions->comp2 }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Comp 3</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Comp 3" name="comp3"
                                                                                table="values_conditions"
                                                                                value="{{ $values_conditions->comp3 == '' ? '' : $values_conditions->comp3 }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Comp 4</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Comp 4" name="comp4"
                                                                                table="values_conditions"
                                                                                value="{{ $values_conditions->comp4 == '' ? '' : $values_conditions->comp4 }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Comp 5</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Comp 5" name="comp5"
                                                                                table="values_conditions"
                                                                                value="{{ $values_conditions->comp5 == '' ? '' : $values_conditions->comp5 }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @php
                                                                $customeFields = getsectionsFields($section->id);
                                                            @endphp
                                                            <div class="row">
                                                                @if (count($customeFields) > 0)
                                                                    <div class="col-md-12">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;border-bottom: 1px solid #eee;">
                                                                            <label>{{ $section->name }} (Custom
                                                                                Fields)</label>
                                                                        </div>
                                                                    </div>
                                                                    @foreach ($customeFields as $field)
                                                                        @php
                                                                            $customeFieldValue = getsectionsFieldValue($id, $field->id);
                                                                        @endphp
                                                                        <div class="col-md-4">
                                                                            <div class="form-group"
                                                                                style="padding: 0 10px;">
                                                                                {{-- <label>Owner 3 Social Security #</label> --}}
                                                                                <div class="input-group mb-2">
                                                                                    <input type="{{ $field->type }}"
                                                                                        class="form-control"
                                                                                        placeholder="{{ $field->label }}"
                                                                                        name="feild_value"
                                                                                        section_id="{{ $section->id }}"
                                                                                        id="{{ $field->id }}"
                                                                                        table="custom_field_values"
                                                                                        value="{{ $customeFieldValue }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <hr>
                                                    @elseif($section->id == '4')
                                                        <div class="col-md-12" style="padding:0px;">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group lead-heading"
                                                                        id="{{ $section->id }}">
                                                                        <label>{{ $section->name }}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>HOA Dues per month</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="HOA Dues per month"
                                                                                name="dues_per_month"
                                                                                table="property_finance_infos"
                                                                                value="{{ $property_finance_infos->dues_per_month == '' ? '' : $property_finance_infos->dues_per_month }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Financing Notes</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Financing Notes"
                                                                                name="financing_notes"
                                                                                table="property_finance_infos"
                                                                                value="{{ $property_finance_infos->financing_notes == '' ? '' : $property_finance_infos->financing_notes }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Past Due Amount of Mortgage/Taxes/HOA</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Past Due Amount of Mortgage/Taxes/HOA"
                                                                                name="due_amount_mortage"
                                                                                table="property_finance_infos"
                                                                                value="{{ $property_finance_infos->due_amount_mortage == '' ? '' : $property_finance_infos->due_amount_mortage }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group"
                                                                        style="padding: 0 10px;border-bottom: 1px solid #eee;">
                                                                        <label>Loan info 1</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Origination Date</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="date" class="form-control"
                                                                                placeholder="Origination Date"
                                                                                name="loan1_origination_date"
                                                                                table="property_finance_infos"
                                                                                value="{{ $property_finance_infos->loan1_origination_date == '' ? '' : $property_finance_infos->loan1_origination_date }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Financing Notes</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Original Term"
                                                                                name="loan1_original_term"
                                                                                table="property_finance_infos"
                                                                                value="{{ $property_finance_infos->loan1_original_term == '' ? '' : $property_finance_infos->loan1_original_term }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Loan 1 Original Balance</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Loan 1 Original Balance"
                                                                                name="loan1_original_balance"
                                                                                table="property_finance_infos"
                                                                                value="{{ $property_finance_infos->loan1_original_balance == '' ? '' : $property_finance_infos->loan1_original_balance }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Loan Type</label> --}}
                                                                        <select class="custom-select" name="loan1_type"
                                                                            onchange="updateValue(value,'loan1_type','property_finance_infos')">
                                                                            <option value="">Loan Type</option>
                                                                            <option value="FHA"
                                                                                @if (isset($property_finance_infos)) @if ($property_finance_infos->loan1_type == 'FHA') selected @endif
                                                                                @endif>FHA</option>
                                                                            <option value="VA"
                                                                                @if (isset($property_finance_infos)) @if ($property_finance_infos->loan1_type == 'VA') selected @endif
                                                                                @endif>VA</option>
                                                                            <option value="Conventional"
                                                                                @if (isset($property_finance_infos)) @if ($property_finance_infos->loan1_type == 'Conventional') selected @endif
                                                                                @endif>Conventional
                                                                            </option>
                                                                            <option value="Non-Conventional"
                                                                                @if (isset($property_finance_infos)) @if ($property_finance_infos->loan1_type == 'Non-Conventional') selected @endif
                                                                                @endif>Non-Conventional
                                                                            </option>
                                                                            <option value="Owner Financing"
                                                                                @if (isset($property_finance_infos)) @if ($property_finance_infos->loan1_type == 'Owner Financing') selected @endif
                                                                                @endif>Owner Financing
                                                                            </option>

                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Original Balance</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Original Balance"
                                                                                name="loan1_original_balance"
                                                                                table="property_finance_infos"
                                                                                value="{{ $property_finance_infos->loan1_original_balance == '' ? '' : $property_finance_infos->loan1_original_balance }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Current Balance</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Current Balance"
                                                                                name="loan1_current_balance"
                                                                                table="property_finance_infos"
                                                                                value="{{ $property_finance_infos->loan1_current_balance == '' ? '' : $property_finance_infos->loan1_current_balance }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Loan Fixed or Adjustable</label> --}}
                                                                        <select class="custom-select"
                                                                            name="loan1_fixed_adjustable"
                                                                            onchange="updateValue(value,'loan1_fixed_adjustable','property_finance_infos')">
                                                                            <option value="">Loan Fixed or
                                                                                Adjustable
                                                                            </option>
                                                                            <option value="fixed"
                                                                                @if (isset($property_finance_infos)) @if ($property_finance_infos->loan1_fixed_adjustable == 'fixed') selected @endif
                                                                                @endif>Fixed</option>
                                                                            <option value="adjustable"
                                                                                @if (isset($property_finance_infos)) @if ($property_finance_infos->loan1_fixed_adjustable == 'adjustable') selected @endif
                                                                                @endif>Adjustable
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Interest Rate</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Interest Rate"
                                                                                name="loan1_interest_rate"
                                                                                table="property_finance_infos"
                                                                                value="{{ $property_finance_infos->loan1_interest_rate == '' ? '' : $property_finance_infos->loan1_interest_rate }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Loan  Balloon</label> --}}
                                                                        <select class="custom-select"
                                                                            name="loan1_ballons"
                                                                            onchange="updateValue(value,'loan1_ballons','property_finance_infos')">
                                                                            <option value="">Loan Balloon</option>
                                                                            <option value="yes"
                                                                                @if (isset($property_finance_infos)) @if ($property_finance_infos->loan1_ballons == 'yes') selected @endif
                                                                                @endif>Yes</option>
                                                                            <option value="no"
                                                                                @if (isset($property_finance_infos)) @if ($property_finance_infos->loan1_ballons == 'no') selected @endif
                                                                                @endif>No</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Loan Pre-Payment Penalty</label> --}}
                                                                        <select class="custom-select"
                                                                            name="loan1_prepayment_penality"
                                                                            onchange="updateValue(value,'loan1_prepayment_penality','property_finance_infos')">
                                                                            <option value="">Loan Pre-Payment
                                                                                Penalty</option>
                                                                            <option value="yes"
                                                                                @if (isset($property_finance_infos)) @if ($property_finance_infos->loan1_prepayment_penality == 'yes') selected @endif
                                                                                @endif>Yes</option>
                                                                            <option value="no"
                                                                                @if (isset($property_finance_infos)) @if ($property_finance_infos->loan1_prepayment_penality == 'no') selected @endif
                                                                                @endif>No</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Loan  Monthly PITIH Payment</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Loan  Monthly PITIH Payment"
                                                                                name="loan1_month_pitih_payment"
                                                                                table="property_finance_infos"
                                                                                value="{{ $property_finance_infos->loan1_month_pitih_payment == '' ? '' : $property_finance_infos->loan1_month_pitih_payment }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Loan  Mortgage Company Name</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Loan  Mortgage Company Name"
                                                                                name="loan1_mor_comp_name"
                                                                                table="property_finance_infos"
                                                                                value="{{ $property_finance_infos->loan1_mor_comp_name == '' ? '' : $property_finance_infos->loan1_mor_comp_name }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Loan  Mortgage Company Phone</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Loan  Mortgage Company Phone"
                                                                                name="loan1_mor_comp_phone"
                                                                                table="property_finance_infos"
                                                                                value="{{ $property_finance_infos->loan1_mor_comp_phone == '' ? '' : $property_finance_infos->loan1_mor_comp_phone }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Loan  Account Number</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Loan  Account Number"
                                                                                name="loan1_account_nmbr"
                                                                                table="property_finance_infos"
                                                                                value="{{ $property_finance_infos->loan1_account_nmbr == '' ? '' : $property_finance_infos->loan1_account_nmbr }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Loan  Online Access Link</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Loan  Online Access Link"
                                                                                name="loan1_online_link"
                                                                                table="property_finance_infos"
                                                                                value="{{ $property_finance_infos->loan1_online_link == '' ? '' : $property_finance_infos->loan1_online_link }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Loan Online Access User Name</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Loan  Online Access User Name"
                                                                                name="loan1_user_name"
                                                                                table="property_finance_infos"
                                                                                value="{{ $property_finance_infos->loan1_user_name == '' ? '' : $property_finance_infos->loan1_user_name }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Loan Online Access Password</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Loan Online Access Password"
                                                                                name="loan1_online_pass"
                                                                                table="property_finance_infos"
                                                                                value="{{ $property_finance_infos->loan1_online_pass == '' ? '' : $property_finance_infos->loan1_online_pass }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Loan Account PIN/Codeword</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Loan Account PIN/Codeword"
                                                                                name="loan1_account_pin"
                                                                                table="property_finance_infos"
                                                                                value="{{ $property_finance_infos->loan1_account_pin == '' ? '' : $property_finance_infos->loan1_account_pin }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Loan Day of Month Due</label> --}}
                                                                        <select class="custom-select"
                                                                            name="loan1_due_day_month"
                                                                            onchange="updateValue(value,'loan1_due_day_month','property_finance_infos')">
                                                                            <option value="">Loan Day of Month Due
                                                                            </option>
                                                                            <option value="1"
                                                                                @if (isset($property_finance_infos)) @if ($property_finance_infos->loan1_due_day_month == '1') selected @endif
                                                                                @endif>1</option>
                                                                            <option value="15"
                                                                                @if (isset($property_finance_infos)) @if ($property_finance_infos->loan1_due_day_month == '15') selected @endif
                                                                                @endif>15</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group"
                                                                        style="padding: 0 10px;border-bottom: 1px solid #eee;">
                                                                        <label>Loan info 2</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Origination Date</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="date" class="form-control"
                                                                                placeholder="Origination Date"
                                                                                name="loan2_origination_date"
                                                                                table="property_finance_infos"
                                                                                value="{{ $property_finance_infos->loan2_origination_date == '' ? '' : $property_finance_infos->loan2_origination_date }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Financing Notes</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Original Term"
                                                                                name="loan2_original_term"
                                                                                table="property_finance_infos"
                                                                                value="{{ $property_finance_infos->loan2_original_term == '' ? '' : $property_finance_infos->loan2_original_term }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Loan 1 Original Balance</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Loan 1 Original Balance"
                                                                                name="loan2_original_balance"
                                                                                table="property_finance_infos"
                                                                                value="{{ $property_finance_infos->loan2_original_balance == '' ? '' : $property_finance_infos->loan2_original_balance }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Loan Type</label> --}}
                                                                        <select class="custom-select" name="loan2_type"
                                                                            onchange="updateValue(value,'loan2_type','property_finance_infos')">
                                                                            <option value="">Loan Type</option>
                                                                            <option value="FHA"
                                                                                @if (isset($property_finance_infos)) @if ($property_finance_infos->loan2_type == 'FHA') selected @endif
                                                                                @endif>FHA</option>
                                                                            <option value="VA"
                                                                                @if (isset($property_finance_infos)) @if ($property_finance_infos->loan2_type == 'VA') selected @endif
                                                                                @endif>VA</option>
                                                                            <option value="Conventional"
                                                                                @if (isset($property_finance_infos)) @if ($property_finance_infos->loan2_type == 'Conventional') selected @endif
                                                                                @endif>Conventional
                                                                            </option>
                                                                            <option value="Non-Conventional"
                                                                                @if (isset($property_finance_infos)) @if ($property_finance_infos->loan2_type == 'Non-Conventional') selected @endif
                                                                                @endif>Non-Conventional
                                                                            </option>
                                                                            <option value="Owner Financing"
                                                                                @if (isset($property_finance_infos)) @if ($property_finance_infos->loan2_type == 'Owner Financing') selected @endif
                                                                                @endif>Owner Financing
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Original Balance</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Original Balance"
                                                                                name="loan2_original_balance"
                                                                                table="property_finance_infos"
                                                                                value="{{ $property_finance_infos->loan2_original_balance == '' ? '' : $property_finance_infos->loan2_original_balance }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Current Balance</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Current Balance"
                                                                                name="loan2_current_balance"
                                                                                table="property_finance_infos"
                                                                                value="{{ $property_finance_infos->loan2_current_balance == '' ? '' : $property_finance_infos->loan2_current_balance }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Loan Fixed or Adjustable</label> --}}
                                                                        <select class="custom-select"
                                                                            name="loan2_fixed_adjust"
                                                                            onchange="updateValue(value,'loan2_fixed_adjust','property_finance_infos')">
                                                                            <option value="">Loan Fixed or
                                                                                Adjustable</option>
                                                                            <option value="fixed"
                                                                                @if (isset($property_finance_infos)) @if ($property_finance_infos->loan2_fixed_adjust == 'fixed') selected @endif
                                                                                @endif>Fixed</option>
                                                                            <option value="adjustable"
                                                                                @if (isset($property_finance_infos)) @if ($property_finance_infos->loan2_fixed_adjust == 'adjustable') selected @endif
                                                                                @endif>Adjustable
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Interest Rate</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Interest Rate"
                                                                                name="loan2_interst_rate"
                                                                                table="property_finance_infos"
                                                                                value="{{ $property_finance_infos->loan2_interst_rate == '' ? '' : $property_finance_infos->loan2_interst_rate }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Loan  Balloon</label> --}}
                                                                        <select class="custom-select"
                                                                            name="loan2_baloons"
                                                                            onchange="updateValue(value,'loan2_baloons','property_finance_infos')">
                                                                            <option value="">Loan Balloon</option>
                                                                            <option value="yes"
                                                                                @if (isset($property_finance_infos)) @if ($property_finance_infos->loan2_baloons == 'yes') selected @endif
                                                                                @endif>Yes</option>
                                                                            <option value="no"
                                                                                @if (isset($property_finance_infos)) @if ($property_finance_infos->loan2_baloons == 'no') selected @endif
                                                                                @endif>No</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Loan Pre-Payment Penalty</label> --}}
                                                                        <select class="custom-select"
                                                                            name="loan2_prepayment_penality"
                                                                            onchange="updateValue(value,'loan2_prepayment_penality','property_finance_infos')">
                                                                            <option value="">Loan Pre-Payment
                                                                                Penalty</option>
                                                                            <option value="yes"
                                                                                @if (isset($property_finance_infos)) @if ($property_finance_infos->loan2_prepayment_penality == 'yes') selected @endif
                                                                                @endif>Yes</option>
                                                                            <option value="no"
                                                                                @if (isset($property_finance_infos)) @if ($property_finance_infos->loan2_prepayment_penality == 'no') selected @endif
                                                                                @endif>No</option>

                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Loan  Monthly PITIH Payment</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Loan  Monthly PITIH Payment"
                                                                                name="loan2_month_pitih_payment"
                                                                                table="property_finance_infos"
                                                                                value="{{ $property_finance_infos->loan2_month_pitih_payment == '' ? '' : $property_finance_infos->loan2_month_pitih_payment }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Loan  Mortgage Company Name</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Loan  Mortgage Company Name"
                                                                                name="loan2_mor_comp_name"
                                                                                table="property_finance_infos"
                                                                                value="{{ $property_finance_infos->loan2_mor_comp_name == '' ? '' : $property_finance_infos->loan2_mor_comp_name }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Loan  Mortgage Company Phone</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Loan  Mortgage Company Phone"
                                                                                name="loan2_mor_comp_phone"
                                                                                table="property_finance_infos"
                                                                                value="{{ $property_finance_infos->loan2_mor_comp_phone == '' ? '' : $property_finance_infos->loan2_mor_comp_phone }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Loan  Account Number</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Loan  Account Number"
                                                                                name="loan2_account_nmbr"
                                                                                table="property_finance_infos"
                                                                                value="{{ $property_finance_infos->loan2_account_nmbr == '' ? '' : $property_finance_infos->loan2_account_nmbr }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Loan  Online Access Link</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Loan  Online Access Link"
                                                                                name="loan2_online_link"
                                                                                table="property_finance_infos"
                                                                                value="{{ $property_finance_infos->loan2_online_link == '' ? '' : $property_finance_infos->loan2_online_link }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Loan Online Access User Name</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Loan  Online Access User Name"
                                                                                name="loan2_user_name"
                                                                                table="property_finance_infos"
                                                                                value="{{ $property_finance_infos->loan2_user_name == '' ? '' : $property_finance_infos->loan2_user_name }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Loan Online Access Password</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Loan Online Access Password"
                                                                                name="loan2_online_pass"
                                                                                table="property_finance_infos"
                                                                                value="{{ $property_finance_infos->loan2_online_pass == '' ? '' : $property_finance_infos->loan2_online_pass }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                {{-- <div class="col-md-4">
                                                                                <div class="form-group" style="padding: 0 10px;">
                                                                                    <label>Loan Account PIN/Codeword</label>
                                                                                    <div class="input-group mb-2" >
                                                                                        <input type="text" class="form-control" placeholder="Loan Account PIN/Codeword" name="loan2_account_pin" table="property_finance_infos" value="{{ $property_finance_infos->loan2_account_pin == '' ? '' : $property_finance_infos->loan2_account_pin }}">
                                                                                    </div>
                                                                                </div>
                                                                            </div> --}}
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Loan Day of Month Due</label> --}}
                                                                        <select class="custom-select"
                                                                            name="loan2_due_day_month"
                                                                            onchange="updateValue(value,'loan2_due_day_month','property_finance_infos')">
                                                                            <option value="">Loan Day of Month Due
                                                                            </option>
                                                                            <option value="1"
                                                                                @if (isset($property_finance_infos)) @if ($property_finance_infos->loan2_due_day_month == '1') selected @endif
                                                                                @endif>1</option>
                                                                            <option value="15"
                                                                                @if (isset($property_finance_infos)) @if ($property_finance_infos->loan2_due_day_month == '15') selected @endif
                                                                                @endif>15</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Yearly Property Tax Amount</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Yearly Property Tax Amount"
                                                                                name="year_prop_tax"
                                                                                table="property_finance_infos"
                                                                                value="{{ $property_finance_infos->year_prop_tax == '' ? '' : $property_finance_infos->year_prop_tax }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Does mortgage payment(s) include property taxes?</label> --}}
                                                                        <select class="custom-select"
                                                                            name="include_property_taxes"
                                                                            onchange="updateValue(value,'include_property_taxes','property_finance_infos')">
                                                                            <option value="">Does mortgage
                                                                                payment(s) include property taxes?</option>
                                                                            <option value="yes"
                                                                                @if (isset($property_finance_infos)) @if ($property_finance_infos->include_property_taxes == 'yes') selected @endif
                                                                                @endif>Yes</option>
                                                                            <option value="no"
                                                                                @if (isset($property_finance_infos)) @if ($property_finance_infos->include_property_taxes == 'no') selected @endif
                                                                                @endif>No</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Does mortgage payment(s) include property insurance?</label> --}}
                                                                        <select class="custom-select"
                                                                            name="include_property_insurance"
                                                                            onchange="updateValue(value,'include_property_insurance','property_finance_infos')">
                                                                            <option value="">Does mortgage
                                                                                payment(s) include property insurance?
                                                                            </option>
                                                                            <option value="yes"
                                                                                @if (isset($property_finance_infos)) @if ($property_finance_infos->include_property_insurance == 'yes') selected @endif
                                                                                @endif>Yes</option>
                                                                            <option value="no"
                                                                                @if (isset($property_finance_infos)) @if ($property_finance_infos->include_property_insurance == 'no') selected @endif
                                                                                @endif>No</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @php
                                                                $customeFields = getsectionsFields($section->id);
                                                            @endphp
                                                            <div class="row">
                                                                @if (count($customeFields) > 0)
                                                                    <div class="col-md-12">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;border-bottom: 1px solid #eee;">
                                                                            <label>{{ $section->name }} (Custom
                                                                                Fields)</label>
                                                                        </div>
                                                                    </div>
                                                                    @foreach ($customeFields as $field)
                                                                        @php
                                                                            $customeFieldValue = getsectionsFieldValue($id, $field->id);
                                                                        @endphp
                                                                        <div class="col-md-4">
                                                                            <div class="form-group"
                                                                                style="padding: 0 10px;">
                                                                                {{-- <label>Owner 3 Social Security #</label> --}}
                                                                                <div class="input-group mb-2">
                                                                                    <input type="{{ $field->type }}"
                                                                                        class="form-control"
                                                                                        placeholder="{{ $field->label }}"
                                                                                        name="feild_value"
                                                                                        section_id="{{ $section->id }}"
                                                                                        id="{{ $field->id }}"
                                                                                        table="custom_field_values"
                                                                                        value="{{ $customeFieldValue }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <hr>
                                                    @elseif($section->id == '5')
                                                        <div class="col-md-12" style="padding:0px;">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group lead-heading"
                                                                        id="{{ $section->id }}">
                                                                        <label>{{ $section->name }}</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Reason for Selling/Needs/Greeds</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <textarea id="template_text" class="form-control" rows="2" placeholder="Reason for Selling/Needs/Greeds"
                                                                                name="selling_reason" table="selling_motivations">{{ $selling_motivations->selling_reason == '' ? '' : $selling_motivations->selling_reason }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Impact</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Impact" name="impact"
                                                                                table="selling_motivations"
                                                                                value="{{ $selling_motivations->impact == '' ? '' : $selling_motivations->impact }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Serious About Solving Now?</label> --}}
                                                                        <select class="custom-select" name="solving_now"
                                                                            onchange="updateValue(value,'solving_now','selling_motivations')">
                                                                            <option value="">Serious About Solving
                                                                                Now?</option>
                                                                            <option value="yes"
                                                                                @if (isset($selling_motivations)) @if ($selling_motivations->solving_now == 'yes') selected @endif
                                                                                @endif>Yes</option>
                                                                            <option value="no"
                                                                                @if (isset($selling_motivations)) @if ($selling_motivations->solving_now == 'no') selected @endif
                                                                                @endif>No</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Selling Timeframe</label> --}}
                                                                        <select class="custom-select"
                                                                            name="selling_timeframe"
                                                                            onchange="updateValue(value,'selling_timeframe','selling_motivations')">
                                                                            <option value="">Selling Timeframe
                                                                            </option>
                                                                            <option value="ASAP (within 7 days)"
                                                                                @if (isset($selling_motivations)) @if ($selling_motivations->selling_timeframe == 'ASAP (within 7 days)') selected @endif
                                                                                @endif>ASAP (within 7
                                                                                days)</option>
                                                                            <option value="within 14 days"
                                                                                @if (isset($selling_motivations)) @if ($selling_motivations->selling_timeframe == 'within 14 days') selected @endif
                                                                                @endif>within 14 days
                                                                            </option>
                                                                            <option value="within 30 days"
                                                                                @if (isset($selling_motivations)) @if ($selling_motivations->selling_timeframe == 'within 30 days') selected @endif
                                                                                @endif>within 30 days
                                                                            </option>
                                                                            <option value="within 60 days"
                                                                                @if (isset($selling_motivations)) @if ($selling_motivations->selling_timeframe == 'within 60 days') selected @endif
                                                                                @endif>within 60 days
                                                                            </option>
                                                                            <option value="more than 60 days"
                                                                                @if (isset($selling_motivations)) @if ($selling_motivations->selling_timeframe == 'more than 60 days') selected @endif
                                                                                @endif>more than 60
                                                                                days</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Where moving to?</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Where moving to?"
                                                                                name="moving_to"
                                                                                table="selling_motivations"
                                                                                value="{{ $selling_motivations->moving_to == '' ? '' : $selling_motivations->moving_to }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @php
                                                                $customeFields = getsectionsFields($section->id);
                                                            @endphp
                                                            <div class="row">
                                                                @if (count($customeFields) > 0)
                                                                    <div class="col-md-12">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;border-bottom: 1px solid #eee;">
                                                                            <label>{{ $section->name }} (Custom
                                                                                Fields)</label>
                                                                        </div>
                                                                    </div>
                                                                    @foreach ($customeFields as $field)
                                                                        @php
                                                                            $customeFieldValue = getsectionsFieldValue($id, $field->id);
                                                                        @endphp
                                                                        <div class="col-md-4">
                                                                            <div class="form-group"
                                                                                style="padding: 0 10px;">
                                                                                {{-- <label>Owner 3 Social Security #</label> --}}
                                                                                <div class="input-group mb-2">
                                                                                    <input type="{{ $field->type }}"
                                                                                        class="form-control"
                                                                                        placeholder="{{ $field->label }}"
                                                                                        name="feild_value"
                                                                                        section_id="{{ $section->id }}"
                                                                                        id="{{ $field->id }}"
                                                                                        table="custom_field_values"
                                                                                        value="{{ $customeFieldValue }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <hr>
                                                    @elseif($section->id == '6')
                                                        <div class="col-md-12" id="{{ $section->id }}"
                                                            style="padding:0px;">
                                                            <div class="row" id="NEGOTIATIONS">
                                                                <div class="col-md-12">
                                                                    <div class="form-group lead-heading">
                                                                        <label>{{ $section->name }}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Final Price</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Final Price"
                                                                                name="FinalPrice">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Taking Loan 1 Subject 2</label> --}}
                                                                        <select class="custom-select"
                                                                            name="Loan1Subject2" required>
                                                                            <option value="">Loan 1 Subject 2
                                                                            </option>
                                                                            <option value="yes">Yes</option>
                                                                            <option value="no">No</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Taking Loan 2 Subject 2</label> --}}
                                                                        <select class="custom-select"
                                                                            name="Loan2Subject2" required>
                                                                            <option value="">Loan 2 Subject 2
                                                                            </option>
                                                                            <option value="yes">yes</option>
                                                                            <option value="no">no</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Owner Financing Amount</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Owner Financing Amount"
                                                                                name="OwnerFinancingAmount">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Owner Financing Interest Rate</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Owner Financing Interest Rate"
                                                                                name="OwnerFinancingInterestRate">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Owner Financing Term</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Owner Financing Term"
                                                                                name="OwnerFinancingTerm">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Monthly Owner Financing Payment</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Monthly Owner Financing Payment"
                                                                                name="MonthlyOwnerFinancingPayment">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Owner Financing Balloon Payment Due (in Months)</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Owner Financing Balloon Payment Due (in Months)"
                                                                                name="OwnerFinancingBalloonPaymentDue">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Past Due Amount of Mortgage/Taxes/HOA</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Past Due Amount of Mortgage/Taxes/HOA"
                                                                                name="PastDueAmountMortgage">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Profit Expected</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Profit Expected"
                                                                                name="rofitExpected">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Profit Collected</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Profit Collected"
                                                                                name="ProfitCollected">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Monthly Passive Income</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Monthly Passive Income"
                                                                                name="MonthlyPassiveIncome">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @php
                                                                $customeFields = getsectionsFields($section->id);
                                                            @endphp
                                                            <div class="row">
                                                                @if (count($customeFields) > 0)
                                                                    <div class="col-md-12">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;border-bottom: 1px solid #eee;">
                                                                            <label>{{ $section->name }} (Custom
                                                                                Fields)</label>
                                                                        </div>
                                                                    </div>
                                                                    @foreach ($customeFields as $field)
                                                                        @php
                                                                            $customeFieldValue = getsectionsFieldValue($id, $field->id);
                                                                        @endphp
                                                                        <div class="col-md-4">
                                                                            <div class="form-group"
                                                                                style="padding: 0 10px;">
                                                                                {{-- <label>Owner 3 Social Security #</label> --}}
                                                                                <div class="input-group mb-2">
                                                                                    <input type="{{ $field->type }}"
                                                                                        class="form-control"
                                                                                        placeholder="{{ $field->label }}"
                                                                                        name="feild_value"
                                                                                        section_id="{{ $section->id }}"
                                                                                        id="{{ $field->id }}"
                                                                                        table="custom_field_values"
                                                                                        value="{{ $customeFieldValue }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <hr>
                                                    @elseif($section->id == '7')
                                                        <div class="col-md-12" id="{{ $section->id }}"
                                                            style="padding:0px;">
                                                            <div class="row" id="CALCULATOR">
                                                                <div class="col-md-12">
                                                                    <div class="form-group lead-heading">
                                                                        <label>{{ $section->name }}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @php
                                                                $customeFields = getsectionsFields($section->id);
                                                            @endphp
                                                            <div class="row">
                                                                @if (count($customeFields) > 0)
                                                                    <div class="col-md-12">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;border-bottom: 1px solid #eee;">
                                                                            <label>{{ $section->name }} (Custom
                                                                                Fields)</label>
                                                                        </div>
                                                                    </div>
                                                                    @foreach ($customeFields as $field)
                                                                        @php
                                                                            $customeFieldValue = getsectionsFieldValue($id, $field->id);
                                                                        @endphp
                                                                        <div class="col-md-4">
                                                                            <div class="form-group"
                                                                                style="padding: 0 10px;">
                                                                                {{-- <label>Owner 3 Social Security #</label> --}}
                                                                                <div class="input-group mb-2">
                                                                                    <input type="{{ $field->type }}"
                                                                                        class="form-control"
                                                                                        placeholder="{{ $field->label }}"
                                                                                        name="feild_value"
                                                                                        section_id="{{ $section->id }}"
                                                                                        id="{{ $field->id }}"
                                                                                        table="custom_field_values"
                                                                                        value="{{ $customeFieldValue }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <hr>
                                                    @elseif($section->id == '8')
                                                        <div class="col-md-12" id="{{ $section->id }}"
                                                            style="padding:0px;">
                                                            <div class="row" id="OBJECTIONS">
                                                                <div class="col-md-12">
                                                                    <div class="form-group lead-heading">
                                                                        <label>{{ $section->name }}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Biggest worry about selling?</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <textarea id="template_text" class="form-control" rows="2" placeholder="Biggest worry about selling?"
                                                                                name="Biggestworryaboutselling"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Do you have someone that’s helping you make the decision to sell this house?</label> --}}
                                                                        <select class="custom-select" name="solving_now"
                                                                            onchange="updateValue(value,'solving_now','selling_motivations')">
                                                                            <option value="">Do you have someone
                                                                                that’s helping you make the decision to sell
                                                                                this house?</option>
                                                                            <option value="yes"
                                                                                @if (isset($selling_motivations)) @if ($selling_motivations->solving_now == 'yes') selected @endif
                                                                                @endif>Yes</option>
                                                                            <option value="no"
                                                                                @if (isset($selling_motivations)) @if ($selling_motivations->solving_now == 'no') selected @endif
                                                                                @endif>No</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>If so, what’s their name?</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="If so, what’s their name?"
                                                                                name="SomeoneHelpingName">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @php
                                                                $customeFields = getsectionsFields($section->id);
                                                            @endphp
                                                            <div class="row">
                                                                @if (count($customeFields) > 0)
                                                                    <div class="col-md-12">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;border-bottom: 1px solid #eee;">
                                                                            <label>{{ $section->name }} (Custom
                                                                                Fields)</label>
                                                                        </div>
                                                                    </div>
                                                                    @foreach ($customeFields as $field)
                                                                        @php
                                                                            $customeFieldValue = getsectionsFieldValue($id, $field->id);
                                                                        @endphp
                                                                        <div class="col-md-4">
                                                                            <div class="form-group"
                                                                                style="padding: 0 10px;">
                                                                                {{-- <label>Owner 3 Social Security #</label> --}}
                                                                                <div class="input-group mb-2">
                                                                                    <input type="{{ $field->type }}"
                                                                                        class="form-control"
                                                                                        placeholder="{{ $field->label }}"
                                                                                        name="feild_value"
                                                                                        section_id="{{ $section->id }}"
                                                                                        id="{{ $field->id }}"
                                                                                        table="custom_field_values"
                                                                                        value="{{ $customeFieldValue }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <hr>
                                                    @elseif($section->id == '9')
                                                        <div class="col-md-12" id="{{ $section->id }}"
                                                            style="padding:0px;">
                                                            <div class="row" id="COMMITMENT">
                                                                <div class="col-md-12">
                                                                    <div class="form-group lead-heading">
                                                                        <label>{{ $section->name }}</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Commitment to move forward?</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <select class="custom-select"
                                                                                name="solving_now"
                                                                                onchange="updateValue(value,'solving_now','selling_motivations')">
                                                                                <option value="">Commitment to move
                                                                                    forward?</option>
                                                                                <option value="yes"
                                                                                    @if (isset($selling_motivations)) @if ($selling_motivations->solving_now == 'yes') selected @endif
                                                                                    @endif>Yes</option>
                                                                                <option value="no"
                                                                                    @if (isset($selling_motivations)) @if ($selling_motivations->solving_now == 'no') selected @endif
                                                                                    @endif>No</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Send zoom link button (to email and sms)</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Send zoom link button (to email and sms)"
                                                                                name="SomeoneHelpingName">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            @php
                                                                $customeFields = getsectionsFields($section->id);
                                                            @endphp
                                                            <div class="row">
                                                                @if (count($customeFields) > 0)
                                                                    <div class="col-md-12">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;border-bottom: 1px solid #eee;">
                                                                            <label>{{ $section->name }} (Custom
                                                                                Fields)</label>
                                                                        </div>
                                                                    </div>
                                                                    @foreach ($customeFields as $field)
                                                                        @php
                                                                            $customeFieldValue = getsectionsFieldValue($id, $field->id);
                                                                        @endphp
                                                                        <div class="col-md-4">
                                                                            <div class="form-group"
                                                                                style="padding: 0 10px;">
                                                                                {{-- <label>Owner 3 Social Security #</label> --}}
                                                                                <div class="input-group mb-2">
                                                                                    <input type="{{ $field->type }}"
                                                                                        class="form-control"
                                                                                        placeholder="{{ $field->label }}"
                                                                                        name="feild_value"
                                                                                        section_id="{{ $section->id }}"
                                                                                        id="{{ $field->id }}"
                                                                                        table="custom_field_values"
                                                                                        value="{{ $customeFieldValue }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <hr>
                                                    @elseif($section->id == '10')
                                                        <div class="col-md-12" id="{{ $section->id }}"
                                                            style="padding:0px;">
                                                            <div class="row" id="STUFF">
                                                                <div class="col-md-12">
                                                                    <div class="form-group lead-heading">
                                                                        <label>{{ $section->name }}</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Get email</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input style="margin-right:5px"
                                                                                type="checkbox" name="get_email"> Get
                                                                            email
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Get all names on title</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input style="margin-right:5px"
                                                                                type="checkbox" name="all_names"> Get
                                                                            all names on title
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>If no good pictures are online, ask them for recent pictures</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input style="margin-right:5px"
                                                                                type="checkbox" name="recent_pics"> If
                                                                            no good pictures are online, ask them for recent
                                                                            pictures
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Explain next steps: Inspection, search, 10 minute closing process</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input style="margin-right:5px"
                                                                                type="checkbox" name="next_steps">
                                                                            Explain next steps: Inspection, search, 10
                                                                            minute closing process
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @php
                                                                $customeFields = getsectionsFields($section->id);
                                                            @endphp
                                                            <div class="row">
                                                                @if (count($customeFields) > 0)
                                                                    <div class="col-md-12">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;border-bottom: 1px solid #eee;">
                                                                            <label>{{ $section->name }} (Custom
                                                                                Fields)</label>
                                                                        </div>
                                                                    </div>
                                                                    @foreach ($customeFields as $field)
                                                                        @php
                                                                            $customeFieldValue = getsectionsFieldValue($id, $field->id);
                                                                        @endphp
                                                                        <div class="col-md-4">
                                                                            <div class="form-group"
                                                                                style="padding: 0 10px;">
                                                                                {{-- <label>Owner 3 Social Security #</label> --}}
                                                                                <div class="input-group mb-2">
                                                                                    <input type="{{ $field->type }}"
                                                                                        class="form-control"
                                                                                        placeholder="{{ $field->label }}"
                                                                                        name="feild_value"
                                                                                        section_id="{{ $section->id }}"
                                                                                        id="{{ $field->id }}"
                                                                                        table="custom_field_values"
                                                                                        value="{{ $customeFieldValue }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <hr>
                                                    @elseif($section->id == '11')
                                                        <div class="col-md-12" id="{{ $section->id }}"
                                                            style="padding:0px;">
                                                            <div class="row" id="AGENT">
                                                                <div class="col-md-12">
                                                                    <div class="form-group lead-heading">
                                                                        <label>AGENT INFO</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Property currently listed with an agent </label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <select class="custom-select"
                                                                                name="solving_now"
                                                                                onchange="updateValue(value,'solving_now','selling_motivations')">
                                                                                <option value="">Property currently
                                                                                    listed with an agent </option>
                                                                                <option value="yes"
                                                                                    @if (isset($selling_motivations)) @if ($selling_motivations->solving_now == 'yes') selected @endif
                                                                                    @endif>Yes</option>
                                                                                <option value="no"
                                                                                    @if (isset($selling_motivations)) @if ($selling_motivations->solving_now == 'no') selected @endif
                                                                                    @endif>No</option>
                                                                                <option value="no"
                                                                                    @if (isset($selling_motivations)) @if ($selling_motivations->solving_now == 'expire') selected @endif
                                                                                    @endif>Expiring
                                                                                    soon</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Does agent need to be involved? </label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <select class="custom-select"
                                                                                name="solving_now"
                                                                                onchange="updateValue(value,'solving_now','selling_motivations')">
                                                                                <option value="">Does agent need to
                                                                                    be involved? </option>
                                                                                <option value="yes"
                                                                                    @if (isset($selling_motivations)) @if ($selling_motivations->solving_now == 'yes') selected @endif
                                                                                    @endif>Yes</option>
                                                                                <option value="no"
                                                                                    @if (isset($selling_motivations)) @if ($selling_motivations->solving_now == 'no') selected @endif
                                                                                    @endif>No</option>

                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Agent Name</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Agent Name"
                                                                                name="SomeoneHelpingName">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Agent Office Name</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Agent Office Name"
                                                                                name="SomeoneHelpingName">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Agent Phone</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Agent Phone"
                                                                                name="SomeoneHelpingName">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Agent Email</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Agent Email"
                                                                                name="SomeoneHelpingName">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @php
                                                                $customeFields = getsectionsFields($section->id);
                                                            @endphp
                                                            <div class="row">
                                                                @if (count($customeFields) > 0)
                                                                    <div class="col-md-12">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;border-bottom: 1px solid #eee;">
                                                                            <label>{{ $section->name }} (Custom
                                                                                Fields)</label>
                                                                        </div>
                                                                    </div>
                                                                    @foreach ($customeFields as $field)
                                                                        @php
                                                                            $customeFieldValue = getsectionsFieldValue($id, $field->id);
                                                                        @endphp
                                                                        <div class="col-md-4">
                                                                            <div class="form-group"
                                                                                style="padding: 0 10px;">
                                                                                {{-- <label>Owner 3 Social Security #</label> --}}
                                                                                <div class="input-group mb-2">
                                                                                    <input type="{{ $field->type }}"
                                                                                        class="form-control"
                                                                                        placeholder="{{ $field->label }}"
                                                                                        name="feild_value"
                                                                                        section_id="{{ $section->id }}"
                                                                                        id="{{ $field->id }}"
                                                                                        table="custom_field_values"
                                                                                        value="{{ $customeFieldValue }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <hr>
                                                    @elseif($section->id == '12')
                                                        <div class="col-md-12" id="{{ $section->id }}"
                                                            style="padding:0px;">
                                                            <div class="row" id="SEQUENCE">
                                                                <div class="col-md-12">
                                                                    <div class="form-group lead-heading">
                                                                        <label>{{ $section->name }}</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Schedule Follow up Reminder </label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <select class="custom-select"
                                                                                name="solving_now"
                                                                                onchange="updateValue(value,'solving_now','selling_motivations')">
                                                                                <option value="">Schedule Follow up
                                                                                    Reminder </option>
                                                                                <option value="1"
                                                                                    @if (isset($selling_motivations)) @if ($selling_motivations->solving_now == '1') selected @endif
                                                                                    @endif>1 Day
                                                                                </option>
                                                                                <option value="2"
                                                                                    @if (isset($selling_motivations)) @if ($selling_motivations->solving_now == '2') selected @endif
                                                                                    @endif>2 Days
                                                                                </option>
                                                                                <option value="3"
                                                                                    @if (isset($selling_motivations)) @if ($selling_motivations->solving_now == '3') selected @endif
                                                                                    @endif>4 Days
                                                                                </option>
                                                                                <option value="4"
                                                                                    @if (isset($selling_motivations)) @if ($selling_motivations->solving_now == '4') selected @endif
                                                                                    @endif>1 Week
                                                                                </option>

                                                                            </select>
                                                                        </div>
                                                                        <button type="submit"
                                                                            class="btn btn-primary mt-2">Stop
                                                                            Followup</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @php
                                                                $customeFields = getsectionsFields($section->id);
                                                            @endphp
                                                            <div class="row">
                                                                @if (count($customeFields) > 0)
                                                                    <div class="col-md-12">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;border-bottom: 1px solid #eee;">
                                                                            <label>{{ $section->name }} (Custom
                                                                                Fields)</label>
                                                                        </div>
                                                                    </div>
                                                                    @foreach ($customeFields as $field)
                                                                        @php
                                                                            $customeFieldValue = getsectionsFieldValue($id, $field->id);
                                                                        @endphp
                                                                        <div class="col-md-4">
                                                                            <div class="form-group"
                                                                                style="padding: 0 10px;">
                                                                                {{-- <label>Owner 3 Social Security #</label> --}}
                                                                                <div class="input-group mb-2">
                                                                                    <input type="{{ $field->type }}"
                                                                                        class="form-control"
                                                                                        placeholder="{{ $field->label }}"
                                                                                        name="feild_value"
                                                                                        section_id="{{ $section->id }}"
                                                                                        id="{{ $field->id }}"
                                                                                        table="custom_field_values"
                                                                                        value="{{ $customeFieldValue }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <hr>
                                                    @elseif($section->id == '13')
                                                        <div class="col-md-12" id="{{ $section->id }}"
                                                            style="padding:0px;">
                                                            <div class="row" id="APPOINTMENTS">
                                                                <div class="col-md-12">
                                                                    <div class="form-group lead-heading">
                                                                        <label>{{ $section->name }}</label>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        @foreach ($getAllAppointments as $appt)
                                                                            <div class="form-group"
                                                                                style="padding: 0 10px;">
                                                                                <div class="card-body"
                                                                                    style="font-weight:bold;color:#556ee6;font-size:16px">
                                                                                    @php
                                                                                        $appt_dt = substr($appt->appt_date, 0, 10);
                                                                                        $appt_dt2 = date('d-m-Y', strtotime($appt->appt_date));
                                                                                        $appt_tm = substr($appt->appt_time, 0, 5);
                                                                                    @endphp
                                                                                    On {{ $appt_dt2 }}, at
                                                                                    {{ $appt_tm }} <br />
                                                                                    <span
                                                                                        style="color:#bfbfbf">{{ $appt->description }}</span>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>


                                                                </div>


                                                                @php
                                                                    $customeFields = getsectionsFields($section->id);
                                                                @endphp
                                                                <div class="row">
                                                                    @if (count($customeFields) > 0)
                                                                        <div class="col-md-12">
                                                                            <div class="form-group"
                                                                                style="padding: 0 10px;border-bottom: 1px solid #eee;">
                                                                                <label>{{ $section->name }} (Custom
                                                                                    Fields)</label>
                                                                            </div>
                                                                        </div>
                                                                        @foreach ($customeFields as $field)
                                                                            @php
                                                                                $customeFieldValue = getsectionsFieldValue($id, $field->id);
                                                                            @endphp
                                                                            <div class="col-md-4">
                                                                                <div class="form-group"
                                                                                    style="padding: 0 10px;">
                                                                                    {{-- <label>Owner 3 Social Security #</label> --}}
                                                                                    <div class="input-group mb-2">
                                                                                        <input
                                                                                            type="{{ $field->type }}"
                                                                                            class="form-control"
                                                                                            placeholder="{{ $field->label }}"
                                                                                            name="feild_value"
                                                                                            section_id="{{ $section->id }}"
                                                                                            id="{{ $field->id }}"
                                                                                            table="custom_field_values"
                                                                                            value="{{ $customeFieldValue }}">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <hr>
                                                        @elseif($section->id == '14')
                                                            <div class="col-md-12" id="{{ $section->id }}"
                                                                style="padding:0px;">
                                                                <div class="row" id="COMMUNICATIONS">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group lead-heading">
                                                                            <label>{{ $section->name }}</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @php
                                                                    $customeFields = getsectionsFields($section->id);
                                                                @endphp
                                                                <div class="row">
                                                                    @if (count($customeFields) > 0)
                                                                        <div class="col-md-12">
                                                                            <div class="form-group"
                                                                                style="padding: 0 10px;border-bottom: 1px solid #eee;">
                                                                                <label>{{ $section->name }} (Custom
                                                                                    Fields)</label>
                                                                            </div>
                                                                        </div>
                                                                        @foreach ($customeFields as $field)
                                                                            @php
                                                                                $customeFieldValue = getsectionsFieldValue($id, $field->id);
                                                                            @endphp
                                                                            <div class="col-md-4">
                                                                                <div class="form-group"
                                                                                    style="padding: 0 10px;">
                                                                                    {{-- <label>Owner 3 Social Security #</label> --}}
                                                                                    <div class="input-group mb-2">
                                                                                        <input
                                                                                            type="{{ $field->type }}"
                                                                                            class="form-control"
                                                                                            placeholder="{{ $field->label }}"
                                                                                            name="feild_value"
                                                                                            section_id="{{ $section->id }}"
                                                                                            id="{{ $field->id }}"
                                                                                            table="custom_field_values"
                                                                                            value="{{ $customeFieldValue }}">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12">

                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            <a href="{{ route('admin.zoom.index') }}"
                                                                                type="button"
                                                                                class="btn btn-primary">Zoom Meeting</a>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12">

                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            <div class="card-body"> <label
                                                                                    style="font-size:16px">Send
                                                                                    Email</label>
                                                                                <form
                                                                                    action="{{ route('admin.single-email.store') }}"
                                                                                    method="post"
                                                                                    enctype="multipart/form-data">
                                                                                    @csrf
                                                                                    @method('POST')
                                                                                    <div class="row">
                                                                                        <div class="col-md-6">
                                                                                            <div class="form-group">
                                                                                                <label>Subject:</label>
                                                                                                <div
                                                                                                    class="input-group mb-2">
                                                                                                    <input type="text"
                                                                                                        class="form-control"
                                                                                                        placeholder="Subject"
                                                                                                        name="subject">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-6">
                                                                                            <div class="form-group">
                                                                                                <label>Send To:</label>
                                                                                                <input type="text"
                                                                                                    class="form-control"
                                                                                                    value="{{ $leadinfo->owner1_email1 }}"
                                                                                                    placeholder="Sender Email"
                                                                                                    name="send_to">

                                                                                            </div>
                                                                                        </div>

                                                                                    </div>
                                                                                    <div class="form-group ">
                                                                                        <label>Message</label>
                                                                                        <textarea id="template_text" class="form-control summernote-usage" rows="10" required name="message"></textarea>
                                                                                        <div id='count'
                                                                                            class="float-lg-right">
                                                                                        </div>
                                                                                        <button type="submit"
                                                                                            class="btn btn-primary mt-2">Send
                                                                                            Email</button>
                                                                                    </div>
                                                                                </form>

                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <hr>
                                                        @elseif($section->id == '15')
                                                            <div class="col-md-12" id="{{ $section->id }}"
                                                                style="padding:0px;">
                                                                <div class="row" id="HISTORY">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group lead-heading">
                                                                            <label>{{ $section->name }}</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @php
                                                                    $customeFields = getsectionsFields($section->id);
                                                                @endphp
                                                                <div class="row">
                                                                    @if (count($customeFields) > 0)
                                                                        <div class="col-md-12">
                                                                            <div class="form-group"
                                                                                style="padding: 0 10px;border-bottom: 1px solid #eee;">
                                                                                <label>{{ $section->name }} (Custom
                                                                                    Fields)</label>
                                                                            </div>
                                                                        </div>
                                                                        @foreach ($customeFields as $field)
                                                                            @php
                                                                                $customeFieldValue = getsectionsFieldValue($id, $field->id);
                                                                            @endphp
                                                                            <div class="col-md-4">
                                                                                <div class="form-group"
                                                                                    style="padding: 0 10px;">
                                                                                    {{-- <label>Owner 3 Social Security #</label> --}}
                                                                                    <div class="input-group mb-2">
                                                                                        <input
                                                                                            type="{{ $field->type }}"
                                                                                            class="form-control"
                                                                                            placeholder="{{ $field->label }}"
                                                                                            name="feild_value"
                                                                                            section_id="{{ $section->id }}"
                                                                                            id="{{ $field->id }}"
                                                                                            table="custom_field_values"
                                                                                            value="{{ $customeFieldValue }}">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <hr>
                                                        @elseif($section->id == '16')
                                                            <div class="col-md-12" id="{{ $section->id }}"
                                                                style="padding:0px;">
                                                                <div class="row" id="SECTION">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group lead-heading">
                                                                            <label>{{ $section->name }}</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @php
                                                                    $customeFields = getsectionsFields($section->id);
                                                                @endphp
                                                                <div class="row">
                                                                    @if (count($customeFields) > 0)
                                                                        <div class="col-md-12">
                                                                            <div class="form-group"
                                                                                style="padding: 0 10px;border-bottom: 1px solid #eee;">
                                                                                <label>{{ $section->name }} (Custom
                                                                                    Fields)</label>
                                                                            </div>
                                                                        </div>
                                                                        @foreach ($customeFields as $field)
                                                                            @php
                                                                                $customeFieldValue = getsectionsFieldValue($id, $field->id);
                                                                            @endphp
                                                                            <div class="col-md-4">
                                                                                <div class="form-group"
                                                                                    style="padding: 0 10px;">
                                                                                    {{-- <label>Owner 3 Social Security #</label> --}}
                                                                                    <div class="input-group mb-2">
                                                                                        <input
                                                                                            type="{{ $field->type }}"
                                                                                            class="form-control"
                                                                                            placeholder="{{ $field->label }}"
                                                                                            name="feild_value"
                                                                                            section_id="{{ $section->id }}"
                                                                                            id="{{ $field->id }}"
                                                                                            table="custom_field_values"
                                                                                            value="{{ $customeFieldValue }}">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        <label for="file">Select file type to
                                                                            upload</label>
                                                                        <select class="custom-select" name="lead_status"
                                                                            table="lead_info"
                                                                            onchange="toggleFIlesUpload(value)">
                                                                            <option value="any" selected>Any File
                                                                            </option>
                                                                            <option value="purchase_agreement">Purchase
                                                                                Agreement</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group" style="padding: 0 10px;"
                                                                        id="driveUpload">


                                                                        <div class="form-group">
                                                                            <label for="file">Select Files to
                                                                                Upload:</label>
                                                                            <input type="file" name="file"
                                                                                id="file" class="form-control"
                                                                                multiple>
                                                                        </div>
                                                                        <button type="submit" id="custom-upload-button"
                                                                            class="btn btn-primary">Upload to Google
                                                                            Drive</button>


                                                                    </div>

                                                                    <div class="form-group"
                                                                        style="padding: 0 10px; display: none;"
                                                                        id="purchaseAgreementUpload">


                                                                        <div class="form-group">
                                                                            <label for="file">Select Files to
                                                                                Upload:</label>
                                                                            <input type="file"
                                                                                name="purchase_agreement" id="file"
                                                                                class="form-control"
                                                                                accept="application/pdf">
                                                                        </div>
                                                                        <button type="submit"
                                                                            id="agreement-upload-button"
                                                                            class="btn btn-primary">Move Lead to
                                                                            Deals</button>


                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                        @elseif($section->id == '17')
                                                            <div class="col-md-12" id="{{ $section->id }}"
                                                                style="padding:0px;">
                                                                <div class="row" id="COMPANY">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group lead-heading">
                                                                            <label>{{ $section->name }}</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label>Title  Company Name</label> --}}
                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="Title  Company Name"
                                                                                    name="company_name"
                                                                                    onchange="updateValue(value,'company_name','title_company')"
                                                                                    table="title_company"
                                                                                    value="{{ $title_company->company_name }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label>Title Company Contact Name</label> --}}
                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="Title Company Contact Name"
                                                                                    name="SomeoneHelpingName">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label>Title Company Phone</label> --}}
                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="Title Company Phone"
                                                                                    name="SomeoneHelpingName">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label>Title Company Email</label> --}}
                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="Title Company Email"
                                                                                    name="SomeoneHelpingName">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label>Title Company Email</label> --}}
                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="Buying/Selling Entity Details"
                                                                                    onchange="updateValue(value,'buy_sell_entity_detail','title_company')"
                                                                                    table="title_company"
                                                                                    name="buy_sell_entity_detail">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @php
                                                                    $customeFields = getsectionsFields($section->id);
                                                                @endphp
                                                                <div class="row">
                                                                    @if (count($customeFields) > 0)
                                                                        <div class="col-md-12">
                                                                            <div class="form-group"
                                                                                style="padding: 0 10px;border-bottom: 1px solid #eee;">
                                                                                <label>{{ $section->name }} (Custom
                                                                                    Fields)</label>
                                                                            </div>
                                                                        </div>
                                                                        @foreach ($customeFields as $field)
                                                                            @php
                                                                                $customeFieldValue = getsectionsFieldValue($id, $field->id);
                                                                            @endphp
                                                                            <div class="col-md-4">
                                                                                <div class="form-group"
                                                                                    style="padding: 0 10px;">
                                                                                    {{-- <label>Owner 3 Social Security #</label> --}}
                                                                                    <div class="input-group mb-2">
                                                                                        <input
                                                                                            type="{{ $field->type }}"
                                                                                            class="form-control"
                                                                                            placeholder="{{ $field->label }}"
                                                                                            name="feild_value"
                                                                                            section_id="{{ $section->id }}"
                                                                                            id="{{ $field->id }}"
                                                                                            table="custom_field_values"
                                                                                            value="{{ $customeFieldValue }}">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <hr>
                                                        @elseif($section->id == '18')
                                                            <div class="col-md-12" id="{{ $section->id }}"
                                                                style="padding:0px;">
                                                                <div class="row" id="INSURANCE">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group lead-heading">
                                                                            <label>{{ $section->name }}</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label>Insurance Company Name</label> --}}
                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="Insurance Company Name"
                                                                                    name="SomeoneHelpingName">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label>Insurance Company Phone</label> --}}
                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="Insurance Company Phone"
                                                                                    name="SomeoneHelpingName">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label>Insurance Company Agent</label> --}}
                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="Insurance Company Agent"
                                                                                    name="SomeoneHelpingName">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label>Insurance Agent Phone</label> --}}
                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="Insurance Agent Phone"
                                                                                    name="SomeoneHelpingName">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label>Insurance Account Number</label> --}}
                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="Insurance Account Number"
                                                                                    name="SomeoneHelpingName">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label>Insurance Online Access Link</label> --}}
                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="Insurance Online Access Link"
                                                                                    name="SomeoneHelpingName">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label>Insurance Online Access User Name</label> --}}
                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="Insurance Online Access User Name"
                                                                                    name="SomeoneHelpingName">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label>Insurance Online Access Password</label> --}}
                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="Insurance Online Access Password"
                                                                                    name="SomeoneHelpingName">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @php
                                                                    $customeFields = getsectionsFields($section->id);
                                                                @endphp
                                                                <div class="row">
                                                                    @if (count($customeFields) > 0)
                                                                        <div class="col-md-12">
                                                                            <div class="form-group"
                                                                                style="padding: 0 10px;border-bottom: 1px solid #eee;">
                                                                                <label>{{ $section->name }} (Custom
                                                                                    Fields)</label>
                                                                            </div>
                                                                        </div>
                                                                        @foreach ($customeFields as $field)
                                                                            @php
                                                                                $customeFieldValue = getsectionsFieldValue($id, $field->id);
                                                                            @endphp
                                                                            <div class="col-md-4">
                                                                                <div class="form-group"
                                                                                    style="padding: 0 10px;">
                                                                                    {{-- <label>Owner 3 Social Security #</label> --}}
                                                                                    <div class="input-group mb-2">
                                                                                        <input
                                                                                            type="{{ $field->type }}"
                                                                                            class="form-control"
                                                                                            placeholder="{{ $field->label }}"
                                                                                            name="feild_value"
                                                                                            section_id="{{ $section->id }}"
                                                                                            id="{{ $field->id }}"
                                                                                            table="custom_field_values"
                                                                                            value="{{ $customeFieldValue }}">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <hr>
                                                        @elseif($section->id == '19')
                                                            <div class="col-md-12" id="{{ $section->id }}"
                                                                style="padding:0px;">
                                                                <div class="row" id="HOA">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group lead-heading">
                                                                            <label>{{ $section->name }}</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label>HOA Name</label> --}}
                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="HOA Name"
                                                                                    name="SomeoneHelpingName">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label>Contact Name</label> --}}
                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="Contact Name"
                                                                                    name="SomeoneHelpingName">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label>HOA Phone Number</label> --}}
                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="HOA Phone Number"
                                                                                    name="SomeoneHelpingName">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label>HOA Email</label> --}}
                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="HOA Email"
                                                                                    name="SomeoneHelpingName">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @php
                                                                    $customeFields = getsectionsFields($section->id);
                                                                @endphp
                                                                <div class="row">
                                                                    @if (count($customeFields) > 0)
                                                                        <div class="col-md-12">
                                                                            <div class="form-group"
                                                                                style="padding: 0 10px;border-bottom: 1px solid #eee;">
                                                                                <label>{{ $section->name }} (Custom
                                                                                    Fields)</label>
                                                                            </div>
                                                                        </div>
                                                                        @foreach ($customeFields as $field)
                                                                            @php
                                                                                $customeFieldValue = getsectionsFieldValue($id, $field->id);
                                                                            @endphp
                                                                            <div class="col-md-4">
                                                                                <div class="form-group"
                                                                                    style="padding: 0 10px;">
                                                                                    {{-- <label>Owner 3 Social Security #</label> --}}
                                                                                    <div class="input-group mb-2">
                                                                                        <input
                                                                                            type="{{ $field->type }}"
                                                                                            class="form-control"
                                                                                            placeholder="{{ $field->label }}"
                                                                                            name="feild_value"
                                                                                            section_id="{{ $section->id }}"
                                                                                            id="{{ $field->id }}"
                                                                                            table="custom_field_values"
                                                                                            value="{{ $customeFieldValue }}">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <hr>
                                                        @elseif($section->id == '20')
                                                            <div class="col-md-12" id="{{ $section->id }}"
                                                                style="padding:0px;">
                                                                <div class="row" id="FUTURE">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group lead-heading">
                                                                            <label>{{ $section->name }}</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">

                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="Seller 1 Forwarding Address"
                                                                                    name="SomeoneHelpingName">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label>Seller 1 Forwarding City</label> --}}
                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="Seller 1 Forwarding City"
                                                                                    name="SomeoneHelpingName">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label>Seller 1 Forwarding State</label> --}}
                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="Seller 1 Forwarding State"
                                                                                    name="SomeoneHelpingName">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label>Seller 1 Forwarding Zip</label> --}}
                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="Seller 1 Forwarding Zip"
                                                                                    name="SomeoneHelpingName">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label>Seller 1 Nearest Relative Address</label> --}}
                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="Seller 1 Nearest Relative Address"
                                                                                    name="SomeoneHelpingName">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label>Seller 1 Nearest Relative City</label> --}}
                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="Seller 1 Nearest Relative City"
                                                                                    name="SomeoneHelpingName">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label>Seller 1 Nearest Relative State</label> --}}
                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="Seller 1 Nearest Relative State"
                                                                                    name="SomeoneHelpingName">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label>Seller 1 Nearest Relative Zip</label> --}}
                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="Seller 1 Nearest Relative Zip"
                                                                                    name="SomeoneHelpingName">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label>Seller 1 Nearest Relative Phone</label> --}}
                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="Seller 1 Nearest Relative Phone"
                                                                                    name="SomeoneHelpingName">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label>Seller 2 Forwarding Address</label> --}}
                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="Seller 2 Forwarding Address"
                                                                                    name="SomeoneHelpingName">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label>Seller 2 Forwarding City</label> --}}
                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="Seller 2 Forwarding City"
                                                                                    name="SomeoneHelpingName">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label>Seller 2 Forwarding State</label> --}}
                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="Seller 2 Forwarding State"
                                                                                    name="SomeoneHelpingName">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label>Seller 2 Forwarding Zip</label> --}}
                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="Seller 2 Forwarding Zip"
                                                                                    name="SomeoneHelpingName">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label>Seller 2 Nearest Relative Address</label> --}}
                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="Seller 2 Nearest Relative Address"
                                                                                    name="SomeoneHelpingName">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label>Seller 2 Nearest Relative City</label> --}}
                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="Seller 2 Nearest Relative City"
                                                                                    name="SomeoneHelpingName">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label>Seller 2 Nearest Relative State</label> --}}
                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="Seller 2 Nearest Relative State"
                                                                                    name="SomeoneHelpingName">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label>Seller 2 Nearest Relative Zip</label> --}}
                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="Seller 2 Nearest Relative Zip"
                                                                                    name="SomeoneHelpingName">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label>Seller 2 Nearest Relative Phone</label> --}}
                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="Seller 2 Nearest Relative Phone"
                                                                                    name="SomeoneHelpingName">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label>Seller 3 Forwarding Address</label> --}}
                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="Seller 3 Forwarding Address"
                                                                                    name="SomeoneHelpingName">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label>Seller 3 Forwarding City</label> --}}
                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="Seller 3 Forwarding City"
                                                                                    name="SomeoneHelpingName">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label>Seller 3 Forwarding State</label> --}}
                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="Seller 3 Forwarding State"
                                                                                    name="SomeoneHelpingName">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label>Seller 3 Forwarding Zip</label> --}}
                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="Seller 3 Forwarding Zip"
                                                                                    name="SomeoneHelpingName">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label>Seller 3 Nearest Relative Address</label> --}}
                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="Seller 3 Nearest Relative Address"
                                                                                    name="SomeoneHelpingName">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label>Seller 3 Nearest Relative City</label> --}}
                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="Seller 3 Nearest Relative City"
                                                                                    name="SomeoneHelpingName">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label>Seller 3 Nearest Relative State</label> --}}
                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="Seller 3 Nearest Relative State"
                                                                                    name="SomeoneHelpingName">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label>Seller 3 Nearest Relative Zip</label> --}}
                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="Seller 3 Nearest Relative Zip"
                                                                                    name="SomeoneHelpingName">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label>Seller 3 Nearest Relative Phone</label> --}}
                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="Seller 3 Nearest Relative Phone"
                                                                                    name="SomeoneHelpingName">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label> Nearest Relative Phone</label> --}}
                                                                            <div class="input-group mb-2">
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    placeholder="Nearest Relative Phone"
                                                                                    name="SomeoneHelpingName">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @php
                                                                    $customeFields = getsectionsFields($section->id);
                                                                @endphp
                                                                <div class="row">
                                                                    @if (count($customeFields) > 0)
                                                                        <div class="col-md-12">
                                                                            <div class="form-group"
                                                                                style="padding: 0 10px;border-bottom: 1px solid #eee;">
                                                                                <label>{{ $section->name }} (Custom
                                                                                    Fields)</label>
                                                                            </div>
                                                                        </div>
                                                                        @foreach ($customeFields as $field)
                                                                            @php
                                                                                $customeFieldValue = getsectionsFieldValue($id, $field->id);
                                                                            @endphp
                                                                            <div class="col-md-4">
                                                                                <div class="form-group"
                                                                                    style="padding: 0 10px;">
                                                                                    {{-- <label>Owner 3 Social Security #</label> --}}
                                                                                    <div class="input-group mb-2">
                                                                                        <input
                                                                                            type="{{ $field->type }}"
                                                                                            class="form-control"
                                                                                            placeholder="{{ $field->label }}"
                                                                                            name="feild_value"
                                                                                            section_id="{{ $section->id }}"
                                                                                            id="{{ $field->id }}"
                                                                                            table="custom_field_values"
                                                                                            value="{{ $customeFieldValue }}">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <hr>
                                                        @elseif($section->id == '21')
                                                            <div class="col-md-12" id="{{ $section->id }}"
                                                                style="padding:0px;">
                                                                <div class="row" id="COMMITMENT">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group lead-heading">
                                                                            <label>{{ $section->name }}</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @php
                                                                    $customeFields = getsectionsFields($section->id);
                                                                @endphp
                                                                <div class="row">
                                                                    @if (count($customeFields) > 0)
                                                                        <div class="col-md-12">
                                                                            <div class="form-group"
                                                                                style="padding: 0 10px;border-bottom: 1px solid #eee;">
                                                                                <label>{{ $section->name }} (Custom
                                                                                    Fields)</label>
                                                                            </div>
                                                                        </div>
                                                                        @foreach ($customeFields as $field)
                                                                            @php
                                                                                $customeFieldValue = getsectionsFieldValue($id, $field->id);
                                                                            @endphp
                                                                            <div class="col-md-4">
                                                                                <div class="form-group"
                                                                                    style="padding: 0 10px;">
                                                                                    {{-- <label>Owner 3 Social Security #</label> --}}
                                                                                    <div class="input-group mb-2">
                                                                                        <input
                                                                                            type="{{ $field->type }}"
                                                                                            class="form-control"
                                                                                            placeholder="{{ $field->label }}"
                                                                                            name="feild_value"
                                                                                            section_id="{{ $section->id }}"
                                                                                            id="{{ $field->id }}"
                                                                                            table="custom_field_values"
                                                                                            value="{{ $customeFieldValue }}">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <hr>
                                                        @elseif($section->id == '23')
                                                            <div class="col-md-12" id="{{ $section->id }}"
                                                                style="padding:0px;">
                                                                <div class="row" id="SECTION">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group lead-heading">
                                                                            <label>{{ $section->name }}</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @php
                                                                    $customeFields = getsectionsFields($section->id);
                                                                @endphp
                                                                <div class="row">
                                                                    @if (count($customeFields) > 0)
                                                                        <div class="col-md-12">
                                                                            <div class="form-group"
                                                                                style="padding: 0 10px;border-bottom: 1px solid #eee;">
                                                                                <label>{{ $section->name }} (Custom
                                                                                    Fields)</label>
                                                                            </div>
                                                                        </div>
                                                                        @foreach ($customeFields as $field)
                                                                            @php
                                                                                $customeFieldValue = getsectionsFieldValue($id, $field->id);
                                                                            @endphp
                                                                            <div class="col-md-4">
                                                                                <div class="form-group"
                                                                                    style="padding: 0 10px;">
                                                                                    {{-- <label>Owner 3 Social Security #</label> --}}
                                                                                    <div class="input-group mb-2">
                                                                                        <input
                                                                                            type="{{ $field->type }}"
                                                                                            class="form-control"
                                                                                            placeholder="{{ $field->label }}"
                                                                                            name="feild_value"
                                                                                            section_id="{{ $section->id }}"
                                                                                            id="{{ $field->id }}"
                                                                                            table="custom_field_values"
                                                                                            value="{{ $customeFieldValue }}">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">

                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        <div class="card">
                                                                            <div class="card-header bg-soft-dark ">
                                                                                <table
                                                                                    class="table table-striped table-bordered"
                                                                                    id="datatable">
                                                                                    <thead>
                                                                                        <tr>

                                                                                            <th scope="col">Skip trace
                                                                                                option</th>

                                                                                            <th scope="col">Date of
                                                                                                Last Email Skip Trace</th>
                                                                                            <th scope="col">Date of
                                                                                                Last Phone Skip Trace</th>
                                                                                            <th scope="col">Date of
                                                                                                Last Name Skip Trace</th>
                                                                                            <th scope="col">Date of
                                                                                                Last Email Verification</th>
                                                                                            <th scope="col">Date of
                                                                                                Last Phone Scrub </th>

                                                                                            <th scope="col">Verified
                                                                                                Numbers & Emails</th>
                                                                                            <th scope="col">Scam
                                                                                                Numbers & Emails</th>

                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>

                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4"
                                        style="position: relative;margin-left: 1100px;margin-top: -524px;">
                                        <div class="card content-div">
                                            <div class="form-group" style="padding: 0 10px;">
                                                <label>Load Script</label>
                                                <select class="custom-select" name="lead_assigned_to"
                                                    onchange="loadScript(value)">
                                                    <option value="">Load Script</option>
                                                    @if (count($scripts) > 0)
                                                        @foreach ($scripts as $script)
                                                            <option value="{{ $script->id }}">{{ $script->name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="load_script"></div>
                                        </div>
                                    </div>

                                </div>
                                {{-- <button type="submit" class="btn btn-primary mt-2" >Send SMS</button>
                                            </div> --}}
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    <!-- Call Initiated Successfully Modal -->
    <div class="modal fade" id="initiate-call" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content mt-2">
                <div class="modal-body">
                    <p class="calling-response" style="text-align: center; font-size: 16px;"></p>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script>
        $(document).ready(function() {

            // $('#datatable').DataTable();
            $('#appoitment-list-table').DataTable();
            $("#custom-upload-button").click(function() {
                var form = $("#main_form");

                // Set the form's action attribute to the new route
                form.attr("action", "{{ route('admin.google.drive.login') }}");

                // Submit the form
                form.submit();
            });

            $("#agreement-upload-button").click(function() {
                var form = $("#main_form");

                // Set the form's action attribute to the new route
                form.attr("action", "{{ route('admin.contact.purchase_agreement') }}");

                // Submit the form
                form.submit();
            });

            $('#fetch-realtor-estimates-button').click(function() {
                getRealtorPropertyId();
            });
        });
    </script>
    <script>
        function showDiv(divId, element) {
            document.getElementById(divId).style.display = element.value == 1 ? 'block' : 'none';
        }

        function templateId() {
            template_id = document.getElementById("template-select").value;
            setTextareaValue(template_id)
        }
    </script>
    <script>
        // Check the type of file for upload to google drive
        function toggleFIlesUpload(value) {
            if (value == 'purchase_agreement') {
                $('#driveUpload').hide()
                $('#purchaseAgreementUpload').show()
            } else {
                $('#driveUpload').show()
                $('#purchaseAgreementUpload').hide()
            }
        }

        function setTextareaValue(id) {
            if (id > 0) {
                axios.get('/admin/template/' + id)
                    .then(response =>
                        document.getElementById("template_text").value = response.data['body'],
                    )
                    .catch(error => console.log(error));
            } else {
                document.getElementById("template_text").value = '';
            }


        }
        const textarea = document.querySelector('textarea')
        const count = document.getElementById('count')
        textarea.onkeyup = (e) => {
            count.innerHTML = "Characters: " + e.target.value.length + "/160";
        };

        $('.form-control').on("change keyup input", function() {
            var _token = $('input#_token').val();
            var id = {!! $id !!};
            var fieldVal = $(this).val();
            var table = $(this).attr('table');
            var fieldName = $(this).attr('name');
            if (table == 'custom_field_values') {
                var section_id = $(this).attr('section_id');
                var feild_id = $(this).attr('id');
            } else {
                var feild_id = 0;
                var section_id = 0;
            }
            var type = $(this).attr('type');
            $.ajax({
                method: "POST",
                url: '<?php echo url('admin/contact/detail/update'); ?>',
                data: {
                    id: id,
                    fieldVal: fieldVal,
                    table: table,
                    feild_id: feild_id,
                    section_id: section_id,
                    fieldName: fieldName,
                    type: type,
                    _token: _token
                },
                success: function(res) {
                    if (res.status == true) {
                        $.notify(res.message, 'success');
                        $("#custom_message").modal("hide");
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        $.notify(res.message, 'error');
                    }
                },
                error: function(err) {
                    $.notify('Error occurred while saving.', 'error');
                }
            });
        });

        function getRealtorPropertyId() {
            $('#propertyEstimatesFetchingId').show()
            var _token = $('input#_token').val();
            var id = {!! $contact->id !!};
            $.ajax({
                method: "POST",
                url: '<?php echo url('admin/contact/get-property-id'); ?>',
                data: {
                    id: id,
                    _token: _token
                },
                success: function(res) {
                    $('#propertyEstimatesFetchingId').hide()
                    if (res.status == true) {
                        if (id != null) {
                            getEstimates(res.id)
                        }
                        // Customize the Toastr message based on your requirements
                        toastr.success(res.message, {
                            timeOut: 10000, // Set the duration (10 seconds in this example)
                        });
                    } else {
                        // // If there are estimates, clear the container
                        // estimateContainer.html('');
                        // // Optionally, you can add a message or other content to indicate no results
                        // estimateContainer.append("<p>No estimates found.</p>");
                        // // Display an error message using Toastr for failed API responses
                        toastr.error(res.message, {
                            timeOut: 9000, // Set the duration (5 seconds in this example)
                        });
                    }
                },
                error: function(err) {
                    $('#propertyEstimatesFetchingId').hide()
                    // // If there are estimates, clear the container
                    // estimateContainer.html('');
                    // // Optionally, you can add a message or other content to indicate no results
                    // estimateContainer.append("<p>No estimates found.</p>");
                    // Display an error message using Toastr for failed API responses
                    toastr.error('API Error: ' + response.Message, 'API Response Error', {
                        timeOut: 9000, // Set the duration (5 seconds in this example)
                    });
                }
            });
        };

        function getEstimates(id) {
            $('#propertyEstimatesFetchingEstimates').show()
            var _token = $('input#_token').val();
            $.ajax({
                method: "POST",
                url: '<?php echo url('admin/contact/get-property-estimates'); ?>',
                data: {
                    id: id,
                    _token: _token
                },
                success: function(res) {
                    $('#propertyEstimatesFetchingEstimates').hide()
                    console.log(res)
                    if (res.status == true) {

                        var estimateContainer = $("#estimateContainer");

                        // Check if there are estimates in the response
                        if (res.estimates && res.estimates.length > 0) {
                            // // If there are estimates, clear the container
                            // estimateContainer.html('');

                            // Iterate through the estimates array
                            $.each(res.estimates, function(index, estimate) {
                                // Create a div element to display the estimate
                                var estimateDiv = $("<div>");

                                // Format the estimate, estimate_high, and estimate_low as currency
                                var formatter = new Intl.NumberFormat('en-US', {
                                    style: 'currency',
                                    currency: 'USD'
                                });

                                // Add data to the div
                                estimateDiv.append("<label>Source Name: " + estimate.source.name +
                                    "</label><br>");
                                estimateDiv.append("<label>Estimate: " + formatter.format(estimate
                                        .estimate) +
                                    "</label><br>");
                                estimateDiv.append("<label>Estimate High: " + formatter.format(estimate
                                        .estimate_high) +
                                    "</label><br>");
                                estimateDiv.append("<label>Estimate Low: " + formatter.format(estimate
                                        .estimate_low) +
                                    "</label><br>");
                                estimateDiv.append("<label>Date: " + estimate.date +
                                    "</label><br>");
                                estimateDiv.append("<hr>");

                                // Append the div to the container
                                estimateContainer.append(estimateDiv);
                            });
                        } else {
                            // // If there are estimates, clear the container
                            // estimateContainer.html('');
                            // // Optionally, you can add a message or other content to indicate no results
                            // estimateContainer.append("<p>No estimates found.</p>");
                        }
                        // Customize the Toastr message based on your requirements
                        toastr.success(res.message, {
                            timeOut: 10000, // Set the duration (10 seconds in this example)
                        });
                    } else {
                        // Display an error message using Toastr for failed API responses
                        toastr.error(res.message, {
                            timeOut: 9000, // Set the duration (5 seconds in this example)
                        });
                    }
                },
                error: function(err) {
                    $('#propertyEstimatesFetchingEstimates').hide()
                    // Display an error message using Toastr for failed API responses
                    toastr.error('API Error: ' + response.Message, 'API Response Error', {
                        timeOut: 9000, // Set the duration (5 seconds in this example)
                    });
                }
            });
        };

        function updateValue(fieldVal, fieldName, table) {
            var _token = $('input#_token').val();
            var id = {!! $id !!};
            $.ajax({
                method: "POST",
                url: '<?php echo url('admin/contact/detail/update'); ?>',
                data: {
                    id: id,
                    fieldVal: fieldVal,
                    table: table,
                    fieldName: fieldName,
                    _token: _token
                },
                success: function(res) {
                    if (res.status == true) {
                        toastr.success(res.message, {
                            timeOut: 10000, // Set the duration (10 seconds in this example)
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        $.notify(res.message, 'error');
                    }
                },
                error: function(err) {
                    $.notify('Error occurred while saving.', 'error');
                }
            });
        }

        function loadScript(val) {
            var _token = $('input#_token').val();
            var id = val;
            $.ajax({
                method: "get",
                url: '<?php echo url('admin/load/script'); ?>' + '/' + id,
                data: '',
                success: function(res) {
                    $('.load_script').html(res);
                },
                error: function(err) {
                    $.notify('Error occurred while saving.', 'error');
                }
            });
        }
    </script>
@endsection
