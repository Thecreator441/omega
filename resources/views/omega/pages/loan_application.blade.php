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
            <form action="{{ url('loan_application/store') }}" method="POST" role="form" id="loanApplForm" class="needs-validation">
                {{ csrf_field() }}

                <div class="row">
                    <div class="row">
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="member" class="col-xl-1 col-lg-3 col-md-2 col-sm-2 control-label">@lang('label.member')<span class="text-red text-bold">*</span></label>
                                <div class="col-xl-11 col-lg-9 col-md-10 col-sm-10">
                                    <select class="form-control select2" name="member" id="member" required>
                                        <option value=""></option>
                                        @foreach($members as $member)
                                            <option value="{{$member->idmember}}">{{pad($member->memnumb, 6)}} : {{ $member->name }} {{ $member->surname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <label for="savings" class="col-xl-2 col-lg-4 col-md-4 col-sm-4 control-label">@lang('label.balance')</label>
                                <div class="col-xl-10 col-lg-8 col-md-8 col-sm-8">
                                    <input type="text" name="savings" id="savings" class="form-control text-bold text-right" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <label for="amount" class="col-xl-2 col-lg-4 col-md-4 col-sm-4 control-label">@lang('label.amount')</label>
                                <div class="col-xl-10 col-lg-8 col-md-8 col-sm-8">
                                    <input type="text" name="amount" id="amount" class="form-control text-bold text-right">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <label for="loan_type" class="col-xl-2 col-lg-4 col-md-4 col-sm-4 control-label">@lang('label.loan_type')</label>
                                <div class="col-xl-10 col-lg-8 col-md-8 col-sm-8">
                                    <select name="loan_type" id="loan_type" class="form-control select2">
                                        <option value=""></option>
                                        @foreach ($loan_types as $loan_type)
                                            <option value="{{$loan_type->idltype}}">{{pad($loan_type->lcode, 3)}} :
                                                @if ($emp->lang == 'fr') {{$loan_type->labelfr}} @else {{$loan_type->labeleng}} @endif </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                         <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <label for="loan_pur" class="col-xl-2 col-lg-4 col-md-4 col-sm-4 control-label">@lang('label.loan_pur')</label>
                                <div class="col-xl-10 col-lg-8 col-md-8 col-sm-8">
                                    <select name="loan_pur" id="loan_pur" class="form-control select2">
                                        <option value=""></option>
                                        @foreach ($loan_purs as $loan_pur)
                                            <option value="{{$loan_pur->idloanpur}}">{{pad($loan_pur->purcode, 3)}} :
                                                @if ($emp->lang == 'fr') {{$loan_pur->labelfr}} @else {{$loan_pur->labeleng}} @endif </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="amorti" class="col-xl-2 col-lg-4 col-md-4 col-sm-2 col-xs-4 control-label">@lang('label.amort')</label>
                                <div class="col-xl-10 col-lg-8 col-md-8 col-sm-10 col-xs-8">
                                    <select name="amorti" id="amorti" class="form-control select2">
                                        <option value="C" selected>@lang('label.constamort')</option>
                                        <option value="V">@lang('label.varamort')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-6">
                            <div class="form-group">
                                <label for="grace" class="col-xl-2 col-lg-4 col-md-4 col-sm-4 control-label">@lang('label.grace')</label>
                                <div class="col-xl-10 col-lg-8 col-md-8 col-sm-8">
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
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-6">
                            <div class="form-group">
                                <label for="period" class="col-xl-2 col-lg-4 col-md-4 col-sm-4 control-label">@lang('label.periodicity')</label>
                                <div class="col-xl-10 col-lg-8 col-md-8 col-sm-8">
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
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label for="int_rate" class="col-xl-2 col-lg-4 col-md-4 col-xs-6 control-label">@lang('label.monintrate')</label>
                                <div class="col-xl-10 col-lg-8 col-md-8 col-xs-6">
                                    <input type="text" name="int_rate" id="int_rate" class="form-control text-right">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-6">
                            <div class="form-group">
                                <label for="tax_rate" class="col-xl-2 col-lg-4 col-md-4 col-sm-4 control-label">@lang('label.taxrate')</label>
                                <div class="col-xl-10 col-lg-8 col-md-8 col-sm-8">
                                    <input type="text" name="tax_rate" id="tax_rate" class="form-control text-right">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-6">
                            <div class="form-group">
                                <label for="numb_inst" class="col-xl-2 col-lg-4 col-md-4 col-sm-4 control-label">@lang('label.noinstal')</label>
                                <div class="col-xl-10 col-lg-8 col-md-8 col-sm-8">
                                    <input type="text" name="numb_inst" id="numb_inst" class="form-control text-right">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label for="inst1" class="col-xl-2 col-lg-4 col-md-4 col-xs-6 control-label">@lang('label.inst1')</label>
                                <div class="col-xl-10 col-lg-8 col-md-8 col-xs-6">
                                    <input type="date" name="inst1" id="date" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-xl-1 col-lg-1 col-md-1"></div>
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label">@lang('label.guarant')</label>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-3 col-xs-6">
                                <div class="form-group">
                                    <div class="radio">
                                        <label for="fin"><input type="radio" name="guarantee" id="fin" value="F">@lang('label.fin')</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-3 col-xs-6">
                                <div class="form-group">
                                    <div class="radio">
                                        <label for="morg"><input type="radio" name="guarantee" id="morg" value="M">@lang('label.morg')</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <div class="radio">
                                        <label for="fin&morg"><input type="radio" name="guarantee" id="fin&morg" value="F&M">@lang('label.fin&morg')</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="tableInput">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div id="finance" style="display: none">
                                <div class="row" id="com" style="display: none">
                                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="comake" class="col-xl-1 col-lg-3 col-md-2 col-sm-2 control-label">@lang('label.comake')</label>
                                            <div class="col-xl-11 col-lg-9 col-md-10 col-sm-10">
                                                <select class="form-control select2" name="comake" id="comake" required>
                                                    <option value=""></option>
                                                    @foreach($members as $member)
                                                        <option value="{{$member->idmember}}">{{pad($member->memnumb, 6)}} : {{ $member->name }} {{ $member->surname }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-5 col-xs-6">
                                        <div class="form-group">
                                            <label for="comake_savings" class="col-xl-2 col-lg-4 col-md-4 col-sm-5 control-label">@lang('label.balance')</label>
                                            <div class="col-xl-10 col-lg-8 col-md-8 col-sm-7">
                                                <input type="text" name="comake_savings" id="comake_savings" class="form-control text-bold text-right" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-5 col-xs-6">
                                        <div class="form-group">
                                            <label for="comake_amount" class="col-xl-2 col-lg-4 col-md-4 col-sm-4 control-label">@lang('label.amount')</label>
                                            <div class="col-xl-10 col-lg-8 col-md-8 col-sm-8">
                                                <input type="text" name="comake_amount" id="comake_amount" class="form-control text-bold text-right">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-2 col-xs-12">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <button type="button" id="plus" class="btn btn-sm bg-green pull-right btn-raised fa fa-plus"></button>
                                                <button type="button" id="minus" class="btn btn-sm bg-red pull-right btn-raised fa fa-minus"></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="table-responsive">
                                        <table id="billet-data-table" class="table table-striped table-hover table-condensed table-bordered">
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th>@lang('label.comake')</th>
                                                <th>@lang('label.account')</th>
                                                <th>@lang('label.available')</th>
                                                <th>@lang('label.amount') @lang('label.blocked')</th>
                                            </tr>
                                            </thead>
                                            <tbody id="comakers">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div id="mortgage" style="display: none">
                                <div class="row">
                                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="mort_name" class="col-xl-1 col-lg-3 col-md-2 col-sm-2 control-label">@lang('label.name')</label>
                                            <div class="col-xl-11 col-lg-9 col-md-10 col-sm-10">
                                                <input type="text" id="mort_name" class="form-control mort_name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-5 col-xs-6">
                                        <div class="form-group">
                                            <label for="mort_nature" class="col-xl-2 col-lg-4 col-md-4 col-sm-5 control-label">@lang('label.nature')</label>
                                            <div class="col-xl-10 col-lg-8 col-md-8 col-sm-7">
                                                <select id="mort_nature" class="form-control mort_nature select2">
                                                    <option value=""></option>
                                                    <option value="Co">@lang('label.coporal')</option>
                                                    <option value="Ma">@lang('label.material')</option>
                                                    <option value="Mo">@lang('label.meuble')</option>
                                                    <option value="Im">@lang('label.immeuble')</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-5 col-xs-6">
                                        <div class="form-group">
                                            <label for="mort_amount" class="col-xl-2 col-lg-4 col-md-4 col-sm-4 control-label">@lang('label.amount')</label>
                                            <div class="col-xl-10 col-lg-8 col-md-8 col-sm-8">
                                                <input type="text" name="mort_amount" id="mort_amount" class="form-control text-bold text-right">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-2 col-xs-12">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <button type="button" id="plus2" class="btn btn-sm bg-green pull-right btn-raised fa fa-plus"></button>
                                                    <button type="button" id="minus2" class="btn btn-sm bg-red pull-right btn-raised fa fa-minus"></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="table-responsive">
                                        <table id="billet-data-table2" class="table table-striped table-hover table-condensed table-bordered">
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th>@lang('label.name')</th>
                                                <th>@lang('label.nature')s</th>
                                                <th>@lang('label.amount')s</th>
                                            </tr>
                                            </thead>
                                            <tbody id="mortgages">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                </div>

                <div class="row" id="tableInput2">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        {{-- <button type="submit" id="print" class="btn btn-sm bg-blue pull-right btn-raised fa fa-print"></button> --}}
                        <button type="button" id="simulation" class="btn btn-sm bg-green pull-right btn-raised fa fa-eye"></button>
                    </div>

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                            <table id="loan-data-table" class="table table-striped table-hover table-condensed table-bordered no-padding">
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

                <div class="row" id="tableInput3">
                    <div class="col-xl-11 col-lg-11 col-md-11 col-sm-11 col-xs-12">
                        <div class="table-responsive">
                            <table class="table">
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
                    </div>
                    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-xs-12">
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
            $('#date').val(installment_date($('#grace').val()));

            $('#finance').hide();
            $('#com').hide();
            $('#mortgage').hide();

            if ($('#comakers tr').length === 0) {
                $('#minus').attr('disabled', true);
            }

            if ($('#mortgages tr').length === 0) {
                $('#minus2').attr('disabled', true);
            }
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
                        $('#savings').val('');

                        savingsBalance(member.idmember, '#savings');
                    }
                });
            } else {
                $('#savings').val('');
            }
        });

        $('#amount, #comake_amount, #mort_amount').on('input', function () {
            $(this).val(money($(this).val()));
        });

        $('#grace').change(function () {
            $('#date').val(installment_date($(this).val()));
        });

        $('input[type="radio"]').click(function () {
            $(this).each(function () {
                if ($(this).is(':checked')) {
                    if ($(this).val() === 'F') {
                        $('#finance').show();
                        $('#com').show();
                        $('#mortgage').hide();
                        $('#mortgages').empty();
                        fillMember();
                        sumAmount();
                    } else if ($(this).val() === 'M') {
                        $('#comakers').empty();
                        $('#finance').hide();
                        $('#com').hide();
                        $('#mortgage').show();
                        sumAmount();
                    } else if ($(this).val() === 'F&M') {
                        $('#finance').show();
                        $('#com').show();
                        $('#mortgage').show();
                        fillMember();
                        sumAmount();
                    } else {
                        $('#mortgages').empty();
                        $('#comakers').empty();
                        $('#finance').hide();
                        $('#com').hide();
                        $('#mortgage').hide();
                        fillMember();
                        sumAmount();
                    }
                }
            })
        });

        $('#comake').change(function () {
            if (!isNaN($(this).val())) {
                $.ajax({
                    url: "{{ url('getMember') }}",
                    method: 'get',
                    data: {
                        member: $(this).val()
                    },
                    success: function (member) {
                        $('#comake_savings').val('');
                        savingsBalance(member.idmember, '#comake_savings');
                    }
                });
            } else {
                $('#comake_savings').val('');
            }
        });

        $('#plus').click(function () {
            let com = $('#comake');

            let comId = com.select2('data')[0]['id'];
            let comText = com.select2('data')[0]['text'];
            let loan_type = $('#loan_type').val();

            var accNumb = comText.split(':')[0];

            async function fillComakers() {
                const loanType = await getData('getLoanType?ltype=' + loan_type);
                const account = await getData('getMemAcc?member=' + comId + '&account=' + loanType.blockacc);
                let amt = $('#comake_amount');
                let ava = $('#comake_savings');

                let line = '<tr>' +
                    '<td class="text-center" style="width: 5%"><input type="checkbox" class="check"></td>' +
                    '<td><input type="hidden" name="comakers[]" value="' + comId + '">' + comText + '</td>' +
                    '<td><input type="hidden" name="coAccs[]" value="' + account.account + '">' + account.accnumb + '</td>' +
                    '<td class="text-right text-bold">' + ava.val() + '</td>' +
                    '<td class="text-right text-bold amounts"><input type="hidden" name="coAmts[]" value="' + trimOver(amt.val(), null) + '">' + amt.val() + '</td>' +
                    '</tr>';

                $('#comakers').append(line);
                ava.val('');
                amt.val('');
                sumAmount();
            }

            fillComakers();

            $('#minus').removeAttr('disabled');

            com.val('').select2();
            $('#comake_name').val('');
        });

        $('#plus2').click(function () {
            let name = $('#mort_name');
            let amt = $('#morgAmt');
            let nat = $('#mort_nature');

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
            line += '<td class="text-right text-bold amounts"><input type="hidden" name="mort_amounts[]" class="text-right" value="' + trimOver(amt.val(), null) + '">' + amt.val() + '</td>' +
                '</tr>';
            $('#mortgages').append(line);
            $('#minus2').removeAttr('disabled');

            name.val('');
            amt.val('');
            nat.val('');
            nat.select2().trigger('change');
            sumAmount();
        });

        $('#minus').hover(function () {
            if ($('#comakers tr').length === 1)
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
            if ($('#mortgages tr').length === 0)
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
            $('#comakers').empty();

            let mem = $('#member');

            let memId = mem.select2('data')[0]['id'];
            let memText = mem.select2('data')[0]['text'];
            let loan_type = $('#loan_type').val();

            async function fillComakers() {
                const loanType = await getData('getLoanType?ltype=' + loan_type);
                const account = await getData('getMemAcc?member=' + memId + '&account=' + loanType.blockacc);
                let ava = $('#availsavs').val();
                let amt = $('#amount').val();

                let line = '<tr>' +
                    '<td class="text-center" style="width: 5%"><input type="checkbox" class="check" disabled></td>' +
                    '<td><input type="hidden" name="comakers[]" value="' + memId + '">' + memText + '</td>' +
                    '<td><input type="hidden" name="coAccs[]" value="' + account.account + '">' + account.accnumb + '</td>' +
                    '<td class="text-right text-bold">' + ava + '</td>';

                if (parseInt(trimOver(ava, null)) < parseInt(trimOver(amt, null))) {
                    line += '<td class="text-right text-bold amounts">' +
                        '<input type="hidden" name="coAmts[]" value="' + parseInt(trimOver(ava, null)) + '">' + ava + '</td>';
                    $('#com').show();
                } else {
                    line += '<td class="text-right text-bold amounts">' +
                        '<input type="hidden" name="coAmts[]" value="' + parseInt(trimOver(amt, null)) + '">' + amt + '</td>';
                    $('#com').hide();
                }
                line += '<tr>';

                $('#comakers').append(line);
                sumAmount();
            }

            fillComakers();
        }

        async function savingsBalance(member, field) {
            $.ajax({
                url: "{{ url('getMemberSavingsBalance') }}",
                method: 'get',
                data: {
                    member: member
                },
                success: function (savings) {
                    console.log(savings);

                    $(field).val(money(parseInt(savings.ava - savings.block)));
                }
            });
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
            let amount = parseInt(trimOver($('#amount').val(), null));
            let dif = amount - sumAmt;
            let diff = $('#diff');
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

        $(document).on('click', '#simulation', function () {
            $('#loan-data-table').DataTable({
                destroy: true,
                paging: false,
                info: false,
                searching: false,
                responsive: true,
                ordering: false,
                FixedHeader: true,
                dom: 'lBfrtip',
                buttons: [
                        {
                            extend: 'copy',
                            text: '',
                            className: 'buttons-copy btn btn-sm bg-blue btn-raised fa fa-copy',
                            titleAttr: '@lang('label.copy')',
                            footer: true
                        },
                        {
                            extend: 'excel',
                            text: '',
                            className: 'buttons-excel btn btn-sm bg-blue btn-raised fa fa-file-excel-o',
                            titleAttr: '@lang('label.excel')',
                            footer: true
                        },
                        {
                            extend: 'pdf',
                            text: '',
                            className: 'buttons-pdf btn btn-sm bg-blue btn-raised fa fa-file-pdf-o',
                            titleAttr: '@lang('label.pdf')',
                            footer: true
                        },
                        {
                            extend: 'print',
                            text: '',
                            className: 'buttons-print btn btn-sm bg-blue btn-raised fa fa-print',
                            titleAttr: '@lang('label.print')',
                            footer: true
                        }
                    ],
                dom:
                    "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: false,
                language: {
                    url: "{{ asset("plugins/datatables/lang/$emp->lang.json") }}",
                },
                serverMethod: 'GET',
                ajax: {
                    url: "{{ url('loan_simulation_view') }}",
                    data: {
                        amount: $('#amount').val(),
                        numb_inst: $('#numb_inst').val(),
                        int_rate: $('#int_rate').val(),
                        tax_rate: $('#tax_rate').val(),
                        period: $('#period').val(),
                        inst1: $('#inst1').val(),
                        date: $('#date').val(),
                        amorti: $('#amorti').val()
                    },
                    datatype: 'json'
                },
                columns: [
                    {data: 'intallment', class: 'text-center'},
                    {data: 'capital', class: 'text-right text-bold'},
                    {data: 'amort_amt', class: 'text-right text-bold'},
                    {data: 'int_amt', class: 'text-right text-bold'},
                    {data: 'ann_amt', class: 'text-right text-bold'},
                    {data: 'tax_amt', class: 'text-right text-bold'},
                    {data: 'tot_amt', class: 'text-right text-bold'},
                    {data: 'date', class: 'text-center'}
                ],
            });
        });

        function submitForm() {
            let cust = $('#member').val();
            let diff = parseInt(trimOver($('#diff').text(), null));
            let tot = parseInt(trimOver($('#totrans').val(), null));
            let amt = parseInt(trimOver($('#amount').val(), null));
            
            if (diff === 0 && cust !== '' && tot === amt) {
                mySwal("{{ $title }}", '@lang('confirm.loan_application_text')', '@lang('confirm.no')', '@lang('confirm.yes')', '#loanApplForm');
            } else {
                myOSwal("{{ $title }}", '@lang('confirm.loan_application_error_text')', 'error');
            }
        }
    </script>
@stop
