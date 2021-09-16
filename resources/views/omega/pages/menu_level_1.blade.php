<?php
$emp = Session::get('employee');

$title = $menu->labeleng;
if ($emp->lang == 'fr') {
    $title = $menu->labelfr;
    App::setLocale('fr');
}
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')
    <div class="box box-info" id="newForm" style="display: none;">
        <div class="box-header with-border">
            <h3 class="box-title text-bold" id="title">@lang('label.new_menu_level_1')</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right" id="exitForm">
                    <i class="fa fa-close"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <form action="{{ route('menu_level_1/store') }}" method="post" role="form" id="main_menuForm" class="needs-validation">
                {{ csrf_field() }}

                <div id="fillform">
                    <input type="hidden" name="idmain_menu" id="idmain_menu">

                    <div class="row">
                        <div class="col-md-2 col-xs-12">
                            <div class="form-group has-error">
                                <label for="level" class="col-md-3 col-xs-5 control-label">@lang('label.level')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-9 col-xs-7">
                                    <input type="text" class="form-control text-right" name="level" id="level" value="{{$main_menus_1->count()+1}}" required>
                                    <div class="help-block">@lang('placeholder.level')</div>
                                </div>
                            </div>
                        </div>
                        @if($emp->lang == 'fr')
                            <div class="col-md-5 col-xs-12">
                                <div class="form-group has-error">
                                    <label for="labelfr" class="col-md-3 col-xs-5 control-label">@lang('label.menu_level_1_fr')<span class="text-red text-bold">*</span></label>
                                    <div class="col-md-9 col-xs-7">
                                        <input type="text" class="form-control" name="labelfr" id="labelfr" required>
                                        <div class="help-block">@lang('placeholder.menu_level_1_fr')</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 col-xs-12">
                                <div class="form-group has-error">
                                    <label for="labeleng" class="col-md-3 col-xs-5 control-label">@lang('label.menu_level_1_eng')<span class="text-red text-bold">*</span></label>
                                    <div class="col-md-9 col-xs-7">
                                        <input type="text" class="form-control" name="labeleng" id="labeleng" required>
                                        <div class="help-block">@lang('placeholder.menu_level_1_eng')</div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="col-md-5 col-xs-12">
                                <div class="form-group has-error">
                                    <label for="labeleng" class="col-md-3 col-xs-5 control-label">@lang('label.menu_level_1_eng')<span class="text-red text-bold">*</span></label>
                                    <div class="col-md-9 col-xs-7">
                                        <input type="text" class="form-control" name="labeleng" id="labeleng" required>
                                        <div class="help-block">@lang('placeholder.menu_level_1_eng')</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 col-xs-12">
                                <div class="form-group has-error">
                                    <label for="labelfr" class="col-md-3 col-xs-5 control-label">@lang('label.menu_level_1_fr')<span class="text-red text-bold">*</span></label>
                                    <div class="col-md-9 col-xs-7">
                                        <input type="text" class="form-control" name="labelfr" id="labelfr" required>
                                        <div class="help-block">@lang('placeholder.menu_level_1_fr')</div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-xs-12">
                            <div class="form-group has-info">
                                <label for="view_icon" class="col-md-3 col-xs-5 control-label">@lang('label.icon')</label>
                                <div class="col-md-9 col-xs-7">
                                    <input type="text" class="form-control" name="view_icon" id="view_icon">
                                    <div class="help-block">@lang('placeholder.icon')</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-xs-12">
                            <div class="form-group has-info">
                                <label for="view_path" class="col-md-3 col-xs-5 control-label">@lang('label.path')</label>
                                <div class="col-md-9 col-xs-7">
                                    <input type="text" class="form-control" name="view_path" id="view_path">
                                    <div class="help-block">@lang('placeholder.path')</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-xs-12">
                            <div class="form-group has-info">
                                <label for="operation" class="col-md-3 control-label">@lang('label.opera')</label>
                                <div class="col-md-9">
                                    <select class="form control select2" name="operation" id="operation">
                                        <option value=""></option>
                                        @foreach ($operations as $operation)
                                        <option value="{{ $operation->idoper }}">@if($emp->lang == 'fr') {{ $operation->labelfr }} @else {{ $operation->labeleng }} @endif</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block">@lang('placeholder.operation')</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <button type="submit" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold">{{$title}}</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-success bg-green btn-sm pull-right" id="insertForm">
                    <i class="oin ion-plus"></i>&nbsp;@lang('label.new_menu_level_1')
                </button>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table id="admin-data-table" class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr>
                                <th>@lang('label.level')</th>
                                <th>@lang('label.main_menu')</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($main_menus_1 as $main_menu_1)
                                <tr>
                                    <td class="text-center">{{$main_menu_1->level}}</i></td>
                                    <td><span><i class="{{$main_menu_1->view_icon}}"></i></span>&nbsp;&nbsp; @if($emp->lang == 'fr') {{ $main_menu_1->labelfr }} @else {{ $main_menu_1->labeleng }} @endif</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-info bg-aqua btn-sm fa fa-edit" onclick="edit('{{$main_menu_1->idmenus_1}}')"></button>
                                        <button type="button" class="btn bg-red btn-sm delete fa fa-trash" onclick="remove('{{$main_menu_1->idmenus_1}}')"></button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <form action="{{route('menu_level_1/delete')}}" method="post" role="form" id="delForm" style="display: none">
                            {{ csrf_field() }}
                            <input type="hidden" name="main_menu" id="main_menu" value="">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script>
        $('#insertForm').click(function () {
            in_out_form();
            $('#level').val("{{$main_menus_1->count()+1}}");
            $('#newForm').show();
        });

        function edit(idmain_menu) {
            $.ajax({
                url: "{{ url('getMenu') }}",
                method: 'get',
                data: {
                    id: idmain_menu,
                    level: 1
                },
                success: function (main_menu) {
                    $('#title').text('@lang('label.edit') @if($emp->lang === 'fr')' + main_menu.labelfr + ' @else ' + main_menu.labeleng + '@endif');
                    $('#idmain_menu').val(main_menu.idmenu);
                    $('#labelfr').val(main_menu.labelfr);
                    $('#labeleng').val(main_menu.labeleng);
                    $('#level').val(main_menu.level);
                    $('#view_icon').val(main_menu.view_icon);
                    $('#view_path').val(main_menu.view_path);
                    $('#operation').val(main_menu.operation).select2();

                    $('#save').replaceWith('<button type="submit" id="edit" class="btn btn-sm bg-aqua pull-right btn-raised fa fa-edit edit"></button>');

                    $('#newForm').show();
                }
            });
        }

        function remove(idmain_menu) {
            swal({
                icon: 'warning',
                title: "{{$title}}",
                text: '@lang('confirm.menu_level_1_del_text')',
                closeOnClickOutside: false,
                allowOutsideClick: false,
                closeOnEsc: false,
                buttons: {
                    cancel: {
                        text: ' @lang('confirm.no')',
                        value: false,
                        visible: true,
                        closeModal: true,
                        className: "btn bg-red fa fa-close"
                    },
                    confirm: {
                        text: ' @lang('confirm.yes')',
                        value: true,
                        visible: true,
                        closeModal: true,
                        className: "btn bg-green fa fa-check"
                    },
                },
            }).then(function (isConfirm) {
                if (isConfirm) {
                    $('#main_menu').val(idmain_menu);
                    $('#delForm').submit();
                }
            });
        }

        $('#exitForm').click(function () {
            $('#newForm').hide();
            in_out_form();
        });

        function submitForm() {
            let text = "@lang('confirm.menu_level_1_save_text')";
            if ($('#idmain_menu').val() !== '') {
                text = "@lang('confirm.menu_level_1_edit_text')";
            }

            mySwal("{{$title}}", text, "@lang('confirm.no')", "@lang('confirm.yes')", '#main_menuForm');
        }

        function in_out_form() {
            $('#title').text('@lang('label.new_menu_level_1')');
            $('#idmain_menu').val('');
            $('#fillform :input').val('');
            $('.edit').replaceWith('<button type="submit" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>');
        }
    </script>
@stop
