@extends('admin.layout.head')

@section('content')




<div id="main-content">
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <h2>Etsy Config</h2>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
                    <!-- <li class="breadcrumb-item active"><a href="{{url('/subscriber')}}">Subscriber List</a></li> -->
                    <li class="breadcrumb-item active">Etsy Config</li>
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
                        <form class="form-horizontal" method="POST" action="{{ route('etsyConfig') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{$id}}">
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="first_name" class="control-label">App Url</label>
                                        <input type="text" class="form-control" name="app_url" placeholder="" value="{{isset($user->app_url)?($user->app_url):''}}">

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
                                        <label for="first_name" class="control-label">Key String<span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" name="key_string" placeholder="" value="{{isset($user->key_string)?($user->key_string):''}}" required>

                                        @if ($errors->has('key_string'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('key_string') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="first_name" class="control-label">Shared Secret<span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" name="shared_secret" placeholder="" value="{{isset($user->shared_secret)?($user->shared_secret):''}}" required>

                                        @if ($errors->has('shared_secret'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('shared_secret') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="first_name" class="control-label">Access Token Secret</label>
                                        <input type="text" class="form-control" name="access_token_secret" placeholder="" value="{{isset($user->access_token_secret)?($user->access_token_secret):''}}">

                                        @if ($errors->has('access_token_secret'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('access_token_secret') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="first_name" class="control-label">Access Token</label>
                                        <input type="text" class="form-control" name="access_token" value="{{isset($user->access_token)?($user->access_token):''}}">

                                        @if ($errors->has('access_token'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('access_token') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="first_name" class="control-label">Shop Id<span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" name="shop_name" value="{{isset($user->shop_name)?($user->shop_name):''}}" required>

                                        @if ($errors->has('shop_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('shop_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="first_name" class="control-label">User Name<span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" name="user_name" placeholder="" value="{{isset($user->user_name)?($user->user_name):''}}" required>

                                        @if ($errors->has('user_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('user_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="first_name" class="control-label">Country</label>
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
                                        <label for="first_name" class="control-label">Store</label>
                                        <input type="text" class="form-control" name="store" placeholder="" value="{{isset($user->store_id)?($user->store_id):''}}">

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
                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary" id="access_code_url">
                                            Generate Token And Authorize
                                        </button>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group  pull-right">
                                        <a href="{{ url()->previous() }}" class="btn btn-light">
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

<!--model-->
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

<!--end model-->
@section('script')
<script>
    $('#access_code_url').on('click', function() {
        var token = $('input[name="_token"]').attr('value');
        $.ajax({
            type: 'GET',
            url: base_url + '/get_access_code_url',
            contentType: 'application/json',
            dataType: 'json',
            // data: data,
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

        if (access_token) {
            var data = {
                verify_token: access_token,
                id: $('#id').val()
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