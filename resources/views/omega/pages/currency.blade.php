<?php $emp = Session::get('employee');

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
            <h3 class="box-title text-bold" id="title">@if($emp->lang == 'fr') Nouvelle Dévise @else New
                Currency @endif</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right" id="exitForm">
                    <i class="fa fa-close"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <form action="{{ route('currency/store') }}" class="needs-validation" method="post" role="form" id="curForm">
                {{ csrf_field() }}

                <div id="fillform">
                    <input type="hidden" name="idcurrency" id="idcurrency">

                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group has-error">
                                <label for="name" class="col-md-3 control-label">@lang('label.name') <sup class="text-red text-bold">*</sup></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" value="" name="name" id="name" required>
                                    <div class="help-block">@lang('placeholder.name')</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <div class="form-group has-error">
                                <label for="format" class="col-md-3 control-label">@lang('label.format') <sup class="text-red text-bold">*</sup></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" value="" name="format" id="format" required>
                                    <div class="help-block">@lang('placeholder.format')</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <div class="form-group has-error">
                                <label for="symbol" class="col-md-3 control-label">@lang('label.symbol') <sup class="text-red text-bold">*</sup></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" value="" name="symbol" id="symbol" required>
                                    <div class="help-block">@lang('placeholder.symbol')</div>
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
        <div class="box-header  with-border">
            <h3 class="box-title text-bold">{{$title}}</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-success bg-green btn-sm pull-right" id="insertForm">
                    <i class="oin ion-plus"></i>&nbsp;@lang('label.newcur')
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
                                <th>Format</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($currencies as $currency)
                                <tr>
                                    <td>{{ $currency->label }}</td>
                                    <td>{{ $currency->symbol }} ({{ $currency->format }})</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-info bg-aqua btn-sm fa fa-edit" onclick="edit('{{$currency->idcurrency}}')"></button>
                                        <button type="button" class="btn bg-red btn-sm delete fa fa-trash" onclick="remove('{{$currency->idcurrency}}')"></button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <form action="{{route('currency/delete')}}" method="post" role="form" id="delForm" style="display: none">
                            {{ csrf_field() }}
                            <input type="hidden" name="currency" id="currency" value="">
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

        function edit(idcurrency) {
            $.ajax({
                url: "{{ url('getCurrency') }}",
                method: 'get',
                data: {
                    id: idcurrency
                },
                success: function (currency) {
                    $('#title').text('@lang('label.edit') ' + currency.label);
                    $('#idcurrency').val(currency.idcurrency);
                    $('#name').val(currency.label);
                    $('#symbol').val(currency.symbol);
                    $('#format').val(currency.format);

                    $('#save').replaceWith('<button type="submit" id="edit" class="btn btn-sm bg-aqua pull-right btn-raised fa fa-edit edit"></button>');

                    $('#newForm').show();
                }
            });
        }

        function remove(idcurrency) {
            swal({
                icon: 'warning',
                title: "{{$title}}",
                text: '@lang('confirm.curdel_text')',
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
                    $('#currency').val(idcurrency);
                    $('#delForm').submit();
                }
            });
        }

        $('#exitForm').click(function () {
            $('#newForm').hide();
            in_out_form();
        });

        function submitForm() {
            let text = '@lang('confirm.cursave_text')';
            if ($('#idcurrency').val() !== '') {
                text = '@lang('confirm.curedit_text')';
            }

            mySwal("{{$title}}", text, '@lang('confirm.no')', '@lang('confirm.yes')', '#curForm');
        }

        function in_out_form() {
            $('#title').text('@lang('label.newcur')');
            $('#idcurrency').val('');
            $('#fillform :input').val('');
            $('.edit').replaceWith('<button type="submit" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>');
        }
    </script>
@stop
