@extends('admin.include.loginmain')

@section('content')
<div id="wrapper" class="auth-main">
    <div class="container">
        <div class="row clearfix">
            <div class="col-12">
                <nav class="navbar navbar-expand-lg">
                    <a class="navbar-brand" href="javascript:void(0);"><img src="{{asset('assets/images/icon-light.svg')}}" width="30" height="30" class="d-inline-block align-top mr-2" alt="">Etsy Connector</a>
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="{{url('contect-us')}}"> {{__('messages.contact_us')}}</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{url('login')}}">{{__('messages.login')}}</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-8">
                <div class="auth_detail">
                    <h2 class="text-monospace">
                        {{__('messages.everything')}}<br>{{__('messages.you_need_for')}}
                        <div id="carouselExampleControls" class="carousel vert slide" data-ride="carousel" data-interval="1500">
                            <div class="carousel-inner">
                                <!-- <div class="carousel-item active">your Admin</div> -->
                                <div class="carousel-item">your Project</div>
                                <div class="carousel-item">your Dashboard</div>
                                <div class="carousel-item">your Application</div>
                                <div class="carousel-item">your Client</div>
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
                        <p class="lead">Recover my password</p>
                    </div>
                    <div class="body">
                        <p>Please enter your new valid password and confirm password.</p>
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required placeholder="email" autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="password" required autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="confirm password" required autocomplete="new-password">

                            </div>
                            <button type="submit" class="btn btn-primary">
                                {{ __('Reset Password') }}
                            </button>
                            <div class="bottom">
                                <span class="helper-text">Know your password? <a href="{{url('/')}}">Login</a></span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection