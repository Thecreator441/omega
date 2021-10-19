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
            <form action="{{ url('check_in/store') }}" method="post" role="form" id="checkForm" class="needs-validation">
                {{ csrf_field() }}

                <div class="row">
                    <div class="row">
                        <div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 col-xs-12">
                            <div class="form-group">
                                <label for="member" class="col-xl-1 col-lg-2 col-md-2 col-sm-2 control-label">@lang('label.member')<span class="text-red text-bold">*</span></label>
                                <div class="col-xl-11 col-lg-110col-md-10 col-sm-10">
                                    <select class="form-control select2" name="member" id="member" required>
                                        <option value=""></option>
                                        @foreach($members as $member)
                                            <option value="{{$member->idmember}}">{{pad($member->memnumb, 6)}} : {{ $member->name }} {{ $member->surname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <div class="form-group">
                                <label for="bank" class="col-xl-1 col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">@lang('label.bank')<span class="text-red text-bold">*</span></label>
                                <div class="col-xl-11 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                    <select class="form-control select2" name="bank" id="bank" required>
                                        <option value=""></option>
                                        @foreach($banks as $bank)
                                            <option value="{{$bank->idbank}}"> {{pad($bank->bankcode, 3)}} : @if($emp->lang === 'fr')
                                                    {{ $bank->labelfr}}
                                                @else
                                                    {{ $bank->labeleng}}
                                                @endif</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label for="checkno" class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-2 control-label">@lang('label.checkno')<span class="text-red text-bold">*</span></label>
                                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-10">
                                    <input type="text" class="form-control" name="checkno" id="checkno" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="form-group">
                                <label for="checkamt" class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-xs-2 control-label">@lang('label.amount')<span class="text-red text-bold">*</span></label>
                                <div class="col-xl-9 col-lg-9 col-md-8 col-sm-8 col-xs-10">
                                    <input type="text" class="form-control text-right text-bold" name="checkamt" id="checkamt" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <div class="form-group">
                                <label for="represent" class="col-xl-1 col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">@lang('label.carrier')</label>
                                <div class="col-xl-11 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                    <input type="text" class="form-control" name="represent" id="represent">
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                </div>

                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="col-xl-4 col-lg-5 col-md-4 col-sm-4 col-sm-12 bg-maroon-gradient"></div>
                        <div class="col-xl-4 col-lg-2 col-md-4 col-sm-4 col-sm-12 text-center text-blue text-bold">@lang('label.memloanacc')</div>
                        <div class="col-xl-4 col-lg-5 col-md-4 col-sm-4 col-sm-12 bg-maroon-gradient"></div>
                    </div>
                </div>

                <div class="row" id="tableInput">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                            <table id="billet-data-table" class="table table-striped table-hover table-condensed table-bordered no-padding">
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
                            <table id="billet-data-table2" class="table table-striped table-hover table-condensed table-bordered no-padding">
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
                                <tr class="text-bold text-blue bg-antiquewhite text-right">
                                    <td>@lang('label.totrans')</td>
                                    <td><input type="text" style="text-align: right" class="text-bold" name="totrans" id="totrans" readonly></td>
                                    <td>@lang('label.diff')</td>
                                    <td id="diff" class="text-right" style="width: 15%"></td>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 col-xs-12">
                        <button type="submit" id="save" class="save btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>
                    </div>
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

                        $('#billet-data-table').DataTable({
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
                                {
                                    data: null, class: 'text-center', render: function (data, type, row) {
                                        return '<td><input type="hidden" name="accounts[]" value="' + data.account + '">' + data.accnumb + '</td>';
                                    }
                                },
                                {
                                    data: null, render: function (data, type, row) {
                                        return '<td><input type="hidden" name="operations[]" value="' + data.operation + '">' +
                                            '@if ($emp->lang == "fr")' + data.acclabelfr + ' @else ' + data.acclabeleng + '@endif</td>';
                                    }
                                },
                                {
                                    data: null, class: 'text-center', render: function (data, type, row) {
                                        return '<td><input type="text" name="amounts[]" class="amount"></td>';
                                    }
                                }
                            ],
                        });

                        $('#loanacc > tr').remove();
    
                        $.ajax({
                            url: "{{ url('getMemLoans') }}",
                            method: 'get',
                            data: {
                                member: member.idmember
                            },
                            success: function (loans) {
                                let loanAccLine = '';
                                var table = $('#billet-data-table2').DataTable();
    
                                $.each(loans, function (i, loan) {
                                    let loanamt = parseInt(loan.amount);
                                    if (parseInt(loan.isRef) > 0) {
                                        loanamt = parseInt(loan.refamt);
                                    }
                                    let paidamt = parseInt(loan.paidamt);
                                    let remamt = loanamt - paidamt;
                                    let accramt = parseInt(loan.accramt);
    
                                    async function pasteLoans() {
                                        const loanType = await getData('getLoanType?id=' + loan.loantype);
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
                                        $('#loanacc').html(loanAccLine);
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

        function submitForm() {
            let tot = parseInt(trimOver($('#totrans').val(), null));
            let amt = parseInt(trimOver($('#checkamt').val(), null));
            let dif = parseInt(trimOver($('#diff').text(), null));

            if ((tot === amt) && (dif === 0)) {
                mySwal("{{ $title }}", '@lang('confirm.check_in_text')', '@lang('confirm.no')', '@lang('confirm.yes')', '#checkForm');
            } else {
                myOSwal("{{ $title }}", '@lang('confirm.check_in_error_text')', 'error');
            }
        }
    </script>
@stop
