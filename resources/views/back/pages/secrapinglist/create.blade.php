@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
    <style>
        span.select2-selection.select2-selection--single {
            height: 40px;
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
                            <form method="post" action="{{ route('admin.scraping.store') }}" enctype="multipart/form-data">
                                @csrf <!-- CSRF Token -->

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="country">Country</label>
                                        <input type="text" class="form-control @error('country') is-invalid @enderror"
                                            id="country" name="country" value="{{ old('country') }}">
                                        @error('country')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="state">State</label>
                                        <input type="text" class="form-control @error('state') is-invalid @enderror"
                                            id="state" name="state" value="{{ old('state') }}">
                                        @error('state')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <input type="text" class="form-control @error('city') is-invalid @enderror"
                                            id="city" name="city" value="{{ old('city') }}">
                                        @error('city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="zip">Zip</label>
                                        <input type="number" class="form-control @error('zip') is-invalid @enderror"
                                            id="zip" name="zip" value="{{ old('zip') }}">
                                        @error('zip')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="listing_type">Listing Type</label>
                                        <select class="form-control @error('listing_type') is-invalid @enderror"
                                            id="listing_type" name="listing_type[]" multiple>
                                            <option value="owner" {{ old('owner') ? 'selected' : '' }}>For Sale (by Owner)
                                            </option>
                                            <option value="agent" {{ old('agent') ? 'selected' : '' }}>Sale (By Agent)
                                            </option>
                                        </select>
                                        @error('listing_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="price_range">Price Range</label>
                                        <select class="form-control @error('price_range') is-invalid @enderror"
                                            id="price_range" name="price_range">
                                            <option value="">Select Price Range</option>
                                            <option value="100k-300k">100k-300k</option>
                                            <option value="300k-600k">300k-600k</option>

                                        </select>
                                        @error('price_range')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="no_of_bedrooms">No of Bedrooms</label>
                                        <select class="form-control @error('no_of_bedrooms') is-invalid @enderror"
                                            id="no_of_bedrooms" name="no_of_bedrooms">
                                            <option value="">Select No of Bedrooms</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>

                                        </select>
                                        @error('no_of_bedrooms')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="no_of_bathrooms">No of bathrooms</label>
                                        <select class="form-control @error('no_of_bathrooms') is-invalid @enderror"
                                            id="no_of_bathrooms" name="no_of_bathrooms">
                                            <option value="">Select No of Bedrooms</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>

                                        </select>
                                        @error('no_of_bathrooms')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>



                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="property_type">Property Type</label>
                                        <select class="form-control @error('property_type') is-invalid @enderror"
                                            id="property_type" name="property_type[]" multiple>
                                            <option value="">Property Type</option>
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
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="filters">Filters</label>
                                        <select class="form-control @error('filters') is-invalid @enderror" id="filters"
                                            name="filters">
                                            <option value="">Filter</option>
                                            <option value="pre-foreclousers">Pre Foreclousers</option>
                                            <option value="coming-soon">Coming Soon</option>

                                        </select>
                                        @error('filters')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="job_name">Job Name</label>
                                        <input type="text"
                                            class="form-control @error('job_name') is-invalid @enderror" id="job_name"
                                            name="job_name" value="{{ old('job_name') }}">
                                        @error('job_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>



                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="data_status">Status</label>
                                        <select class="form-control @error('data_status') is-invalid @enderror"
                                            id="data_status" name="data_status">
                                            <option value="">Select Status</option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>

                                        </select>
                                        @error('data_status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="file">File</label>
                                        <input type="file"
                                            class="form-control-file @error('file') is-invalid @enderror" id="file"
                                            name="file">
                                        @error('file')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>



                                <button type="submit" class="btn btn-primary">Add Data</button>
                            </form>


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

        });
    </script>
    <script></script>
@endsection
