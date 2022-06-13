@extends('admin.layout.head')

@section('content')




<div id="main-content">
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <h2>{{__('messages.add_localization')}}</h2>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
                    <!-- <li class="breadcrumb-item active"><a href="{{url('/my-shop')}}">{{__('messages.myshop')}}</a></li> -->
                    <!-- <li class="breadcrumb-item active"><a href="{{url('/my-shop')}}">{{__('messages.myshop')}}</a></li> -->

                    <li class="breadcrumb-item active">{{__('messages.add_localization')}}</li>
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
                        <span>
                            <h2>
                                {{__('messages.add_localization')}}
                            </h2>
                            <span>Download a sample file click here <a href="{{url('/')}}/resources/lang/sample.txt" download="sample.txt" class="btn btn-info"><i class="fa fa-download" aria-hidden="true"></i> </a>
                            </span>
                        </span>
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
                        <form class="form-horizontal" method="POST" action="{{ $url}}" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="first_name" class="control-label">{{__('messages.name')}}<span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" name="name" placeholder="Ex:en" value="{{old('name')}}">

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
                                        <label for="first_name" class="control-label">{{__('messages.value')}}<span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" name="value" placeholder="Ex:english" value="{{old('value')}}" required>

                                        @if ($errors->has('key_string'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('key_string') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="file" class="control-label">{{__('messages.file')}}<span style="color: red;">*</span></label>
                                        <input type="file" class="form-control" name="file" placeholder="Ex:4fd7vtsfmclj0q5cg3ot0eyj" value="{{isset($user->file)?($user->file):''}}" required>

                                        @if ($errors->has('key_string'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('key_string') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12 ">

                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 ">
                                    <div class="form-group pull-right">
                                        <a href="{{ url('localization') }}" class="btn btn-light">
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