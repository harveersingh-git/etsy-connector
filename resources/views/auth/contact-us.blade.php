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
                        <li class="nav-item"><a class="nav-link" href="{{url('login')}}"> {{__('messages.login')}}</a></li>
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
                        <li><a class="btn btn-default fb-btn-color" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="facebook"><i class="fa fa-facebook"></i></a></li>
                        <li><a class="btn btn-default tw-btn-color" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="twitter"><i class="fa fa-twitter"></i></a></li>
                        <li><a class="btn btn-default ig-btn-color" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="instagram"><i class="fa fa-instagram"></i></a></li>
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
                        <form class="form-auth-small" action="#" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="signin-email" class="control-label sr-only">{{ __('Email Address') }}</label>
                                <textarea class="form-control" rows="8" cols="30" required="" placeholder="Plese write your query here.."></textarea>
                                <!-- <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autocomplete="off" placeholder="email" autofocus> -->

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
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

</script>
@endsection
@endsection