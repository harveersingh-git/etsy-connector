@extends('admin.layout.head')

@section('content')




<div id="main-content">
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <h2>{{__('messages.add_etsy_setting')}}</h2>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item active"><a href="{{url('/etsy-setting')}}">{{__('messages.etsy_setting')}}</a></li>
                    <!-- <li class="breadcrumb-item active"><a href="{{url('/my-shop')}}">{{__('messages.myshop')}}</a></li> -->

                    <li class="breadcrumb-item active">{{__('messages.add_etsy_setting')}}</li>
                </ul>
                <!-- <a href="javascript:void(0);" class="btn btn-sm btn-primary" title="">Create New</a> -->
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <!-- Color Pickers -->


        <!-- Masked Input -->
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card">
                    <div class="header" style=" display: flex; justify-content: space-between;">
                        <h2>
                            <span>
                                <!-- <h2>{{__('messages.add_etsy_setting')}}</h2> -->
                            </span>
                        </h2>
                        <span> <a class="btn btn-primary" type="reset" href="{{url()->previous() }}"><i class="fa fa-arrow-left"></i>
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
                        {!! Form::open(array('route' => 'etsy-setting.store','method'=>'POST')) !!}
                        {{ csrf_field() }}
                           
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="first_name" class="control-label">{{__('messages.app_url')}}<span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" name="app_url" placeholder="Ex:https://openapi.etsy.com/v2/" value="{{isset($user->app_url)?($user->app_url):''}}">

                                        @if ($errors->has('app_url'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('app_url') }}</strong>
                                        </span>
                                        @endif
                                        <!-- <span class="help-block">(999) 999-9999</span> -->
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="first_name" class="control-label">{{__('messages.key_string')}}<span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" name="key_string" placeholder="Ex:4fd7vtsfmclj0q5cg3ot0eyj" value="{{isset($user->key_string)?($user->key_string):''}}" required>

                                        @if ($errors->has('key_string'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('key_string') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="first_name" class="control-label">{{__('messages.shared_secret')}}<span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" name="shared_secret" placeholder="Ex:v1cot8y888" value="{{isset($user->shared_secret)?($user->shared_secret):''}}" required>

                                        @if ($errors->has('shared_secret'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('shared_secret') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="first_name" class="control-label">{{__('messages.access_token_secret')}}</label>
                                        <input type="text" class="form-control" name="access_token_secret" placeholder="Ex:8000000f335565ee1c17310746e047" value="{{isset($user->access_token_secret)?($user->access_token_secret):''}}">

                                        @if ($errors->has('access_token_secret'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('access_token_secret') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="first_name" class="control-label">{{__('messages.access_token')}}</label>
                                        <input type="text" class="form-control" placeholder="Ex:8039f62f335565ee1c17310000000" name="access_token" value="{{isset($user->access_token)?($user->access_token):''}}">

                                        @if ($errors->has('access_token'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('access_token') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            

                              
                           
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <!-- <div class="form-group">
                                        <button type="button" class="btn btn-primary" id="access_code_url">
                                            Generate Token And Authorize
                                        </button>
                                    </div> -->
                                </div>

             

                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <!-- <div class="form-group">
                                        <button type="button" class="btn btn-primary" id="access_code_url">
                                            Generate Token And Authorize
                                        </button>
                                    </div> -->
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group  pull-right">
                                        <a href="{{ url('etsy-setting') }}" class="btn btn-light">
                                            {{__('messages.back')}}
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            {{__('messages.save')}}
                                        </button>
                                    </div>
                                </div>

                            </div>
                            {!! Form::close() !!}
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