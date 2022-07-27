@extends('admin.layout.head')

@section('content')

<div id="main-content">
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <h2>{{__('messages.shop_list')}}</h2>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item active"><a href="{{url('/subscriber')}}">{{__('messages.subscriber')}}</a></li>
                    <li class="breadcrumb-item active">{{__('messages.shop_list')}}</li>
                </ul>
                <a href="{{ url('add-shoplist') }}/{{$id}}" class="btn btn-sm btn-primary" title=""><i class="fa fa-plus" aria-hidden="true"></i> {{__('messages.create_new')}}</a>
            </div>
        </div>
    </div>
    <div class="container-fluid">

        <div class="row clearfix">

            <div class="col-lg-12">
                <div class="card">
                    <div class="header" style=" display: flex; justify-content: space-between;">
                        @if(Request::segment(1)=='shoplist')
                        <h2>{{__('messages.active_shop_list')}}</h2>
                        @else
                        <h2>{{__('messages.trash_shop_list')}}</h2>
                        @endif

                        <ul class="header-dropdown dropdown dropdown-animated scale-left mb-5">
                            <li> <a href="javascript:void(0);" data-toggle="cardloading" data-loading-effect="pulse"><i class="icon-refresh"></i></a></li>
                            <li><a href="javascript:void(0);" class="full-screen"><i class="icon-size-fullscreen"></i></a></li>
                            <li> <a type="button" data-type="confirm" class="btn btn-sm btn-success js-sweetalert text-white" id="" title="Active" href="{{url('shoplist')}}/{{Request::segment(2)}}"><i class="fa fa-check-circle-o" aria-hidden="true"></i> {{__('messages.active')}}</a>
                            </li>
                            <!-- <li> <a type="button" data-type="confirm" class="btn btn-sm btn-warning js-sweetalert text-white" id="" title="In-Active" href="{{url('subscriber-in-active')}}"><i class="fa fa-minus-circle" aria-hidden="true"></i> {{__('messages.in_active')}}</a></li> -->
                            <li> <a type="button" data-type="confirm" class="btn btn-sm btn-danger js-sweetalert text-white" id="" title="Trash" href="{{url('shoplist-trash')}}/{{Request::segment(2)}}"><i class="fa fa-trash-o" aria-hidden="true"></i> {{__('messages.trash')}}</a></li>
                            <li><a class="btn btn-primary text-white" type="reset" href="{{url('/subscriber')}}"><i class="fa fa-arrow-left"></i>
                                    {{__('messages.back')}}
                                </a></li>
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
                        <div class="fade show active" id="one">
                            <table class="table-responsive table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th class="text-center">{{__('messages.sr_no')}}</th>
                                        <th class="text-center">{{__('messages.shop_name')}}</th>

                                        <th class="text-center">{{__('messages.action')}}</th>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th class="text-center">{{__('messages.sr_no')}}</th>
                                        <th class="text-center">{{__('messages.shop_name')}}</th>

                                        <th class="text-center">{{__('messages.action')}}</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @if(!empty($data) && $data->count())
                                    @foreach($data as $key => $value)
                                    <tr>
                                        <th class="text-center">{{ $key+1 }}</th>
                                        <td class="text-center">{{$value->shop_name}}</td>


                                        <td class="text-center">
                                            @if(Request::segment(1)=='shoplist')
                                            <a type="button" href="{{url('/shoplist/edit')}}/{{base64_encode($value->id)}}" class="btn btn-info  btn-gray" title="Edit" style="color: #fff;" data-toggle="tooltip" data-placement="top"><i class="fa fa-edit"></i></a>
                                            <!-- <a type="button" href="{{url('/etsy-config')}}/{{$value->id}}" class="btn btn-warning" title="Generate Token And Authorize" style="color: #fff;"><i class="fa fa-gear fa-spin"></i></a> -->
                                            <a type="button" href="{{url('/etsy-list-data')}}/{{base64_encode($value->id)}}" class="btn btn-success btn-gray" title="View" data-toggle="tooltip" data-placement="top"><i class="fa fa-eye" aria-hidden="true"></i></a>

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
                    url: "{{url('delete_shoplist')}}",
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
                swal("Your Record safe now!");
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
                    url: "{{url('my-shop-restore')}}",
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
                    url: "{{url('shoplist-permanently-delete')}}",
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
</script>

@endsection
@endsection