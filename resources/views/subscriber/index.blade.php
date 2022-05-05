@extends('admin.layout.head')

@section('content')

<div id="main-content">
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <h2>Subscriber List</h2>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item active">Subscriber List</li>
                </ul>
                <a href="{{ route('subscriber.create') }}" class="btn btn-sm btn-primary" title="">Create New</a>
            </div>
        </div>
    </div>
    <div class="container-fluid">

        <div class="row clearfix">

            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        @if(Request::segment(1)=='subscriber-trash')
                        <h2>Trash Subscriber List</h2>
                        @elseif(Request::segment(1)=='subscriber-in-active')
                        <h2>In-Active Subscriber List</h2>
                        @else
                        <h2>Active Subscriber List</h2>
                        @endif
                        <ul class="header-dropdown dropdown dropdown-animated scale-left">
                            <li> <a href="javascript:void(0);" data-toggle="cardloading" data-loading-effect="pulse"><i class="icon-refresh"></i></a></li>
                            <li><a href="javascript:void(0);" class="full-screen"><i class="icon-size-fullscreen"></i></a></li>
                            <li> <a type="button" data-type="confirm" class="btn btn-sm btn-primary js-sweetalert text-white" id="" title="Active" href="{{url('subscriber')}}">Active</a>
                            </li>
                            <li> <a type="button" data-type="confirm" class="btn btn-sm btn-primary js-sweetalert text-white" id="" title="Active" href="{{url('subscriber-in-active')}}">In-Active</a></li>
                            <li> <a type="button" data-type="confirm" class="btn btn-sm btn-primary js-sweetalert text-white" id="" title="Active" href="{{url('subscriber-trash')}}">Trash</a></li>

                            <!-- <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"></a>
                                <ul class="dropdown-menu">
                                    <li><a href="javascript:void(0);">Action</a></li>
                                    <li><a href="javascript:void(0);">Another Action</a></li>
                                    <li><a href="javascript:void(0);">Something else</a></li>
                                </ul>
                            </li> -->

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
                        <div class="table-responsive fade show active" id="one">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th class="text-center">Sr. No.</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Mobile</th>
                                        <th class="text-center">Status</th>
                                        <th>Action</th>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th class="text-center">Sr. No.</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Mobile</th>
                                        <th class="text-center">Status</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @if(!empty($data) && $data->count())
                                    @foreach($data as $key => $value)
                                    <tr>
                                        <th class="text-center">{{ $key+1 }}</th>
                                        <td class="text-center">{{$value->name}} {{$value->last_name}}</td>
                                        <td class="text-center">{{$value->email}} </td>
                                        <td class="text-center">{{$value->mobile}}</td>
                                        <td class="text-center">
                                            @if($value->active=='0')
                                            <i class="fa fa-eye-slash" id="{{$value->id}}"></i>
                                            @else
                                            <i class="fa fa-eye" id="{{$value->id}}"></i>
                                            @endif
                                        </td>
                                        <td>
                                            @if(Request::segment(1)=='subscriber-trash')
                                            <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm restore" id="{{$value->id}}" title="Activate User">
                                                <i class="fa fa-undo" aria-hidden="true"></i>


                                            </a>
                                            <button type="button" data-type="confirm" class="btn btn-danger js-sweetalert permanently_delete" id="{{$value->id}}" title="Delete"><i class="fa fa-trash-o"></i></button>

                                            @else
                                            <a type="button" href="{{ route('subscriber.edit',$value->id) }}" class="btn btn-info" title="Edit" style="color: #fff;"><i class="fa fa-edit"></i></a>
                                            <button type="button" data-type="confirm" class="btn btn-danger js-sweetalert delete" id="{{$value->id}}" title="Delete"><i class="fa fa-trash-o"></i></button>
                                            <a type="button" href="{{ route('etsy-config',$value->id) }}" class="btn btn-warning" title="Etsy config" style="color: #fff;"><i class="fa fa-cogs"></i></a>
                                            <a type="button" href="{{ route('update-password',$value->id) }}" class="btn btn-primary" title="Change password" style="color: #fff;"><i class="fa fa-lock"></i></a>
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
            title: "Are you sure?",
            text: "Once you confirm, the User will we move to trash.",
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
                swal("Your Record safe now!");
            }
        });

    });


    $(document).on('click', '.permanently_delete', function() {
        id = $(this).attr('id');
        swal({
            title: "Are you sure?",
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
                swal("Your Record safe now!");
            }
        });

    });


    $(document).on('click', '.restore', function() {
        id = $(this).attr('id');

        swal({
            title: "Are you sure?",
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
                        id: id
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
            title: "Are you sure?",
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