<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.cout'))

@section('content')
    <div class="box">
        <div class="box-header">
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right fa fa-close" id="home"></button>
            </div>
        </div>
        <div class="box-body">
            <form action="{{ url('cash_out/store') }}" method="post" id="coutForm" role="form"
                  enctype="multipart/form-data">
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
                    <div class="col-md-9">
                        <div class="row">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="member"
                                               class="col-md-2 control-label">@lang('label.member')</label>
                                        <div class="col-md-3">
                                            <select class="form-control select2" name="member" id="member">
                                                <option></option>
                                                @foreach($members as $member)
                                                    <option
                                                        value="{{$member->idmember}}">{{pad($member->memnumb, 6)}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" name="mem_name" id="mem_name" class="form-control"
                                                   disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="nic"
                                               class="col-md-2 control-label">@lang('label.idcard')</label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="nic" id="nic"
                                                   disabled="disabled">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="benef"
                                               class="col-md-2 control-label">@lang('label.benef')</label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="benef" id="benef">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="loan_info"
                                               class="col-md-2 control-label">@lang('label.loaninf')</label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="loan_info" id="loan_info">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="row">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <img id="pic" alt="@lang('label.mempic')" class="img-bordered-sm"
                                             style="height: 150px; width: 100%;"/>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <img id="sign" alt="@lang('label.memsign')" class="img-bordered-sm"
                                             style="height: 70px; width: 100%;"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12" id="tableInput">
                        <div class="row">
                            <div class="row">
                                <table id="simul-data-table"
                                       class="table table-striped table-hover table-condensed table-bordered table-responsive no-padding">
                                    <thead>
                                    <tr class="bg-purples">
                                        <th>@lang('label.account')</th>
                                        <th style="width: 20%">@lang('label.entitle')</th>
                                        <th>@lang('label.opera')</th>
                                        <th>@lang('label.available')</th>
                                        <th>@lang('label.amount')</th>
                                        <th>@lang('label.fees')</th>
                                    </tr>
                                    </thead>
                                    <tbody id="mem_table">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-11">
                        <div class="row">
                            <div class="row">
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
                                        <td style="width: 15%">
                                            <input type="text" style="text-align: left" name="totrans" id="totrans"
                                                   readonly></td>
                                        <td>@lang('label.diff')</td>
                                        <td id="diff" class="text-right" style="width: 15%"></td>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="row">
                            <div class="row">
                                <button type="button" id="save"
                                        class="btn btn-sm bg-blue pull-right btn-raised fa fa-save">
                                </button>
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
        $('#member').change(function () {
            $.ajax({
                url: "{{ url('getMember') }}",
                method: 'get',
                data: {member: $(this).val()},
                success: function (member) {
                    if (member.surname === null) {
                        $('#mem_name').val(member.name);
                        $('#benef').val(member.name);
                    } else {
                        $('#mem_name').val(member.name + ' ' + member.surname);
                        $('#benef').val(member.name + ' ' + member.surname);
                    }
                    $('#nic').val(member.nic);
                    $('#pic').attr('src', member.pic);
                    $('#sign').attr('src', member.signature);

                    $.ajax({
                        url: "{{ url('getAccBalance') }}",
                        method: 'get',
                        data: {member: member.idmember},
                        success: function (accounts) {
                            let ordLine = '';
                            $.each(accounts, function (i, account) {
                                if (account.accabbr === 'O') {
                                    let available;
                                    let initbal = parseInt(account.initbal);
                                    let evebal = parseInt(account.evebal);

                                    let debit = $.parseJSON(
                                        $.ajax({
                                            url: "{{ url('getMemDebit') }}",
                                            method: 'get',
                                            data: {
                                                member: member.idmember,
                                                account: account.account,
                                            },
                                            dataType: 'json',
                                            async: false
                                        }).responseText
                                    );

                                    let credit = $.parseJSON(
                                        $.ajax({
                                            url: "{{ url('getMemCredit') }}",
                                            method: 'get',
                                            data: {
                                                member: member.idmember,
                                                account: account.account,
                                            },
                                            dataType: 'json',
                                            async: false
                                        }).responseText
                                    );

                                    if (evebal === 0) {
                                        available = -initbal + (debit - credit);
                                    } else {
                                        available = -evebal + (debit - credit);
                                    }

                                    ordLine += "<tr>" +
                                        "<td><input type='hidden' name='accounts[]' value='" + account.account + "'>" + account.accnumb + "</td>" +
                                        "<td>@if ($emp->lang == 'fr')" + account.labelfr + " @else " + account.labeleng + "@endif</td>" +
                                        "<td><input type='hidden' name='operations[]' value='" + account.operation + "'>" +
                                        "@if ($emp->lang == 'fr')" + account.debtfr + " @else " + account.debteng + "@endif</td>" +
                                        "<td class='text-right'>" + money(Math.abs(available)) + "</td>" +
                                        "<td><input type='text' class='amount' name='amounts[]'></td>" +
                                        "<td><input type='text' class='fee' name='fees[]'></td>" +
                                        "</tr>";
                                    $('#mem_table').html(ordLine);
                                }
                            });
                        }
                    });
                }
            });
        });

        function sum(amount, valueId, sumId) {
            $(valueId).val(money($(valueId).val()));
            $(sumId).text(money(amount * trimOver($(valueId).val(), null)));

            let sum = 0;

            $('.sum').each(function () {
                let numb = trimOver($(this).text(), null);
                if (parseInt(numb))
                    sum += parseInt(numb);
            });
            $('#totbil').val(money(sum));
        }

        $(document).on('input', '.amount, .fee', function () {
            $(this).val(money($(this).val()));

            let sumAmt = 0;

            $('.amount, .fee').each(function () {
                let amount = trimOver($(this).val(), null);
                if (parseInt(amount)) {
                    sumAmt += parseInt(amount);
                }
            });

            $('#totrans').val(money(sumAmt));

            let dif = parseInt(trimOver($('#totbil').val(), null)) - sumAmt;
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
        });

        $('#save').click(function () {
            if (parseInt(trimOver($('#diff').text(), null)) === 0) {
                swal({
                        title: '@lang('sidebar.cout')',
                        text: '@lang('confirm.cout_text')',
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
                            $('#coutForm').submit();
                        }
                    }
                );
            } else {
                swal({
                        title: '@lang('sidebar.cout')',
                        text: '@lang('confirm.couterror_text')',
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
