<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Situation Membre';
else
    $title = 'Member Situation';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    <div class="box">
        <div class="box-header">
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right fa fa-close" id="home"></button>
            </div>
        </div>
        <div class="box-body">
            <div class="box-header with-border">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="member" class="col-md-5 control-label">@lang('label.member')</label>
                            <div class="col-md-7">
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
                        <div class="col-md-12">
                            <input type="text" name="mem_name" id="mem_name" class="form-control" disabled>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-5 bg-maroon-gradient"></div>
                <div class="col-md-2 text-center text-blue text-bold">@lang('label.memaccs')</div>
                <div class="col-md-5 bg-maroon-gradient"></div>

                <table class="table table-striped table-hover table-bordered table-condensed table-responsive">
                    <thead>
                    <tr>
                        <th>@lang('label.account')</th>
                        <th>@lang('label.desc')</th>
                        <th>@lang('label.amount')</th>
                        <th>@lang('label.blocked')</th>
                        <th>@lang('label.available')</th>
                    </tr>
                    </thead>
                    <tbody id="memacc">
                    </tbody>
                </table>
            </div>

            <div class="col-md-12">
                <div class="col-md-5 bg-maroon-gradient"></div>
                <div class="col-md-2 text-center text-blue text-bold">@lang('label.memloanacc')</div>
                <div class="col-md-5 bg-maroon-gradient"></div>

                <table class="table table-striped table-hover table-bordered table-condensed table-responsive">
                    <thead>
                    <tr>
                        <th>@lang('label.loanno')</th>
                        <th>@lang('label.account')</th>
                        <th>@lang('label.amount')</th>
                        <th>@lang('label.capital')</th>
                        <th>@lang('label.interest')</th>
                        <th>@lang('label.delays')</th>
                        <th>@lang('label.fines')</th>
                        <th>@lang('label.totint')</th>
                        <th>@lang('label.date')</th>
                    </tr>
                    </thead>
                    <tbody id="loanacc">
                    </tbody>
                </table>
            </div>

            <div class="col-md-12">
                <button type="button" id="print" class="btn btn-sm bg-default pull-right btn-raised fa fa-print">
                </button>
            </div>
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
                        $('#mem_name').val(member.name);
                    } else {
                        $('#mem_name').val(member.name + ' ' + member.surname);
                    }

                    $.ajax({
                        url: "{{ url('getAccBalance') }}",
                        method: 'get',
                        data: {member: member.idmember},
                        success: function (accounts) {
                            let memAccLine = '';
                            let loanAccLine = '';
                            $.each(accounts, function (i, account) {
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

                                let loans = $.parseJSON(
                                    $.ajax({
                                        url: "{{ url('getMemLoans') }}",
                                        method: 'get',
                                        data: {member: member.idmember},
                                        dataType: 'json',
                                        async: false
                                    }).responseText
                                );

                                let loanAmt = 0;
                                $.each(loans, function (i, loan) {
                                    if (loan.memacc === account.account) {
                                        let loanType = $.parseJSON(
                                            $.ajax({
                                                url: "{{ url('getLoanType') }}",
                                                method: 'get',
                                                data: {ltype: loan.loantype},
                                                dataType: 'json',
                                                async: false
                                            }).responseText
                                        );

                                        let amt = '';
                                        if (loan.remamt === '0.00' || isNaN(loan.remamt)) {
                                            amt = loan.amount;
                                        } else {
                                            amt = loan.remamt;
                                        }
                                        loanAmt += amt;

                                        loanAccLine += "<tr>" +
                                            "<td>" + pad(loan.loanno, 6) + "</td>" +
                                            "<td>" + loanType.accnumb + "</td>" +
                                            "<td class='text-right text-bold'>" + money(parseInt(amt)) + "</td>" +
                                            "<td class='text-right text-bold'>" + money(parseInt(loan.intamt)) + "</td>" +
                                            "<td class='text-right text-bold'>" + money(parseInt(loan.intamt)) + "</td>" +
                                            "<td>" + money(parseInt(loan.intamt)) + "</td>" +
                                            "<td class='text-right text-bold'>" + money(parseInt(loan.intamt)) + "</td>" +
                                            "<td class='text-right text-bold'>" + money(parseInt(loan.intamt)) + "</td>" +
                                            "<td class='text-center'>" + userDate(loan.created_at) + "</td>" +
                                            "</tr>";
                                        $('#loanacc').html(loanAccLine);
                                    }
                                });

                                let available;
                                let block;
                                let initbal = parseInt(account.initbal);
                                let evebal = parseInt(account.evebal);

                                if (evebal === 0) {
                                    available = initbal - debit + credit;
                                } else {
                                    available = evebal - debit + credit;
                                }

                                if (available > parseInt(loanAmt)) {
                                    block = parseInt(loanAmt);
                                } else {
                                    block = available;
                                }

                                if (account.accabbr === 'O' || account.accabbr === 'E') {
                                    memAccLine += "<tr>" +
                                        "<td>" + account.accnumb + "</td>" +
                                        "<td>@if ($emp->lang == 'fr')" + account.labelfr + " @else " + account.labeleng + "@endif</td>" +
                                        "<td class='text-right text-bold'>" + money(available) + "</td>" +
                                        "<td class='text-right text-bold'>" + money(block) + "</td>" +
                                        "<td class='text-right text-bold'>" + money(available - block) + "</td>" +
                                        "</tr>";
                                    $('#memacc').html(memAccLine);
                                }

                                {{--else {--}}
                                {{--    $.ajax({--}}
                                {{--        url: "{{ url('getMemLoans') }}",--}}
                                {{--        method: 'get',--}}
                                {{--        data: {member: member.idmember},--}}
                                {{--        success: function (loans) {--}}
                                {{--            $.each(loans, function (i, loan) {--}}
                                {{--                if (loan.memacc === account.account) {--}}
                                {{--                    let amt = '';--}}
                                {{--                    if (loan.remamt === '0.00' || isNaN(loan.remamt)) {--}}
                                {{--                        amt = loan.amount;--}}
                                {{--                    } else {--}}
                                {{--                        amt = loan.remamt;--}}
                                {{--                    }--}}

                                {{--                    loanAccLine += "<tr>" +--}}
                                {{--                        "<td>" + pad(loan.loanno, 6) + "</td>" +--}}
                                {{--                        "<td>" + account.accnumb + "</td>" +--}}
                                {{--                        "<td class='text-right text-bold'>" + money(parseInt(amt)) + "</td>" +--}}
                                {{--                        "<td class='text-right text-bold'>" + money(parseInt(loan.intamt)) + "</td>" +--}}
                                {{--                        "<td class='text-right text-bold'>" + money(parseInt(loan.intamt)) + "</td>" +--}}
                                {{--                        "<td>" + money(parseInt(loan.intamt)) + "</td>" +--}}
                                {{--                        "<td class='text-right text-bold'>" + money(parseInt(loan.intamt)) + "</td>" +--}}
                                {{--                        "<td class='text-right text-bold'>" + money(parseInt(loan.intamt)) + "</td>" +--}}
                                {{--                        "<td class='text-center'>" + userDate(loan.created_at) + "</td>" +--}}
                                {{--                        "</tr>";--}}
                                {{--                    $('#loanacc').html(loanAccLine);--}}
                                {{--                }--}}
                                {{--            });--}}
                                {{--        },--}}
                                {{--        error: function (errors) {--}}
                                {{--            $.each(errors, function (i, error) {--}}
                                {{--                console.log(error)--}}
                                {{--            });--}}
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
    </script>
@stop
