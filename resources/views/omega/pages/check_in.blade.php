<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.checkin'))

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold"> @lang('sidebar.checkin') </h3>
        </div>
{{--        <div class="box-header">--}}
{{--            <div class="box-tools">--}}
{{--                <button type="button" class="btn btn-alert bg-red btn-sm pull-right fa fa-close" id="home"></button>--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="box-body">
            <form action="{{ url('check_in/store') }}" method="post" role="form" id="checkForm">
                {{ csrf_field() }}
                <div class="box-header with-border" id="form">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="member" class="col-md-2 control-label">@lang('label.member')</label>
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
                                    <div class="row">
                                        <input type="text" class="form-control" name="mem_name" id="mem_name" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="bank" class="col-md-2 control-label">@lang('label.bank')</label>
                                <div class="col-md-3">
                                    <select class="form-control select2" name="bank" id="bank">
                                        <option></option>
                                        @foreach($banks as $bank)
                                            <option
                                                value="{{$bank->idbank}}"> {{pad($bank->bankcode, 6)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="bank_name" id="bank_name" disabled>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="checkno"
                                       class="col-md-3 control-label">@lang('label.checkno')</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="checkno" id="checkno">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" class="form-control text-right text-bold" name="checkamt"
                                       id="checkamt" placeholder="@lang('label.amount')">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="carrier"
                                       class="col-md-2 control-label">@lang('label.carrier')</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="carrier" id="carrier">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-5 bg-maroon-gradient"></div>
                        <div class="col-md-2 text-center text-blue text-bold">@lang('label.memotacc')</div>
                        <div class="col-md-5 bg-maroon-gradient"></div>
                    </div>

                    <table id="tableInput"
                           class="table table-striped table-hover table-condensed table-bordered table-responsive no-padding">
                        <thead>
                        <tr class="bg-purples">
                            <th>@lang('label.account')</th>
                            <th>@lang('label.desc')</th>
                            <th>@lang('label.opera')</th>
                            <th>@lang('label.amount')</th>
                        </tr>
                        </thead>
                        <tbody id="mem_acc">
                        </tbody>
                    </table>
                </div>

                <div class="col-md-12" id="tableInput">
                    <div class="col-md-5 bg-maroon-gradient"></div>
                    <div class="col-md-2 text-center text-blue text-bold">@lang('label.memloanacc')</div>
                    <div class="col-md-5 bg-maroon-gradient"></div>

                    <table id="simul-data-table2"
                           class="table table-striped table-hover table-bordered table-condensed table-responsive">
                        <thead>
                        <tr>
                            <th style="width: 9%">@lang('label.account')</th>
                            <th style="width: 13%">@lang('label.desc')</th>
                            <th class="cin">@lang('label.loanamt')</th>
                            <th class="cin">@lang('label.capital')</th>
                            <th style="width: 5%">@lang('label.late')</th>
                            <th class="cin">@lang('label.interest')</th>
                            <th class="cin">@lang('label.finint')</th>
                            <th class="cin">@lang('label.accint')</th>
                            <th class="cin">@lang('label.totint')</th>
                            <th class="cin">@lang('label.intpay')</th>
                            <th class="cout">@lang('label.payment')</th>
                        </tr>
                        </thead>
                        <tbody id="loanacc">
                        </tbody>
                        <tfoot></tfoot>
                    </table>
                </div>

                <div class="col-md-11" id="tableInput">
                    <table class="table table-responsive">
                        <thead>
                        <tr class="text-bold text-blue bg-antiquewhite text-right">
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
        $(document).ready(function () {
            $('#checkno').verifNumber();
        });

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

                    async function memAccs() {
                        const accBals = await getData('getAccBalance?member=' + member.idmember);

                        let memAccLine = '';

                        $.each(accBals, function (i, accBal) {
                            if (accBal.accabbr === 'O') {
                                memAccLine += '<tr>' +
                                    '<td><input type="hidden" name="accounts[]" value="' + accBal.account + '">' + accBal.accnumb + '</td>' +
                                    '<td>@if ($emp->lang == 'fr')' + accBal.labelfr + ' @else ' + accBal.labeleng + '@endif</td>' +
                                    '<td><input type="hidden" name="operations[]" value="' + accBal.operation + '">@if ($emp->lang == 'fr')' + accBal.credtfr + ' @else ' + accBal.credteng + '@endif</td>' +
                                    '<td><input type="text" name="amounts[]" class="amount"></td>' +
                                    '</tr>';
                            }
                        });
                        $('#mem_acc').html(memAccLine);
                    }

                    $('#loanacc > tr').remove();

                    async function memLoans() {
                        const loans = await getData('getMemLoans?member=' + member.idmember);

                        let loanAccLine = '';

                        $.each(loans, function (i, loan) {
                            let loanamt = parseInt(loan.amount);
                            if (parseInt(loan.isRef) > 0) {
                                loanamt = parseInt(loan.refamt);
                            }
                            let paidamt = parseInt(loan.paidamt);
                            let remamt = loanamt - paidamt;
                            let accramt = parseInt(loan.accramt);

                            async function pasteLoans() {
                                const loanType = await getData('getLoanType?ltype=' + loan.loantype);
                                const installs = await getData('getInstalls?loan=' + loan.idloan);

                                let days = 0;
                                let totPaid = 0;
                                let diff = 0;

                                $.each(installs, function (i, install) {
                                    const dateInterval = 86400000;
                                    let date0 = new Date(loan.instdate1);
                                    let date1 = new Date(loan.lastdate);
                                    let date2 = new Date(install.instdate);
                                    let date3 = new Date();

                                    if ((date3.getTime() >= date0.getTime())) {
                                        totPaid += parseInt(install.amort);
                                        diff = paidamt - totPaid;

                                        if (date1.getTime() <= date2.getTime()) {
                                            if (diff > 0) {
                                                days = Math.abs(Math.floor((date2.getTime() - date3.getTime()) / dateInterval));
                                            } else {
                                                if (paidamt > 0) {
                                                    days = Math.abs(Math.floor((date3.getTime() - date1.getTime()) / dateInterval));
                                                } else {
                                                    days = Math.abs(Math.floor((date3.getTime() - date0.getTime()) / dateInterval));
                                                }
                                            }
                                        }
                                    }
                                });

                                let inst = Math.round((remamt * loan.intrate) / 100);
                                let totints = inst + accramt;

                                loanAccLine += '<tr>' +
                                    '<td style="width: 9%"><input type="hidden" name="loans[]" value="' + loan.idloan + '">' + loan.accnumb + '</td>' +
                                    '<td style="width: 13%">@if ($emp->lang == 'fr')' + loan.labelfr + ' @else ' + loan.labeleng + '@endif</td>' +
                                    '<td class="text-right text-bold cin">' + money(loanamt) + '</td>' +
                                    '<td class="text-right text-bold cin">' + money(remamt) + '</td>';

                                if (diff >= 0) {
                                    loanAccLine += '<td class="text-center" style="width: 5%">-' + days + '</td>' +
                                        '<td class="text-right text-bold cin">' +
                                        '<input type="hidden" name="ints[]" value="' + inst + '">' + money(inst) + '</td>' +
                                        '<td class="text-right text-bold cin">' +
                                        '<input type="hidden" name="pens[]" value="' + 0 + '">' + money(0) + '</td>' +
                                        '<td class="text-right text-bold cin">' +
                                        '<input type="hidden" name="accrs[]" value="' + accramt + '">' + money(accramt) + '</td>' +
                                        '<td class="text-right text-bold cin">' +
                                        '<input type="hidden" name="totints[]" value="' + totints + '">' + money(totints) + '</td>';
                                } else {
                                    let pen = Math.round((remamt * days * loanType.pentax) / 1200);
                                    totints += pen;

                                    loanAccLine += '<td class="text-center" style="width: 5%">+' + days + '</td>' +
                                        '<td class="text-right text-bold cin">' +
                                        '<input type="hidden" name="ints[]" value="' + inst + '">' + money(inst) + '</td>' +
                                        '<td class="text-right text-bold cin">' +
                                        '<input type="hidden" name="pens[]" value="' + pen + '">' + money(pen) + '</td>' +
                                        '<td class="text-right text-bold cin">' +
                                        '<input type="hidden" name="accrs[]" value="' + accramt + '">' + money(accramt) + '</td>' +
                                        '<td class="text-right text-bold cin">' +
                                        '<input type="hidden" name="totints[]" value="' + totints + '">' + money(totints) + '</td>';
                                }

                                if (accramt === 0) {
                                    loanAccLine += '<td class="cin"><input type="text" name="intamts[]" class="amount"></td>';
                                } else {
                                    loanAccLine += '<td class="cin"><input type="text" name="intamts[]" class="amount" required></td>';
                                }
                                loanAccLine += '<td class="cout"><input type="text" name="loanamts[]" class="amount"></td>' +
                                    '</tr>';

                                $('#loanacc').html(loanAccLine);
                            }

                            pasteLoans();
                        });
                    }

                    memAccs();
                    memLoans();
                }
            });
        });

        $('#bank').change(function () {
            $.ajax({
                url: "{{ url('getBank') }}",
                method: 'get',
                data: {
                    bank: $(this).val()
                },
                success: function (bank) {
                    $('#bank_name').val(bank.name);
                }
            });
        });

        $('#checkamt').on('input', function () {
            $(this).val(money($(this).val()));

            sumAmount();
        });

        $(document).on('input', '.amount', function () {
            $(this).val(money($(this).val()));

            sumAmount();
        });

        function sumAmount() {
            let sumAmt = 0;

            $('.amount').each(function () {
                let amount = trimOver($(this).val(), null);
                if (parseInt(amount)) {
                    sumAmt += parseInt(amount);
                }
            });

            $('#totrans').val(money(sumAmt));

            let dif = parseInt(trimOver($('#checkamt').val(), null)) - sumAmt;
            let diff = $('#diff');

            if (dif < 0) {
                diff.attr('class', 'text-red');
            } else if (dif > 0) {
                diff.attr('class', 'text-green');
            } else {
                diff.attr('class', 'text-blue');
            }
            diff.text(money(dif));
        }

        $(document).on('click', '#save', function () {
            let tot = parseInt(trimOver($('#totrans').val(), null));
            let amt = parseInt(trimOver($('#checkamt').val(), null));
            let dif = parseInt(trimOver($('#diff').text(), null));

            if ((tot === amt) && (dif === 0)) {
                swal({
                        title: '@lang('sidebar.checkin')',
                        text: '@lang('confirm.checkinsave_text')',
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
                            $('#checkForm').submit();
                        }
                    }
                );
            } else {
                swal({
                        title: '@lang('sidebar.checkin')',
                        text: '@lang('confirm.checkinerror_text')',
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
