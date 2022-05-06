@extends('admin.include.loginmain')
@section('title')
Register
@endsection
@section('content')
@php

$country = \GetCountry::getCountryCode();

@endphp

<div id="wrapper" class="auth-main">
    <div class="container">
        <div class="row clearfix">
            <div class="col-12">
                <nav class="navbar navbar-expand-lg">
                    <a class="navbar-brand" href="javascript:void(0);"><img src="{{ asset('assets/images/icon-light.svg')}}" width="30" height="30" class="d-inline-block align-top mr-2" alt="">Etsy Connector</a>
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="javascript:void(0);">Documentation</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{url('login')}}">Sign In</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-8">
                <div class="auth_detail">
                    <h2 class="text-monospace">
                        Everything<br> you need for
                        <div id="carouselExampleControls" class="carousel vert slide" data-ride="carousel" data-interval="1500">
                            <div class="carousel-inner">
                                <div class="carousel-item active">your Admin</div>
                                <div class="carousel-item">your Project</div>
                                <div class="carousel-item">your Dashboard</div>
                                <div class="carousel-item">your Application</div>
                                <div class="carousel-item">your Client</div>
                            </div>
                        </div>
                    </h2>
                    <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
                    <ul class="social-links list-unstyled">
                        <li><a class="btn btn-default" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="facebook"><i class="fa fa-facebook"></i></a></li>
                        <li><a class="btn btn-default" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="twitter"><i class="fa fa-twitter"></i></a></li>
                        <li><a class="btn btn-default" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="instagram"><i class="fa fa-instagram"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="header">
                        <p class="lead">Create an account</p>
                    </div>
                    <div class="body">
                        @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                        @endif
                        @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif
                        <form method="POST" action="{{ route('register') }}" class="form-auth-small">
                            @csrf
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col">
                                        <label for="name" class="control-label sr-only">{{ __('Name') }}</label>
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required placeholder="first name" autocomplete="name" autofocus>

                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <!-- </div>
                            
                                            <div class="form-group"> -->
                                        <label for="last_name" class="control-label sr-only">{{ __('Last Name') }}</label>
                                        <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required placeholder="last name" autocomplete="last_name" autofocus>

                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="signin-email" class="control-label sr-only">{{ __('Email Address') }}</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col">
                                        <label for="signin-email" class="control-label sr-only">{{ __('Contry Code') }}</label>
                                        <select class="form-select form-control" data-control="select2" data-placeholder="Please select" name="country_code" value="" id="code">
                                            <option value="">--Please Select--</option>

                                            @forelse($country as $nation)

                                            <option value="{{$nation->code}}" {{(old('country_code')==$nation->code)?'selected':''}}>{{$nation->code}}({{$nation->name}})</option>
                                            @empty
                                            <option value="">No country found</option>
                                            @endforelse

                                        </select>
                                        @if ($errors->has('country_code'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('code') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col">
                                        <label for="mobile" class="control-label sr-only">{{ __('Mobile') }}</label>
                                        <input type="number" class="form-control @error('mobile') is-invalid @enderror" id="mobile" name="mobile" value="{{ old('mobile') }}" required autocomplete="mobile" placeholder="mobile" autofocus>

                                        @error('mobile')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col">
                                        <label for="signin-password" class="control-label sr-only">{{ __('Password') }}</label>
                                        <input type="password" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="password" required autocomplete="current-password">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <!-- </div>
                                <div class="form-group"> -->
                                    <div class="col">
                                        <label for="password-confirm" class="control-label sr-only">{{ __('Confirm Password') }}</label>
                                        <input type="password" id="password-confirm" type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" placeholder="confirm password" required autocomplete="new-password">
                                        @error('password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg btn-block"> {{ __('Register') }}</button>
                                <div class="bottom">
                                    <span class="helper-text m-b-10"><i class="fa fa-lock"></i><a href="{{ route('password.request') }}"> {{ __('Forgot Your Password') }}</a></span>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection