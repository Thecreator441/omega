<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.cin'))

@section('content')
    <div class="box">
        <div class="box-header">
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right fa fa-close" id="home"></button>
            </div>
        </div>
        <div class="box-body">
            <form action="{{ url('cash_in/store') }}" method="post" role="form" id="cinForm">
                {{ csrf_field() }}
                <div class="col-md-3">
                    <div class="form-group">
                        <h3 class="bg-antiquewhite text-blue text-bold text-center">@lang('label.break')</h3>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="member" class="col-md-4 control-label">@lang('label.member')</label>
                                    <div class="col-md-8">
                                        <select class="form-control select2" name="member" id="member">
                                            <option></option>
                                            @foreach($members as $member)
                                                <option
                                                    value="{{$member->idmember}}">{{pad($member->memnumb, 6)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="represent"
                                           class="col-md-3 control-label">@lang('label.represent')</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="represent" id="represent">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
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
                <div class="col-md-9" id="tableInput">
                    <table
                        class="table table-striped table-hover table-condensed table-bordered table-responsive no-padding">
                        <thead>
                        <tr class="bg-purples">
                            <th>@lang('label.account')</th>
                            <th>@lang('label.entitle')</th>
                            <th>@lang('label.opera')</th>
                            <th>@lang('label.amount')</th>
                        </tr>
                        </thead>
                        <tbody id="mem_acc">
                        </tbody>
                        <tfoot>
                        <tr class="bg-purples text-right text-bold">
                            <td colspan="4" id="totopera"></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="col-md-12" id="tableInput">
                    <div class="col-md-5 bg-maroon-gradient"></div>
                    <div class="col-md-2 text-center text-blue text-bold">@lang('label.loanacc')</div>
                    <div class="col-md-5 bg-maroon-gradient"></div>

                    <table
                        class="table table-striped table-hover table-bordered table-condensed table-responsive">
                        <thead>
                        <tr class="bg-antiquewhite text-blue">
                            <th>@lang('label.account')</th>
                            <th>@lang('label.entitle')</th>
                            <th>@lang('label.penalty')</th>
                            <th>@lang('label.late')</th>
                            <th>@lang('label.amount')</th>
                            <th>@lang('label.capital')</th>
                            <th>@lang('label.retint')</th>
                            <th>@lang('label.totint')</th>
                            <th>@lang('label.payment')</th>
                            <th>@lang('label.interest')</th>
                            <th>@lang('label.diff')</th>
                        </tr>
                        </thead>
                        <tbody id="loan_acc">
                        </tbody>
                    </table>
                </div>

                <div class="col-md-11" id="tableInput">
                    <table class="table table-responsive">
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
                                <input type="text" style="text-align: left" name="totrans" id="totrans" readonly></td>
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
        $('#member').change(function () {
            $.ajax({
                url: "{{ url('getMember') }}",
                method: 'get',
                data: {
                    member: $(this).val()
                },
                success: function (member) {
                    if (member.surname === null) {
                        $('#represent').val(member.name);
                    } else {
                        $('#represent').val(member.name + ' ' + member.surname);
                    }

                    $.ajax({
                        url: "{{ url('getAccBalance') }}",
                        method: 'get',
                        data: {member: member.idmember},
                        success: function (accounts) {
                            let memAccLine = '';
                            let loanAccLine = '';
                            $.each(accounts, function (i, account) {
                                if (account.accabbr === 'O') {
                                    memAccLine += "<tr>" +
                                        "<td><input type='hidden' name='accounts[]' value='" + account.account + "'>" + account.accnumb + "</td>" +
                                        "<td>@if ($emp->lang == 'fr')" + account.labelfr + " @else " + account.labeleng + "@endif</td>" +
                                        "<td><input type='hidden' name='operations[]' value='" + account.operation + "'>@if ($emp->lang == 'fr')" + account.credtfr + " @else " + account.credteng + "@endif</td>" +
                                        "<td><input type='text' name='amounts[]' class='amount'></td>" +
                                        "</tr>";
                                    $('#mem_acc').html(memAccLine);
                                }
                                {{--else if (account.accabbr === 'E') {--}}
                                {{--    let loans = $.parseJSON(--}}
                                {{--        $.ajax({--}}
                                {{--            url: "{{ url('getMemLoans') }}",--}}
                                {{--            method: 'get',--}}
                                {{--            data: {member: member.idmember},--}}
                                {{--            dataType: 'json',--}}
                                {{--            async: false--}}
                                {{--        }).responseText--}}
                                {{--    );--}}

                                {{--    let loanAmt = 0;--}}
                                {{--    $.each(loans, function (i, loan) {--}}
                                {{--        if (loan.memacc === account.account) {--}}
                                {{--            let loanType = $.parseJSON(--}}
                                {{--                $.ajax({--}}
                                {{--                    url: "{{ url('getLoanType') }}",--}}
                                {{--                    method: 'get',--}}
                                {{--                    data: {ltype: loan.loantype},--}}
                                {{--                    dataType: 'json',--}}
                                {{--                    async: false--}}
                                {{--                }).responseText--}}
                                {{--            );--}}

                                {{--            let amt = '';--}}
                                {{--            if (loan.remamt === '0.00' || isNaN(loan.remamt)) {--}}
                                {{--                amt = loan.amount;--}}
                                {{--            } else {--}}
                                {{--                amt = loan.remamt;--}}
                                {{--            }--}}
                                {{--            loanAmt += amt;--}}

                                {{--            loanAccLine += "<tr>" +--}}
                                {{--                "<td>" + pad(loan.loanno, 6) + "</td>" +--}}
                                {{--                "<td>" + loanType.accnumb + "</td>" +--}}
                                {{--                "<td class='text-right text-bold'>" + money(parseInt(amt)) + "</td>" +--}}
                                {{--                "<td class='text-right text-bold'>" + money(parseInt(loan.intamt)) + "</td>" +--}}
                                {{--                "<td class='text-right text-bold'>" + money(parseInt(loan.intamt)) + "</td>" +--}}
                                {{--                "<td>" + money(parseInt(loan.intamt)) + "</td>" +--}}
                                {{--                "<td class='text-right text-bold'>" + money(parseInt(loan.intamt)) + "</td>" +--}}
                                {{--                "<td class='text-right text-bold'>" + money(parseInt(loan.intamt)) + "</td>" +--}}
                                {{--                "<td class='text-center'>" + userDate(loan.created_at) + "</td>" +--}}
                                {{--                "</tr>";--}}
                                {{--            $('#loan_acc').html(loanAccLine);--}}
                                {{--        }--}}
                                {{--    });--}}
                                {{--}--}}
                            });
                        },
                        error: function (errors) {
                            $.each(errors, function (i, error) {
                                console.log(error)
                            });
                        }
                    });
                }
            });
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

        $(document).on('input', '.amount', function () {
            $(this).val(money($(this).val()));

            let sumAmt = 0;

            $('.amount').each(function () {
                let amount = trimOver($(this).val(), null);
                if (parseInt(amount)) {
                    sumAmt += parseInt(amount);
                }
            });

            $('#totrans').val(money(sumAmt));
            $('#totopera').text(toWord(sumAmt, '{{$emp->lang}}'));

            let dif = parseInt(trimOver($('#totbil').val(), null)) - sumAmt;
            let diff = $('#diff');

            if (dif < 0) {
                diff.attr('class', 'text-red');
            } else if (dif > 0) {
                diff.attr('class', 'text-green');
            } else {
                diff.attr('class', 'text-blue');
            }
            diff.text(money(dif));
        });

        $('#save').click(function () {
            if (parseInt(trimOver($('#diff').text(), null)) === 0) {
                swal({
                        title: '@lang('sidebar.cin')',
                        text: '@lang('confirm.cin_text')',
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
                            $('#cinForm').submit();
                        }
                    }
                );
            } else {
                swal({
                        title: '@lang('sidebar.cin')',
                        text: '@lang('confirm.cinerror_text')',
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
