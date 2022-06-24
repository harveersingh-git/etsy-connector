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
            <div class="col-md-6 col-sm-12">
                <h2>{{__('messages.edit_subscriber')}}</h2>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item active"><a href="{{url('/subscriber')}}">{{__('messages.subscriber_list')}}</a></li>
                    <li class="breadcrumb-item active">{{__('messages.edit_subscriber')}}</li>
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
                    <!-- <div class="header">

                        <h2>{{__('messages.edit_subscriber')}}</h2>
                        <a style="float: right;margin-top: -22px;" class="btn btn-primary" type="reset" href="{{url('/subscriber')}}"><i class="fa fa-arrow-left"></i>
                            {{__('messages.back')}}
                        </a>
                    </div> -->

                    <div class="body">
                        {!! Form::model($user, ['method' => 'PATCH','route' => ['subscriber.update', $user->id]]) !!}

                        {{ csrf_field() }}
                        <div class="row clearfix">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="first_name" class="control-label">{{__('messages.first_name')}}<span style="color: red;">*</span></label>

                                    {!! Form::text('name', null, array('placeholder' => 'first name','class' => 'form-control')) !!}

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
                                    {!! Form::text('last_name', null, array('placeholder' => 'last name','class' => 'form-control')) !!}

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
                                    {!! Form::text('email', null, array('placeholder' => 'email','class' => 'form-control')) !!}

                                    @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6">

                                <div class="form-group">

                                    <label for="last_name" class="control-label">{{__('messages.country_code')}}<span style="color: red;">*</span></label>
                                    <select class="form-select form-control" data-control="select2" data-placeholder="Please select" name="code" value="" id="code">
                                        <option value="">--Please Select--</option>

                                        @forelse($country as $nation)

                                        <option value="{{$nation->code}}" {{($nation->code==$user->country_code)?'selected':''}}>{{$nation->name}}({{$nation->code}})</option>
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
                                    <label for="last_name" class="control-label">{{__('messages.mobile')}}<span style="color: red;">*</span></label>
                                    {!! Form::text('mobile', null, array('placeholder' => 'mobile','class' => 'form-control')) !!}

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
                                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="" required autocomplete="some-unrecognised-value" placeholder="Address">{{isset($user->subscribe_details['address'])?$user->subscribe_details['address']:old('city')}}</textarea>
                                    @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="last_name" class="control-label">{{__('messages.city')}}<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" name="city" placeholder="" value="{{isset($user->subscribe_details['city'])?$user->subscribe_details['city']:old('city')}}" required>
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
                                    <input type="text" class="form-control" name="state" placeholder="" value="{{isset($user->subscribe_details['state'])?$user->subscribe_details['state']:old('state')}}">
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
                                    <input type="number" min="1" class="form-control" name="zip" placeholder="" value="{{isset($user->subscribe_details['zip'])?$user->subscribe_details['zip']:old('zip')}}" autocomplete="off" required>
                                    @if ($errors->has('zip'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('zip') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="last_name" class="control-label">{{__('messages.country')}}<span style="color: red;">*</span></label>
                                    <select class="form-select form-control" data-control="select2" data-placeholder="Please select" name="country" value="" id="country">
                                        <option value="">--Please Select--</option>

                                        @forelse($country as $nation)

                                        <option value="{{$nation->id}}" {{ isset($user->subscribe_details['country_id']) && ( $user->subscribe_details['country_id']== $nation->id ) ? 'selected' : '' }}>{{$nation->name}}</option>
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
                                    <div class="form-row">
                                        <div class="col">
                                            <div class="form-group clearfix">
                                                <label class="fancy-checkbox element-left">
                                                    <input class="form-check-input" type="checkbox" name="business" id="business" {{ isset($user['business_account']) &&  ($user['business_account']=='1') ? 'checked':''}}>
                                                    <span> {{ __('messages.Business') }}</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col" id="tex_id_div" >
                                            <label for="password-confirm" class="control-label sr-only">{{ __('Tax ID') }}</label>
                                            <input type="text" id="tax_id" type="text" class="form-control @error('Tax ID') is-invalid @enderror" name="tax_id" placeholder="Tax ID " value="{{ isset($user['tax_id']) ? $user['tax_id']:''}}"/>
                                            @if ($errors->has('tax_id'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('tax_id') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label class="fancy-checkbox ">
                                        <input class="form-check-input" type="checkbox" name="auto_email_update" id="auto_email_update" {{ isset($user->subscribe_details['auto_email_update']) &&  ($user->subscribe_details['auto_email_update']=='1') ? 'checked':''}}>
                                        <span> {{__('messages.want_latest_update')}}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group pull-right">
                                    <a href="{{url('/subscriber')}}" class="btn btn-light">
                                        {{__('messages.back')}}
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        {{__('messages.update')}}
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
</script>
@endsection
@endsection