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
            <h3 class="box-title text-bold" id="title">@lang('label.new_menu_level_3')</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right" id="exitForm">
                    <i class="fa fa-close"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <form action="{{ route('menu_level_3/store') }}" method="post" role="form" id="main_menuForm" class="needs-validation">
                {{ csrf_field() }}

                <div id="fillform">
                    <input type="hidden" name="idmain_menu" id="idmain_menu">

                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group has-error">
                                <label for="menu_level_1" class="col-md-3 col-xs-5 control-label">@lang('label.menu_level_1')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-9 col-xs-7">
                                    <select class="form-control select2" id="menu_level_1" name="menu_level_1">
                                        <option value=""></option>
                                        @foreach($main_menus_1 as $main_menu_1)
                                            <option value="{{ $main_menu_1->idmenus_1 }}">@if($emp->lang == 'fr') {{ $main_menu_1->labelfr }} @else {{ $main_menu_1->labeleng }} @endif</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">@lang('placeholder.menu_level_1')</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group has-error">
                                <label for="menu_level_2" class="col-md-3 col-xs-5 control-label">@lang('label.menu_level_2')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-9 col-xs-7">
                                    <select class="form-control select2" id="menu_level_2" name="menu_level_2" required>
                                        <option value=""></option>
                                        @foreach($main_menus_2 as $main_menu_2)
                                            <option value="{{ $main_menu_2->idmenus_2 }}">@if($emp->lang == 'fr') {{ $main_menu_2->labelfr }} @else {{ $main_menu_2->labeleng }} @endif</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">@lang('placeholder.menu_level_2')</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        @if($emp->lang == 'fr')
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group has-error">
                                    <label for="labelfr" class="col-md-3 col-xs-5 control-label">@lang('label.menu_level_3_fr')<span class="text-red text-bold">*</span></label>
                                    <div class="col-md-9 col-xs-7">
                                        <input type="text" class="form-control" name="labelfr" id="labelfr" required>
                                        <div class="help-block">@lang('placeholder.menu_level_3_fr')</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group has-error">
                                    <label for="labeleng" class="col-md-3 col-xs-5 control-label">@lang('label.menu_level_3_eng')<span class="text-red text-bold">*</span></label>
                                    <div class="col-md-9 col-xs-7">
                                        <input type="text" class="form-control" name="labeleng" id="labeleng" required>
                                        <div class="help-block">@lang('placeholder.menu_level_3_eng')</div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group has-error">
                                    <label for="labeleng" class="col-md-3 col-xs-5 control-label">@lang('label.menu_level_3_eng')<span class="text-red text-bold">*</span></label>
                                    <div class="col-md-9 col-xs-7">
                                        <input type="text" class="form-control" name="labeleng" id="labeleng" required>
                                        <div class="help-block">@lang('placeholder.menu_level_3_eng')</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group has-error">
                                    <label for="labelfr" class="col-md-3 col-xs-5 control-label">@lang('label.menu_level_3_fr')<span class="text-red text-bold">*</span></label>
                                    <div class="col-md-9 col-xs-7">
                                        <input type="text" class="form-control" name="labelfr" id="labelfr" required>
                                        <div class="help-block">@lang('placeholder.menu_level_3_fr')</div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-xs-12">
                            <div class="form-group has-error">
                                <label for="level" class="col-md-3 col-xs-5 control-label">@lang('label.level')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-9 col-xs-7">
                                    <input type="text" class="form-control text-right" name="level" id="level" required readonly>
                                    <div class="help-block">@lang('placeholder.level')</div>
                                </div>
                            </div>
                        </div>
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
                    <i class="oin ion-plus"></i>&nbsp;@lang('label.new_menu_level_3')
                </button>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <table id="admin-data-table" class="table table-bordered table-striped table-hover table-responsive-xl">
                            <thead>
                            <tr>
                                <th>@lang('label.icon')</th>
                                <th>@lang('label.level')</th>
                                <th>@lang('label.menu_level_3')</th>
                                <th>@lang('label.menu_level_2')</th>
                                <th>@lang('label.menu_level_1')</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($main_menus_3 as $main_menu_3)
                                <tr>
                                    <td class="text-center"><i class="{{$main_menu_3->view_icon}}"></i></td>
                                    <td class="text-center">{{$main_menu_3->level}}</i></td>
                                    <td>@if($emp->lang == 'fr') {{ $main_menu_3->labelfr }} @else {{ $main_menu_3->labeleng }} @endif</td>
                                    <td>{{$main_menu_3->main_menu_2}}</td>
                                    <td>{{$main_menu_3->main_menu_1}}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-info bg-aqua btn-sm fa fa-edit" onclick="edit('{{$main_menu_3->idmenus_3}}')"></button>
                                        <button type="button" class="btn bg-red btn-sm delete fa fa-trash" onclick="remove('{{$main_menu_3->idmenus_3}}')"></button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <form action="{{route('menu_level_3/delete')}}" method="post" role="form" id="delForm" style="display: none">
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
            $('#newForm').show();
        });

        $('#menu_level_1').change(function () {
            if ($(this).val() !== '') {
                $.ajax({
                    url: "{{ url('getNextMenus') }}",
                    method: 'get',
                    data: {
                        id: $(this).val(),
                        level: 1
                    },
                    success: function (menus_2) {
                        let option = "<option></option>";
                        $.each(menus_2, function (i, menu_2) {
                            option += "<option value=" + menu_2.idmenus_2 + ">@if($emp->lang == 'fr') " + menu_2.labelfr + " @else " + menu_2.labeleng + " @endif</option>";
                        });
                        $('#menu_level_2').html(option);
                    }
                });
            }
        });

        $('#menu_level_2').change(function () {
            if ($(this).val() !== '') {
                $.ajax({
                    url: "{{ url('getPrevMenus') }}",
                    method: 'get',
                    data: {
                        id: $(this).val(),
                        level: 3
                    },
                    success: function (menus) {
                        $('#level').val(parseInt(menus.length) + 1);
                    }
                });
            }
        });

        function edit(idmain_menu) {
            $.ajax({
                url: "{{ url('getMenu') }}",
                method: 'get',
                data: {
                    id: idmain_menu,
                    level: 3
                },
                success: function (main_menu) {
                    $('#title').text('@lang('label.edit') @if($emp->lang === 'fr')' + main_menu.labelfr + ' @else ' + main_menu.labeleng + '@endif');
                    $('#idmain_menu').val(main_menu.idmenu);
                    $('#labelfr').val(main_menu.labelfr);
                    $('#labeleng').val(main_menu.labeleng);
                    $('#menu_level_1').val(main_menu.ML1_menu_1).select2();
                    $('#menu_level_2').val(main_menu.menu_2).select2();
                    $('#level').val(main_menu.level);
                    $('#level').attr("readonly", false);
                    $('#view_icon').val(main_menu.view_icon);
                    $('#view_path').val(main_menu.view_path);
                    
                    $('#save').replaceWith('<button type="submit" id="edit" class="btn btn-sm bg-aqua pull-right btn-raised fa fa-edit edit"></button>');

                    $('#newForm').show();
                }
            });
        }

        function remove(idmain_menu) {
            swal({
                icon: 'warning',
                title: "{{$title}}",
                text: '@lang('confirm.menu_level_3_del_text')',
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
            let text = '@lang('confirm.menu_level_3_save_text')';
            if ($('#idmain_menu').val() !== '') {
                text = '@lang('confirm.menu_level_3_edit_text')';
            }

            mySwal("{{$title}}", text, '@lang('confirm.no')', '@lang('confirm.yes')', '#main_menuForm');
        }

        function in_out_form() {
            $('#title').text('@lang('label.new_menu_level_3')');
            $('#idmain_menu').val('');
            $('#fillform :input').val('');
            $('.select2').val('').select2();
            $('.edit').replaceWith('<button type="submit" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>');
        }
    </script>
@stop
