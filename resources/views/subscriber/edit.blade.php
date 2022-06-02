@extends('admin.layout.head')

@section('content')




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
                
                    <div class="header form-inline">
                        <h2 >{{__('messages.edit_subscriber')}}</h2>
                          <a href="{{url('/subscriber')}}" class="ml-2" >
                                        {{__('messages.back')}}
                                    </a>
                    </div>
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

                                        <option value="{{$nation->code}}" {{($nation->code==$user->country_code)?'selected':''}}>{{$nation->code}}({{$nation->name}})</option>
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
                                    <label class="fancy-checkbox ">
                                        <input class="form-check-input" type="checkbox" name="auto_email_update" id="auto_email_update" {{ isset($user->subscribe_details['auto_email_update']) &&  ($user->subscribe_details['auto_email_update']=='1') ? 'checked':''}}>
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

</script>
@endsection
@endsection