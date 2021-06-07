<?php $emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>


@extends('layouts.dashboard')

@section('title', trans('sidebar.provi'))

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold"> @lang('sidebar.provi') </h3>
        </div>
        {{--        <div class="box-header">--}}
        {{--            <div class="box-tools">--}}
        {{--                <button type="button" class="btn btn-alert bg-red btn-sm pull-right fa fa-close" id="home"></button>--}}
        {{--            </div>--}}
        {{--        </div>--}}
        <div class="box-body">
            <form action="{{ url('provision_report/store') }}" method="POST" role="form" id="proForm">
                {{ csrf_field() }}
                <div class="box-header with-border">
                    {{--                    <div class="row">--}}
                    {{--                        <div class="col-md-4"></div>--}}
                    {{--                        <div class="col-md-4">--}}
                    {{--                            <div class="form-group">--}}
                    {{--                                <label for="date"--}}
                    {{--                                       class="col-md-3 control-label">@lang('label.date')</label>--}}
                    {{--                                <div class="col-md-9">--}}
                    {{--                                    <input type="date" name="date" id="date" class="form-control">--}}
                    {{--                                </div>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                        <div class="col-md-4"></div>--}}
                    {{--                    </div>--}}

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="ageing"
                                       class="col-md-4 control-label">@lang('label.loanage')</label>
                                <div class="col-md-8">
                                    <select class="form-control select2" id="ageing">
                                        <option value="">@lang('label.all')</option>
                                        <option value="3">30 - 59</option>
                                        <option value="6">60 - 89</option>
                                        <option value="9">90 - 119</option>
                                        <option value="12">120 - 179</option>
                                        <option value="18">180 - 359</option>
                                        <option value="36">> 360</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="ltype"
                                       class="col-md-4 control-label">@lang('label.loanty')</label>
                                <div class="col-md-8">
                                    <select class="form-control select2" id="ltype">
                                        <option value="">@lang('label.all')</option>
                                        @foreach ($loanTypes as $loanType)
                                            <option value="{{$loanType->idltype}}">{{pad($loanType->lcode, 3)}} :
                                                @if ($emp->lang=='fr') {{$loanType->labelfr}} @else {{$loanType->labeleng}} @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="loanoff"
                                       class="col-md-4 control-label">@lang('label.loanoff')</label>
                                <div class="col-md-8">
                                    <select class="form-control select2" id="loanoff">
                                        <option value="">@lang('label.all')</option>
                                        @foreach ($employees as $employee)
                                            <option
                                                value="{{$employee->idemp}}">{{$employee->name}} {{$employee->surname}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <button type="button" id="search"
                                        class="btn btn-sm bg-green pull-right btn-raised fa fa-search">
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <table id="simul-data-table"
                           class="table table-striped table-hover table-condensed table-bordered table-responsive">
                        <thead>
                        <tr>
                            <th style="text-align: center; width: 2%"><input type="checkbox" id="check"></th>
                            <th style="width: 6%">@lang('label.loan')</th>
                            <th style="width: 6%">@lang('label.member')</th>
                            <th style="width: 15%">@lang('label.name')</th>
                            <th class="cin">@lang('label.amount')</th>
                            <th class="cin">@lang('label.capital')</th>
                            <th class="cin">@lang('label.interest')</th>
                            <th class="cin">@lang('label.fines')</th>
                            <th class="cin">@lang('label.total')</th>
                            <th class="cin">@lang('label.guarant')</th>
                            <th class="cin">@lang('label.risk')</th>
                            <th style="width: 3%">@lang('label.days')</th>
                            <th class="cin">@lang('label.provi')</th>
                        </tr>
                        </thead>
                        <tbody id="provReport"></tbody>
                        <tfoot id="tableInput">
                        <tr class="bg-antiquewhite" id="provFoot"></tr>
                        </tfoot>
                    </table>
                </div>

                <div class="col-md-12">
                    <button type="button" id="print" class="btn btn-sm bg-default pull-right btn-raised fa fa-print"></button>
                    <button type="button" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>
                </div>
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
        $(document).ready(function () {
            fillLoans($('#ltype').val(), $('#loanoff').val());
        });

        $('#search').click(function () {
            fillLoans($('#ltype').val(), $('#loanoff').val());
        });

        function fillLoans(ltype = null, emp = null) {
            let proFoot = '';
            let tot = '@lang('label.total')';

            proFoot += '<td class="text-center text-bold" colspan="4" style="width: 29%">' + tot + '</td>' +
                '<td class="text-right text-bold cin" id="totAmt"></td>' +
                '<td class="text-right text-bold cin" id="totCap"></td>' +
                '<td class="text-right text-bold cin" id="totInt"></td>' +
                '<td class="text-right text-bold cin" id="totFin"></td>' +
                '<td class="text-right text-bold cin" id="totTot"></td>' +
                '<td class="text-right text-bold cin" id="totGua"></td>' +
                '<td class="text-right text-bold cin" id="totRis"></td>' +
                '<td class="text-right text-bold" colspan="2" style="width: 17%">' +
                '<input type="text" class="text-right text-bold" id="totPro" readonly></td>';

            $('#provFoot').html(proFoot);
            $.ajax({
                url: "{{ url('getProvLoans') }}",
                method: 'get',
                data: {
                    ltype: ltype,
                    employee: emp
                },
                success: function (loans) {
                    let proBody = '';
                    let age = parseInt($('#ageing').val());
                    let row = 0;

                    $.each(loans, function (i, loan) {
                        let surname = '';
                        if (loan.surname !== null) {
                            surname = loan.surname;
                        }

                        let amt = loan.amount;
                        if (loan.isRef > 1) {
                            amt = loan.refamt;
                        }

                        let paidamt = parseInt(loan.paidamt);
                        let remamt = amt - paidamt;

                        $('#provReport > tr').remove();

                        async function populate() {
                            const comakers = await getData('getComakers?loan=' + loan.idloan);
                            const mortgages = await getData('getMortgages?loan=' + loan.idloan);
                            const loanType = await getData('getLoanType?ltype=' + loan.loantype);
                            const installs = await getData('getInstalls?loan=' + loan.idloan);

                            let comake = 0;
                            let totAmt = 0;
                            let totCap = 0;
                            let totInt = 0;
                            let totFin = 0;
                            let totTot = 0;
                            let totGua = 0;
                            let totRis = 0;
                            let totPro = 0;

                            if (comakers !== null) {
                                $.each(comakers, function (i, comaker) {
                                    comake += (parseInt(comaker.guaramt) - parseInt(comaker.paidguar));
                                });
                            }
                            if (mortgages !== null) {
                                $.each(mortgages, function (i, mortgage) {
                                    let actamt = parseInt(mortgage.amount);
                                    if (actamt === 0) {
                                        actamt = parseInt(mortgage.amount);
                                    }
                                    comake += actamt;
                                });
                            }

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

                            if (days >= 30) {
                                let inst = Math.round((remamt * loan.intrate) / 100);
                                let pen = Math.round((remamt * days * loanType.pentax) / 1200);
                                let total = remamt + inst + pen;
                                let risk = total - comake;

                                if ((loan.guarantee === 'F') || (loan.guarantee === 'F&M')) {
                                    if (age === 3) {
                                        if (days >= 30 && days <= 59) {
                                            proBody += '<tr>' +
                                                '<td style="text-align: center; width: 2%"><input type="checkbox" class="check" value="' + row++ + '" name="provs[]"></td>' +
                                                '<td style="width: 6%">' + pad(loan.loanno, 6) + '</td>' +
                                                '<td style="width: 6%">' + pad(loan.memnumb, 6) + '</td>' +
                                                '<td style="width: 15%">' + loan.name + '</td>' +
                                                '<td class="text-right text-bold cin amt">' + money(amt) + '</td>' +
                                                '<td class="text-right text-bold cin cap">' + money(remamt) + '</td>' +
                                                '<td class="text-right text-bold cin int">' + money(inst) + '</td>' +
                                                '<td class="text-right text-bold cin fin">' + money(pen) + '</td>' +
                                                '<td class="text-right text-bold cin tot">' + money(total) + '</td>' +
                                                '<td class="text-right text-bold cin gua">' + money(comake) + '</td>' +
                                                '<td class="text-right text-bold cin ris">' + money(risk) + '</td>' +
                                                '<td class="text-center" style="width: 3%">' + days + '</td>' +
                                                '<td class="text-right text-bold cin pro"><input type="hidden" name="amounts[]" value="' + Math.round((risk * 20) / 100) + '">' + money(Math.round((risk * 20) / 100)) + '</td>' +
                                                '</tr>';
                                        }
                                    } else if (age === 6 || age === 9) {
                                        if ((days >= 60 && days <= 89) || (days >= 90 && days <= 119)) {
                                            proBody += '<tr>' +
                                                '<td style="text-align: center; width: 2%"><input type="checkbox" class="check" value="' + row++ + '" name="provs[]"></td>' +
                                                '<td style="width: 6%">' + pad(loan.loanno, 6) + '</td>' +
                                                '<td style="width: 6%">' + pad(loan.memnumb, 6) + '</td>' +
                                                '<td style="width: 15%">' + loan.name + '</td>' +
                                                '<td class="text-right text-bold cin amt">' + money(amt) + '</td>' +
                                                '<td class="text-right text-bold cin cap">' + money(remamt) + '</td>' +
                                                '<td class="text-right text-bold cin int">' + money(inst) + '</td>' +
                                                '<td class="text-right text-bold cin fin">' + money(pen) + '</td>' +
                                                '<td class="text-right text-bold cin tot">' + money(total) + '</td>' +
                                                '<td class="text-right text-bold cin gua">' + money(comake) + '</td>' +
                                                '<td class="text-right text-bold cin ris">' + money(risk) + '</td>' +
                                                '<td class="text-center" style="width: 3%">' + days + '</td>' +
                                                '<td class="text-right text-bold cin pro"><input type="hidden" name="amounts[]" value="' + Math.round((risk * 40) / 100) + '">' + money(Math.round((risk * 40) / 100)) + '</td>' +
                                                '</tr>';
                                        }
                                    } else if (age === 12) {
                                        if (days >= 120 && days <= 179) {
                                            proBody += '<tr>' +
                                                '<td style="text-align: center; width: 2%"><input type="checkbox" class="check" value="' + row++ + '" name="provs[]"></td>' +
                                                '<td style="width: 6%">' + pad(loan.loanno, 6) + '</td>' +
                                                '<td style="width: 6%">' + pad(loan.memnumb, 6) + '</td>' +
                                                '<td style="width: 15%">' + loan.name + '</td>' +
                                                '<td class="text-right text-bold cin amt">' + money(amt) + '</td>' +
                                                '<td class="text-right text-bold cin cap">' + money(remamt) + '</td>' +
                                                '<td class="text-right text-bold cin int">' + money(inst) + '</td>' +
                                                '<td class="text-right text-bold cin fin">' + money(pen) + '</td>' +
                                                '<td class="text-right text-bold cin tot">' + money(total) + '</td>' +
                                                '<td class="text-right text-bold cin gua">' + money(comake) + '</td>' +
                                                '<td class="text-right text-bold cin ris">' + money(risk) + '</td>' +
                                                '<td class="text-center" style="width: 3%">' + days + '</td>' +
                                                '<td class="text-right text-bold cin pro"><input type="hidden" name="amounts[]" value="' + Math.round((risk * 60) / 100) + '">' + money(Math.round((risk * 60) / 100)) + '</td>' +
                                                '</tr>';
                                        }
                                    } else if (age === 18) {
                                        if (days >= 180 && days <= 359) {
                                            proBody += '<tr>' +
                                                '<td style="text-align: center; width: 2%"><input type="checkbox" class="check" value="' + row++ + '" name="provs[]"></td>' +
                                                '<td style="width: 6%">' + pad(loan.loanno, 6) + '</td>' +
                                                '<td style="width: 6%">' + pad(loan.memnumb, 6) + '</td>' +
                                                '<td style="width: 15%">' + loan.name + '</td>' +
                                                '<td class="text-right text-bold cin amt">' + money(amt) + '</td>' +
                                                '<td class="text-right text-bold cin cap">' + money(remamt) + '</td>' +
                                                '<td class="text-right text-bold cin int">' + money(inst) + '</td>' +
                                                '<td class="text-right text-bold cin fin">' + money(pen) + '</td>' +
                                                '<td class="text-right text-bold cin tot">' + money(total) + '</td>' +
                                                '<td class="text-right text-bold cin gua">' + money(comake) + '</td>' +
                                                '<td class="text-right text-bold cin ris">' + money(risk) + '</td>' +
                                                '<td class="text-center" style="width: 3%">' + days + '</td>' +
                                                '<td class="text-right text-bold cin pro"><input type="hidden" name="amounts[]" value="' + Math.round((risk * 80) / 100) + '">' + money(Math.round((risk * 80) / 100)) + '</td>' +
                                                '</tr>';
                                        }
                                    } else if (age === 36) {
                                        if (days >= 360) {
                                            proBody += '<tr>' +
                                                '<td style="text-align: center; width: 2%"><input type="checkbox" class="check" value="' + row++ + '" name="provs[]"></td>' +
                                                '<td style="width: 6%">' + pad(loan.loanno, 6) + '</td>' +
                                                '<td style="width: 6%">' + pad(loan.memnumb, 6) + '</td>' +
                                                '<td style="width: 15%">' + loan.name + '</td>' +
                                                '<td class="text-right text-bold cin amt">' + money(amt) + '</td>' +
                                                '<td class="text-right text-bold cin cap">' + money(remamt) + '</td>' +
                                                '<td class="text-right text-bold cin int">' + money(inst) + '</td>' +
                                                '<td class="text-right text-bold cin fin">' + money(pen) + '</td>' +
                                                '<td class="text-right text-bold cin tot">' + money(total) + '</td>' +
                                                '<td class="text-right text-bold cin gua">' + money(comake) + '</td>' +
                                                '<td class="text-right text-bold cin ris">' + money(risk) + '</td>' +
                                                '<td class="text-center" style="width: 3%">' + days + '</td>' +
                                                '<td class="text-right text-bold cin pro"><input type="hidden" name="amounts[]" value="' + risk + '">' + money(risk) + '</td>' +
                                                '</tr>';
                                        }
                                    } else {
                                        let perc = 0;
                                        if (days >= 30 && days <= 59) {
                                            perc = 20;
                                        } else if ((days >= 60 && days <= 89) || (days >= 90 && days <= 119)) {
                                            perc = 40;
                                        } else if (days >= 120 && days <= 179) {
                                            perc = 60;
                                        } else if (days >= 180 && days <= 359) {
                                            perc = 80;
                                        } else if (days >= 360) {
                                            perc = 100;
                                        }

                                        proBody += '<tr>' +
                                            '<td style="text-align: center; width: 2%"><input type="checkbox" class="check" value="' + row++ + '" name="provs[]"></td>' +
                                            '<td style="width: 6%">' + pad(loan.loanno, 6) + '</td>' +
                                            '<td style="width: 6%">' + pad(loan.memnumb, 6) + '</td>' +
                                            '<td style="width: 15%">' + loan.name + '</td>' +
                                            '<td class="text-right text-bold cin amt">' + money(amt) + '</td>' +
                                            '<td class="text-right text-bold cin cap">' + money(remamt) + '</td>' +
                                            '<td class="text-right text-bold cin int">' + money(inst) + '</td>' +
                                            '<td class="text-right text-bold cin fin">' + money(pen) + '</td>' +
                                            '<td class="text-right text-bold cin tot">' + money(total) + '</td>' +
                                            '<td class="text-right text-bold cin gua">' + money(comake) + '</td>' +
                                            '<td class="text-right text-bold cin ris">' + money(risk) + '</td>' +
                                            '<td class="text-center" style="width: 3%">' + days + '</td>' +
                                            '<td class="text-right text-bold cin pro"><input type="hidden" name="amounts[]" value="' + Math.round((risk * perc) / 100) + '">' + money(Math.round((risk * perc) / 100)) + '</td>' +
                                            '</tr>';
                                    }
                                }

                                if ((loan.guarantee === 'M') || (loan.guarantee === 'F&M')) {
                                    if (days >= 360 && days <= 719) {
                                        proBody += '<tr>' +
                                            '<td style="text-align: center; width: 2%"><input type="checkbox" class="check" value="' + row++ + '" name="provs[]"></td>' +
                                            '<td style="width: 6%">' + pad(loan.loanno, 6) + '</td>' +
                                            '<td style="width: 6%">' + pad(loan.memnumb, 6) + '</td>' +
                                            '<td style="width: 15%">' + loan.name + '</td>' +
                                            '<td class="text-right text-bold cin amt">' + money(amt) + '</td>' +
                                            '<td class="text-right text-bold cin cap">' + money(remamt) + '</td>' +
                                            '<td class="text-right text-bold cin int">' + money(inst) + '</td>' +
                                            '<td class="text-right text-bold cin fin">' + money(pen) + '</td>' +
                                            '<td class="text-right text-bold cin tot">' + money(total) + '</td>' +
                                            '<td class="text-right text-bold cin gua">' + money(comake) + '</td>' +
                                            '<td class="text-right text-bold cin ris">' + money(risk) + '</td>' +
                                            '<td class="text-center" style="width: 3%">' + days + '</td>' +
                                            '<td class="text-right text-bold cin pro"><input type="hidden" name="amounts[]" value="' + Math.round((risk * 40) / 100) + '">' + money(Math.round((risk * 40) / 100)) + '</td>' +
                                            '</tr>';
                                    } else if (days >= 720 && days <= 1079) {
                                        proBody += '<tr>' +
                                            '<td style="text-align: center; width: 2%"><input type="checkbox" class="check" value="' + row++ + '" name="provs[]"></td>' +
                                            '<td style="width: 6%">' + pad(loan.loanno, 6) + '</td>' +
                                            '<td style="width: 6%">' + pad(loan.memnumb, 6) + '</td>' +
                                            '<td style="width: 15%">' + loan.name + '</td>' +
                                            '<td class="text-right text-bold cin amt">' + money(amt) + '</td>' +
                                            '<td class="text-right text-bold cin cap">' + money(remamt) + '</td>' +
                                            '<td class="text-right text-bold cin int">' + money(inst) + '</td>' +
                                            '<td class="text-right text-bold cin fin">' + money(pen) + '</td>' +
                                            '<td class="text-right text-bold cin tot">' + money(total) + '</td>' +
                                            '<td class="text-right text-bold cin gua">' + money(comake) + '</td>' +
                                            '<td class="text-right text-bold cin ris">' + money(risk) + '</td>' +
                                            '<td class="text-center" style="width: 3%">' + days + '</td>' +
                                            '<td class="text-right text-bold cin pro"><input type="hidden" name="amounts[]" value="' + Math.round((risk * 60) / 100) + '">' + money(Math.round((risk * 60) / 100)) + '</td>' +
                                            '</tr>';
                                    } else if (days >= 1080 && days <= 1439) {
                                        proBody += '<tr>' +
                                            '<td style="text-align: center; width: 2%"><input type="checkbox" class="check" value="' + row++ + '" name="provs[]"></td>' +
                                            '<td style="width: 6%">' + pad(loan.loanno, 6) + '</td>' +
                                            '<td style="width: 6%">' + pad(loan.memnumb, 6) + '</td>' +
                                            '<td style="width: 15%">' + loan.name + '</td>' +
                                            '<td class="text-right text-bold cin amt">' + money(amt) + '</td>' +
                                            '<td class="text-right text-bold cin cap">' + money(remamt) + '</td>' +
                                            '<td class="text-right text-bold cin int">' + money(inst) + '</td>' +
                                            '<td class="text-right text-bold cin fin">' + money(pen) + '</td>' +
                                            '<td class="text-right text-bold cin tot">' + money(total) + '</td>' +
                                            '<td class="text-right text-bold cin gua">' + money(comake) + '</td>' +
                                            '<td class="text-right text-bold cin ris">' + money(risk) + '</td>' +
                                            '<td class="text-center" style="width: 3%">' + days + '</td>' +
                                            '<td class="text-right text-bold cin pro"><input type="hidden" name="amounts[]" value="' + Math.round((risk * 80) / 100) + '">' + money(Math.round((risk * 80) / 100)) + '</td>' +
                                            '</tr>';
                                    } else if (days >= 1440) {
                                        proBody += '<tr>' +
                                            '<td style="text-align: center; width: 2%"><input type="checkbox" class="check" value="' + row++ + '" name="provs[]"></td>' +
                                            '<td style="width: 6%">' + pad(loan.loanno, 6) + '</td>' +
                                            '<td style="width: 6%">' + pad(loan.memnumb, 6) + '</td>' +
                                            '<td style="width: 15%">' + loan.name + '</td>' +
                                            '<td class="text-right text-bold cin amt">' + money(amt) + '</td>' +
                                            '<td class="text-right text-bold cin cap">' + money(remamt) + '</td>' +
                                            '<td class="text-right text-bold cin int">' + money(inst) + '</td>' +
                                            '<td class="text-right text-bold cin fin">' + money(pen) + '</td>' +
                                            '<td class="text-right text-bold cin tot">' + money(total) + '</td>' +
                                            '<td class="text-right text-bold cin gua">' + money(comake) + '</td>' +
                                            '<td class="text-right text-bold cin ris">' + money(risk) + '</td>' +
                                            '<td class="text-center" style="width: 3%">' + days + '</td>' +
                                            '<td class="text-right text-bold cin pro"><input type="hidden" name="amounts[]" value="' + risk + '">' + money(risk) + '</td>' +
                                            '</tr>';
                                    }
                                }
                            }
                            $('#provReport').html(proBody);

                            $('.amt').each(function () {
                                totAmt += parseInt(trimOver($(this).text(), null));
                            });
                            $('.cap').each(function () {
                                totCap += parseInt(trimOver($(this).text(), null));
                            });
                            $('.int').each(function () {
                                totInt += parseInt(trimOver($(this).text(), null));
                            });
                            $('.fin').each(function () {
                                totFin += parseInt(trimOver($(this).text(), null));
                            });
                            $('.tot').each(function () {
                                totTot += parseInt(trimOver($(this).text(), null));
                            });
                            $('.gua').each(function () {
                                totGua += parseInt(trimOver($(this).text(), null));
                            });
                            $('.ris').each(function () {
                                totRis += parseInt(trimOver($(this).text(), null));
                            });
                            $('.pro').each(function () {
                                totPro += parseInt(trimOver($(this).text(), null));
                            });

                            $('#totAmt').text(money(totAmt));
                            $('#totCap').text(money(totCap));
                            $('#totInt').text(money(totInt));
                            $('#totFin').text(money(totFin));
                            $('#totTot').text(money(totTot));
                            $('#totGua').text(money(totGua));
                            $('#totRis').text(money(totRis));
                            $('#totPro').val(money(totPro));
                        }

                        populate();
                    });
                }
            });
        }

        $('#check').click(function () {
            if ($(this).is(':checked')) {
                $('.check').each(function () {
                    if($(this).is(':checked')) {
                        $(this).removeAttr('checked');
                        $(this).attr('checked', true);
                    } else {
                        $(this).attr('checked', true);
                    }
                })
            } else {
                $('.check').each(function () {
                    $(this).removeAttr('checked');
                })
            }
        });

        $('#save').click(function () {
            let prov = parseInt(trimOver($('#totPro').val(), null));

            if (!isNaN(prov)) {
                swal({
                        title: '@lang('sidebar.provi')',
                        text: '@lang('confirm.provi_text')',
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
                            $('#proForm').submit();
                        }
                    }
                );
            } else {
                swal({
                        title: '@lang('sidebar.provi')',
                        text: '@lang('confirm.provierror_text')',
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
