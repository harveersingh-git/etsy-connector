@extends('admin.layout.head')

@section('content')

<style>
    .select2-container--default .select2-selection--single {
        border: 0px solid #aaa !important;
    }

    span#select2-code-container {
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


<div id="main-content">
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12 ">
                <h2>{{__('messages.add_subscriber')}}</h2>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item active"><a href="{{url('/subscriber')}}">{{__('messages.subscriber_list')}}</a></li>
                    <li class="breadcrumb-item active">{{__('messages.add_subscriber')}}</li>
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
                            <!-- <span>
                                <h2>{{__('messages.add_subscriber')}}</h2>
                            </span> -->
                        </h2>
                        <span> <a class="btn btn-primary" type="reset" href="{{url('/subscriber')}}"><i class="fa fa-arrow-left"></i>
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
                        {!! Form::open(array('route' => 'subscriber.store','method'=>'POST')) !!}
                        {{ csrf_field() }}
                        <div class="row clearfix">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="first_name" class="control-label">{{__('messages.first_name')}}<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" name="first_name" placeholder="Ex:Jone" value="{{old('first_name')}}" autocomplete="some-unrecognised-value" required>

                                    @if ($errors->has('first_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                    @endif
                                    <!-- <span class="help-block">(999) 999-9999</span> -->
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="last_name" class="control-label">{{__('messages.last_name')}}<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" name="last_name" placeholder="Ex:Smith" value="{{old('last_name')}}" autocomplete="some-unrecognised-value" required>

                                    @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>{{__('messages.email')}}<span style="color: red;">*</span></label>
                                    <input type="email" class="form-control" name="email" placeholder="Ex:jons@yopmail.com" value="{{old('email')}}" autocomplete="some-unrecognised-value" required>

                                    @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6">

                                <div class="form-group">
                                    @php
                                    $countrycode = json_decode(file_get_contents(public_path() . '/' . 'countryCode/CountryCodes.json'));
                                    @endphp
                                    <label for="code" class="control-label">{{__('messages.country_code')}}<span style="color: red;">*</span></label>
                                    <select class="form-select form-control" data-control="select2" data-placeholder="Please select" name="code" value="" id="code">
                                        <option value="">--Please Select--</option>

                                        @forelse($countrycode as $nation)

                                        <option value="{{$nation->dial_code}}" {{($nation->dial_code==old('code')?'selected':'')}}>{{$nation->name}}({{$nation->dial_code}})</option>
                                        @empty
                                        <option value="">No country found</option>
                                        @endforelse

                                    </select>
                                    @if ($errors->has('code'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('code') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6">

                                <div class="form-group">
                                    <label for="mobile" class="control-label">{{__('messages.mobile')}}<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" name="mobile" placeholder="Ex:9985740000" value="{{old('mobile')}}" autocomplete="some-unrecognised-value" required>

                                    @if ($errors->has('mobile'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('mobile') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="address" class="control-label">{{__('messages.address')}}<span style="color: red;">*</span></label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address') }}" required autocomplete="some-unrecognised-value" placeholder="Address">{{isset($user->subscribe_details['address'])?$user->subscribe_details['address']:old('city')}}</textarea>
                                    @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="city" class="control-label">{{__('messages.city')}}<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" name="city" placeholder="Ex:Melbourne" value="{{old('city')}}" autocomplete="some-unrecognised-value" required>

                                    @if ($errors->has('city'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="last_name" class="control-label">{{__('messages.state')}}<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" name="state" placeholder="Ex:Florida" value="{{old('state')}}" autocomplete="some-unrecognised-value" required>

                                    @if ($errors->has('state'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('state') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="last_name" class="control-label">{{__('messages.postal_code')}}<span style="color: red;">*</span></label>
                                    <input type="number" min="1" class="form-control" name="zip" placeholder="Ex:32934" value="{{old('zip')}}" autocomplete="some-unrecognised-value" required>

                                    @if ($errors->has('zip'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('zip') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="country" class="control-label">{{__('messages.country')}}<span style="color: red;">*</span></label>
                                    <!-- <input type="text" min="1" class="form-control" name="country" placeholder="Ex:United States" value="{{old('country')}}" autocomplete="off" required> -->
                                    <select class="form-select form-control" data-control="select2" data-placeholder="Please select" name="country" value="" id="country">
                                        <option value="">--Please Select--</option>

                                        @forelse($country as $nation)

                                        <option value="{{$nation->id}}" {{($nation->id==old('country'))?'selected':''}}>{{$nation->name}}</option>
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
                                    <label for="last_name" class="control-label">{{__('messages.password')}}<span style="color: red;">*</span></label>
                                    <input type="password" class="form-control" name="password" placeholder="" value="{{old('password')}}">

                                    @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="last_name" class="control-label">{{__('messages.c_password')}}<span style="color: red;">*</span></label>
                                    <input type="password" class="form-control" name="password_confirmation" placeholder="" value="{{old('password_confirmation')}}">

                                    @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label class="fancy-checkbox ">
                                        <input class="form-check-input" type="checkbox" name="auto_email_update" id="auto_email_update">
                                        <span> {{__('messages.want_latest_update')}}</span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group pull-right">
                                    <a href="{{url('/subscriber')}}" class="btn btn-light">
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
    $("#code").select2({
        placeholder: "Select a country code",
        allowClear: true
    });
</script>
@endsection
@endsection