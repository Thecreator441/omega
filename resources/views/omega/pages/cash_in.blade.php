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
            <h3 class="box-title text-bold"> @lang('sidebar.cin') </h3>
        </div>
        <div class="box-body">
            <form action="{{ url('cash_in/store') }}" method="post" role="form" id="cinForm">
                {{ csrf_field() }}

                <div class="col-md-12">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label for="member" class="col-md-2 co col-xs-2 ntrol-label">@lang('label.member')</label>
                                    <div class="col-md-10 col-xs-10">
                                        <select class="form-control select2" name="member" id="member">
                                            <option value=""></option>
                                            @foreach($members as $member)
                                                <option value="{{$member->idmember}}">{{pad($member->memnumb, 6)}} : {{ $member->name }} {{ $member->surname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label for="represent" class="col-md-2 col-xs-2  control-label">@lang('label.represent')</label>
                                    <div class="col-md-10 col-xs-10">
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
                                    <td id="billet">{{$money->value}}</td>
                                    <td><input type="text" name="{{$money->moncode}}" id="{{$money->moncode}}" oninput="sum('{{$money->value}}', '#{{$money->moncode}}', '#{{$money->moncode}}Sum')"></td>
                                    <td class="sum text-right text-bold" id="{{$money->moncode}}Sum"></td>
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
                                    <td><input type="text" name="{{$money->moncode}}" id="{{$money->moncode}}" oninput="sum('{{$money->value}}', '#{{$money->moncode}}', '#{{$money->moncode}}Sum')"></td>
                                    <td class="sum text-right text-bold" id="{{$money->moncode}}Sum"></td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th class="bg-purples" colspan="2"
                                style="text-align: center !important;">@lang('label.tobreak')</th>
                            <th class="bg-blue">
                                <input type="text" class="bg-blue pull-right text-bold" name="totbil" id="totbil" disabled style="text-align: right !important;">
                            </th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="col-md-9" id="tableInput">
                    <div class="col-md-12">
                        <div class="row">
                            <table
                                class="table table-striped table-hover table-condensed table-bordered table-responsive no-padding">
                                <thead>
                                <tr class="bg-purples">
                                    <th>@lang('label.account')</th>
                                    <th>@lang('label.entitle')</th>
                                    {{-- <th>@lang('label.opera')</th> --}}
                                    <th>@lang('label.amount')</th>
                                </tr>
                                </thead>
                                <tbody id="mem_acc">
                                </tbody>
                                <tfoot>
                                <tr class="bg-purples text-right text-bold">
                                    <td colspan="3" id="totopera"></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
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
                            <th class="cin">@lang('label.loan_amt')</th>
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
        $(document).ready(function () {
            sumAmount();
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
                            if (accBal.accabbr === 'Or') {
                                memAccLine += '<tr>' +
                                    '<td><input type="hidden" name="accounts[]" value="' + accBal.account + '">' + accBal.accnumb + '</td>' +
                                    '<td><input type="hidden" name="operations[]" value="' + accBal.operation + '">@if ($emp->lang == 'fr')' + accBal.labelfr + ' @else ' + accBal.labeleng + '@endif</td>' +
                                    //'<td>@if ($emp->lang == 'fr')' + accBal.credtfr + ' @else ' + accBal.credteng + '@endif</td>' + --}}
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
                                    let pen = Math.round((remamt * days * loanType.pen_req_tax) / 1200);
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

            sumAmount();
        }

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
        }

        function addRow(monLength, infLength) {
            let dim = monLength - infLength;
            let tabLigne = null;
            for (let i = 0; i < dim; i++) {
                if ((infLength + i) < 5) {
                    tabLigne += '<tr><td colspan="4"><input type="text" disabled></td></tr>';
                }
                if ((infLength + i) === 6) {
                    $('#mem_acc').after('<thead><tr>' +
                        '<th colspan="4" style="background-color: lightgrey !important;"><input type="text" disabled></th>' +
                        '</tr></thead><tbody id="skip"></tbody>'
                    );
                }
                if ((infLength + i) > 6) {
                    $('#skip').append('<tr><td colspan="4" style="background-color: lightgrey !important;"><input type="text" disabled></td></tr>');
                }
            }
            return tabLigne;
        }

        $('#save').click(function () {
            let cust = $('#member').val();
            let totbil = parseInt(trimOver($('#totbil').val(), null));
            let diff = parseInt(trimOver($('#diff').text(), null));

            if (diff === 0 && cust !== '' && !isNaN(totbil) && totbil !== 0) {
                mySwal("{{ $title }}", '@lang('confirm.cin_text')', '@lang('confirm.no')', '@lang('confirm.yes')', '#cinForm');
            } else {
                myOSwal("{{ $title }}", '@lang('confirm.cinerror_text')', 'error');
            }
        });
    </script>
@stop
