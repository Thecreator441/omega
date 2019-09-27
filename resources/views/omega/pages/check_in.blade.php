<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr') {
    App::setLocale('fr');
    $title = 'Versement Par Chèque';
} else {
    $title = 'Check Deposit';
}
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')
    <div class="box">
        <div class="box-header">
            <div class="box-tools">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right fa fa-close" id="home"></button>
            </div>
        </div>
        <div class="box-body">
            <form action="{{ url('check_in/store') }}" method="post" role="form" id="checkForm">
                {{ csrf_field() }}
                <div class="box-header with-border" id="form">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="member" class="col-md-2 control-label">@lang('label.member')</label>
                                <div class="col-md-3">
                                    <select class="form-control select2" name="member" id="member">
                                        <option></option>
                                        @foreach($members as $member)
                                            <option
                                                value="{{$member->idmember}}">{{pad($member->memnumb, 6)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-7">
                                    <div class="row">
                                        <input type="text" class="form-control" name="mem_name" id="mem_name" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bank" class="col-md-2 control-label">@lang('label.bank')</label>
                                <div class="col-md-3">
                                    <select class="form-control select2" name="bank" id="bank">
                                        <option></option>
                                        @foreach($banks as $bank)
                                            <option
                                                value="{{$bank->idbank}}"> {{pad($bank->bankcode, 6)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="bank_name" id="bank_name" disabled>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="checkno"
                                       class="col-md-3 control-label">@lang('label.checkno')</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="checkno" id="checkno">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" class="form-control text-right text-bold" name="checkamt"
                                       id="checkamt" placeholder="@lang('label.amount')">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="carrier"
                                       class="col-md-2 control-label">@lang('label.carrier')</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="carrier" id="carrier">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-5 bg-maroon-gradient"></div>
                        <div class="col-md-2 text-center text-blue text-bold">@lang('label.memotacc')</div>
                        <div class="col-md-5 bg-maroon-gradient"></div>
                    </div>

                    <table id="tableInput"
                           class="table table-striped table-hover table-condensed table-bordered table-responsive no-padding">
                        <thead>
                        <tr class="bg-purples">
                            <th>@lang('label.account')</th>
                            <th>@lang('label.entitle')</th>
                            <th>@lang('label.opera')</th>
                            <th>@lang('label.amount')</th>
                        </tr>
                        </thead>
                        <tbody id="mem_acc">
                        </tbody>
                    </table>
                </div>

                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-5 bg-maroon-gradient"></div>
                        <div class="col-md-2 text-center text-blue text-bold">@lang('label.memloanacc')</div>
                        <div class="col-md-5 bg-maroon-gradient"></div>
                    </div>

                    <table id="tableInput2"
                           class="table table-striped table-hover table-condensed table-bordered table-responsive no-padding">
                        <thead>
                        <tr class="bg-purples">
                            <th colspan="2">@lang('label.account')</th>
                            <th>@lang('label.fines')</th>
                            <th>@lang('label.late')</th>
                            <th>@lang('label.amount')</th>
                            <th>@lang('label.balance')</th>
                            <th>@lang('label.retint')</th>
                            <th>@lang('label.totint')</th>
                            <th>@lang('label.payment')</th>
                            <th>@lang('label.interest')</th>
                            <th>@lang('label.diff')</th>
                        </tr>
                        </thead>
                        <tbody id="loan_acc">
                        </tbody>
                    </table>
                </div>

                <div class="col-md-11">
                    <table class="table table-responsive" id="tableInput">
                        <thead>
                        <tr class="text-bold text-blue bg-antiquewhite text-left">
                            <td>@lang('label.totrans')</td>
                            <td style="width: 15%"><input type="text" style="text-align: left" name="totrans"
                                                          id="totrans" readonly></td>
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
            $('#checkno').verifNumber();
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

                    $.ajax({
                        url: "{{ url('getAccBalance') }}",
                        method: 'get',
                        data: {member: member.idmember},
                        success: function (accounts) {
                            let memAccLine = '';
                            let loanAccLine = '';
                            $.each(accounts, function (i, account) {
                                if (account.accabbr === 'O' || account.accabbr === 'S') {
                                    memAccLine += "<tr>" +
                                        "<td><input type='hidden' name='accounts[]' value='" + account.account + "'>" + account.accnumb + "</td>" +
                                        "<td>@if ($emp->lang == 'fr')" + account.labelfr + " @else " + account.labeleng + "@endif</td>" +
                                        "<td><input type='hidden' name='operations[]' value='" + account.operation + "'>" +
                                        "@if ($emp->lang == 'fr') DÉPÔT CHÈQUE " + account.operfr + " @else CHECK IN " + account.opereng + "@endif</td>" +
                                        "<td><input type='text' name='amounts[]' class='amount'></td>" +
                                        "</tr>";
                                    $('#mem_acc').html(memAccLine);
                                }
                                {{--else if (account.accabbr === 'E') {--}}
                                {{--    let loans = $.parseJSON(--}}
                                {{--        $.ajax({--}}
                                {{--            url: "{{ url('getMemLoans') }}",--}}
                                {{--            method: 'get',--}}
                                {{--            data: {member: member.idmember},--}}
                                {{--            dataType: 'json',--}}
                                {{--            async: false--}}
                                {{--        }).responseText--}}
                                {{--    );--}}

                                {{--    let loanAmt = 0;--}}
                                {{--    $.each(loans, function (i, loan) {--}}
                                {{--        if (loan.memacc === account.account) {--}}
                                {{--            let loanType = $.parseJSON(--}}
                                {{--                $.ajax({--}}
                                {{--                    url: "{{ url('getLoanType') }}",--}}
                                {{--                    method: 'get',--}}
                                {{--                    data: {ltype: loan.loantype},--}}
                                {{--                    dataType: 'json',--}}
                                {{--                    async: false--}}
                                {{--                }).responseText--}}
                                {{--            );--}}

                                {{--            let amt = '';--}}
                                {{--            if (loan.remamt === '0.00' || isNaN(loan.remamt)) {--}}
                                {{--                amt = loan.amount;--}}
                                {{--            } else {--}}
                                {{--                amt = loan.remamt;--}}
                                {{--            }--}}
                                {{--            loanAmt += amt;--}}

                                {{--            loanAccLine += "<tr>" +--}}
                                {{--                "<td>" + pad(loan.loanno, 6) + "</td>" +--}}
                                {{--                "<td>" + loanType.accnumb + "</td>" +--}}
                                {{--                "<td class='text-right text-bold'>" + money(parseInt(amt)) + "</td>" +--}}
                                {{--                "<td class='text-right text-bold'>" + money(parseInt(loan.intamt)) + "</td>" +--}}
                                {{--                "<td class='text-right text-bold'>" + money(parseInt(loan.intamt)) + "</td>" +--}}
                                {{--                "<td>" + money(parseInt(loan.intamt)) + "</td>" +--}}
                                {{--                "<td class='text-right text-bold'>" + money(parseInt(loan.intamt)) + "</td>" +--}}
                                {{--                "<td class='text-right text-bold'>" + money(parseInt(loan.intamt)) + "</td>" +--}}
                                {{--                "<td class='text-center'>" + userDate(loan.created_at) + "</td>" +--}}
                                {{--                "</tr>";--}}
                                {{--            $('#loan_acc').html(loanAccLine);--}}
                                {{--        }--}}
                                {{--    });--}}
                                {{--}--}}
                            });
                        },
                        error: function (errors) {
                            $.each(errors, function (i, error) {
                                console.log(error)
                            });
                        }
                    });
                }
            });
        });

        $('#bank').change(function () {
            $.ajax({
                url: "{{ url('getBank') }}",
                method: 'get',
                data: {
                    bank: $(this).val()
                },
                success: function (bank) {
                    $('#bank_name').val(bank.name);
                }
            });
        });

        $('#checkamt').on('input', function () {
            $(this).val(money($(this).val()));
        });

        $(document).on('input', '.amount', function () {
            $(this).val(money($(this).val()));

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
                diff.text(money(dif));
            } else if (diff > 0) {
                diff.attr('class', 'text-green');
                diff.text(money(dif));
            } else {
                diff.attr('class', 'text-blue');
                diff.text(money(dif));
            }
        });

        $(document).on('click', '#save', function () {
            let tot = parseInt(trimOver($('#totrans').val(), null));
            let amt = parseInt(trimOver($('#checkamt').val(), null));

            if (tot === amt) {
                swal({
                        title: '@lang('sidebar.checkin')',
                        text: '@lang('confirm.checkinsave_text')',
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
                            $('#checkForm').submit();
                        }
                    }
                );
            } else {
                swal({
                        title: '@lang('sidebar.checkin')',
                        text: '@lang('confirm.checkinerror_text')',
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
