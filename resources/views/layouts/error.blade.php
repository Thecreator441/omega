<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <title>OMEGA | @yield('title')</title>

    <!-- Custom -->
    <link href="{{ asset('css/myStyle.css') }}" rel="stylesheet">
    <!-- Bootstrap 3.3.7 -->
    <link href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
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
<script src="{{ asset('plugins/jquery/dist/jquery.min.js') }}"></script>

<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>

<!-- Material Design -->
<script src="{{ asset('js/material.min.js') }}"></script>

<script>
    {{--$(document).ready(function () {--}}
    {{--    $('#button').on('click', function (e) {--}}
    {{--        e.preventDefault();--}}

    {{--        // $.ajaxSetup({--}}
    {{--        //     headers: {--}}
    {{--        //         'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')--}}
    {{--        //     }--}}
    {{--        // });--}}
    {{--        let _token = $("input[name='_token']").val();--}}
    {{--        $.ajax({--}}
    {{--            url: "{{ url('omeg/login') }}",--}}
    {{--            type: 'POST',--}}
    {{--            data: {--}}
    {{--                '_token': _token,--}}
    {{--                'name': $('#name').val(),--}}
    {{--                'password': $('#password').val()--}}
    {{--            },--}}
    {{--            success: function (data) {--}}
    {{--                if ($.isEmptyObject(data.error)) {--}}
    {{--                    alert(data.success);--}}
    {{--                } else {--}}
    {{--                    console.log(data.error);--}}
    {{--                }--}}
    {{--            }--}}
    {{--        });--}}
    {{--    })--}}
    {{--})--}}
</script>

</body>
</html>
