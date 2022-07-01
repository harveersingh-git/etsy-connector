@extends('admin.include.loginmain')
@section('title')
Login
@endsection
@section('content')
<div id="wrapper" class="auth-main">
    <div class="container">
        <div class="row clearfix">
            <div class="col-12">
                <nav class="navbar navbar-expand-lg">
                    <a class="navbar-brand" href="javascript:void(0);"><img src="{{ asset('assets/images/icon-light.svg')}}" width="30" height="30" class="d-inline-block align-top mr-2" alt="">Etsy Connector</a>
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="javascript:void(0);"> {{__('messages.documentation')}}</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{url('register')}}">{{__('messages.sign_up')}}</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-8">
                <div class="auth_detail">
                    <h2 class="text-monospace">
                        {{__('messages.everything')}}<br>{{__('messages.you_need_for')}}
                        <div id="carouselExampleControls" class="carousel vert slide" data-ride="carousel" data-interval="1500">
                            <div class="carousel-inner">
                                <div class="carousel-item active">{{__('messages.you_admin')}}</div>
                                <div class="carousel-item">{{__('messages.you_project')}}</div>
                                <div class="carousel-item">{{__('messages.you_dashboard')}}</div>
                                <div class="carousel-item">{{__('messages.you_application')}}</div>
                                <div class="carousel-item">{{__('messages.you_client')}}</div>
                            </div>
                        </div>
                    </h2>
                    <p>{{__('messages.it_is_a_long')}}</p>
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
                        <p class="lead">{{__('messages.login_to_your_account')}}</p>
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
                        <form class="form-auth-small" action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="signin-email" class="control-label sr-only">{{ __('Email Address') }}</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autocomplete="off" placeholder="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="signin-password" class="control-label sr-only">{{ __('Password') }}</label>
                                <input type="password" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="password" required autocomplete="current-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group clearfix">
                                <label class="fancy-checkbox element-left">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <span> {{ __('Remember Me') }}</span>
                                </label>
                            </div>
                            <button type="button" class="btn btn-primary btn-lg btn-block" id="resened_btn"> {{ __('Resend Link') }}</button>

                            <button type="submit" class="btn btn-primary btn-lg btn-block"> {{ __('Login') }}</button>
                            <div class="text-center text-muted"> or continue with  </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12  text-center">
                                    <div class="">
                                        <a href="{{route('redirectToProvider', ['facebook'])}}" class="btn btn-primary btn-sm btn-width-equ" data-toggle="tooltip" title="" data-original-title="Login with Facebook"> <i aria-hidden="true" class="fa fa-facebook"></i> </a>
                                        <a href="{{route('redirectToProvider', ['google'])}}" class="btn btn-secondary btn-sm btn-width-equ" data-toggle="tooltip" title="" data-original-title="Login with Google"> <i aria-hidden="true" class="fa fa-google-plus"></i> </a>
                                    </div>
                                </div>
                            </div>
                            <div class="bottom">
                                <span class="helper-text m-b-10"><i class="fa fa-lock"></i><a href="{{ route('password.request') }}"> {{ __('Forgot Your Password') }}</a></span>
                                <span>Don't have an account? <a href="{{url('register')}}">{{ __('Register') }}</a></span>
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
    $(window).on('load', function() {
        var error = $('.invalid-feedback').find('strong').text();
        if (error == "The selected email is invalid or the account has not been verified or enable.") {
            $('#resened_btn').show();
        } else {
            $('#resened_btn').hide();
        }
    });
    $(document).on('click', '#resened_btn', function() {
        var current = $(this);
        current.text('Please wait..');
        current.prop('disabled', true);
        var email = $('#email').val();
        if (typeof email !== 'undefined') {
            $.ajax({
                type: "POST",
                url: "{{url('resend')}}",
                data: {
                    _token: '{{csrf_token()}}',
                    email: email
                },
                beforeSend: function() {

                },
                success: function(data) {
                    current.text(' Resend Link');
                    console.log('success', data);
                    current.prop('disabled', false);
                    toastr.success("Re-send the Email verification link on your email id please check.");
                    // window.location.reload();
                }
            });
        } else {
            toastr.error("Please provide a email id");
        }

    })
</script>
@endsection
@endsection