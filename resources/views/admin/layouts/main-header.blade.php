<!-- main-header opened -->
<div class="main-header sticky side-header nav nav-item">
    <div class="container-fluid">
        <div class="main-header-left ">
            <div class="responsive-logo">
                <a href="{{ url('/' . ($page = 'index')) }}"><img
                        src="{{ URL::asset('assets/admin/img/logo_tabrat.png') }}" class="logo-1" alt="logo"></a>
                <a href="{{ url('/' . ($page = 'index')) }}"><img
                        src="{{ URL::asset('assets/admin/img/logo_tabrat.png') }}" class="dark-logo-1"
                        alt="logo"></a>
                <a href="{{ url('/' . ($page = 'index')) }}"><img
                        src="{{ URL::asset('assets/admin/img/logo_tabrat.png') }}" class="logo-2"
                        alt="logo"></a>
                <a href="{{ url('/' . ($page = 'index')) }}"><img
                        src="{{ URL::asset('assets/admin/img/logo_tabrat.png') }}" class="dark-logo-2"
                        alt="logo"></a>
            </div>
            <div class="app-sidebar__toggle" data-toggle="sidebar">
                <a class="open-toggle" href="#"><i class="header-icon fe fe-align-left"></i></a>
                <a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>
            </div>

        </div>
        <div class="main-header-right">
            <ul class="nav">
            </ul>
            <div class="nav nav-item  navbar-nav-right ml-auto">
                <div class="nav-item full-screen fullscreen-button">
                    <a class="new nav-link full-screen-link" href="#"><svg xmlns="http://www.w3.org/2000/svg"
                            class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-maximize">
                            <path
                                d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3">
                            </path>
                        </svg></a>
                </div>
                <div class="dropdown main-profile-menu nav nav-item nav-link">

                        <a class="profile-user d-flex" href=""><img alt=""
                                                                    src="{{ URL::asset('assets/admin/img/logo_tabrat.png') }}"></a>


                    <div class="dropdown-menu">
                        <div class="main-header-profile bg-primary p-3">
                            <div class="d-flex wd-100p">

                                    <div class="main-img-user"><img alt=""
                                                                    src="{{ URL::asset('assets/admin/img/logo_tabrat.png') }}" class="">
                                    </div>


                                <div class="mr-3 my-auto">
                                    <span>  @if(\Illuminate\Support\Facades\Auth::guard('center')->check())
                                            {{Auth::guard('center')->user()->name}}
                                        @elseif(Auth::check())
                                            {{Auth::user()->name}}
                                        @endif  </span>
                                </div>
                            </div>
                        </div>
                        <a class="dropdown-item" href="{{url('admin/update_admin_details')}}"><i class="bx bx-user-circle"></i> حسابي  </a>
                        <a class="dropdown-item" href="{{url('admin/update_admin_password')}}"><i class="bx bx-cog"></i> تعديل كلمة المرور </a>

                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();document.getElementById('logout-form2').submit();"><i
                                    class="bx bx-log-out"></i>
                                تسجيل خروج </a>
                            <form id="logout-form2" action="{{ route('logout') }}" method="post"
                                style="display: none">
                                @csrf
                            </form>


                    </div>
                </div>
{{--                <div class="dropdown main-header-message right-toggle">--}}
{{--                    <a class="nav-link pr-0" data-toggle="sidebar-left" data-target=".sidebar-left">--}}
{{--                        <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24"--}}
{{--                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"--}}
{{--                            stroke-linejoin="round" class="feather feather-menu">--}}
{{--                            <line x1="3" y1="12" x2="21" y2="12"></line>--}}
{{--                            <line x1="3" y1="6" x2="21" y2="6"></line>--}}
{{--                            <line x1="3" y1="18" x2="21" y2="18"></line>--}}
{{--                        </svg>--}}
{{--                    </a>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
</div>
<!-- /main-header -->
