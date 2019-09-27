<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.ocout'))

@section('content')
    <div class="box">
        <div class="box-header">
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right fa fa-close" id="home"></button>
            </div>
        </div>
        <div class="box-body">
            <form action="{{ url('other_cash_out/store') }}" method="post" role="form" id="ocoutForm">
                {{ csrf_field() }}
                <div class="col-md-3">
                    <h2 class="bg-antiquewhite text-blue text-bold text-center">@lang('label.break')</h2>
                    <table id="tableInput"
                           class="table table-striped table-hover table-condensed table-bordered table-responsive no-padding">
                        <thead>
                        <tr>
                            <th colspan="2" class="bg-purples">@lang('label.notes')</th>
                            <th class="bilSum"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($moneys as $money)
                            @if ($money->format == 'B')
                                <tr>
                                    <td id="billet">{{money($money->value)}}</td>
                                    <td><input type="text" name="{{$money->moncode}}" id="{{$money->moncode}}"
                                               oninput="sum('{{$money->value}}', '#{{$money->moncode}}', '#{{$money->moncode}}Sum')">
                                    </td>
                                    <td class="sum text-right" id="{{$money->moncode}}Sum"></td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                        <thead>
                        <tr>
                            <th colspan="2" class="bg-purples">@lang('label.coins')</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($moneys as $money)
                            @if ($money->format == 'C')
                                <tr>
                                    <td id="billet">{{$money->value}}</td>
                                    <td><input type="text" name="{{$money->moncode}}" id="{{$money->moncode}}"
                                               oninput="sum('{{$money->value}}', '#{{$money->moncode}}', '#{{$money->moncode}}Sum')">
                                    </td>
                                    <td class="sum text-right" id="{{$money->moncode}}Sum"></td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th class="bg-purples" colspan="2"
                                style="text-align: center !important;">@lang('label.tobreak')</th>
                            <th class="bg-blue">
                                <input type="text" class="bg-blue pull-right text-bold" name="totbil" id="totbil"
                                       disabled style="text-align: right !important;">
                            </th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="box-header with-border">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="opera" class="col-md-3 control-label">@lang('label.opera')</label>
                                        <div class="col-md-9">
                                            @foreach ($operas as $opera)
                                                @if ($opera->opercode == 34)
                                                    <input type="text" class="form-control" disabled
                                                           value="{{pad($opera->opercode, 3)}} : @if ($emp->lang == 'fr') {{$opera->labelfr}}@else {{$opera->labeleng}} @endif">
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="represent"
                                                   class="col-md-4 control-label">@lang('label.represent')</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="represent" id="represent">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="account"
                                               class="col-md-5 control-label">@lang('label.account')</label>
                                        <div class="col-md-7">
                                            <select class="form-control select2" id="account">
                                                <option></option>
                                                @foreach($accounts as $account)
                                                    @if (substrWords($account->accnumb, 1) != 7)
                                                        <option
                                                            value="{{$account->idaccount}}">{{$account->accnumb}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="acc_name" id="acc_name"
                                               disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="desc" class="col-md-3 control-label">@lang('label.desc')</label>
                                        <div class="col-md-9">
                                            <div class="row">
                                                <input type="text" class="form-control" id="desc">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="col-md-7">
                                        <div class="row">
                                        <div class="row">
                                            <div class="form-group">
                                                <input type="text" class="form-control text-right text-bold" id="amount"
                                                       placeholder="@lang('label.amount')">
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="row">
                                            <div class="form-group">
                                                <button type="button" id="minus"
                                                        class="btn btn-sm bg-red pull-right btn-raised fa fa-minus"></button>
                                                <button type="button" id="plus"
                                                        class="btn btn-sm bg-green pull-right btn-raised fa fa-plus"></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
{{--                                <div class="col-md-3">--}}
{{--                                    <div class="form-group">--}}
{{--                                        <label for="amount" class="col-md-4 control-label">@lang('label.amount')</label>--}}
{{--                                        <div class="col-md-8">--}}
{{--                                            <input type="text" class="form-control text-right text-bold" id="amount">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-2">--}}
{{--                                    <div class="form-group">--}}
{{--                                        <button type="button" id="minus"--}}
{{--                                                class="btn btn-sm bg-red pull-right btn-raised fa fa-minus"></button>--}}
{{--                                        <button type="button" id="plus"--}}
{{--                                                class="btn btn-sm bg-green pull-right btn-raised fa fa-plus"></button>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                            </div>
                        </div>

                        <div class="col-md-12">
                            <table
                                class="table table-striped table-hover table-bordered table-condensed table-responsive no-padding">
                                <thead>
                                <tr>
                                    <th colspan="2">@lang('label.account')</th>
                                    <th>@lang('label.desc')</th>
                                    <th>@lang('label.amount')</th>
                                </tr>
                                </thead>
                                <tbody id="cont">
                                </tbody>
                                <tfoot id="tableInput">
                                <tr>
                                    <td colspan="3" class="text-right">@lang('label.totdist')</td>
                                    <td class="bg-blue text-right" id="totdist"></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="col-md-11">
                            <table class="table table-responsive" id="tableInput">
                                <thead>
                                <tr class="text-bold text-blue bg-antiquewhite text-left">
                                    @foreach($accounts as $account)
                                        @if ($cash->cashacc == $account->idaccount)
                                            <td style="width: 25%">
                                                @if($emp->lang == 'fr') {{$account->labelfr }} @else {{$account->labeleng }} @endif
                                            </td>
                                            <td>{{$account->accnumb }}</td>
                                        @endif
                                    @endforeach
                                    <td>@lang('label.totrans')</td>
                                    <td style="width: 15%"><input type="text" style="text-align: left" name="totrans"
                                                                  id="totrans" readonly></td>
                                    <td>@lang('label.diff')</td>
                                    <td id="diff" class="text-right" style="width: 15%"></td>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="col-md-1">
                            <button type="button" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save">
                            </button>
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
            if ($('#cont tr').length === 0) {
                $('#minus').attr('disabled', true);
            }
        });

        function sum(amount, valueId, sumId) {
            $(valueId).val(money($(valueId).val()));
            $(sumId).val(money(amount * trimOver($(valueId).val(), null)));

            let sum = 0;

            $('.sum').each(function () {
                let numb = trimOver($(this).val(), null);

                if (parseInt(numb))
                    sum += parseInt(numb);
            });
            $('#totbil').val(money(sum));
        }

        $('#account').change(function () {
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
        });

        $('#amount').on('input', function () {
            $(this).val(money($(this).val()));
        });

        $('#plus').click(function () {
            let acc = $('#account');
            let opera = $('#desc');
            let amount = $('#amount');

            let accId = acc.select2('data')[0]['id'];
            let accText = acc.select2('data')[0]['text'];

            let line = '<tr>' +
                '<td style="text-align: center; width: 5%"><input type="checkbox" class="check"></td>' +
                '<td><input type="hidden" name="accounts[]" value="' + accId + '">' + accText + '</td>' +
                '<td><input type="hidden" name="operations[]" value="' + opera.val() + '">' + opera.val() + '</td>' +
                '<td class="text-right text-bold amount"><input type="hidden" name="amounts[]" value="' + amount.val() + '">' + amount.val() + '</td>' +
                '</tr>';

            $('#cont').append(line);
            $('#minus').removeAttr('disabled');

            sumAmount();

            acc.val('').trigger('change');
            opera.val('');
            amount.val('');
            $('#acc_name').val('');
        });

        $('#minus').click(function () {
            $('.check').each(function () {
                if ($(this).is(':checked'))
                    $(this).closest('tr').remove();
            });
            sumAmount();
        });

        $('#minus').hover(function () {
            if ($('#cont tr').length === 0)
                $(this).attr('disabled', true);
        });

        function sumAmount() {
            let sum = 0;
            $('.amount').each(function () {
                let numb = trimOver($(this).text(), null);
                if (parseInt(numb))
                    sum += parseInt(numb);
            });
            $('#totdist').text(money(sum));
            $('#totrans').val(money(sum));

            let dif = parseInt(trimOver($('#totbil').val(), null)) - sum;
            let diff = $('#diff');

            if (dif < 0) {
                diff.attr('class', 'text-red');
                diff.text(money(dif));
            } else if (diff > 0) {
                diff.attr('class', 'text-green');
                diff.text(money(dif));
            } else {
                diff.attr('class', 'text-blue');
                diff.text(money(dif));
            }
        }

        $(document).on('click', '#save', function () {
            if (parseInt(trimOver($('#diff').text(), null)) === 0) {
                swal({
                        title: '@lang('sidebar.ocout')',
                        text: '@lang('confirm.ocout_text')',
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
                            $('#ocoutForm').submit();
                        }
                    }
                );
            } else {
                swal({
                        title: '@lang('sidebar.ocout')',
                        text: '@lang('confirm.ocouterror_text')',
                        type: 'error',
                        confirmButtonClass: 'bg-blue',
                        confirmButtonText: 'OK',
                        closeOnConfirm: true,
                    }
                );
            }
        });
    </script>
@stop
