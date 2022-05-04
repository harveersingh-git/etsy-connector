@extends('admin.layout.head')

@section('content')




<div id="main-content">
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <h2>Edit Subscriber</h2>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item active">Edit Subscriber</li>
                </ul>
                <!-- <a href="javascript:void(0);" class="btn btn-sm btn-primary" title="">Create New</a> -->
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <div class="card">
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
                    {!! Form::model($user, ['method' => 'PATCH','route' => ['subscriber.update', $user->id]]) !!}
                
                    {{ csrf_field() }}
                    <div class="body">
                        <div class="row">
                            <div class="col-lg-6">
                                <label>First Name<span style="color: red;">*</span></label>
                                {!! Form::text('name', null, array('placeholder' => 'first name','class' => 'form-control')) !!}


                                @if ($errors->has('first_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-lg-6">
                                <label>Last Name<span style="color: red;">*</span></label>
                                {!! Form::text('last_name', null, array('placeholder' => 'last name','class' => 'form-control')) !!}

                                @if ($errors->has('last_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <label>Email<span style="color: red;">*</span></label>
                                {!! Form::text('email', null, array('placeholder' => 'email','class' => 'form-control')) !!}

                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-lg-6">
                                <label>mobile<span style="color: red;">*</span></label>
                                {!! Form::text('mobile', null, array('placeholder' => 'mobile','class' => 'form-control')) !!}

                                @if ($errors->has('mobile'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('mobile') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <label>Password<span style="color: red;">*</span></label>
                                <input type="password" class="form-control" name="password" placeholder="" value="{{old('password')}}" >

                                @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-lg-6">
                                <label>Confirm Password<span style="color: red;">*</span></label>
                                <input type="password" class="form-control" name="password_confirmation" placeholder="" value="{{old('password_confirmation')}}">

                                @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <label>City<span style="color: red;">*</span></label>
                                <input type="text" class="form-control" name="city" placeholder="" value="{{$user->subscribe_details['city']}}" required>

                                @if ($errors->has('city'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('city') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-lg-6">
                                <label>State<span style="color: red;">*</span></label>
                                <input type="text" class="form-control" name="state" placeholder="" value="{{$user->subscribe_details['state']}}">

                                @if ($errors->has('state'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('state') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="clearfix " style="margin-top: 30px;">

                                    <label class="fancy-checkbox ">
                                        <input class="form-check-input" type="checkbox" name="auto_email_update" id="auto_email_update" {{ ($user->subscribe_details['auto_email_update']=='1') ? 'checked':''}}>
                                        <span> Are you wants latest update by mail?</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>Postal Code<span style="color: red;">*</span></label>
                                <input type="number" min="1" class="form-control" name="zip" placeholder="" value="{{$user->subscribe_details['zip']}}" autocomplete="off" required>

                                @if ($errors->has('zip'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('zip') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>



                        <div class="row" style="margin-top: 10px;">
                            <div class="col-lg-6">
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


@section('script')
<script>

</script>
@endsection
@endsection