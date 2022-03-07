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
                    <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item active">Etsy Config</li>
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

                    <form class="form-horizontal" method="POST" action="{{ route('etsyConfig') }}">
                        {{ csrf_field() }}
                        <div class="body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label>App Url</label>
                                    <input type="text" class="form-control" name="app_url" placeholder="" value="{{isset($user->app_url)?($user->app_url):''}}">

                                    @if ($errors->has('app_url'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('app_url') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-lg-6">
                                    <label>Key String<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" name="key_string" placeholder="" value="{{isset($user->key_string)?($user->key_string):''}}" required>

                                    @if ($errors->has('key_string'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('key_string') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label>Shared Secret<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" name="shared_secret" placeholder="" value="{{isset($user->shared_secret)?($user->shared_secret):''}}" required>

                                    @if ($errors->has('shared_secret'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('shared_secret') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-lg-6">
                                    <label>Access Token Secret</label>
                                    <input type="text" class="form-control" name="access_token_secret" placeholder="" value="{{isset($user->access_token_secret)?($user->access_token_secret):''}}">

                                    @if ($errors->has('access_token_secret'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('access_token_secret') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label>Access Token</label>
                                    <input type="text" class="form-control" name="access_token" value="{{isset($user->access_token)?($user->access_token):''}}">

                                    @if ($errors->has('access_token'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('access_token') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="col-lg-6">
                                    <label>Shop Id<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" name="shop_name" value="{{isset($user->shop_name)?($user->shop_name):''}}" required>

                                    @if ($errors->has('shop_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('shop_name') }}</strong>
                                    </span>
                                    @endif
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <label>User Name<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" name="user_name" placeholder="" value="{{isset($user->user_name)?($user->user_name):''}}" required>

                                    @if ($errors->has('user_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('user_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-lg-6">
                                    <label>Country</label>
                                    <select name="country_id" id="country" class="form-control">
                                        <option value="">--select--</option>
                                        <option value="1" {{isset($user->country_id) && ($user->country_id) == '1' ? 'selected' : ''}}>Afghanistan</option>
                                        <option value="2" {{isset($user->country_id) && ($user->country_id)== '2' ? 'selected' : ''}}>Albania</option>
                                        <option value="3" {{isset($user->country_id) && ($user->country_id)== '3' ? 'selected' : ''}}>Algeria</option>
                                        <option value="4" {{isset($user->country_id) && ($user->country_id)== '4' ? 'selected' : ''}}>Australia</option>

                                    </select>
                                    @error('country')
                                    <p class="alert alert-danger"> {{ $errors->first('country') }} </p>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <label>Store</label>
                                    <input type="text" class="form-control" name="store" placeholder="" value="{{isset($user->store)?($user->store):''}}">

                                    @if ($errors->has('store'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('store') }}</strong>
                                    </span>
                                    @endif
                                </div>

                            </div>




                            <div class="row" style="margin-top: 10px;">
                                <div class="col-lg-6">
                                    <button type="submit" class="btn btn-primary">
                                        Update
                                    </button>
                                </div>

                                <div class="col-lg-3">
                                    <button type="button" class="btn btn-primary" id="access_code_url">
                                        Generate Token And Authorize
                                    </button>
                                </div>
                                <!-- <div class="col-lg-3">
                                    <button type="button" class="btn btn-primary">
                                        Download CSV
                                    </button>
                                </div> -->
                            </div>




                        </div>
                    </form>


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
                verify_token: access_token
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