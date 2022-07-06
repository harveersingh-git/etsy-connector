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
                    <li class="breadcrumb-item active"><a href="{{url('/my-shop')}}">{{__('messages.myshop')}}</a></li>
                    <!-- <li class="breadcrumb-item active"><a href="{{url('/my-shop')}}">{{__('messages.myshop')}}</a></li> -->

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
                    <div class="header" style=" display: flex; justify-content: space-between;">
                        <h2>
                            <span>
                                <!-- <h2>{{__('messages.add_shop')}}</h2> -->
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
                        <form class="form-horizontal" method="POST" action="{{ $url}}">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{$id}}" name="id">
                            <div class="row clearfix">



                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="first_name" class="control-label mr-1">{{__('messages.shop_id')}}<span style="color: red;">*</span></label>
                                        <span class="tooltips">
                                            <i class="fa fa-question-circle" aria-hidden="true"></i>
                                            <span class="tooltiptext"><a href="https://app.cartrover.com/get_etsy_shop_id.php" style="color:#fff" target="blank">{{__('messages.Click here to get your shop ID')}}</a> </span>

                                        </span>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Ex:spgp4n98ejs58585" name="shop_name" value="{{isset($user->shop_name)?($user->shop_name):old('shop_name')}}" id="shop_name" autocomplete="off" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="verify_shop_id">{{__('messages.verify_shop_id')}}</span>
                                            </div>
                                        </div>
                                        @if ($errors->has('shop_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('shop_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="first_name" class="control-label">{{__('messages.user_name')}}<span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" name="user_name" placeholder="Ex:abc@yopmail.com" value="{{isset($user->user_name)?($user->user_name):old('user_name')}}" required>

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
                                        <input type="text" class="form-control" name="store" placeholder="Ex:abcshop" value="{{isset($user->store_id)?($user->store_id):old('store')}}">

                                        @if ($errors->has('store'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('store') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div> -->

                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <label for="first_name" class="control-label">{{__('messages.default_language')}}<span style="color: red;">*</span></label>
                                    <select class="select2-selection select2-selection--single form-select form-control" name="language" id="language">

                                        <option value="en" {{ isset($data->language) && ( $data->language== 'en' ) ? 'selected' : '' }}>English</option>
                                        <option value="de" {{ isset($data->language) && ( $data->language== 'de' ) ? 'selected' : '' }}>German</option>
                                        <option value="es" {{ isset($data->language) && ( $data->language== 'es' ) ? 'selected' : '' }}>Spanish</option>
                                        <option value="fr" {{ isset($data->language) && ( $data->language== 'fr' ) ? 'selected' : '' }}>French</option>
                                        <option value="it" {{ isset($data->language) && ( $data->language== 'it' ) ? 'selected' : '' }}>Italian</option>
                                        <option value="ja" {{ isset($data->language) && ( $data->language== 'ja' ) ? 'selected' : '' }}>Japanese</option>
                                        <option value="nl" {{ isset($data->language) && ( $data->language== 'nl' ) ? 'selected' : '' }}>Dutch</option>
                                        <option value="pl" {{ isset($data->language) && ( $data->language== 'pl' ) ? 'selected' : '' }}>Polish</option>
                                        <option value="pt" {{ isset($data->language) && ( $data->language== 'pt' ) ? 'selected' : '' }}>Portuguese</option>
                                        <option value="ru" {{ isset($data->language) && ( $data->language== 'ru' ) ? 'selected' : '' }}>Russian</option>
                                    </select>
                                </div>
                                <!--<div class="col-lg-6 col-md-6 col-sm-12">
                                     <div class="form-group">
                                        <button type="button" class="btn btn-primary" id="access_code_url">
                                            Generate Token And Authorize
                                        </button>
                                    </div> 
                                </div>-->
                                <!--<div class="col-lg-6 col-md-6 col-sm-12">
                                     <div class="form-group">
                                        <button type="button" class="btn btn-primary" id="access_code_url">
                                            Generate Token And Authorize
                                        </button>
                                    </div> 
                                </div>-->
                                <div class="col-lg-12 col-md-12 col-sm-12 save-update-btn">
                                    <div class="form-group  pull-right">
                                        <a href="{{ url('my-shop') }}" class="btn btn-light">
                                            {{__('messages.back')}}
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-floppy-o" aria-hidden="true"></i> {{__('messages.save')}}
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
    $(document).on('keyup', '#shop_name', function() {
        $('#verify_shop_id').html('<i class="fa fa-refresh fa-spin">');
        var value = $(this).val();
        $.ajax({
            type: "POST",
            url: "{{url('verify_shop_id')}}",
            data: {
                _token: '{{csrf_token()}}',
                value: value
            },
            beforeSend: function() {

            },
            success: function(data) {
                console.log('data', data.status);
                if (data.status == 'success') {
                    $('#verify_shop_id').html('<i class="fa fa-check" aria-hidden="true" style="color:green"></i>');
                } else {
                    $('#verify_shop_id').html('<i class="fa fa-close" style="color:red"></i>');
                }

            },
            error: function(textStatus, errorThrown) {
                $('#verify_shop_id').html('<i class="fa fa-close" style="color:red"></i>');
            }
        });


    });
</script>
@endsection
@endsection