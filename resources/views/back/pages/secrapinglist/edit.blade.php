@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
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
                        <h4 class="mb-0 font-size-18">Data Management</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item">Data Management</li>
                                <li class="breadcrumb-item active">Edit Data</li>
                            </ol>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            Edit Data
                            <a href="{{ URL::previous() }}" class="btn btn-outline-primary btn-sm float-right"
                                title="New"><i class="fas fa-arrow-left"></i></a>
                            @include('components.modalform')
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('admin.scraping.update', @$scrapingdata->id) }}"
                                enctype="multipart/form-data">
                                @csrf <!-- CSRF Token -->

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="country">Country</label>
                                        <input type="text" class="form-control @error('country') is-invalid @enderror"
                                            id="country" name="country"
                                            value="{{ old('country', $scrapingdata->country) }}">
                                        @error('country')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="state">State</label>
                                        <input type="text" class="form-control @error('state') is-invalid @enderror"
                                            id="state" name="state" value="{{ old('state', $scrapingdata->state) }}">
                                        @error('state')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <input type="text" class="form-control @error('city') is-invalid @enderror"
                                            id="city" name="city" value="{{ old('city', $scrapingdata->city) }}">
                                        @error('city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="zip">Zip</label>
                                        <input type="number" class="form-control @error('zip') is-invalid @enderror"
                                            id="zip" name="zip" value="{{ old('zip', $scrapingdata->zip_code) }}">
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
                                            <option value="owner"
                                                {{ in_array('owner', (array) $scrapingdata->listing_type) ? 'selected' : '' }}>
                                                For Sale (by Owner)</option>
                                            <option value="agent"
                                                {{ in_array('agent', (array) $scrapingdata->listing_type) ? 'selected' : '' }}>
                                                Sale (By Agent)</option>
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
                                            <option value="100k-300k"
                                                {{ $scrapingdata->price_range == '100k-300k' ? 'selected' : '' }}>100k-300k
                                            </option>
                                            <option value="300k-600k"
                                                {{ $scrapingdata->price_range == '300k-600k' ? 'selected' : '' }}>300k-600k
                                            </option>

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
                                            <option value="1"
                                                {{ $scrapingdata->no_of_bedrooms == '1' ? 'selected' : '' }}>1</option>
                                            <option value="2"
                                                {{ $scrapingdata->no_of_bedrooms == '2' ? 'selected' : '' }}>2</option>
                                            <option value="3"
                                                {{ $scrapingdata->no_of_bedrooms == '3' ? 'selected' : '' }}>3</option>
                                            <option value="4"
                                                {{ $scrapingdata->no_of_bedrooms == '4' ? 'selected' : '' }}>4</option>
                                            <option value="5"
                                                {{ $scrapingdata->no_of_bedrooms == '5' ? 'selected' : '' }}>5</option>

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
                                            <option value="1"
                                                {{ $scrapingdata->no_of_bathrooms == '1' ? 'selected' : '' }}>1</option>
                                            <option value="2"
                                                {{ $scrapingdata->no_of_bathrooms == '2' ? 'selected' : '' }}>2</option>
                                            <option value="3"
                                                {{ $scrapingdata->no_of_bathrooms == '3' ? 'selected' : '' }}>3</option>
                                            <option value="4"
                                                {{ $scrapingdata->no_of_bathrooms == '4' ? 'selected' : '' }}>4</option>
                                            <option value="5"
                                                {{ $scrapingdata->no_of_bathrooms == '5' ? 'selected' : '' }}>5</option>

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
                                            <option value="Houses"
                                                {{ in_array('Houses', (array) $scrapingdata->property_type) ? 'selected' : '' }}>
                                                Houses</option>
                                            <option value="Townhomes"
                                                {{ in_array('Townhomes', (array) $scrapingdata->property_type) ? 'selected' : '' }}>
                                                Townhomes</option>
                                            <option value="Multi-Family"
                                                {{ in_array('Multi-Family', (array) $scrapingdata->property_type) ? 'selected' : '' }}>
                                                Multi-Family</option>
                                            <option value="Condos/Co-ops"
                                                {{ in_array('Condos/Co-ops', (array) $scrapingdata->property_type) ? 'selected' : '' }}>
                                                Condos/Co-ops</option>
                                            <option value="Lots/Land"
                                                {{ in_array('Lots/Land', (array) $scrapingdata->property_type) ? 'selected' : '' }}>
                                                Lots/Land</option>
                                            <option value="Apartments"
                                                {{ in_array('Apartments', (array) $scrapingdata->property_type) ? 'selected' : '' }}>
                                                Apartments</option>
                                            <option value="Manufactured"
                                                {{ in_array('Manufactured', (array) $scrapingdata->property_type) ? 'selected' : '' }}>
                                                Manufactured</option>
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
                                            <option value="pre-foreclousers"
                                                {{ $scrapingdata->filters == 'pre-foreclousers' ? 'selected' : '' }}>Pre
                                                Foreclousers</option>
                                            <option value="coming-soon"
                                                {{ $scrapingdata->filters == 1 ? 'selected' : 'coming-soon' }}>Coming Soon
                                            </option>

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
                                            name="job_name" value="{{ old('job_name', $scrapingdata->job_name) }}">
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
                                            <option value="1"
                                                {{ $scrapingdata->data_status == 1 ? 'selected' : '' }}>Active</option>
                                            <option value="0"
                                                {{ $scrapingdata->data_status == 0 ? 'selected' : '' }}>Inactive</option>

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

                                <button type="submit" class="btn btn-primary">Update Data</button>
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
