<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.cfbank'))

@section('content')
    <div class="box">
        <div class="box-header">
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right fa fa-close" id="home"></button>
            </div>
        </div>
        <div class="box-body">
            <form action="{{ url('cash_from/store') }}" method="post" role="form" id="cashFromBank">
                {{csrf_field()}}
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cashcode" class="col-md-2 control-label">@lang('label.cash')</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="cashcode" id="cashcode" disabled
                                           value="{{$cash->cashcode}} :@if ($emp->lang == 'fr') {{$cash->labelfr}} @else {{$cash->labeleng}} @endif">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="opera" class="col-md-3 control-label">@lang('label.opera')</label>
                                <div class="col-md-9">
                                    <select class="form-control select2" name="opera" id="opera" disabled>
                                        <option></option>
                                        @foreach($operas as $opera)
                                            @if ($opera->opercode == 8)
                                                <option value="{{$opera->idoper}}" selected>{{pad($opera->opercode, 3)}}
                                                    : @if ($emp->lang === 'fr') {{$opera->labelfr}} @else {{$opera->labeleng}} @endif</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="account" class="col-md-3 control-label">@lang('label.account')</label>
                                <div class="col-md-9">
                                    <select class="form-control select2" name="account" id="account">
                                        <option></option>
                                        @foreach($accounts as $account)
                                            @if (substrWords($account->accnumb, 2) == '56')
                                                <option value="{{$account->idaccount}}">{{$account->accnumb}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <input type="text" class="form-control" name="acc_name" id="acc_name" disabled>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="amount" class="col-md-4 control-label">@lang('label.amount')</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control text-right text-bold" id="amount">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <table id="tableInput"
                           class="table w-auto table-striped table-hover table-condensed table-bordered table-responsive no-padding">
                        <caption class="text-blue">@lang('label.break')</caption>
                        <thead>
                        <tr class="text-blue">
                            <th>@lang('label.value')</th>
                            <th>@lang('label.label')</th>
                            <th>@lang('label.in')</th>
                            <th>@lang('label.amount')</th>
                            <th>@lang('label.letters')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($moneys as $money)
                            @if ($money->format == 'B')
                                <tr>
                                    <td id="bil">{{money($money->value)}}</td>
                                    <td id="bill">@if($emp->lang == 'fr') {{$money->labelfr}} @else {{$money->labeleng}} @endif</td>
                                    <td style="width: 10%;">
                                        <input type="text" name="{{$money->moncode}}" id="{{$money->moncode}}"
                                               oninput="sum('{{$money->value}}', '#{{$money->moncode}}', '#{{$money->moncode}}Sum', '#{{$money->moncode}}Word')">
                                    </td>
                                    <td class="sum" id="{{$money->moncode}}Sum"></td>
                                    <td class="text-blue word" id="{{$money->moncode}}Word"></td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                        <thead>
                        <tr>
                            <th colspan="5" class="bg-gray"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($moneys as $money)
                            @if ($money->format == 'C')
                                <tr>
                                    <td id="bil">{{money($money->value)}}</td>
                                    <td id="bill">@if($emp->lang == 'fr') {{$money->labelfr}} @else {{$money->labeleng}} @endif</td>
                                    <td style="width: 10%;">
                                        <input type="text" name="{{$money->moncode}}" id="{{$money->moncode}}"
                                               oninput="sum('{{$money->value}}', '#{{$money->moncode}}', '#{{$money->moncode}}Sum', '#{{$money->moncode}}Word')">
                                    </td>
                                    <td class="sum" id="{{$money->moncode}}Sum"></td>
                                    <td class="text-blue word" id="{{$money->moncode}}Word"></td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr class="bg-green-active">
                            <td colspan="3" style="text-align: center !important;">@lang('label.tobreak')</td>
                            <td>
                                <input type="text" class="bg-green-active pull-right text-bold"
                                       name="totbil" id="totbil" readonly>
                            </td>
                            <td class="text-left text-bold" id="totopera"></td>
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
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
        $('#account').change(function () {
            $.ajax({
                url: "{{ url('getAccount') }}",
                method: 'get',
                data: {
                    account: $(this).val()
                },
                success: function (account) {
                    console.log(account);
                    $('#acc_name').val("@if($emp->lang == 'fr')" + account.labelfr + " @else" + account.labeleng + " @endif");
                }
            });
        });

        $('#amount').on('input', function () {
            $(this).val(money($(this).val()));
            sumAll();
        });

        function sum(amount, valueId, sumId, wordId) {
            $(valueId).val(money($(valueId).val()));
            let totAmt = amount * trimOver($(valueId).val(), null);
            $(sumId).text(money(totAmt));
            $(wordId).text(toWord(totAmt));

            sumAll();
        }

        function sumAll() {
            let sum = 0;

            $('.sum').each(function () {
                let numb = trimOver($(this).text(), null);

                if (parseInt(numb))
                    sum += parseInt(numb);
            });
            $('#totbil').val(money(sum));
            $('#totopera').text(toWord(sum));

            $('#totrans').val(money(sum));

            let dif = parseInt(trimOver($('#amount').val(), null)) - sum;
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

        $('#save').click(function () {
            let amt = parseInt(trimOver($('#amount').val(), null));
            let tot = parseInt(trimOver($('#totrans').val(), null));
            if (amt === tot) {
                swal({
                        title: '@lang('sidebar.cfbank')',
                        text: '@lang('confirm.cfbank_text')',
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
                            $('#cashFromBank').submit();
                        }
                    }
                );
            } else {
                swal({
                        title: '@lang('confirm.cfbank')',
                        text: '@lang('confirm.cfbankerror_text')',
                        type: 'error',
                        confirmButtonClass: 'bg-blue',
                        confirmButtonText: 'OK',
                        closeOnConfirm: true,
                    }
                );
            }
        })
    </script>
@stop
