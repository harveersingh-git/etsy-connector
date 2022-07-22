@extends('admin.include.loginmain')
@section('title')
Register
@endsection
@section('content')
@php

$location = \CurrentLocation::getLocation();

@endphp
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
                        <li class="nav-item"><a class="nav-link" href="{{url('contect-us')}}"> {{__('messages.contact_us')}}</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{url('login')}}">Sign In</a></li>
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
                <div class="card sign-up-page-card">
                    <div class="header">
                        <p class="lead">{{__('messages.create_an_account')}}</p>
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
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required placeholder="first name" autocomplete="some-unrecognised-value" autofocus>

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
                                        <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required placeholder="last name" autocomplete="off" autofocus>

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
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autocomplete="some-unrecognised-value" placeholder="email" autofocus>

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
                                            <strong>{{ $errors->first('code') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col">
                                        <label for="mobile" class="control-label sr-only">{{ __('Mobile') }}</label>
                                        <input type="number" class="form-control @error('mobile') is-invalid @enderror" id="mobile" min="0" name="mobile" value="{{ old('mobile') }}" required autocomplete="some-unrecognised-value" placeholder="mobile" autofocus>

                                        @error('mobile')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="address" class="control-label sr-only">{{ __('Address') }}</label>
                                <!-- <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autocomplete="some-unrecognised-value" placeholder="email" autofocus> -->
                                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address') }}" required autocomplete="some-unrecognised-value" placeholder="Address">{{old('address')}}</textarea>
                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col">
                                        <label for="city" class="control-label sr-only">{{ __('City') }}</label>
                                        <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{(isset($location->cityName)) ? $location->cityName:old('city') }}" required placeholder="city" autocomplete="some-unrecognised-value" autofocus>

                                        @error('city')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <!-- </div>
                            
                                            <div class="form-group"> -->
                                        <label for="state" class="control-label sr-only">{{ __('state') }}</label>
                                        <input id="state" type="text" class="form-control @error('state') is-invalid @enderror" name="state" value="{{(isset($location->regionName)) ? $location->regionName:old('state') }}" required placeholder="state" autocomplete="some-unrecognised-value" autofocus>

                                        @error('state')
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
                                        <label for="zip" class="control-label sr-only">{{ __('Postal Code') }}</label>
                                        <input type="number" min="1" class="form-control @error('zip') is-invalid @enderror" id="zip" name="zip" value="{{(isset($location->zipCode)) ? $location->zipCode : old('zip') }}" required autocomplete="some-unrecognised-value" placeholder="postal code" autofocus>

                                        @error('mobile')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <label for="signin-email" class="control-label sr-only">{{ __('Contry') }}</label>
                                        <select class="select2-selection form-select form-control" data-control="select2" data-placeholder="Please select" name="country" value="" id="country">
                                            <option value="">--country--</option>

                                            @forelse($country as $nation)

                                            <option value="{{$nation->id}}" {{(ucfirst($nation->name)== $location->countryName)?'selected':''}}>{{$nation->name}}</option>
                                            @empty
                                            <option value="">No country found</option>
                                            @endforelse

                                        </select>
                                        @if ($errors->has('country'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('country') }}</strong>
                                        </span>
                                        @endif
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
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group clearfix">
                                            <label class="fancy-checkbox element-left">
                                                <input class="form-check-input" type="checkbox" name="business" id="business" {{ old('business') ? 'checked' : '' }}>
                                                <span> {{ __('messages.Business') }}</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col" id="tex_id_div" style="display: none;">
                                        <label for="password-confirm" class="control-label sr-only">{{ __('Tax ID') }}</label>
                                        <input type="text" id="tax_id" type="text" class="form-control @error('Tax ID') is-invalid @enderror" name="tax_id" placeholder="Tax ID  ">
                                        @if ($errors->has('tax_id'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('tax_id') }}</strong>
                                        </span>
                                        @endif
                                    </div>
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
@section('script')
<script>
    $(document).ready(function() {
        if ($('#business').is(':checked')) {
            $("#tex_id_div").show();
        } else {
            $('#tax_id').val('');
            $("#tex_id_div").hide();
        }
    });
    $('#business').click(function() {
        if ($(this).is(':checked')) {
            $("#tex_id_div").show();
        } else {
            $('#tax_id').val('');
            $("#tex_id_div").hide();
        }
    });

    $("#code").select2({
        placeholder: "Select a country code",
        allowClear: true
    });
    $("#country").select2({
        placeholder: "Select a country",
        allowClear: true
    });
</script>
@endsection
@endsection