<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.appli'))

@section('content')
    <div class="box">
        <div class="box-header">
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right fa fa-close" id="home"></button>
            </div>
        </div>
        <div class="box-body">
            <form action="{{ url('loan_application/store') }}" method="POST" role="form" id="lappForm">
                {{ csrf_field() }}
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="member" class="col-md-2 control-label">@lang('label.member')</label>
                                <div class="col-md-4">
                                    <select class="form-control select2" name="member" id="member">
                                        <option></option>
                                        @foreach($members as $member)
                                            <option
                                                value="{{$member->idmember}}">{{pad($member->memnumb, 6)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="mem_name" id="mem_name" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" id="availsavs" class="form-control text-right text-bold" disabled
                                           placeholder="@lang('label.availsavs')">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="loanamt" id="loanamt" placeholder="@lang('label.loanamt')"
                                           class="form-control text-right text-bold">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="loanty" class="col-md-2 control-label">@lang('label.loanty')</label>
                                <div class="col-md-4">
                                    <select name="loanty" id="loanty" class="form-control select2">
                                        <option></option>
                                        @foreach ($ltypes as $type)
                                            <option value="{{$type->idltype}}">{{pad($type->lcode, 3)}} :
                                                @if ($emp->lang == 'fr') {{$type->labelfr}} @else {{$type->labeleng}} @endif </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <label for="loanpur"
                                               class="col-md-5 control-label">@lang('label.loanpur')</label>
                                        <div class="col-md-7">
                                            <select name="loanpur" id="loanpur" class="form-control select2">
                                                <option></option>
                                                @foreach ($lpurs as $pur)
                                                    <option value="{{$pur->idloanpur}}">{{pad($pur->purcode, 3)}} :
                                                        @if ($emp->lang == 'fr') {{$pur->labelfr}} @else {{$pur->labeleng}} @endif </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
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
                    </div>

                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="period" class="col-md-2 control-label">@lang('label.periodicity')</label>
                                <div class="col-md-4">
                                    <select name="period" id="period" class="form-control select2">
                                        <option></option>
                                        <option value="D">@lang('label.daily')</option>
                                        <option value="W">@lang('label.weekly')</option>
                                        <option value="B">@lang('label.bimens')</option>
                                        <option value="M" selected>@lang('label.mens')</option>
                                        <option value="T">@lang('label.trim')</option>
                                        <option value="S">@lang('label.sem')</option>
                                        <option value="A">@lang('label.ann')</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <label for="grace" class="col-md-5 control-label">@lang('label.grace')</label>
                                        <div class="col-md-7">
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
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="numb_inst" class="col-md-4 control-label">@lang('label.noinstal')</label>
                                <div class="col-md-8">
                                    <input type="text" name="numb_inst" id="numb_inst" class="form-control text-right">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tax_rate" class="col-md-5 control-label">@lang('label.taxrate')</label>
                                <div class="col-md-7">
                                    <input type="text" name="tax_rate" id="tax_rate" class="form-control text-right">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="int_rate" class="col-md-7 control-label">@lang('label.monintrate')</label>
                                <div class="col-md-5">
                                    <input type="text" name="int_rate" id="int_rate" class="form-control text-right">
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
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="button" id="print"
                                            class="btn btn-sm bg-default pull-right btn-raised fa fa-print"></button>
                                    <button type="button" id="display"
                                            class="btn btn-sm bg-green pull-right btn-raised fa fa-eye"></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-1"></div>
                            <div class="col-md-2">
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        <label class="control-label">@lang('label.guarant')</label>
                                    </div>
                                </div>
                            </div>
{{--                            <div class="col-md-2">--}}
{{--                                <div class="radio">--}}
{{--                                    <label for="none">--}}
{{--                                        <input type="radio" name="guarantee" id="none" value="N"--}}
{{--                                               checked>@lang('label.none')--}}
{{--                                    </label>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="col-md-2">
                                <div class="radio">
                                    <label for="fin">
                                        <input type="radio" name="guarantee" id="fin" value="F">@lang('label.fin')
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="radio">
                                    <label for="morg">
                                        <input type="radio" name="guarantee" id="morg" value="M">@lang('label.morg')
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="radio">
                                    <label for="fin&morg">
                                        <input type="radio" name="guarantee" id="fin&morg"
                                               value="F&M">@lang('label.fin&morg')</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="finance" style="display: none">
                    <div class="box-header with-border" id="com" style="display: none">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="comake" class="col-md-2 control-label">@lang('label.comake')</label>
                                    <div class="col-md-4">
                                        <select id="comake" class="form-control select2">
                                            <option></option>
                                            @foreach($members as $member)
                                                <option
                                                    value="{{$member->idmember}}">{{pad($member->memnumb, 6)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" id="comake_name" class="form-control" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="text" id="comsavs" class="form-control text-right text-bold"
                                           placeholder="@lang('label.availsavs')" disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="col-md-12">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <input type="text" id="comAmt" placeholder="@lang('label.amount')"
                                                   class="form-control text-bold text-right">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row">
                                            <div class="form-group">
                                                <button type="button" id="minus"
                                                        class="btn btn-sm bg-red pull-right btn-raised fa fa-minus"></button>
                                                <button type="button" id="plus"
                                                        class="btn btn-sm bg-green pull-right btn-raised fa fa-plus"></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12" id="tableInput">
                        <table
                            class="table table-striped table-hover table-condensed table-responsive table-bordered">
                            <thead>
                            <tr>
                                <th colspan="2">@lang('label.comake')</th>
                                <th>@lang('label.account')</th>
                                <th>@lang('label.available')</th>
                                <th>@lang('label.amount')</th>
                            </tr>
                            </thead>
                            <tbody id="coMakers">
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="morgage" style="display: none">
                    <div class="box-header with-border">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="morgName" class="col-md-2 control-label">@lang('label.name')</label>
                                    <div class="col-md-10">
                                        <input type="text" id="morgName" class="form-control mortName">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select id="morgNature" class="form-control mortNature select2">
                                        <option value="0">@lang('label.nature')</option>
                                        <option value="Co">@lang('label.coporal')</option>
                                        <option value="Ma">@lang('label.material')</option>
                                        <option value="Mo">@lang('label.meuble')</option>
                                        <option value="Im">@lang('label.immeuble')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="col-md-12">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <input type="text" id="morgAmt" placeholder="@lang('label.amount')"
                                                   class="form-control mortAmt text-right text-bold">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row">
                                            <div class="form-group">
                                                <button type="button" id="minus2"
                                                        class="btn btn-sm bg-red pull-right btn-raised fa fa-minus"></button>
                                                <button type="button" id="plus2"
                                                        class="btn btn-sm bg-green pull-right btn-raised fa fa-plus"></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12" id="tableInput">
                        <table
                            class="table table-striped table-hover table-condensed table-responsive table-bordered">
                            <thead>
                            <tr>
                                <th colspan="2">@lang('label.name')</th>
                                <th>@lang('label.nature')s</th>
                                <th>@lang('label.amount')s</th>
                            </tr>
                            </thead>
                            <tbody id="morg_infos">
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="box-footer with-border">
                    <div class="row">
                        <div class="col-md-12">
                            <table
                                class="table table-bordered table-striped table-hover table-condensed table-responsive">
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
                                    <td><input type="text" name="amoAmt" id="amoAmt"
                                               class="text-bold text-blue text-right"
                                               readonly></td>
                                    <td><input type="text" name="intAmt" id="intAmt"
                                               class="text-bold text-blue text-right"
                                               readonly></td>
                                    <td><input type="text" name="annAmt" id="annAmt"
                                               class="text-bold text-blue text-right"
                                               readonly></td>
                                    <td><input type="text" name="taxAmt" id="taxAmt"
                                               class="text-bold text-blue text-right"
                                               readonly></td>
                                    <td><input type="text" name="totAmt" id="totAmt"
                                               class="text-bold text-blue text-right"
                                               readonly></td>
                                    <td></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-11">
                    <table class="table table-responsive" id="tableInput">
                        <thead>
                        <tr class="text-bold text-blue bg-antiquewhite text-left">
                            <td class="text-center">@lang('label.totrans')</td>
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
            $('#numb_inst').verifNumber();
            $('#tax_rate, #int_rate').verifTax();

            $('#date').val(formDate($('#grace').val()));

            $('#finance').hide();
            $('#com').hide();
            $('#morgage').hide();

            if ($('#coMakers tr').length === 0) {
                $('#minus').attr('disabled', true);
            }

            if ($('#morg_infos tr').length === 0) {
                $('#minus2').attr('disabled', true);
            }
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
                        data: {
                            member: member.idmember
                        },
                        success: function (accounts) {
                            $.each(accounts, function (i, account) {
                                if (account.accnumb.toString().slice(0, 6) === '373000') {
                                    let debit = getDebit(member.idmember, account.account);
                                    let credit = getCredit(member.idmember, account.account);

                                    let available;

                                    let initbal = parseInt(account.initbal);
                                    let evebal = parseInt(account.evebal);

                                    if (evebal === 0) {
                                        available = initbal - debit + credit;
                                    } else {
                                        available = evebal - debit + credit;
                                    }
                                    $('#availsavs').val(money(parseInt(available)));
                                }
                            });
                        }
                    });
                }
            });
        });

        $('#loanamt, #comAmt, #morgAmt').on('input', function () {
            $(this).val(money($(this).val()));
        });

        $('#grace').change(function () {
            $('#date').val(formDate($(this).val()));
        });

        $('input[type="radio"]').click(function () {
            $(this).each(function () {
                if ($(this).is(':checked')) {
                    if ($(this).val() === 'F') {
                        $('#finance').show();
                        $('#morgage').hide();
                        fillMember()
                    } else if ($(this).val() === 'M') {
                        $('#morg_infos').empty();
                        $('#finance').hide();
                        $('#com').hide();
                        $('#morgage').show();
                        sumAmount();
                    } else if ($(this).val() === 'F&M') {
                        $('#morg_infos').empty();
                        $('#finance').show();
                        $('#morgage').show();
                        fillMember();
                    } else if ($(this).val() === 'N') {
                        $('#morg_infos').empty();
                        $('#finance').hide();
                        $('#com').hide();
                        $('#morgage').hide();
                        fillMember();
                    }
                }
            })
        });

        $('#comake').change(function () {
            if ($(this).val() !== '') {
                $.ajax({
                    url: "{{ url('getMember') }}",
                    method: 'get',
                    data: {
                        member: $(this).val()
                    },
                    success: function (member) {
                        if (member.surname === null) {
                            $('#comake_name').val(member.name);
                        } else {
                            $('#comake_name').val(member.name + ' ' + member.surname);
                        }

                        $.ajax({
                            url: "{{ url('getAccBalance') }}",
                            method: 'get',
                            data: {
                                member: member.idmember
                            },
                            success: function (accounts) {
                                $.each(accounts, function (i, account) {
                                    if (account.accnumb.toString().slice(0, 6) === '373000') {
                                        let debit = getDebit(member.idmember, account.account);
                                        let credit = getCredit(member.idmember, account.account);

                                        let available;

                                        let initbal = parseInt(account.initbal);
                                        let evebal = parseInt(account.evebal);

                                        if (evebal === 0) {
                                            available = initbal - debit + credit;
                                        } else {
                                            available = evebal - debit + credit;
                                        }
                                        $('#comsavs').val(money(parseInt(available)));
                                    }
                                });
                            }
                        });
                    }
                });
            }
        });

        $('#plus').click(function () {
            let com = $('#comake');

            let comId = com.select2('data')[0]['id'];
            let comText = com.select2('data')[0]['text'];

            let line = '<tr>' +
                '<td class="text-center" style="width: 5%"><input type="checkbox" class="check"></td>' +
                '<td><input type="hidden" name="coMakers[]" value="' + comId + '">' + comText + '</td>';

            $.ajax({
                url: "{{ url('getAccBalance') }}",
                method: 'get',
                data: {
                    member: comId
                },
                success: function (accounts) {
                    let amt = $('#comAmt');
                    let ava = $('#comsavs');

                    $.each(accounts, function (i, account) {
                        if (account.accnumb.toString().slice(0, 6) === '373000') {
                            line += '<td><input type="hidden" name="coAccs[]" value="' + account.account + '">' + account.accnumb + '</td>';
                        }
                    });
                    line += '<td class="text-right text-bold">' + ava.val() + '</td>' +
                        '<td class="text-right text-bold amounts"><input type="hidden" name="coAmts[]" value="' + trimOver(amt.val(), null) + '">' + amt.val() + '</td>' +
                        '</tr>';
                    $('#coMakers').append(line);
                    ava.val('');
                    amt.val('');
                    sumAmount();
                }
            });
            $('#minus').removeAttr('disabled');

            com.val('');
            com.select2().trigger('change');
            $('#comake_name').val('');
        });

        $('#plus2').click(function () {
            let name = $('#morgName');
            let amt = $('#morgAmt');
            let nat = $('#morgNature');

            let natId = nat.select2('data')[0]['id'];
            let natText = nat.select2('data')[0]['text'];

            let line = '<tr>' +
                '<td class="text-center" style="width: 5%"><input type="checkbox" class="check2"></td>' +
                '<td><input type="hidden" name="mortNames[]" value="' + name.val() + '">' + name.val() + '</td>';
            if (isNaN(natId)) {
                line += '<td><input type="hidden" name="mortNatures[]" value="' + natId + '">' + natText + '</td>';
            } else {
                return false;
            }
            line += '<td class="text-right text-bold amounts"><input type="hidden" name="mortAmts[]" class="text-right" value="' + trimOver(amt.val(), null) + '">' + amt.val() + '</td>' +
                '</tr>';
            $('#morg_infos').append(line);
            $('#minus2').removeAttr('disabled');

            name.val('');
            amt.val('');
            nat.val('');
            nat.select2().trigger('change');
            sumAmount();
        });

        $('#minus').hover(function () {
            if ($('#coMakers tr').length === 1)
                $(this).attr('disabled', true);
        });

        $('#minus').click(function () {
            $('.check').each(function () {
                if ($(this).is(':checked'))
                    $(this).closest('tr').remove();

                $('#check').attr('checked', false);
            });

            sumAmount();
        });

        $('#minus2').hover(function () {
            if ($('#morg_infos tr').length === 0)
                $(this).attr('disabled', true);
        });

        $('#minus2').click(function () {
            $('.check2').each(function () {
                if ($(this).is(':checked'))
                    $(this).closest('tr').remove();

                $('#check2').attr('checked', false);
            });

            sumAmount();
        });

        function fillMember() {
            $('#coMakers').empty();

            let mem = $('#member');

            let memId = mem.select2('data')[0]['id'];
            let memText = mem.select2('data')[0]['text'];

            let line = '<tr>' +
                '<td class="text-center" style="width: 5%"><input type="checkbox" class="check" disabled></td>' +
                '<td><input type="hidden" name="coMakers[]" value="' + memId + '">' + memText + '</td>';
            $.ajax({
                url: "{{ url('getAccBalance') }}",
                method: 'get',
                data: {
                    member: memId
                },
                success: function (accounts) {
                    let ava = $('#availsavs').val();
                    let amt = $('#loanamt').val();

                    $.each(accounts, function (i, account) {
                        if (account.accnumb.toString().slice(0, 6) === '373000') {
                            line += '<td><input type="hidden" name="coAccs[]" value="' + account.account + '">' + account.accnumb + '</td>';
                        }
                    });
                    line += '<td class="text-right text-bold">' + ava + '</td>';

                    if (parseInt(trimOver(ava, null)) <= parseInt(trimOver(amt, null))) {
                        line += '<td class="text-right text-bold amounts">' +
                            '<input type="hidden" name="coAmts[]" value="' + parseInt(trimOver(ava, null)) + '">' + ava + '</td>';
                        $('#com').show();
                    } else {
                        line += '<td class="text-right text-bold amounts">' +
                            '<input type="hidden" name="coAmts[]" value="' + parseInt(trimOver(amt, null)) + '">' + amt + '</td>';
                        $('#com').hide();
                    }
                    line += '<tr>';
                    $('#coMakers').append(line);
                    sumAmount();
                }
            });
        }

        function getCredit(id, acc) {
            return $.parseJSON(
                $.ajax({
                    url: "{{ url('getMemCredit') }}",
                    method: 'get',
                    data: {
                        member: id,
                        account: acc,
                    },
                    dataType: 'json',
                    async: false
                }).responseText
            );
        }

        function getDebit(id, acc) {
            return $.parseJSON(
                $.ajax({
                    url: "{{ url('getMemDebit') }}",
                    method: 'get',
                    data: {
                        member: id,
                        account: acc,
                    },
                    dataType: 'json',
                    async: false
                }).responseText
            );
        }

        function sumAmount() {
            let sumAmt = 0;

            $('.amounts').each(function () {
                let amount = trimOver($(this).text(), null);
                if (parseInt(amount)) {
                    sumAmt += parseInt(amount);
                }
            });

            $('#totrans').val(money(sumAmt));
            let amount = parseInt(trimOver($('#loanamt').val(), null));
            let dif = amount - sumAmt;
            let diff = $('#diff');
            console.log(dif);
            if (dif > 0) {
                diff.attr('class', 'text-orange');
                diff.text(money(dif));
            } else if (dif === 0) {
                diff.attr('class', 'text-blue');
                diff.text(money(dif));
            } else if (dif < 0) {
                diff.attr('class', 'text-red');
                diff.text(money(dif));
            }
        }

        $(document).on('click', '#display', function () {
            let amt = parseInt(trimOver($('#loanamt').val(), null));
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

        $(document).on('click', '#save', function () {
            let tot = parseInt(trimOver($('#totrans').val(), null));
            let amt = parseInt(trimOver($('#loanamt').val(), null));
            let dif = parseInt(trimOver($('#diff').text(), null));

            if ((tot === amt) && (dif === 0)) {
                swal({
                        title: '@lang('sidebar.appli')',
                        text: '@lang('confirm.lapp_text')',
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
                            $('#lappForm').submit();
                        }
                    }
                );
            } else {
                swal({
                        title: '@lang('sidebar.appli')',
                        text: '@lang('confirm.lapperror_text')',
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
