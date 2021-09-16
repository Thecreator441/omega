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
            <form action="{{ url('cash_in/store') }}" method="post" role="form" id="cinForm" class="needs-validation">
                {{ csrf_field() }}

                <div class="row">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
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
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="represent" class="col-xl-1 col-lg-2 col-md-3 col-sm-3 control-label">@lang('label.represent')</label>
                                <div class="col-xl-11 col-lg-10 col-md-9 col-sm-9">
                                    <input type="text" class="form-control" name="represent" id="represent">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" id="tableInput">
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-xs-12">
                        <div class="table-responsive">
                            <table id="billet-data-table" class="table table-striped table-hover table-condensed table-bordered no-padding">
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
                                <tr>
                                    <th colspan="2" class="bg-purples">@lang('label.coins')</th>
                                    <th></th>
                                </tr>
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
                    </div>
                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-8 col-xs-12">
                        <div class="table-responsive">
                            <table id="billet-data-table2" class="table table-striped table-hover table-condensed table-bordered no-padding">
                                <thead>
                                <tr class="bg-purples">
                                    <th>@lang('label.account')</th>
                                    <th>@lang('label.entitle')</th>
                                    <th>@lang('label.amount')</th>
                                </tr>
                                </thead>
                                <tbody>
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

                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="col-xl-4 col-lg-5 col-md-4 col-sm-4 col-sm-12 bg-maroon-gradient"></div>
                        <div class="col-xl-4 col-lg-2 col-md-4 col-sm-4 col-sm-12 text-center text-blue text-bold">@lang('label.memloanacc')</div>
                        <div class="col-xl-4 col-lg-5 col-md-4 col-sm-4 col-sm-12 bg-maroon-gradient"></div>
                    </div>
                </div>
                
                <div class="row" id="tableInput2">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                            <table id="loan-data-table" class="table table-striped table-hover table-condensed table-bordered no-padding">
                                <thead>
                                <tr>
                                    <th>@lang('label.account')</th>
                                    <th>@lang('label.desc')</th>
                                    <th>@lang('label.loan_amt')</th>
                                    <th>@lang('label.capital')</th>
                                    <th>@lang('label.late')</th>
                                    <th>@lang('label.interest')</th>
                                    <th>@lang('label.finint')</th>
                                    <th>@lang('label.accint')</th>
                                    <th>@lang('label.totint')</th>
                                    <th>@lang('label.intpay')</th>
                                    <th>@lang('label.payment')</th>

                                    {{-- <th style="width: 9%">@lang('label.account')</th>
                                    <th style="width: 13%">@lang('label.desc')</th>
                                    <th class="cin">@lang('label.loan_amt')</th>
                                    <th class="cin">@lang('label.capital')</th>
                                    <th style="width: 5%">@lang('label.late')</th>
                                    <th class="cin">@lang('label.interest')</th>
                                    <th class="cin">@lang('label.finint')</th>
                                    <th class="cin">@lang('label.accint')</th>
                                    <th class="cin">@lang('label.totint')</th>
                                    <th class="cin">@lang('label.intpay')</th>
                                    <th class="cout">@lang('label.payment')</th> --}}
                                </tr>
                                </thead>
                                <tbody id="loanacc">
                                </tbody>
                                <tfoot></tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row" id="tableInput3">
                    <div class="col-xl-11 col-lg-11 col-md-11 col-sm-12 col-xs-12 ">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr class="text-bold text-blue bg-antiquewhite text-left">
                                    <td style="width: 25%">
                                        @if($emp->lang == 'fr') {{$cash->labelfr }} @else {{$cash->labeleng }} @endif
                                    </td>
                                    <td>{{$cash->casAcc_Numb }}</td>
                                    <td>@lang('label.totrans')</td>
                                    <td style="width: 15%">
                                        <input type="text" style="text-align: left" name="totrans" id="totrans" readonly></td>
                                    <td>@lang('label.diff')</td>
                                    <td id="diff" class="text-right" style="width: 15%"></td>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 col-xs-12">
                        <button type="submit" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>
                    </div>
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
            if (!isNaN($(this).val())) {
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

                        $('#billet-data-table2').DataTable({
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
                                url: "{{ url('getMemBals') }}",
                                data: {
                                    member: member.idmember,
                                    acctype: 'Or'
                                },
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
                        });
    
                        /*$.ajax({
                            url: "{{ url('getAccBalance') }}",
                            method: 'get',
                            data: {
                                member: member.idmember
                            },
                            success: function (memAccs) {
                                let memAccLine = '';
                                
                                $.each(memAccs, function (i, memAcc) {
                                    if (memAcc.accabbr === 'Or') {
                                        memAccLine += '<tr>' +
                                            '<td><input type="hidden" name="accounts[]" value="' + memAcc.account + '">' + memAcc.accnumb + '</td>' +
                                            '<td><input type="hidden" name="operations[]" value="' + memAcc.operation + '">@if ($emp->lang == 'fr')' + memAcc.acclabelfr + ' @else ' + memAcc.acclabeleng + '@endif</td>' +
                                            '<td><input type="text" name="amounts[]" class="amount"></td>' +
                                            '</tr>';
                                    }
                                });
                                $('#mem_acc').html(memAccLine);
                            }
                        });*/
    
                        $('#loanacc > tr').remove();
    
                        $.ajax({
                            url: "{{ url('getMemLoans') }}",
                            method: 'get',
                            data: {
                                member: member.idmember
                            },
                            success: function (loans) {
                                let loanAccLine = '';
                                var table = $('#billet-data-table3').DataTable();
    
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
                                        
                                        table.row.add(loanAccLine).draw();
                                        {{-- $('#loanacc').html(loanAccLine); --}}
                                    }
    
                                    pasteLoans();
                                });
                            }
                        });
                    }
                });
            } else {
                $('#represent').val('');
            }
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

        function submitForm() {
            let cust = $('#member').val();
            let totbil = parseInt(trimOver($('#totbil').val(), null));
            let diff = parseInt(trimOver($('#diff').text(), null));

            if (diff === 0 && cust !== '' && !isNaN(totbil) && totbil !== 0) {
                mySwal("{{ $title }}", '@lang('confirm.cin_text')', '@lang('confirm.no')', '@lang('confirm.yes')', '#cinForm');
            } else {
                myOSwal("{{ $title }}", '@lang('confirm.cinerror_text')', 'error');
            }
        }
    </script>
@stop
