@extends('admin.include.loginmain')
@section('title')
Login@php

$country = \GetCountry::getCountryCode();
$location = \CurrentLocation::getLocation();
@endphp
@endsection
@section('content')
<style>
    .select2-container--default .select2-selection--single {
        border: 0px solid #aaa !important;
    }

    span#select2-code-container,
    span#select2-country-container {
        box-shadow: none;
        background-color: #fff;
        font-size: 14px;
        height: auto;
        display: block;
        width: 100%;
        height: calc(1.5em + 0.75rem + 2px);
        padding: 0.375rem 0.75rem;
        /* font-size: 1rem; */
        font-weight: 400;
        line-height: 1.5;
        /* color: #495057; */
        /* background-color: #fff; */
        /* background-clip: padding-box; */
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }
</style>
<div id="wrapper" class="auth-main">
    <div class="container">
        <div class="row clearfix">
            <div class="col-12">
                <nav class="navbar navbar-expand-lg">
                    <a class="navbar-brand" href="javascript:void(0);"><img src="{{ asset('assets/images/icon-light.svg')}}" width="30" height="30" class="d-inline-block align-top mr-2" alt="">Etsy Connector</a>
                    <ul class="navbar-nav">
                        @auth
                        <li class="nav-item"><a class="nav-link" href="{{url('home')}}"> {{__('messages.home')}}</a></li>

                        @else
                        <li class="nav-item"><a class="nav-link" href="{{url('login')}}"> {{__('messages.login')}}</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{url('register')}}">{{__('messages.sign_up')}}</a></li>


                        @endauth
                    </ul>
                </nav>
            </div>
            <div class="col-lg-8">
                <div class="auth_detail">
                    <h2 class="text-monospace">
                        {{__('messages.everything')}}<br>{{__('messages.you_need_for')}}
                        <div id="carouselExampleControls" class="carousel vert slide" data-ride="carousel" data-interval="1500">
                            <div class="carousel-inner">
                                <!-- <div class="carousel-item active">{{__('messages.you_admin')}}</div> -->
                                <div class="carousel-item">{{__('messages.you_project')}}</div>
                                <div class="carousel-item">{{__('messages.you_dashboard')}}</div>
                                <div class="carousel-item">{{__('messages.you_application')}}</div>
                                <div class="carousel-item">{{__('messages.you_client')}}</div>
                            </div>
                        </div>
                    </h2>
                    <p>{{__('messages.it_is_a_long')}}</p>
                    <ul class="social-links list-unstyled">
                    <li><a class="btn btn-default ig-btn-color" target="blank" href="https://besirious.net/" data-toggle="tooltip" data-placement="top" title="website"><i class="fa fa-globe"></i></a></li>
                        <li><a class="btn btn-default fb-btn-color" target="blank" href="https://www.facebook.com/beSIRIOus/" data-toggle="tooltip" data-placement="top" title="facebook"><i class="fa fa-facebook"></i></a></li>
                        <li><a class="btn btn-default tw-btn-color" target="blank" href="https://www.linkedin.com/company/besirious" data-toggle="tooltip" data-placement="top" title="linkedin"><i class="fa fa-linkedin"></i></a></li>
                        <li><a class="btn btn-default ig-btn-color" target="blank" href="https://www.youtube.com/channel/UCCw2Bcp7Yjn-66_0JqvStow" data-toggle="tooltip" data-placement="top" title="youtube"><i class="fa fa-youtube-play"></i></a></li>
                   
                    </ul>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card login-card-new">
                    <div class="header">
                        <p class="lead">{{__('messages.contact_us')}}</p>
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
                        <form class="form-auth-small" action="{{$url}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col">
                                        <label for="name" class="control-label sr-only">{{ __('messages.name') }}</label>
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required placeholder="name" autocomplete="some-unrecognised-value" autofocus>

                                        @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col">
                                        <!-- </div>
                            
                                            <div class="form-group"> -->
                                        <label for="email" class="control-label sr-only">{{ __('messages.email') }}</label>
                                        <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="email" autocomplete="off" autofocus>

                                        @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col">

                                        <label for="signin-email" class="control-label sr-only">{{ __('messags.country_code') }}</label>
                                        <select class="select2-selection form-select form-control" data-placeholder="Please select" name="country_code" value="" id="code">
                                            <option value="">-country code-</option>

                                            @forelse($country as $nation)

                                            <option value="{{$nation->code}}" {{(ucfirst($nation->name)== $location->countryName)?'selected':''}}>{{$nation->name}}({{$nation->code}})</option>
                                            @empty
                                            <option value="">No country found</option>
                                            @endforelse

                                        </select>
                                        @if ($errors->has('country_code'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('country_code') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col">
                                        <label for="mobile" class="control-label sr-only">{{ __('messages.mobile') }}</label>
                                        <input type="number" class="form-control @error('mobile') is-invalid @enderror" id="mobile" min="0" name="mobile" value="{{ old('mobile') }}" required autocomplete="some-unrecognised-value" placeholder="mobile" autofocus>

                                        @if ($errors->has('mobile'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('mobile') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="signin-subject" class="control-label sr-only">{{ __('messages.subject') }}</label>
                                <input type="subject" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" value="{{ old('subject') }}" required autocomplete="some-unrecognised-value" placeholder="subject" autofocus>

                                @if ($errors->has('subject'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('subject') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="signin-email" class="control-label sr-only">{{__('messages.message')}}</label>
                                <textarea class="form-control" rows="6" cols="30" required="" placeholder="Plese write your query here.." name="message"></textarea>
                                @if ($errors->has('message'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('message') }}</strong>
                                </span>
                                @endif
                            </div>



                            <button type="submit" class="btn btn-primary btn-lg btn-block"> {{ __('messages.send') }}</button>
                            <!-- <div class="text-center text-muted"> or continue with  </div> -->
                            <!-- <div class="row">
                                <div class="col-sm-12 col-md-12  text-center">
                                    <div class="">
                                        <a href="{{route('redirectToProvider', ['facebook'])}}" class="btn btn-primary btn-sm btn-width-equ fb-btn-color" data-toggle="tooltip" title="" data-original-title="Login with Facebook"> <i aria-hidden="true" class="fa fa-facebook"></i> </a>
                                        <a href="{{route('redirectToProvider', ['google'])}}" class="btn btn-secondary btn-sm btn-width-equ gplus-btn-color" data-toggle="tooltip" title="" data-original-title="Login with Google"> <i aria-hidden="true" class="fa fa-google-plus"></i> </a>
                                    </div>
                                </div>
                            </div> -->
                            <!-- <div class="bottom">
                                <span class="helper-text m-b-10"><i class="fa fa-lock"></i><a href="{{ route('password.request') }}"> {{ __('Forgot Your Password') }}</a></span>
                                <span>Don't have an account? <a href="{{url('register')}}">{{ __('Register') }}</a></span>
                            </div> -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('script')
<script>
    $("#code").select2({
        placeholder: "Select a country code",
        allowClear: true
    });
</script>
@endsection
@endsection