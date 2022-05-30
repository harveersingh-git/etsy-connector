@extends('admin.layout.head')

@section('content')




<div id="main-content">
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <h2>{{__('messages.edit_shop')}}</h2>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item active"><a href="{{url('/my-shop')}}">{{__('messages.myshop')}}</a></li>
                    <!-- <li class="breadcrumb-item active"><a href="#">{{__('messages.shop_list')}}</a></li> -->

                    <li class="breadcrumb-item active">{{__('messages.edit_shop')}}</li>
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
                        <h2>Etsy Config</h2>
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
                        <form class="form-horizontal" method="POST" action="{{ route('update-my-shop')}}">
                        {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{$data['id']}}" name="id">
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="first_name" class="control-label">{{__('messages.app_url')}}</label>
                                        <input type="text" class="form-control" name="app_url" placeholder="" value="{{isset($data->app_url)?($data->app_url):''}}">

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
                                        <input type="text" class="form-control" name="key_string" placeholder="" value="{{isset($data->key_string)?($data->key_string):''}}" required>

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
                                        <input type="text" class="form-control" name="shared_secret" placeholder="" value="{{isset($data->shared_secret)?($data->shared_secret):''}}" required>

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
                                        <input type="text" class="form-control" name="access_token_secret" placeholder="" value="{{isset($data->access_token_secret)?($data->access_token_secret):''}}">

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
                                        <input type="text" class="form-control" name="access_token" value="{{isset($data->access_token)?($data->access_token):''}}">

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
                                        <input type="text" class="form-control" name="shop_name" value="{{isset($data->shop_name)?($data->shop_name):''}}" required>

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
                                        <input type="text" class="form-control" name="user_name" placeholder="" value="{{isset($data->user_name)?($data->user_name):''}}" required>

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

                                            <option value="{{$nation->id}}" {{ isset($data->country_id) && ( $data->country_id== $nation->id ) ? 'selected' : '' }}>{{$nation->name}}</option>
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
                                        <input type="text" class="form-control" name="store" placeholder="" value="{{isset($data->store_id)?($data->store_id):''}}">

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
                                        <a href="{{ url('my-shop') }}" class="btn btn-light">
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