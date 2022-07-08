@extends('admin.layout.head')

@section('content')




<div id="main-content">
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <h2>{{__('messages.edit_profile')}}</h2>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item active">{{__('messages.edit_profile')}}</li>
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
                                <!-- <h2>{{__('messages.edit_profile')}}</h2> -->
                            </span>
                        </h2>
                        <span> <a class="btn btn-primary" type="reset" href="{{url('/')}}"><i class="fa fa-arrow-left"></i>
                                {{__('messages.back')}}
                            </a></span>

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

                        <form class="form-horizontal" method="POST" action="{{ route('editProfile') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>  {{__('messages.name')}}<span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" name="name" placeholder="abc" value="{{$user->name}}" required>

                                        @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('name') }}</strong>
                                        </span>
                                        @endif

                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>  {{__('messages.last_name')}}<span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" name="last_name" placeholder="xyx" value="{{$user->last_name}}" required>

                                        @if ($errors->has('last_name'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('last_name') }}</strong>
                                        </span>
                                        @endif

                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>  {{__('messages.email')}}<span style="color: red;">*</span></label>
                                        <input type="email" class="form-control" name="email" placeholder="abc@gmail.com" value="{{$user->email}}" required>

                                        @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif

                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>  {{__('messages.mobile')}}<span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" name="mobile" placeholder="997487548" value="{{$user->mobile}}" required>

                                        @if ($errors->has('mobile'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('mobile') }}</strong>
                                        </span>
                                        @endif

                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>  {{__('messages.profile_image')}}</label>
                                        <input type="file" class="form-control" name="profile_image" value="">

                                        @if ($errors->has('profile_image'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('profile_image') }}</strong>
                                        </span>
                                        @endif

                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group pull-right">
                                        <a href="{{url('/')}}" class="btn btn-light mr-2">
                                            {{__('messages.back')}}
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-floppy-o" aria-hidden="true"></i> {{__('messages.save')}}
                                        </button>
                                    </div>
                                </div>








                            </div>
                        </form>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>
@endsection