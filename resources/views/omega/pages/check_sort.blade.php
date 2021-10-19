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
            <form action="{{ url('check_sort/store') }}" method="post" role="form" id="checkSortForm" class="needs-validation">
                {{ csrf_field() }}

                <div class="row">
                    <div class="row">
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="check" class="col-xl-2 col-lg-3 col-md-3 col-sm-4 col-xs-4 control-label">@lang('label.checkno')<span class="text-red text-bold">*</span></label>
                                <div class="col-xl-10 col-lg-9 col-md-9 col-sm-8 col-xs-8">
                                    <select name="check" id="check" class="form-control select2" required>
                                        <option value=""></option>
                                        @foreach ($checks as $check)
                                            <option value="{{$check->idcheck}}">{{$check->checknumb}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-7 col-lg-7 col-md-7 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="member" class="col-xl-1 col-lg-2 col-md-2 col-sm-4 control-label">@lang('label.member')<span class="text-red text-bold">*</span></label>
                                <div class="col-xl-11 col-lg-10 col-md-10 col-sm-8">
                                    <select class="form-control select2" name="member" id="member" required disabled>
                                        <option value=""></option>
                                        @foreach($members as $member)
                                            <option value="{{$member->idmember}}">{{pad($member->memnumb, 6)}} : {{ $member->name }} {{ $member->surname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="bank" class="col-xl-2 col-lg-3 col-md-3 col-sm-4 control-label">@lang('label.bank')</label>
                                <div class="col-xl-10 col-lg-9 col-md-9 col-sm-8">
                                    <select class="form-control select2" name="bank" id="bank" disabled>
                                        <option value=''></option>
                                        @foreach($banks as $bank)
                                            <option value="{{ $bank->idbank }}">{{ pad($bank->bankcode, 3) }} : @if($emp->lang === 'eng') {{ $bank->labeleng }} @else {{ $bank->labelfr }} @endif </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="carrier" class="col-xl-2 col-lg-3 col-md-3 col-sm-4 control-label">@lang('label.carrier')</label>
                                <div class="col-xl-10 col-lg-9 col-md-9 col-sm-8">
                                    <input type="text" name="carrier" id="carrier" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 pull-right">
                            <div class="form-group">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <input type="text" name="date" id="date" class="form-control" placeholder="@lang('label.date')" disabled>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                </div>

                <div class="row" id="tableInput">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="col-xl-5 col-lg-5 col-md-4 col-sm-4 col-xs-12 bg-maroon-gradient"></div>
                                <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-xs-12 text-center text-blue text-bold">@lang('label.memotacc')</div>
                                <div class="col-xl-5 col-lg-5 col-md-4 col-sm-4 col-xs-12 bg-maroon-gradient"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="table-responsive">
                                    <table id="memacc-data-table" class="table table-striped table-hover table-condensed table-bordered">
                                        <thead>
                                            <tr>
                                                <th>@lang('label.account')</th>
                                                <th>@lang('label.entitle')</th>
                                                <th>@lang('label.amount')</th>
                                            </tr>
                                        </thead>
                                        <tbody id="memacc">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="col-xl-5 col-lg-5 col-md-4 col-sm-4 col-xs-12 bg-maroon-gradient"></div>
                                <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-xs-12 text-center text-blue text-bold">@lang('label.memloanacc')</div>
                                <div class="col-xl-5 col-lg-5 col-md-4 col-sm-4 col-xs-12 bg-maroon-gradient"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="table-responsive">
                                    <table id="loanacc-data-table" class="table table-striped table-hover table-condensed table-bordered">
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
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" id="tableInput2">
                    <div class="col-xl-11 col-lg-11 col-md-11 col-sm-11 col-xs-10">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr class="text-bold text-blue bg-antiquewhite text-right">
                                        <td>@lang('label.totrans')</td>
                                        <td>
                                            <input type="text" style="text-align: left" name="totrans" id="totrans" readonly>
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-xs-2 pull-right">
                        <button type="button" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
        let memacc = $('#memacc-data-table').DataTable({
            paging: false,
            info: false,
            responsive: true,
            ordering: false,
            FixedHeader: true,
            language: {
                url: "{{ asset("plugins/datatables/lang/$emp->lang.json") }}",
            },
            searching: false
        });

        let loanacc = $('#loanacc-data-table').DataTable({
            paging: false,
            info: false,
            responsive: true,
            ordering: false,
            FixedHeader: true,
            language: {
                url: "{{ asset("plugins/datatables/lang/$emp->lang.json") }}",
            },
            searching: false
        });
            
        $('#check').change(function () {
            if($(this).val() !== '') {
                $.ajax({
                    url: "{{ url('getCheck') }}",
                    method: 'get',
                    data: {
                        check: $(this).val(),
                    }, success: function (check) {
                        $('#member').val(check.member).select2();
                        $('#bank').val(check.bank).select2();
                        $('#carrier').val(check.carrier);
                        $('#date').val(userDate(check.created_at));

                        var checkAccs = check.check_acc_amts;

                        if(checkAccs.length > 0) {
                            memacc.rows().remove().draw();
                            loanacc.rows().remove().draw();

                            $.each(checkAccs, function (i, checkAcc) {
                                $('#mem_acc > tr').remove();
                                $('#loanacc > tr').remove();

                                if (checkAcc.type === 'N') {
                                    const memLine = $('<tr>' +
                                            '<td class="text-center"><input type="hidden" name="accounts[]" value="' + checkAcc.account + '">' + checkAcc.accnumb + '</td>' +
                                            '<td><input type="hidden" name="operations[]" value="' + checkAcc.operation + '">' + checkAcc.acc + '</td>' +
                                            '<td class="text-right text-bold cout"><input type="hidden" name="amounts[]" class="amount" value="' + parseInt(checkAcc.accamt) + '">' + money(parseInt(checkAcc.accamt)) + '</td>' +
                                        '</tr>');
                                    
                                    memacc.row.add(memLine[0]).draw();
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
                    }
                });
            } else {
                $('#member').val('').select2();
                $('#bank').val('').select2();
                $('#carrier').val('');
                $('#date').val('');

                memacc.rows().remove().draw();
                loanacc.rows().remove().draw();
            }
        });

        $('#save').click(function () {
            let check = $('#check').val();
            let totbil = parseInt(trimOver($('#totrans').val(), null));

            if (check !== '' && !isNaN(totbil) && totbil !== 0) {
                mySwal("{{ $title }}", '@lang('confirm.check_sort_text')', '@lang('confirm.no')', '@lang('confirm.yes')', '#checkSortForm');
            } else {
                myOSwal("{{ $title }}", '@lang('confirm.check_sort_error_text')', 'error');
            }
        });
    </script>
@stop
