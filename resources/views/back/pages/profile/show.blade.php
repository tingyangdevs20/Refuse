<!-- resources/views/back/pages/profile/show.blade.php -->

@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet"/>
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">
        <h1>Profile</h1>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.profile.update') }}" method="post">
            @csrf

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}">
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>


            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}">
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" name="password" id="password" class="form-control">
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm New Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $user->address) }}">
                @error('address')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="street">Street</label>
                <input type="text" name="street" id="street" class="form-control" value="{{ old('street', $user->street) }}">
                @error('street')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- <div class="form-group">
                <label for="state">State</label>
                <input type="text" name="state" id="state" class="form-control" value="{{ old('state', $user->state) }}">
                @error('state')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div> --}}

            <div class="form-group">
                <label for="city">City</label>
                <input type="text" name="city" id="city" class="form-control" value="{{ old('city', $user->city) }}">
                @error('city')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>


            <div class="form-group">
                <label for="zip">Zip</label>
                <input type="text" name="zip" id="zip" class="form-control" value="{{ old('zip', $user->zip) }}">
                @error('zip')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="mobile">Phone Number</label>
                <input type="text" name="mobile" id="mobile" class="form-control" value="{{ old('mobile', $user->mobile) }}">
                @error('mobile')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="website_link">Website Address</label>
                <input type="text" name="website_link" id="website_link" class="form-control" value="{{ old('website_link', $user->website_link) }}">
                @error('website_link')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Time Zone</label>
                <select class="custom-select" name="time_zone" id="time_zone">
                    <option value="0">Select Time Zone</option>

                        @foreach($timezones as $timezone)

                        @if($user->time_zone==$timezone->id)
                            <option selected value="{{ $timezone->id }}">{{ $timezone->time_zone }}</option>
                            @else
                            <option value="{{ $timezone->id }}">{{ $timezone->time_zone }}</option>

                            @endif
                        @endforeach

                </select>
            </div>



            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </div>
    </div>
@endsection
