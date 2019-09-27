<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.refin'))

@section('content')
    <div class="box">
        <div class="box-header">
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right fa fa-close" id="home"></button>
            </div>
        </div>
        <div class="box-body">
            <form action="{{ url('refinancing/store') }}" method="POST" role="form" id="resForm">
                {{csrf_field()}}
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="loan" class="col-md-5 control-label">@lang('label.loanno')</label>
                                <div class="col-md-7">
                                    <select class="form-control select2" name="loan" id="loan">
                                        <option></option>
                                        @foreach ($loans as $loan)
                                            <option value="{{$loan->idloan}}">{{pad($loan->loanno, 6)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="member" class="col-md-5 control-label">@lang('label.member')</label>
                                <div class="col-md-7">
                                    <input type="text" name="member" id="member" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="col-md-12">
                                <input type="text" name="mem_name" id="mem_name" class="form-control" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="amount" class="col-md-5 control-label">@lang('label.remamt')</label>
                                <div class="col-md-7">
                                    <input type="text" name="amount" id="amount"
                                           class="form-control text-bold text-right" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="newamt" class="col-md-5 control-label">@lang('label.newamt')</label>
                                <div class="col-md-7">
                                    <input type="text" name="newamt" id="newamt"
                                           class="form-control text-bold text-right">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="amorti" class="col-md-4 control-label">@lang('label.amort')</label>
                                <div class="col-md-8">
                                    <select name="amorti" id="amorti" class="form-control select2" >
                                        <option></option>
                                        <option value="C">@lang('label.constamort')</option>
                                        <option value="V">@lang('label.varamort')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="period" class="col-md-5 control-label">@lang('label.periodicity')</label>
                                <div class="col-md-7">
                                    <select name="period" id="period" class="form-control select2" >
                                        <option></option>
                                        <option value="D">@lang('label.daily')</option>
                                        <option value="W">@lang('label.weekly')</option>
                                        <option value="B">@lang('label.bimens')</option>
                                        <option value="M">@lang('label.mens')</option>
                                        <option value="T">@lang('label.trim')</option>
                                        <option value="S">@lang('label.sem')</option>
                                        <option value="A">@lang('label.ann')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="grace" class="col-md-5 control-label">@lang('label.grace')</label>
                                <div class="col-md-7">
                                    <select name="grace" id="grace" class="form-control select2" >
                                        <option></option>
                                        <option value="1">@lang('label.day1')</option>
                                        <option value="7">@lang('label.week1')</option>
                                        <option value="15">@lang('label.mon1/2')</option>
                                        <option value="30">@lang('label.mon1')</option>
                                        <option value="90">@lang('label.trim1')</option>
                                        <option value="180">@lang('label.sem1')</option>
                                        <option value="360">@lang('label.ann1')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="numb_inst" class="col-md-5 control-label">@lang('label.noinstal')</label>
                                <div class="col-md-7">
                                    <input type="text" name="numb_inst" id="numb_inst" class="form-control text-right">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="int_rate" class="col-md-5 control-label">@lang('label.monintrate')</label>
                                <div class="col-md-7">
                                    <input type="text" name="int_rate" id="int_rate" class="form-control text-right">
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="inst1" class="col-md-5 control-label">@lang('label.inst1')</label>
                                <div class="col-md-7">
                                    <input type="date" name="inst1" id="date" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="button" id="print"
                                        class="btn btn-sm bg-default pull-right btn-raised fa fa-print"></button>
                                <button type="button" id="display"
                                        class="btn btn-sm bg-green pull-right btn-raised fa fa-eye"></button>
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
            $('#numb_inst').verifNumber();
            $('#int_rate, #tax_rate').verifTax();
        });

        $('#grace').change(function () {
            $('#date').val(formDate($('#grace').val()));
        });

        $(document).on('input', '#newamt', function () {
            $(this).val(money($(this).val()));
        });

        $('#loan').change(function () {
            $.ajax({
                url: "{{ url('getLoan') }}",
                method: 'get',
                data: {
                    loan: $(this).val()
                },
                success: function (loan) {
                    $.ajax({
                        url: "{{ url('getMember') }}",
                        method: 'get',
                        data: {
                            member: loan.member
                        },
                        success: function (member) {
                            $('#member').val(pad(member.memnumb, 6));
                            if (member.surname === null) {
                                $('#mem_name').val(member.name);
                            } else {
                                $('#mem_name').val(member.name + ' ' + member.surname);
                            }
                        }
                    });

                    if (loan.remamt === '0.00') {
                        $('#amount').val(money(parseInt(loan.amount)));
                    } else {
                        $('#amount').val(money(parseInt(loan.remamt)));
                    }
                    $('#amorti').val(loan.amortype).trigger('change');
                    $('#period').val(loan.periodicity).trigger('change');
                    $('#grace').val(loan.grace).trigger('change');
                    $('#int_rate').val(loan.intrate);
                    $('#tax_rate').val(loan.vat);
                    $('#numb_inst').val(parseInt(loan.nbrinst));
                    let date = new Date();
                    date = date.addDays(parseInt(loan.grace));
                    date = Date.parse(date).toString('yyyy-MM-dd');
                    $('#date').val(date);
                }
            });
        });

        $(document).on('click', '#display', function () {
            let amt = parseInt(trimOver($('#newamt').val(), null));
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
                    } else if (period === 'M') {
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
                    '<td class="text-center"><input type="hidden" name="nos[]" value="' + i + '">' + i + '</td>' +
                    '<td class="text-right text-bold"><input type="hidden" name="capitals[]" value="' + Math.round(capital) + '">' + money(Math.round(capital)) + '</td>' +
                    '<td class="text-right text-bold"><input type="hidden" name="amortAmts[]" value="' + Math.round(amortAmt) + '">' + money(Math.round(amortAmt)) + '</td>' +
                    '<td class="text-right text-bold"><input type="hidden" name="intAmts[]" value="' + Math.round(intAmt) + '">' + money(Math.round(intAmt)) + '</td>' +
                    '<td class="text-right text-bold"><input type="hidden" name="annAmts[]" value="' + Math.round(annAmt) + '">' + money(Math.round(annAmt)) + '</td>' +
                    '<td class="text-right text-bold"><input type="hidden" name="taxAmts[]" value="' + Math.round(taxAmt) + '">' + money(Math.round(taxAmt)) + '</td>' +
                    '<td class="text-right text-bold"><input type="hidden" name="totAmts[]" value="' + Math.round(totAmt) + '">' + money(Math.round(totAmt)) + '</td>' +
                    '<td class="text-center"><input type="hidden" name="dates[]" value="' + date + '">' + date + '</td>' +
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

        $('#save').click(function () {
            if (parseInt(trimOver($('#amoAmt').val(), null)) === parseInt(trimOver($('#newamt').val(), null))) {
                swal({
                        title: '@lang('sidebar.refin')',
                        text: '@lang('confirm.refin_text')',
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
                            $('#resForm').submit();
                        }
                    }
                );
            } else {
                swal({
                        title: '@lang('sidebar.refin')',
                        text: '@lang('confirm.refinerr_text')',
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
