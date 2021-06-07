<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.sort'))

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold"> @lang('sidebar.sort') </h3>
        </div>
{{--        <div class="box-header">--}}
{{--            <div class="box-tools">--}}
{{--                <button type="button" class="btn btn-alert bg-red btn-sm pull-right fa fa-close" id="home"></button>--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="box-body">
            <form action="{{ url('check_sort/store') }}" method="post" role="form" id="checkSortForm">
                {{ csrf_field() }}
                <div class="box-header with-border" id="form">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="check" class="col-md-3 control-label">@lang('label.checkno')</label>
                                <div class="col-md-9">
                                    <select name="check" id="check" class="form-control select2">
                                        <option></option>
                                        @foreach ($checks as $check)
                                            <option value="{{$check->idcheck}}">{{$check->checknumb}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="mem_numb" class="col-md-2 control-label">@lang('label.member')</label>
                                <div class="col-md-3">
                                    <input type="text" name="mem_numb" id="mem_numb" class="form-control" disabled>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" name="mem_name" id="mem_name" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="bank" class="col-md-3 control-label">@lang('label.bank')</label>
                                <div class="col-md-9">
                                    <input type="text" name="bank" id="bank" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="carrier"
                                       class="col-md-3 control-label">@lang('label.carrier')</label>
                                <div class="col-md-9">
                                    <input type="text" name="carrier" id="carrier" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="date" class="col-md-4 control-label">@lang('label.date')</label>
                                <div class="col-md-8">
                                    <input type="text" name="date" id="date" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="col-md-5 bg-maroon-gradient"></div>
                    <div class="col-md-2 text-center text-blue text-bold">@lang('label.memotacc')</div>
                    <div class="col-md-5 bg-maroon-gradient"></div>

                    <table
                        class="table table-striped table-hover table-condensed table-bordered table-responsive no-padding">
                        <thead>
                        <tr class="text-bold">
                            <th class="cout">@lang('label.account')</th>
                            <th style="width: 25%">@lang('label.entitle')</th>
                            <th>@lang('label.opera')</th>
                            <th class="cout">@lang('label.amount')</th>
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
        $('#check').change(function () {
            $.ajax({
                url: "{{ url('getToSortChecks') }}",
                method: 'get',
                data: {
                    check: $(this).val(),
                }, success: function (check) {
                    $('#mem_numb').val(pad(parseInt(check.memnumb), 6));

                    if (check.surname === null) {
                        $('#mem_name').val(check.name);
                    } else {
                        $('#mem_name').val(check.name + ' ' + check.surname);
                    }

                    $('#bank').val(check.ouracc + ' : ' + check.bname);
                    $('#carrier').val(check.carrier);
                    $('#date').val(userDate(check.created_at));

                    $.ajax({
                        url: "{{ url('getCheckAccs') }}",
                        method: 'get',
                        data: {
                            check: check.idcheck
                        },
                        success: function (checkAccs) {
                            let memLine = '';
                            let loanAccLine = '';
                            $.each(checkAccs, function (i, checkAcc) {
                                $('#mem_acc > tr').remove();
                                $('#loanacc > tr').remove();
                                if (checkAcc.type === 'N') {
                                    memLine += '<tr>' +
                                        '<td class="cout"><input type="hidden" name="accounts[]" value="' + checkAcc.account + '">' + checkAcc.accnumb + '</td>' +
                                        '<td style="width: 25%">@if ($emp->lang === 'fr')' + checkAcc.labelfr + ' @else ' + checkAcc.labeleng + '@endif</td>' +
                                        '<td><input type="hidden" name="operations[]" value="' + checkAcc.operation + '">' +
                                        '@if ($emp->lang === 'fr')' + checkAcc.credtfr + ' @else ' + checkAcc.credteng + '@endif</td>' +
                                        '<td class="text-right text-bold cout">' +
                                        '<input type="hidden" name="amounts[]" class="amount" value="' + parseInt(checkAcc.accamt) + '">' + money(parseInt(checkAcc.accamt)) + '</td>' +
                                        '</tr>';
                                    $('#mem_acc').html(memLine);
                                } else if (checkAcc.type === 'L') {
                                    $.ajax({
                                        url: "{{ url('getLoan') }}",
                                        method: 'get',
                                        data: {loan: checkAcc.loan},
                                        success: function (loan) {
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
                                                    '<td style="width: 9%"><input type="hidden" name="loans[]" value="' + checkAcc.loan + '">' + checkAcc.accnumb + '</td>' +
                                                    '<td style="width: 13%">@if ($emp->lang == 'fr')' + loanType.labelfr + ' @else ' + loanType.labeleng + '@endif</td>' +
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

                                                loanAccLine += '<td class="text-right text-bold cin">' +
                                                    '<input type="hidden" name="intamts[]" class="amount" value="' + checkAcc.intamt + '">' + money(checkAcc.intamt) + '</td>' +
                                                    '<td class="text-right text-bold cout">' +
                                                    '<input type="hidden" name="loanamts[]" class="amount" value="' + checkAcc.accamt + '">' + money(checkAcc.accamt) + '</td>' +
                                                    '</tr>';

                                                $('#loanacc').html(loanAccLine);
                                            }

                                            pasteLoans();
                                        }
                                    });
                                }
                            });
                            $('#totrans').val(money(check.amount));
                        }
                    });
                }
            });
        });

        $('#save').click(function () {
            let tot = parseInt(trimOver($('#totrans').val(), null));

            if (!isNaN(tot) && tot !== 0) {
                swal({
                        title: '@lang('sidebar.sort')',
                        text: '@lang('confirm.checksort_text')',
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
                            $('#checkSortForm').submit();
                        }
                    }
                )
            } else {
                swal({
                        title: '@lang('sidebar.sort')',
                        text: '@lang('confirm.checksorterror_text')',
                        type: 'error',
                        confirmButtonClass: 'bg-blue',
                        confirmButtonText: 'OK',
                        closeOnConfirm: true,
                    }
                )
            }
        });
    </script>
@stop
