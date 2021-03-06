@extends('admin.layout.head')

@section('content')


<style>


    .btn-gray {
        color: #fff;
    }

    .btn-gray:hover {
        color: #fff;
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
                    <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>
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
                                    <div class="header" style=" display: flex; justify-content: space-between;">
                                        @if(count($data)>0)
                                        @if($type=='single')
                                        @php
                                        $lan = isset($records->language)?$records->language:'en';
                                        $language = ['de'=>'German','en-US'=>'English','es'=>'Spanish','fr'=>'French','it'=>'Italian','ja'=>'Japanese','nl'=>'Dutch','pl'=>'Polish',
                                        'pt'=>'Portuguese','ru'=>'Russian'];
                                        $current_language = $language[ $lan];

                                        @endphp
                                        @endif
                                        <h2>
                                            {{__('messages.product_of')}} {{$records['shops']->shop_name}}
                                            @if($type=='multi')
                                            (Multi-Language)
                               
                                            @else
                                            ({{$current_language}})
                                            @endif
                                         
                                        </h2>

                                        <span>
                                        @if($type!='multi')
                                     
                                            <a href="{{url('public/uploads/'.$records->file_name)}}" download="{{$records->file_name}}" class="btn btn-info btn-gray" data-toggle="tooltip" data-placement="top" title="Download"><i class="fa fa-download" aria-hidden="true"></i>
                                            </a>
                                            <a href="javascript:void(0)" class="copy btn btn-warning btn-gray" id="{{url('public/uploads/'.$records->file_name)}}" data-toggle="tooltip" data-placement="top" title="Copy">
                                                <i class="fa fa-copy" style="color: #fff;"></i>
                                            </a>
                                            @else
                                       
                                            <a href="{{url('public/uploads/'.$records->multi_lang_file_name)}}" download="{{$records->multi_lang_file_name}}" class="btn btn-info btn-gray" data-toggle="tooltip" data-placement="top" title="Download"><i class="fa fa-download" aria-hidden="true"></i>
                                            </a>
                                            <a href="javascript:void(0)" class="copy btn btn-warning btn-gray" id="{{url('public/uploads/'.$records->multi_lang_file_name)}}" data-toggle="tooltip" data-placement="top" title="Copy">
                                                <i class="fa fa-copy" style="color: #fff;"></i>
                                            </a>
                                            @endif

                                            <a class="btn btn-primary" type="reset" href="{{url()->previous() }}"><i class="fa fa-arrow-left"></i>
                                                {{__('messages.back')}}
                                            </a>
                                        </span>
                                        @endif

                                    </div>
                                    <div class="body">
                                        <div class="" id="one">
                                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4">

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


                                                    @forelse($data as $key => $value)
                                                    <tr>
                                                        <th class="text-center">{{ $key+1 }}</th>
                                                        <td>{{$value['shops']->shop_name}}</td>
                                                        <td>{{substr($value->title,0,20)}}...</td>
                                                        <td class="text-center">{{$value->price}} {{$value->currency_code}}</td>
                                                        <td class="text-center">{{substr($value->materials,0,50)}}..</td>
                                                    </tr>
                                                    @empty
                                                    <tr>No record found</tr>
                                                    @endforelse

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
</script>
@endsection
@endsection