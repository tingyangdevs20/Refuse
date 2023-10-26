@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css"
        integrity="sha256-2XFplPlrFClt0bIdPgpz8H7ojnk10H69xRqd9+uTShA=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/4.5.6/css/ionicons.min.css"
        integrity="sha512-0/rEDduZGrqo4riUlwqyuHDQzp2D1ZCgH/gFIfjMIL5az8so6ZiXyhf1Rg8i6xsjv+z/Ubc4tt1thLigEcu6Ug=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />




    <style>
        /* Style for the placeholder label */
        .placeholder {
            position: absolute;
            pointer-events: none;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            transition: all 0.2s ease-in-out;
        }

        /* Style to hide the label when the input is focused or has a value */
        .date-input-container input:focus+.placeholder,
        .date-input-container input:not(:placeholder-shown)+.placeholder {
            transform: translateY(-100%) scale(0.8);
        }
        
        

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
            padding: 5px !important;
            background: #ccc;
            border-radius: 5px;
            line-height: 44px;
        }

        .dropdown-item {
            display: inline;
            width: auto;
            padding: 1px;
            clear: both;
            font-weight: 400;
            color: #212529;
            text-align: inherit;
            white-space: nowrap;
            background-color: transparent;
            border: 0;
        }

        .button-item {
            background-color: #38B6FF;
            color: black;
            border-color: #38B6FF;
            transition: background-color 0.3s, color 0.3s;
            /* Add a transition for a smooth effect */
        }

        .button-item:hover {
            background-color: #38B6FF;
            /* Change the background color on hover */
            color: white;
            /* Change the text color on hover */
            border-color: #38B6FF;
        }

        .load_script {
            background-color: #f0f0f0;
            /* A background color to visually indicate it's not editable */
            cursor: not-allowed;
            /* Display a "not-allowed" cursor when hovering */
            pointer-events: none;
            /* Prevent mouse events (clicks, hovers) on the div */
        }

        .file-manager ul {
            list-style: none;
        }

        .file-manager .folder {
            display: block;
            text-align: center;
            margin: 10px;
            padding: 10px;
        }

        .file-manager .folder .folder-icon-large {
            font-size: 40px;
            /* Adjust the size as needed */
        }

        .file-manager .heading {
            font-size: 24px;
            /* Adjust the size as needed */
            text-align: left;
            margin: 10px 0;
            list-style: none;
        }

        body {
            margin-top: 20px;
        }

        .file-manager-actions {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            -ms-flex-pack: justify;
            justify-content: space-between;
        }

        .file-manager-actions>* {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
        }

        .file-manager-container {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
        }

        .file-item {
            position: relative;
            z-index: 1;
            -ms-flex: 0 0 auto;
            flex: 0 0 auto;
            border: 1px solid #eee;
            cursor: pointer;
        }

        .file-item:hover,
        .file-item.focused {
            border-color: rgba(0, 0, 0, 0.05);
        }

        .file-item.focused {
            z-index: 2;
        }

        .file-item * {
            -ms-flex-negative: 0;
            flex-shrink: 0;
            text-decoration: none;
        }

        .dark-style .file-item:hover,
        .dark-style .file-item.focused {
            border-color: rgba(255, 255, 255, 0.2);
        }

        .file-item-checkbox {
            margin: 0 !important;
        }

        .file-item-select-bg {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: -1;
            opacity: 0;
        }

        .file-item-img {
            background-color: transparent;
            background-position: center center;
            background-size: cover;
        }

        .file-item-name {
            display: block;
            overflow: hidden;
        }

        .file-manager-col-view .file-item {
            margin: 0 0.25rem 0.25rem 0;
            padding: 1.25rem 0 1rem 0;
            width: 9rem;
            text-align: center;
        }

        [dir="rtl"] .file-manager-col-view .file-item {
            margin-right: 0;
            margin-left: 0.25rem;
        }

        .file-manager-col-view .file-item-img,
        .file-manager-col-view .file-item-icon {
            display: block;
            margin: 0 auto 0.75rem auto;
            width: 4rem;
            height: 4rem;
            font-size: 2.5rem;
            line-height: 4rem;
        }

        .file-manager-col-view .file-item-level-up {
            font-size: 1.5rem;
        }

        .file-manager-col-view .file-item-checkbox,
        .file-manager-col-view .file-item-actions {
            position: absolute;
            top: 6px;
        }

        .file-manager-col-view .file-item-checkbox {
            left: 6px;
        }

        [dir="rtl"] .file-manager-col-view .file-item-checkbox {
            right: 6px;
            left: auto;
        }

        .file-manager-col-view .file-item-actions {
            right: 6px;
        }

        [dir="rtl"] .file-manager-col-view .file-item-actions {
            right: auto;
            left: 6px;
        }

        .file-manager-col-view .file-item-name {
            width: 100%;
        }

        .file-manager-col-view .file-manager-row-header,
        .file-manager-col-view .file-item-changed {
            display: none;
        }

        .file-manager-row-view .file-manager-row-header,
        .file-manager-row-view .file-item {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            margin: 0 0 0.125rem 0;
            padding: 0.25rem 3rem 0.25rem 2.25em;
            width: 100%;
        }

        [dir="rtl"] .file-manager-row-view .file-manager-row-header,
        [dir="rtl"] .file-manager-row-view .file-item {
            padding-right: 2.25em;
            padding-left: 3rem;
        }

        .file-manager-row-view .file-item-img,
        .file-manager-row-view .file-item-icon {
            display: block;
            margin: 0 1rem;
            width: 2rem;
            height: 2rem;
            text-align: center;
            font-size: 1.25rem;
            line-height: 2rem;
        }

        .file-manager-row-view .file-item-level-up {
            font-size: 1rem;
        }

        .file-manager-row-view .file-item-checkbox,
        .file-manager-row-view .file-item-actions {
            position: absolute;
            top: 50%;
            -webkit-transform: translateY(-50%);
            transform: translateY(-50%);
        }

        .file-manager-row-view .file-item-checkbox {
            left: 10px;
        }

        [dir="rtl"] .file-manager-row-view .file-item-checkbox {
            right: 10px;
            left: auto;
        }

        .file-manager-row-view .file-item-actions {
            right: 10px;
        }

        [dir="rtl"] .file-manager-row-view .file-item-actions {
            right: auto;
            left: 10px;
        }

        .file-manager-row-view .file-item-changed {
            display: none;
            margin-left: auto;
            width: 10rem;
        }

        [dir="rtl"] .file-manager-row-view .file-item-changed {
            margin-right: auto;
            margin-left: 0;
        }

        .file-manager-row-view .file-item-name {
            width: calc(100% - 4rem);
        }

        .file-manager-row-view .file-manager-row-header {
            border-bottom: 2px solid rgba(0, 0, 0, 0.05);
            font-weight: bold;
        }

        .file-manager-row-view .file-manager-row-header .file-item-name {
            margin-left: 4rem;
        }

        [dir="rtl"] .file-manager-row-view .file-manager-row-header .file-item-name {
            margin-right: 4rem;
            margin-left: 0;
        }

        .light-style .file-item-name {
            color: #4e5155 !important;
        }

        .light-style .file-item.selected .file-item-select-bg {
            opacity: 0.15;
        }

        @media (min-width: 768px) {
            .light-style .file-manager-row-view .file-item-changed {
                display: block;
            }

            .light-style .file-manager-row-view .file-item-name {
                width: calc(100% - 15rem);
            }
        }

        @media (min-width: 992px) {

            .light-style .file-manager-col-view .file-item-checkbox,
            .light-style .file-manager-col-view .file-item-actions {
                opacity: 0;
            }

            .light-style .file-manager-col-view .file-item:hover .file-item-checkbox,
            .light-style .file-manager-col-view .file-item.focused .file-item-checkbox,
            .light-style .file-manager-col-view .file-item.selected .file-item-checkbox,
            .light-style .file-manager-col-view .file-item:hover .file-item-actions,
            .light-style .file-manager-col-view .file-item.focused .file-item-actions,
            .light-style .file-manager-col-view .file-item.selected .file-item-actions {
                opacity: 1;
            }
        }

        .material-style .file-item-name {
            color: #4e5155 !important;
        }

        .material-style .file-item.selected .file-item-select-bg {
            opacity: 0.15;
        }

        @media (min-width: 768px) {
            .material-style .file-manager-row-view .file-item-changed {
                display: block;
            }

            .material-style .file-manager-row-view .file-item-name {
                width: calc(100% - 15rem);
            }
        }

        @media (min-width: 992px) {

            .material-style .file-manager-col-view .file-item-checkbox,
            .material-style .file-manager-col-view .file-item-actions {
                opacity: 0;
            }

            .material-style .file-manager-col-view .file-item:hover .file-item-checkbox,
            .material-style .file-manager-col-view .file-item.focused .file-item-checkbox,
            .material-style .file-manager-col-view .file-item.selected .file-item-checkbox,
            .material-style .file-manager-col-view .file-item:hover .file-item-actions,
            .material-style .file-manager-col-view .file-item.focused .file-item-actions,
            .material-style .file-manager-col-view .file-item.selected .file-item-actions {
                opacity: 1;
            }
        }

        .dark-style .file-item-name {
            color: #fff !important;
        }

        .dark-style .file-item.selected .file-item-select-bg {
            opacity: 0.15;
        }

        @media (min-width: 768px) {
            .dark-style .file-manager-row-view .file-item-changed {
                display: block;
            }

            .dark-style .file-manager-row-view .file-item-name {
                width: calc(100% - 15rem);
            }
        }

        @media (min-width: 992px) {

            .dark-style .file-manager-col-view .file-item-checkbox,
            .dark-style .file-manager-col-view .file-item-actions {
                opacity: 0;
            }

            .dark-style .file-manager-col-view .file-item:hover .file-item-checkbox,
            .dark-style .file-manager-col-view .file-item.focused .file-item-checkbox,
            .dark-style .file-manager-col-view .file-item.selected .file-item-checkbox,
            .dark-style .file-manager-col-view .file-item:hover .file-item-actions,
            .dark-style .file-manager-col-view .file-item.focused .file-item-actions,
            .dark-style .file-manager-col-view .file-item.selected .file-item-actions {
                opacity: 1;
            }
        }

        .popover .arrow {
            display: none !important;
        }
        .note-toolbar .panel-heading{
            display: none !important;
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

                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            <i class="fas fa-edit mr-1"></i>Contact
                            @include('components.modalform')
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
                                            <ul class="dropdown-menu-new" style="padding-left: 0;margin-top:-17px">
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
                                                                                id="date_added" table="lead_info"
                                                                                value="{{ $leadinfo->date_added == '' ? '' : $leadinfo->date_added }}">
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Lead Status</label> --}}
                                                                        <select class="custom-select" name="lead_status"
                                                                            table="lead_info"
                                                                            onchange="updateValue(value,'lead_status','lead_info')">>
                                                                            <option value="">Lead
                                                                                Status {{ $leadinfo->lead_status }}
                                                                            </option>
                                                                            <option value="None/Unknown"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'None/Unknown') selected @endif
                                                                                @endif>None/Unknown
                                                                            </option>
                                                                            <option value="Prospect"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'Prospect') selected @endif
                                                                                @endif>Prospect
                                                                            </option>
                                                                            <option value="DNC"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'DNC') selected @endif
                                                                                @endif>DNC</option>
                                                                            <option value="Lead-New"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'Lead-New') selected @endif
                                                                                @endif>Lead-New
                                                                            </option>

                                                                            <option value="Lead-Cold"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'Lead-Cold') selected @endif
                                                                                @endif>Lead-Cold
                                                                            </option>
                                                                            <option value="Lead-Warm"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'Lead-Warm') selected @endif
                                                                                @endif>Lead-Warm
                                                                            </option>
                                                                            <option value="Lead-Hot"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'Lead-Hot') selected @endif
                                                                                @endif>Lead-Hot
                                                                            </option>
                                                                            <option value="Send to Research"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'Send to Research') selected @endif
                                                                                @endif>Send to Research
                                                                            </option>

                                                                            <option value="Not Available - Not Selling"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'Not Available - Not Selling') selected @endif
                                                                                @endif>Not Available -
                                                                                Not Selling
                                                                            </option>

                                                                            <option value="Not Available - Sold Property"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'Not Available - Sold Property') selected @endif
                                                                                @endif>Not Available -
                                                                                Sold Property
                                                                            </option>

                                                                            <option
                                                                                value="Not Available - Under Contract w/3rd Party"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'Not Available - Under Contract w/3rd Party') selected @endif
                                                                                @endif>Not Available -
                                                                                Under Contract w/3rd Party
                                                                            </option>


                                                                            <option value="Not Interested"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'Not Interested') selected @endif
                                                                                @endif>Not Interested
                                                                            </option>

                                                                            <option value="Non-Responsive"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'Non-Responsive') selected @endif
                                                                                @endif>Non-Responsive
                                                                            </option>

                                                                            <option value="Maybe to Our Offer"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'Maybe to Our Offer') selected @endif
                                                                                @endif>Maybe to Our
                                                                                Offer
                                                                            </option>

                                                                            <option value="Phone Call - Scheduled"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'Phone Call - Scheduled') selected @endif
                                                                                @endif>Phone Call -
                                                                                Scheduled
                                                                            </option>

                                                                            <option value="Phone Call - Completed"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'Phone Call - Completed') selected @endif
                                                                                @endif>Phone Call -
                                                                                Completed
                                                                            </option>

                                                                            <option value="Phone Call - No Show"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'Phone Call - No Show') selected @endif
                                                                                @endif>Phone Call - No
                                                                                Show
                                                                            </option>

                                                                            <option value="Phone Call - Said No"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'Phone Call - Said No') selected @endif
                                                                                @endif>Phone Call -
                                                                                Said No
                                                                            </option>

                                                                            <option value="Contract Out - Buy Side"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'Contract Out - Buy Side') selected @endif
                                                                                @endif>Contract Out -
                                                                                Buy Side
                                                                            </option>

                                                                            <option value="Contract Out - Sell Side"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'Contract Out - Sell Side') selected @endif
                                                                                @endif>Contract Out -
                                                                                Sell Side
                                                                            </option>

                                                                            <option value="Contract Signed - Buy Side"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'Contract Signed - Buy Side') selected @endif
                                                                                @endif>Contract Signed
                                                                                - Buy Side
                                                                            </option>

                                                                            <option value="Contract Signed - Sell Side"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'Contract Signed - Sell Side') selected @endif
                                                                                @endif>Contract Signed
                                                                                - Sell Side
                                                                            </option>

                                                                            <option value="Closed Deal - Buy Side"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'Closed Deal - Buy Side') selected @endif
                                                                                @endif>Closed Deal -
                                                                                Buy Side
                                                                            </option>
                                                                            <option value="Closed Deal - Sell Side"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'Closed Deal - Sell Side') selected @endif
                                                                                @endif>Closed Deal -
                                                                                Sell Side
                                                                            </option>
                                                                            <option value="Rehab in Process"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'Rehab in Process') selected @endif
                                                                                @endif>Rehab in Process
                                                                            </option>
                                                                            <option value="Hold - Rental"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'Hold - Rental') selected @endif
                                                                                @endif>Hold - Rental
                                                                            </option>
                                                                            <option value="For Sale (by Us)"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'For Sale (by Us)') selected @endif
                                                                                @endif>For Sale (by Us)
                                                                            </option>
                                                                            <option value="Closed Deal - Buy Side"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'Closed Deal - Buy Side') selected @endif
                                                                                @endif>Closed Deal -
                                                                                Buy Side
                                                                            </option>
                                                                            <option value="Closed Deal - Sell Side"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_status == 'Closed Deal - Sell Side') selected @endif
                                                                                @endif>Closed Deal -
                                                                                Sell Side
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
                                                                            <option value="">Lead Assigned To
                                                                            </option>
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
                                                                            onchange="updateValue(value,'lead_type','lead_info')">
                                                                            <option value="">Lead
                                                                                Type
                                                                            </option>
                                                                            <option value="Agents"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_type == 'Agents') selected @endif
                                                                                @endif>Agents
                                                                            </option>

                                                                            <option value="Attorney"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_type == 'Attorney') selected @endif
                                                                                @endif>Attorney
                                                                            </option>

                                                                            <option value="Buyer (Investors)"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_type == 'Buyer (Investors)') selected @endif
                                                                                @endif>Buyer
                                                                                (Investors)
                                                                            </option>

                                                                            <option value="Buyer (Owner Financing)"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_type == 'Buyer (Owner Financing)') selected @endif
                                                                                @endif>Buyer (Owner
                                                                                Financing)
                                                                            </option>

                                                                            <option value="Buyer (Retail)"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_type == 'Buyer (Retail)') selected @endif
                                                                                @endif>Buyer (Retail)
                                                                            </option>

                                                                            <option value="Code Enforcement"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_type == 'Code Enforcement') selected @endif
                                                                                @endif>Code Enforcement
                                                                            </option>

                                                                            <option value="Mortgage Brokers"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_type == 'Mortgage Brokers') selected @endif
                                                                                @endif>Mortgage Brokers
                                                                            </option>

                                                                            <option value="Seller"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_type == 'Seller') selected @endif
                                                                                @endif>Seller
                                                                            </option>
                                                                            <option value="Tenant"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_type == 'Tenant') selected @endif
                                                                                @endif>Tenant
                                                                            </option>

                                                                            <option value="Title Company"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_type == 'Title Company') selected @endif
                                                                                @endif>Title Company
                                                                            </option>

                                                                            <option value="Wholesaler"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_type == 'Wholesaler') selected @endif
                                                                                @endif>Wholesaler
                                                                            </option>

                                                                            <option value="Other"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_type == 'Other') selected @endif
                                                                                @endif>Other
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        <select class="custom-select select2"
                                                                            multiple="multiple"
                                                                            onchange="updateTagValue(value,'tags','lead_info')"
                                                                            name="tag_id[]" id="tags"
                                                                            style="width: 100%;">
                                                                            <option value=""
                                                                                @if (count($selected_tags) == 0) selected @endif
                                                                                disabled>Select Tags</option>
                                                                            @if (count($tags) > 0)
                                                                                @foreach ($tags as $tag)
                                                                                    @php
                                                                                        $selected = in_array($tag->id, $selected_tags) ? 'selected' : '';
                                                                                    @endphp
                                                                                    <option value="{{ $tag->id }}"
                                                                                        {{ $selected }}>
                                                                                        {{ $tag->name }}</option>
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Lead Source</label> --}}
                                                                        <select class="custom-select" name="lead_source"
                                                                            onchange="updateValue(value,'lead_source','lead_info')">
                                                                            <option value="">Lead Source</option>
                                                                            <option value="Bandit Signs"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'Bandit Signs') selected @endif
                                                                                @endif>Bandit Signs
                                                                            </option>
                                                                            <option value="Billboards"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'Billboards') selected @endif
                                                                                @endif>Billboards
                                                                            </option>
                                                                            <option value="Cold Calling"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'Cold Calling') selected @endif
                                                                                @endif>Cold Calling
                                                                            </option>
                                                                            <option value="Direct Mail"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'Direct Mail') selected @endif
                                                                                @endif>Direct Mail
                                                                            </option>
                                                                            <option value="Door Knocking"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'Door Knocking') selected @endif
                                                                                @endif>Door Knocking
                                                                            </option>
                                                                            <option value="Email"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'Email') selected @endif
                                                                                @endif>Email
                                                                            </option>
                                                                            <option value="Facebook Ads"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'Facebook Ads') selected @endif
                                                                                @endif>Facebook Ads
                                                                            </option>
                                                                            <option value="Flyers"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'Flyers') selected @endif
                                                                                @endif>Flyers
                                                                            </option>
                                                                            <option value="Instagram Ads"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'Instagram Ads') selected @endif
                                                                                @endif>Instagram Ads
                                                                            </option>
                                                                            <option value="iSpeedToLead"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'iSpeedToLead') selected @endif
                                                                                @endif>iSpeedToLead
                                                                            </option>
                                                                            <option value="LinkedIn Ads"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'LinkedIn Ads') selected @endif
                                                                                @endif>LinkedIn Ads
                                                                            </option>
                                                                            <option value="Magazine"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'Magazine') selected @endif
                                                                                @endif>Magazine
                                                                            </option>
                                                                            <option value="MMS"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'MMS') selected @endif
                                                                                @endif>MMS
                                                                            </option>
                                                                            <option value="Newspaper"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'Newspaper') selected @endif
                                                                                @endif>Newspaper
                                                                            </option>
                                                                            <option value="Phone Call (Incoming)"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'Phone Call (Incoming)') selected @endif
                                                                                @endif>Phone Call
                                                                                (Incoming)
                                                                            </option>
                                                                            <option value="Radio"
                                                                            @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'Radio') selected @endif
                                                                            @endif>Radio
                                                                        </option>
                                                                            <option value="Referral"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'Referral') selected @endif
                                                                                @endif>Referral
                                                                            </option>
                                                                            <option value="Retargeting"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'Retargeting') selected @endif
                                                                                @endif>Retargeting
                                                                            </option>
                                                                            <option value="RVM"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'Retargeting') selected @endif
                                                                                @endif>RVM
                                                                            </option>
                                                                            <option value="SEO"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'SEO') selected @endif
                                                                                @endif>SEO
                                                                            </option>
                                                                            <option value="SMS"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'SMS') selected @endif
                                                                                @endif>SMS
                                                                            </option>
                                                                            <option value="Social Media"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'Social Media') selected @endif
                                                                                @endif>Social Media
                                                                            </option>
                                                                            <option value="Tiktok Ads"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'Tiktok Ads') selected @endif
                                                                                @endif>Tiktok Ads
                                                                            </option>
                                                                            <option value="Twitter Ads"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'Twitter Ads') selected @endif
                                                                                @endif>Twitter Ads
                                                                            </option>
                                                                            <option value="Website"
                                                                                @if (isset($leadinfo)) @if ($leadinfo->lead_source == 'Website') selected @endif
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
                                                                            <textarea id="template_text" class="form-control" rows="1" placeholder="Mailing Address"
                                                                                name="mailing_address" table="lead_info">{{ $leadinfo->mailing_address == '' ? '' : $leadinfo->mailing_address }}</textarea>
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
                                                                                name="mailing_zip" table="lead_info"
                                                                                value="{{ $leadinfo->mailing_zip == '' ? '' : $leadinfo->mailing_zip }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- Owner info 1 --}}
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group"
                                                                        style="padding: 0 10px;border-bottom: 1px solid #eee;">
                                                                        <label>Contact 1</label>
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
                                                                                value="{{ $leadinfo->owner1_first_name == '' ? '' : $leadinfo->owner1_first_name }}">
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
                                                                                value="{{ $leadinfo->owner1_last_name == '' ? '' : $leadinfo->owner1_last_name }}">
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
                                                                                placeholder="Primary Phone Number"
                                                                                name="owner1_primary_number"
                                                                                table="lead_info"
                                                                                value="{{ $leadinfo->owner1_primary_number == '' ? '' : $leadinfo->owner1_primary_number }}">
                                                                            @if ($leadinfo->owner1_primary_number)
                                                                                <a id="button-call" class="m-1"
                                                                                    href="javascript:void(0)"
                                                                                    phone-number="{{ $leadinfo->owner1_primary_number == '' ? '' : $leadinfo->owner1_primary_number }}"><i
                                                                                        class="fas fa-phone whatsapp-icon button-item"
                                                                                        style="padding: 24%"></i></a>
                                                                                <button id="button-hangup-outgoing"
                                                                                    class='d-none button-item'>
                                                                                    <i class="fas fa-phone whatsapp-icon button-item hangupicon"
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
                                                                                placeholder="Phone Number 2"
                                                                                name="owner1_number2" table="lead_info"
                                                                                value="{{ $leadinfo->owner1_number2 == '' ? '' : $leadinfo->owner1_number2 }}">
                                                                            @if ($leadinfo->owner1_number2)
                                                                                <a id="button-call" class=" m-1"
                                                                                    href="javascript:void(0)"
                                                                                    phone-number="{{ $leadinfo->owner1_number2 == '' ? '' : $leadinfo->owner1_number2 }}"><i
                                                                                        class="fas fa-phone whatsapp-icon button-item"
                                                                                        style="padding: 24%"></i></a>
                                                                                <button id="button-hangup-outgoing"
                                                                                    class='d-none button-item'>
                                                                                    <i class="fas fa-phone whatsapp-icon button-item hangupicon"
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
                                                                                placeholder="Phone Number 3"
                                                                                name="owner1_number3" table="lead_info"
                                                                                value="{{ $leadinfo->owner1_number3 == '' ? '' : $leadinfo->owner1_number3 }}">
                                                                            @if ($leadinfo->owner1_number3)
                                                                                <a id="button-call" class="m-1"
                                                                                    href="javascript:void(0)"
                                                                                    phone-number="{{ $leadinfo->owner1_number3 == '' ? '' : $leadinfo->owner1_number3 }}"><i
                                                                                        class="fas fa-phone whatsapp-icon button-item"
                                                                                        style="padding: 24%"></i></a>
                                                                                <button id="button-hangup-outgoing"
                                                                                    class='d-none button-item'>
                                                                                    <i class="fas fa-phone whatsapp-icon button-item hangupicon"
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
                                                                            <!-- Display the date as text -->
                                                                            <input class="form-control"
                                                                                placeholder="Date of Birth"
                                                                                name="owner1_dob" table="lead_info"
                                                                                type="date"
                                                                                onchange="updateValue(value,'owner1_dob','lead_info')"
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
                                                                        <label>Contact 2</label>
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
                                                                                placeholder="Primary Phone Number"
                                                                                name="owner2_primary_number"
                                                                                table="lead_info"
                                                                                value="{{ $leadinfo->owner2_primary_number == '' ? '' : $leadinfo->owner2_primary_number }}">
                                                                            @if ($leadinfo->owner2_primary_number)
                                                                                <a id="button-call"
                                                                                    class="outgoing-call m-1"
                                                                                    href="javascript:void(0)"
                                                                                    phone-number="{{ $leadinfo->owner2_primary_number == '' ? '' : $leadinfo->owner2_primary_number }}"><i
                                                                                        class="fas fa-phone whatsapp-icon button-item"
                                                                                        style="padding: 24%"></i></a>
                                                                                <button
                                                                                    id="button-hangup-outgoing button-item"
                                                                                    class='d-none'>
                                                                                    <i class="fas fa-phone whatsapp-icon button-item hangupicon"
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
                                                                                placeholder="Phone Number 2"
                                                                                name="owner2_number2" table="lead_info"
                                                                                value="{{ $leadinfo->owner2_number2 == '' ? '' : $leadinfo->owner2_number2 }}">
                                                                            @if ($leadinfo->owner2_number2)
                                                                                <a id="button-call"
                                                                                    class="outgoing-call m-1"
                                                                                    href="javascript:void(0)"
                                                                                    phone-number="{{ $leadinfo->owner2_number2 == '' ? '' : $leadinfo->owner2_number2 }}"><i
                                                                                        class="fas fa-phone whatsapp-icon button-item"
                                                                                        style="padding: 24%"></i></a>
                                                                                <button
                                                                                    id="button-hangup-outgoing button-item"
                                                                                    class='d-none'>
                                                                                    <i class="fas fa-phone whatsapp-icon button-item hangupicon"
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
                                                                                placeholder="Phone Number 3"
                                                                                name="owner2_number3" table="lead_info"
                                                                                value="{{ $leadinfo->owner2_number3 == '' ? '' : $leadinfo->owner2_number3 }}">
                                                                            @if ($leadinfo->owner2_number3)
                                                                                <a id="button-call"
                                                                                    class="outgoing-call m-1"
                                                                                    href="javascript:void(0)"
                                                                                    phone-number="{{ $leadinfo->owner2_number3 == '' ? '' : $leadinfo->owner2_number3 }}"><i
                                                                                        class="fas fa-phone whatsapp-icon button-item"
                                                                                        style="padding: 24%"></i></a>
                                                                                <button
                                                                                    id="button-hangup-outgoing button-item"
                                                                                    class='d-none'>
                                                                                    <i class="fas fa-phone whatsapp-icon button-item hangupicon"
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
                                                                            <input class="form-control"
                                                                                placeholder="Date of Birth"
                                                                                name="owner2_dob" table="lead_info"
                                                                                type="date"
                                                                                onchange="updateValue(value,'owner2_dob','lead_info')"
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
                                                                        <label>Contact 3</label>
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
                                                                                placeholder="Phone Primary Number"
                                                                                name="owner3_primary_number"
                                                                                table="lead_info"
                                                                                value="{{ $leadinfo->owner3_primary_number == '' ? '' : $leadinfo->owner3_primary_number }}">
                                                                            @if ($leadinfo->owner3_primary_number)
                                                                                <a id="button-call"
                                                                                    class="outgoing-call m-1"
                                                                                    href="javascript:void(0)"
                                                                                    phone-number="{{ $leadinfo->owner3_primary_number == '' ? '' : $leadinfo->owner3_primary_number }}"><i
                                                                                        class="fas fa-phone whatsapp-icon button-item"
                                                                                        style="padding: 24%"></i></a>
                                                                                <button
                                                                                    id="button-hangup-outgoing button-item"
                                                                                    class='d-none'>
                                                                                    <i class="fas fa-phone whatsapp-icon button-item hangupicon"
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
                                                                                placeholder="Phone Number 2"
                                                                                name="owner3_number2" table="lead_info"
                                                                                value="{{ $leadinfo->owner3_number2 == '' ? '' : $leadinfo->owner3_number2 }}">
                                                                            @if ($leadinfo->owner3_number2)
                                                                                <a id="button-call"
                                                                                    class="outgoing-call m-1"
                                                                                    href="javascript:void(0)"
                                                                                    phone-number="{{ $leadinfo->owner3_number2 == '' ? '' : $leadinfo->owner3_number2 }}"><i
                                                                                        class="fas fa-phone whatsapp-icon button-item"
                                                                                        style="padding: 24%"></i></a>
                                                                                <button
                                                                                    id="button-hangup-outgoing button-item"
                                                                                    class='d-none'>
                                                                                    <i class="fas fa-phone whatsapp-icon button-item hangupicon"
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
                                                                                placeholder="Phone Number 3"
                                                                                name="owner3_number3" table="lead_info"
                                                                                value="{{ $leadinfo->owner3_number2 == '' ? '' : $leadinfo->owner3_number2 }}">
                                                                            @if ($leadinfo->owner3_number3)
                                                                                <a id="button-call"
                                                                                    class="outgoing-call m-1"
                                                                                    href="javascript:void(0)"
                                                                                    phone-number="{{ $leadinfo->owner3_number3 == '' ? '' : $leadinfo->owner3_number3 }}"><i
                                                                                        class="fas fa-phone whatsapp-icon button-item"
                                                                                        style="padding: 24%"></i></a>
                                                                                <button
                                                                                    id="button-hangup-outgoing button-item"
                                                                                    class='d-none'>
                                                                                    <i class="fas fa-phone whatsapp-icon button-item hangupicon"
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
                                                                            <input class="form-control"
                                                                                placeholder="Date of Birth"
                                                                                name="owner3_dob" table="lead_info"
                                                                                type="date"
                                                                                onchange="updateValue(value,'owner2_dob','lead_info')"
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
                                                                            <textarea id="template_text" class="form-control" rows="1" placeholder="Property Address"
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
                                                                                table="values_conditions">{{ $values_conditions->repair_detail == null ? null : $values_conditions->repair_detail }}</textarea>
                                                                        </div>
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
                                                                        <div class="input-group mb-2">
                                                                            <button type="button"
                                                                                id="fetch-realtor-estimates-button"
                                                                                class="btn btn-primary button-item">Get
                                                                                Property
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
                                                                <div class="col-md-12">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        <div class="input-group mb-2">
                                                                            <button type="button"
                                                                                id="fetch-map-links-button"
                                                                                class="btn btn-primary button-item">Get
                                                                                Google Maps &
                                                                                Zillow link</button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group"
                                                                        style="padding: 0 10px; display: none;"
                                                                        id="fetchgooglemap">
                                                                        <div class="d-flex align-items-center">
                                                                            <strong>Fetching Google Map link...</strong>
                                                                            <div class="spinner-border spinner-border-sm ml-1"
                                                                                role="status" aria-hidden="true"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group"
                                                                        style="padding: 0 10px; display: none;"
                                                                        id="fetchzillow">
                                                                        <div class="d-flex align-items-center">
                                                                            <strong>Fetching Zillow Link ...</strong>
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
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        <label>Google Maps Link</label>
                                                                        <a @if (!empty($property_infos->property_address)) href="{{ $property_infos->map_link }}" @endif
                                                                            id="google_map_link" target="_blank">
                                                                            <div class="input-group mb-2"
                                                                                id="google_map_link_text">
                                                                                {{ $property_infos->map_link }}
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        <label>Zillow Link</label>
                                                                        <a @if (!empty($property_infos->property_address)) href="{{ $property_infos->zillow_link }}" @endif
                                                                            id="zillow_link" target="_blank">
                                                                            <div class="input-group mb-2"
                                                                                id="zillow_link_text">
                                                                                {{ $property_infos->zillow_link }}
                                                                            </div>
                                                                        </a>
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
                                                                            <!-- Display the date as text -->
                                                                            <input class="form-control " type="date"
                                                                                placeholder="Origination Date"
                                                                                name="loan1_origination_date"
                                                                                table="property_finance_infos"
                                                                                onchange="updateValue(value,'loan1_origination_date','property_finance_infos')"
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
                                                                                placeholder="Original Balance"
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
                                                                        {{-- <label>Loan Balloon</label> --}}
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
                                                                        {{-- <label>Loan Monthly PITIH Payment</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Loan Monthly PITIH Payment"
                                                                                name="loan1_month_pitih_payment"
                                                                                table="property_finance_infos"
                                                                                value="{{ $property_finance_infos->loan1_month_pitih_payment == '' ? '' : $property_finance_infos->loan1_month_pitih_payment }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Loan Mortgage Company Name</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Loan Mortgage Company Name"
                                                                                name="loan1_mor_comp_name"
                                                                                table="property_finance_infos"
                                                                                value="{{ $property_finance_infos->loan1_mor_comp_name == '' ? '' : $property_finance_infos->loan1_mor_comp_name }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Loan Mortgage Company Phone</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Loan Mortgage Company Phone"
                                                                                name="loan1_mor_comp_phone"
                                                                                table="property_finance_infos"
                                                                                value="{{ $property_finance_infos->loan1_mor_comp_phone == '' ? '' : $property_finance_infos->loan1_mor_comp_phone }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Loan Account Number</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Loan Account Number"
                                                                                name="loan1_account_nmbr"
                                                                                table="property_finance_infos"
                                                                                value="{{ $property_finance_infos->loan1_account_nmbr == '' ? '' : $property_finance_infos->loan1_account_nmbr }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Loan Online Access Link</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Loan Online Access Link"
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
                                                                                placeholder="Loan Online Access User Name"
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
                                                                                placeholder="Loan Day of Month Due"
                                                                                name="loan1_due_day_month"
                                                                                table="property_finance_infos"
                                                                                value="{{ $property_finance_infos->loan1_due_day_month == '' ? '' : $property_finance_infos->loan1_due_day_month }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Does mortgage payment(s) include property taxes?</label> --}}
                                                                        <select class="custom-select"
                                                                            name="include_property_taxes"
                                                                            onchange="updateValue(value,'include_property_taxes','property_finance_infos')">
                                                                            <option value="">Include property taxes?
                                                                            </option>
                                                                            <option value="yes"
                                                                                @if (isset($property_finance_infos)) @if ($property_finance_infos->include_property_taxes == 'yes') selected @endif
                                                                                @endif>Yes</option>
                                                                            <option value="no"
                                                                                @if (isset($property_finance_infos)) @if ($property_finance_infos->include_property_taxes == 'no') selected @endif
                                                                                @endif>No</option>
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
                                                                            {{-- <input type="date" class="form-control"
                                                                                placeholder="Origination Date"
                                                                                name="loan2_origination_date"
                                                                                table="property_finance_infos"
                                                                                value="{{ $property_finance_infos->loan2_origination_date == '' ? '' : $property_finance_infos->loan2_origination_date }}"> --}}
                                                                            <!-- Display the date as text -->

                                                                            <input type="date" class="form-control"
                                                                                placeholder="Origination Date"
                                                                                name="loan2_origination_date"
                                                                                table="property_finance_infos"
                                                                                onchange="updateValue(value,'loan2_origination_date','property_finance_infos')"
                                                                                value="{{ $property_finance_infos->loan2_origination_date == '' ? '' : $property_finance_infos->loan2_origination_date }}">

                                                                            <!-- Hidden date input -->
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
                                                                                placeholder="Original Balance"
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
                                                                        {{-- <label>Loan Balloon</label> --}}
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
                                                                        {{-- <label>Loan Monthly PITIH Payment</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Loan Monthly PITIH Payment"
                                                                                name="loan2_month_pitih_payment"
                                                                                table="property_finance_infos"
                                                                                value="{{ $property_finance_infos->loan2_month_pitih_payment == '' ? '' : $property_finance_infos->loan2_month_pitih_payment }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Loan Mortgage Company Name</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Loan Mortgage Company Name"
                                                                                name="loan2_mor_comp_name"
                                                                                table="property_finance_infos"
                                                                                value="{{ $property_finance_infos->loan2_mor_comp_name == '' ? '' : $property_finance_infos->loan2_mor_comp_name }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Loan Mortgage Company Phone</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Loan Mortgage Company Phone"
                                                                                name="loan2_mor_comp_phone"
                                                                                table="property_finance_infos"
                                                                                value="{{ $property_finance_infos->loan2_mor_comp_phone == '' ? '' : $property_finance_infos->loan2_mor_comp_phone }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Loan Account Number</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Loan Account Number"
                                                                                name="loan2_account_nmbr"
                                                                                table="property_finance_infos"
                                                                                value="{{ $property_finance_infos->loan2_account_nmbr == '' ? '' : $property_finance_infos->loan2_account_nmbr }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Loan Online Access Link</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Loan Online Access Link"
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
                                                                                placeholder="Loan Online Access User Name"
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

                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Does mortgage payment(s) include property insurance?</label> --}}
                                                                        <select class="custom-select"
                                                                            name="include_property_insurance"
                                                                            onchange="updateValue(value,'include_property_insurance','property_finance_infos')">
                                                                            <option value="">Include property
                                                                                insurance?
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
                                                            <div class="row">
                                                                <div class="col-md-12">

                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Notes About Condition</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <textarea id="template_text" class="form-control" rows="1" placeholder="Financing Notes"
                                                                                table="property_finance_infos" name="financing_notes">{{ $property_finance_infos->financing_notes == '' ? '' : $property_finance_infos->financing_notes }}</textarea>
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
                                                                <div class="col-md-12">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Reason for Selling/Needs/Greeds</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <textarea id="template_text" class="form-control" rows="2" placeholder="Impact" name="impact"
                                                                                table="selling_motivations">{{ $selling_motivations->impact == '' ? '' : $selling_motivations->impact }}</textarea>
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
                                                                                name="final_price" table="negotiations"
                                                                                value="{{ $negotiations->final_price == '' ? '' : $negotiations->final_price }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Taking Loan 1 Subject 2</label> --}}
                                                                        <select class="custom-select"
                                                                            name="loan1_subject1" table="negotiations"
                                                                            onchange="updateValue(value,'loan1_subject1','negotiations')">
                                                                            <option value="">Loan 1 Subject 2?
                                                                            </option>
                                                                            <option value="Yes"
                                                                                @if (isset($negotiations)) @if ($negotiations->loan1_subject1 == 'Yes') selected @endif
                                                                                @endif>Yes</option>
                                                                            <option value="No"
                                                                                @if (isset($negotiations)) @if ($negotiations->loan1_subject1 == 'No') selected @endif
                                                                                @endif>No</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Taking Loan 2 Subject 2</label> --}}
                                                                        <select class="custom-select"
                                                                            name="loan2_subject2" table="negotiations"
                                                                            onchange="updateValue(value,'loan2_subject2','negotiations')">>
                                                                            <option value="">Loan 2 Subject 2?
                                                                            </option>
                                                                            <option value="Yes"
                                                                                @if (isset($negotiations)) @if ($negotiations->loan2_subject2 == 'Yes') selected @endif
                                                                                @endif>Yes</option>
                                                                            <option value="No"
                                                                                @if (isset($negotiations)) @if ($negotiations->loan2_subject2 == 'No') selected @endif
                                                                                @endif>No</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Owner Financing Amount</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Owner Financing Amount"
                                                                                name="finance_amount"
                                                                                table="negotiations"
                                                                                value="{{ $negotiations->finance_amount == '' ? '' : $negotiations->finance_amount }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Owner Financing Interest Rate</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Owner Financing Interest Rate"
                                                                                name="finance_interest_rate"
                                                                                table="negotiations"
                                                                                value="{{ $negotiations->finance_interest_rate == '' ? '' : $negotiations->finance_interest_rate }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Owner Financing Term</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Owner Financing Term"
                                                                                name="finance_term" table="negotiations"
                                                                                value="{{ $negotiations->finance_term == '' ? '' : $negotiations->finance_term }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Monthly Owner Financing Payment</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Monthly Owner Financing Payment"
                                                                                name="month_finance_payment"
                                                                                table="negotiations"
                                                                                value="{{ $negotiations->month_finance_payment == '' ? '' : $negotiations->month_finance_payment }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Owner Financing Balloon Payment Due (in Months)</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Owner Financing Balloon Payment Due (in Months)"
                                                                                name="baloon_due_payment"
                                                                                table="negotiations"
                                                                                value="{{ $negotiations->baloon_due_payment == '' ? '' : $negotiations->baloon_due_payment }}">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Profit Expected</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="number" class="form-control"
                                                                                placeholder="Profit Expected"
                                                                                name="expected_profit"
                                                                                table="negotiations"
                                                                                value="{{ $negotiations->expected_profit == '' ? '' : $negotiations->expected_profit }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Profit Collected</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="number" class="form-control"
                                                                                placeholder="Profit Collected"
                                                                                name="actual_profit"
                                                                                table="negotiations"
                                                                                value="{{ $negotiations->actual_profit == '' ? '' : $negotiations->actual_profit }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        <div class="input-group mb-2">
                                                                            <!-- Display the date as text -->
                                                                            <input class="form-control"
                                                                                placeholder="Closing Date"
                                                                                name="closing_date" table="negotiations"
                                                                                type="date"
                                                                                onchange="updateValue(value,'closing_date','negotiations')"
                                                                                value="{{ $negotiations->closing_date == '' ? '' : $negotiations->closing_date }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Monthly Passive Income</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Monthly Passive Income"
                                                                                name="monthly_passive_income"
                                                                                table="negotiations"
                                                                                value="{{ $negotiations->monthly_passive_income == '' ? '' : $negotiations->monthly_passive_income }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Monthly Passive Income</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Past Due Amount of Mortgage/Taxes/HOA"
                                                                                name="past_due_mortage"
                                                                                table="negotiations"
                                                                                value="{{ $negotiations->past_due_mortage == '' ? '' : $negotiations->past_due_mortage }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Past Due Amount of Mortgage/Taxes/HOA</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <textarea id="template_text" class="form-control" rows="2" placeholder="Negotiations Notes"
                                                                                name="negotiations_notes" table="negotiations">{{ $negotiations->negotiations_notes == '' ? '' : $negotiations->negotiations_notes }}</textarea>
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
                                                                                name="selling_problem" table="objections">{{ $objections->selling_problem == '' ? '' : $objections->selling_problem }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Do you have someone that’s helping you make the decision to sell this house?</label> --}}
                                                                        <select class="custom-select" name="solving_now"
                                                                            onchange="updateValue(value,'decision_helper','objections')">
                                                                            <option value="">Someone helping them to
                                                                                make decision?
                                                                                this house?</option>
                                                                            <option value="yes"
                                                                                @if (isset($objections)) @if ($objections->decision_helper == 'yes') selected @endif
                                                                                @endif>Yes</option>
                                                                            <option value="no"
                                                                                @if (isset($objections)) @if ($objections->decision_helper == 'no') selected @endif
                                                                                @endif>No</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>If so, what’s their name?</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="If so, what’s their name?"
                                                                                name="helper_name" table="objections"
                                                                                value="{{ $objections->helper_name == '' ? '' : $objections->helper_name }}">
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
                                                                                name="commitment_move_forward"
                                                                                onchange="updateValue(value,'commitment_move_forward','commitments')">
                                                                                <option value="">Commitment to move
                                                                                    forward?</option>
                                                                                <option value="yes"
                                                                                    @if (isset($commitments)) @if ($commitments->commitment_move_forward == 'yes') selected @endif
                                                                                    @endif>Yes</option>
                                                                                <option value="no"
                                                                                    @if (isset($commitments)) @if ($commitments->commitment_move_forward == 'no') selected @endif
                                                                                    @endif>No</option>
                                                                            </select>
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
                                                                <div class="col-md-12">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Get email</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input style="margin-right:5px"
                                                                                type="checkbox" name="get_email"
                                                                                table="stuffs"
                                                                                onchange="updateValue(this.checked ? '1' : null, 'get_email', 'stuffs')"
                                                                                value="{{ $stuffs->get_email }}"
                                                                                {{ $stuffs->get_email == 1 ? 'checked' : '' }}>
                                                                            Get
                                                                            email
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Get all names on title</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input style="margin-right:5px"
                                                                                type="checkbox" name="all_names"
                                                                                onchange="updateValue(this.checked ? '1' : null, 'all_names', 'stuffs')"
                                                                                value="{{ $stuffs->all_names }}"
                                                                                {{ $stuffs->all_names == 1 ? 'checked' : '' }}>
                                                                            Get
                                                                            all names on title
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        <div class="input-group mb-2">
                                                                            <label
                                                                                style="display: flex; align-items: center;">
                                                                                <input style="margin-right: 5px;"
                                                                                    type="checkbox" id="recent_pics"
                                                                                    name="recent_pics"
                                                                                    onchange="updateValue(this.checked ? '1' : null, 'recent_pics', 'stuffs')"
                                                                                    value="{{ $stuffs->recent_pics }}"
                                                                                    {{ $stuffs->recent_pics == 1 ? 'checked' : '' }}>
                                                                                If no good pictures are online, ask them for
                                                                                recent pictures
                                                                            </label>
                                                                        </div>
                                                                    </div>


                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Explain next steps: Inspection, search, 10 minute closing process</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input style="margin-right:5px"
                                                                                type="checkbox" name="next_steps"
                                                                                onchange="updateValue(this.checked ? '1' : null, 'next_steps', 'stuffs')"
                                                                                value="{{ $stuffs->next_steps }}"
                                                                                {{ $stuffs->next_steps == 1 ? 'checked' : '' }}>
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
                                                                                name="property_listed_agent"
                                                                                onchange="updateValue(value,'property_listed_agent','agent_infos')">
                                                                                <option value="">Property currently
                                                                                    listed with an agent? </option>
                                                                                <option value="yes"
                                                                                    @if (isset($agent_infos)) @if ($agent_infos->property_listed_agent == 'yes') selected @endif
                                                                                    @endif>Yes</option>
                                                                                <option value="no"
                                                                                    @if (isset($agent_infos)) @if ($agent_infos->property_listed_agent == 'no') selected @endif
                                                                                    @endif>No</option>
                                                                                <option value="no"
                                                                                    @if (isset($agent_infos)) @if ($agent_infos->property_listed_agent == 'expire') selected @endif
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
                                                                                name="agent_involvent"
                                                                                onchange="updateValue(value,'agent_involvent','agent_infos')">
                                                                                <option value="">Does agent need to
                                                                                    be involved? </option>
                                                                                <option value="yes"
                                                                                    @if (isset($agent_infos)) @if ($agent_infos->agent_involvent == 'yes') selected @endif
                                                                                    @endif>Yes</option>
                                                                                <option value="no"
                                                                                    @if (isset($agent_infos)) @if ($agent_infos->agent_involvent == 'no') selected @endif
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
                                                                                name="agent_name" table="agent_infos"
                                                                                value="{{ $agent_infos->agent_name }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Agent Office Name</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Agent Office Name"
                                                                                name="agent_office_name"
                                                                                table="agent_infos"
                                                                                value="{{ $agent_infos->agent_office_name }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Agent Phone</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Agent Phone"
                                                                                name="agent_phone" table="agent_infos"
                                                                                value="{{ $agent_infos->agent_phone }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Agent Email</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Agent Email"
                                                                                name="agent_email" table="agent_infos"
                                                                                value="{{ $agent_infos->agent_email }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Agent Email</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Days on Market"
                                                                                name="days_on_market"
                                                                                table="agent_infos"
                                                                                value="{{ $agent_infos->days_on_market }}">
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
                                                                                name="followup_reminder"
                                                                                onchange="updateValue(value,'followup_reminder','followup_sequences')">
                                                                                <option value="">Schedule Follow up
                                                                                    Reminder </option>
                                                                                <option value="1"
                                                                                    @if (isset($followup_sequences)) @if ($followup_sequences->followup_reminder == '1') selected @endif
                                                                                    @endif>1 Day
                                                                                </option>
                                                                                <option value="2"
                                                                                    @if (isset($followup_sequences)) @if ($followup_sequences->followup_reminder == '2') selected @endif
                                                                                    @endif>2 Days
                                                                                </option>
                                                                                <option value="3"
                                                                                    @if (isset($followup_sequences)) @if ($followup_sequences->followup_reminder == '3') selected @endif
                                                                                    @endif>4 Days
                                                                                </option>
                                                                                <option value="4"
                                                                                    @if (isset($followup_sequences)) @if ($followup_sequences->followup_reminder == '4') selected @endif
                                                                                    @endif>1 Week
                                                                                </option>

                                                                            </select>
                                                                        </div>
                                                                        <button type="submit"
                                                                            onclick="updateValue('Yes','stop_followup','followup_sequences')"
                                                                            class="btn btn-primary button-item mt-2">Stop Followup</button>
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
                                                            <div class="row">
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
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        <a href="{{ route('admin.zoom.index') }}"
                                                                            type="button"
                                                                            class="btn btn-primary button-item">Zoom
                                                                            Meeting</a>

                                                                    </div>
                                                                </div>
                                                                <hr>
                                                                <div class="col-md-12">

                                                                    <form id="messageForm" class="form-group"
                                                                        style="padding: 0 10px;">
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">
                                                                            {{-- <label>Select Message Type:</label> --}}
                                                                            <select id="messageType"
                                                                                onchange="showMessageTypeData()"
                                                                                class="custom-select">
                                                                                <option value="">Select Message Type
                                                                                </option>
                                                                                <option value="sms">SMS</option>
                                                                                <option value="email">Email</option>
                                                                                <option value="mms">MMS</option>
                                                                                <option value="rvm">RVM</option>
                                                                            </select>
                                                                        </div>

                                                                        <div id="smsData"
                                                                            style="display: none; padding: 0 10px;">
                                                                            <h3>SMS Data</h3>
                                                                            <div class="row">
                                                                                <div class="form-group"
                                                                                    style=" display: none; padding: 0 10px;">
                                                                                    <label>Media File (<small
                                                                                            class="text-danger">Disregard
                                                                                            if not sending
                                                                                            MMS</small>)</label>
                                                                                    {{-- <input type="file" class="form-control-file" name="media_file{{ $count }}"> --}}
                                                                                </div>
                                                                                <input type="hidden"
                                                                                    class="form-control"
                                                                                    placeholder="Hours" value=""
                                                                                    name="mediaUrl[]">
                                                                                <input type="hidden"
                                                                                    class="form-control"
                                                                                    placeholder="Subject" value=""
                                                                                    name="subject[]">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group ">
                                                                                        <label>Message</label>
                                                                                        <textarea id="template_text" class="form-control" rows="10" name="body[]"></textarea>
                                                                                        <div id='count'
                                                                                            class="float-lg-right"></div>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <small class="text-danger"><b>Use
                                                                                                {name} {street} {city}
                                                                                                {state} {zip} to substitute
                                                                                                the respective
                                                                                                fields</b></small>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>Select Numbers to Send SMS:</label>
                                                                                <div class="checkbox-list"
                                                                                    id="checkbox-list">

                                                                                    <!-- Add more numbers here -->
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div id="emailData"
                                                                            style="display: none; padding: 0 10px;">
                                                                            <input type="hidden" class="form-control"
                                                                                placeholder="Hours" value=""
                                                                                name="mediaUrl[]">
                                                                            <div class="form-group"
                                                                                style=" display: none;">
                                                                                {{-- <label>Media File (<small class="text-danger">Disregard if not sending MMS</small>)</label> --}}
                                                                                {{-- <input type="file" class="form-control-file" name="media_file{{ $count }}"> --}}
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group ">
                                                                                        <label>Subject</label>
                                                                                        <input type="text"
                                                                                            class="form-control"
                                                                                            placeholder="Subject"
                                                                                            value=""
                                                                                            name="subject[]">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group ">
                                                                                        <label>Message</label>
                                                                                        <textarea id="template_text" class="form-control summernote-usage" rows="10" name="body[]"></textarea>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <small class="text-danger"><b>Use
                                                                                                {name} {street} {city}
                                                                                                {state} {zip} to substitute
                                                                                                the respective
                                                                                                fields</b></small>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>Select eamil to Send mail:</label>
                                                                                <div class="checkbox-list2"
                                                                                    id="checkbox-list2">

                                                                                    <!-- Add more numbers here -->
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div id="mmsData"
                                                                            style="display: none; padding: 0 10px;">
                                                                            <h3>MMS Data</h3>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <label>Media File (<small
                                                                                                class="text-danger">Disregard
                                                                                                if not sending
                                                                                                MMS</small>)</label>
                                                                                        <input type="file"
                                                                                            class="form-control-file"
                                                                                            name="media_file">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group ">
                                                                                        <label>Message</label>
                                                                                        <textarea id="template_text" class="form-control" rows="10" name="body[]"></textarea>
                                                                                        <div id='count'
                                                                                            class="float-lg-right"></div>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <small class="text-danger"><b>Use
                                                                                                {name} {street} {city}
                                                                                                {state} {zip} to substitute
                                                                                                the respective
                                                                                                fields</b></small>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>Select Numbers to Send MMS:</label>
                                                                                <div class="checkbox-list3"
                                                                                    id="checkbox-list3">

                                                                                    <!-- Add more numbers here -->
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div id="rvmData"
                                                                            style="display: none; padding: 0 10px;">
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group mt-3">
                                                                                        <label>Rvm Files</label>
                                                                                        <select class="custom-select"
                                                                                            name="mediaUrl[]" required>
                                                                                            <option value="">Rvm
                                                                                                File</option>
                                                                                            @if (count($files) > 0)
                                                                                                @foreach ($files as $file)
                                                                                                    <option
                                                                                                        value="{{ $file->mediaUrl }}">
                                                                                                        {{ $file->name }}
                                                                                                    </option>
                                                                                                @endforeach
                                                                                            @endif

                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>Select Numbers to Send RVM:</label>
                                                                                <div class="checkbox-list4"
                                                                                    id="checkbox-list4">

                                                                                    <!-- Add more numbers here -->
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group"
                                                                            style="padding: 0 10px;">

                                                                            <button type="button"
                                                                                class="btn btn-primary button-item">Send
                                                                                Messages</button>
                                                                        </div>
                                                                    </form>
                                                                    {{-- <div class="card-body"> <label
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
                                                                                        <div class="input-group mb-2">
                                                                                            <input type="text"
                                                                                                class="form-control"
                                                                                                placeholder="Subject"
                                                                                                name="subject"
                                                                                                table="emails">
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
                                                                                            name="send_to"
                                                                                            table="emails">

                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                            <div class="form-group ">
                                                                                <label>Message</label>
                                                                                <textarea id="template_text" class="form-control summernote-usage" rows="10" name="message"
                                                                                    table="emails"></textarea>
                                                                                <div id='count'
                                                                                    class="float-lg-right">
                                                                                </div>
                                                                                <button type="submit"
                                                                                    class="btn btn-primary button-item mt-2">Send
                                                                                    Email</button>
                                                                            </div>
                                                                        </form>

                                                                    </div> --}}
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
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group" style="padding: 0 10px;">
                                                                    <label for="file_type">Select file type to
                                                                        upload</label>
                                                                    <select class="custom-select" name="lead_status"
                                                                        onchange="updateAcceptedFiles()"
                                                                        table="lead_info" id="file_type">
                                                                        <option value="Photo" selected>Photo</option>
                                                                        <option value="Buy Side / Purchase Agreement">Buy
                                                                            Side / Purchase Agreement</option>
                                                                        <option value="Buy Side / Closing Paperwork">Buy
                                                                            Side / Closing Paperwork</option>
                                                                        <option value="Buy Side / Closing Paperwork">Sell
                                                                            Side / Purchase Agreement</option>
                                                                        <option value="Sell Side / Closing Paperwork">Sell
                                                                            Side / Closing Paperwork</option>
                                                                        <option value="Lender Paperwork">Lender Paperwork
                                                                        </option>
                                                                        <option value="Rental Paperwork">Rental Paperwork
                                                                        </option>
                                                                        <option value="Insurance Paperwork">Insurance
                                                                            Paperwork</option>
                                                                        <option value="Inspection Paperwork">Inspection
                                                                            Paperwork</option>
                                                                        <option value="Miscellaneous">Miscellaneous
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group" style="padding: 0 10px;"
                                                                    id="driveUpload">


                                                                    <div class="form-group">
                                                                        <label for="file">Select File to
                                                                            upload</label>
                                                                        <form action="/admin/google-drive-login"
                                                                            class="dropzone" name="file"
                                                                            id="dropzone" method="POST"
                                                                            enctype="multipart/form-data">
                                                                            @csrf
                                                                            <div class="fallback">
                                                                            </div>
                                                                            <input type="hidden" name="hiddenFile"
                                                                                id="hidden-file">
                                                                            <input hidden name="contact_id"
                                                                                value="{{ $contact->id }}">
                                                                        </form>
                                                                    </div>
                                                                    <button type="button" id="custom-upload-button"
                                                                        class="btn btn-primary button-item">Upload</button>
                                                                    <button type="button"
                                                                        class="btn btn-primary button-item"
                                                                        data-toggle="modal"
                                                                        data-target="#fileManagerModal">
                                                                        Open File Manager
                                                                    </button>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <!-- Button to open the modal -->


                                                        <!-- Single modal for the file manager -->
                                                        <!-- Main File Manager Modal -->
                                                        <div class="modal fade" id="fileManagerModal" tabindex="-1"
                                                            role="dialog" aria-labelledby="fileManagerModalLabel"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-body">
                                                                        <div
                                                                            class="container flex-grow-1 light-style container-p-y">
                                                                            <div
                                                                                class="container-m-nx container-m-ny bg-lightest mb-3">
                                                                                <ol
                                                                                    class="breadcrumb text-big container-p-x py-3 m-0">
                                                                                    <li class="breadcrumb-item">
                                                                                        <a
                                                                                            href="javascript:void(0)">REIFuze</a>
                                                                                    </li>
                                                                                    {{-- <li class="breadcrumb-item">
                                                                                        <a href="javascript:void(0)">projects</a>
                                                                                    </li>
                                                                                    <li class="breadcrumb-item active">site</li> --}}
                                                                                </ol>

                                                                                <hr class="m-0" />


                                                                            </div>

                                                                            <div
                                                                                class="file-manager-container file-manager-col-view">
                                                                                <div class="file-manager-row-header">
                                                                                    <div class="file-item-name pb-2">
                                                                                        Filename</div>
                                                                                    <div class="file-item-changed pb-2">
                                                                                        Changed</div>
                                                                                </div>

                                                                                {{-- <div class="file-item">
                                                                                    <div class="file-item-icon file-item-level-up fas fa-level-up-alt text-secondary"></div>
                                                                                    <a href="javascript:void(0)" class="file-item-name">
                                                                                        ..
                                                                                    </a>
                                                                                </div> --}}

                                                                                <div onclick="fetchFiles('Photo')"
                                                                                    class="file-item">
                                                                                    <div
                                                                                        class="file-item-select-bg bg-primary">
                                                                                    </div>
                                                                                    <div
                                                                                        class="file-item-icon far fa-folder text-secondary">
                                                                                    </div>
                                                                                    <a class="file-item-name">
                                                                                        Photos
                                                                                    </a>
                                                                                    <div class="file-item-changed">
                                                                                        02/13/2018</div>
                                                                                    <div
                                                                                        class="file-item-actions btn-group">
                                                                                        <button type="button"
                                                                                            class="btn btn-default btn-sm rounded-pill icon-btn borderless md-btn-flat hide-arrow dropdown-toggle"
                                                                                            data-toggle="dropdown"><i
                                                                                                class="ion ion-ios-more"></i></button>
                                                                                        <div
                                                                                            class="dropdown-menu dropdown-menu-right">
                                                                                            <a class="dropdown-item"
                                                                                                href="javascript:void(0)">Rename</a>
                                                                                            <a class="dropdown-item"
                                                                                                href="javascript:void(0)">Move</a>
                                                                                            <a class="dropdown-item"
                                                                                                href="javascript:void(0)">Copy</a>
                                                                                            <a class="dropdown-item"
                                                                                                href="javascript:void(0)">Remove</a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div onclick="fetchFiles('Rental Paperwork')"
                                                                                    class="file-item">
                                                                                    <div
                                                                                        class="file-item-select-bg bg-primary">
                                                                                    </div>
                                                                                    <div
                                                                                        class="file-item-icon far fa-folder text-secondary">
                                                                                    </div>
                                                                                    <a href="javascript:void(0)"
                                                                                        class="file-item-name">
                                                                                        Rental Paperwork
                                                                                    </a>
                                                                                </div>
                                                                                <div onclick="fetchFiles('Lender Paperwork')"
                                                                                    class="file-item">
                                                                                    <div
                                                                                        class="file-item-select-bg bg-primary">
                                                                                    </div>
                                                                                    <div
                                                                                        class="file-item-icon far fa-folder text-secondary">
                                                                                    </div>
                                                                                    <a href="javascript:void(0)"
                                                                                        class="file-item-name">
                                                                                        Lender Paperwork
                                                                                    </a>
                                                                                </div>
                                                                                <div onclick="fetchFiles('Insurance Paperwork')"
                                                                                    class="file-item">
                                                                                    <div
                                                                                        class="file-item-select-bg bg-primary">
                                                                                    </div>
                                                                                    <div
                                                                                        class="file-item-icon far fa-folder text-secondary">
                                                                                    </div>
                                                                                    <a href="javascript:void(0)"
                                                                                        class="file-item-name">
                                                                                        Insurance Paperwork
                                                                                    </a>
                                                                                </div>
                                                                                <div onclick="fetchFiles('Inspection Paperwork')"
                                                                                    class="file-item">
                                                                                    <div
                                                                                        class="file-item-select-bg bg-primary">
                                                                                    </div>
                                                                                    <div
                                                                                        class="file-item-icon far fa-folder text-secondary">
                                                                                    </div>
                                                                                    <a href="javascript:void(0)"
                                                                                        class="file-item-name">
                                                                                        Inspection Paperwork
                                                                                    </a>
                                                                                </div>
                                                                                <div onclick="fetchFiles('Miscellaneous')"
                                                                                    class="file-item">
                                                                                    <div
                                                                                        class="file-item-select-bg bg-primary">
                                                                                    </div>
                                                                                    <div
                                                                                        class="file-item-icon far fa-folder text-secondary">
                                                                                    </div>
                                                                                    <a href="javascript:void(0)"
                                                                                        class="file-item-name">
                                                                                        Miscellaneous
                                                                                    </a>
                                                                                </div>
                                                                                <div onclick="fetchFiles('Buy Side / Purchase Agreement')"
                                                                                    class="file-item">
                                                                                    <div
                                                                                        class="file-item-select-bg bg-primary">
                                                                                    </div>
                                                                                    <div
                                                                                        class="file-item-icon far fa-folder text-secondary">
                                                                                    </div>
                                                                                    <a href="javascript:void(0)"
                                                                                        class="file-item-name">
                                                                                        Buy Side / Purchase Agreement
                                                                                    </a>
                                                                                </div>
                                                                                <div onclick="fetchFiles('Buy Side / Closing Paperwork')"
                                                                                    class="file-item">
                                                                                    <div
                                                                                        class="file-item-select-bg bg-primary">
                                                                                    </div>
                                                                                    <div
                                                                                        class="file-item-icon far fa-folder text-secondary">
                                                                                    </div>
                                                                                    <a href="javascript:void(0)"
                                                                                        class="file-item-name">
                                                                                        Buy Side / Closing Paperwork
                                                                                    </a>
                                                                                </div>
                                                                                <div onclick="fetchFiles('Sell Side / Purchase Agreement')"
                                                                                    class="file-item">
                                                                                    <div
                                                                                        class="file-item-select-bg bg-primary">
                                                                                    </div>
                                                                                    <div
                                                                                        class="file-item-icon far fa-folder text-secondary">
                                                                                    </div>
                                                                                    <a href="javascript:void(0)"
                                                                                        class="file-item-name">
                                                                                        Sell Side / Purchase Agreement
                                                                                    </a>
                                                                                </div>
                                                                                <div onclick="fetchFiles('Sell Side / Closing Paperwork')"
                                                                                    class="file-item">
                                                                                    <div
                                                                                        class="file-item-select-bg bg-primary">
                                                                                    </div>
                                                                                    <div
                                                                                        class="file-item-icon far fa-folder text-secondary">
                                                                                    </div>
                                                                                    <a href="javascript:void(0)"
                                                                                        onclick=""
                                                                                        class="file-item-name">
                                                                                        Sell Side / Closing Paperwork
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal fade" id="filesModal" tabindex="-1"
                                                            role="dialog" aria-labelledby="filesModalLabel"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-body">
                                                                        <div
                                                                            class="container flex-grow-1 light-style container-p-y">
                                                                            <div
                                                                                class="container-m-nx container-m-ny bg-lightest mb-3">
                                                                                <ol
                                                                                    class="breadcrumb text-big container-p-x py-3 m-0">
                                                                                    <li class="breadcrumb-item">
                                                                                        <a
                                                                                            href="javascript:void(0)">REIFuze</a>
                                                                                    </li>
                                                                                    {{-- <li class="breadcrumb-item">
                                                                                        <a href="javascript:void(0)">projects</a>
                                                                                    </li>
                                                                                    <li class="breadcrumb-item active">site</li> --}}
                                                                                </ol>

                                                                                <hr class="m-0" />


                                                                            </div>

                                                                            <div
                                                                                class="file-manager-container file-manager-col-view">
                                                                                <div class="file-item">
                                                                                    <div
                                                                                        class="file-item-icon file-item-level-up fas fa-level-up-alt text-secondary">
                                                                                    </div>
                                                                                    <a href="javascript:void(0)"
                                                                                        class="file-item-name">
                                                                                        ..
                                                                                    </a>
                                                                                </div>
                                                                                {{-- <div class="file-item">
                                                                                    <div class="file-item-select-bg bg-primary"></div>
                                                                                    <div class="file-item-icon far fa-file text-secondary"></div>
                                                                                    <a href="javascript:void(0)" class="file-item-name">
                                                                                        MAKEFILE
                                                                                    </a>
                                                                                    <div class="file-item-actions btn-group">
                                                                                        <button type="button" class="btn btn-default btn-sm rounded-pill icon-btn borderless md-btn-flat hide-arrow dropdown-toggle" data-toggle="dropdown"><i class="ion ion-ios-more"></i></button>
                                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                                        <a class="dropdown-item" href="javascript:void(0)">Delete</a>
                                                                                    </div>
                                                                                    </div>
                                                                                </div> --}}
                                                                            </div>
                                                                        </div>
                                                                    </div>
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
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Title  Company Name</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Title Company Name"
                                                                                name="company_name"
                                                                                table="title_company"
                                                                                value="{{ $title_company->company_name }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Title Company Contact Name</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Title Company Contact Name"
                                                                                name="contact_name"
                                                                                table="title_company"
                                                                                value="{{ $title_company->contact_name }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Title Company Phone</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Title Company Phone"
                                                                                name="phone" table="title_company"
                                                                                value="{{ $title_company->phone }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Title Company Email</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Title Company Email"
                                                                                name="email" table="title_company"
                                                                                value="{{ $title_company->email }}">

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Title Company Email</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Buying/Selling Entity Details"
                                                                                table="title_company"
                                                                                name="buy_sell_entity_detail"
                                                                                value="{{ $title_company->buy_sell_entity_detail }}">
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
                                                                    $file->is_sub
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
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Insurance Company Name</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Insurance Company Name"
                                                                                name="insurance_company_name"
                                                                                table="insurance_company"
                                                                                value="{{ $insurance_company->insurance_company_name }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Insurance Company Phone</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Insurance Company Phone"
                                                                                name="insurance_company_phone"
                                                                                table="insurance_company"
                                                                                value="{{ $insurance_company->insurance_company_phone }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Insurance Company Agent</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Insurance Company Agent"
                                                                                name="insurance_company_agent"
                                                                                table="insurance_company"
                                                                                value="{{ $insurance_company->insurance_company_agent }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Insurance Agent Phone</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Insurance Agent Phone"
                                                                                name="insurance_company_agent_phone"
                                                                                table="insurance_company"
                                                                                value="{{ $insurance_company->insurance_company_agent_phone }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Insurance Account Number</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Insurance Account Number"
                                                                                name="insurance_account_number"
                                                                                table="insurance_company"
                                                                                value="{{ $insurance_company->insurance_account_number }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Insurance Online Access Link</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Insurance Online Access Link"
                                                                                name="insurance_online_link"
                                                                                table="insurance_company"
                                                                                value="{{ $insurance_company->insurance_online_link }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Insurance Online Access User Name</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Insurance Online Access User Name"
                                                                                name="insurance_online_user"
                                                                                table="insurance_company"
                                                                                value="{{ $insurance_company->insurance_online_user }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Insurance Online Access Password</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Insurance Online Access Password"
                                                                                name="insurance_online_password"
                                                                                table="insurance_company"
                                                                                value="{{ $insurance_company->insurance_online_password }}">
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
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>HOA Name</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="HOA Name" name="hoa_name"
                                                                                table="hoa_info"
                                                                                value="{{ $hoa_info->hoa_name }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Contact Name</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Contact Name"
                                                                                name="hoa_contact_name" table="hoa_info"
                                                                                value="{{ $hoa_info->hoa_contact_name }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>HOA Phone Number</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="HOA Phone Number"
                                                                                name="hoa_phone" table="hoa_info"
                                                                                value="{{ $hoa_info->hoa_phone }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>HOA Email</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="HOA Email" name="hoa_email"
                                                                                table="hoa_info"
                                                                                value="{{ $hoa_info->hoa_email }}">
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
                                                    @elseif($section->id == '20')
                                                        <div class="col-md-12" id="{{ $section->id }}"
                                                            style="padding:0px;">
                                                            <div class="row" id="FUTURE">
                                                                <div class="col-md-12">
                                                                    <div class="form-group lead-heading">
                                                                        <label>{{ $section->name }}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group"
                                                                        style="padding: 0 10px;border-bottom: 1px solid #eee;">
                                                                        <label>Seller 1</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">

                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Seller 1 Forwarding Address"
                                                                                name="seller1_address"
                                                                                table="future_seller_infos"
                                                                                value="{{ $future_seller_infos->seller1_address }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Seller 1 Forwarding City</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Seller 1 Forwarding City"
                                                                                name="seller1_city"
                                                                                table="future_seller_infos"
                                                                                value="{{ $future_seller_infos->seller1_city }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Seller 1 Forwarding State</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Seller 1 Forwarding State"
                                                                                name="seller1_state"
                                                                                table="future_seller_infos"
                                                                                value="{{ $future_seller_infos->seller1_state }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Seller 1 Forwarding Zip</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Seller 1 Forwarding Zip"
                                                                                name="seller1_zip"
                                                                                table="future_seller_infos"
                                                                                value="{{ $future_seller_infos->seller1_zip }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Seller 1 Nearest Relative Address</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Seller 1 Nearest Relative Address"
                                                                                name="seller1_nearest_address"
                                                                                table="future_seller_infos"
                                                                                value="{{ $future_seller_infos->seller1_nearest_address }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Seller 1 Nearest Relative City</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Seller 1 Nearest Relative City"
                                                                                name="seller1_nearest_city"
                                                                                table="future_seller_infos"
                                                                                value="{{ $future_seller_infos->seller1_nearest_city }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Seller 1 Nearest Relative State</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Seller 1 Nearest Relative State"
                                                                                name="seller1_nearest_state"
                                                                                table="future_seller_infos"
                                                                                value="{{ $future_seller_infos->seller1_nearest_state }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Seller 1 Nearest Relative Zip</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Seller 1 Nearest Relative Zip"
                                                                                name="seller1_nearest_zip"
                                                                                table="future_seller_infos"
                                                                                value="{{ $future_seller_infos->seller1_nearest_zip }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Seller 1 Nearest Relative Phone</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Seller 1 Nearest Relative Phone"
                                                                                name="seller1_nearest_phone"
                                                                                table="future_seller_infos"
                                                                                value="{{ $future_seller_infos->seller1_nearest_phone }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group"
                                                                        style="padding: 0 10px;border-bottom: 1px solid #eee;">
                                                                        <label>Seller 2</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Seller 2 Forwarding Address</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Seller 2 Forwarding Address"
                                                                                name="seller2_address"
                                                                                table="future_seller_infos"
                                                                                value="{{ $future_seller_infos->seller2_address }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Seller 2 Forwarding City</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Seller 2 Forwarding City"
                                                                                name="seller2_city"
                                                                                table="future_seller_infos"
                                                                                value="{{ $future_seller_infos->seller2_city }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Seller 2 Forwarding State</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Seller 2 Forwarding State"
                                                                                name="seller2_state"
                                                                                table="future_seller_infos"
                                                                                value="{{ $future_seller_infos->seller2_state }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Seller 2 Forwarding Zip</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Seller 2 Forwarding Zip"
                                                                                name="seller2_zip"
                                                                                table="future_seller_infos"
                                                                                value="{{ $future_seller_infos->seller2_zip }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Seller 2 Nearest Relative Address</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Seller 2 Nearest Relative Address"
                                                                                name="seller2_nearest_address"
                                                                                table="future_seller_infos"
                                                                                value="{{ $future_seller_infos->seller2_nearest_address }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Seller 2 Nearest Relative City</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Seller 2 Nearest Relative City"
                                                                                name="seller2_nearest_city"
                                                                                table="future_seller_infos"
                                                                                value="{{ $future_seller_infos->seller2_nearest_city }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Seller 2 Nearest Relative State</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Seller 2 Nearest Relative State"
                                                                                name="seller2_nearest_state"
                                                                                table="future_seller_infos"
                                                                                value="{{ $future_seller_infos->seller2_nearest_state }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Seller 2 Nearest Relative Zip</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Seller 2 Nearest Relative Zip"
                                                                                name="seller2_nearest_zip"
                                                                                table="future_seller_infos"
                                                                                value="{{ $future_seller_infos->seller2_nearest_zip }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Seller 2 Nearest Relative Phone</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Seller 2 Nearest Relative Phone"
                                                                                name="seller2_nearest_phone"
                                                                                table="future_seller_infos"
                                                                                value="{{ $future_seller_infos->seller2_nearest_phone }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group"
                                                                        style="padding: 0 10px;border-bottom: 1px solid #eee;">
                                                                        <label>Seller 3</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Seller 3 Forwarding Address</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Seller 3 Forwarding Address"
                                                                                name="seller3_address"
                                                                                table="future_seller_infos"
                                                                                value="{{ $future_seller_infos->seller3_address }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Seller 3 Forwarding City</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Seller 3 Forwarding City"
                                                                                name="seller3_city"
                                                                                table="future_seller_infos"
                                                                                value="{{ $future_seller_infos->seller3_city }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Seller 3 Forwarding State</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Seller 3 Forwarding State"
                                                                                name="seller3_state"
                                                                                table="future_seller_infos"
                                                                                value="{{ $future_seller_infos->seller3_state }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Seller 3 Forwarding Zip</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Seller 3 Forwarding Zip"
                                                                                name="seller3_zip"
                                                                                table="future_seller_infos"
                                                                                value="{{ $future_seller_infos->seller3_zip }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Seller 3 Nearest Relative Address</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Seller 3 Nearest Relative Address"
                                                                                name="seller3_nearest_address"
                                                                                table="future_seller_infos"
                                                                                value="{{ $future_seller_infos->seller3_nearest_address }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Seller 3 Nearest Relative City</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Seller 3 Nearest Relative City"
                                                                                name="seller3_nearest_city"
                                                                                table="future_seller_infos"
                                                                                value="{{ $future_seller_infos->seller3_nearest_city }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Seller 3 Nearest Relative State</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Seller 3 Nearest Relative State"
                                                                                name="seller3_nearest_state"
                                                                                table="future_seller_infos"
                                                                                value="{{ $future_seller_infos->seller3_nearest_state }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Seller 3 Nearest Relative Zip</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Seller 3 Nearest Relative Zip"
                                                                                name="seller3_nearest_zip"
                                                                                table="future_seller_infos"
                                                                                value="{{ $future_seller_infos->seller3_nearest_zip }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        {{-- <label>Seller 3 Nearest Relative Phone</label> --}}
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Seller 3 Nearest Relative Phone"
                                                                                name="seller3_nearest_phone"
                                                                                table="future_seller_infos"
                                                                                value="{{ $future_seller_infos->seller3_nearest_phone }}">
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
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group"
                                                                        style="padding: 0 10px;border-bottom: 1px solid #eee;">
                                                                        <label>Electricity</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Company Name"
                                                                                name="electricity_company_name"
                                                                                table="utility_deparments"
                                                                                @if (isset($utility_deparments)) value="{{ $utility_deparments->electricity_company_name }}" @endif>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Phone"
                                                                                name="electricity_phone"
                                                                                table="utility_deparments"
                                                                                @if (isset($utility_deparments)) value="{{ $utility_deparments->electricity_phone }}" @endif>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Login Link"
                                                                                name="electricity_link"
                                                                                table="utility_deparments"
                                                                                @if (isset($utility_deparments)) value="{{ $utility_deparments->electricity_link }}" @endif>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        <div class="input-group mb-2">
                                                                            <input type="text"
                                                                                class="form-control"placeholder="User Name"
                                                                                name="electricity_user_name"
                                                                                table="utility_deparments"
                                                                                @if (isset($utility_deparments)) value="{{ $utility_deparments->electricity_user_name }}" @endif>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Password"
                                                                                name="electricity_password"
                                                                                table="utility_deparments"
                                                                                @if (isset($utility_deparments)) value="{{ $utility_deparments->electricity_password }}" @endif>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        <div class="input-group mb-2 mt-3">
                                                                            <input style="margin-right:5px"type="checkbox"
                                                                                name="electricity_service_active"
                                                                                table="utility_deparments"
                                                                                onchange="updateValue(this.checked ? '1' : null, 'electricity_service_active', 'utility_deparments')"
                                                                                {{ isset($utility_deparments) && $utility_deparments->electricity_service_active == 1 ? 'checked' : '' }}>
                                                                            Service Active
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12">
                                                                    <div class="form-group"
                                                                        style="padding: 0 10px;border-bottom: 1px solid #eee;">
                                                                        <label>Water</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Company Name"
                                                                                name="water_company_name"
                                                                                table="utility_deparments"
                                                                                @if (isset($utility_deparments)) value="{{ $utility_deparments->water_company_name }}" @endif>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Phone" name="water_phone"
                                                                                table="utility_deparments"
                                                                                @if (isset($utility_deparments)) value="{{ $utility_deparments->water_phone }}" @endif>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Login Link"
                                                                                name="water_link"
                                                                                table="utility_deparments"
                                                                                @if (isset($utility_deparments)) value="{{ $utility_deparments->water_link }}" @endif>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="User Name"
                                                                                name="water_user_name"
                                                                                table="utility_deparments"
                                                                                @if (isset($utility_deparments)) value="{{ $utility_deparments->water_user_name }}" @endif>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Password"
                                                                                name="water_password"
                                                                                table="utility_deparments"
                                                                                @if (isset($utility_deparments)) value="{{ $utility_deparments->water_password }}" @endif>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        <div class="input-group mb-2 mt-3">
                                                                            <input style="margin-right:5px"
                                                                                type="checkbox"
                                                                                name="water_service_active"
                                                                                table="utility_deparments"
                                                                                onchange="updateValue(this.checked ? '1' : null, 'water_service_active', 'utility_deparments')"
                                                                                {{ isset($utility_deparments) && $utility_deparments->water_service_active == 1 ? 'checked' : '' }}>
                                                                            Service Active
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12">
                                                                    <div class="form-group"
                                                                        style="padding: 0 10px;border-bottom: 1px solid #eee;">
                                                                        <label>Natural Gas</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Company Name"
                                                                                name="gas_company_name"
                                                                                table="utility_deparments"
                                                                                @if (isset($utility_deparments)) value="{{ $utility_deparments->gas_company_name }}" @endif>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Phone" name="gas_phone"
                                                                                table="utility_deparments"
                                                                                @if (isset($utility_deparments)) value="{{ $utility_deparments->gas_phone }}" @endif>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Login Link" name="gas_link"
                                                                                table="utility_deparments"
                                                                                @if (isset($utility_deparments)) value="{{ $utility_deparments->gas_link }}" @endif>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="User Name"
                                                                                name="gas_user_name"
                                                                                table="utility_deparments"
                                                                                @if (isset($utility_deparments)) value="{{ $utility_deparments->gas_user_name }}" @endif>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Password"
                                                                                name="gas_password"
                                                                                table="utility_deparments"
                                                                                @if (isset($utility_deparments)) value="{{ $utility_deparments->gas_password }}" @endif>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        <div class="input-group mb-2 mt-3">
                                                                            <input style="margin-right:5px"
                                                                                type="checkbox"
                                                                                name="gas_service_active"
                                                                                table="utility_deparments"
                                                                                onchange="updateValue(this.checked ? '1' : null, 'gas_service_active', 'utility_deparments')"
                                                                                {{ isset($utility_deparments) && $utility_deparments->gas_service_active == 1 ? 'checked' : '' }}>
                                                                            Service Active
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12">
                                                                    <div class="form-group"
                                                                        style="padding: 0 10px;border-bottom: 1px solid #eee;">
                                                                        <label>Propane</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Company Name"
                                                                                name="propane_company_name"
                                                                                table="utility_deparments"
                                                                                @if (isset($utility_deparments)) value="{{ $utility_deparments->propane_company_name }}" @endif>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Phone" name="propane_phone"
                                                                                table="utility_deparments"
                                                                                @if (isset($utility_deparments)) value="{{ $utility_deparments->propane_phone }}" @endif>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Login Link"
                                                                                name="propane_link"
                                                                                table="utility_deparments"
                                                                                @if (isset($utility_deparments)) value="{{ $utility_deparments->propane_link }}" @endif>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="User Name"
                                                                                name="propane_user_name"
                                                                                table="utility_deparments"
                                                                                @if (isset($utility_deparments)) value="{{ $utility_deparments->propane_user_name }}" @endif>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Password"
                                                                                name="propane_password"
                                                                                table="utility_deparments"
                                                                                @if (isset($utility_deparments)) value="{{ $utility_deparments->propane_password }}" @endif>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        <div class="input-group mb-2 mt-3">
                                                                            <input style="margin-right:5px"
                                                                                type="checkbox"
                                                                                name="propane_service_active"
                                                                                table="utility_deparments"
                                                                                onchange="updateValue(this.checked ? '1' : null, 'propane_service_active', 'utility_deparments')"
                                                                                {{ isset($utility_deparments) && $utility_deparments->propane_service_active == 1 ? 'checked' : '' }}>
                                                                            Service Active
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
                                                        <div class="row">
                                                            <div class="col-md-12">

                                                                <div class="form-group" style="padding: 0 10px;">
                                                                    <div class="card">
                                                                        <div class="">
                                                                            <div class="table-responsive">
                                                                                <table
                                                                                    class="table table-striped table-bordered"
                                                                                    id="datatable">
                                                                                    <thead>
                                                                                        <tr>

                                                                                            <th scope="col">Skip trace
                                                                                                option</th>
                                                                                            <th scope="col">Name</th>
                                                                                            <th scope="col">Address
                                                                                            </th>
                                                                                            <th scope="col">City</th>
                                                                                            <th scope="col">Zip</th>

                                                                                            <th scope="col">Verified
                                                                                                Numbers & Emails</th>
                                                                                            <th scope="col">Scam
                                                                                                Numbers & Emails</th>
                                                                                            <th scope="col">Append Name
                                                                                                & Emails

                                                                                            </th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        @if ($collection)
                                                                                            @foreach ($collection as $skipTraceRecord)
                                                                                                <tr>
                                                                                                    <td>{{ @$skipTraceRecord->select_option }}
                                                                                                    </td>
                                                                                                    <td>{{ @$skipTraceRecord->first_name }}
                                                                                                        {{ @$skipTraceRecord->last_name }}
                                                                                                    </td>
                                                                                                    <td>{{ @$skipTraceRecord->address }}
                                                                                                    </td>
                                                                                                    <td>{{ @$skipTraceRecord->city }}
                                                                                                    </td>
                                                                                                    <td>{{ @$skipTraceRecord->zip }}
                                                                                                    </td>

                                                                                                    <td>{{ @$skipTraceRecord->verified_numbers }}
                                                                                                        {{ @$skipTraceRecord->verified_emails }}
                                                                                                    </td>
                                                                                                    <td>{{ @$skipTraceRecord->scam_numbers }}
                                                                                                        {{ @$skipTraceRecord->scam_emails }}
                                                                                                    </td>
                                                                                                    <td>{{ @$skipTraceRecord->append_names }}
                                                                                                        {{ @$skipTraceRecord->append_emails }}
                                                                                                    </td>
                                                                                                </tr>
                                                                                            @endforeach

                                                                                        @endif
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                    @elseif($section->id == '25')
                                                        <div class="col-md-12" id="{{ $section->id }}"
                                                            style="padding:0px;">
                                                            <div class="row" id="digitalsigning">
                                                                <div class="col-md-12">
                                                                    <div class="form-group lead-heading">
                                                                        <label>{{ $section->name }}</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        <div id="error-messages"
                                                                            class="alert alert-danger alert-dismissible"
                                                                            style="display: none; margin-left: 1%;">
                                                                            <!-- Close button -->
                                                                            <button type="button" class="close"
                                                                                data-dismiss="alert" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                            <!-- Error messages will be appended here -->
                                                                        </div>
                                                                        <label for="recipient-name"
                                                                            class="col-form-label">Form Template <span
                                                                                class="required">*</span></label>
                                                                        <select class="form-control formTemplate"
                                                                            onchange="fetch(this)" id="template_id"
                                                                            name="template_id" required>
                                                                            <option value="">Select Form Template
                                                                            </option>
                                                                            @foreach (getFormTemplate() as $templateId => $template)
                                                                                <option value="{{ $templateId }}">
                                                                                    {{ $template }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        <label>Template Content <span
                                                                                class="required">*</span></label>
                                                                        <textarea class="form-control text1 userAgreementContent" id="user-agreement-content" name="content"
                                                                            rows="10"></textarea>
                                                                        <div id='count' class="float-lg-right">
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group" style="padding: 0 10px;">
                                                                        <label for="seller_id"
                                                                            class="col-form-label">Select Contacts <span
                                                                                class="required">*</span></label>
                                                                                <div class="checkbox-list">
                                                                                    <div class="row">
                                                                                        <div class="col-md-4">
                                                                                            <label><input style="margin-right:5px" type="checkbox" class="user-seller"
                                                                                                table="lead_info"
                                                                                                onchange="updateValue(this.checked ? '1' : null, 'mail_to_owner1', 'lead_info')"
                                                                                                value="{{ $leadinfo->mail_to_owner1 }}"
                                                                                                {{ $leadinfo->mail_to_owner1 == 1 ? 'checked' : '' }}
                                                                                                name="mail_to_owner1">Contact 1 ({{ $leadinfo->owner1_first_name }})</label>
                                                                                        </div>
                                                                                        <div class="col-md-4">
                                                                                            <label><input style="margin-right:5px" type="checkbox" class="user-seller"
                                                                                                table="lead_info"
                                                                                                onchange="updateValue(this.checked ? '1' : null, 'mail_to_owner2', 'lead_info')"
                                                                                                value="{{ $leadinfo->mail_to_owner2 }}"
                                                                                                {{ $leadinfo->mail_to_owner2 == 1 ? 'checked' : '' }}
                                                                                                name="mail_to_owner2">Contact 2 ({{ $leadinfo->owner2_first_name }})</label>

                                                                                        </div>
                                                                                        <div class="col-md-4">
                                                                                            <label><input style="margin-right:5px" type="checkbox" class="user-seller"
                                                                                                table="lead_info"
                                                                                                onchange="updateValue(this.checked ? '1' : null, 'mail_to_owner3', 'lead_info')"
                                                                                                value="{{ $leadinfo->mail_to_owner3 }}"
                                                                                                {{ $leadinfo->mail_to_owner3 == 1 ? 'checked' : '' }}
                                                                                                name="mail_to_owner3">Contact 3 ({{ $leadinfo->owner3_first_name }})</label>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <div class="form-group"
                                                                            style="margin-left: 15px;">
                                                                            <small class="text-danger"><b>Please Keep
                                                                                    {SIGNATURE_USER} in contenet for
                                                                                    user sign</b></small>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="margin-left: 15px;">
                                                                        <button type="button"
                                                                            class="btn btn-primary button-item saveUserAgreementContact">Create</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <hr>
                                                    @elseif($section->id == '24')
                                                        <div class="col-md-12" id="{{ $section->id }}" style="padding:0px;">
                                                            <div class="row" id="APPOINTMENTS">
                                                                <div class="col-md-12">
                                                                    <div class="form-group lead-heading">
                                                                        <label>{{ $section->name }}</label>
                                                                    </div>
                                                                </div>
                                                                <div class="card col-md-12" style="padding: 0 10px;">
                                                                    <table id="tasktable" class="table table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                                <th><input type="checkbox" id="selectAll" class="task-checkbox"></th>
                                                                                <!-- <th>S.No</th> -->
                                                                                <th>Task</th>
                                                                                <!-- <th>Assigned To</th> -->
                                                                                <!-- <th>Status</th> -->
                                                                                <th>Action</th>
                                                                                <th>Drag</th> <!-- New drag handle column -->
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($tasks as $key => $task)
                                                                                <tr data-task-id="{{ $task->id }}">
                                                                                    <!-- Add data-task-id attribute -->
                                                                                    <td>
                                                                                        <input type="checkbox" class="task-checkbox" name="task_id[]"
                                                                                            value="{{ $task->id }}">
                                                                                    </td>
                                                                                    <!-- <td>{{ @$loop->iteration }}</td> -->
                                                                                    <td><a href="{{ route('admin.task-list.show', $task->id) }}"
                                                                                            id="trigger-startup-button">{{ @$task->tast }} </a> </td>
                                                                                    <!-- <td>{{ @$task->user->name }}</td> -->
                                                                                    <!-- <td>{{ @$task->status }}</td> -->
                                                                                    <td>
                                                                                        <!-- @if (auth()->user()->can('administrator') ||
                                                                                                auth()->user()->can('user_task_edit'))-->
                                                                                        <button class="btn btn-outline-primary btn-sm edit-task"
                                                                                            data-task-id="{{ @$task->id }}"
                                                                                            data-task-name="{{ @$task->tast }}"
                                                                                            data-assignee-id="{{ @$task->user->id }}"
                                                                                            title="Edit Task"><i class="fas fa-edit"></i></button>
                                                                                    <!-- @endif -->
                                                                                    </td>
                                                                                    <td class="drag-handle"><i class="fas fa-arrows-alt"></i></td>
                                                                                    <!-- Drag handle icon -->
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-1"></div> --}}
                                    <div class="col-md-4">
                                        <div class="card content-div">
                                            <div class="form-group" style="padding: 0 10px;">
                                                <label style="margin-top: 5px;">Load Script</label>
                                                <select class="custom-select" name="lead_assigned_to"
                                                    onchange="loadScript(value)">
                                                    <option value="">Select Script</option>
                                                    @if (count($scripts) > 0)
                                                        @foreach ($scripts as $script)
                                                            <option value="{{ $script->id }}">{{ $script->name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div readonly class="load_script"></div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- <button type="submit" class="btn btn-primary mt-2" >Send SMS</button>
                                            </div> --}}

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

    {{-- <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/dropzone@5.9.3/dist/min/dropzone.min.js"></script>
    <script src="{{ asset('back/assets/js/pages/user-agreement.js?t=') }}<?= time() ?>"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script> --}}

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <link rel="stylesheet" href="{{ asset('/summernote/dist/summernote.css') }}" />
    <script src="{{ asset('/summernote/dist/summernote.min.js') }}"></script>


    <script>
        Dropzone.autoDiscover = false;
        $(document).ready(function() {

            // Initially hide the date input
            $('.date-input-hidden').hide();
            setupDateInputHandling();


            // When the text input is clicked, hide it and show the hidden date input
            $('.date-input-text').on('click', function() {
                $(this).hide();
                $('.date-input-hidden').show().focus();

            });

            var uploadedFiles = [];
            var acceptedFiles = ".jpg, .jpeg, .png, .gif, .pdf, .docx";
            var myDropzone = new Dropzone("#dropzone", {
                paramName: "file", // The name that will be used for the uploaded file
                maxFilesize: 5, // Maximum file size (in MB)
                acceptedFiles: acceptedFiles, // Accepted file types
                maxFiles: 5, // Maximum number of files that can be uploaded
                autoProcessQueue: false, // Automatically process the queue when files are added
                addRemoveLinks: true, // Show remove links on uploaded files
                dictDefaultMessage: "Drop files here or click to upload", // Default message displayed on the Dropzone area
                dictFallbackMessage: "Your browser does not support drag and drop file uploads.",
                dictFallbackText: "Please use the fallback form below to upload your files.",
                dictRemoveFile: "Remove", // Text for the remove file link
                dictCancelUpload: "Cancel", // Text for the cancel upload link
                dictCancelUploadConfirmation: "Are you sure you want to cancel this upload?",
                init: function() {
                    this.on("addedfile", function(file) {
                        var dropzoneForm = document.getElementById("dropzone");

                        // Append existing input elements
                        // dropzoneForm.appendChild(document.getElementById("_token"));
                        // dropzoneForm.appendChild(document.getElementById("lead_status"));

                        // Create and append a new hidden input element
                        var id = {!! $id !!};
                        var hiddenInput = document.createElement("input");
                        hiddenInput.type = "hidden";
                        hiddenInput.name = "contact_id";
                        hiddenInput.id = "contact_id";
                        hiddenInput.value = id;
                        dropzoneForm.appendChild(hiddenInput);

                        var leadStatusValue = document.getElementById("file_type").value;
                        var document_type = document.createElement("input");
                        document_type.type = "hidden";
                        document_type.name = "file_type";
                        document_type.id = "file_type";
                        document_type.value = leadStatusValue;
                        dropzoneForm.appendChild(document_type);

                        var token = document.createElement("input");
                        token.type = "hidden";
                        token.name = "_token";
                        token.id = "_token";
                        token.value = "{{ csrf_token() }}";;
                        dropzoneForm.appendChild(token);
                    });

                    this.on("success", function(file, response) {
                        // Event handler when a file upload is successful
                        console.log(response);
                        this.removeAllFiles();
                        toastr.success("File uplaoded Successfully", {
                            timeOut: 10000, // Set the duration (10 seconds in this example)
                        });
                    });

                    this.on("removedfile", function(file) {
                        // Event handler when a file is removed from the queue
                    });

                    this.on("error", function(file, errorMessage) {
                        console.log(errorMessage);
                        toastr.error("File not uploaded", {
                            timeOut: 10000, // Set the duration (10 seconds in this example)
                        });
                    });
                }
            });
            // When the date input loses focus, hide it and show the text input if it's empty
            $('.date-input-hidden').on('blur', function() {
                if (!$(this).val()) {
                    $(this).hide();
                    $('.date-input-text').show();
                } else {
                    $(this).show();
                    $('.date-input-text').hide();
                }
            });

            // Agreement
            $(document).on("click", ".saveUserAgreementContact", function(e) {
                let CKEDITOR = [];
                e.preventDefault();
                var myData = $(this);
                myData.attr('disabled', true);
                console.log($("#user-agreement-create").find("textarea[name='content']").val(CKEDITOR[
                    "user-agreement-content"]));
                $("#user-agreement-create").find("textarea[name='content']").val(CKEDITOR[
                    "user-agreement-content"]);
                var data = $(this).parents("form").serialize();
                $.ajax({
                    url: "/admin/user-agreement/save",
                    method: "post",
                    data: data,
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            location.reload();
                        } else {
                            console.log(response);
                        }
                    },
                    error: function(xhr) {
                        // Handle the error here (e.g., show an error message to the user)
                        console.log("AJAX Request Error: " + xhr.statusText);
                        var errors = xhr.responseJSON.errors;
                        var errorMessageContainer = $("#error-messages");
                        errorMessageContainer.empty(); // Clear any previous error messages

                        if (errors) {
                            // Scenario 1: Named errors
                            for (var fieldName in errors) {
                                if (errors.hasOwnProperty(fieldName)) {
                                    var errorValues = errors[fieldName];
                                    if (Array.isArray(errorValues)) {
                                        console.log(errors[fieldName]);
                                        if (errors[fieldName].length > 1) {
                                            errors[fieldName].forEach(element => {
                                                errorMessageContainer.append(
                                                    '<div> <i class="fa fa-info"></i> ' +
                                                    fieldName + ' : ' + element +
                                                    ' value is not found in the contact record!</div><br>'
                                                    );
                                            });
                                        } else {
                                            if (errorValues[0] === 'This field is required!') {
                                                errorMessageContainer.append(
                                                    '<div> <i class="fa fa-info"></i> ' +
                                                    fieldName + ' : ' + errorValues +
                                                    '</div><br>');

                                            } else {

                                                errorMessageContainer.append(
                                                    '<div> <i class="fa fa-info"></i> ' +
                                                    fieldName + ' : ' + errorValues +
                                                    ' value is not found in the contact record!</div><br>'
                                                    );
                                            }
                                        }
                                        // If there are multiple error values, join them into a single line
                                        // var errorMessage = fieldName + ': ' + errorValues.join(', ');
                                    } else {
                                        errorMessageContainer.append(
                                            '<div> <i class="fa fa-info"></i> ' +
                                            fieldName + ' : ' + errorValues + '</div>');
                                    }
                                }
                            }
                        } else {
                            // Scenario 2: Missing field error
                            var errorList = xhr.responseJSON;
                            var errorHTML = "";
                            for (var i = 0; i < errorList.length; i++) {
                                errorHTML += errorList[i] + ' is required!' + "<br>";
                            }
                            errorMessageContainer.append('<div>' + errorHTML + '</div>');
                        }
                        errorMessageContainer.show();
                    }

                });


            });





            // $('#fileManagerModal').on('show.bs.modal', function (e) {
            //         var modal = $(this);
            //         var id = {!! $id !!};

            //         // Perform an AJAX request to fetch content
            //         $.ajax({
            //             url: '/admin/file-manager/'+id, // Replace with your actual AJAX endpoint
            //             type: 'GET',
            //             success: function (data) {
            //                 // Update the modal content with the received data
            //                 // modal.find('.modal-body').html(data);
            //                 console.log(data);
            //             },
            //             error: function (xhr, status, error) {
            //                 console.error(error);
            //             }
            //         });
            //     });

            $("#custom-upload-button").click(function() {
                myDropzone.processQueue(); // Process the Dropzone queue
            });

            // $('#datatable').DataTable();
            $('#appoitment-list-table').DataTable();

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

            // $("#custom-upload-button").click(function() {
            //     console.log('work');
            //     var form = $("#my-awesome-dropzone");
            //     var form2 = $("#main_form");

            //     // Set the form's action attribute to the new route
            //     form.attr("action", "{{ route('admin.google.drive.login') }}");
            //     form2.attr("action", "{{ route('admin.google.drive.login') }}");
            //     // Submit the form
            //     // form.submit();
            //     form2.submit();

            // });


            // Get a reference to the hidden input
            // Get a reference to the hidden input




            $('#fetch-realtor-estimates-button').click(function() {
                getRealtorPropertyId();
            });

            $('#fetch-map-links-button').click(function() {
                fetchgooglemap();
                // $('#fetchgooglemap').show()
                // $('#fetchzillow').show()
            });
        });
    </script>
    <script>
        function deleteFile(fileId) {

            var id = {!! $id !!};
            var requestData = {
                id: id,
                fileId: fileId
            };
            // Confirm with the user before deleting

            // Perform an AJAX request to delete the file
            $.ajax({
                url: `/admin/file-manager/delete`, // Replace with your actual DELETE endpoint
                type: 'DELETE',
                data: requestData,
                success: function(data) {
                    // Handle success, for example, you can remove the file item from the UI
                    console.log(data);
                    // Remove the file item from the UI, e.g., using jQuery
                    $('#fileItem' + fileId).remove();
                },
                error: function(xhr, status, error) {
                    console.error("Error deleting file: " + error);
                }
            });

        }

        function stepBackModel() {
            $('#fileManagerModal').modal('show');
            $('#filesModal').modal('hide');
        }

        function fetchFiles(fileType) {
            $('#fileManagerModal').modal('hide');
            $('#filesModal').modal('show');

            var modal = $('#filesModal'); // Use the correct modal by ID

            var id = {!! $id !!};
            var requestData = {
                id: id,
                fileType: fileType
            };
            // Perform an AJAX request to fetch content
            $.ajax({
                url: '/admin/file-manager',
                type: 'GET',
                data: requestData,
                success: function(data) {
                    console.log(data);
                    // Clear existing content in the modal's body
                    modal.find('.file-manager-container').empty();

                    modal.find('.file-manager-container').append(`<div class="file-item">
                    <div class="file-item-icon file-item-level-up fas fa-level-up-alt text-secondary" onClick="stepBackModel()"></div>
                    <a href="javascript:void(0)" class="file-item-name">
                        ..
                    </a>
                </div>`);
                    // Iterate through the data and add file items to the modal
                    for (var key in data.data) {
                        if (data.data.hasOwnProperty(key)) {
                            var fileItem = data.data[key];
                            var fileItemHTML = `
                                <div class="file-item">
                                    <div class="file-item-select-bg bg-primary"></div>
                                    <div class="file-item-icon far fa-file text-secondary"></div>
                                    <a href="${fileItem.url}" class="file-item-name" target="_blank">
                                        ${fileItem.file_name}
                                    </a>
                                    <div class="file-item-actions btn-group">
                                        <button type="button" class="btn btn-default btn-sm rounded-pill icon-btn borderless md-btn-flat hide-arrow dropdown-toggle" data-toggle="dropdown"><i class="ion ion-ios-more"></i></button>
                                        <div class="dropdown-menu dropdown-menu-right">

                                            <br>
                                            <a class="dropdown-item" href="${fileItem.url}" target="_blank">Open in tab</a>
                                            <br>
                                            <a class="dropdown-item" href="${fileItem.url}" target="_blank"  download="${fileItem.file_name}">Download</a>

                                            </div>
                                            </div>
                                            </div>
                                            `;
                            // <a class="dropdown-item" href="javascript:void(0)" onclick="deleteFile('${fileItem.uuid}')">Delete</a>

                            // Append the file item to the modal's body
                            modal.find('.file-manager-container').append(fileItemHTML);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        function downloadFile(fileUrl) {
            // Create an invisible anchor element
            var a = document.createElement('a');
            a.style.display = 'none';
            document.body.appendChild(a);

            // Set the anchor's href attribute to the file URL
            a.href = fileUrl;

            // Trigger a click event on the anchor
            a.click();

            // Remove the anchor from the DOM
            document.body.removeChild(a);
        }


        function updateAcceptedFiles() {
            var selectElement = document.getElementById("file_type");
            var selectedOption = selectElement.options[selectElement.selectedIndex].value;

            if (selectedOption === "photo") {
                this.acceptedFiles = ".jpg, .jpeg, .png, .gif";
            } else if (selectedOption === "Miscellaneous") {
                this.acceptedFiles = ".jpg, .jpeg, .png, .gif, .pdf"; // Customize this list
            } else {
                this.acceptedFiles = ".pdf"; // Default for other cases
            }
            console.log(this.acceptedFiles);

            // Update the acceptedFiles in the Dropzone configuration
            // acceptFile = acceptedFiles;
        }

        function showDiv(divId, element) {
            document.getElementById(divId).style.display = element.value == 1 ? 'block' : 'none';
        }

        function templateId() {
            template_id = document.getElementById("template-select").value;
            setTextareaValue(template_id)
        }

        function createCheckbox(number, checkboxList) {

            if (number) {
                const label = document.createElement("label");
                const checkbox = document.createElement("input");
                checkbox.type = "checkbox";
                checkbox.name = "smsNumbers[]";
                checkbox.value = number;

                // Set the label text to the phone number
                label.appendChild(checkbox);
                label.appendChild(document.createTextNode(" " + number));

                // Append the label to the checkboxList
                checkboxList.appendChild(label);

                const br = document.createElement("br");
                checkboxList.appendChild(br);
            }
        }
    </script>
    <script>
        // Check the type of file for upload to google drive
        function toggleFIlesUpload(value) {
            if (value == 'purchase_agreement_seller' || value == 'purchase_agreement_buyer') {
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

            // Check the input type
            var inputType = $(this).attr('type');
            var isNumberInput = (inputType === 'number');

            // Set the delay time in milliseconds (e.g., 1000 ms)
            var delayTime = 1000;

            if (table == 'custom_field_values') {
                var section_id = $(this).attr('section_id');
                var feild_id = $(this).attr('id');
            } else {
                var feild_id = 0;
                var section_id = 0;
            }
            var type = $(this).attr('type');

            // Apply a delay for number input elements
            if (isNumberInput) {
                clearTimeout($(this).data('timeout'));
                $(this).data('timeout', setTimeout(function() {
                    sendAjaxRequest();
                }, delayTime));
            } else {
                // Immediately update for other input types
                sendAjaxRequest();
            }

            function sendAjaxRequest() {
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
                            // $.notify(res.message, 'success');
                            $("#custom_message").modal("hide");
                            // setTimeout(function() {
                            //     location.reload();
                            // }, 1000);
                        } else {
                            $.notify(res.message, 'error');
                        }
                    },
                    error: function(err) {
                        $.notify('Error occurred while saving.', 'error');
                    }
                });
            }
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

        function fetchgooglemap() {
            $('#fetchgooglemap').show()
            var _token = $('input#_token').val();
            var id = {!! $contact->id !!};
            $.ajax({
                method: "POST",
                url: '<?php echo url('admin/contact/fetch-google-map'); ?>',
                data: {
                    id: id,
                    _token: _token
                },
                success: function(res) {
                    $('#fetchgooglemap').hide()
                    $('#google_map_link').show()
                    $('#google_map_text').hide()

                    if (res.status == true) {
                        $('#google_map_link').attr('href', res.link);
                        $('#google_map_link_text').html(res.link);
                        // getEstimates(res.id)
                        // Customize the Toastr message based on your requirements
                        toastr.success(res.message, {
                            timeOut: 10000, // Set the duration (10 seconds in this example)
                        });
                        fetchzillowlink();
                    } else {
                        toastr.error(res.message, {
                            timeOut: 9000, // Set the duration (5 seconds in this example)
                        });
                    }
                },
                error: function(err) {
                    $('#fetchgooglemap').hide()
                    toastr.error('API Error: ' + response.Message, 'API Response Error', {
                        timeOut: 9000, // Set the duration (5 seconds in this example)
                    });
                }
            });
        };

        function fetchzillowlink() {
            $('#fetchzillow').show()
            var _token = $('input#_token').val();
            var id = {!! $contact->id !!};
            $.ajax({
                method: "POST",
                url: '<?php echo url('admin/contact/fetch-zillow-link'); ?>',
                data: {
                    id: id,
                    _token: _token
                },
                success: function(res) {
                    $('#fetchzillow').hide()

                    if (res.status == true) {
                        $('#zillow_link').show()
                        $('#zillow_link').attr('href', res.link);
                        $('#zillow_link_text').html(res.link);
                        // getEstimates(res.id)
                        // Customize the Toastr message based on your requirements
                        toastr.success(res.message, {
                            timeOut: 10000, // Set the duration (10 seconds in this example)
                        });
                    } else {
                        toastr.error(res.message, {
                            timeOut: 9000, // Set the duration (5 seconds in this example)
                        });
                        $('#zillow_link_text').show()
                        $('#zillow_link_text').html("No link found");
                        $('#zillow_link').removeAttr('href');
                    }
                },
                error: function(err) {
                    $('#fetchgooglemap').hide()
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

        function setupDateInputHandling() {
            // Get all input elements with type 'date'
            var dateInputs = document.querySelectorAll('input[type="date"]');
            // Add event listeners to each 'date' input
            dateInputs.forEach(function(dateInput) {

                if (dateInput.value === '' || dateInput.value === null) {
                    dateInput.type = 'text';
                } else {
                    dateInput.type = 'date';
                }
                dateInput.addEventListener('focus', function() {
                    if (this.value !== '' || this.value !== null) {
                        this.type = 'date';
                    }
                });
                dateInput.addEventListener('blur', function() {
                    if (this.value === '' || this.value === null) {
                        this.type = 'text';
                    } else {
                        this.type = 'date';
                    }
                });
            });
        }

        function showMessageTypeData() {
            var messageType = document.getElementById("messageType").value;
            // Hide all message data sections
            document.getElementById("smsData").style.display = "none";
            document.getElementById("emailData").style.display = "none";
            document.getElementById("mmsData").style.display = "none";
            document.getElementById("rvmData").style.display = "none";

            // Show the selected message data section
            if (messageType === "sms") {
                document.getElementById("smsData").style.display = "block";
                const owner1primaryNumber = document.querySelector('input[name="owner1_primary_number"]').value;
                const owner1number2 = document.querySelector('input[name="owner1_number2"]').value;
                const owner1number3 = document.querySelector('input[name="owner1_number3"]').value;

                const owner2primaryNumber = document.querySelector('input[name="owner2_primary_number"]').value;
                const owner2number2 = document.querySelector('input[name="owner2_number2"]').value;
                const owner2number3 = document.querySelector('input[name="owner2_number3"]').value;

                const owner3primaryNumber = document.querySelector('input[name="owner3_primary_number"]').value;
                const owner3number2 = document.querySelector('input[name="owner3_number2"]').value;
                const owner3number3 = document.querySelector('input[name="owner3_number3"]').value;


                // Get the checkboxList element by its ID
                document.getElementById("checkbox-list").innerHTML = '';
                const checkboxList = document.getElementById("checkbox-list");
                createCheckbox(owner1primaryNumber, checkboxList);
                createCheckbox(owner1number2, checkboxList);
                createCheckbox(owner1number3, checkboxList);

                createCheckbox(owner2primaryNumber, checkboxList);
                createCheckbox(owner2number2, checkboxList);
                createCheckbox(owner2number3, checkboxList);

                createCheckbox(owner3primaryNumber, checkboxList);
                createCheckbox(owner3number2, checkboxList);
                createCheckbox(owner3number3, checkboxList);

            } else if (messageType === "email") {
                $(".summernote-usage").summernote({
                    height: 200,
                });
                document.getElementById("emailData").style.display = "block";
                document.getElementById("checkbox-list2").innerHTML = '';
                const checkboxList = document.getElementById("checkbox-list2");
                const owner1email1 = document.querySelector('input[name="owner1_email1"]').value;
                const owner1email2 = document.querySelector('input[name="owner1_email2"]').value;

                const owner2email1 = document.querySelector('input[name="owner2_email1"]').value;
                const owner2email2 = document.querySelector('input[name="owner2_email2"]').value;

                const owner3email1 = document.querySelector('input[name="owner3_email1"]').value;
                const owner3email2 = document.querySelector('input[name="owner3_email2"]').value;



                // Get the checkboxList element by its ID
                document.getElementById("checkbox-list").innerHTML = '';
                createCheckbox(owner1email1, checkboxList);
                createCheckbox(owner1email2, checkboxList);

                createCheckbox(owner2email1, checkboxList);
                createCheckbox(owner2email2, checkboxList);

                createCheckbox(owner3email1, checkboxList);
                createCheckbox(owner3email2, checkboxList);

            } else if (messageType === "mms") {
                document.getElementById("mmsData").style.display = "block";

                const owner1primaryNumber = document.querySelector('input[name="owner1_primary_number"]').value;
                const owner1number2 = document.querySelector('input[name="owner1_number2"]').value;
                const owner1number3 = document.querySelector('input[name="owner1_number3"]').value;

                const owner2primaryNumber = document.querySelector('input[name="owner2_primary_number"]').value;
                const owner2number2 = document.querySelector('input[name="owner2_number2"]').value;
                const owner2number3 = document.querySelector('input[name="owner2_number3"]').value;

                const owner3primaryNumber = document.querySelector('input[name="owner3_primary_number"]').value;
                const owner3number2 = document.querySelector('input[name="owner3_number2"]').value;
                const owner3number3 = document.querySelector('input[name="owner3_number3"]').value;


                // Get the checkboxList element by its ID
                document.getElementById("checkbox-list3").innerHTML = '';
                const checkboxList = document.getElementById("checkbox-list3");
                createCheckbox(owner1primaryNumber, checkboxList);
                createCheckbox(owner1number2, checkboxList);
                createCheckbox(owner1number3, checkboxList);

                createCheckbox(owner2primaryNumber, checkboxList);
                createCheckbox(owner2number2, checkboxList);
                createCheckbox(owner2number3, checkboxList);

                createCheckbox(owner3primaryNumber, checkboxList);
                createCheckbox(owner3number2, checkboxList);
                createCheckbox(owner3number3, checkboxList);

            } else if (messageType === "rvm") {
                document.getElementById("rvmData").style.display = "block";

                const owner1primaryNumber = document.querySelector('input[name="owner1_primary_number"]').value;
                const owner1number2 = document.querySelector('input[name="owner1_number2"]').value;
                const owner1number3 = document.querySelector('input[name="owner1_number3"]').value;

                const owner2primaryNumber = document.querySelector('input[name="owner2_primary_number"]').value;
                const owner2number2 = document.querySelector('input[name="owner2_number2"]').value;
                const owner2number3 = document.querySelector('input[name="owner2_number3"]').value;

                const owner3primaryNumber = document.querySelector('input[name="owner3_primary_number"]').value;
                const owner3number2 = document.querySelector('input[name="owner3_number2"]').value;
                const owner3number3 = document.querySelector('input[name="owner3_number3"]').value;


                // Get the checkboxList element by its ID
                document.getElementById("checkbox-list4").innerHTML = '';
                const checkboxList = document.getElementById("checkbox-list4");
                createCheckbox(owner1primaryNumber, checkboxList);
                createCheckbox(owner1number2, checkboxList);
                createCheckbox(owner1number3, checkboxList);

                createCheckbox(owner2primaryNumber, checkboxList);
                createCheckbox(owner2number2, checkboxList);
                createCheckbox(owner2number3, checkboxList);

                createCheckbox(owner3primaryNumber, checkboxList);
                createCheckbox(owner3number2, checkboxList);
                createCheckbox(owner3number3, checkboxList);
            }
        }

        // Add an event listener to the message type dropdown
        document.getElementById("messageType").addEventListener("change", showMessageTypeData);

        // Initialize the form with the message type data
        // showMessageTypeData();

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
                        // setTimeout(function() {
                        //     location.reload();
                        // }, 1000);
                    } else {
                        $.notify(res.message, 'error');
                    }
                },
                error: function(err) {
                    $.notify('Error occurred while saving.', 'error');
                }
            });
        }

        function fetch(ctrl) {
            //alert(ctrl.value);
            var tempid = ctrl.value;
            console.log(tempid);
            //alert(tempid);
            $('#user-agreement-content').html('');
            var url = '<?php echo url('/admin/get/template/'); ?>/' + tempid;
            $.ajax({
                type: 'GET',
                url: url,
                data: '',
                processData: false,
                contentType: false,
                success: function(d) {
                    // alert(d);
                    // $('#user-agreement-content').html(d);
                }
            });
        }

        function updateTagValue(fieldVal, fieldName, table) {
            var _token = $('input[name="_token"]').val(); // Make sure to target the input using the name attribute
            var id = {{ $id }}; // Use Blade syntax to insert PHP variable
            var selectedTags = $('#tags').val(); // Get the selected values from the Select2 input
            $.ajax({
                method: "POST",
                url: '{{ route('admin.contact.detail.update.select2') }}', // Use Laravel route function
                data: {
                    id: id,
                    fieldVal: fieldVal,
                    table: table,
                    fieldName: fieldName,
                    selectedTags: selectedTags, // Pass the selected tags
                    _token: _token
                },
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
                    $('.load_script .note-toolbar.panel-heading').hide();
                },
                error: function(err) {
                    $.notify('Error occurred while saving.', 'error');
                }
            });
        }
        // Function to show the selected message type data
    </script>
@endsection
