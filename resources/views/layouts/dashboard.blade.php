<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

$emp = Session::get('employee');
if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <title>@yield('title')</title>

    <link rel="apple-touch-icon" href="{{ asset('images/favicon.png') }}"/>
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}"/>
    <link rel="icon" href="{{ asset('images/favicon.png') }}">

    <!-- Select2 -->
    <link href="{{ asset('plugins/select2/css/select2.min.css') }}" rel="stylesheet">

    <!-- Bootstrap 3.3.7 -->
    <link href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="{{ asset('plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

    <!-- iCheck for checkboxes and radio inputs -->
{{--    <link href="{{asset('plugins/iCheck/all.css')}}" rel="stylesheet">--}}

    <!-- Flags Icon -->
    <link href="{{ asset('plugins/flags-icon/css/flag-icon.min.css') }}" rel="stylesheet">

    <!-- Theme style -->
    <link href="{{ asset('css/AdminLTE/AdminLTE.min.css') }}" rel="stylesheet">

    <!-- Material Design -->
    <link href="{{ asset('css/bootstrap-material-design/bootstrap-material-design.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/ripples/ripples.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/MaterialAdminLTE/MaterialAdminLTE.min.css') }}" rel="stylesheet">

    <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('css/skins/all-md-skins.min.css') }}">

    <!-- sweetalerts2 -->
    <link href="{{ asset('plugins/sweet-alerts/css/sweetalert.css') }}" rel="stylesheet">

    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables.net-bs/css/dataTables.bootstrap.min.css') }}"/>
{{--    <link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/buttons.dataTables.min.css') }}"/>--}}

<!-- Custom-->
    <link href="{{ asset('css/myStyle.css') }}" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-blue-light sidebar-mini sidebar-collapse">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><img src="{{ asset('images/favicon.png') }}" alt=""></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><img src="{{ asset('images/dashLogo.png') }}" alt=""></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Language Changing -->
                    <li class="dropdown notifications-menu">
                        @if ($emp->lang == 'fr')
                            <a href="{{ url('lang/eng') }}"><i class="flag-icon flag-icon-gb"></i></a>
                        @else
                            <a href="{{ url('lang/fr') }}"><i class="flag-icon flag-icon-fr"></i></a>
                        @endif
                    </li>
                    <!-- User Account -->
                    <li class="dropdown user user-menu">
                        <a href="" data-toggle="dropdown">
                            <img src="{{ asset($emp->pic) }}" class="user-image"
                                 alt="{{ $emp->surname }}">
                            <span class="hidden-xs">{{ $emp->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="{{ asset($emp->pic) }}" class="img-circle"
                                     alt="{{ $emp->surname }}">
                                <p>
                                    {{ $emp->name }}
                                    <small>{{ $emp->surname }}</small>
                                    <small>@if ($emp->lang == 'fr') {{ $emp->labelfr }} @else {{ $emp->labeleng }} @endif</small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="col-md-12 text-center">
                                    <form action="{{ url('logout') }}" method="POST" role="form" id="logOutForm">
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn btn-danger"><i class="fa fa-sign-out"></i>
                                            <span>@lang('sidebar.discon')</span>
                                        </button>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

@include('layouts.includes.aside')

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                                </button>
                                <h4><i class="icon fa fa-check"></i>Success!</h4>
                                {{ $message }}
                            </div>
                        @elseif ($message = Session::get('danger'))
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                                </button>
                                <h4><i class="icon fa fa-warning"></i> @if($emp->lang == 'fr') Alerte! @else
                                        Alert! @endif</h4>
                                {{ $message }}
                            </div>
                        @endif
                        <div class="alert alert-success alert-dismissible" id="alert_success" style="display: none">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                            </button>
                            <h4><i class="icon fa fa-check"></i>Success!</h4>
                            <span id="success_message"></span>
                        </div>

                        <div class="alert alert-danger alert-dismissible" id="alert_danger" style="display: none">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                            </button>
                            <h4><i class="icon fa fa-warning"></i> @if($emp->lang == 'fr') Alerte! @else
                                    Alert! @endif</h4>
                            <span id="danger_message"></span>
                        </div>
                    </div>
                </div>
            </div>

            @yield('content')
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; 2019 <a href="http://tamcho-tech.com">OMEGA</a>.</strong> @lang('sidebar.footer')
    </footer>
</div>

<!-- jQuery 3 -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->

<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>

<!-- Material Design -->
<script src="{{ asset('js/material/material.min.js') }}"></script>
<script src="{{ asset('js/ripples/ripples.min.js') }}"></script>

<!-- DataTables -->
<script src="{{ asset('plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>

<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

<!-- sweetalerts2 -->
<script src="{{ asset('plugins/sweet-alerts/js/sweetalert.min.js') }}"></script>

<!-- iCheck for checkboxes and radio inputs -->
{{--<script src="{{asset('plugins/iCheck/icheck.min.js')}}"></script>--}}

<!-- accounting -->
<script src="{{ asset('plugins/accounting/js/accounting.min.js') }}"></script>

<!-- date -->
@if ($emp->lang == 'fr')
    <script src="{{ asset('plugins/date/js/date-en-GB.js') }}"></script>
@else
    <script src="{{ asset('plugins/date/js/date-fr-FR.js') }}"></script>
@endif

<!-- Select2 -->
<script src="{{ asset('plugins/written-number/js/written-number.min.js') }}"></script>

<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte/adminlte.min.js') }}"></script>

<!-- Custom-->
<script src="{{ asset('js/myScript.js') }}"></script>

@yield('script')

</body>
</html>
