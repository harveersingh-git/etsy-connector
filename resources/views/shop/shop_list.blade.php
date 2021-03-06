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
                    <!-- <li class="breadcrumb-item active"><a href="{{url('/subscriber')}}">{{__('messages.subscriber')}}</a></li> -->
                    <li class="breadcrumb-item active">{{__('messages.shop_list')}}</li>
                </ul>
                <!-- <a href="{{ url('add-shoplist') }}" class="btn btn-sm btn-primary" title="">{{__('messages.create_new')}}</a> -->
            </div>
        </div>
    </div>
    <div class="container-fluid">

        <div class="row clearfix">

            <div class="col-lg-12">
                <div class="card">
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
                                        <th class="text-center">{{__('messages.email')}}</th>
                                        <th class="text-center">{{__('messages.contact')}}</th>
                                        <th class="text-center">{{__('messages.action')}}</th>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th class="text-center">{{__('messages.sr_no')}}</th>
                                        <th class="text-center">{{__('messages.shop_name')}}</th>
                                        <th class="text-center">{{__('messages.email')}}</th>
                                        <th class="text-center">{{__('messages.contact')}}</th>
                                        <th class="text-center">{{__('messages.action')}}</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @if(!empty($data) && $data->count())
                                    @foreach($data as $key => $value)
                                    <tr>
                                        <th class="text-center">{{ $key+1 }}</th>
                                        <td class="text-center">{{$value->shop_name}}</td>
                                        <td class="text-center">{{isset($value->owner['email'])?$value->owner['email']:'N/A'}}</td>
                                        <td class="text-center">{{isset($value->owner['email'])?$value->owner['country_code']:'N/A'}} - {{isset($value->owner['mobile'])?$value->owner['mobile']:'N/A'}}</td>
                                        <td class="text-center">
                                            <a type="button" href="{{url('/shoplist/edit')}}/{{base64_encode($value->id)}}" class="btn btn-info  btn-gray" title="Edit" style="color: #fff;" data-toggle="tooltip" data-placement="top"><i class="fa fa-edit"></i></a>
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
</script>

@endsection
@endsection