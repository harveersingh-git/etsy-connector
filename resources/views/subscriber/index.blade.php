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
                    <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item active">Subscriber List</li>
                </ul>

                <a class="btn btn-success" href="{{ route('subscriber.create') }}"> Create New Subscriber</a> <!-- <a href="javascript:void(0);" class="btn btn-sm btn-primary" title="">Create New</a> -->
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
                    <div class="container-fluid">

                        <div class="row clearfix">
                            <div class="col-lg-12">
                                <div class="">
                                    <div class="header">
                                        <h2>Subscriber List</h2>
                                        <div class="pull-right">
                                            <ul class="nav nav-tabs nav-fill mb-3" id="ex1" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link active" id="ex2-tab-1" data-toggle="tab" href="#active" role="tab" aria-controls="ex2-tabs-1" aria-selected="true">Active</a>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link" id="ex2-tab-2" data-toggle="tab" href="#in-active" role="tab" aria-controls="ex2-tabs-2" aria-selected="false">In-active</a>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                    <div class="tab-content" id="ex2-content">

                                        <div class="body tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="ex2-tab-1">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover" id="subscribe_main_table">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">Sr. No.</th>
                                                            <th class="text-center">Name</th>
                                                            <th class="text-center">Email</th>
                                                            <th class="text-center">Mobile</th>
                                                            <th>Action</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        @if(!empty($data) && $data->count())
                                                        @foreach($data as $key => $value)
                                                        <tr>
                                                            <th class="text-center">{{ $key+1 }}</th>
                                                            <td class="text-center">{{$value->name}} {{$value->last_name}}</td>
                                                            <td class="text-center">{{$value->email}} </td>
                                                            <td class="text-center">{{$value->mobile}}</td>
                                                            <td class="text-center"> <a class="" href="{{ route('subscriber.edit',$value->id) }}">
                                                                    <span class="svg-icon svg-icon-3">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                            <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black"></path>
                                                                            <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black"></path>
                                                                        </svg>
                                                                    </span>
                                                                </a>
                                                                <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm delete" id="{{$value->id}}">
                                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                                                    <span class="svg-icon svg-icon-3">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                            <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black" />
                                                                            <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black" />
                                                                            <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black" />
                                                                        </svg>
                                                                    </span>
                                                                    <!--end::Svg Icon-->
                                                                </a>


                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                        @else
                                                        <tr>
                                                            <td colspan="13">There are no data.</td>
                                                        </tr>
                                                        @endif
                                                    </tbody>
                                                </table>

                                            </div>

                                        </div>
                                        <div class="body tab-pane fade" id="in-active" role="tabpanel" aria-labelledby="ex2-tab-2">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover" id="subscribe_second_table">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">Sr. No.</th>
                                                            <th class="text-center">Name</th>
                                                            <th class="text-center">Email</th>
                                                            <th class="text-center">Mobile</th>
                                                            <th>Action</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>


                                                        @forelse($trash_user as $key => $value)
                                                        <tr>
                                                            <th class="text-center">{{ $key+1 }}</th>
                                                            <td class="text-center">{{$value->name}} {{$value->last_name}}</td>
                                                            <td class="text-center">{{$value->email}} </td>
                                                            <td class="text-center">{{$value->mobile}}</td>
                                                            <td class="text-center">
                                                                <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm restore" id="{{$value->id}}" title="Activate User">
                                                                    <i class="fa fa-undo" aria-hidden="true"></i>


                                                                </a>
                                                                <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm permanently_delete" id="{{$value->id}}" title="Permanently Delete">
                                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                                                    <span class="svg-icon svg-icon-3">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                            <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black" />
                                                                            <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black" />
                                                                            <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black" />
                                                                        </svg>
                                                                    </span>
                                                                    <!--end::Svg Icon-->
                                                                </a>


                                                            </td>
                                                        </tr>
                                                        @empty
                                                        <tr>
                                                            <td colspan="13">There are no data.</td>
                                                        </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>


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
            text: "Once you confirm, the User will we deactivate.",
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
    $(document).ready(function() {
        var oTable = $('#subscribe_main_table').DataTable({
            "pageLength": 100,
            responsive: true,
            "lengthChange": false,
            // searching: false

        });
        var oTable = $('#subscribe_second_table').DataTable({
            "pageLength": 100,
            responsive: true,
            "lengthChange": false,
            // searching: false

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
</script>
@endsection
@endsection