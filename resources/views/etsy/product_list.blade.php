@extends('admin.layout.head')

@section('content')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-progressbar/0.9.0/bootstrap-progressbar.min.js"></script>


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

                                    <div class="header" style=" display: flex; justify-content: space-between;">
                                        <h2>
                                            <span>

                                                @hasanyrole('Admin') {{__('messages.product_list')}} of {{isset($shops[0]->shop_name)?$shops[0]->shop_name:''}}
                                                @endhasanyrole
                                            </span>
                                        </h2>



                                        @hasanyrole('Admin')
                                        <span>
                                            <a class="btn btn-primary" type="reset" href="{{url('shoplist') }}/{{$shops[0]->user_id}}">
                                                <i class="fa fa-arrow-left"></i>
                                                {{__('messages.back')}}
                                            </a>
                                        </span>

                                        @endhasanyrole

                                    </div>


                                    <div class="progress progress-striped active" style="display:none;" id="progress_div">
                                        <div class="progress-bar progress-bar-striped" role="progressbar" data-transitiongoal="25" id="progress_id"></div>
                                        <input type="hidden" value="0" id="progress_input_hide">
                                    </div>


                                    <div class="header product-list-new" style=" display: flex; justify-content: space-between;">

                                        <div class="">
                                            <form role="form" action="{{$url}}" method="post" class="form-inline" id="sync_form">
                                                @csrf
                                                <div class="form-group" style="position: relative; height: 36px;margin-right: 7px;">

                                                    <select class="select2-selection select2-selection--single form-select form-control shop" name="shop" id="shop">
                                                        <option value="">--Select shop--</option>
                                                        @forelse($shops as $shop)
                                                        <option value="{{$shop->id}}">{{$shop->shop_name}}</option>
                                                        @empty
                                                        <p>No shop</p>
                                                        @endforelse
                                                    </select>
                                                    @if ($errors->has('shop'))
                                                    <span class="help-block" style="position: absolute;width: max-content;bottom: -25px;">
                                                        <strong>{{ $errors->first('shop') }}</strong>
                                                    </span>
                                                    @endif
                                                    &nbsp&nbsp
                                                </div>
                                                <div class="form-group">

                                                    <select class="select2-selection select2-selection--single form-select form-control language" name="language" id="sync_language">
                                                        <option value="">Select a language</option>

                                                    </select>

                                                    &nbsp&nbsp
                                                </div>




                                                <button type="button" id="sync_prduct_btn" class="btn btn-sm btn-primary form-group" title="">Sync Product</button>

                                            </form>
                                        </div>
                                        <div class="">
                                            <form role="form" action="{{$url}}" method="Get" class="form-inline" id="">
                                                @csrf
                                                <div class="form-group" style="    position: relative;">

                                                    <select class="select2-selection select2-selection--single form-select form-control shop_search" name="shop" id="shop">
                                                        <option value="">--Select shop--</option>
                                                        @forelse($shops as $shop)

                                                        <option value="{{$shop->id}}">{{$shop->shop_name}}</option>
                                                        @empty
                                                        <p>No shop</p>
                                                        @endforelse
                                                    </select>
                                                    @if ($errors->has('shop'))
                                                    <span class="help-block" style="position: absolute;width: max-content;bottom: -20px;">
                                                        <strong>{{ $errors->first('shop') }}</strong>
                                                    </span>
                                                    @endif
                                                    &nbsp&nbsp
                                                </div>
                                                <div class="form-group">

                                                    <select class="select2-selection select2-selection--single form-select form-control language_search" name="language" id="language_search">
                                                        <option value="">Select a language</option>
                                                        <!-- <option value="en">English</option>
                                                                <option value="de">German</option>
                                                                <option value="es">Spanish</option>
                                                                <option value="fr">French</option>
                                                                <option value="it">Italian</option>
                                                                <option value="ja">Japanese</option>
                                                                <option value="nl">Dutch</option>
                                                                <option value="pl">Polish</option>
                                                                <option value="pt">Portuguese</option>
                                                                <option value="ru">Russian</option> -->
                                                    </select>

                                                    &nbsp&nbsp
                                                </div>




                                                <button type=" submit" class="btn btn-sm btn-primary form-group mr-2" title="">Search</button>
                                                <a type="button" href="{{url()->current()}}" class="btn btn-danger product-list-clr">Clear</a>

                                            </form>
                                        </div>

                                    </div>

                                    <div class="body">
                                        <div class="" id="one">
                                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4">

                                            </div>
                                        </div>
                                        <div class="">
                                            @if(count($data)>0)
                                            <table class="table-responsive table table-striped table-bordered table-hover" id="product_table">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">{{__('messages.sr_no')}}</th>
                                                        <th class="text-center">{{__('messages.File Name')}}</th>
                                                        <th class="text-center">{{__('messages.Date')}}</th>
                                                        <th class="text-center">{{__('messages.shop_name')}}</th>
                                                        <th class="text-center">{{__('messages.language')}}</th>
                                                        <th class="text-center">{{__('messages.action')}}</th>

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
                                                        <td><a href="{{url('public/uploads/'.$value->file_name)}}" download="{{$value->file_name}}" class="btn btn-info">
                                                                <i class="fa fa-download" aria-hidden="true"></i> </a>
                                                            <a href="javascript:void(0)" class="copy btn btn-warning" id="{{url('public/uploads/'.$value->file_name)}}">
                                                                <i class="fa fa-copy" style="color: #fff;"></i>
                                                            </a>
                                                            <a href="{{url('/etsy-product-list')}}/{{base64_encode($value->id)}}" class=" btn btn-primary" id="#"><i class="fa fa-eye"></i> </a> <a href="javascript:void(0);" class="delete btn btn-danger" id="{{$value->id}}"><i class="fa fa-trash-o"></i> </a>
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
            searching: false

        });


    });
    $('.shop').on('change', function() {



        var token = $('input[name="_token"]').attr('value');
        var data = {

            id: this.value
        };
        $.ajax({
            type: 'POST',
            url: base_url + '/get_shop_default_lang',
            contentType: 'application/json',
            dataType: 'json',
            data: JSON.stringify(data),
            headers: {
                'X-CSRF-Token': token
            },

            success: function(result) {
                if (result.status == "success") {
                    // console.log('result.language', result.language);
                    var type = '';
                    var lang = result.data.language

                    $.each(result.language, function(key, value) {
                        if (key == lang) {
                            type += '<option value="' + key + '" selected>' + value + '</option>';
                        } else {
                            type += '<option value="' + key + '">' + value + '</option>';
                        }

                    });



                    $('.language').html(type);
                } else {

                }


            },
            error: function(xhr, status, error) {
                alert("Error!" + xhr.status);
            },
        })
    });
    $('.shop_search').on('change', function() {



        var token = $('input[name="_token"]').attr('value');
        var data = {

            id: this.value
        };
        $.ajax({
            type: 'POST',
            url: base_url + '/get_shop_default_lang',
            contentType: 'application/json',
            dataType: 'json',
            data: JSON.stringify(data),
            headers: {
                'X-CSRF-Token': token
            },

            success: function(result) {
                if (result.status == "success") {
                    // console.log('result.language', result.language);
                    var type = '';
                    var lang = result.data.language

                    $.each(result.language, function(key, value) {
                        if (key == lang) {
                            type += '<option value="' + key + '" selected>' + value + '</option>';
                        } else {
                            type += '<option value="' + key + '">' + value + '</option>';
                        }

                    });



                    $('.language_search').html(type);
                } else {

                }


            },
            error: function(xhr, status, error) {
                alert("Error!" + xhr.status);
            },
        })
    });
    $("#shop").select2({
        placeholder: "Select a shop",
        allowClear: true
    });
    $("#language").select2({
        placeholder: "Select a language",
        allowClear: true
    })



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
            title: "{{__('messages.are_you_sure')}}",
            text: "{{__('messages.Once you confirm, you will not be able to recover !')}}",
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
                swal("{{__('messages.your_record_safe')}}");
            }
        });

    });




    $(document).ready(function() {
        $('.progress .progress-bar').progressbar({
            display_text: 'fill',
            use_percentage: false
        });
    });

    $(document).ready(function() {


        $(document).on('click', '#sync_prduct_btn', function() {
            // $('#sync_prduct_btn').click(function() {

            // $('#sync_form').submit();

            var shop_id = $('#shop').find(":selected").val();
            var token = $('input[name="_token"]').attr('value');
            var lang = $('#sync_language').find(":selected").val();

            if (shop_id.length == '0') {
                toastr.error("please select the shop");
            } else {
                $('#progress_div').show();
                $(this).prop('disabled', true);
                var data = {
                    shop: shop_id,
                    language: lang

                };
                var url = $(location).attr('href'),
                    parts = url.split("/"),
                    last_part = parts[parts.length - 1];

                $.ajax({
                    type: 'POST',
                    url: base_url + '/etsy-list-data',
                    contentType: 'application/json',
                    dataType: 'json',
                    data: JSON.stringify(data),
                    headers: {
                        'X-CSRF-Token': token
                    },

                    success: function(data) {
                       
                        if (data.status = "true") {
                            var total = data.data.count

                            for (var i = 0; i <= total; i++) {
                                var width = parseInt(i) / parseInt(total) * 100;
                                $('#progress_id').width(Math.round(width) + '%');
                                $('#progress_id').attr('data-transitiongoal', width);
                                $('#progress_id').text(Math.round(width) + '/100');
                                $('#progress_input_hide').val(Math.round(width));

                            }


                        } else {
                            toastr.error(data.message);
                        }

                    }
                })
            }

        });

        setInterval(function() {
            var progress_input_hide = $('#progress_input_hide').val();
            if (progress_input_hide == '100') {
                window.location.reload();
            }
        }, 9000);

    });
</script>
@endsection
@endsection