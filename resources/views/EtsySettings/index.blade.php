@extends('admin.layout.head')

@section('content')

<div id="main-content">
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <h2>{{__('messages.etsy_setting')}}</h2>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item active">{{__('messages.etsy_setting')}}</li>
                </ul>
                <a href="{{ route('etsy-setting.create') }}" class="btn btn-sm btn-primary" title=""><i class="fa fa-plus" aria-hidden="true"></i> {{__('messages.create_new')}}</a>
            </div>
        </div>
    </div>
    <div class="container-fluid">

        <div class="row clearfix">

            <div class="col-lg-12">
                <div class="card">
                    <div class="header" style=" display: flex; justify-content: space-between;">
                        <!-- <h2> {{__('messages.localization')}}</h2> -->
                        @if(Request::segment(1)=='etsy-setting')
                        <h2>{{__('messages.active_etsy_setting')}}</h2>
                        @else
                        <h2>{{__('messages.trash_etsy_setting')}}</h2>
                        @endif
                        <ul class="header-dropdown dropdown dropdown-animated scale-left">
                            <li> <a href="javascript:void(0);" data-toggle="cardloading" data-loading-effect="pulse"><i class="icon-refresh"></i></a></li>
                            <li><a href="javascript:void(0);" class="full-screen"><i class="icon-size-fullscreen"></i></a></li>
                            <li> <a type="button" data-type="confirm" class="btn btn-sm btn-success js-sweetalert text-white" id="" title="Active" href="{{url('etsy-setting')}}"><i class="fa fa-check-circle-o" aria-hidden="true"></i> {{__('messages.active')}}</a>
                            </li>
                            <!-- <li> <a type="button" data-type="confirm" class="btn btn-sm btn-warning js-sweetalert text-white" id="" title="In-Active" href="{{url('subscriber-in-active')}}"><i class="fa fa-minus-circle" aria-hidden="true"></i> {{__('messages.in_active')}}</a></li> -->
                            <li> <a type="button" data-type="confirm" class="btn btn-sm btn-danger js-sweetalert text-white" id="" title="Trash" href="{{url('etsy-setting-trash')}}"><i class="fa fa-trash-o" aria-hidden="true"></i> {{__('messages.trash')}}</a></li>

                        </ul>
                    </div>
                    <div class="body tab-content">
                        <div class="fade show active" id="one">
                            <table class="table-responsive table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th class="text-center">{{__('messages.sr_no')}}</th>
                                        <th class="text-center">{{__('messages.app_url')}}</th>


                                        <th class="text-center">Action</th>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th class="text-center">{{__('messages.sr_no')}}</th>
                                        <th class="text-center">{{__('messages.app_url')}}</th>

                                        <th class="text-center">Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @if(!empty($data) && $data->count())
                                    @foreach($data as $key => $value)
                                    <tr>
                                        <th class="text-center">{{ $key+1 }}</th>
                                        <td class="text-center">{{$value->app_url}} </td>

                                        <td class="text-center">
                                            @if(Request::segment(1)=='etsy-setting')
                                            <a type="button" href="{{ route('etsy-setting.edit',$value->id) }}" class="btn btn-info btn-gray" title="Edit" style="color: #fff;" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                            <button type="button" data-type="confirm" class="btn btn-danger js-sweetalert delete btn-width-equ" id="{{$value->id}}" title="Delete" data-toggle="tooltip" data-placement="top"><i class="fa fa-trash-o"></i></button>
                                            @else
                                            <a href="#" class="btn btn-primary restore" id="{{$value->id}}" title="Restore" data-val="">
                                                <i class="fa fa-undo red-color" aria-hidden="true"></i>


                                            </a>
                                            <button type="button" data-type="confirm" class="btn btn-danger js-sweetalert permanently_delete btn-width-equ" id="{{$value->id}}" title="{{__('messages.delete')}}" data-toggle="tooltip" data-placement="top"><i class="fa fa-trash-o"></i></button>

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
                    url: "{{url('etsy-setting-restore')}}",
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
                    url: "{{url('etsy-setting-permanently-delete')}}",
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
                    url: "{{url('delete_etsy_setting')}}",
                    data: {
                        _token: '{{csrf_token()}}',
                        id: id
                    },
                    beforeSend: function() {

                    },
                    success: function(data) {
                        toastr.success("Record delete successfully");
                        window.location.reload();
                    }
                });

            } else {
                swal("{{__('messages.your_record_safe')}}");
            }
        });

    });
</script>

@endsection
@endsection