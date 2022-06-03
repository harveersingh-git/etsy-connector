@extends('admin.layout.head')

@section('content')


<style>
    .dt-buttons {
        z-index: 1;
        position: absolute;
    }
</style>

<div id="main-content">
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <h2>{{__('messages.product_list')}}</h2>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item active"> {{__('messages.product_list')}}</li>
                </ul>

                <!-- <a href="{{url('export-csv')}}" class="btn btn-sm btn-primary" title="">Download CSV</a> -->
                <!-- <a href="javascript:void(0);" class="btn btn-sm btn-primary" title="">Create New</a> -->
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
                                    <div class="header form-inline">
                                        <h2>{{__('messages.product_list')}}</h2> 
                                        @hasanyrole('Admin')
                                        &nbsp
                                        <h2> of {{isset($shops[0]->shop_name)?$shops[0]->shop_name:''}}</h2>
                                        @endhasanyrole
                                        <a href="{{url()->previous() }}" class="ml-2">
                                            {{__('messages.back')}}
                                        </a>
                                    </div>
                                    <div class="body">
                                        <div class="" id="one">
                                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                                <div class="dt-buttons">
                                                    <form role="form" action="{{$url}}" method="post" class="form-inline" id="sync_form">
                                                        @csrf
                                                        <div class="form-group">

                                                            <select class="select2-selection select2-selection--single form-select form-control" name="language" id="language">

                                                                <option value="en">English</option>
                                                                <option value="de">German</option>
                                                                <option value="es">Spanish</option>
                                                                <option value="fr">French</option>
                                                                <option value="it">Italian</option>
                                                                <option value="ja">Japanese</option>
                                                                <option value="nl">Dutch</option>
                                                                <option value="pl">Polish</option>
                                                                <option value="pt">Portuguese</option>
                                                                <option value="ru">Russian</option>
                                                            </select>

                                                            &nbsp&nbsp
                                                        </div>
                                                        <div class="form-group">

                                                            <select class="select2-selection select2-selection--single form-select form-control" name="shop" id="shop">
                                                                <option value="">--Select shop--</option>
                                                                @forelse($shops as $shop)
                                                                <option value="{{$shop->id}}" {{($shop->id==$etsy_id)?'selected':''}}>{{$shop->shop_name}}</option>
                                                                @empty
                                                                <p>No shop</p>
                                                                @endforelse
                                                            </select>
                                                            @if ($errors->has('shop'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('shop') }}</strong>
                                                            </span>
                                                            @endif
                                                            &nbsp&nbsp
                                                        </div>



                                                        <button type=" submit" class="btn btn-sm btn-primary form-group" title="">Sync Product</button>

                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            @if(count($data)>0)
                                            <table class="table table-striped table-bordered table-hover" id="product_table">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Sr. No.</th>
                                                        <th class="text-center">File Name</th>
                                                        <th class="text-center">Date</th>
                                                        <th class="text-center">Shop Name</th>
                                                        <th class="text-center">Language</th>
                                                        <th class="text-center">Action</th>

                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @if(!empty($data) && $data->count())
                                                    @foreach($data as $key => $value)
                                                    <tr>
                                                        <th class="text-center">{{ $key+1 }}</th>
                                                        <td>{{substr($value->file_name,0,50)}}</td>

                                                        <td>{{ \Carbon\Carbon::parse($value->date)->format('d-M-Y') }}</td>
                                                        <td>{{isset($value['shops']->shop_name)?$value['shops']->shop_name:'N/A'}}</td>
                                                        @php
                                                        $lan = isset($value->language)?$value->language:'en';
                                                        $language = ['de'=>'German','en'=>'English','es'=>'Spanish','fr'=>'French','it'=>'Italian','ja'=>'Japanese','nl'=>'Dutch','pl'=>'Polish',
                                                        'pt'=>'Portuguese','ru'=>'Russian'];
                                                        $current_language = $language[ $lan];

                                                        @endphp
                                                        <td>{{ $current_language }}</td>
                                                        <td><a href="{{url('public/uploads/'.$value->file_name)}}" download="{{$value->file_name}}" class="btn btn-info"><i class="fa fa-download" aria-hidden="true"></i> </a> <a href="javascript:void(0)" class="copy btn btn-warning" id="{{url('public/uploads/'.$value->file_name)}}"><i class="fa fa-copy" style="color: #fff;"></i> </a> <a href="{{url('/etsy-product-list')}}/{{base64_encode($value->id)}}" class=" btn btn-primary" id="#"><i class="fa fa-eye"></i> </a> <a href="javascript:void(0);" class="delete btn btn-danger" id="{{$value->id}}"><i class="fa fa-trash-o"></i> </a></td>


                                                    </tr>
                                                    @endforeach
                                                    @else
                                                    <tr>
                                                        <td colspan="13">There are no data.</td>
                                                    </tr>
                                                    @endif
                                                </tbody>
                                            </table>

                                            @else
                                            <p class="" style="margin-top:4%;">No Product found. Please sync the product.</p>

                                            @endif
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
    $(document).ready(function() {
        var oTable = $('#product_table').DataTable({
            "pageLength": 100,
            responsive: true,
            "lengthChange": false,
            // searching: false

        });
        $("#shop").select2({
            placeholder: "Select a shop",
            allowClear: true
        });
        $("#language").select2({
            placeholder: "Select a language",
            allowClear: true
        })

    });

    function copyToClipboard(text) {
        var sampleTextarea = document.createElement("textarea");
        document.body.appendChild(sampleTextarea);
        sampleTextarea.value = text; //save main text in it
        sampleTextarea.select(); //select textarea contenrs
        document.execCommand("copy");
        document.body.removeChild(sampleTextarea);
    }
    $(document).on("click", ".copy", function() {
        var copyText = $(this).attr('id');


        copyToClipboard(copyText);
        $(this).text('Copied');
    });

    $(document).on('click', '.delete', function() {
        id = $(this).attr('id');
        var current = $(this);
        // alert(id);
        swal({
            title: "Are you sure?",
            text: "Once you confirm, you will not be able to recover !",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: "POST",
                    url: "{{url('delete_download_history')}}",
                    data: {
                        _token: '{{csrf_token()}}',
                        id: id
                    },
                    beforeSend: function() {

                    },
                    success: function(data) {
                        toastr.success("Record deleted successfully");
                        $(current).closest('tr').remove();
                        // window.location.reload();
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