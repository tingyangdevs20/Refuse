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
        @include('back.pages.partials.messages')
        <form action="{{ route('admin.profile.update') }}" method="post">
            @csrf
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
