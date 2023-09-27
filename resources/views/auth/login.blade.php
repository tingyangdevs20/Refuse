@extends('auth.inc.master')

@section('content')

<div class="account-pages my-5 pt-sm-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card overflow-hidden">
                    <div style="background:#666666">
                        <div class="row">
                            <div class="col-7">
                                <div class="text-primary p-4" >
                                    <h5  style="color:#38B6FF">Welcome Back !</h5>
                                    <p style="color:#ffffff">Sign in to continue to REIFuze.</p>
                                </div>
                            </div>


                            @if (session('status'))
                                <div class="col-12">
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-5 align-self-end">
                        <img src="{{ asset('back/assets/images/profile-img.png') }}" alt="" style="margin-left: -75%;margin-top: 21px;" class="img-fluid">
                    </div>
                    <div class="card-body pt-0">

                        <div class="p-2" id="dvLogin">
                            <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="mt-3">
                                    <button class="btn btn-primary btn-block waves-effect waves-light" style="background:#38B6FF;border-color:#38B6FF" type="submit">Log In</button>
                                </div>
                            </form>
                            <div class="mt-4 text-center" style="display: block">
                                <a href="#" onclick="forgot_password('login')" class="text-muted"><i class="mdi mdi-lock mr-1"></i> Forgot your password?</a>
                            </div>
                        </div>

                        <div class="p-2" id="dvforgot" style="display:none">
                            <form class="form-horizontal" method="POST" action="{{ route('password.email') }}" >
                                @csrf
                                <p style="font-weight:bold">Forgot Password</p>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input id="email" type="email" placeholder="Enter Registered Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>



                                <div class="mt-3">
                                    <button class="btn btn-primary btn-block waves-effect waves-light" style="background:#38B6FF;border-color:#38B6FF" type="submit">Submit</button>
                                </div>
                            </form>
                            <div class="mt-4 text-center" style="display: block">
                                <a href="#" onclick="forgot_password('forgot')" class="text-muted"><i class="mdi mdi-lock mr-1"></i>Back To Login </a>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="mt-5 text-center">

                    <div>
{{--                        <p>Don't have an account ? <a href="{{ route('register') }}" class="font-weight-medium text-primary"> Signup now </a> </p> --}}
                        <p>© 2023 REIFuze.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

<script>
    function forgot_password(ctrl)
    {
        //dvLogin
        if(ctrl=="login")
        {

        $("#dvforgot").show();
        $("#dvLogin").hide();
        }else{
            $("#dvforgot").hide();
        $("#dvLogin").show();
        }
    }
    </script>
