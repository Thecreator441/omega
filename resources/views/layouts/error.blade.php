<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    {{--    <title>{{env('APP_NAME')}} | @yield('title')</title>--}}
    <title>@yield('title')</title>
    <link rel="apple-touch-icon" href="{{ asset('images/favicon.png') }}"/>
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}"/>
    <link rel="icon" href="{{ asset('images/favicon.png') }}">

    <!-- Custom -->
    <link href="{{ asset('css/myStyle.css') }}" rel="stylesheet">

    <!-- Select2 -->
    <link href="{{ asset('plugins/select2/css/select2.min.css') }}" rel="stylesheet">

    <!-- Bootstrap 3.3.7 -->
    <link href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="{{ asset('plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

    <!-- Flags Icon -->
{{--    <link href="{{ asset('plugins/flags-icon/css/flag-icon.min.css') }}" rel="stylesheet">--}}

<!-- Theme style -->
    <link href="{{ asset('css/AdminLTE/AdminLTE.min.css') }}" rel="stylesheet">

    <!-- Material Design -->
    <link href="{{ asset('css/bootstrap-material-design/bootstrap-material-design.min.css') }}" rel="stylesheet">

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue-light sidebar-mini">
<div class="wrapper">

    @yield('content')

</div>

<!-- jQuery 3 -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>

<!-- Material Design -->
{{--<script src="{{ asset('js/material.min.js') }}"></script>--}}

<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

<!-- ua-parser -->
<script src="{{ asset('plugins/ua-parser/ua-parser.pack.js') }}"></script>

@yield('script')

</body>
</html>
