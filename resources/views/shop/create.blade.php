@extends('admin.layout.head')

@section('content')




<div id="main-content">
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <h2>{{__('messages.add_shop')}}</h2>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item active"><a href="{{url('/subscriber')}}">{{__('messages.subscriber')}}</a></li>
                    <li class="breadcrumb-item active"><a href="{{url('/shoplist')}}/{{$id}}">{{__('messages.shop_list')}}</a></li>

                    <li class="breadcrumb-item active">{{__('messages.add_shop')}}</li>
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
                    <div class="header">
                        <h2>{{__('messages.add_shop')}}</h2>
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
                        <form class="form-horizontal" method="POST" action="{{ $url}}">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{$id}}" name="id">
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="first_name" class="control-label">{{__('messages.app_url')}}</label>
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
                                    <div class="form-group">
                                        <label for="first_name" class="control-label">{{__('messages.shop_id')}}<span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" placeholder="Ex:spgp4n98ejs58585" name="shop_name" value="{{isset($user->shop_name)?($user->shop_name):''}}" required>

                                        @if ($errors->has('shop_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('shop_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="first_name" class="control-label">{{__('messages.user_name')}}<span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" name="user_name" placeholder="Ex:abc@yopmail.com" value="{{isset($user->user_name)?($user->user_name):''}}" required>

                                        @if ($errors->has('user_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('user_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="first_name" class="control-label">{{__('messages.country')}}</label>
                                        <select class="form-select form-control" data-control="select2" data-placeholder="Please select" name="country_id" value="" id="country">
                                            <option value="">--Please Select--</option>

                                            @forelse($country as $nation)

                                            <option value="{{$nation->id}}" {{ isset($user->country_id) && ( $user->country_id== $nation->id ) ? 'selected' : '' }}>{{$nation->name}}</option>
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
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="first_name" class="control-label">{{__('messages.store')}}</label>
                                        <input type="text" class="form-control" name="store" placeholder="Ex:abcshop" value="{{isset($user->store_id)?($user->store_id):''}}">

                                        @if ($errors->has('store'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('store') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12">
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
                                        <a href="{{ url('shoplist') }}/{{$id}}" class="btn btn-light">
                                            Back
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            Update
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