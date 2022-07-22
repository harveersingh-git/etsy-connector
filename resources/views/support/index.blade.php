@extends('admin.layout.head')

@section('content')

<div id="main-content">
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <h2>{{__('messages.support')}}</h2>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
                    <!-- <li class="breadcrumb-item active"><a href="{{url('/subscriber')}}">{{__('messages.subscriber')}}</a></li> -->
                    <li class="breadcrumb-item active">{{__('messages.support')}}</li>
                </ul>
                <!-- <a href="{{ url('add-my-shop') }}" class="btn btn-sm btn-primary" title=""><i class="fa fa-plus" aria-hidden="true"></i>{{__('messages.create_new')}}</a> -->
            </div>
        </div>
    </div>
    <div class="container-fluid">

        <div class="row clearfix">

            <div class="col-lg-12">
                <div class="card">

                    <div class="header product-list-new" style=" display: flex; justify-content: space-between;">
                        <div>
                        </div>

                        <div class="">
                            <form role="form" action="{{$url}}" method="Get" class="form-inline" id="">
                                @csrf
                                <div class="form-group" style="    position: relative;">



                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="search" placeholder="Search" value="{{Request::query('search')}}"  required>


                                    &nbsp&nbsp
                                </div>




                                <button type=" submit" class="btn btn-sm btn-primary form-group mr-2" title=""><i class="fa fa-search" aria-hidden="true"></i>{{__('messages.search')}}</button>
                                <a type="button" href="{{url()->current()}}" class="btn btn-danger product-list-clr"><i class="fa fa-times" aria-hidden="true"></i>{{__('messages.clear')}}</a>

                            </form>
                        </div>

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

                            <table class="table-responsive table table-bordered table-striped table-hover" id="contact_list">
                                <thead>
                                    <tr>
                                        <th class="text-center">{{__('messages.sr_no')}}</th>
                                        <th class="text-center">{{__('messages.name')}}</th>
                                        <th class="text-center">{{__('messages.email')}}</th>
                                        <th class="text-center">{{__('messages.mobile')}}</th>

                                        <th class="text-center"> {{__('messages.action')}}</th>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th class="text-center">{{__('messages.sr_no')}}</th>
                                        <th class="text-center">{{__('messages.name')}}</th>
                                        <th class="text-center">{{__('messages.email')}}</th>
                                        <th class="text-center">{{__('messages.mobile')}}</th>


                                        <th class="text-center">{{__('messages.action')}}</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @if(!empty($data) && $data->count())
                                    @foreach($data as $key => $value)
                                    <tr>
                                        <th class="text-center">{{ $key+1 }}</th>
                                        <td class="text-center">{{$value->name}}</td>
                                        <td class="text-center">{{$value->email}}</td>
                                        <td class="text-center">{{$value->country_code}}-{{$value->mobile}}</td>

                                        <td class="text-center">
                                            @if($value->status=='0')
                                            <a type="button" href="{{url('/support/edit')}}/{{base64_encode($value->id)}}" class="btn btn-info btn-gray" title="View" style="color: #fff;" data-toggle="tooltip" data-placement="top" title="{{__('messages.edit')}}"><i class="fa fa-eye"></i></a>

                                            @else
                                            <a type="button" href="{{url('/support/edit')}}/{{base64_encode($value->id)}}" class="btn btn-info btn-gray" title="Viewed" style="color: #fff;" data-toggle="tooltip" data-placement="top" title="{{__('messages.edit')}}"><i class="fa fa-eye-slash"></i></a>

                                            @endif

                                            <!-- <a type="button" href="{{url('/etsy-config')}}/{{$value->id}}" class="btn btn-warning btn-gray" title="Generate Token And Authorize" style="color: #fff;"><i class="fa fa-gear fa-spin"></i></a>

                                            <button type="button" data-type="confirm" class="btn btn-danger js-sweetalert delete btn-width-equ" id="{{$value->id}}" title="{{__('messages.delete')}}" data-toggle="tooltip" data-placement="top"><i class="fa fa-trash-o"></i></button> -->


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
    $(document).ready(function() {
        var oTable = $('#contact_list').DataTable({
            "pageLength": 100,
            responsive: true,
            "lengthChange": false,
            searching: false

        });


    });
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