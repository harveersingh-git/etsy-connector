@extends('admin.layout.head')

@section('content')

<div id="main-content">
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <h2>{{__('messages.myshop')}}</h2>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
                    <!-- <li class="breadcrumb-item active"><a href="{{url('/subscriber')}}">{{__('messages.subscriber')}}</a></li> -->
                    <li class="breadcrumb-item active">{{__('messages.myshop')}}</li>
                </ul>
                <a href="{{ url('add-my-shop') }}" class="btn btn-sm btn-primary" title=""><i class="fa fa-plus" aria-hidden="true"></i>{{__('messages.create_new')}}</a>
            </div>
        </div>
    </div>
    <div class="container-fluid">

        <div class="row clearfix">

            <div class="col-lg-12">
                <div class="card">
                <div class="header" style=" display: flex; justify-content: space-between;">

                        <!-- <h2> {{__('messages.myshop')}}</h2> -->
                  
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
                    
                                        <th  class="text-center"> {{__('messages.action')}}</th>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th class="text-center">{{__('messages.sr_no')}}</th>
                                        <th class="text-center">{{__('messages.shop_name')}}</th>
                   
                                        <th  class="text-center">{{__('messages.action')}}</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @if(!empty($data) && $data->count())
                                    @foreach($data as $key => $value)
                                    <tr>
                                        <th class="text-center">{{ $key+1 }}</th>
                                        <td class="text-center">{{$value->shop_name}}</td>
                               

                                        <td>
                                            <a type="button" href="{{url('/my-shop/edit')}}/{{base64_encode($value->id)}}" class="btn btn-info btn-gray" title="Edit" style="color: #fff;" data-toggle="tooltip" data-placement="top" title="{{__('messages.edit')}}"><i class="fa fa-edit"></i></a>
                                            <!-- <a type="button" href="{{url('/etsy-config')}}/{{$value->id}}" class="btn btn-warning btn-gray" title="Generate Token And Authorize" style="color: #fff;"><i class="fa fa-gear fa-spin"></i></a> -->

                                            <button type="button" data-type="confirm" class="btn btn-danger js-sweetalert delete btn-width-equ" id="{{$value->id}}" title="{{__('messages.delete')}}" data-toggle="tooltip" data-placement="top"><i class="fa fa-trash-o"></i></button>


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
            text: "{{__('messages.Once you confirm, you will not be able to recover !')}}",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: "POST",
                    url: "{{url('delete_myshoplist')}}",
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
</script>

@endsection
@endsection