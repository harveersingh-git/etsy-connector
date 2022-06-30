@extends('admin.layout.head')

@section('content')




<div id="main-content">
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <h2>{{__('messages.edit_etsy_setting')}}</h2>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item active"><a href="{{url('/etsy-setting')}}">{{__('messages.etsy_setting')}}</a></li>
                    <li class="breadcrumb-item active">{{__('messages.edit_etsy_setting')}}</li>
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
                                <!-- {{__('messages.edit_etsy_setting')}} -->
                            </span>
                        </h2>
                        <span> <a class="btn btn-primary" type="reset" href="{{url()->previous() }}"><i class="fa fa-arrow-left"></i>
                                {{__('messages.back')}}
                            </a></span>

                    </div>
                    <div class="body">
                        {!! Form::model($user, ['method' => 'PATCH','route' => ['etsy-setting.update', $user->id]]) !!}

                        {{ csrf_field() }}
                        <input type="hidden" id="id" value="{{$user->id}}">
                        <div class="row clearfix">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="name" class="control-label">{{__('messages.app_url')}}<span style="color: red;">*</span></label>

                                    {!! Form::text('app_url', null, array('placeholder' => 'Ex:https://openapi.etsy.com/v2/','class' => 'form-control')) !!}

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
                                    <label for="name" class="control-label">{{__('messages.key_string')}}<span style="color: red;">*</span></label>

                                    {!! Form::text('key_string', null, array('placeholder' => 'Ex:4fd7vtsfmclj0q5cg3ot0eyj','class' => 'form-control')) !!}

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
                                    <label for="first_name" class="control-label">{{__('messages.shared_secret')}}<span style="color: red;">*</span></label>

                                    <input type="text" class="form-control" name="shared_secret" placeholder="Ex:v1cot8y888" value="{{isset($user->shared_secret)?($user->shared_secret):''}}" required>

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
                                    <input type="text" class="form-control" name="access_token_secret" placeholder="Ex:8000000f335565ee1c17310746e047" value="{{isset($user->access_token_secret)?($user->access_token_secret):''}}">

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
                                    <input type="text" class="form-control" placeholder="Ex:8039f62f335565ee1c17310000000" name="access_token" value="{{isset($user->access_token)?($user->access_token):''}}">

                                    @if ($errors->has('access_token'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('access_token') }}</strong>
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
                                <div class="form-group pull-right">
                                    <a href="{{url('/country')}}" class="btn btn-light">
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