@extends('admin.layout.head')

@section('content')




<div id="main-content">
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <h2>{{__('messages.license')}}</h2>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item active"><a href="{{url('/subscriber')}}">{{__('messages.subscriber_list')}}</a></li>
                    <li class="breadcrumb-item active">{{__('messages.license')}}</li>
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
                            <!-- <span>
                                <h2>{{__('messages.add_subscriber')}}</h2>
                            </span> -->
                        </h2>
                        <span> <a class="btn btn-primary" type="reset" href="{{url('/subscriber')}}"><i class="fa fa-arrow-left"></i>
                                {{__('messages.back')}}
                            </a></span>


                    </div>
                    <div class="header">
                        <div class="list-group">
                            <span class="list-group-item list-group-item-action flex-column align-items-start active">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1"> License
                                        @if($user['license']=='1')
                                        {{__('messages.allowed')}}
                                        @else
                                        {{__('messages.not_allowed')}}
                                        @endif
                                    </h5>
                                    <small>
                                        @if(isset($user['allow']->expire_date))

                                        @php($valuee = \Carbon\Carbon::parse($user['allow']->expire_date)->diffInSeconds())
                                        @php($dt = \Carbon\Carbon::now())
                                        @php($days = $dt->diffInDays($dt->copy()->addSeconds($valuee)))
                                        @php($hours = $dt->diffInHours($dt->copy()->addSeconds($valuee)->subDays($days)))
                                        @php($minutes = $dt->diffInMinutes($dt->copy()->addSeconds($valuee)->subDays($days)->subHours($hours)))
                                        @php($current_time =\Carbon\CarbonInterval::days($days)->hours($hours)->minutes($minutes)->forHumans())
                                        @endif

                                        @if($user['license']=='0')
                                        {{__('messages.licence has been expired')}}
                                        @else


                                        {{__('messages.licence will expire')}} {{ $current_time }}
                                        @endif
                                    </small>
                                </div>


                                </small>
                            </span>


                        </div>
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
                            <input type="hidden" value="{{$id}}" name="id">
                            <div class="row clearfix">

                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <b>{{__('messages.license')}}</b>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-drivers-license-o"></i></span>
                                        </div>

                                        <select class="form-select form-control" data-control="select2" data-placeholder="Please select" name="license" value="" id="license">
                                            <option value="0">{{__('messages.no')}}</option>
                                            <option value="1">{{__('messages.yes')}}</option>


                                        </select>
                                    </div>
                                    @if ($errors->has('country'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('country') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <b>{{__('messages.expire_date')}}</b>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                        </div>
                                        <input type="text" class="form-control  datepicker" placeholder="Ex: 30/07/2016" name="expire_date" id="expire_date" autocomplete="off">

                                    </div>
                                    @if ($errors->has('expire_date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('expire_date') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <b>{{__('messages.allow_shops')}}</b>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-home"></i></span>
                                        </div>
                                        <input type="number" class="form-control" min="0" placeholder="Ex:2" name="allowed_shops" id="expire_date" autocomplete="off">

                                    </div>
                                    @if ($errors->has('allowed_shops'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('allowed_shops') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group pull-right">
                                        <a href="{{url('/subscriber')}}" class="btn btn-light">
                                            {{__('messages.back')}}
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-floppy-o" aria-hidden="true"></i> {{__('messages.update')}}
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
    $('.datepicker').datepicker({
        startDate: new Date(),
        // endDate: '+2d'
    });

    // $(document).ready(function() {
    //     if ($('#business').is(':checked')) {
    //         $("#tex_id_div").show();
    //     } else {
    //         $('#tax_id').val('');
    //         $("#tex_id_div").hide();
    //     }
    // });
    // $('#business').click(function() {
    //     if ($(this).is(':checked')) {
    //         $("#tex_id_div").show();
    //     } else {
    //         $('#tax_id').val('');
    //         $("#tex_id_div").hide();
    //     }
    // });
</script>
@endsection
@endsection