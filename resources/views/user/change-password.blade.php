@extends('admin.layout.head')

@section('content')




<div id="main-content">
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <h2>{{__('messages.current_password')}}</h2>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item active">{{__('messages.current_password')}}</li>
                </ul>
                <!-- <a href="javascript:void(0);" class="btn btn-sm btn-primary" title="">Create New</a> -->
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <div class="card">

                    <div class="header" style=" display: flex; justify-content: space-between;">
                        <h2>
                            <span>
                                <!-- <h2>{{__('messages.current_password')}}</h2> -->
                            </span>
                        </h2>
                        <span> <a class="btn btn-primary" type="reset" href="{{url('/')}}"><i class="fa fa-arrow-left"></i>
                                {{__('messages.back')}}
                            </a></span>

                    </div>
                    <!-- <div class="header form-inline">
                        <h2>{{__('messages.current_password')}}</h2>
                        <a href="{{url('/')}}" class="ml-2">
                            {{__('messages.back')}}
                        </a>
                    </div> -->
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

                        <form class="form-horizontal" method="POST" action="{{ route('changePassword') }}"> {{ csrf_field() }}
                            <form class="form-horizontal" method="POST" action="{{ route('changePassword') }}">
                                {{ csrf_field() }}

                                <div class="row clearfix">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label> {{__('messages.current_password')}}<span style="color: red;">*</span></label>
                                            <input id="current-password" type="password" class="form-control" name="current-password" placeholder="current-password" required>

                                            @if ($errors->has('current-password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('current-password') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label> {{__('messages.new_password')}}<span style="color: red;">*</span></label>
                                            <input id="new-password" type="password" class="form-control" name="new-password" placeholder="new password" required>

                                            @if ($errors->has('new-password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('new-password') }}</strong>
                                            </span>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label> {{__('messages.confirm_password')}}<span style="color: red;">*</span></label>
                                            <input id="new-password-confirm" type="password" class="form-control" name="new-password_confirmation" placeholder="confirm-password" required>


                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 pull-right">
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-12 pull-right">
                                        <div class="form-group ">
                                            <a href="{{url('/')}}" class="btn btn-light mr-2">
                                                {{__('messages.back')}}
                                            </a>
                                            <button type="submit" class="btn btn-primary">
                                                {{__('messages.save')}}
                                            </button>
                                        </div>
                                    </div>

                                </div>

                            </form>
                        </form>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>
@endsection