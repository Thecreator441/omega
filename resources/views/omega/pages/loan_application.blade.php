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
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <input type="text" name="amount" id="amount" placeholder="@lang('label.loan_amt')" class="form-control text-bold text-right" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="employee" class="col-xl-1 col-lg-3 col-md-2 col-sm-2 control-label">@lang('label.loan_off')<span class="text-red text-bold">*</span></label>
                                <div class="col-xl-11 col-lg-9 col-md-10 col-sm-10">
                                    <select class="form-control select2" name="employee" id="employee" required>
                                        <option value=""></option>
                                        @foreach($employees as $employee)
                                            <option value="{{$employee->idemp}}">{{pad($employee->empmat, 6)}} : {{ $employee->name }} {{ $employee->surname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <label for="loan_type" class="col-xl-2 col-lg-4 col-md-4 col-sm-4 control-label">@lang('label.loan_type')<span class="text-red text-bold">*</span></label>
                                <div class="col-xl-10 col-lg-8 col-md-8 col-sm-8">
                                    <select name="loan_type" id="loan_type" class="form-control select2" required>
                                        <option value=""></option>
                                        @foreach ($loan_types as $loan_type)
                                            <option value="{{$loan_type->idltype}}">{{pad($loan_type->loan_type_code, 3)}} :
                                                @if ($emp->lang == 'fr') {{$loan_type->labelfr}} @else {{$loan_type->labeleng}} @endif </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                         <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <label for="loan_pur" class="col-xl-2 col-lg-4 col-md-4 col-sm-4 control-label">@lang('label.loan_pur')<span class="text-red text-bold">*</span></label>
                                <div class="col-xl-10 col-lg-8 col-md-8 col-sm-8">
                                    <select name="loan_pur" id="loan_pur" class="form-control select2" required>
                                        <option value=""></option>
                                        @foreach ($loan_purs as $loan_pur)
                                            <option value="{{$loan_pur->idloanpur}}">@if ($emp->lang == 'fr') {{$loan_pur->labelfr}} @else {{$loan_pur->labeleng}} @endif </option>
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
                                <label for="date" class="col-xl-2 col-lg-4 col-md-4 col-xs-6 control-label">@lang('label.inst1')</label>
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
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="comake" class="col-xl-1 col-lg-2 col-md-2 col-sm-2 control-label">@lang('label.comake')</label>
                                            <div class="col-xl-11 col-lg-10 col-md-10 col-sm-10">
                                                <select class="form-control select2" id="comake">
                                                    <option value=""></option>
                                                    @foreach($members as $member)
                                                        <option value="{{$member->idmember}}">{{pad($member->memnumb, 6)}} : {{ $member->name }} {{ $member->surname }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="account" class="col-xl-1 col-lg-2 col-md-2 col-sm-2 control-label">@lang('label.account')</label>
                                            <div class="col-xl-11 col-lg-10 col-md-10 col-sm-10">
                                                <select id="account" class="form-control select2">
                                                    <option value=""></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-5 col-xs-6">
                                        <div class="form-group">
                                            <label for="comake_savings" class="col-xl-2 col-lg-4 col-md-4 col-sm-5 control-label">@lang('label.balance')</label>
                                            <div class="col-xl-10 col-lg-8 col-md-8 col-sm-7">
                                                <input type="text" id="comake_savings" class="form-control text-bold text-right" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-5 col-xs-6">
                                        <div class="form-group">
                                            <label for="comake_amount" class="col-xl-2 col-lg-4 col-md-4 col-sm-4 control-label">@lang('label.amount')</label>
                                            <div class="col-xl-10 col-lg-8 col-md-8 col-sm-8">
                                                <input type="hidden" id="comake_amountOld">
                                                <input type="text" id="comake_amount" class="form-control text-bold text-right">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-2 col-xs-12">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <button type="button" id="com_minus" class="btn btn-sm bg-red pull-right btn-raised fa fa-minus"></button>
                                                <button type="button" id="com_plus" class="btn btn-sm bg-green pull-right btn-raised fa fa-plus"></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="table-responsive">
                                        <table class="table billet-data-table table-striped table-hover table-condensed table-bordered">
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
                                                    <option value="B">@lang('label.immeuble')</option>
                                                    <option value="C">@lang('label.coporal')</option>
                                                    <option value="F">@lang('label.meuble')</option>
                                                    <option value="M">@lang('label.material')</option>
                                                    <option value="O">@lang('label.others')</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-5 col-xs-6">
                                        <div class="form-group">
                                            <label for="mort_amount" class="col-xl-2 col-lg-4 col-md-4 col-sm-4 control-label">@lang('label.amount')</label>
                                            <div class="col-xl-10 col-lg-8 col-md-8 col-sm-8">
                                                <input type="text" id="mort_amount" class="form-control text-bold text-right">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-2 col-xs-12">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <button type="button" id="mort_plus" class="btn btn-sm bg-green pull-right btn-raised fa fa-plus"></button>
                                                    <button type="button" id="mort_minus" class="btn btn-sm bg-red pull-right btn-raised fa fa-minus"></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="table-responsive">
                                        <table class="table billet-data-table table-striped table-hover table-condensed table-bordered">
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
                        <button type="button" id="preview" class="btn btn-sm bg-green pull-right btn-raised fa fa-eye"></button>
                    </div>

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                            <table class="table loan-data-table table-striped table-hover table-condensed table-bordered no-padding">
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
                                <tfoot class="bg-antiquewhite">
                                    <tr>
                                        <th colspan="2"></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
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
            $('#mortgage').hide();

            if ($('#comakers tr').length === 0) {
                $('#com_minus').attr('disabled', true);
            }

            if ($('#mortgages tr').length === 0) {
                $('#mort_minus').attr('disabled', true);
            }
        });

        $('#member').change(function () {
            if (!isNaN($(this).val())) {
                $('#fin').prop('checked', true);
                $('#finance').show();

                $('#comake').val($(this).val()).trigger('change');
            }
        });

        $('#comake').change(function () {
            if (!isNaN($(this).val())) {
                $.ajax({
                    url: "{{ url('getMemCashOutBals') }}",
                    method: 'get',
                    data: {
                        member: $(this).val()
                    },
                    success: function (accounts) {
                        let option = "<option value=''></option>";
                        $.each(accounts.data, function (i, account) {
                            option += "<option " +
                                "value=" + account.account + ">" + account.accnumb + " : @if($emp->lang == 'fr') " + account.acclabelfr + " @else " + account.acclabeleng + " @endif</option>";
                        });
                        $('#account').html(option);
                    }
                });
            } else {
                $('#account').html("<option value=''></option>");
            }
        });

        $('#account').change(function () {
            if (!isNaN($(this).val())) {
                $.ajax({
                    url: "{{ url('getMemCashOutBals') }}",
                    method: 'get',
                    data: {
                        member: $('#comake').val(),
                        acctype: 'Or'
                    },
                    success: function (balances) {
                        let savings = 0;
                        $.each(balances.data, function (i, balance) {
                            if (parseInt(balance.account) === parseInt($('#account').val())) {
                                savings += (parseInt(balance.available) - parseInt(balance.block_amt));
                            }
                        });

                        $('#comake_savings').val(money(savings));
                    }
                });
            } else {
                $('#comake_savings').val('');
            }
        });

        $('#amount, #comake_amount, #mort_amount').on('input', function () {
            $(this).val(money($(this).val()));
        });

        $('#comake_amount').on('input', function () {
            var comake_savings = parseInt(trimOver($('#comake_savings').val(), null));
            var comake_amount = parseInt(trimOver($('#comake_amount').val(), null));

            if (comake_savings > comake_amount) {
                $("#comake_amountOld").val(comake_amount);
                $('#comake_amount').val(money(comake_amount));
            } else {
                $("#comake_amount").val(money(trimOver($("#comake_amountOld").val(), null)));
        
                myOSwal("{{ $title }}", "@lang('sidebar.small_account_balance')", 'error');
                $('#comake_amount').focusin();
            }
        });

        $('#grace').change(function () {
            $('#date').val(installment_date($(this).val()));
        });

        $('input[type="radio"]').click(function () {
            $(this).each(function () {
                if ($(this).is(':checked')) {
                    if ($(this).val() === 'F') {
                        $('#finance').show();
                        $('#mortgage').hide();
                        $('#mortgages').empty();
                        sumAmount();
                    } else if ($(this).val() === 'M') {
                        $('#finance').hide();
                        $('#mortgage').show();
                        sumAmount();
                    } else if ($(this).val() === 'F&M') {
                        $('#finance').show();
                        $('#mortgage').show();
                        sumAmount();
                    } else {
                        $('#mortgages').empty();
                        $('#comakers').empty();
                        $('#finance').hide();
                        $('#mortgage').hide();
                        sumAmount();
                    }
                }
            })
        });

        $('#com_plus').click(function () {
            var comake_key = $('#comake').select2('data')[0]['id'];
            var comake_value = $('#comake').select2('data')[0]['text'];

            var account_key = $('#account').select2('data')[0]['id'];
            var account_value = $('#account').select2('data')[0]['text'].split(':');

            var line = $('<tr>' +
                '<td class="text-center" style="width: 5%"><input type="checkbox" class="check"></td>' +
                '<td><input type="hidden" name="comakers[]" value="' + comake_key + '">' + comake_value + '</td>' +
                '<td class="text-center"><input type="hidden" name="comake_accs[]" value="' + account_key + '">' + account_value[0] + '</td>' +
                '<td class="text-right text-bold">' + $('#comake_savings').val() + '</td>' +
                '<td class="text-right text-bold amounts"><input type="hidden" name="comake_amounts[]" value="' + trimOver($('#comake_amount').val(), null) + '">' + $('#comake_amount').val() + '</td>' +
                '</tr>');

            billet_data_table.row.add(line[0]).draw();

            $('#comake_savings').val('');
            $('#comake_amount').val('');

            sumAmount();

            $('#com_minus').prop('disabled', false);
            $('#comake').val('').select2();
            $('#account').html("<option value=''></option>");
            $('#comake_savings').val('');
        });

        $('#mort_plus').click(function () {
            var nature_Id = $('#mort_nature').select2('data')[0]['id'];
            var nature_Text = $('#mort_nature').select2('data')[0]['text'];

            var line = $('<tr>' +
                            '<td class="text-center" style="width: 5%"><input type="checkbox" class="check2"></td>' +
                            '<td><input type="hidden" name="mort_names[]" value="' + $('#mort_name').val() + '">' + $('#mort_name').val() + '</td>' +
                            '<td><input type="hidden" name="mort_natures[]" value="' + nature_Id + '">' + nature_Text + '</td>' +
                            '<td class="text-right text-bold amounts"><input type="hidden" name="mort_amounts[]" value="' + trimOver($('#mort_amount').val(), null) + '">' + $('#mort_amount').val() + '</td>' +
                        '</tr>');

            billet_data_table2.row.add(line[0]).draw();

            $('#mort_minus').prop('disabled', false);

            $('#mort_name').val('');
            $('#mort_amount').val('');
            $('#mort_nature').val('').select2();

            sumAmount();
        });

        $('#com_minus').hover(function () {
            if ($('#comakers tr').length === 1)
                $(this).attr('disabled', true);
        });

        $('#com_minus').click(function () {
            $('.check').each(function () {
                if ($(this).is(':checked'))
                    billet_data_table.row($(this).parents('tr')).remove().draw();

                $('#check').attr('checked', false);
            });

            sumAmount();
        });

        $('#mort_minus').hover(function () {
            if ($('#mortgages tr').length === 0)
                $(this).attr('disabled', true);
        });

        $('#mort_minus').click(function () {
            $('.check2').each(function () {
                if ($(this).is(':checked'))
                    billet_data_table2.row($(this).parents('tr')).remove().draw();

                $('#check2').attr('checked', false);
            });

            sumAmount();
        });

        function sumAmount() {
            var sumAmt = 0;

            $('.amounts').each(function () {
                var amount = trimOver($(this).text(), null);
                if (parseInt(amount)) {
                    sumAmt += parseInt(amount);
                }
            });

            $('#totrans').val(money(sumAmt));
            var amount = parseInt(trimOver($('#amount').val(), null));
            var dif = amount - sumAmt;
            var diff = $('#diff');
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

        $(document).on('click', '#preview', function () {
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
                    url: "{{ url('getLoanSimulationPreview') }}",
                    data: {
                        amount: $('#amount').val(),
                        numb_inst: $('#numb_inst').val(),
                        int_rate: $('#int_rate').val(),
                        tax_rate: $('#tax_rate').val(),
                        period: $('#period').val(),
                        date: $('#date').val(),
                        amorti: $('#amorti').val()
                    },
                    datatype: 'json'
                },
                columns: [
                    {data: 'installment', class: 'text-center'},
                    {data: 'capital', class: 'text-right text-bold'},
                    {data: 'amort_amt', class: 'text-right text-bold'},
                    {data: 'int_amt', class: 'text-right text-bold'},
                    {data: 'ann_amt', class: 'text-right text-bold'},
                    {data: 'tax_amt', class: 'text-right text-bold'},
                    {data: 'tot_amt', class: 'text-right text-bold'},
                    {data: 'date', class: 'text-center'}
                ],
                footerCallback: function (row, data, start, end, display) {
                    var api = this.api(), api;
                    
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                        var type = typeof i;
                        
                        if(type === 'string') {
                            i = parseInt(trimOver(i, null));
                        } else if (type === 'number') {
                            i = parseInt(i);
                        } else {
                            i = 0;
                        }
                        return i;
                    };
                    
                    var totAmo = api
                        .column(2, {page: 'all'})
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                    }, 0);
                        
                    var totInt = api
                        .column(3, {page: 'all'})
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                    }, 0);
                        
                    var totAnn = api
                        .column(4, {page: 'all'})
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                    }, 0);
                            
                    var totVAT = api
                        .column(5, {page: 'all'})
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                    }, 0);
                            
                    var totTot = api
                        .column(6, {page: 'all'})
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                    }, 0);

                    $(api.column(2).footer()).html(money(totAmo));
                    $(api.column(3).footer()).html(money(totInt));
                    $(api.column(4).footer()).html(money(totAnn));
                    $(api.column(5).footer()).html(money(totVAT));
                    $(api.column(6).footer()).html(money(totTot));
                }
            });
        });

        function submitForm() {
            let cust = $('#member').val();
            let diff = parseInt(trimOver($('#diff').text(), null));
            let tot = parseInt(trimOver($('#totrans').val(), null));
            let amt = parseInt(trimOver($('#amount').val(), null));

            if (diff === 0 && cust !== '' && tot === amt) {
                mySwal("{{ $title }}", "@lang('confirm.loan_application_text')", "@lang('confirm.no')", "@lang('confirm.yes')", '#loanApplForm');
            } else {
                myOSwal("{{ $title }}", "@lang('confirm.loan_application_error_text')", 'error');
            }
        }
    </script>
@stop
