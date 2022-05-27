@extends('admin.layout.head')

@section('content')




<div id="main-content">
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <h2>Download History List </h2>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item active">Download History List </li>
                </ul>

                <!-- <a href="{{url('generate-csv')}}" class="btn btn-sm btn-primary" title="" target="blanck">Download CSV</a> -->
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
                                    <div class="header">
                                        <h2>Download History List </h2>
                                    
                                    </div>
                                    <div class="body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover" id="product_table">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Sr. No.</th>
                                                        <th class="text-center">File Name</th>
                                                        <th class="text-center">Date</th>
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
                                                        <td><a href="{{url('public/uploads/'.$value->file_name)}}" download="{{$value->file_name}}">Download </a></td>
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