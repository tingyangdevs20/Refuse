<!-- resources/views/back/pages/profile/show.blade.php -->

@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />

    <style>
        .profileform {
            width: 60%;
        }
    </style>
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid ">

            <!-- start page title -->
            <div class="row">
                <div class="col-md-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">Contacts Management</h4>
                    </div>
                    <div class="card ">
                        <div class="card-header bg-soft-dark ">
                            Create New Contact
                            @include('components.modalform')
                        </div>
                        <div class="card-body p-5">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            <div class="col-md-7">
                                <form action="{{ route('admin.group.contact.store', $group->id) }}" class="" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="">Name</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" name="name" id="name" placeholder="First Name"
                                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                                                @error('name')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            {{-- <label for="name">Last Name</label> --}}
                                            <div class="form-group">
                                                <input type="text" name="last_name" placeholder="Last Name"
                                                    id="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}">
                                                @error('last_name')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- </div> -->
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="street">Property Address</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="text" name="street" placeholder="Property Address"
                                                    id="street" class="form-control" value="{{ old('street') }}">
                                                @error('street')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" placeholder="Property State" name="state"
                                                    id="state" class="form-control" value="{{ old('state') }}">
                                                @error('state')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">

                                            <div class="form-group">
                                                <input type="text" placeholder="Property City" name="city"
                                                    id="city" class="form-control" value="{{ old('city') }}">
                                                @error('city')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" placeholder="Property Zip" name="zip"
                                                    id="zip" class="form-control" value="{{ old('zip') }}">
                                                @error('zip')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="number">Phone Number</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" name="number" placeholder="Primary Phone Number"
                                                    id="number" class="form-control" value="{{ old('number') }}">
                                                @error('number')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" placeholder="Phone Number 2" name="number2"
                                                    id="number2" class="form-control" value="{{ old('number2') }}">
                                                @error('number2')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" placeholder="Phone Number 3" name="number3"
                                                    id="number3" class="form-control" value="{{ old('number3') }}">
                                                @error('number3')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="email">Email</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="email" name="email1" placeholder="Email 1" id="email"
                                                    class="form-control" value="{{ old('email1') }}">
                                                @error('email1')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="email" name="email2" placeholder="Email 2" id="email"
                                                    class="form-control" value="{{ old('email2') }}">
                                                @error('email2')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <div class="form-group">
                                        <label>Time Zone</label>
                                        <select class="custom-select" name="time_zone" id="time_zone">
                                            <option value="0">Select Time Zone</option>

                                            @foreach ($timezones as $timezone)
                                                @if ($user->time_zone == $timezone->id)
                                                    <option selected value="{{ $timezone->id }}">
                                                        {{ $timezone->time_zone }}</option>
                                                @else
                                                    <option value="{{ $timezone->id }}">{{ $timezone->time_zone }}
                                                    </option>
                                                @endif
                                            @endforeach

                                        </select>
                                    </div> --}}



                                    <button type="submit" class="btn btn-primary">Save</button>
                                </form>
                            </div>
                            <div class="col-md-5"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

        </div> <!-- container-fluid -->
    </div>
@endsection
