@extends('admin.layout.head')

@section('content')




<div id="main-content">
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <h2>{{__('messages.edit_shop_list')}}</h2>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item active"><a href="{{url('/subscriber')}}">{{__('messages.subscriber')}}</a></li>
                    <li class="breadcrumb-item active"><a href="#">{{__('messages.shop_list')}}</a></li>

                    <li class="breadcrumb-item active">{{__('messages.edit_shop_list')}}</li>
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
                    <div class="">
                        <div class="header" style=" display: flex; justify-content: space-between;">
                            <h2>
                                <!-- <span>
                                <h2>{{__('messages.add_subscriber')}}</h2>
                            </span> -->
                            </h2>
                            <span> <a class="btn btn-primary" type="reset" href="{{ url('shoplist') }}/{{$data['user_id']}}"><i class="fa fa-arrow-left"></i>
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
                            <form class="form-horizontal" method="POST" action="{{ route('updateshop')}}">
                                {{ csrf_field() }}
                                <input type="hidden" name="id" value="{{$data['id']}}" id="id">
                                <div class="row clearfix">
                                    <!-- <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="first_name" class="control-label">{{__('messages.app_url')}}<span style="color: red;">*</span></label>
                                            <input type="text" class="form-control" name="app_url" placeholder="" value="{{isset($data->app_url)?($data->app_url):''}}">

                                            @if ($errors->has('app_url'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('app_url') }}</strong>
                                            </span>
                                            @endif
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
                                    </div> -->
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="first_name" class="control-label">{{__('messages.shop_id')}}<span style="color: red;">*</span></label>
                                            <span class="tooltips">
                                                <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                <span class="tooltiptext"><a href="https://app.cartrover.com/get_etsy_shop_id.php" style="color:#fff" target="blank"> click Here..</a> </span>
                                            </span>
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
                                        <label for="first_name" class="control-label">{{__('messages.default_language')}}</label>
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
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">

                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <!-- <button type="button" class="btn btn-primary" id="access_code_url">

                                                {{__('messages.generate_token_and_authorize')}}
                                            </button> -->
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group  pull-right">
                                            <a href="{{ url('shoplist') }}/{{$data['user_id']}}" class="btn btn-light">
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





    <div class="modal fade" id="url_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Access Url </h5>


                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div>

                    <p style="color: red; margin-left: 43px;"> Click the below link and provide the access code.<a href="#" target="_blank" id="url">Click Here...</a></p>

                </div>
                <div class="modal-body">
                    <div class="form-group">

                        <label for="recipient-name" class="col-form-label">Access code:</label>
                        <input type="text" class="form-control" id="access_code" required="" name="access_code" placeholder="fe0bd040">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="verify_token">Update</button>
                </div>
            </div>
        </div>
    </div>

    @section('script')
    <script>
        $('#access_code_url').on('click', function() {
            var token = $('input[name="_token"]').attr('value');
            var id = $('#id').val();

            var data = {
                id: id
            };
            $.ajax({
                type: 'POST',
                url: base_url + '/get_access_code_url',
                contentType: 'application/json',
                dataType: 'json',
                data: JSON.stringify(data),
                headers: {
                    'X-CSRF-Token': token
                },

                success: function(result) {
                    if (result.status == "success") {
                        $('#url_model').modal('toggle');
                        $("#url").attr('href', result.data)
                    } else {
                        toastr.error("please check Key String and Shared Secret");
                    }


                },
                error: function(xhr, status, error) {
                    alert("Error!" + xhr.status);
                },
            })
        });

        $('#verify_token').on('click', function() {
            var token = $('input[name="_token"]').attr('value');
            var access_token = $('#access_code').val();
            var id = $('#id').val();
            if (access_token) {
                var data = {
                    verify_token: access_token,
                    id: id
                };
                $.ajax({
                    type: 'POST',
                    url: base_url + '/verify_access_code',
                    contentType: 'application/json',
                    dataType: 'json',
                    data: JSON.stringify(data),
                    headers: {
                        'X-CSRF-Token': token
                    },

                    success: function(result) {
                        if (result.status == "success") {
                            $('#url_model').modal('toggle');
                            $("#url").attr('href', '#')
                            toastr.success("Record insert successfully");
                            window.location.reload();
                        } else {
                            toastr.error("please check Key String and Shared Secret");
                            // alert('please check Key String and Shared Secret');
                        }


                    },
                    error: function(xhr, status, error) {
                        alert("Error!" + xhr.status);
                    },
                })
            }
        });
    </script>
    @endsection
    @endsection