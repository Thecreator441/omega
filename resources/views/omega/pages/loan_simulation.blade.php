<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.simul'))

@section('content')
    <div class="box">
        <div class="box-header">
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right fa fa-close" id="home"></button>
            </div>
        </div>
        <div class="box-body">
            <form action="{{ url('loan_simulation/store') }}" method="POST" role="form">
                {{ csrf_field() }}
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
                                <div class="form-group">
                                    <input type="text" class="form-control" name="mem_name" id="mem_name" disabled>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="amount" class="col-md-5 control-label">@lang('label.amount')</label>
                                <div class="col-md-7">
                                    <input type="text" name="amount" id="amount"
                                           class="form-control text-bold text-right">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="amorti" class="col-md-4 control-label">@lang('label.amort')</label>
                                <div class="col-md-8">
                                    <select name="amorti" id="amorti" class="form-control select2">
                                        <option></option>
                                        <option value="C" selected>@lang('label.constamort')</option>
                                        <option value="V">@lang('label.varamort')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="period" class="col-md-4 control-label">@lang('label.periodicity')</label>
                                <div class="col-md-8">
                                    <select name="period" id="period" class="form-control select2">
                                        <option></option>
                                        <option value="D">@lang('label.daily')</option>
                                        <option value="W">@lang('label.weekly')</option>
                                        <option value="B">@lang('label.bimens')</option>
                                        {{--                                        <option value="F">@lang('label.bimes')</option>--}}
                                        <option value="M" selected>@lang('label.mens')</option>
                                        <option value="T">@lang('label.trim')</option>
                                        <option value="S">@lang('label.sem')</option>
                                        <option value="A">@lang('label.ann')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="grace" class="col-md-5 control-label">@lang('label.grace')</label>
                                <div class="col-md-7">
                                    {{--                                    <input type="text" name="grace" id="grace" class="form-control text-right">--}}
                                    <select name="grace" id="grace" class="form-control select2">
                                        <option value="1">@lang('label.day1')</option>
                                        <option value="7">@lang('label.week1')</option>
                                        <option value="15">@lang('label.mon1/2')</option>
                                        <option value="30" selected>@lang('label.mon1')</option>
                                        <option value="90">@lang('label.trim1')</option>
                                        <option value="180">@lang('label.sem1')</option>
                                        <option value="360">@lang('label.ann1')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="tax_rate" class="col-md-7 control-label">@lang('label.taxrate')</label>
                                <div class="col-md-5">
                                    <input type="text" name="tax_rate" id="tax_rate" class="form-control text-right">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="int_rate" class="col-md-8 control-label">@lang('label.monintrate')</label>
                                <div class="col-md-4">
                                    <input type="text" name="int_rate" id="int_rate" class="form-control text-right">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="numb_inst" class="col-md-6 control-label">@lang('label.noinstal')</label>
                                <div class="col-md-6">
                                    <input type="text" name="numb_inst" id="numb_inst" class="form-control text-right">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="inst1" class="col-md-5 control-label">@lang('label.inst1')</label>
                                <div class="col-md-7">
                                    <input type="date" name="inst1" id="date" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <table class="table table-bordered table-striped table-hover table-condensed table-responsive">
                        <thead>
                        <tr class="text-center text-bold">
                            <th>@lang('label.install')</th>
                            <th>@lang('label.capital')</th>
                            <th>@lang('label.amort')</th>
                            <th>@lang('label.interest')</th>
                            <th>@lang('label.annuity')</th>
                            <th>@lang('label.tax')</th>
                            <th>@lang('label.total')</th>
                            <th>@lang('label.date')</th>
                        </tr>
                        </thead>
                        <tbody id="amorDisplay">
                        </tbody>
                        <tfoot id="tableInput">
                        <tr>
                            <td></td>
                            <td><input type="text" disabled></td>
                            <td><input type="text" name="amoAmt" id="amoAmt" class="text-bold text-blue text-right"
                                       readonly></td>
                            <td><input type="text" name="intAmt" id="intAmt" class="text-bold text-blue text-right"
                                       readonly></td>
                            <td><input type="text" name="annAmt" id="annAmt" class="text-bold text-blue text-right"
                                       readonly></td>
                            <td><input type="text" name="taxAmt" id="taxAmt" class="text-bold text-blue text-right"
                                       readonly></td>
                            <td><input type="text" name="totAmt" id="totAmt" class="text-bold text-blue text-right"
                                       readonly></td>
                            <td></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="col-md-12">
                    <button type="button" id="print" class="btn btn-sm bg-blue pull-right btn-raised fa fa-print">
                    </button>
                    <button type="button" id="display" class="btn btn-sm bg-green pull-right btn-raised fa fa-eye">
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
        $(document).ready(function () {
            $('#numb_inst').verifNumber();
            $('#tax_rate, #int_rate').verifTax();

            $('#date').val(formDate($('#grace').val()));
        });

        $('#grace').change(function () {
            $('#date').val(formDate($('#grace').val()));
        });

        $('#amount').on('input', function () {
            $(this).val(money($(this).val()));
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
                        $('#mem_name').val(member.name);
                    } else {
                        $('#mem_name').val(member.name + ' ' + member.surname);
                    }
                }
            });
        });

        $(document).on('click', '#display', function () {
            let amt = parseInt(trimOver($('#amount').val(), null));
            let period = $('#period').val();
            let amort = $('#amorti').val();
            let instno = parseInt($('#numb_inst').val());
            let tax = parseFloat(parseFloat($('#tax_rate').val()) / 100);
            if (isNaN(tax)) {
                tax = 0;
            }
            let intra = parseFloat(parseFloat($('#int_rate').val()) / 100);
            let intdate = $('#date').val();
            let line = '';

            let totAmorAmt = 0;
            let totIntAmt = 0;
            let totAnnAmt = 0;
            let totTaxAmt = 0;
            let totTotAmt = 0;

            for (let i = 1; i < instno + 1; i++) {
                let amortAmt;
                let capital = amt;
                let date = new Date(intdate);

                if (amort === 'C') {
                    amortAmt = amt / instno;
                    if (i > 1) {
                        let cap = amt - amortAmt;
                        for (let j = 1; j < i - 1; j++) {
                            cap -= amortAmt;
                        }
                        capital = cap;
                    }
                }

                if (amort === 'V') {
                    amortAmt = (capital * intra) / (Math.pow((1 + intra), instno) - 1);
                    if (i > 1) {
                        let cap = capital - amortAmt;
                        let amo = (cap * intra) / (Math.pow((1 + intra), instno - 1) - 1);
                        for (let j = 1; j < i - 1; j++) {
                            cap -= amo;
                            amo = (cap * intra) / (Math.pow((1 + intra), (instno - (j + 1))) - 1);
                        }
                        capital = cap;
                        amortAmt = amo;
                    }
                }

                if (i === 1) {
                    date = date;
                } else {
                    if (period === 'D') {
                        date = date.addDays(i - 1);
                    } else if (period === 'W') {
                        date = date.addDays(7 * (i - 1));
                    } else if (period === 'B') {
                        date = date.addDays(15 * (i - 1));
                    }
                    // else if (period === 'F') {
                    //     date = date.addMonths(i - 1);
                    // }
                    else if (period === 'M') {
                        date = date.addMonths(i - 1);
                    } else if (period === 'T') {
                        date = date.addMonths(3 * (i - 1));
                    } else if (period === 'S') {
                        date = date.addMonths(6 * (i - 1));
                    } else {
                        date = date.addYears(i - 1);
                    }
                }

                let intAmt = capital * intra;
                let annAmt = amortAmt + intAmt;
                let taxAmt = intAmt * tax;
                let totAmt = annAmt + taxAmt;

                date = Date.parse(date).toString('dd/MM/yyyy');

                line += '<tr>' +
                    '<td class="text-center">' + i + '</td>' +
                    '<td class="text-right text-bold">' + money(Math.round(capital)) + '</td>' +
                    '<td class="text-right text-bold">' + money(Math.round(amortAmt)) + '</td>' +
                    '<td class="text-right text-bold">' + money(Math.round(intAmt)) + '</td>' +
                    '<td class="text-right text-bold">' + money(Math.round(annAmt)) + '</td>' +
                    '<td class="text-right text-bold">' + money(Math.round(taxAmt)) + '</td>' +
                    '<td class="text-right text-bold">' + money(Math.round(totAmt)) + '</td>' +
                    '<td class="text-center">' + date + '</td>' +
                    '</tr>';

                totAmorAmt += amortAmt;
                totIntAmt += intAmt;
                totAnnAmt += annAmt;
                totTaxAmt += taxAmt;
                totTotAmt += totAmt;
            }
            $('#amoAmt').val(money(totAmorAmt));
            $('#intAmt').val(money(totIntAmt));
            $('#annAmt').val(money(totAnnAmt));
            $('#taxAmt').val(money(totTaxAmt));
            $('#totAmt').val(money(totTotAmt));

            line += '<tr>' +
                '<td class="text-center">' + ++instno + '</td>' +
                '<td class="text-right text-bold">0</td>' +
                '<td class="text-right text-bold">0</td>' +
                '<td class="text-right text-bold">0</td>' +
                '<td class="text-right text-bold">0</td>' +
                '<td class="text-right text-bold">0</td>' +
                '<td colspan="2"></td>' +
                '</tr>';
            $('#amorDisplay').html(line);
        });
    </script>
@stop
