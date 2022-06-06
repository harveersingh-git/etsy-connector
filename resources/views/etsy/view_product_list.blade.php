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
                <h2>{{__('messages.products')}}</h2>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item active">{{__('messages.products')}}</li>
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
                                        @if(count($data)>0)
                                        @php
                                        $lan = isset($records->language)?$records->language:'en';
                                        $language = ['de'=>'German','en'=>'English','es'=>'Spanish','fr'=>'French','it'=>'Italian','ja'=>'Japanese','nl'=>'Dutch','pl'=>'Polish',
                                        'pt'=>'Portuguese','ru'=>'Russian'];
                                        $current_language = $language[ $lan];

                                        @endphp
                                        <h2>{{__('messages.product_of')}} {{$records['shops']->shop_name}} ({{ $current_language}})</h2>

                                        <a href="{{url()->previous() }}" class="ml-2">
                                            {{__('messages.back')}}
                                        </a>
                                        @endif

                                    </div>
                                    <div class="body">
                                        <div class="" id="one">
                                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                                <div class="dt-buttons">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            @if(count($data)>0)
                                            <table class="table table-striped table-bordered table-hover" id="product_table">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">{{__('messages.sr_no')}}</th>
                                                        <th class="text-center">{{__('messages.shop_name')}}</th>
                                                        <th class="text-center">{{__('messages.title')}}</th>
                                                        <th class="text-center">{{__('messages.price')}}</th>
                                                        <th class="text-center">{{__('messages.materials')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @if(!empty($data) && $data->count())
                                                    @foreach($data as $key => $value)
                                                    <tr>
                                                        <th class="text-center">{{ $key+1 }}</th>
                                                        <td>{{$value['shops']->shop_name}}</td>
                                                        <td>{{substr($value->title,0,20)}}...</td>
                                                        <td class="text-center">{{$value->price}} {{$value->currency_code}}</td>
                                                        <td class="text-center">{{substr($value->materials,0,50)}}..</td>
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


    });
</script>
@endsection
@endsection