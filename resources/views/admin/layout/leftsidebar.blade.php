<div id="left-sidebar" class="sidebar">
    <div class="navbar-brand">
        <a href="{{ url('/') }}"><img src="{{asset('assets/images/icon-dark.svg')}}" alt="Etsy Connector Logo" class="img-fluid logo"><span>Etsy Connector</span></a>
        <button type="button" class="btn-toggle-offcanvas btn btn-sm btn-default float-right"><i class="lnr lnr-menu fa fa-chevron-circle-left"></i></button>
    </div>
    <div class="sidebar-scroll">
        <div class="user-account">
            <div class="user_div">
                @if(Auth::user()->profile_image)
                <img src="{{asset('profile_images/')}}/{{Auth::user()->profile_image}}" class="user-photo" alt="User Profile Picture">
                @else
                <img src="{{asset('assets/images/user.png')}}" class="user-photo" alt="User Profile Picture">


                @endif
            </div>
            <div class="dropdown">
                <span>{{__('messages.welcome')}},</span>
                <a href="javascript:void(0);" class="dropdown-toggle user-name" data-toggle="dropdown"><strong> {{ Auth::user()->name }}</strong></a>
                <ul class="dropdown-menu dropdown-menu-right account">
                    <li class="{{ Request::segment(1) === 'edit-profile' ? 'active' : null }}"><a href="{{ url('edit-profile') }}"><i class="icon-user"></i><span>{{__('messages.edit_profile')}}</span></a></li>
                    <li class="{{ Request::segment(1) === 'change-password' ? 'active' : null }}"><a href="{{ url('change-password') }}"><i class="icon-lock"></i><span>{{__('messages.change_password')}}</span></a></li>
                    <!-- <li><a href="javascript:void(0);"><i class="icon-user"></i>My Profile</a></li> -->
                    <!-- <li><a href="javascript:void(0);"><i class="icon-envelope-open"></i>Messages</a></li> -->
                    <!-- <li><a href="javascript:void(0);"><i class="icon-settings"></i>Settings</a></li> -->
                    <li class="divider"></li>
                    <li><a href="javascript:void(0);"  data-toggle="modal" data-target="#kt_modal_strip"><i class="icon-power"></i>{{__('messages.logout')}}</a></li>
                </ul>
            </div>
        </div>
        <nav id="left-sidebar-nav" class="sidebar-nav">
            <ul id="main-menu" class="metismenu">
                
                @hasanyrole('Admin')
                <li class="{{ Request::segment(1) === 'home' ? 'active' : null }}"><a href="{{ url('/') }}"><i class="icon-home"></i><span>{{__('messages.dashboard')}}</span></a></li>
                <li class="{{ Request::segment(1) === 'subscriber' ? 'active' : null }}"><a href="{{ url('/subscriber') }}"><i class="icon-users"></i><span>{{__('messages.subscriber')}}</span></a></li>
                <li class="{{ Request::segment(1) === 'shop-list' ? 'active' : null }}"><a href="{{ url('/shop-list') }}"><i class="fa fa-shopping-cart"></i><span>{{__('messages.shop-list')}}</span></a></li>
                <li class="{{ Request::segment(1) === 'support' ? 'active' : null }}"><a href="{{ url('/support') }}"><i class="fa fa-phone"></i><span>{{__('messages.support')}}</span></a></li>

                @endhasanyrole
                @hasanyrole('Subscriber')
                <li class="{{ Request::segment(1) === 'my-shop' ? 'active' : null }}"><a href="{{ url('/my-shop') }}"><i class="fa fa-shopping-cart"></i><span>{{__('messages.myshop')}}</span></a></li>
                <li class="{{ Request::segment(1) === 'etsy-list-data' ? 'active' : null }}"><a href="{{ url('etsy-list-data') }}"><i class="fa fa-list"></i>{{__('messages.product_list')}}</a></li>

                @endhasanyrole
                <!-- <li class="{{ Request::segment(1) === 'edit-profile' ? 'active' : null }}"><a href="{{ url('edit-profile') }}"><i class="icon-user"></i><span>{{__('messages.edit_profile')}}</span></a></li>
                <li class="{{ Request::segment(1) === 'change-password' ? 'active' : null }}"><a href="{{ url('change-password') }}"><i class="icon-lock"></i><span>{{__('messages.change_password')}}</span></a></li> -->

                @hasanyrole('Adminn')
                <li class="{{ (Request::segment(1) === 'etsy-config') || (Request::segment(1) === 'etsy-list-data') || (Request::segment(1) === 'etsy-download-history')  ? 'active' : null }}">
                    <a href="#uiElements" class="has-arrow"><i class="icon-list"></i><span>{{__('messages.etsy_products')}}</span></a>
                    <ul>
                        <!-- <li class="{{ Request::segment(1) === 'etsy-config' ? 'active' : null }}"><a href="{{ url('etsy-config') }}">{{__('messages.etsy_config')}}</a></li> -->
                        <li class="{{ Request::segment(1) === 'etsy-list-data' ? 'active' : null }}"><a href="{{ url('etsy-list-data') }}">{{__('messages.product_list')}}</a></li>
                        <li class="{{ Request::segment(1) === 'etsy-download-history' ? 'active' : null }}"><a href="{{ url('etsy-download-history') }}">{{__('messages.etsy_download_history')}}</a></li>


                    </ul>
                </li>
                @endhasanyrole
                @hasanyrole('Admin')
                <li class="{{ (Request::segment(1) === 'country') || (Request::segment(1) === 'localization') || (Request::segment(1) === 'etsy-setting') || (Request::segment(1) === 'status') ? 'active' : null }}">
                    <a href="#uiElements" class="has-arrow"><i class="icon-settings"></i><span>{{__('messages.settings')}}</span></a>
                    <ul>
                        <li class="{{ Request::segment(1) === 'localization' ? 'active' : null }}"><a href="{{ url('localization') }}">{{__('messages.localization')}}</a></li>

                        <li class="{{ Request::segment(1) === 'country' ? 'active' : null }}"><a href="{{ url('country') }}">{{__('messages.country')}}</a></li>
                        <li class="{{ Request::segment(1) === 'etsy-setting' ? 'active' : null }}"><a href="{{ url('etsy-setting') }}">{{__('messages.etsy_setting')}}</a></li>
                        <li class="{{ Request::segment(1) === 'status' ? 'active' : null }}"><a href="{{ url('status') }}">{{__('messages.status')}}</a></li>


                    </ul>
                </li>
                @endhasanyrole
                <!-- @hasanyrole('Subscriber')
                <li class="{{ (Request::segment(1) === 'country')  ? 'active' : null }}">
                    <a href="#uiElements" class="has-arrow"><i class="icon-settings"></i><span>{{__('messages.settings')}}</span></a>
                    <ul>
                        <li class="{{ Request::segment(1) === 'localization' ? 'active' : null }}"><a href="{{ url('localization') }}">{{__('messages.localization')}}</a></li>



                    </ul>
                </li>
                @endhasanyrole -->



            </ul>
        </nav>
    </div>
</div>