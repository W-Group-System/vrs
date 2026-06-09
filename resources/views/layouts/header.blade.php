<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title>@yield('title', 'Visitor Registration System')</title>
    <link rel="icon" type="image/x-icon" href="{{URL::asset('/images/visitor.png')}}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <!-- Toastr style -->
    <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet">
    @yield('css')
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <style>
        .loader {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url("{{ asset('/images/3.gif')}}") 50% 50% no-repeat white ;
            opacity: .8;
            background-size:120px 120px;
        }
    </style>
</head>
<body>
    <div id="loader" style="display:none;" class="loader">
    </div>
    <div id="app">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="{{ asset('/images/user.png')}}" width="50px"/>
                            </span>
                            @auth
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{auth()->user()->name}}</strong>
                                    <span class="clear"> <span class="block m-t-xs">{{auth()->user()->email}}
                                    </span> <span class="text-muted text-xs block">{{auth()->user()->position}}&nbsp;<b class="caret"></b></span> </span> 
                                </a>
                                <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                    <li><a href="{{ route('change_password') }}">{{ __('Change Password') }}</a></li> 
                                    <li class="divider"></li>
                                    <li>
                                        <a href="{{ route('logout') }}" onclick="logout(); show();">{{ __('Logout') }}</a>
                                    </li>
                                </ul>
                            @endauth
                        </div>
                        <div class="logo-element">VRS</div>
                    </li>
                    <li>
                        <a href="{{ url('/dashboard') }}"><i class="fa fa-th-large"></i><span class="nav-label">Dashboards</span></a>
                    </li>
                    <li>
                        <a href="{{ url('/visitor_id') }}"><i class="fa fa-id-badge"></i><span class="nav-label">Visitor ID Cards</span></a>
                    </li>
                    <li>
                        <a href="{{ url('/visitor_id_returned') }}"><i class="fa fa-id-badge"></i><span class="nav-label">Returned Visitor ID Cards</span></a>
                    </li>
                    <li>
                        <a href="{{ url('/report') }}"><i class="fa fa-building"></i><span class="nav-label">Reports</span></a>
                    </li>
                    @if (@auth()->user()->role == 'Admin')
                    <li>
                        <a href="{{ url('/tenant') }}"><i class="fa fa-home"></i><span class="nav-label">Tenants</span></a>
                    </li>
                    @endif
                    @if (@auth()->user()->position == 'Administrator' && (@auth()->user()->name == 'Admin'))
                    <li>
                        <a href="{{ url('/building') }}"><i class="fa fa-building"></i><span class="nav-label">Buildings</span></a>
                    </li>
                    <li>
                        <a href="{{ url('/user') }}"><i class="fa fa-users" aria-hidden="true"></i><span class="nav-label">Users</span></a>
                    </li>
                    @endif
                </ul>
            </div>
        </nav>
        
        <div id="page-wrapper" class="gray-bg dashbard-1">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-success " href="#"><i class="fa fa-bars"></i> </a>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <span class="m-r-sm text-muted welcome-message">Welcome to <b>Visitor Registration System</b></span>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}" onclick="logout(); show();">
                                <i class="fa fa-sign-out"></i> Log out
                            </a>
                        </li>
                    </ul>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </nav>
            </div>
            <div class="wrapper">
                @yield('content')
            </div>
            <div class="footer">
                <div class="pull-right">
                    <strong>WGROUP</strong> DEVELOPER &copy; {{date('Y')}}
                </div>
            </div>
        </div>
    </div>

    <script>
        function show() {
            document.getElementById("loader").style.display="block";
        }
        function logout() {
            event.preventDefault();
            document.getElementById('logout-form').submit();
        }
    </script>



    <!-- Mainly scripts --> 
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
 
    <!-- Flot -->
    <script src="{{ asset('js/plugins/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.spline.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.pie.js') }}"></script>
 
    <!-- Peity -->
    <script src="{{ asset('js/plugins/peity/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('js/demo/peity-demo.js') }}"></script>
 
    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
 
    <!-- jQuery UI -->
    <script src="{{ asset('js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
 
    <!-- GITTER -->
    <script src="{{ asset('js/plugins/gritter/jquery.gritter.min.js') }}"></script>
 
    <!-- Sparkline -->
    <script src="{{ asset('js/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
 
    <!-- Sparkline demo data  -->
    <script src="{{ asset('js/demo/sparkline-demo.js') }}"></script>
 
    <!-- ChartJS-->
    <script src="{{ asset('js/plugins/chartJs/Chart.min.js') }}"></script>
 
    <!-- Toastr -->
    <script src="{{ asset('js/plugins/toastr/toastr.min.js') }}"></script>

    <!-- DataTables -->
    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    @include('sweetalert::alert')
    @yield('footer')
    
</body>
</html>