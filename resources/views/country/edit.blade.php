@extends('admin.layout.head')

@section('content')




<div id="main-content">
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <h2>{{__('messages.Edit Country')}}</h2>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item active"><a href="{{url('/country')}}">{{__('messages.Country List')}}</a></li>
                    <li class="breadcrumb-item active">{{__('messages.Edit Country')}}</li>
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
                                {{__('messages.Edit Country')}}
                            </span>
                        </h2>
                        <span> <a class="btn btn-primary" type="reset" href="{{url()->previous() }}"><i class="fa fa-arrow-left"></i>
                                {{__('messages.back')}}
                            </a></span>

                    </div>
                    <div class="body">
                        {!! Form::model($user, ['method' => 'PATCH','route' => ['country.update', $user->id]]) !!}

                        {{ csrf_field() }}
                        <div class="row clearfix">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="name" class="control-label">{{__('messages.Country Name')}}<span style="color: red;">*</span></label>

                                    {!! Form::text('name', null, array('placeholder' => 'Ex:India','class' => 'form-control')) !!}

                                    @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                    <!-- <span class="help-block">(999) 999-9999</span> -->
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="code" class="control-label">{{__('messages.country_code')}}<span style="color: red;">*</span></label>
                                    {!! Form::text('code', null, array('placeholder' => 'Ex:+91','class' => 'form-control')) !!}

                                    @if ($errors->has('code'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('code') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="col-lg-6 col-md-6 col-sm-12">
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group pull-right">
                                    <a href="{{url('/country')}}" class="btn btn-light">
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