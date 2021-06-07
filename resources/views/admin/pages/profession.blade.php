<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.profs'))

@section('content')
    <div class="box box-info" id="newForm" style="display: none;">
        <div class="box-header with-border">
            <h3 class="box-title text-bold" id="title">@lang('label.newprof')</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right" id="exitForm">
                    <i class="fa fa-close"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <form action="{{ route('admin/profession/store') }}" method="post" role="form" id="counForm" class="needs-validation">
                {{ csrf_field() }}

                <div id="fillform">
                    <input type="hidden" name="idcountry" id="idcountry">

                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group has-error">
                                <label for="labeleng" class="col-md-3 control-label">@lang('label.labeleng')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="labeleng" id="labeleng" required>
                                    <div class="help-block">@lang('placeholder.nameeng')</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group has-error">
                                <label for="labelfr" class="col-md-3 control-label">@lang('label.labelfr')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="labelfr" id="labelfr" required>
                                    <div class="help-block">@lang('placeholder.namefr')</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <button type="submit" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>
                </div>
            </form>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold">@lang('sidebar.profs')</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-success bg-green btn-sm pull-right" id="insertForm">
                    <i class="oin ion-plus"></i>&nbsp;@lang('label.newprof')
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
                                <th>@lang('label.label')</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($professions as $profession)
                                <tr>
                                    <td>@if($emp->lang == 'fr') {{ $profession->labelfr }} @else {{ $profession->labeleng }} @endif</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-info bg-aqua btn-sm fa fa-edit" onclick="edit('{{$profession->idprof}}')"></button>
                                        <button type="button" class="btn bg-red btn-sm delete fa fa-trash" onclick="remove('{{$profession->idprof}}')"></button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <form action="{{route('admin/profession/delete')}}" method="post" role="form" id="delForm" style="display: none">
                            {{ csrf_field() }}
                            <input type="hidden" name="country" id="country" value="">
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

        function edit(idprofession) {
            $.ajax({
                url: "{{ url('getProfession') }}",
                method: 'get',
                data: {
                    id: idprofession
                },
                success: function (profession) {
                    $('#title').text('@lang('label.edit') @if($emp->lang === 'fr')' + profession.labelfr + ' @else ' + profession.labeleng + '@endif');
                    $('#idcountry').val(profession.idprof);
                    $('#labelfr').val(profession.labelfr);
                    $('#labeleng').val(profession.labeleng);

                    $('#save').replaceWith('<button type="submit" id="edit" class="btn btn-sm bg-aqua pull-right btn-raised fa fa-edit"></button>');

                    $('#newForm').show();
                }
            });
        }

        function remove(idprofession) {
            swal({
                icon: 'warning',
                title: '@lang('sidebar.profs')',
                text: '@lang('confirm.profdel_text')',
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
                    $('#country').val(idprofession);
                    $('#delForm').submit();
                }
            });
        }

        $('#exitForm').click(function () {
            $('#newForm').hide();
            in_out_form();
        });

        function submitForm() {
            let text = '@lang('confirm.profsave_text')';
            if ($('#idcountry').val() !== '') {
                text = '@lang('confirm.profedit_text')';
            }

            mySwal('@lang('sidebar.profs')', text, '@lang('confirm.no')', '@lang('confirm.yes')', '#counForm');
        }

        function in_out_form() {
            $('#title').text('@lang('label.newprof')');
            $('#idcountry').val('');
            $('#fillform :input').val('');
            $('#edit').replaceWith('<button type="submit" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>');
        }
    </script>
@stop
