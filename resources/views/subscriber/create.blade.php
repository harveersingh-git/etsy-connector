@extends('admin.layout.head')

@section('content')




<div id="main-content">
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <h2>Add Subscriber</h2>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item active"><a href="{{url('/subscriber')}}">Subscriber List</a></li>
                    <li class="breadcrumb-item active">Add Subscriber</li>
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
                        <h2>Add Subscriber</h2>
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
                                    <label for="first_name" class="control-label">First Name<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" name="first_name" placeholder="Ex:Jone" value="{{old('first_name')}}" required>

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
                                    <label for="last_name" class="control-label">Last Name<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" name="last_name" placeholder="Ex:Smith" value="{{old('last_name')}}" required>

                                    @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Email<span style="color: red;">*</span></label>
                                    <input type="email" class="form-control" name="email" placeholder="Ex:jons@yopmail.com" value="{{old('email')}}" required>

                                    @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6">

                                <div class="form-group">
                                    <label for="last_name" class="control-label">Country Code<span style="color: red;">*</span></label>
                                    <select class="form-select form-control" data-control="select2" data-placeholder="Please select" name="code" value="" id="code">
                                        <option value="">--Please Select--</option>

                                        @forelse($country as $nation)

                                        <option value="{{$nation->code}}">{{$nation->code}}({{$nation->name}})</option>
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
                                    <label for="last_name" class="control-label">mobile<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" name="mobile" placeholder="Ex:9985740000" value="{{old('mobile')}}">

                                    @if ($errors->has('mobile'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('mobile') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="last_name" class="control-label">City<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" name="city" placeholder="Ex:Melbourne" value="{{old('city')}}" required>

                                    @if ($errors->has('city'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="last_name" class="control-label">State<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" name="state" placeholder="Ex:Florida" value="{{old('state')}}">

                                    @if ($errors->has('state'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('state') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="last_name" class="control-label">Postal Code<span style="color: red;">*</span></label>
                                    <input type="number" min="1" class="form-control" name="zip" placeholder="Ex:32934" value="{{old('zip')}}" autocomplete="off" required>

                                    @if ($errors->has('zip'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('zip') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="country" class="control-label">Country<span style="color: red;">*</span></label>
                                    <!-- <input type="text" min="1" class="form-control" name="country" placeholder="Ex:United States" value="{{old('country')}}" autocomplete="off" required> -->
                                    <select class="form-select form-control" data-control="select2" data-placeholder="Please select" name="country" value="" id="country">
                                        <option value="">--Please Select--</option>

                                        @forelse($country as $nation)

                                        <option value="{{$nation->id}}">{{$nation->name}}</option>
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
                                    <label for="last_name" class="control-label">Password<span style="color: red;">*</span></label>
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
                                    <label for="last_name" class="control-label">Confirm Password<span style="color: red;">*</span></label>
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
                                        <span> Are you wants latest update by mail?</span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group pull-right">
                                    <a href="{{url('/subscriber')}}" class="btn btn-light">
                                        Back
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        Save
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