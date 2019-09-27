<?php $emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.memset'))

@section('content')

    <div class="box">
        <div class="box-header">
            <div class="box-tools">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right fa fa-close" id="home"></button>
            </div>
        </div>
        <div class="box-body">
            <form action="{{ url('mem_setting/store') }}" method="POST" id="memSetForm" role="form">
                {{csrf_field()}}
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <select id="account" class="form-control select2">
                                    <option value="">@lang('label.account')</option>
                                    @foreach ($accounts as $account)
                                        @if ($account->accabbr == 'O')
                                            <option value="{{$account->idaccount}}">{{$account->accnumb}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" id="acc_name" class="form-control" placeholder="@lang('label.desc')"
                                       disabled>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="row">
                                <div class="form-group">
                                    <select id="opera" class="form-control select2">
                                        <option value="">@lang('label.opera')</option>
                                        @foreach ($operas as $opera)
                                            <option value="{{$opera->idoper}}">{{pad($opera->opercode, 3)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" id="opera_name" class="form-control"
                                       placeholder="@lang('label.desc')" disabled>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" id="amount" placeholder="@lang('label.amount')"
                                       class="form-control text-right text-bold">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="row">
                                <div class="form-group">
                                    <button type="button" id="minus"
                                            class="btn btn-sm bg-red pull-right fa fa-minus"></button>
                                    <button type="button" id="plus"
                                            class="btn btn-sm bg-green pull-right fa fa-plus"></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <table class="table table-hover-table-condensed table-bordered table-striped table-responsive">
                            <thead>
                            <tr>
                                <th colspan="2">@lang('label.account')</th>
                                <th>@lang('label.opera')</th>
                                <th>@lang('label.amount')</th>
                            </tr>
                            </thead>
                            <tbody id="ordSet">
                            @foreach ($mem_sets as $memset)
                                @if ($memset->accabbr == 'O')
                                    <tr>
                                        <td style="width: 5%; text-align: center">
                                            <input type="checkbox" class="check" name="classes[]"
                                                   value="{{$memset->idmemset}}">&nbsp;
                                        </td>
                                        <td>{{$memset->accnumb}}</td>
                                        <td>@if($emp->lang === 'fr') {{$memset->operlabelfr}} @else {{$memset->operlabeleng}} @endif</td>
                                        <td class="text-right text-bold">{{money((int)$memset->amount)}}</td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <select id="account2" class="form-control select2">
                                    <option value="">@lang('label.account')</option>
                                    @foreach ($accounts as $account)
                                        @if ($account->accabbr != 'O')
                                            <option value="{{$account->idaccount}}">{{$account->accnumb}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" id="acc_name2" class="form-control" placeholder="@lang('label.desc')"
                                       disabled>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="row">
                                <div class="form-group">
                                    <select id="opera2" class="form-control select2">
                                        <option value="">@lang('label.opera')</option>
                                        @foreach ($operas as $opera)
                                            <option value="{{$opera->idoper}}">{{pad($opera->opercode, 3)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" id="opera_name2" class="form-control"
                                       placeholder="@lang('label.desc')"
                                       disabled>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" id="amount2" placeholder="@lang('label.amount')"
                                       class="form-control text-right text-bold">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="row">
                                <div class="form-group">
                                    <button type="button" id="minus2"
                                            class="btn btn-sm bg-red pull-right fa fa-minus"></button>
                                    <button type="button" id="plus2"
                                            class="btn btn-sm bg-green pull-right fa fa-plus"></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <table class="table table-hover-table-condensed table-bordered table-striped table-responsive">
                            <thead>
                            <tr>
                                <th colspan="2">@lang('label.account')</th>
                                <th>@lang('label.opera')</th>
                                <th>@lang('label.amount')</th>
                            </tr>
                            </thead>
                            <tbody id="genSet">
                            @foreach ($mem_sets as $memset)
                                @if ($memset->accabbr != 'O')
                                    <tr>
                                        <td style="width: 5%; text-align: center">
                                            <input type="checkbox" class="check2" name="classes2[]"
                                                   value="{{$memset->idmemset}}">&nbsp;
                                        </td>
                                        <td>{{$memset->accnumb}}</td>
                                        <td>@if($emp->lang === 'fr') {{$memset->operlabelfr}} @else {{$memset->operlabeleng}} @endif</td>
                                        <td class="text-right text-bold">{{money((int)$memset->amount)}}</td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-md-12">
                    <button type="button" id="save"
                            class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>
                </div>
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
        $(document).ready(function () {
            if ($('#ordSet tr, #genSet tr').length === 0) {
                $('#minus, #minus2').attr('disabled', true);
            }
        });

        $('#amount, #amount2').on('input', function () {
            $(this).val(money($(this).val()));
        });

        $('#account').change(function () {
            if ($(this).val() !== '') {
                $.ajax({
                    url: "{{ url('getAccount') }}",
                    method: 'get',
                    data: {
                        account: $(this).val()
                    },
                    success: function (account) {
                        $('#acc_name').val("@if($emp->lang == 'fr')" + account.labelfr + " @else" + account.labeleng + " @endif");
                    }
                });
            } else {
                $('#acc_name').val('');
            }
        });

        $('#opera').change(function () {
            if ($(this).val() !== '') {
                $.ajax({
                    url: "{{ url('getOperation') }}",
                    method: 'get',
                    data: {
                        operation: $(this).val()
                    },
                    success: function (opera) {
                        $('#opera_name').val("@if($emp->lang == 'fr')" + opera.labelfr + " @else" + opera.labeleng + " @endif");
                    }
                });
            } else {
                $('#opera_name').val('');
            }
        });

        $('#plus').click(function () {
            let acc = $('#account');
            let opera = $('#opera');
            let operaName = $('#opera_name');
            let amount = $('#amount');

            let accText = acc.select2('data')[0]['text'];

            let line = '<tr>' +
                '<td style="text-align: center; width: 5%"><input type="checkbox" class="check"></td>' +
                '<td><input type="hidden" name="accounts[]" value="' + acc.val() + '">' + accText + '</td>' +
                '<td><input type="hidden" name="operations[]" value="' + opera.val() + '">' + operaName.val() + '</td>' +
                '<td class="text-right text-bold amount"><input type="hidden" name="amounts[]" value="' + trimOver(amount.val(), null) + '">' + money(amount.val()) + '</td>' +
                '</tr>';

            $('#ordSet').append(line);
            $('#minus').removeAttr('disabled');

            acc.val('').trigger('change');
            opera.val('').trigger('change');
            amount.val('');
            operaName.val('');
        });

        $('#minus').click(function () {
            $('.check').each(function () {
                if ($(this).is(':checked'))
                    $(this).closest('tr').remove();
            });
        });

        $('#minus').hover(function () {
            if ($('#ordSet tr').length === 0)
                $(this).attr('disabled', true);
        });

        $('#account2').change(function () {
            if ($(this).val() !== '') {
                $.ajax({
                    url: "{{ url('getAccount') }}",
                    method: 'get',
                    data: {
                        account: $(this).val()
                    },
                    success: function (account) {
                        $('#acc_name2').val("@if($emp->lang == 'fr')" + account.labelfr + " @else" + account.labeleng + " @endif");
                    }
                });
            } else {
                $('#acc_name2').val('');
            }
        });

        $('#opera2').change(function () {
            2
            if ($(this).val() !== '') {
                $.ajax({
                    url: "{{ url('getOperation') }}",
                    method: 'get',
                    data: {
                        operation: $(this).val()
                    },
                    success: function (opera) {
                        $('#opera_name2').val("@if($emp->lang == 'fr')" + opera.labelfr + " @else" + opera.labeleng + " @endif");
                    }
                });
            } else {
                $('#opera_name2').val('');
            }
        });

        $('#plus2').click(function () {
            let acc = $('#account2');
            let opera = $('#opera2');
            let operaName = $('#opera_name2');
            let amount = $('#amount2');

            let accText = acc.select2('data')[0]['text'];

            let line = '<tr>' +
                '<td style="text-align: center; width: 5%"><input type="checkbox" class="check2"></td>' +
                '<td><input type="hidden" name="accounts2[]" value="' + acc.val() + '">' + accText + '</td>' +
                '<td><input type="hidden" name="operations2[]" value="' + opera.val() + '">' + operaName.val() + '</td>' +
                '<td class="text-right text-bold amount"><input type="hidden" name="amounts2[]" value="' + trimOver(amount.val(), null) + '">' + money(amount.val()) + '</td>' +
                '</tr>';

            $('#genSet').append(line);
            $('#minus2').removeAttr('disabled');

            acc.val('').trigger('change');
            opera.val('').trigger('change');
            amount.val('');
            operaName.val('');
        });

        $('#minus2').click(function () {
            $('.check2').each(function () {
                if ($(this).is(':checked'))
                    $(this).closest('tr').remove();
            });
        });

        $('#minus2').hover(function () {
            if ($('#genSet tr').length === 0)
                $(this).attr('disabled', true);
        });

        $(document).on('click', '#save', function () {
            swal({
                    title: '@lang('sidebar.memset')',
                    text: '@lang('confirm.memset_text')',
                    type: 'info',
                    showCancelButton: true,
                    cancelButtonClass: 'bg-red',
                    confirmButtonClass: 'bg-green',
                    confirmButtonText: '@lang('confirm.yes')',
                    cancelButtonText: '@lang('confirm.no')',
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function (isConfirm) {
                    if (isConfirm) {
                        $('#memSetForm').submit();
                    }
                }
            );
        });
    </script>
@stop
