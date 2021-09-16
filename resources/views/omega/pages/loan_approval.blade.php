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
            <form action="{{ url('loan_approval/store') }}" method="POST" role="form" id="loanApprForm" class="needs-validation">
                {{csrf_field()}}
                
                <div class="row">
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="dem_loan" class="col-xl-2 col-lg-4 col-md-4 col-sm-2 col-xs-4 control-label">@lang('label.loan_no')<span class="text-red text-bold">*</span></label>
                                <div class="col-xl-10 col-lg-8 col-md-8 col-sm-10 col-xs-8">
                                    <select class="form-control select2" name="dem_loan" id="dem_loan" required>
                                        <option value=""></option>
                                        @foreach ($dem_loans as $dem_loan)
                                            <option value="{{$dem_loan->iddemloan}}">{{pad($dem_loan->demloanno, 6)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="member" class="col-xl-1 col-lg-3 col-md-2 col-sm-2 control-label">@lang('label.member')<span class="text-red text-bold">*</span></label>
                                <div class="col-xl-11 col-lg-9 col-md-10 col-sm-10">
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
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <label for="amount" class="col-xl-2 col-lg-4 col-md-4 col-sm-4 control-label">@lang('label.dem_amt')</label>
                                <div class="col-xl-10 col-lg-8 col-md-8 col-sm-8">
                                    <input type="text" name="loan_amt" id="loan_amt" class="form-control text-bold text-right" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <input type="text" name="amount" id="amount" placeholder="@lang('label.app_amt')" class="form-control text-bold text-right" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="employee" class="col-xl-1 col-lg-3 col-md-2 col-sm-2 control-label">@lang('label.loan_off')<span class="text-red text-bold">*</span></label>
                                <div class="col-xl-11 col-lg-9 col-md-10 col-sm-10">
                                    <select class="form-control select2" name="employee" id="employee" required disabled>
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
                                    <select name="loan_type" id="loan_type" class="form-control select2" required disabled>
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
                                    <select name="loan_pur" id="loan_pur" class="form-control select2" required disabled>
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
                                    <select name="amorti" id="amorti" class="form-control select2" required disabled>
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
                                    <select name="grace" id="grace" class="form-control select2" required disabled>
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
                                    <select name="period" id="period" class="form-control select2" required disabled>
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
                                    <input type="text" name="int_rate" id="int_rate" class="form-control text-right" required disabled>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-6">
                            <div class="form-group">
                                <label for="tax_rate" class="col-xl-2 col-lg-4 col-md-4 col-sm-4 control-label">@lang('label.taxrate')</label>
                                <div class="col-xl-10 col-lg-8 col-md-8 col-sm-8">
                                    <input type="text" name="tax_rate" id="tax_rate" class="form-control text-right" required disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-6">
                            <div class="form-group">
                                <label for="numb_inst" class="col-xl-2 col-lg-4 col-md-4 col-sm-4 control-label">@lang('label.noinstal')</label>
                                <div class="col-xl-10 col-lg-8 col-md-8 col-sm-8">
                                    <input type="text" name="numb_inst" id="numb_inst" class="form-control text-right" required disabled>
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
                                        <label for="fin"><input type="radio" name="guarantee" id="fin" value="F" disabled>@lang('label.fin')</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-3 col-xs-6">
                                <div class="form-group">
                                    <div class="radio">
                                        <label for="morg"><input type="radio" name="guarantee" id="morg" value="M" disabled>@lang('label.morg')</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <div class="radio">
                                        <label for="fin&morg"><input type="radio" name="guarantee" id="fin_morg" value="F&M" disabled>@lang('label.fin&morg')</label>
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
                                                <select class="form-control select2" id="comake" disabled>
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
                                                <select id="account" class="form-control select2" disabled>
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
                                                <input type="text" id="comake_savings" class="form-control text-bold text-right"  disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-5 col-xs-6">
                                        <div class="form-group">
                                            <label for="comake_amount" class="col-xl-2 col-lg-4 col-md-4 col-sm-4 control-label">@lang('label.amount')</label>
                                            <div class="col-xl-10 col-lg-8 col-md-8 col-sm-8">
                                                <input type="hidden" id="comake_amountOld">
                                                <input type="text" id="comake_amount" class="form-control text-bold text-right" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-2 col-xs-12">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <button type="button" id="com_minus" class="btn btn-sm bg-red pull-right btn-raised fa fa-minus" disabled></button>
                                                <button type="button" id="com_plus" class="btn btn-sm bg-green pull-right btn-raised fa fa-plus" disabled></button>
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
                                                <input type="text" id="mort_name" class="form-control mort_name" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-5 col-xs-6">
                                        <div class="form-group">
                                            <label for="mort_nature" class="col-xl-2 col-lg-4 col-md-4 col-sm-5 control-label">@lang('label.nature')</label>
                                            <div class="col-xl-10 col-lg-8 col-md-8 col-sm-7">
                                                <select id="mort_nature" class="form-control mort_nature select2" disabled>
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
                                                <input type="text" id="mort_amount" class="form-control text-bold text-right" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-2 col-xs-12">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <button type="button" id="mort_plus" class="btn btn-sm bg-green pull-right btn-raised fa fa-plus" disabled></button>
                                                    <button type="button" id="mort_minus" class="btn btn-sm bg-red pull-right btn-raised fa fa-minus" disabled></button>
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
                                                                  id="totrans" disabled></td>
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
        });

        $('#amount').on('input', function () {
            $(this).val(money($(this).val()));

            sumAmount();
        });

        $('#dem_loan').change(function () {
            if (!isNaN($(this).val())) {
                $.ajax({
                    url: "{{ url('getAppliedLoan') }}",
                    method: 'get',
                    data: {
                        dem_loan: $(this).val()
                    },
                    success: function (response) {
                        var dem_loan = response.data;

                        $('#member').val(dem_loan.member).select2();
                        $('#loan_amt').val(money(parseInt(dem_loan.amount)));
                        $('#amount').val(money(parseInt(dem_loan.amount)));
                        $('#employee').val(dem_loan.employee).select2();
                        $('#loan_type').val(dem_loan.loantype).select2();
                        $('#loan_pur').val(dem_loan.loanpur).select2();
                        $('#amorti').val(dem_loan.amortype).select2();
                        $('#grace').val(dem_loan.grace).select2();
                        $('#period').val(dem_loan.periodicity).select2();
                        $('#int_rate').val(dem_loan.intrate);
                        $('#tax_rate').val(dem_loan.vat);
                        $('#numb_inst').val(parseInt(dem_loan.nbrinst));
                        {{-- $('#date').val(dem_loan.instdate1); --}}

                        var guarantee = dem_loan.guarantee

                        if (guarantee === 'F') {
                            $('#fin').prop('checked', true);
                            $('#morg').prop('checked', false);
                            $('#fin_morg').prop('checked', false);
                            $('#finance').show();
                            $('#mortgage').hide();
                        }
                        if (guarantee === 'M') {
                            $('#fin').prop('checked', false);
                            $('#morg').prop('checked', true);
                            $('#fin_morg').prop('checked', false);
                            $('#finance').hide();
                            $('#mortgage').show();
                        }
                        if (guarantee === 'F&M') {
                            $('#fin').prop('checked', false);
                            $('#morg').prop('checked', false);
                            $('#fin_morg').prop('checked', true);
                            $('#finance').show();
                            $('#mortgage').show();
                        }

                        if (guarantee === 'F' || guarantee === 'F&M') {
                            var comakers = dem_loan.comakers;

                            if (parseInt(comakers.length) > 0) {
                                var comake_line;
                                $.each(comakers, function (i, comaker) {
                                    comake_line += '<tr>' +
                                                '<td class="text-center" style="width: 5%"><input type="checkbox" class="check" disabled></td>' +
                                                '<td>' + comaker.M_name + ' ' + comaker.M_surname + '</td>' +
                                                '<td class="text-center">' + comaker.accnumb + '</td>' +
                                                '<td class="text-right text-bold">' + money(parseInt(comaker.guaramt)) + '</td>' +
                                                '<td class="text-right text-bold amounts">' + money(parseInt(comaker.guaramt)) + '</td>' +
                                            '</tr>';
                                });

                                $('#comakers').html(comake_line);
                            }
                        }
                        if (guarantee === 'M' || guarantee === 'F&M') {
                            var mortgages = dem_loan.mortgages;

                            if (parseInt(mortgages.length) > 0) {
                                var mortgage_line;
                                $.each(mortgages, function (i, mortgage) {
                                    var nature = "@lang('label.others')";
                                    if (mortgage.nature === "B") {
                                        nature = "@lang('label.immeuble')";
                                    } else if (mortgage.nature === "C") {
                                        nature = "@lang('label.coporal')";
                                    } else if (mortgage.nature === "D") {
                                        nature = "@lang('label.meuble')";
                                    } else if (mortgage.nature === "M") {
                                        nature = "@lang('label.material')";
                                    }

                                    mortgage_line += '<tr>' +
                                                '<td class="text-center" style="width: 5%"><input type="checkbox" class="check2" disabled></td>' +
                                                '<td>' + mortgage.name + '</td>' +
                                                '<td>' + nature + '</td>' +
                                                '<td class="text-right text-bold amounts">' + money(parseInt(mortgage.amount)) + '</td>' +
                                            '</tr>'
                                });

                                $('#mortgages').html(mortgage_line);
                            }
                        }
                        
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
                                    amount: dem_loan.amount,
                                    numb_inst: parseInt(dem_loan.nbrinst),
                                    int_rate: dem_loan.intrate,
                                    tax_rate: dem_loan.vat,
                                    period: dem_loan.periodicity,
                                    date: $('#date').val(),
                                    amorti: dem_loan.amortype
                                },
                                datatype: 'json'
                            },
                            columns: [
                                {data: 'installment', class: 'text-center',
                                    render: function(data, type, row) {
                                        if (row.installment !== null) {
                                            return '<input type="hidden" name="installs[]" value="' + row.installment + '">' + row.installment;
                                        }
                                        return '';
                                    }
                                },
                                {data: 'capital', class: 'text-right text-bold', 
                                    render: function(data, type, row) {
                                        if (parseInt(row.capital) !== 0) {
                                            return '<input type="hidden" name="capitals[]" value="' + row.capital + '">' + row.capital;
                                        }
                                        return row.capital;
                                    }
                                },
                                {data: 'amort_amt', class: 'text-right text-bold', 
                                    render: function(data, type, row) {
                                        if (parseInt(row.amort_amt) !== 0) {
                                            return '<input type="hidden" name="amo_amts[]" value="' + row.amort_amt + '">' + row.amort_amt;
                                        }
                                        return row.amort_amt;
                                    }
                                },
                                {data: 'int_amt', class: 'text-right text-bold', 
                                    render: function(data, type, row) {
                                        if (parseInt(row.int_amt) !== 0) {
                                            return '<input type="hidden" name="int_amts[]" value="' + row.int_amt + '">' + row.int_amt;
                                        }
                                        return row.int_amt;
                                    }
                                },
                                {data: 'ann_amt', class: 'text-right text-bold', 
                                    render: function(data, type, row) {
                                        if (parseInt(row.ann_amt) !== 0) {
                                            return '<input type="hidden" name="ann_amts[]" value="' + row.ann_amt + '">' + row.ann_amt;
                                        }
                                        return row.ann_amt;
                                    }
                                },
                                {data: 'tax_amt', class: 'text-right text-bold', 
                                    render: function(data, type, row) {
                                        if (parseInt(row.tax_amt) !== 0) {
                                            return '<input type="hidden" name="tax_amts[]" value="' + row.tax_amt + '">' + row.tax_amt;
                                        }
                                        return row.tax_amt;
                                    }
                                },
                                {data: 'tot_amt', class: 'text-right text-bold', 
                                    render: function(data, type, row) {
                                        if (parseInt(row.tot_amt) !== 0) {
                                            return '<input type="hidden" name="tot_amts[]" value="' + row.tot_amt + '">' + row.tot_amt;
                                        }
                                        return row.tot_amt;
                                    }
                                },
                                {data: 'date', class: 'text-center',
                                    render: function(data, type, row) {
                                        if (row.date !== null) {
                                            return '<input type="hidden" name="dates[]" value="' + row.date + '">' + row.date;
                                        }
                                        return '';
                                    }
                                }
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

                        sumAmount();
                    }
                });
            }
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
                    {data: 'installment', class: 'text-center',
                        render: function(data, type, row) {
                            return '<input type="hidden" name="installs[]" value="' + parseInt(trimOver(row.installment, null)) + '">' + row.installment;
                        }
                    },
                    {data: 'capital', class: 'text-right text-bold', 
                        render: function(data, type, row) {
                            return '<input type="hidden" name="capitals[]" value="' + parseInt(trimOver(row.capital, null)) + '">' + row.capital;
                        }
                    },
                    {data: 'amort_amt', class: 'text-right text-bold', 
                        render: function(data, type, row) {
                            return '<input type="hidden" name="amo_amts[]" value="' + parseInt(trimOver(row.amort_amt, null)) + '">' + row.amort_amt;
                        }
                    },
                    {data: 'int_amt', class: 'text-right text-bold', 
                        render: function(data, type, row) {
                            return '<input type="hidden" name="int_amts[]" value="' + parseInt(trimOver(row.int_amt, null)) + '">' + row.int_amt;
                        }
                    },
                    {data: 'ann_amt', class: 'text-right text-bold', 
                        render: function(data, type, row) {
                            return '<input type="hidden" name="ann_amts[]" value="' + parseInt(trimOver(row.ann_amt, null)) + '">' + row.ann_amt;
                        }
                    },
                    {data: 'tax_amt', class: 'text-right text-bold', 
                        render: function(data, type, row) {
                            return '<input type="hidden" name="tax_amts[]" value="' + parseInt(trimOver(row.tax_amt, null)) + '">' + row.tax_amt;
                        }
                    },
                    {data: 'tot_amt', class: 'text-right text-bold', 
                        render: function(data, type, row) {
                            return '<input type="hidden" name="tot_amts[]" value="' + parseInt(trimOver(row.tot_amt, null)) + '">' + row.tot_amt;
                        }
                    },
                    {data: 'date', class: 'text-center',
                        render: function(data, type, row) {
                            return '<input type="hidden" name="dates[]" value="' + row.date + '">' + row.date;
                        }
                    }
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
            $('#loan-data-table').DataTable().destroy();

            let cust = $('#member').val();
            let diff = parseInt(trimOver($('#diff').text(), null));
            let tot = parseInt(trimOver($('#totrans').val(), null));
            let amt = parseInt(trimOver($('#amount').val(), null));

            if (cust !== '') {
                mySwal("{{ $title }}", "@lang('confirm.loan_approval_text')", "@lang('confirm.no')", "@lang('confirm.yes')", '#loanApprForm');
            } else {
                myOSwal("{{ $title }}", "@lang('confirm.loan_approval_error_text')", 'error');
            }
        }
    </script>
@stop
