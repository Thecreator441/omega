<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.delinq'))

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold"> @lang('sidebar.delinq') </h3>
        </div>
        {{--        <div class="box-header">--}}
        {{--            <div class="box-tools">--}}
        {{--                <button type="button" class="btn btn-alert bg-red btn-sm pull-right fa fa-close" id="home"></button>--}}
        {{--            </div>--}}
        {{--        </div>--}}
        <div class="box-body">
            <form action="{{ url('delinquency_report/store') }}" method="POST" role="form">
                {{ csrf_field() }}
                <div class="box-header">
                    <div class="col-md-3"></div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="radio">
                                <label for="summary">
                                    <input type="radio" name="delinq" id="summary" value="S">
                                    @lang('label.summary')
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="radio">
                                <label for="par3">
                                    <input type="radio" name="delinq" id="par3" value="P3">
                                    @lang('label.par3')
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="radio">
                                <label for="par6">
                                    <input type="radio" name="delinq" id="par6" value="P6">
                                    @lang('label.par6')
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>

                <div class="box-footer with-border" id="sum_report" style="display: none">
                    <div class="col-md-12">
                        <table class="table table-striped table-hover table-condensed table-bordered table-responsive">
                            <thead>
                            <tr>
                                <th rowspan="2">@lang('label.cats')</th>
                                <th colspan="5">@lang('label.noloanout')</th>
                                <th class="bg-gray" style="width: 1px"></th>
                                <th colspan="5">@lang('label.amtloanout')</th>
                            </tr>
                            <tr>
                                <th class="cout">@lang('label.totnumb')</th>
                                <th>M</th>
                                <th>F</th>
                                <th>G</th>
                                <th>%</th>
                                <th class="bg-gray" style="width: 1%"></th>
                                <th class="cout">@lang('label.totamt')</th>
                                <th>M</th>
                                <th>F</th>
                                <th>G</th>
                                <th>%</th>
                            </tr>
                            </thead>
                            <tbody id="sumReport"></tbody>
                            <tfoot id="sumReportFooter" class="bg-antiquewhite text-bold"></tfoot>
                        </table>
                    </div>
                </div>

                <div class="box-footer with-border" id="par3_report" style="display: none">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <table class="table table-striped table-hover table-condensed table-bordered table-responsive">
                                    <caption class="text-center text-bold h4"><b>@lang('label.gender')</b></caption>
                                    <thead>
                                    <tr>
                                        <th>@lang('label.gender')</th>
                                        <th>@lang('label.amount')</th>
                                        <th style="width: 25%">@lang('label.delamt')</th>
                                        <th>@lang('label.totnumb')</th>
                                        <th>%</th>
                                    </tr>
                                    </thead>
                                    <tbody id="par30GenReport"></tbody>
                                    <tfoot id="par30GenReportFooter" class="bg-antiquewhite text-bold"></tfoot>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-striped table-hover table-condensed table-bordered table-responsive">
                                    <caption class="text-center text-bold h4"><b>@lang('label.loanty')</b></caption>
                                    <thead>
                                    <tr>
                                        <th>@lang('label.loanty')</th>
                                        <th>@lang('label.amount')</th>
                                        <th>M</th>
                                        <th>F</th>
                                        <th>G</th>
                                        <th>%</th>
                                    </tr>
                                    </thead>
                                    <tbody id="par30LTypeReport">
                                    @foreach ($loanTypes as $loanType)
                                        <tr>
                                            <td class="text-bold text-center">@if ($emp->lang == 'fr') {{$loanType->labelfr}} @else {{$loanType->labeleng}} @endif</td>
                                            <td class="text-bold text-right amt3" id="amt{{$loanType->idltype}}p3"></td>
                                            <td class="text-bold text-right mal3" id="mal{{$loanType->idltype}}p3"></td>
                                            <td class="text-bold text-right fem3" id="fem{{$loanType->idltype}}p3"></td>
                                            <td class="text-bold text-right grp3" id="grp{{$loanType->idltype}}p3"></td>
                                            <td class="text-center per3" id="per{{$loanType->idltype}}p3"></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot id="par30LTypeReportFooter" class="bg-antiquewhite text-bold"></tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 text-center h4 text-bold">
                        @lang('label.p30rate') : <span id="par30Rate"></span>
                    </div>
                </div>

                <div class="box-footer with-border" id="par6_report" style="display: none">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <table class="table table-striped table-hover table-condensed table-bordered table-responsive">
                                    <caption class="text-center text-bold h4"><b>@lang('label.gender')</b></caption>
                                    <thead>
                                    <tr>
                                        <th>@lang('label.gender')</th>
                                        <th>@lang('label.amount')</th>
                                        <th style="width: 25%">@lang('label.delamt')</th>
                                        <th>@lang('label.totnumb')</th>
                                        <th>%</th>
                                    </tr>
                                    </thead>
                                    <tbody id="par60GenReport"></tbody>
                                    <tfoot id="par60GenReportFooter" class="bg-antiquewhite text-bold"></tfoot>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-striped table-hover table-condensed table-bordered table-responsive">
                                    <caption class="text-center text-bold h4"><b>@lang('label.loanty')</b></caption>
                                    <thead>
                                    <tr>
                                        <th>@lang('label.loanty')</th>
                                        <th>@lang('label.amount')</th>
                                        <th>M</th>
                                        <th>F</th>
                                        <th>G</th>
                                        <th>%</th>
                                    </tr>
                                    </thead>
                                    <tbody id="par60LTypeReport">
                                    @foreach ($loanTypes as $loanType)
                                        <tr>
                                            <td class="text-bold text-center">@if ($emp->lang == 'fr') {{$loanType->labelfr}} @else {{$loanType->labeleng}} @endif</td>
                                            <td class="text-bold text-right amt6" id="amt{{$loanType->idltype}}p6"></td>
                                            <td class="text-bold text-right mal6" id="mal{{$loanType->idltype}}p6"></td>
                                            <td class="text-bold text-right fem6" id="fem{{$loanType->idltype}}p6"></td>
                                            <td class="text-bold text-right grp6" id="grp{{$loanType->idltype}}p6"></td>
                                            <td class="text-center per6" id="per{{$loanType->idltype}}p6"></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot id="par60LTypeReportFooter" class="bg-antiquewhite text-bold">

                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 text-center h4 text-bold">
                        @lang('label.p60rate') : <span id="par60Rate"></span>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="col-md-12">
                        <button type="button" id="print" class="btn btn-sm pull-right btn-raised fa fa-print"></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
        $('input[type="radio"]').click(function () {
            $(this).each(function () {
                if ($(this).is(':checked')) {
                    if ($(this).val() === 'S') {
                        $('#sum_report').show();
                        $('#par3_report').hide();
                        $('#par6_report').hide();
                        summary();
                    } else if ($(this).val() === 'P3') {
                        $('#sum_report').hide();
                        $('#par3_report').show();
                        $('#par6_report').hide();
                        par30();
                    } else if ($(this).val() === 'P6') {
                        $('#sum_report').hide();
                        $('#par3_report').hide();
                        $('#par6_report').show();
                        par60();
                    }
                }
            });
        });

        function summary() {
            $.ajax({
                url: "{{ url('getLoansMember') }}",
                method: 'get',
                success: function (loans) {
                    let mal0 = 0;
                    let fem0 = 0;
                    let grp0 = 0;
                    let malamt0 = 0;
                    let femamt0 = 0;
                    let grpamt0 = 0;

                    let mal1 = 0;
                    let fem1 = 0;
                    let grp1 = 0;
                    let malamt1 = 0;
                    let femamt1 = 0;
                    let grpamt1 = 0;

                    let mal2 = 0;
                    let fem2 = 0;
                    let grp2 = 0;
                    let malamt2 = 0;
                    let femamt2 = 0;
                    let grpamt2 = 0;

                    let mal3 = 0;
                    let fem3 = 0;
                    let grp3 = 0;
                    let malamt3 = 0;
                    let femamt3 = 0;
                    let grpamt3 = 0;

                    let mal4 = 0;
                    let fem4 = 0;
                    let grp4 = 0;
                    let malamt4 = 0;
                    let femamt4 = 0;
                    let grpamt4 = 0;

                    let mal5 = 0;
                    let fem5 = 0;
                    let grp5 = 0;
                    let malamt5 = 0;
                    let femamt5 = 0;
                    let grpamt5 = 0;

                    let mal6 = 0;
                    let fem6 = 0;
                    let grp6 = 0;
                    let malamt6 = 0;
                    let femamt6 = 0;
                    let grpamt6 = 0;

                    $.each(loans, function (i, loan) {
                        let amt = parseInt(loan.amount);
                        if (parseInt(loan.isRef) > 1) {
                            amt = parseInt(loan.refamt);
                        }
                        let paidamt = parseInt(loan.paidamt);
                        let remamt = amt - paidamt;

                        async function summaries() {
                            let installs = await $.get('getInstalls?loan=' + loan.idloan);
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

                            if (days <= 0) {
                                if (loan.gender === 'M') {
                                    ++mal0;
                                    malamt0 += remamt;
                                } else if (loan.gender === 'F') {
                                    ++fem0;
                                    femamt0 += remamt;
                                } else {
                                    ++grp0;
                                    grpamt0 += remamt;
                                }
                            } else if (days >= 1 && days <= 29) {
                                if (loan.gender === 'M') {
                                    ++mal1;
                                    malamt1 += remamt;
                                } else if (loan.gender === 'F') {
                                    ++fem1;
                                    femamt1 += remamt;
                                } else {
                                    ++grp1;
                                    grpamt1 += remamt;
                                }
                            } else if (days >= 30 && days <= 59) {
                                if (loan.gender === 'M') {
                                    ++mal2;
                                    malamt2 += remamt;
                                } else if (loan.gender === 'F') {
                                    ++fem2;
                                    femamt2 += remamt;
                                } else {
                                    ++grp2;
                                    grpamt2 += remamt;
                                }
                            } else if (days >= 60 && days <= 89) {
                                if (loan.gender === 'M') {
                                    ++mal3;
                                    malamt3 += remamt;
                                } else if (loan.gender === 'F') {
                                    ++fem3;
                                    femamt3 += remamt;
                                } else {
                                    ++grp3;
                                    grpamt3 += remamt;
                                }
                            } else if (days >= 90 && days <= 179) {
                                if (loan.gender === 'M') {
                                    ++mal4;
                                    malamt4 += remamt;
                                } else if (loan.gender === 'F') {
                                    ++fem4;
                                    femamt4 += remamt;
                                } else {
                                    ++grp4;
                                    grpamt4 += remamt;
                                }
                            } else if (days >= 180 && days <= 359) {
                                if (loan.gender === 'M') {
                                    ++mal5;
                                    malamt5 += remamt;
                                } else if (loan.gender === 'F') {
                                    ++fem5;
                                    femamt5 += remamt;
                                } else {
                                    ++grp5;
                                    grpamt5 += remamt;
                                }
                            } else if (days >= 360) {
                                if (loan.gender === 'M') {
                                    ++mal6;
                                    malamt6 += remamt;
                                }
                                if (loan.gender === 'F') {
                                    ++fem6;
                                    femamt6 += remamt;
                                } else {
                                    ++grp6;
                                    grpamt6 += remamt;
                                }
                            }

                            let tot = (mal0 + mal1 + mal2 + mal3 + mal4 + mal5 + mal6) +
                                (fem0 + fem1 + fem2 + fem3 + fem4 + fem5 + fem6) +
                                (grp0 + grp1 + grp2 + grp3 + grp4 + grp5 + grp6);
                            let totamt = (malamt0 + malamt1 + malamt2 + malamt3 + malamt4 + malamt5 + malamt6) +
                                (femamt0 + femamt1 + femamt2 + femamt3 + femamt4 + femamt5 + femamt6) +
                                (grpamt0 + grpamt1 + grpamt2 + grpamt3 + grpamt4 + grpamt5 + grpamt6);

                            let per0 = parseFloat(((mal0 + fem0 + grp0) / tot) * 100).toFixed(2);
                            let per1 = parseFloat(((mal1 + fem1 + grp1) / tot) * 100).toFixed(2);
                            let per2 = parseFloat(((mal2 + fem2 + grp2) / tot) * 100).toFixed(2);
                            let per3 = parseFloat(((mal3 + fem3 + grp3) / tot) * 100).toFixed(2);
                            let per4 = parseFloat(((mal4 + fem4 + grp4) / tot) * 100).toFixed(2);
                            let per5 = parseFloat(((mal5 + fem5 + grp5) / tot) * 100).toFixed(2);
                            let per6 = parseFloat(((mal6 + fem6 + grp6) / tot) * 100).toFixed(2);
                            if (isNaN(per0) || isNaN(per1) || isNaN(per3) || isNaN(per4) || isNaN(per5) || isNaN(per6)) {
                                per0 = parseFloat(0).toFixed(2);
                                per1 = parseFloat(0).toFixed(2);
                                per2 = parseFloat(0).toFixed(2);
                                per3 = parseFloat(0).toFixed(2);
                                per4 = parseFloat(0).toFixed(2);
                                per5 = parseFloat(0).toFixed(2);
                                per6 = parseFloat(0).toFixed(2);
                            }

                            let peramt0 = parseFloat(((malamt0 + femamt0 + grpamt0) / totamt) * 100).toFixed(2);
                            let peramt1 = parseFloat(((malamt1 + femamt1 + grpamt1) / totamt) * 100).toFixed(2);
                            let peramt2 = parseFloat(((malamt2 + femamt2 + grpamt2) / totamt) * 100).toFixed(2);
                            let peramt3 = parseFloat(((malamt3 + femamt3 + grpamt3) / totamt) * 100).toFixed(2);
                            let peramt4 = parseFloat(((malamt4 + femamt4 + grpamt4) / totamt) * 100).toFixed(2);
                            let peramt5 = parseFloat(((malamt5 + femamt5 + grpamt5) / totamt) * 100).toFixed(2);
                            let peramt6 = parseFloat(((malamt6 + femamt6 + grpamt6) / totamt) * 100).toFixed(2);
                            if (isNaN(peramt0) || isNaN(peramt1) || isNaN(peramt3) || isNaN(peramt4) || isNaN(peramt5) || isNaN(peramt6)) {
                                peramt0 = parseFloat(0).toFixed(2);
                                peramt1 = parseFloat(0).toFixed(2);
                                peramt2 = parseFloat(0).toFixed(2);
                                peramt3 = parseFloat(0).toFixed(2);
                                peramt4 = parseFloat(0).toFixed(2);
                                peramt5 = parseFloat(0).toFixed(2);
                                peramt6 = parseFloat(0).toFixed(2);
                            }

                            let totper = parseInt(Math.ceil(
                                parseFloat((((mal0 + fem0 + grp0) / tot) * 100)) +
                                parseFloat((((mal1 + fem1 + grp1) / tot) * 100)) +
                                parseFloat((((mal2 + fem2 + grp2) / tot) * 100)) +
                                parseFloat((((mal3 + fem3 + grp3) / tot) * 100)) +
                                parseFloat((((mal4 + fem4 + grp4) / tot) * 100)) +
                                parseFloat((((mal5 + fem5 + grp5) / tot) * 100)) +
                                parseFloat((((mal6 + fem6 + grp6) / tot) * 100))
                            ));
                            if (isNaN(totper)) {
                                totper = parseFloat(0).toFixed(2);
                            }

                            let totperamt = parseInt(Math.ceil(
                                parseFloat((((malamt0 + femamt0 + grpamt0) / totamt) * 100)) +
                                parseFloat((((malamt1 + femamt1 + grpamt1) / totamt) * 100)) +
                                parseFloat((((malamt2 + femamt2 + grpamt2) / totamt) * 100)) +
                                parseFloat((((malamt3 + femamt3 + grpamt3) / totamt) * 100)) +
                                parseFloat((((malamt4 + femamt4 + grpamt4) / totamt) * 100)) +
                                parseFloat((((malamt5 + femamt5 + grpamt5) / totamt) * 100)) +
                                parseFloat((((malamt6 + femamt6 + grpamt6) / totamt) * 100))
                            ));
                            if (isNaN(totperamt)) {
                                totper = parseFloat(0).toFixed(2);
                            }

                            let totmal = mal0 + mal1 + mal2 + mal3 + mal4 + mal5 + mal6;
                            let totfem = fem0 + fem1 + fem2 + fem3 + fem4 + fem5 + fem6;
                            let totgrp = grp0 + grp1 + grp2 + grp3 + grp4 + grp5 + grp6;
                            let totmalamt = malamt0 + malamt1 + malamt2 + malamt3 + malamt4 + malamt5 + malamt6;
                            let totfemamt = femamt0 + femamt1 + femamt2 + femamt3 + femamt4 + femamt5 + femamt6;
                            let totgrpamt = grpamt0 + grpamt1 + grpamt2 + grpamt3 + grpamt4 + grpamt5 + grpamt6;

                            let tr0 = '<tr>' +
                                '<td class="text-center text-bold">@lang('label.current')</td>' +
                                '<td class="text-center">' + (mal0 + fem0 + grp0) + '</td>' +
                                '<td class="text-center">' + mal0 + '</td>' +
                                '<td class="text-center">' + fem0 + '</td>' +
                                '<td class="text-center">' + grp0 + '</td>' +
                                '<td class="text-center">' + per0 + '</td>' +
                                '<td class="bg-gray"></td>' +
                                '<td class="text-right text-bold">' + money(malamt0 + femamt0 + grpamt0) + '</td>' +
                                '<td class="text-right text-bold">' + money(malamt0) + '</td>' +
                                '<td class="text-right text-bold">' + money(femamt0) + '</td>' +
                                '<td class="text-right text-bold">' + money(grpamt0) + '</td>' +
                                '<td class="text-center">' + peramt0 + '</td>' +
                                '</tr>';

                            let tr1 = '<tr>' +
                                '<td class="text-center text-bold">1 - 29</td>' +
                                '<td class="text-center">' + (mal1 + fem1 + grp1) + '</td>' +
                                '<td class="text-center">' + mal1 + '</td>' +
                                '<td class="text-center">' + fem1 + '</td>' +
                                '<td class="text-center">' + grp1 + '</td>' +
                                '<td class="text-center">' + per1 + '</td>' +
                                '<td class="bg-gray"></td>' +
                                '<td class="text-right text-bold">' + money(malamt1 + femamt1 + grpamt1) + '</td>' +
                                '<td class="text-right text-bold">' + money(malamt1) + '</td>' +
                                '<td class="text-right text-bold">' + money(femamt1) + '</td>' +
                                '<td class="text-right text-bold">' + money(grpamt1) + '</td>' +
                                '<td class="text-center">' + peramt1 + '</td>' +
                                '</tr>';

                            let tr2 = '<tr>' +
                                '<td class="text-center text-bold">30 - 59</td>' +
                                '<td class="text-center">' + (mal2 + fem2 + grp2) + '</td>' +
                                '<td class="text-center">' + mal2 + '</td>' +
                                '<td class="text-center">' + fem2 + '</td>' +
                                '<td class="text-center">' + grp2 + '</td>' +
                                '<td class="text-center">' + per2 + '</td>' +
                                '<td class="bg-gray"></td>' +
                                '<td class="text-right text-bold">' + money(malamt2 + femamt2 + grpamt2) + '</td>' +
                                '<td class="text-right text-bold">' + money(malamt2) + '</td>' +
                                '<td class="text-right text-bold">' + money(femamt2) + '</td>' +
                                '<td class="text-right text-bold">' + money(grpamt2) + '</td>' +
                                '<td class="text-center">' + peramt2 + '</td>' +
                                '</tr>';

                            let tr3 = '<tr>' +
                                '<td class="text-center text-bold">60 - 89</td>' +
                                '<td class="text-center">' + (mal3 + fem3 + grp3) + '</td>' +
                                '<td class="text-center">' + mal3 + '</td>' +
                                '<td class="text-center">' + fem3 + '</td>' +
                                '<td class="text-center">' + grp3 + '</td>' +
                                '<td class="text-center">' + per3 + '</td>' +
                                '<td class="bg-gray"></td>' +
                                '<td class="text-right text-bold">' + money(malamt3 + femamt3 + grpamt3) + '</td>' +
                                '<td class="text-right text-bold">' + money(malamt3) + '</td>' +
                                '<td class="text-right text-bold">' + money(femamt3) + '</td>' +
                                '<td class="text-right text-bold">' + money(grpamt3) + '</td>' +
                                '<td class="text-center">' + peramt3 + '</td>' +
                                '</tr>';

                            let tr4 = '<tr>' +
                                '<td class="text-center text-bold">90 - 179</td>' +
                                '<td class="text-center">' + (mal4 + fem4 + grp4) + '</td>' +
                                '<td class="text-center">' + mal4 + '</td>' +
                                '<td class="text-center">' + fem4 + '</td>' +
                                '<td class="text-center">' + grp4 + '</td>' +
                                '<td class="text-center">' + per4 + '</td>' +
                                '<td class="bg-gray"></td>' +
                                '<td class="text-right text-bold">' + money(malamt4 + femamt4 + grpamt4) + '</td>' +
                                '<td class="text-right text-bold">' + money(malamt4) + '</td>' +
                                '<td class="text-right text-bold">' + money(femamt4) + '</td>' +
                                '<td class="text-right text-bold">' + money(grpamt4) + '</td>' +
                                '<td class="text-center">' + peramt4 + '</td>' +
                                '</tr>';

                            let tr5 = '<tr>' +
                                '<td class="text-center text-bold">180 - 359</td>' +
                                '<td class="text-center">' + (mal5 + fem5 + grp5) + '</td>' +
                                '<td class="text-center">' + mal5 + '</td>' +
                                '<td class="text-center">' + fem5 + '</td>' +
                                '<td class="text-center">' + grp5 + '</td>' +
                                '<td class="text-center">' + per5 + '</td>' +
                                '<td class="bg-gray"></td>' +
                                '<td class="text-right text-bold">' + money(malamt5 + femamt5 + grpamt5) + '</td>' +
                                '<td class="text-right text-bold">' + money(malamt5) + '</td>' +
                                '<td class="text-right text-bold">' + money(femamt5) + '</td>' +
                                '<td class="text-right text-bold">' + money(grpamt5) + '</td>' +
                                '<td class="text-center">' + peramt5 + '</td>' +
                                '</tr>';

                            let tr6 = '<tr>' +
                                '<td class="text-center text-bold">> 360</td>' +
                                '<td class="text-center">' + (mal6 + fem6 + grp6) + '</td>' +
                                '<td class="text-center">' + mal6 + '</td>' +
                                '<td class="text-center">' + fem6 + '</td>' +
                                '<td class="text-center">' + grp6 + '</td>' +
                                '<td class="text-center">' + per6 + '</td>' +
                                '<td class="bg-gray"></td>' +
                                '<td class="text-right text-bold">' + money(malamt6 + femamt6 + grpamt6) + '</td>' +
                                '<td class="text-right text-bold">' + money(malamt6) + '</td>' +
                                '<td class="text-right text-bold">' + money(femamt6) + '</td>' +
                                '<td class="text-right text-bold">' + money(grpamt6) + '</td>' +
                                '<td class="text-center">' + peramt6 + '</td>' +
                                '</tr>';


                            let tbody = tr0 + '' + tr1 + '' + tr2 + '' + tr3 + '' + tr4 + '' + tr5 + '' + tr6;
                            let tfoot = '<tr>' +
                                '<td class="text-center text-bold">@lang('label.total')</td>' +
                                '<td class="text-center">' + tot + '</td>' +
                                '<td class="text-center">' + totmal + '</td>' +
                                '<td class="text-center">' + totfem + '</td>' +
                                '<td class="text-center">' + totgrp + '</td>' +
                                '<td class="text-center">' + totper + '</td>' +
                                '<td class="bg-gray"></td>' +
                                '<td class="text-right text-bold">' + money(totamt) + '</td>' +
                                '<td class="text-right text-bold">' + money(totmalamt) + '</td>' +
                                '<td class="text-right text-bold">' + money(totfemamt) + '</td>' +
                                '<td class="text-right text-bold">' + money(totgrpamt) + '</td>' +
                                '<td class="text-center">' + totperamt + '</td>' +
                                '</tr>';
                            $('#sumReport').html(tbody);
                            $('#sumReportFooter').html(tfoot);
                        }

                        summaries();
                    });
                }
            });
        }

        function par30() {
            $.ajax({
                url: "{{ url('getLoansMember') }}",
                method: 'get',
                success: function (loans) {
                    let malamt = 0;
                    let maldelamt = 0;
                    let malnbr = 0;

                    let femamt = 0;
                    let femdelamt = 0;
                    let femnbr = 0;

                    let grpamt = 0;
                    let grpdelamt = 0;
                    let grpnbr = 0;

                    let totcp = 0;

                    $.each(loans, function (i, loan) {
                        let days = 0;
                        let totPaid = 0;
                        let diff = 0;

                        let typamt = 0;
                        let typmal = 0;
                        let typfem = 0;
                        let typgrp = 0;

                        let amt = parseInt(loan.amount);
                        if (parseInt(loan.isRef) > 1) {
                            amt = parseInt(loan.refamt);
                        }
                        const paidamt = parseInt(loan.paidamt);
                        const remamt = amt - paidamt;
                        const ltype = parseInt(loan.loantype);

                        async function pars30() {
                            const installs = await $.get('getInstalls?loan=' + loan.idloan);

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

                            if (diff < 0) {
                                totcp += remamt;

                                if (days >= 30 && days <= 359) {
                                    typamt += remamt;
                                    if (loan.gender === 'M') {
                                        malamt += remamt;
                                        maldelamt += Math.abs(diff);
                                        ++malnbr;
                                        typmal += remamt;
                                    } else if (loan.gender === 'F') {
                                        femamt += remamt;
                                        femdelamt += Math.abs(diff);
                                        ++femnbr;
                                        typfem += remamt;
                                    } else if (loan.gender === 'G') {
                                        grpamt += remamt;
                                        grpdelamt += Math.abs(diff);
                                        ++grpnbr;
                                        typgrp += remamt;
                                    }
                                }
                            } else {
                                totcp += remamt;
                            }

                            let totamt = (malamt + femamt + grpamt);
                            let totnbr = (malnbr + femnbr + grpnbr);
                            let totdelamt = (maldelamt + femdelamt + grpdelamt);

                            let permal = parseFloat(((maldelamt) / totdelamt) * 100).toFixed(2);
                            let perfem = parseFloat(((femdelamt) / totdelamt) * 100).toFixed(2);
                            let pergrp = parseFloat(((grpdelamt) / totdelamt) * 100).toFixed(2);

                            let totper = parseInt(Math.ceil(
                                parseFloat(((malnbr) / totnbr) * 100) +
                                parseFloat(((femnbr) / totnbr) * 100) +
                                parseFloat(((grpnbr) / totnbr) * 100)
                            ).toFixed(2));

                            if (isNaN(permal) || isNaN(perfem) || isNaN(pergrp) || isNaN(totper)) {
                                permal = parseFloat(0).toFixed(2);
                                perfem = parseFloat(0).toFixed(2);
                                pergrp = parseFloat(0).toFixed(2);
                                totper = parseFloat(0).toFixed(2);
                            }

                            let trmal = '<tr>' +
                                '<td class="text-center text-bold">@lang('label.male')</td>' +
                                '<td class="text-right text-bold">' + money(malamt) + '</td>' +
                                '<td class="text-right text-bold">' + money(maldelamt) + '</td>' +
                                '<td class="text-right text-bold">' + money(malnbr) + '</td>' +
                                '<td class="text-center">' + permal + '</td>' +
                                '</tr>';

                            let trfem = '<tr>' +
                                '<td class="text-center text-bold">@lang('label.female')</td>' +
                                '<td class="text-right text-bold">' + money(femamt) + '</td>' +
                                '<td class="text-right text-bold">' + money(femdelamt) + '</td>' +
                                '<td class="text-right text-bold">' + money(femnbr) + '</td>' +
                                '<td class="text-center">' + perfem + '</td>' +
                                '</tr>';

                            let trgrp = '<tr>' +
                                '<td class="text-center text-bold">@lang('label.group')</td>' +
                                '<td class="text-right text-bold">' + money(grpamt) + '</td>' +
                                '<td class="text-right text-bold">' + money(grpdelamt) + '</td>' +
                                '<td class="text-right text-bold">' + money(grpnbr) + '</td>' +
                                '<td class="text-center">' + pergrp + '</td>' +
                                '</tr>';

                            let tbody = trmal + '' + trfem + '' + trgrp;
                            let tfoot = '<tr>' +
                                '<td class="text-center text-bold">@lang('label.total')</td>' +
                                '<td class="text-right text-bold">' + money(totamt) + '</td>' +
                                '<td class="text-right text-bold">' + money(totdelamt) + '</td>' +
                                '<td class="text-right text-bold">' + totnbr + '</td>' +
                                '<td class="text-center">' + totper + '</td>' +
                                '</tr>';
                            $('#par30GenReport').html(tbody);
                            $('#par30GenReportFooter').html(tfoot);

                            const rate = parseFloat((totamt / totcp) * 100).toFixed(2);
                            $('#par30Rate').text(rate + '%');

                            let typamtrow = 0;
                            let typmalrow = 0;
                            let typfemrow = 0;
                            let typgrprow = 0;

                            if (!isNaN($('#amt' + loan.loantype + 'p3').text()) || !isNaN($('#mal' + loan.loantype + 'p3').text()) || !isNaN($('#fem' + loan.loantype + 'p3').text()) || !isNaN($('#grp' + loan.loantype + 'p3').text())) {
                                typamtrow += parseInt(trimOver($('#amt' + loan.loantype + 'p3').text(), null));
                                typmalrow += parseInt(trimOver($('#mal' + loan.loantype + 'p3').text(), null));
                                typfemrow += parseInt(trimOver($('#fem' + loan.loantype + 'p3').text(), null));
                                typgrprow += parseInt(trimOver($('#grp' + loan.loantype + 'p3').text(), null));
                            }

                            let typamtot = typamtrow + typamt;
                            let typmalot = typmalrow + typmal;
                            let typfemot = typfemrow + typfem;
                            let typgrpot = typgrprow + typgrp;

                            let per = parseFloat(((typamtot) / totamt) * 100).toFixed(2);
                            if (isNaN(per)) {
                                per = parseFloat(0).toFixed(2);
                            }

                            $('#amt' + ltype + 'p3').text(money(typamtot));
                            $('#mal' + ltype + 'p3').text(money(typmalot));
                            $('#fem' + ltype + 'p3').text(money(typfemot));
                            $('#grp' + ltype + 'p3').text(money(typgrpot));
                            $('#per' + loan.loantype + 'p3').text(per);

                            let tlfoot = '<tr>' +
                                '<td class="text-center text-bold">@lang('label.total')</td>' +
                                '<td class="text-right text-bold">' + money(totamt) + '</td>' +
                                '<td class="text-right text-bold">' + money(malamt) + '</td>' +
                                '<td class="text-right text-bold">' + money(femamt) + '</td>' +
                                '<td class="text-right text-bold">' + money(grpamt) + '</td>';

                            let per3p = 0;
                            $('.per3').each(function () {
                                per3p += parseInt(trimOver($(this).text(), null));
                            });
                            if (isNaN(per3p)) {
                                per3p = 0;
                            }

                            tlfoot += '<td class="text-center">' + parseInt(Math.ceil(per3p)) + '</td>' +
                                '</tr>';
                            $('#par30LTypeReportFooter').html(tlfoot);
                        }

                        pars30();
                    });
                }
            });
        }

        function par60() {
            $.ajax({
                url: "{{ url('getLoansMember') }}",
                method: 'get',
                success: function (loans) {
                    let malamt = 0;
                    let maldelamt = 0;
                    let malnbr = 0;

                    let femamt = 0;
                    let femdelamt = 0;
                    let femnbr = 0;

                    let grpamt = 0;
                    let grpdelamt = 0;
                    let grpnbr = 0;

                    let totcp = 0;

                    $.each(loans, function (i, loan) {
                        let days = 0;
                        let totPaid = 0;
                        let diff = 0;

                        let typamt = 0;
                        let typmal = 0;
                        let typfem = 0;
                        let typgrp = 0;

                        let amt = parseInt(loan.amount);
                        if (parseInt(loan.isRef) > 1) {
                            amt = parseInt(loan.refamt);
                        }
                        const paidamt = parseInt(loan.paidamt);
                        const remamt = amt - paidamt;
                        const ltype = parseInt(loan.loantype);

                        async function pars60() {
                            const installs = await getData('getInstalls?loan=' + loan.idloan);

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

                            if (diff < 0) {
                                totcp += remamt;

                                if (days >= 60 && days <= 359) {
                                    typamt += remamt;
                                    if (loan.gender === 'M') {
                                        malamt += remamt;
                                        maldelamt += Math.abs(diff);
                                        ++malnbr;
                                        typmal += remamt;
                                    } else if (loan.gender === 'F') {
                                        femamt += remamt;
                                        femdelamt += Math.abs(diff);
                                        ++femnbr;
                                        typfem += remamt;
                                    } else if (loan.gender === 'G') {
                                        grpamt += remamt;
                                        grpdelamt += Math.abs(diff);
                                        ++grpnbr;
                                        typgrp += remamt;
                                    }
                                }
                            } else {
                                totcp += remamt;
                            }

                            let totamt = (malamt + femamt + grpamt);
                            let totnbr = (malnbr + femnbr + grpnbr);
                            let totdelamt = (maldelamt + femdelamt + grpdelamt);

                            let permal = parseFloat(((maldelamt) / totdelamt) * 100).toFixed(2);
                            let perfem = parseFloat(((femdelamt) / totdelamt) * 100).toFixed(2);
                            let pergrp = parseFloat(((grpdelamt) / totdelamt) * 100).toFixed(2);

                            let totper = parseInt(Math.ceil(
                                parseFloat(((malnbr) / totnbr) * 100) +
                                parseFloat(((femnbr) / totnbr) * 100) +
                                parseFloat(((grpnbr) / totnbr) * 100)
                            ).toFixed(2));

                            if (isNaN(permal) || isNaN(perfem) || isNaN(pergrp) || isNaN(totper)) {
                                permal = parseFloat(0).toFixed(2);
                                perfem = parseFloat(0).toFixed(2);
                                pergrp = parseFloat(0).toFixed(2);
                                totper = parseFloat(0).toFixed(2);
                            }

                            let trmal = '<tr>' +
                                '<td class="text-center text-bold">@lang('label.male')</td>' +
                                '<td class="text-right text-bold">' + money(malamt) + '</td>' +
                                '<td class="text-right text-bold">' + money(maldelamt) + '</td>' +
                                '<td class="text-right text-bold">' + money(malnbr) + '</td>' +
                                '<td class="text-center">' + permal + '</td>' +
                                '</tr>';

                            let trfem = '<tr>' +
                                '<td class="text-center text-bold">@lang('label.female')</td>' +
                                '<td class="text-right text-bold">' + money(femamt) + '</td>' +
                                '<td class="text-right text-bold">' + money(femdelamt) + '</td>' +
                                '<td class="text-right text-bold">' + money(femnbr) + '</td>' +
                                '<td class="text-center">' + perfem + '</td>' +
                                '</tr>';

                            let trgrp = '<tr>' +
                                '<td class="text-center text-bold">@lang('label.group')</td>' +
                                '<td class="text-right text-bold">' + money(grpamt) + '</td>' +
                                '<td class="text-right text-bold">' + money(grpdelamt) + '</td>' +
                                '<td class="text-right text-bold">' + money(grpnbr) + '</td>' +
                                '<td class="text-center">' + pergrp + '</td>' +
                                '</tr>';

                            let tbody = trmal + '' + trfem + '' + trgrp;
                            let tfoot = '<tr>' +
                                '<td class="text-center text-bold">@lang('label.total')</td>' +
                                '<td class="text-right text-bold">' + money(totamt) + '</td>' +
                                '<td class="text-right text-bold">' + money(totdelamt) + '</td>' +
                                '<td class="text-right text-bold">' + totnbr + '</td>' +
                                '<td class="text-center">' + totper + '</td>' +
                                '</tr>';
                            $('#par60GenReport').html(tbody);
                            $('#par60GenReportFooter').html(tfoot);

                            const rate = parseFloat((totamt / totcp) * 100).toFixed(2);
                            $('#par60Rate').text(rate + '%');

                            let typamtrow = 0;
                            let typmalrow = 0;
                            let typfemrow = 0;
                            let typgrprow = 0;

                            if (!isNaN($('#amt' + ltype + 'p6').text()) || !isNaN($('#mal' + ltype + 'p6').text()) ||
                                !isNaN($('#fem' + ltype + 'p6').text()) || !isNaN($('#grp' + ltype + 'p6').text())) {
                                typamtrow = parseInt(trimOver($('#amt' + ltype + 'p6').text(), null));
                                typmalrow = parseInt(trimOver($('#mal' + ltype + 'p6').text(), null));
                                typfemrow = parseInt(trimOver($('#fem' + ltype + 'p6').text(), null));
                                typgrprow = parseInt(trimOver($('#grp' + ltype + 'p6').text(), null));
                            }

                            let typamtot = typamtrow + typamt;
                            let typmalot = typmalrow + typmal;
                            let typfemot = typfemrow + typfem;
                            let typgrpot = typgrprow + typgrp;

                            let typper = parseFloat((typamtot / totamt) * 100).toFixed(2);
                            if (isNaN(typper)) {
                                typper = parseFloat(0).toFixed(2);
                            }

                            $('#amt' + ltype + 'p6').text(money(typamtot));
                            $('#mal' + ltype + 'p6').text(money(typmalot));
                            $('#fem' + ltype + 'p6').text(money(typfemot));
                            $('#grp' + ltype + 'p6').text(money(typgrpot));
                            $('#per' + ltype + 'p6').text(typper);

                            let tlfoot = '<tr>' +
                                '<td class="text-center text-bold">@lang('label.total')</td>' +
                                '<td class="text-right text-bold">' + money(totamt) + '</td>' +
                                '<td class="text-right text-bold">' + money(malamt) + '</td>' +
                                '<td class="text-right text-bold">' + money(femamt) + '</td>' +
                                '<td class="text-right text-bold">' + money(grpamt) + '</td>';

                            let per6p = 0;
                            $('.per6').each(function () {
                                per6p += parseInt(trimOver($(this).text(), null));
                            });
                            if (isNaN(per6p)) {
                                per6p = 0;
                            }

                            tlfoot += '<td class="text-center">' + parseInt(Math.ceil(per6p)) + '</td>' +
                                '</tr>';
                            $('#par60LTypeReportFooter').html(tlfoot);
                        }

                        pars60();
                    });
                }
            });
        }
    </script>
@stop
