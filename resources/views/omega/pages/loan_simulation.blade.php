<?php $emp = Session::get('employee');

$title = $menu->labeleng;
if ($emp->lang == 'fr') {
    $title = $menu->labelfr;
    App::setLocale('fr');
}
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold"> {{ $title }} </h3>
        </div>
        <div class="box-body">
            <form action="{{ url('loan_simulation/print') }}" method="GET" role="form" class="needs-validation" id="loanSimulation">
                {{ csrf_field() }}
                <div class="row">
                    <div class="row">
                        <div class="col-xl-9 col-lg-9 col-md-9 col-sm-7 col-xs-12">
                            <div class="form-group">
                                <label for="member" class="col-xl-1 col-lg-2 col-md-2 col-sm-2 control-label">@lang('label.member')<span class="text-red text-bold">*</span></label>
                                <div class="col-xl-11 col-lg-10 col-md-10 col-sm-10">
                                    <select class="form-control select2" name="member" id="member" required>
                                        <option value=""></option>
                                        @foreach($members as $member)
                                            <option value="{{$member->idmember}}">{{pad($member->memnumb, 6)}} : {{ $member->name }} {{ $member->surname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-5 col-xs-12">
                            <div class="form-group">
                                <label for="amount" class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-xs-2 control-label">@lang('label.amount')</label>
                                <div class="col-xl-10 col-lg-8 col-md-8 col-sm-8 col-xs-10">
                                    <input type="text" name="amount" id="amount" class="form-control text-bold text-right">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="amorti" class="col-xl-2 col-lg-4 col-md-4 control-label">@lang('label.amort')</label>
                                <div class="col-xl-10 col-lg-8 col-md-8">
                                    <select name="amorti" id="amorti" class="form-control select2">
                                        <option value="C" selected>@lang('label.constamort')</option>
                                        <option value="V">@lang('label.varamort')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="grace" class="col-xl-4 col-lg-5 col-md-5 control-label">@lang('label.grace')</label>
                                <div class="col-xl-8 col-lg-7 col-md-7">
                                    <select name="grace" id="grace" class="form-control select2">
                                        <option value="D">@lang('label.day1')</option>
                                        <option value="W">@lang('label.week1')</option>
                                        <option value="B">@lang('label.mon1/2')</option>
                                        <option value="M" selected>@lang('label.mon1')</option>
                                        <option value="T">@lang('label.trim1')</option>
                                        <option value="S">@lang('label.sem1')</option>
                                        <option value="A">@lang('label.ann1')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="period" class="col-xl-2 col-lg-4 col-md-4 control-label">@lang('label.periodicity')</label>
                                <div class="col-xl-10 col-lg-8 col-md-8">
                                    <select name="period" id="period" class="form-control select2">
                                        <option value="D">@lang('label.daily')</option>
                                        <option value="W">@lang('label.weekly')</option>
                                        <option value="B">@lang('label.bimens')</option>
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
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <label for="int_rate" class="col-xl-6 col-lg-5 col-md-5 col-sm-6 control-label">@lang('label.monintrate')</label>
                                <div class="col-xl-6 col-lg-7 col-md-7 col-sm-6">
                                    <input type="text" name="int_rate" id="int_rate" class="form-control text-right">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <label for="tax_rate" class="col-xl-4 col-lg-6 col-md-6 col-sm-5 control-label">@lang('label.taxrate')</label>
                                <div class="col-xl-8 col-lg-6 col-md-6 col-sm-7">
                                    <input type="text" name="tax_rate" id="tax_rate" class="form-control text-right">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <label for="numb_inst" class="col-xl-4 col-lg-6 col-md-6 col-sm-6 control-label">@lang('label.noinstal')</label>
                                <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6">
                                    <input type="text" name="numb_inst" id="numb_inst" class="form-control text-right">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <label for="inst1" class="col-xl-2 col-lg-4 col-md-4 col-sm-5 control-label">@lang('label.inst1')</label>
                                <div class="col-xl-10 col-lg-8 col-md-8 col-sm-7">
                                    <input type="date" name="inst1" id="date" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                </div>

                <div class="row" id="tableInput">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <button type="button" id="print" class="btn btn-sm bg-blue pull-right btn-raised fa fa-print"></button>
                        <button type="button" id="display" class="btn btn-sm bg-green pull-right btn-raised fa fa-eye"></button>
                    </div>

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                            <table id="billet-data-table" class="table table-striped table-hover table-condensed table-bordered no-padding">
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
                            </table>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
        $(document).ready(function () {
            installment_date($('#grace').val());
        });

        $('#grace').change(function () {
            installment_date($(this).val());
        });

        function installment_date(grace) {
            var date = new Date();
            
            if (grace === 'D') {
                date = date.addDays(1);
            } else if (grace === 'W') {
                date = date.addDays(7);
            } else if (grace === 'B') {
                date = date.addDays(15);
            } else if (grace === 'M') {
                date = date.addMonths(1);
            } else if (grace === 'T') {
                date = date.addMonths(3);
            } else if (grace === 'S') {
                date = date.addMonths(6);
            } else {
                date = date.addYears(i);
            }

            $('#date').val(Date.parse(date).toString('yyyy-MM-dd'));
        }

        $('#amount').on('input', function () {
            $(this).val(money($(this).val()));
        });

        $(document).on('click', '#display', function () {
            {{-- $.ajax({
                url: "{{ url('loan_simulation/view') }}",
                method: 'GET',
                data: $("#loanSimulation").serialize(),
                datatype: 'json',
                success: function (member) {
                    console.log(simulation)
                }
            }); --}}

            {{-- $('#billet-data-table').DataTable({
                destroy: true,
                paging: false,
                info: false,
                responsive: true,
                ordering: false,
                searching: false,
                FixedHeader: true,
                processing: true,
                serverSide: false,
                language: {
                    url: "{{ asset("plugins/datatables/lang/$emp->lang.json") }}",
                },
                serverMethod: 'GET',
                ajax: {
                    url: "{{ url('loan_simulation_view') }}",
                    data: $("#loanSimulation").serialize(),
                    datatype: 'json'
                },
                columns: [
                    {data: null, class: 'text-center',
                        render: function (data, type, row) {
                            return '<td><input type="hidden" name="accounts[]" value="' + data.account + '">' + data.accnumb + '</td>';
                        }
                    },
                    {data: null, 
                        render: function (data, type, row) {
                            return '<td><input type="hidden" name="operations[]" value="' + data.operation + '">' +
                                '@if ($emp->lang == "fr")' + data.acclabelfr + ' @else ' + data.acclabeleng + '@endif</td>';
                        }
                    },
                    {data: null, 
                        render: function (data, type, row) {
                            return '<td><input type="text" name="amounts[]" class="amount"></td>';
                        }
                    }
                ],
            }); --}}
            
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
