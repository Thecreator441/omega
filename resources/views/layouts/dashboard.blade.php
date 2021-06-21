<?php

use App\Models\Institution;
use App\Models\AccDate;
use App\Models\Branch_Param;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

$emp = Session::get('employee');
$menus_1 = Session::get('menus_1');
$accdate = Session::get('accdate');
$bParam = null;
$level = null;
$menu = null;

if($emp->level === 'B') {
    $accdate = AccDate::getOpenAccDate();
    $bParam = Branch_Param::getBranchParam($emp->branch);
}

$institution = null;
$institute = null;
$tit = env('APP_NAME');

if ($emp->institution !== null) {
    $institution = Institution::getInstitution($emp->institution)->abbr;
    $institute = Institution::getInstitution($emp->institution);
    $tit = $institution;
}

if ($accdate !== null) {
    if ($accdate->accdate === null) {
        $accdate = AccDate::getOpenAccDate();
    }
}

if ($emp->lang === 'fr') {
    App::setLocale('fr');   
}

$uri = explode('?', $_SERVER["REQUEST_URI"]);
if (count($uri) > 1) {
    $params = explode('&', $uri[1]);
    $level = explode('=', $params[0])[1];
    $menu = explode('=', $params[1])[1];
}
?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{csrf_token()}}">
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        {{--<meta http-equiv="refresh" content="1000; url={{url('logout')}}" />--}}

        <title>{{env('APP_NAME', $institution)}} | @yield('title')</title>

        <link rel="apple-touch-icon" href="{{ asset('images/favicon.png') }}"/>
        <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}"/>
        <link rel="icon" href="{{ asset('images/favicon.png') }}">

        <!-- Select2 -->
        <link href="{{ asset('plugins/select2/css/select2.min.css') }}" rel="stylesheet">

        <!-- Bootstrap 3.3.7 -->
        <link href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

        <!-- Font Awesome -->
        <link href="{{ asset('plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

        <!-- Ionicons -->
        <link href="{{ asset('plugins/Ionicons/css/ionicons.min.css') }}" rel="stylesheet">

        <!-- iCheck for checkboxes and radio inputs -->
        {{--<link href="{{asset('plugins/iCheck/all.css')}}" rel="stylesheet">--}}

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
        <link rel="stylesheet" href="{{ asset('plugins/datatables/css/dataTables.bootstrap.min.css') }}"/>
        <link rel="stylesheet" href="{{ asset('plugins/datatables/FixedHeader-3.1.6/css/fixedHeader.bootstrap.min.css') }}"/>
        <link rel="stylesheet" href="{{ asset('plugins/datatables/Responsive-2.2.3/css/responsive.bootstrap.min.css') }}"/>

        <!-- Custom-->
        <link href="{{ asset('css/myStyle.css') }}" rel="stylesheet">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesnt work if you view the page via file -->
        <!--[if lt IE 9]-->
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <!--[endif]-->

        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    </head>

    <body class="hold-transition skin-blue-light sidebar-mini sidebar-collapse fixed" id="page-top">
        <input type="hidden" id="edit" value="{{$emp->edit}}">
        <input type="hidden" id="emp_level" value="{{$emp->level}}">
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
                                    @if($emp->pic === null)
                                        <img src="{{ asset('storage/logos/logo.png') }}" class="user-image" alt="{{ $emp->surname }}">
                                    @else
                                        @if ($emp->level !== 'P')
                                            <img src="{{ asset('storage/employees/profiles/'.$emp->pic) }}" class="user-image" alt="{{ $emp->surname }}">
                                        @elseif ($emp->level === 'P')
                                            <img src="{{ asset('storage/platforms/profiles/'.$emp->pic) }}" class="user-image" alt="{{ $emp->surname }}">
                                        @else
                                            <img src="{{ asset('storage/logos/logo.png') }}" class="user-image" alt="{{ $emp->surname }}">
                                        @endif
                                    @endif
                                    <span class="hidden-xs">{{$emp->name}}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        @if($emp->pic === null)
                                            <img src="{{ asset('storage/logos/logo.png') }}" class="img-circle" alt="{{ $emp->surname }}">
                                        @else
                                            @if ($emp->level !== 'P')
                                                <img src="{{ asset('storage/employees/profiles/'.$emp->pic) }}" class="img-circle" alt="{{ $emp->surname }}">
                                            @elseif ($emp->level === 'P')
                                                <img src="{{ asset('storage/platforms/profiles/'.$emp->pic) }}" class="img-circle" alt="{{ $emp->surname }}">
                                            @else
                                                <img src="{{ asset('storage/logos/logo.png') }}" class="img-circle" alt="{{ $emp->surname }}">
                                            @endif
                                        @endif
                                        <p>
                                            {{ $emp->name }}
                                            <small>{{ $emp->surname }}</small>
                                            <small>
                                                @if ($emp->lang == 'fr') {{$emp->labelfr}} @else {{$emp->labeleng}}@endif
                                                @if ($emp->level === 'O')
                                                    - @lang('label.organ')
                                                @elseif ($emp->level === 'N')
                                                    - @lang('label.network')  
                                                @elseif ($emp->level === 'Z')
                                                    - @lang('label.zone')
                                                @elseif ($emp->level === 'I')
                                                    - @lang('label.institution')
                                                @elseif ($emp->level === 'B')
                                                    - @lang('label.branch')
                                                @else
                                                    - @lang('label.platform')
                                                @endif
                                            </small>
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        {{--                                <div class="col-md-12 col-xs-12">--}}
                                        {{--                                    <a href="{{url('userprofile')}}" class="btn btn-sm"><i class="fa fa-user"></i>&nbsp;  @lang('label.vuserprof')</a>--}}
                                        {{--                                </div>--}}
                                        <div class="col-md-12 col-xs-12">
                                            <button type="button" class="btn btn-primary btn-sm" id="editPassBtn"><i class="fa fa-edit"></i>
                                                <span>@lang('sidebar.editpass')</span>
                                            </button>
                                        </div>
                                        <div class="col-md-12 col-xs-12">
                                            <form action="{{ url('logout') }}" method="POST" role="form" id="logOutForm">
                                                {{ csrf_field() }}

                                                <button type="button" class="btn btn-danger btn-sm" id="logOutBtn"><i class="fa fa-sign-out"></i>
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
                <!-- Content Header (Page header) -->
                <section class="content-header">

                </section>

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

                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title text-bold">@lang('label.session_block_warning')</h4>
                                </div>
                                <div class="modal-body">
                                    <p>@lang('auth.block_session') </p>
                                    <p>@lang('label.session_block_warning_duration') <span class="text-bold" id="sessionSecondsRemaining">120</span> <span id="second">@lang('label.seconds')</span>.</p>
                                </div>
                                <div class="modal-footer">
                                    <button id="extendSession" type="button" class="btn bg-green btn-sm" data-dismiss="modal">@lang('label.stay_online')</button>
                                    <button id="logoutSession" type="button" class="btn bg-grey btn-sm" data-dismiss="modal">@lang('label.block_session')</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 1.0.0
                </div>
                <strong>Copyright &copy; {{date('Y')}} <a href="https://tamcho-tech.com">{{env('APP_NAME', $institution)}}</a>.</strong> @lang('sidebar.footer')
                @if($emp->level === 'B')
                    <strong>@lang('label.accdate') : 
                        @if ($accdate !== null)
                            @if ($accdate->status === 'O') 
                                @if($accdate->accdate !== null)
                                    {{changeFormat($accdate->accdate)}}
                                @endif
                            @endif
                        @endif
                    </strong>
                @endif
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
        <script src="{{ asset('plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables/js/dataTables.bootstrap.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables/FixedHeader-3.1.6/js/dataTables.fixedHeader.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables/Responsive-2.2.3/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables/Responsive-2.2.3/js/responsive.bootstrap.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables/Buttons-1.6.1/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables/Buttons-1.6.1/js/buttons.flash.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables/Buttons-1.6.1/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables/Buttons-1.6.1/js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables/pdfmake-0.1.36/pdfmake.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables/pdfmake-0.1.36/vfs_fonts.js') }}"></script>
        <script src="{{ asset('plugins/datatables/JSZip-2.5.0/jszip.min.js') }}"></script>

        <!-- Select2 -->
        <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

        <!-- sweetalerts2 -->
        <script src="{{ asset('plugins/sweet-alerts/js/sweetalert.min.js') }}"></script>

        <!-- iCheck for checkboxes and radio inputs -->
        {{--<script src="{{asset('plugins/iCheck/icheck.min.js')}}"></script>--}}

        <!-- accounting -->
        <script src="{{ asset('plugins/accounting/js/accounting.min.js') }}"></script>

        <!-- date -->
        @if ($emp->lang === 'fr')
            <script src="{{ asset('plugins/date/js/date-fr-FR.js') }}"></script>
        @else
            <script src="{{ asset('plugins/date/js/date-en-GB.js') }}"></script>
        @endif

        <!-- Select2 -->
        <script src="{{ asset('plugins/written-number/js/written-number.min.js') }}"></script>

        <!-- AdminLTE App -->
        <script src="{{ asset('js/adminlte/adminlte.min.js') }}"></script>

        <!-- SlimScroll -->
        <script src="{{ asset('plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>

        <!-- Sisyphus -->
        <script src="{{ asset('plugins/sisyphus/sisyphus.min.js') }}"></script>

        <!-- Custom -->
        <script src="{{ asset('js/myScript.js') }}"></script>

        <!-- Custom -->
        <script src="{{ asset('plugins/jsPDF/jspdf.min.js') }}"></script>
        <script src="{{ asset('plugins/jsPDF/jspdf.debug.js') }}"></script>
        <script src="{{ asset('plugins/jsPDF/jspdf.plugin.autotable.js') }}"></script>

        <script>
            // let plat_param = JSON.parse(localStorage.getItem('plat_param'));

            $(document).ready(function () {
                $("form").prepend("<input type='hidden' name='level' value='{{ $level }}'><input type='hidden' name='menu' value='{{ $menu }}'>");
                
                // if ($('#edit').val() !== 'null') {
                //     let changeURL = "{{url('user/change')}}";
                //     if ($('#emp_level').val() !== 'A') {
                //         changeURL = "{{url('admin/user/change')}}";
                //     }
                //     swal({
                //         title: "@lang('label.editpass')",
                //         icon: 'info',
                //         closeOnClickOutside: false,
                //         allowOutsideClick: false,
                //         closeOnEsc: false,
                //         content: {
                //             element: 'input',
                //             attributes: {
                //                 placeholder: "@lang('placeholder.newpass')",
                //                 type: 'password',
                //                 autocapitalize: 'off',
                //             }
                //         },
                //         buttons: {
                //             confirm: {
                //                 text: " @lang('label.edit')",
                //                 visible: true,
                //                 closeModal: false,
                //                 className: "btn bg-aqua fa fa-edit"
                //             },
                //         },
                //     }).then(function (result) {
                //         if (result) {
                //             post(changeURL, {user: '{{$emp->iduser}}', password: result, _token: '{{csrf_token()}}'});
                //         } else {
                //             swal({
                //                 title: "@lang('label.editpass')",
                //                 icon: 'warning',
                //                 closeOnClickOutside: false,
                //                 allowOutsideClick: false,
                //                 closeOnEsc: false,
                //                 content: {
                //                     element: 'input',
                //                     attributes: {
                //                         placeholder: "@lang('placeholder.newpass')",
                //                         type: 'password',
                //                         autocapitalize: 'off',
                //                     }
                //                 },
                //                 buttons: {
                //                     confirm: {
                //                         text: " @lang('label.edit')",
                //                         visible: true,
                //                         closeModal: false,
                //                         className: "btn bg-aqua fa fa-edit"
                //                     },
                //                 },
                //             }).then(function (result) {
                //                 if (result) {
                //                     post(changeURL, {user: '{{$emp->iduser}}', password: result, _token: '{{csrf_token()}}'});
                //                 } else {
                //                     swal({
                //                         title: "@lang('label.editpass')",
                //                         icon: 'error',
                //                         closeOnClickOutside: false,
                //                         allowOutsideClick: false,
                //                         closeOnEsc: false,
                //                         content: {
                //                             element: 'input',
                //                             attributes: {
                //                                 placeholder: "@lang('placeholder.newpass')",
                //                                 type: 'password',
                //                                 autocapitalize: 'off',
                //                             }
                //                         },
                //                         buttons: {
                //                             confirm: {
                //                                 text: " @lang('label.edit')",
                //                                 visible: true,
                //                                 closeModal: true,
                //                                 className: "btn bg-aqua fa fa-edit"
                //                             },
                //                         },
                //                     }).then(function (result) {
                //                         if (result) {
                //                             post(changeURL, {user: '{{$emp->iduser}}', password: result, _token: '{{csrf_token()}}'});
                //                         } else {
                //                             location.href = '{{url('edit_logout')}}'
                //                         }
                //                     });
                //                 }
                //             });
                //         }
                //     });
                // }
                
                // $.ajax({
                //     url: "{{url('getPlatParam')}}",
                //     method: 'GET',
                //     success: function (response) {
                //         localStorage.setItem('plat_param', JSON.stringify(response));
                //         sessionStorage.setItem('plat_param', JSON.stringify(response));
                //     }
                // });
                    
                // Datatable initialisation
                $('#admin-data-table, #admin-data-table2').DataTable({
                    paging: true,
                    info: true,
                    responsive: true,
                    ordering: true,
                    FixedHeader: true,
                    language: {
                        url: "{{ asset("plugins/datatables/lang/$emp->lang.json") }}",
                    },
                    dom: 'lBfrtip',
                    buttons: [
                        {
                            extend: 'copy',
                            text: '',
                            className: 'buttons-copy btn btn-sm bg-blue btn-raised fa fa-copy',
                            titleAttr: "@lang('label.copy')",
                        },
                        {
                            extend: 'excel',
                            text: '',
                            className: 'buttons-excel btn btn-sm bg-blue btn-raised fa fa-file-excel-o',
                            titleAttr: "@lang('label.excel')",
                        },
                        {
                            extend: 'pdf',
                            text: '',
                            className: 'buttons-pdf btn btn-sm bg-blue btn-raised fa fa-file-pdf-o',
                            titleAttr: "@lang('label.pdf')",
                        },
                        {
                            extend: 'print',
                            text: '',
                            className: 'buttons-print btn btn-sm bg-blue btn-raised fa fa-print',
                            titleAttr: "@lang('label.print')",
                        }
                    ],
                    dom:
                        "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                });
                
                $('#commis-data-table').DataTable({
                    "lengthMenu": [[-1, 10, 25, 50, 100], ["All", 10, 25, 50, 100]],
                    paging: true,
                    info: true,
                    responsive: true,
                    ordering: true,
                    FixedHeader: true,
                    language: {
                        url: "{{ asset("plugins/datatables/lang/$emp->lang.json") }}",
                    },
                    dom: 'lBfrtip',
                    buttons: [
                        {
                            extend: 'copy',
                            text: '',
                            className: 'buttons-copy btn btn-sm bg-blue btn-raised fa fa-copy',
                            titleAttr: "@lang('label.copy')",
                        },
                        {
                            extend: 'excel',
                            text: '',
                            className: 'buttons-excel btn btn-sm bg-blue btn-raised fa fa-file-excel-o',
                            titleAttr: "@lang('label.excel')",
                        },
                        {
                            extend: 'pdf',
                            text: '',
                            className: 'buttons-pdf btn btn-sm bg-blue btn-raised fa fa-file-pdf-o',
                            titleAttr: "@lang('label.pdf')",
                        },
                        {
                            extend: 'print',
                            text: '',
                            className: 'buttons-print btn btn-sm bg-blue btn-raised fa fa-print',
                            titleAttr: "@lang('label.print')",
                        }
                    ],
                    dom:
                        "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                });

                $('#state-data-table, #state-data-table2').DataTable({
                    paging: true,
                    info: true,
                    responsive: true,
                    ordering: false,
                    FixedHeader: true,
                    language: {
                        url: "{{ asset("plugins/datatables/lang/$emp->lang.json") }}",
                    }
                });

                $('#billet-data-table, #billet-data-table2').DataTable({
                    paging: false,
                    info: false,
                    responsive: true,
                    ordering: false,
                    FixedHeader: true,
                    language: {
                        url: "{{ asset("plugins/datatables/lang/$emp->lang.json") }}",
                    },
                    searching: false
                });

                $('#other-data-table, #other-data-table2').DataTable({
                    paging: true,
                    pageLength: 10,
                    info: true,
                    responsive: true,
                    ordering: false,
                    FixedHeader: true,
                    lengthChange: false,
                    language: {
                        url: "{{ asset("plugins/datatables/lang/$emp->lang.json") }}",
                    },
                    searching: false
                });

                $('#logOutBtn').click(function () {
                    mySwal("@lang('sidebar.user')", "@lang('confirm.logout_text')", "@lang('confirm.no')", "@lang('confirm.yes')", '#logOutForm');
                });

                // $('#editPassBtn').click(function () {
                //     swal({
                //         title: "@lang('label.editpass')",
                //         icon: 'info',
                //         closeOnClickOutside: true,
                //         allowOutsideClick: false,
                //         closeOnEsc: true,
                //         content: {
                //             element: 'input',
                //             attributes: {
                //                 placeholder: "@lang('placeholder.oldpass')",
                //                 type: 'password',
                //                 autocapitalize: 'off',
                //             }
                //         },
                //         buttons: {
                //             confirm: {
                //                 text: " @lang('label.next')",
                //                 visible: true,
                //                 closeModal: true,
                //                 className: "btn bg-aqua fa fa-arrow-right"
                //             },
                //         },
                //     }).then(function (result) {
                //         if (result) {
                //             swal({
                //                 title: "@lang('label.editpass')",
                //                 icon: 'info',
                //                 closeOnClickOutside: true,
                //                 allowOutsideClick: false,
                //                 closeOnEsc: true,
                //                 content: {
                //                     element: 'input',
                //                     attributes: {
                //                         placeholder: "@lang('placeholder.newpass')",
                //                         type: 'password',
                //                         autocapitalize: 'off',
                //                     }
                //                 },
                //                 buttons: {
                //                     confirm: {
                //                         text: " @lang('label.edit')",
                //                         visible: true,
                //                         closeModal: true,
                //                         className: "btn bg-aqua fa fa-edit"
                //                     },
                //                 },
                //             }).then(function (result2) {
                //                 if (result2) {
                //                     @if($emp->level === 'A')
                //                         post('{{url('admin/user/update')}}', {user: '{{$emp->iduser}}', oldpass: result, password: result2, _token: '{{csrf_token()}}'});
                //                     @else
                //                         post('{{url('user/update')}}', {user: '{{$emp->iduser}}', oldpass: result, password: result2, _token: '{{csrf_token()}}'});
                //                     @endif
                //                 }
                //             });
                //         }
                //     });
                // });

                $('.fa-save').prop('title', "@lang('label.save')");
                $('.fa-edit').prop('title', "@lang('label.edit')");
                $('.fa-trash').prop('title', "@lang('label.delete')");
                $('.fa-trash-o').prop('title', "@lang('label.delete')");
                $('.fa-view').prop('title', "@lang('label.view')");
                $('.fa-recycle').prop('title', "@lang('label.reset')");
                $('.fa-refresh').prop('title', "@lang('label.reset')");
                $('.fa-check').prop('title', "@lang('label.free')");
                $('.fa-close').prop('title', "@lang('label.block')");
                $('.fa-print').prop('title', "@lang('label.print')");
                $('.fa-file-pdf-o').prop('title', "@lang('label.pdf')");
                $('.fa-file-excel-o').prop('title', "@lang('label.excel')");
                $('.fa-copy').prop('title', "@lang('label.copy')");
            });

            $('.backup').click(function () {
                swal({
                    icon: 'warning',
                    title: "@lang('sidebar.backup')",
                    text: "@lang('confirm.backup_text')",
                    closeOnClickOutside: false,
                    allowOutsideClick: false,
                    closeOnEsc: false,
                    buttons: {
                        cancel: {
                            text: " @lang('confirm.no')",
                            value: false,
                            visible: true,
                            closeModal: true,
                            className: "btn bg-red fa fa-close"
                        },
                        confirm: {
                            text: " @lang('confirm.yes')",
                            value: true,
                            visible: true,
                            closeModal: true,
                            className: "btn bg-green fa fa-check"
                        },
                    },
                }).then(function (isConfirm) {
                    if (isConfirm) {
                        $('#backUp').submit();
                    }
                });
            });

            // (function ($) {
            //     let session = {
            //         inactiveTimeout: parseInt(plat_param.inactive_duration),     //(ms) The time until we display a warning message
            //         warningTimeout: Math.round(parseInt(plat_param.inactive_duration) / 4),      //(ms) The time until we log them out
            //         minWarning: Math.round((parseInt(plat_param.inactive_duration) * 0.025) / 10),           //(ms) If they come back to page (on mobile), The minumum amount, before we just log them out
            //         warningStart: null,         //Date time the warning was started
            //         warningTimer: null,         //Timer running every second to countdown to logout
            //         warning: function () {       //Logout function once warningTimeout has expired
            //             swal({
            //                 title: "@lang('sidebar.user')",
            //                 icon: 'info',
            //                 closeOnClickOutside: false,
            //                 allowOutsideClick: false,
            //                 closeOnEsc: false,
            //                 content: {
            //                     element: 'input',
            //                     attributes: {
            //                         placeholder: "@lang('placeholder.password')",
            //                         type: 'password',
            //                         autocapitalize: 'off',
            //                     }
            //                 },
            //                 buttons: {
            //                     confirm: {
            //                         text: " @lang('label.verify')",
            //                         visible: true,
            //                         closeModal: false,
            //                         className: "btn bg-green fa fa-check"
            //                     },
            //                 },
            //             }).then(function (result) {
            //                 if (result) {
            //                     $.ajax({
            //                         url: "{{url('check_session')}}",
            //                         method: "POST",
            //                         data: {
            //                             user: '{{$emp->iduser}}', 
            //                             password: result, 
            //                             _token: '{{csrf_token()}}'
            //                         },
            //                         success: function (response) {
            //                             if (response.success) {
            //                                 swal({
            //                                     icon: 'success',
            //                                     title: "@lang('sidebar.user')",
            //                                     text: response.success,
            //                                     closeOnClickOutside: false,
            //                                     allowOutsideClick: false,
            //                                     closeOnEsc: false,
            //                                     buttons: {
            //                                         confirm: {
            //                                             text: "OK",
            //                                             value: true,
            //                                             visible: true,
            //                                             closeModal: true,
            //                                             className: "btn bg-blue"
            //                                         },
            //                                     },
            //                                 });
            //                                 localStorage.removeItem('classic_verif_user');
            //                                 sessionStorage.removeItem('classic_verif_user');
            //                             }
                        
            //                             if (response.danger) {
            //                                 location.href = '{{url('edit_logout')}}';
            //                             }
            //                         }
            //                     });
            //                     // post("{{url('check_session')}}", {user: '{{$emp->iduser}}', password: result, _token: '{{csrf_token()}}'});
            //                 } else {
            //                     location.href = '{{url('edit_logout')}}';
            //                 }
            //             });
            //         },

            //         // Keepalive Settings
            //         keepaliveTimer: null,
            //         keepaliveUrl: "",
            //         keepaliveInterval: Math.round(parseInt(plat_param.inactive_duration) / 2),     //(ms) the interval to call said url
            //         keepAlive: function () {
            //             // $.ajax({ url: session.keepaliveUrl });
            //         }
            //     };
                
            //     if (localStorage.hasOwnProperty('classic_verif_user') || sessionStorage.hasOwnProperty('classic_verif_user')) {
            //         session.warning();
            //     }
                
            //     $(document).on("idle.idleTimer", function (event, elem, obj) {
            //         //Get time when user was last active
            //         var diff = (+new Date()) - obj.lastActive - obj.timeout,
            //             warning = (+new Date()) - diff;
                    
            //         //On mobile js is paused, so see if this was triggered while we were sleeping
            //         if (diff >= session.warningTimeout || warning <= session.minWarning) {
            //             $("#mdlLoggedOut").modal("show");
            //         } else {
            //                 //Show dialog, and note the time
            //                 $('#sessionSecondsRemaining').html(Math.round((session.warningTimeout - diff) / 1000));
                            
            //                 $("#myModal").modal("show");
                            
            //                 session.warningStart = (+new Date()) - diff;

            //                 //Update counter downer every second
            //                 session.warningTimer = setInterval(function () {
            //                     let remaining = Math.round((session.warningTimeout / 1000) - (((+new Date()) - session.warningStart) / 1000));
            //                     if (remaining >= 0) {
            //                         $('#sessionSecondsRemaining').html(remaining);
            //                         if(remaining >= 10) {
            //                             $('#second').html("@lang('label.seconds')");
            //                         } else {
            //                             $('#second').html("@lang('label.second')");
            //                         }
            //                     } else {
            //                         session.warning();
            //                         localStorage.setItem('classic_verif_user', 'user_blocked');
            //                         sessionStorage.setItem('classic_verif_user', 'user_blocked');
            //                         $("#myModal").modal("hide");
            //                     }
            //                 }, parseInt(plat_param.inactive_duration))
            //             }
            //     });

            //     // create a timer to keep server session alive, independent of idle timer
            //     session.keepaliveTimer = setInterval(function () {
            //         session.keepAlive();
            //     }, session.keepaliveInterval);

            //     //User clicked ok to extend session
            //     $("#extendSession").click(function () {
            //         clearTimeout(session.warningTimer);
            //     });
                
            //     //User clicked logout
            //     $("#logoutSession").click(function () {
            //         session.warning();
            //         localStorage.setItem('classic_verif_user', 'blocked');
            //         sessionStorage.setItem('classic_verif_user', 'blocked');
            //         $("#myModal").modal("hide");
            //     });

            //     //Set up the timer, if inactive for 10 seconds log them out
            //     $(document).idleTimer(session.inactiveTimeout);
            // })(jQuery);

            function fillHidden(customer) {
                $.ajax({
                    url: "{{url('getNetwork')}}",
                    method: 'GET',
                    data: {
                        id: customer.network
                    },
                    success: function (network) {
                        $('#net').val(network.name);
                        $('#netTel').val(network.phone1);
                    }
                });

                $.ajax({
                    url: "{{url('getZone')}}",
                    method: 'GET',
                    data: {
                        id: customer.zone
                    },
                    success: function (zone) {
                        $('#zon').val(zone.name);
                        $('#zonTel').val(zone.phone1);
                    }
                });

                $.ajax({
                    url: "{{url('getInstitution')}}",
                    method: 'GET',
                    data: {
                        id: customer.institution
                    },
                    success: function (institution) {
                        $('#ins').val(institution.name);
                        $('#insTel').val(institution.phone1);
                    }
                });

                $.ajax({
                    url: "{{url('getBranch')}}",
                    method: 'GET',
                    data: {
                        id: customer.branch
                    },
                    success: function (branch) {
                        $('#bra').val(branch.name);
                        $('#braTel').val(branch.phone1);
                    }
                });
            }
        </script>

        @yield('script')

    </body>
</html>
