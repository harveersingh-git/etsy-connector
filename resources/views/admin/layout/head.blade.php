<!doctype html>
<html lang="en">

<head>
    <title>:: Etsy Connector :: Home</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="description" content="Etsy Connector Bootstrap 4x Admin Template">
    <meta name="author" content="WrapTheme, www.thememakker.com">

    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/vendor/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/vendor/jquery-datatable/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/vendor/jquery-datatable/fixedeader/dataTables.fixedcolumns.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/vendor/jquery-datatable/fixedeader/dataTables.fixedheader.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/sweetalert/sweetalert.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}">
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.4/datatables.min.css"/> -->



    <link rel="stylesheet" href="{{asset('assets/vendor/charts-c3/plugin.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/chartist/css/chartist.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/toastr/toastr.min.css')}}">


    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/color_skins.css')}}">
    <link rel="stylesheet" href="{{asset('assets/fonts/font-style.css')}}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <style>
        span.help-block {
            color: red;
        }

        .tooltips {
            position: relative;
            display: inline-block;
        }

        .tooltips .tooltiptext {
            visibility: hidden;
            width: 120px;
            background-color: rgba(0, 0, 0, 0.8);
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px 0;
            position: absolute;
            z-index: 1;
            bottom: 150%;
            left: 50%;
            margin-left: -60px;
            font-size: 12px;
        }

        .tooltips:hover .tooltiptext {
            visibility: visible;
        }

        .tooltips .tooltiptext::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: black transparent transparent transparent;
        }

        .tooltiptext:after {
            content: " ";
            content: " ";
            position: absolute;
            right: 43px;
            top: -9px;
            border-top: none;
            border-right: 8px solid transparent;
            border-left: 8px solid transparent;
            border-bottom: 8px solid #f1f1f1;
        }

        *::after {
            box-sizing: border-box;
        }
    </style>
</head>

<body class="theme-orange">

    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="m-t-30"><img src="{{asset('assets/images/icon-light.svg')}}" width="48" height="48" alt="Etsy Connector"></div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>

    <div id="wrapper">

        <!-- nav side bar -->
        @include('admin.layout.navbar')

        <!-- right side bar -->
        @include('admin.layout.rightsidebar')

        <!-- left side bar -->
        @include('admin.layout.leftsidebar')

        <!-- main containt -->
        @yield('content')

    </div>
    <div class="modal fade" tabindex="-1" id="kt_modal_strip">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Contact with admin</h5>


                </div>

                <div class="modal-body">
                    <div class="text-center">
                        <a href="" id="url" class="btn btn-primary">Click Here</a>
                    </div>


                    <div class="row">

                        <div class="col-md-9 col-lg-9 col-xl-9 col-xxl-9 mb-md-3 mt-xl-5 flex-column">
                            <a href="#" id="" class="">Connect Support</a>
                        </div>
                        <div class="col-md-3 col-lg-3 col-xl-3 col-xxl-3 mb-md-3 mt-xl-5 flex-column text-right">
                            <a class="log_outs" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="btn btn-sm btn-icon btn-active-color-primary btn-icon-gray-600 btn-text-gray-600 pull-left">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr076.svg-->
                                <span class="svg-icon svg-icon-1 me-2">
                                    <i class="fa fa-sign-out" aria-hidden="true"></i> Log Out
                                </span>
                                <!--end::Svg Icon-->
                                <!--begin::Major-->

                                <!--end::Major-->
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            </span>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <!-- Javascript -->
    <script src="{{asset('assets/bundles/libscripts.bundle.js')}}"></script>
    <script src="{{asset('assets/bundles/vendorscripts.bundle.js')}}"></script>
    <script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
    <script src="{{asset('assets/vendor/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('assets/vendor/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/vendor/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
    <script src="{{asset('assets/vendor/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
    <script src="{{asset('assets/vendor/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
    <script src="{{asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>


    <script src="{{asset('assets/bundles/c3.bundle.js')}}"></script>
    <script src="{{asset('assets/bundles/chartist.bundle.js')}}"></script>
    <script src="{{asset('assets/vendor/toastr/toastr.js')}}"></script>
    <script src="{{asset('assets/vendor/sweetalert/sweetalert.min.js')}}"></script>
    <script src="{{asset('assets/bundles/mainscripts.bundle.js')}}"> </script>
    <script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
    <script src="{{asset('assets/js/index.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        var base_url = {!!json_encode(url('/')) !!}

        $("#select_language").select2({
            placeholder: "Select a language",
            allowClear: true
        });

        function changeLanguage(lang) {
            window.location = '{{url("change-language")}}/' + lang;
        }
    </script>
    <script>
        // $('#kt_modal_strip').modal({
        //     backdrop: 'static',
        //     keyboard: false
        // })

        function checkStripConnect() {

            // $("#kt_modal_strip").modal('show');
            // var strip_connect_url = $('#strip_connect_url').val();
            // if (strip_connect_url.length > 0) {
            //     $('#kt_modal_strip').modal({
            //         backdrop: 'static',
            //         keyboard: false
            //     })

            //     $("#kt_modal_strip").modal('show');
            //     $('#url').attr('href', strip_connect_url);
            // }


        }
        window.onload = checkStripConnect;
    </script>
    @yield('script')
</body>

</html>