@extends('admin.layout.head')

@section('content')

<div id="main-content">
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <h2>{{__('messages.subscriber')}}</h2>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item active">{{__('messages.subscriber')}}</li>
                </ul>
                <a href="{{ route('subscriber.create') }}" class="btn btn-sm btn-primary" title=""><i class="fa fa-plus" aria-hidden="true"></i>{{__('messages.create_new')}}</a>
            </div>
        </div>
    </div>
    <div class="container-fluid">

        <div class="row clearfix">

            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        @if(Request::segment(1)=='subscriber-trash')
                        <h2>{{__('messages.trash_subscriber_list')}}</h2>
                        @elseif(Request::segment(1)=='subscriber-in-active')
                        <h2>{{__('messages.inactive_subscriber_list')}}</h2>
                        @else
                        <h2>{{__('messages.active_subscriber_list')}}</h2>
                        @endif
                        <ul class="header-dropdown dropdown dropdown-animated scale-left">
                            <li> <a href="javascript:void(0);" data-toggle="cardloading" data-loading-effect="pulse"><i class="icon-refresh"></i></a></li>
                            <li><a href="javascript:void(0);" class="full-screen"><i class="icon-size-fullscreen"></i></a></li>
                            <li> <a type="button" data-type="confirm" class="btn btn-sm btn-success js-sweetalert text-white" id="" title="Active" href="{{url('subscriber')}}"><i class="fa fa-check-circle-o" aria-hidden="true"></i> {{__('messages.active')}}</a>
                            </li>
                            <li> <a type="button" data-type="confirm" class="btn btn-sm btn-warning js-sweetalert text-white" id="" title="In-Active" href="{{url('subscriber-in-active')}}"><i class="fa fa-minus-circle" aria-hidden="true"></i> {{__('messages.in_active')}}</a></li>
                            <li> <a type="button" data-type="confirm" class="btn btn-sm btn-danger js-sweetalert text-white" id="" title="Trash" href="{{url('subscriber-trash')}}"><i class="fa fa-trash-o" aria-hidden="true"></i> {{__('messages.trash')}}</a></li>

                        </ul>
                    </div>
                    <div class="body tab-content">
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
                        <div class="fade show active table-responsive" id="one">
                            <table class=" table table-bordered table-striped table-hover dataTable js-exportable licence-table-new">
                                <thead>
                                    <tr>
                                        <th class="text-center">{{__('messages.sr_no')}}</th>
                                        <th class="text-center">{{__('messages.name')}}/
                                        {{__('messages.email')}}
                                        </th>
                                
                                        <th class="text-center">{{__('messages.mobile')}}</th>
                                        @if(Request::segment(1)!='subscriber-trash')
                                        <th class="text-center">{{__('messages.active')}}</th>
                                        @endif
                                        <th class="text-center">{{__('messages.license')}}</th>
                                        <th class="text-center">{{__('messages.status')}}</th>
                                        <th class="text-center">{{__('messages.action')}}</th>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th class="text-center">{{__('messages.sr_no')}}</th>
                                        <th class="text-center">{{__('messages.name')}}/{{__('messages.email')}}</th>
                                     
                                        <th class="text-center">{{__('messages.mobile')}}</th>
                                        @if(Request::segment(1)!='subscriber-trash')
                                        <th class="text-center">{{__('messages.active')}}</th>
                                        @endif
                                        <th class="text-center">{{__('messages.license')}}</th>
                                        <th class="text-center">{{__('messages.status')}}</th>
                                        <th class="text-center">{{__('messages.action')}}</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @if(!empty($data) && $data->count())
                                    @foreach($data as $key => $value)
                                    <tr>
                                        <th class="text-center">{{ $key+1 }}</th>
                                        <td class="text-center">{{$value->name}} {{$value->last_name}}</br>{{$value->email}}</td>

                                        <td class="text-center">{{$value->country_code}}-{{$value->mobile}}</td>
                                        @if(Request::segment(1)!='subscriber-trash')
                                        <td class="text-center">
                                            @if($value->active=='0')
                                            <i class="fa fa-eye-slash" id="{{$value->id}}" data-toggle="tooltip" data-placement="top" title="Status"></i>
                                            @else
                                            <i class="fa fa-eye" id="{{$value->id}}" data-toggle="tooltip" data-placement="top" title="Status"></i>
                                            @endif
                                        </td>
                                        @endif
                                        <td class="text-center">
                                            @php $current_time='null';@endphp
                                            @if(isset($value->allow) && ($value->allow !='null'))
                                          
                                            @php($valuee = \Carbon\Carbon::parse($value['allow']->expire_date)->diffInSeconds())
                                            @php($dt = \Carbon\Carbon::now())
                                            @php($days = $dt->diffInDays($dt->copy()->addSeconds($valuee)))
                                            @php($hours = $dt->diffInHours($dt->copy()->addSeconds($valuee)->subDays($days)))
                                            @php($minutes = $dt->diffInMinutes($dt->copy()->addSeconds($valuee)->subDays($days)->subHours($hours)))
                                            @php($current_time =\Carbon\CarbonInterval::days($days)->hours($hours)->minutes($minutes)->forHumans())
                                            @endif

                                            @if($current_time!='null')
                                            {{__('messages.licence will expire')}}</br> {{ $current_time }}
                                            @else
                                            @if($value->current_status['name']=='New')
                                            {{__('messages.licence did not allotted')}}
                                            @else
                                            {{__('messages.licence has been expired')}}
                                            @endif
                                          

                                            @endif

                                        </td>
                                        <td class="text-center">{{isset($value->current_status['name'])?$value->current_status['name']:''}} </td>
                                        <td class="text-center">
                                            @if(Request::segment(1)=='subscriber-trash')
                                            <a href="#" class="btn btn-icon btn-bg-light btn btn-primary btn-sm restore" id="{{$value->id}}" title="Restore as Activate User" data-val="active">
                                                <i class="fa fa-undo" aria-hidden="true"></i>


                                            </a>
                                            <a href="#" class="btn btn-icon btn-bg-light btn btn-info btn-sm restore" id="{{$value->id}}" title="Restore as In-Activate User" data-val="in-active">
                                                <i class="fa fa-undo red-color" aria-hidden="true"></i>


                                            </a>
                                            <button type="button" data-type="confirm" class="btn btn-danger js-sweetalert permanently_delete" id="{{$value->id}}" title="Delete"><i class="fa fa-trash-o"></i></button>

                                            @else
                                            <a type="button" href="{{ route('subscriber.edit',$value->id) }}" class="btn btn-info btn-gray" title="Edit" style="color: #fff;" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>

                                            <a type="button" href="{{ route('shoplist',$value->id) }}" class="btn btn-warning btn-gray" title="Etsy Shop" style="color: #fff;" data-toggle="tooltip" data-placement="top"><i class="fa fa-shopping-cart"></i></a>
                                            <a type="button" href="{{ route('update-password',$value->id) }}" class="btn btn-primary btn-gray" title="Change password" style="color: #fff;" data-toggle="tooltip" data-placement="top"><i class="fa fa-lock"></i></a>

                                            <button type="button" data-type="confirm" class="btn btn-secondary js-sweetalert email_verification btn-gray" id="{{$value->id}}" title="Send Email Verification Link" data-toggle="tooltip" data-placement="top"><i class="fa fa-envelope" aria-hidden="true"></i>
                                            </button>
                                            <a type="button" href="{{ route('license',base64_encode($value->id)) }}" class="btn btn-warning btn-gray" title=" License Allowed" style="color: #fff;" data-toggle="tooltip" data-placement="top"><i class="fa fa-usd"></i></a>

                                            <button type="button" data-type="confirm" class="btn btn-danger js-sweetalert delete btn-width-equ" id="{{$value->id}}" title="Delete" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash-o"></i></button>

                                            @endif
                                        </td>

                                    </tr>
                                    @endforeach
                                    @else

                                    @endif
                                </tbody>

                            </table>
                        </div>


                    </div>
                </div>
            </div>
        </div>



    </div>
</div>

<!--model-->

<!--end model-->
@section('script')


<script>
    $(document).on('click', '.email_verification', function() {
        id = $(this).attr('id');
        // alert(id);
        swal({
            title: "{{__('messages.are_you_sure')}}",
            text: "You want to resend the email verificatin link to the subscriber ",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: "POST",
                    url: "{{url('send_email_verification_link')}}",
                    data: {
                        _token: '{{csrf_token()}}',
                        id: id
                    },
                    beforeSend: function() {

                    },
                    success: function(data) {
                        toastr.success("Resend the email for verification account");
                        // window.location.reload();
                    }
                });

            } else {
                swal("{{__('messages.your_record_safe')}}");
            }
        });

    });
    $(document).on('click', '.delete', function() {
        id = $(this).attr('id');
        // alert(id);
        swal({
            title: "{{__('messages.are_you_sure')}}",
            text: "{{__('messages.Once you confirm, the User will we move to trash')}}",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: "POST",
                    url: "{{url('delete_subscriber')}}",
                    data: {
                        _token: '{{csrf_token()}}',
                        id: id
                    },
                    beforeSend: function() {

                    },
                    success: function(data) {
                        toastr.success("User deactivate successfully");
                        window.location.reload();
                    }
                });

            } else {
                swal("{{__('messages.your_record_safe')}}");
            }
        });

    });


    $(document).on('click', '.permanently_delete', function() {
        id = $(this).attr('id');
        swal({
            title: "{{__('messages.are_you_sure')}}",
            text: "Once deleted, you will not be able to recover !",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: "POST",
                    url: "{{url('permanently-delete')}}",
                    data: {
                        _token: '{{csrf_token()}}',
                        id: id
                    },
                    beforeSend: function() {

                    },
                    success: function(data) {
                        toastr.success("Record deleted successfully");
                        window.location.reload();
                    }
                });

            } else {
                swal("{{__('messages.your_record_safe')}}");
            }
        });

    });


    $(document).on('click', '.restore', function() {
        id = $(this).attr('id');
        var status = $(this).attr('data-val');
        // alert(status);
        swal({
            title: "{{__('messages.are_you_sure')}}",
            text: "You want to recover this record.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: "POST",
                    url: "{{url('subscriber-restore')}}",
                    data: {
                        _token: '{{csrf_token()}}',
                        id: id,
                        status: status
                    },
                    beforeSend: function() {

                    },
                    success: function(data) {
                        toastr.success("Record Restored successfully");
                        window.location.reload();
                    }
                });

            }
        });

    });


    $(document).on('click', 'i.fa.fa-eye,i.fa.fa-eye-slash', function() {
        id = $(this).attr('id');
        var current = $(this);

        swal({
            title: "{{__('messages.are_you_sure')}}",
            text: "You want to update the status",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willUpdate) => {
            if (willUpdate) {
                $.ajax({
                    type: "POST",
                    url: "{{url('subscriber-status-update')}}",
                    data: {
                        _token: '{{csrf_token()}}',
                        id: id
                    },
                    beforeSend: function() {

                    },
                    success: function(data) {
                        toastr.success("Status updated successfully");
                        $(current).toggleClass("fa-eye fa-eye-slash");
                        $(current).closest('tr').remove();
                    }
                });

            }
        });

    });
</script>

@endsection
@endsection