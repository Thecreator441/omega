<?php $emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.operation'))

@section('content')
    <div class="box">
        <div class="box-header">
            <div class="box-tools">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right fa fa-close" id="home"></button>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12">
                        {{ $operations->links('layouts.includes.pagination') }}
                    </div>
                </div>
            </div>
            <form action="{{ url('operation/store') }}" method="POST" role="form" id="operForm">
                {{csrf_field()}}
                <div class="box-header with-border" id="form">
                    @foreach ($operations as $operation)
                        <input type="hidden" id="idoper" name="idoper" value="{{$operation->idoper}}">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="opercode" class="col-md-5 control-label">@lang('label.code')</label>
                                    <div class="col-md-7">
                                        <input type="text" name="opercode" id="opercode" class="form-control"
                                               value="{{pad($operation->opercode, 3)}}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="labeleng" class="col-md-3 control-label">@lang('label.labeleng')</label>
                                    <div class="col-md-9">
                                        <input type="text" name="labeleng" id="labeleng" class="form-control"
                                               value="{{$operation->labeleng}}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="labelfr" class="col-md-3 control-label">@lang('label.labelfr')</label>
                                    <div class="col-md-9">
                                        <input type="text" name="labelfr" id="labelfr" class="form-control"
                                               value="{{$operation->labelfr}}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="debteng" class="col-md-4 control-label">@lang('label.deblabeng')</label>
                                    <div class="col-md-8">
                                        <input type="text" name="debteng" id="debteng" class="form-control"
                                               value="{{$operation->debteng}}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="debtfr" class="col-md-4 control-label">@lang('label.deblabfr')</label>
                                    <div class="col-md-8">
                                        <input type="text" name="debtfr" id="debtfr" class="form-control"
                                               value="{{$operation->debtfr}}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="credteng"
                                           class="col-md-4 control-label">@lang('label.credlabeng')</label>
                                    <div class="col-md-8">
                                        <input type="text" name="credteng" id="credteng" class="form-control"
                                               value="{{$operation->credteng}}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="credtfr" class="col-md-4 control-label">@lang('label.credlabfr')</label>
                                    <div class="col-md-8">
                                        <input type="text" name="credtfr" id="credtfr" class="form-control"
                                               value="{{$operation->credtfr}}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <button type="button" id="delete"
                                        class="btn btn-sm bg-red pull-right btn-raised fa fa-trash"></button>
                                <button type="button" id="update"
                                        class="btn btn-sm bg-aqua pull-right btn-raised fa fa-recycle"></button>
                                <button type="button" id="insert"
                                        class="btn btn-sm bg-blue pull-right btn-raised fa fa-file-o"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
        $(document).ready(function () {

        });

        let form = $('#operForm');

        $('#insert').click(function () {
            setEditable();
            $('#opercode').removeAttr('readonly');
            $('#form :input').val('');
            $(this).replaceWith('<button type="button" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>');
            $('.bg-aqua').replaceWith('<button type="button" id="update" class="btn btn-sm bg-blue pull-right btn-raised fa fa-recycle"></button>');
            $('.bg-red').attr('disabled', true);
        });

        $('#edit').click(function () {
            setEditable();
            $(this).replaceWith('<button type="button" id="edit" class="btn btn-sm bg-aqua pull-right btn-raised fa fa-edit"></button>');
        });

        $(document).on('click', '#save, #edit', function () {
            let text = '';
            if ($('#idoper').val() === '')
                text = '@lang('confirm.opesave_text')';
            else
                text = '@lang('confirm.opeedit_text')';

            swal({
                    title: '@lang('confirm.opera_header')',
                    text: text,
                    type: 'info',
                    showCancelButton: true,
                    cancelButtonClass: 'bg-red',
                    confirmButtonClass: 'bg-blue',
                    confirmButtonText: '@lang('confirm.yes')',
                    cancelButtonText: '@lang('confirm.no')',
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function (isConfirm) {
                    if (isConfirm) {
                        $('#operForm').submit();
                    }
                }
            );
        });

        $('#delete').click(function () {
            swal({
                    title: '@lang('confirm.opera_header')',
                    text: '@lang('confirm.opedel_text')',
                    type: 'info',
                    showCancelButton: true,
                    cancelButtonClass: 'bg-red',
                    confirmButtonClass: 'bg-blue',
                    confirmButtonText: '@lang('confirm.yes')',
                    cancelButtonText: '@lang('confirm.no')',
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function (isConfirm) {
                    if (isConfirm) {
                        form.attr('action', 'operation/delete');
                        form.submit();
                    }
                }
            );
        });

        function setEditable() {
            $('#labeleng, #labelfr, #debteng, #debtfr, #credteng, #credtfr').removeAttr('readonly');
        }
    </script>
@stop
