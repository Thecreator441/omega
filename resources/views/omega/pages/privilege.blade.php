<?php

use App\Models\Menu_Level_I;
use App\Models\Menu_Level_II;
use App\Models\Menu_Level_III;
use App\Models\Menu_Level_IV;

$emp = session()->get('employee');

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
            <h3 class="box-title text-bold" id="title">@lang('label.new_privilege')</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right" id="exitForm">
                    <i class="fa fa-close"></i>
                </button>
            </div>
        </div>

        <div class="box-body">
            <form action="{{ route('privilege/store') }}" method="post" role="form" id="main_menuForm" class="needs-validation">
                {{ csrf_field() }}

                <div id="fillform">
                    <input type="hidden" name="idmain_menu" id="idmain_menu">

                    <div class="row">
                        @if($emp->lang == 'fr')
                            <div class="col-md-4 col-xs-12">
                                <div class="form-group has-error">
                                    <label for="labelfr" class="col-md-3 col-xs-5 control-label">@lang('label.privilege_fr')<span class="text-red text-bold">*</span></label>
                                    <div class="col-md-9 col-xs-7">
                                        <input type="text" class="form-control" name="labelfr" id="labelfr" required>
                                        <div class="help-block">@lang('placeholder.privilege_fr')</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <div class="form-group has-error">
                                    <label for="labeleng" class="col-md-3 col-xs-5 control-label">@lang('label.privilege_eng')<span class="text-red text-bold">*</span></label>
                                    <div class="col-md-9 col-xs-7">
                                        <input type="text" class="form-control" name="labeleng" id="labeleng" required>
                                        <div class="help-block">@lang('placeholder.privilege_eng')</div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="col-md-4 col-xs-12">
                                <div class="form-group has-error">
                                    <label for="labeleng" class="col-md-3 col-xs-5 control-label">@lang('label.privilege_eng')<span class="text-red text-bold">*</span></label>
                                    <div class="col-md-9 col-xs-7">
                                        <input type="text" class="form-control" name="labeleng" id="labeleng" required>
                                        <div class="help-block">@lang('placeholder.privilege_eng')</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <div class="form-group has-error">
                                    <label for="labelfr" class="col-md-3 col-xs-5 control-label">@lang('label.privilege_fr')<span class="text-red text-bold">*</span></label>
                                    <div class="col-md-9 col-xs-7">
                                        <input type="text" class="form-control" name="labelfr" id="labelfr" required>
                                        <div class="help-block">@lang('placeholder.privilege_fr')</div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="col-md-4 col-xs-12">
                            <div class="form-group has-error">
                                <label for="level" class="col-md-3 col-xs-5 control-label">@lang('label.level')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-9 col-xs-7">
                                    <select class="form-control select2" id="level" name="level" required>
                                        <option value=""></option>
                                        @if($emp->level === 'P')
                                            <option value="P">@lang('label.platform')</option>
                                            <option value="O">@lang('label.organ')</option>
                                            <option value="N">@lang('label.network')</option>
                                            <option value="Z">@lang('label.zone')</option>
                                            <option value="I">@lang('label.institution')</option>
                                            <option value="B">@lang('label.branch') </option>
                                        @elseif($emp->level === 'O')
                                            <option value="O" selected>@lang('label.organ')</option>
                                        @elseif($emp->level === 'N')
                                            <option value="N" selected>@lang('label.network')</option>
                                        @elseif($emp->level === 'Z')
                                            <option value="Z" selected>@lang('label.zone')</option>
                                        @elseif($emp->level === 'I')
                                            <option value="I" selected>@lang('label.institution')</option>
                                        @elseif($emp->level === 'B')
                                            <option value="B" selected>@lang('label.branch') </option>
                                        @endif
                                    </select>
                                    <span class="help-block">@lang('placeholder.level')</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group"></div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-default">
                                <div class="box-header with-border">
                                    <h6 class="box-title">@lang('label.access')</h6>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        @if($menus_1->count() > 0)
                                            @foreach($menus_1 as $menu_1)
                                                <?php
                                                    $menus_2 = Menu_Level_II::getMenus(null, ['menu_1' => $menu_1->idmenus_1]); 
                                                ?>

                                                @if($menus_2->count() > 0)
                                                    <div class="col-md-4 col-xs-12">
                                                        <div class="box box-default collapsed-box">
                                                            <div class="box-header">
                                                                <div class="checkbox">
                                                                    <label for="menu1_{{$menu_1->idmenus_1}}">
                                                                        <input type="checkbox" name="menu_1[]" class="menu_1" value="{{$menu_1->idmenus_1}}" id="menu1_{{$menu_1->idmenus_1}}">
                                                                        &nbsp;&nbsp;@if($emp->lang == 'fr') {{$menu_1->labelfr}} @else {{$menu_1->labeleng}} @endif
                                                                    </label>
                                                                </div>
                                                                <div class="box-tools pull-right">
                                                                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                                                        <i class="fa fa-plus"></i>
                                                                    </button>
                                                                </div>
                                                            </div>

                                                            <div class="box-body">
                                                                <div class="row">
                                                                    @foreach($menus_2 as $menu_2)
                                                                        <?php
                                                                            $menus_3 = Menu_Level_III::getMenus(null, ['menu_2' => $menu_2->idmenus_2]); 
                                                                        ?>

                                                                        @if($menus_3->count() > 0)
                                                                            <div class="row col-md-12 col-xs-12">
                                                                                <div class="box box-default collapsed-box">
                                                                                    <div class="box-header">
                                                                                        <div class="col-md-1 col-xs-1"></div>
                                                                                        <div class="col-md-11 col-xs-11 text-muted">
                                                                                            <div class="checkbox">
                                                                                                <label for="menu2_{{$menu_2->idmenus_2}}">
                                                                                                    <input type="checkbox" name="menu_2[]" class="menu_2" value="{{$menu_1->idmenus_1}}_{{$menu_2->idmenus_2}}" id="menu2_{{$menu_2->idmenus_2}}">
                                                                                                    &nbsp;&nbsp;@if($emp->lang == 'fr') {{$menu_2->labelfr}} @else {{$menu_2->labeleng}} @endif
                                                                                                </label>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="box-tools pull-right">
                                                                                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                                                                                <i class="fa fa-plus"></i>
                                                                                            </button>
                                                                                        </div>      
                                                                                    </div>

                                                                                    <div class="box-body">
                                                                                        <div class="row">
                                                                                            @foreach($menus_3 as $menu_3)
                                                                                                <?php
                                                                                                    $menus_4 = Menu_Level_IV::getMenus(null, ['menu_3' => $menu_3->idmenus_3]); 
                                                                                                ?>

                                                                                                @if($menus_4->count() > 0)
                                                                                                    <div class="row col-md-12 col-xs-12">
                                                                                                        <div class="box box-default collapsed-box">
                                                                                                            <div class="box-header">
                                                                                                                <div class="col-md-2 col-xs-2"></div>
                                                                                                                <div class="col-md-10 col-xs-10 text-muted">
                                                                                                                    <div class="checkbox">
                                                                                                                        <label for="menu3_{{$menu_3->idmenus_3}}">
                                                                                                                            <input type="checkbox" name="menu_3[]" class="menu_3" value="{{$menu_1->idmenus_1}}_{{$menu_2->idmenus_2}}_{{$menu_3->idmenus_3}}" id="menu3_{{$menu_3->idmenus_3}}">
                                                                                                                            &nbsp;&nbsp;@if($emp->lang == 'fr') {{$menu_3->labelfr}} @else {{$menu_3->labeleng}} @endif
                                                                                                                        </label>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="box-tools pull-right">
                                                                                                                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                                                                                                        <i class="fa fa-plus"></i>
                                                                                                                    </button>
                                                                                                                </div>
                                                                                                            </div>

                                                                                                            <div class="box-body">
                                                                                                                <div class="row">
                                                                                                                    @foreach($menus_4 as $menu_4)
                                                                                                                        <div class="col-md-12 col-xs-12">
                                                                                                                            <div class="col-md-3 col-xs-3"></div>
                                                                                                                            <div class="col-md-9 col-xs-9 text-muted">
                                                                                                                                <div class="checkbox">
                                                                                                                                    <label for="menu4_{{$menu_4->idmenus_4}}">
                                                                                                                                        <input type="checkbox" name="menu_4[]" class="menu_4" value="{{$menu_1->idmenus_1}}_{{$menu_2->idmenus_2}}_{{$menu_3->idmenus_3}}_{{$menu_4->idmenus_4}}" id="menu4_{{$menu_4->idmenus_4}}">
                                                                                                                                        &nbsp;&nbsp;@if($emp->lang == 'fr') {{$menu_4->labelfr}} @else {{$menu_4->labeleng}} @endif
                                                                                                                                    </label>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    @endforeach
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                @else
                                                                                                    <div class="col-md-2 col-xs-2"></div>
                                                                                                    <div class="col-md-10 col-xs-10 text-muted">
                                                                                                        <div class="checkbox">
                                                                                                            <label for="menu3_{{$menu_3->idmenus_3}}">
                                                                                                                <input type="checkbox" name="menu_3[]" class="menu_3" value="{{$menu_1->idmenus_1}}_{{$menu_2->idmenus_2}}_{{$menu_3->idmenus_3}}" id="menu3_{{$menu_3->idmenus_3}}">
                                                                                                                &nbsp;&nbsp;@if($emp->lang == 'fr') {{$menu_3->labelfr}} @else {{$menu_3->labeleng}} @endif
                                                                                                            </label>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                @endif
                                                                                            @endforeach
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @else
                                                                            <div class="col-md-1 col-xs-1"></div>
                                                                            <div class="col-md-11 col-xs-11 text-muted">
                                                                                <div class="checkbox">
                                                                                    <label for="menu2_{{$menu_2->idmenus_2}}">
                                                                                        <input type="checkbox" name="menu_2[]" class="menu_2" value="{{$menu_1->idmenus_1}}_{{$menu_2->idmenus_2}}" id="menu2_{{$menu_2->idmenus_2}}">
                                                                                        &nbsp;&nbsp;@if($emp->lang == 'fr') {{$menu_2->labelfr}} @else {{$menu_2->labeleng}} @endif
                                                                                    </label>
                                                                                </div>
                                                                            </div> 
                                                                        @endif
                                                                    @endforeach
                                                                </div> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="col-md-4 col-xs-12">
                                                        <div class="box box-default collapsed-box">
                                                            <div class="box-header">
                                                                <div class="checkbox">
                                                                    <label for="menu1_{{$menu_1->idmenus_1}}">
                                                                        <input type="checkbox" name="menu_1[]" class="menu_1" value="{{$menu_1->idmenus_1}}" id="menu1_{{$menu_1->idmenus_1}}">
                                                                        &nbsp;&nbsp;@if($emp->lang == 'fr') {{$menu_1->labelfr}} @else {{$menu_1->labeleng}} @endif
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>
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
                    <i class="fa fa-plus"></i>&nbsp;@lang('label.new_privilege')
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
                                <th>{{$title}}</th>
                                <th>@if($emp->lang == 'fr') Niveau @else Level @endif</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($privileges as $privilege)
                                <tr>
                                    <td>@if($emp->lang == 'fr') {{$privilege->labelfr}} @else {{$privilege->labeleng}} @endif </td>
                                    <td>
                                        @switch($privilege->level)
                                            @case ('O')
                                                @lang('label.organ')
                                                @break
                                            @case ('N')
                                                @lang('label.network')
                                                @break
                                            @case ('Z')
                                                @lang('label.zone')
                                                @break
                                            @case ('I')
                                                @lang('label.institution')
                                                @break
                                            @case ('B')
                                                @lang('label.branch')
                                                @break
                                            @default
                                                @lang('label.platform')
                                                @break
                                        @endswitch
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-info bg-aqua btn-sm fa fa-edit" onclick="edit('{{$privilege->idpriv}}')"></button>
                                        <button type="button" class="btn bg-red btn-sm delete fa fa-trash" onclick="remove('{{$privilege->idpriv}}')"></button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <form action="{{route('privilege/delete')}}" method="post" role="form" id="delForm" style="display: none">
                            {{ csrf_field() }}
                            <input type="hidden" name="privilege" id="privilege" value="">
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

        function edit(idmain_menu) {
            $('#fillform :input').prop('checked', false);

            $.ajax({
                url: "{{ url('getPrivilege') }}",
                method: 'get',
                data: {
                    priv: idmain_menu
                },
                success: function (privilege) {
                    $('#title').text('@lang('label.edit') @if($emp->lang === 'fr')' + privilege.labelfr + ' @else ' + privilege.labeleng + '@endif');
                    $('#idmain_menu').val(idmain_menu);
                    $('#labelfr').val(privilege.labelfr);
                    $('#labeleng').val(privilege.labeleng);
                    $('#level').val(privilege.level).select2();
                    
                    $.ajax({
                        url: "{{url('getPrivMenusAside')}}",
                        method: 'get',
                        data: {
                            privilege: idmain_menu,
                            level: 1
                        },
                        success: function (menus_1) {
                            if (menus_1.length > 0) {
                                $.each(menus_1, function (i, menu_1) {
                                    if (menu_1.menu_1) {
                                        $(".menu_1").each(function () {
                                            if ($(this).attr("id") === "menu1_" + parseInt(menu_1.menu_1)) {
                                                $("#" + $(this).attr("id")).prop("checked", true);
                                            }
                                        })
                                    }
                                });
                            }
                        }
                    });

                    $.ajax({
                        url: "{{url('getPrivMenusAside')}}",
                        method: 'get',
                        data: {
                            privilege: idmain_menu,
                            level: 2
                        },
                        success: function (menus_2) {
                            if (menus_2.length > 0) {
                                $.each(menus_2, function (i, menu_2) {
                                    if (menu_2.menu_2) {
                                        $(".menu_2").each(function () {
                                            if ($(this).attr("id") === "menu2_" + parseInt(menu_2.menu_2)) {
                                                $("#" + $(this).attr("id")).prop("checked", true);
                                            }
                                        })
                                    }
                                });
                            }
                        }
                    });

                    $.ajax({
                        url: "{{url('getPrivMenusAside')}}",
                        method: 'get',
                        data: {
                            privilege: idmain_menu,
                            level: 3
                        },
                        success: function (menus_3) {
                            if (menus_3.length > 0) {
                                $.each(menus_3, function (i, menu_3) {
                                    if (menu_3.menu_3) {
                                        $(".menu_3").each(function () {
                                            if ($(this).attr("id") === "menu3_" + parseInt(menu_3.menu_3)) {
                                                $("#" + $(this).attr("id")).prop("checked", true);
                                            }
                                        })
                                    }
                                });
                            }
                        }
                    });

                    $.ajax({
                        url: "{{url('getPrivMenusAside')}}",
                        method: 'get',
                        data: {
                            privilege: idmain_menu,
                            level: 4
                        },
                        success: function (menus_4) {
                            if (menus_4.length > 0) {
                                $.each(menus_4, function (i, menu_4) {
                                    if (menu_4.menu_4) {
                                        $(".menu_4").each(function () {
                                            if ($(this).attr("id") === "menu4_" + parseInt(menu_4.menu_4)) {
                                                $("#" + $(this).attr("id")).prop("checked", true);
                                            }
                                        })
                                    }
                                });
                            }
                        }
                    });
                    
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
                    $('#privilege').val(idmain_menu);
                    $('#delForm').submit();
                }
            });
        }

        $('#exitForm').click(function () {
            $('#newForm').hide();
            in_out_form();
        });

        function submitForm() {
            let text = '@lang('confirm.menu_level_1_save_text')';
            if ($('#idmain_menu').val() !== '') {
                text = '@lang('confirm.menu_level_1_edit_text')';
            }

            mySwal("{{$title}}", text, '@lang('confirm.no')', '@lang('confirm.yes')', '#main_menuForm');
        }

        $('.menu_1').click(function () {
            if ($(this).is(':checked')) {
                // console.log("Checked");
                $(this).next('.box-body').show();
            }
        });

        function in_out_form() {
            $('#title').text('@lang('label.new_privilege')');
            $('#idmain_menu').val('');
            $('#fillform :input').val('');
            $('#fillform :input').prop('checked', false);
            $('.select2').val('').select2();
            $('.edit').replaceWith('<button type="submit" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>');
        }
    </script>
@stop
