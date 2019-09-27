<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.checkout'))

@section('content')
    <div class="box">
        <div class="box-header">
            <div class="box-tools">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right fa fa-close" id="home"></button>
            </div>
        </div>
        <div class="box-body">
            <form action="{{ url('check_out/store') }}" method="post" role="form" id="cheoutForm">
                {{ csrf_field() }}
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="member" class="col-md-2 control-label">@lang('label.member')</label>
                                <div class="col-md-3">
                                    <div class="col-md-12">
                                        <select class="form-control select2" name="member" id="member">
                                            <option></option>
                                            @foreach($members as $member)
                                                <option
                                                    value="{{$member->idmember}}">{{pad($member->memnumb, 6)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="row">
                                        <input type="text" name="mem_name" id="mem_name" class="form-control" disabled>
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
                                            <option value="{{ $bank->idbank }}">{{pad($bank->bankcode, 6)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" name="bank_name" id="bank_name" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="checkno" class="col-md-3 control-label">@lang('label.checkno')</label>
                                <div class="col-md-9">
                                    <input type="text" name="checkno" id="checkno" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="amount" class="col-md-4 control-label">@lang('label.amount')</label>
                                <div class="col-md-8">
                                    <input type="text" id="checkamt" class="form-control text-right text-bold">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="opera" class="col-md-3 control-label">@lang('label.opera')</label>
                                <div class="col-md-9">
                                    <select class="form-control select2" name="opera" id="opera" disabled>
                                        @foreach($operas as $opera)
                                            @if ($opera->opercode == 4)
                                                <option value="{{ $opera->idoper }}"
                                                        selected>{{pad($opera->opercode, 3)}}
                                                    : @if ($emp->lang == 'fr') {{$opera->labelfr}} @else {{$opera->labeleng}} @endif
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12" id="tableInput">
                    <table
                        class="table table-striped table-hover table-condensed table-bordered table-responsive no-padding">
                        <thead>
                        <tr class="bg-purples">
                            <th>@lang('label.account')</th>
                            <th style="width: 20%">@lang('label.entitle')</th>
                            <th>@lang('label.opera')</th>
                            <th>@lang('label.available')</th>
                            <th>@lang('label.amount')</th>
                            <th>@lang('label.fees')</th>
                        </tr>
                        </thead>
                        <tbody id="mem_table">
                        </tbody>
                    </table>
                </div>

                <div class="col-md-11">
                    <table class="table table-responsive" id="tableInput">
                        <thead>
                        <tr class="text-bold text-blue bg-antiquewhite text-left">
                            <td class="text-right">@lang('label.totrans')</td>
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
        $('#member').change(function () {
            $.ajax({
                url: "{{ url('getMember') }}",
                method: 'get',
                data: {member: $(this).val()},
                success: function (member) {
                    if (member.surname === null) {
                        $('#mem_name').val(member.name);
                    } else {
                        $('#mem_name').val(member.name + ' ' + member.surname);
                    }
                    $('#nic').val(member.nic);
                    $('#pic').attr('src', member.pic);
                    $('#sign').attr('src', member.signature);

                    $.ajax({
                        url: "{{ url('getAccBalance') }}",
                        method: 'get',
                        data: {member: member.idmember},
                        success: function (accounts) {
                            let ordLine = '';
                            $.each(accounts, function (i, account) {
                                if (account.accabbr === 'O') {
                                    let available;
                                    let initbal = parseInt(account.initbal);
                                    let evebal = parseInt(account.evebal);

                                    let debit = $.parseJSON(
                                        $.ajax({
                                            url: "{{ url('getMemDebit') }}",
                                            method: 'get',
                                            data: {
                                                member: member.idmember,
                                                account: account.account,
                                            },
                                            dataType: 'json',
                                            async: false
                                        }).responseText
                                    );

                                    let credit = $.parseJSON(
                                        $.ajax({
                                            url: "{{ url('getMemCredit') }}",
                                            method: 'get',
                                            data: {
                                                member: member.idmember,
                                                account: account.account,
                                            },
                                            dataType: 'json',
                                            async: false
                                        }).responseText
                                    );

                                    if (evebal === 0) {
                                        available = -initbal + (debit - credit);
                                    } else {
                                        available = -evebal + (debit - credit);
                                    }

                                    ordLine += "<tr>" +
                                        "<td><input type='hidden' name='accounts[]' value='" + account.account + "'>" + account.accnumb + "</td>" +
                                        "<td>@if ($emp->lang == 'fr')" + account.labelfr + " @else " + account.labeleng + "@endif</td>" +
                                        "<td><input type='hidden' name='operations[]' value='" + account.operation + "'>" +
                                        "@if ($emp->lang == 'fr') RETRAIT CHÈQUE " + account.operfr + " @else CHECK OUT " + account.opereng + "@endif</td>" +
                                        "<td class='text-right'>" + money(Math.abs(available)) + "</td>" +
                                        "<td><input type='text' class='amount' name='amounts[]'></td>" +
                                        "<td><input type='text' class='fee' name='fees[]'></td>" +
                                        "</tr>";
                                    $('#mem_table').html(ordLine);
                                }
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
                    $('#bank_name').val(bank.ouracc + ' : ' + bank.name);
                }
            });
        });

        $(document).on('input', '#checkamt, .amount, .fee', function () {
            $(this).val(money($(this).val()));

            let sumAmt = 0;

            $('.amount, .fee').each(function () {
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
            let dif = parseInt(trimOver($('#diff').text(), null));

            if ((dif === 0) && (tot === amt)) {
                swal({
                        title: '@lang('sidebar.checkout')',
                        text: '@lang('confirm.cheout_text')',
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
                            $('#cheoutForm').submit();
                        }
                    }
                );
            } else {
                swal({
                        title: '@lang('sidebar.checkout')',
                        text: '@lang('confirm.cinerror_text')',
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
