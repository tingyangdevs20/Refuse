@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <style>
        /* Ensure the table takes the full width of its container */
        .table-responsive {
            overflow-x: auto;
        }

        /* Add horizontal scrolling for the table on smaller screens */
        /* .table {
                                        white-space: nowrap;
                                    } */

        /* Add responsive breakpoints and adjust table font size and padding as needed */
        @media (max-width: 768px) {
            .table {
                font-size: 12px;
            }
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
                        <h4 class="mb-0 font-size-18">Settings</h4>
                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            <i class="fas fa-cog mr-1"></i> Marketing Spend Settings
                            @include('components.modalform')
                        </div>
                        <div class="card-body">
                            <div class="col-md-4">
                                <form action="{{ url('admin/marketing-spend/update') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label>Lead Source</label>
                                        <select class="custom-select" name="lead_source"
                                            onchange="updateValue(value,'lead_source','lead_info')" required>
                                            <option value="">Lead Source</option>
                                            <option value="Bandit Signs"
                                                @if (isset($data)) @if ($data->lead_source == 'Bandit Signs') selected @endif
                                                @endif>Bandit Signs
                                            </option>
                                            <option value="Billboards"
                                                @if (isset($data)) @if ($data->lead_source == 'Billboards') selected @endif
                                                @endif>Billboards
                                            </option>
                                            <option value="Cold Calling"
                                                @if (isset($data)) @if ($data->lead_source == 'Cold Calling') selected @endif
                                                @endif>Cold Calling
                                            </option>
                                            <option value="Direct Mail"
                                                @if (isset($data)) @if ($data->lead_source == 'Direct Mail') selected @endif
                                                @endif>Direct Mail
                                            </option>
                                            <option value="Door Knocking"
                                                @if (isset($data)) @if ($data->lead_source == 'Door Knocking') selected @endif
                                                @endif>Door Knocking
                                            </option>
                                            <option value="Email"
                                                @if (isset($data)) @if ($data->lead_source == 'Email') selected @endif
                                                @endif>Email
                                            </option>
                                            <option value="Facebook Ads"
                                                @if (isset($data)) @if ($data->lead_source == 'Facebook Ads') selected @endif
                                                @endif>Facebook Ads
                                            </option>
                                            <option value="Flyers"
                                                @if (isset($data)) @if ($data->lead_source == 'Flyers') selected @endif
                                                @endif>Flyers
                                            </option>
                                            <option value="Instagram Ads"
                                                @if (isset($data)) @if ($data->lead_source == 'Instagram Ads') selected @endif
                                                @endif>Instagram Ads
                                            </option>
                                            <option value="iSpeedToLead"
                                                @if (isset($data)) @if ($data->lead_source == 'iSpeedToLead') selected @endif
                                                @endif>iSpeedToLead
                                            </option>
                                            <option value="LinkedIn Ads"
                                                @if (isset($data)) @if ($data->lead_source == 'LinkedIn Ads') selected @endif
                                                @endif>LinkedIn Ads
                                            </option>
                                            <option value="Magazine"
                                                @if (isset($data)) @if ($data->lead_source == 'Magazine') selected @endif
                                                @endif>Magazine
                                            </option>
                                            <option value="MMS"
                                                @if (isset($data)) @if ($data->lead_source == 'MMS') selected @endif
                                                @endif>MMS
                                            </option>
                                            <option value="Newspaper"
                                                @if (isset($data)) @if ($data->lead_source == 'Newspaper') selected @endif
                                                @endif>Newspaper
                                            </option>
                                            <option value="Phone Call (Incoming)"
                                                @if (isset($data)) @if ($data->lead_source == 'Phone Call (Incoming)') selected @endif
                                                @endif>Phone Call
                                                (Incoming)
                                            </option>
                                            <option value="Radio"
                                                @if (isset($data)) @if ($data->lead_source == 'Radio') selected @endif
                                                @endif>Radio
                                            </option>
                                            <option value="Referral"
                                                @if (isset($data)) @if ($data->lead_source == 'Referral') selected @endif
                                                @endif>Referral
                                            </option>
                                            <option value="Retargeting"
                                                @if (isset($data)) @if ($data->lead_source == 'Retargeting') selected @endif
                                                @endif>Retargeting
                                            </option>
                                            <option value="RVM"
                                                @if (isset($data)) @if ($data->lead_source == 'Retargeting') selected @endif
                                                @endif>RVM
                                            </option>
                                            <option value="SEO"
                                                @if (isset($data)) @if ($data->lead_source == 'SEO') selected @endif
                                                @endif>SEO
                                            </option>
                                            <option value="SMS"
                                                @if (isset($data)) @if ($data->lead_source == 'SMS') selected @endif
                                                @endif>SMS
                                            </option>
                                            <option value="Social Media"
                                                @if (isset($data)) @if ($data->lead_source == 'Social Media') selected @endif
                                                @endif>Social Media
                                            </option>
                                            <option value="Tiktok Ads"
                                                @if (isset($data)) @if ($data->lead_source == 'Tiktok Ads') selected @endif
                                                @endif>Tiktok Ads
                                            </option>
                                            <option value="Twitter Ads"
                                                @if (isset($data)) @if ($data->lead_source == 'Twitter Ads') selected @endif
                                                @endif>Twitter Ads
                                            </option>
                                            <option value="Website"
                                                @if (isset($data)) @if ($data->lead_source == 'Website') selected @endif
                                                @endif>Website
                                            </option>


                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Date</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fas fa-clock"></i></div>
                                            </div>
                                            <input type="date" required placeholder="Select custom date" name="date"
                                                value="{{ \Carbon\Carbon::parse($data->date)->format('Y-m-d') }}" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Amount</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fas fa-dollar-sign"></i></div>
                                            </div>
                                            <input type="number" required placeholder="Enter Amount Spent" name="amount"
                                                value="{{ $data->amount }}" class="form-control" />
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Update Settings</button>

                                </form>
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
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        $(document).ready(function() {
            setupDateInputHandling()
        });

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
    </script>
@endsection
