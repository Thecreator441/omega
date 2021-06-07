<?php
$emp = Session::get('employee');

$title = $menu->labeleng;
if ($emp->lang == 'fr') {
    $title = $menu->labelfr;
    App::setLocale('fr');
}
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')
    <div class="box" id="form" style="display: none;">
        <div class="box-header with-border">
            <h3 class="box-title text-bold" id="title"> @lang('label.new_acc_plan')</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right" id="exitForm">
                    <i class="fa fa-close"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <form action="{{ route('acc_plan/store') }}" method="post" role="form" id="acc_planForm" class="needs-validation">
                {{ csrf_field() }}

                <div class="fillform">
                    <input type="hidden" name="idaccplan" id="idaccplan">

                    <div class="box-header with-border">
                        <div class="row">
                            <div class="row">
                                <div class="row">
                                    <div class="col-md-2 col=xs-12">
                                        <div class="form-group">
                                            <label for="plan_code" class="col-md-4 col-xs-4 control-label">@lang('label.plan_code')</label>
                                            <div class="col-md-8 col-xs-8">
                                                <input type="text" name="plan_code" id="plan_code" class="form-control text-right code_">
                                            </div>
                                        </div>
                                    </div>
                                    @if($emp->lang == 'fr')
                                        <div class="col-md-5 col-xs-12">
                                            <div class="form-group has-error">
                                                <label for="labelfr" class="col-md-3 control-label">@lang('label.acc_plan_fr')<span class="text-red text-bold">*</span></label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" name="labelfr" id="labelfr" required>
                                                    <div class="help-block">@lang('placeholder.acc_plan_fr')</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5 col-xs-12">
                                            <div class="form-group has-error">
                                                <label for="labeleng" class="col-md-3 control-label">@lang('label.acc_plan_eng')<span class="text-red text-bold">*</span></label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" name="labeleng" id="labeleng" required>
                                                    <div class="help-block">@lang('placeholder.acc_plan_eng')</div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-md-5 col-xs-12">
                                            <div class="form-group has-error">
                                                <label for="labeleng" class="col-md-3 control-label">@lang('label.acc_plan_eng')<span class="text-red text-bold">*</span></label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" name="labeleng" id="labeleng" required>
                                                    <div class="help-block">@lang('placeholder.acc_plan_eng')</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5 col-xs-12">
                                            <div class="form-group has-error">
                                                <label for="labelfr" class="col-md-3 control-label">@lang('label.acc_plan_fr')<span class="text-red text-bold">*</span></label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" name="labelfr" id="labelfr" required>
                                                    <div class="help-block">@lang('placeholder.acc_plan_fr')</div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="row">
                                    <div class="col-md-7 col-xs-12">
                                        <div class="form-group">
                                            <label for="acc_type" class="col-md-3 control-label">@lang('label.acc_type')</label>
                                            <div class="col-md-9">
                                                <select name="acc_type" id="acc_type" class="form-control select2">
                                                    <option value=""></option>
                                                    @foreach ($acctypes as $acctype)
                                                        <option value="{{$acctype->idacctype}}">{{$acctype->accabbr}} : @if ($emp->lang == 'fr') {{$acctype->labelfr}} @else {{$acctype->labeleng}} @endif</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-xs-12">
                                        <div class="form-group">
                                            <label for="min_balance" class="col-md-4 control-label">@lang('label.min_balance')</label>
                                            <div class="col-md-8">
                                                <input type="text" name="min_balance" id="min_balance" class="form-control text-right text-bold minim">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4 col-xs-12">
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <label for="adm_amort_acc">@lang('label.adm_amort_acc')
                                                        &nbsp;&nbsp;<input type="checkbox" name="adm_amort_acc" value="Y" id="adm_amort_acc">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xs-12">
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <label for="cont_fron_inpu">@lang('label.cont_fron_inpu')
                                                        &nbsp;&nbsp;<input type="checkbox" name="cont_fron_inpu" value="Y" id="cont_fron_inpu">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xs-12">
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <label for="calc_comm">@lang('label.calc_comm')
                                                        &nbsp;&nbsp;<input type="checkbox" name="calc_comm" value="Y" id="calc_comm">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-3 col-xs-12">
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <label for="bala_group">@lang('label.bala_group')
                                                        &nbsp;&nbsp;<input type="checkbox" name="bala_group" value="Y" id="bala_group">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-xs-12">
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <label for="bila_group">@lang('label.bila_group')
                                                        &nbsp;&nbsp;<input type="checkbox" name="bila_group" value="Y" id="bila_group">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-xs-12">
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <label for="cont_debt">@lang('label.cont_debt')
                                                        &nbsp;&nbsp;<input type="checkbox" name="cont_debt" value="Y" id="cont_debt">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-xs-12">
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <label for="calc_int">@lang('label.calc_int')
                                                        &nbsp;&nbsp;<input type="checkbox" name="calc_int" value="Y" id="calc_int">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box-header with-border">
                        <div class="row">
                            <div class="row">
                                <div class="row">
                                    <div class="col-md-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="open_fee" class="col-md-6 control-label">@lang('label.openfee')</label>
                                            <div class="col-md-6">
                                                <input type="text" name="open_fee" id="open_fee" class="text-bold fee form-control text-right">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-xs-12">
                                        <div class="form-group">
                                            <label for="open_fee_acc" class="col-md-2 control-label">@lang('label.accont')</label>
                                            <div class="col-md-10">
                                                <select name="open_fee_acc" id="open_fee_acc" class="form-control select2">
                                                    <option value=""></option>
                                                    @foreach($accounts as $account)
                                                        <option value="{{ $account->idaccount }}">
                                                            {{ $account->accnumb }} : @if($emp->lang == 'fr') {{$account->labelfr}} @else {{$account->labeleng}} @endif
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="clos_fee" class="col-md-6 control-label">@lang('label.closefee')</label>
                                            <div class="col-md-6">
                                                <input type="text" name="clos_fee" id="clos_fee" class="text-bold fee form-control text-right">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-xs-12">
                                        <div class="form-group">
                                            <label for="clos_fee_acc" class="col-md-2 control-label">@lang('label.accont')</label>
                                            <div class="col-md-10">
                                                <select name="clos_fee_acc" id="clos_fee_acc" class="form-control select2">
                                                    <option value=""></option>
                                                    @foreach($accounts as $account)
                                                        <option value="{{ $account->idaccount }}">
                                                            {{ $account->accnumb }} : @if($emp->lang == 'fr') {{$account->labelfr}} @else {{$account->labeleng}} @endif
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box-header with-border">
                        <div class="row">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        <h3 class="row text-bold text-muted">@lang('label.commis')</h3>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2 col-xs-12">
                                    <div class="form-group">
                                        <input type="text" id="comis_names" class="form-control" placeholder="@if ($emp->lang == 'fr') Libelle Commission @else Commission @endif">
                                    </div>
                                </div>
                                <div class="col-md-2 col-xs-6">
                                    <div class="form-group">
                                        <label for="comis_rate" class="col-md-4 control-label">@lang('label.rate')</label>
                                        <div class="col-md-8">
                                            <input type="text" id="comis_rate" class="form-control rate text-right">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-xs-6">
                                    <div class="form-group">
                                        <label for="commis_min" class="col-md-4 control-label">@lang('label.minimum')</label>
                                        <div class="col-md-8">
                                            <input type="text" id="comis_min" class="text-bold form-control minim text-right">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5 col-xs-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="commis_acc" class="col-md-4 control-label">@lang('label.accont')</label>
                                            <div class="col-md-8">
                                                <select id="comis_acc" class="form-control select2">
                                                    <option value=""></option>
                                                    @foreach($accounts as $account)
                                                        <option value="{{ $account->idaccount }}">
                                                            {{ $account->accnumb }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-xs-12">
                                    <div class="box-tools pull-right">
                                        <button type="button" id="minus"
                                                class="btn btn-sm bg-red pull-right btn-raised fa fa-minus"></button>
                                        <button type="button" id="plus"
                                                class="btn btn-sm bg-green pull-right btn-raised fa fa-plus"></button>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-striped table-hover table-bordered table-condensed table-responsive no-padding">
                                        <thead>
                                        <tr>
                                            <th colspan="2">@lang('label.label')</th>
                                            <th>@lang('label.rate')</th>
                                            <th>@lang('label.minimum')</th>
                                            <th>@lang('label.accont')</th>
                                        </tr>
                                        </thead>
                                        <tbody id="commis">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box-header with-border">
                        <div class="row">
                            <div class="row">
                                <div class="col-md-12 col-xs-12">
                                    <div class="col-md-12 col-xs-12">
                                        <h3 class="row text-bold text-muted">@lang('label.interest')</h3>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2 col-xs-12">
                                    <div class="form-group">
                                        <label for="">@lang('label.debitor')</label>
                                    </div>
                                </div>
                                <div class="col-md-2 col-xs-6">
                                    <div class="form-group">
                                        <label for="int_debt_rate" class="col-md-4 control-label">@lang('label.rate')</label>
                                        <div class="col-md-8">
                                            <input type="text" name="int_debt_rate" id="int_debt_rate" class="rate form-control rate text-right">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-xs-6">
                                    <div class="form-group">
                                        <label for="int_debt_min" class="col-md-4 control-label">@lang('label.minimum')</label>
                                        <div class="col-md-8">
                                            <input type="text" name="int_debt_min" id="int_debt_min" class="text-bold form-control minim text-right">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5 col-xs-12">
                                    <div class="form-group">
                                        <label for="int_debt_acc" class="col-md-4 control-label">@lang('label.accont')</label>
                                        <div class="col-md-8">
                                            <select name="int_debt_acc" id="int_debt_acc" class="form-control select2">
                                                <option value=""></option>
                                                @foreach($accounts as $account)
                                                    <option value="{{ $account->idaccount }}">
                                                        {{ $account->accnumb }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2 col-xs-12">
                                    <div class="form-group">
                                        <label for="">@lang('label.creditor')</label>
                                    </div>
                                </div>
                                <div class="col-md-2 col-xs-12">
                                    <div class="form-group">
                                        <label for="int_cred_rate" class="col-md-4 control-label">@lang('label.rate')</label>
                                        <div class="col-md-8">
                                            <input type="text" name="int_cred_rate" id="int_cred_rate" class="rate form-control rate text-right">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-xs-12">
                                    <div class="form-group">
                                        <label for="int_cred_min" class="col-md-4 control-label">@lang('label.minimum')</label>
                                        <div class="col-md-8">
                                            <input type="text" name="int_cred_min" id="int_cred_min" class="text-bold form-control minim text-right">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5 col-xs-12">
                                    <div class="form-group">
                                        <label for="int_cred_acc" class="col-md-4 control-label">@lang('label.accont')</label>
                                        <div class="col-md-8">
                                            <select name="int_cred_acc" id="int_cred_acc" class="form-control select2">
                                                <option value=""></option>
                                                @foreach($accounts as $account)
                                                    <option value="{{ $account->idaccount }}">
                                                        {{ $account->accnumb }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box-header">
                        <div class="row">
                            <div class="row">
                                <div class="col-md-2 col-xs-12">
                                    <div class="form-group">
                                        <label for="">@lang('label.penwith')</label>
                                    </div>
                                </div>
                                <div class="col-md-2 col-xs-12">
                                    <div class="form-group">
                                        <label for="pen_with_rate" class="col-md-4 control-label">@lang('label.rate')</label>
                                        <div class="col-md-8">
                                            <input type="text" name="pen_with_rate" id="pen_with_rate" class="rate form-control text-right">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8 col-xs-12">
                                    <div class="form-group">
                                        <label for="pen_with_acc" class="col-md-2 control-label">@lang('label.accont')</label>
                                        <div class="col-md-10">
                                            <select name="pen_with_acc" id="pen_with_acc" class="form-control select2">
                                                <option value=""></option>
                                                @foreach($accounts as $account)
                                                    <option value="{{ $account->idaccount }}">
                                                        {{ $account->accnumb }} : @if($emp->lang == 'fr') {{$account->labelfr}} @else {{$account->labeleng}} @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <button type="button" id="save" class="btn btn-sm bg-blue pull-right fa fa-save btn-raised"></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold">{{$title}}</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-success bg-green btn-sm pull-right" id="new_acc_plan">
                    <i class="fa fa-plus"></i>&nbsp;@lang('label.new_acc_plan')
                </button>
            </div>
        </div>
        <div class="box-body">
            <table id="admin-data-table" class="table table-condensed table-striped table-responsive table-hover table-responsive-xl table-bordered">
                <thead>
                <tr>
                    <th>@lang('label.plan_code')</th>
                    <th style="width: 50%">{{ $title }}</th>
                    <th>@lang('label.acctype')</th>
                    <th>@lang('label.date')</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody id="acc_table">
                @foreach ($acc_plans as $acc_plan)
                    <tr>
                        <td class="text-center">{{$acc_plan->plan_code}}</td>
                        <td>@if($emp->lang == 'fr') {{$acc_plan->labelfr}} @else {{$acc_plan->labeleng}} @endif</td>
                        <td>@if($emp->lang == 'fr') {{$acc_plan->Atfr}} @else {{$acc_plan->Ateng}} @endif</td>
                        <td class="text-center">{{changeFormat($acc_plan->created_at)}}</td>
                        <td class="text-center">
                            <button class="btn btn-info bg-aqua btn-sm fa fa-edit" onclick="edit('{{$acc_plan->idaccplan}}')"></button>
                            <button type="button" class="btn bg-red btn-sm delete fa fa-trash-o" onclick="remove('{{$acc_plan->idaccplan}}')"></button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <form action="{{route('acc_plan/delete')}}" method="post" role="form" id="delForm" style="display: none">
                {{ csrf_field() }}
                <input type="hidden" name="acc_plan" id="acc_plan" value="">
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
        $(document).ready(function () {
            $('.rate').verifTax();
        });

        $('.minim, .fee').on('input', function () {
            $(this).val(money($(this).val()));
        });

        $('.code_').on('input', function () {
            $(this).val(accounting.formatNumber($(this).val()).replace(/,/g, ''));
        });

        $('#new_acc_plan').click(function () {
            in_out_form();
            $('#form').show();
        });

        $('#plus').click(function () {
            let name = $('#comis_names');
            let rate = $('#comis_rate');
            let min = $('#comis_min');
            let acc = $('#comis_acc');

            let accId = acc.select2('data')[0]['id'];
            let accText = acc.select2('data')[0]['text'];

            let line = '<tr>' +
                '<td class="text-center" style="width: 5%"><input type="checkbox" class="check"></td>' +
                '<td><input type="hidden" name="comis_names[]" value="' + name.val() + '">' + name.val() + '</td>' +
                '<td class="text-right"><input type="hidden" name="comis_rate[]" value="' + rate.val() + '">' + rate.val() + '</td>' +
                '<td class="text-right text-bold"><input type="hidden" name="comis_min[]" value="' + min.val() + '">' + min.val() + '</td>' +
                '<td class="text-center"><input type="hidden" name="comis_acc[]" value="' + accId + '">' + accText + '</td>' +
                '</tr>';

            if (name.val() !== null) {
                $('#commis').append(line);
                $('#minus').removeAttr('disabled');

                other_in_out();
            } else {
                name.focusin();
            }
        });

        $('#minus').click(function () {
            $('.check').each(function () {
                if ($(this).is(':checked'))
                    $(this).closest('tr').remove();
            });
        });

        $('#minus').hover(function () {
            if ($('#commis tr').length === 0)
                $(this).attr('disabled', true);
        });

        function edit(idacc_plan) {
            $.ajax({
                url: "{{ url('getAccPlan') }}",
                method: 'get',
                data: {
                    id: idacc_plan
                },
                success: function (acc_plan) {
                    $('#title').text("@lang('label.edit') @if($emp->lang === 'fr') " + acc_plan.labelfr + " @else " + acc_plan.labeleng + "@endif");

                    $('#idaccplan').val(acc_plan.idaccplan);
                    $('#plan_code').val(acc_plan.plan_code);
                    $('#acc_type').val(acc_plan.acc_type).select2();
                    $('#min_balance').val(money(acc_plan.min_balance));
                    $('#labeleng').val(acc_plan.labeleng);
                    $('#labelfr').val(acc_plan.labelfr);

                    if (acc_plan.calc_int === 'Y') {
                        $('#calc_int').prop('checked', true);
                    }
                    if (acc_plan.cont_debt === 'Y') {
                        $('#cont_debt').prop('checked', true);
                    }
                    if (acc_plan.bila_group === 'Y') {
                        $('#bila_group').prop('checked', true);
                    }
                    if (acc_plan.bala_group === 'Y') {
                        $('#bala_group').prop('checked', true);
                    }
                    if (acc_plan.calc_comm === 'Y') {
                        $('#calc_comm').prop('checked', true);
                    }
                    if (acc_plan.adm_amort_acc === 'Y') {
                        $('#adm_amort_acc').prop('checked', true);
                    }
                    if (acc_plan.cont_fron_inpu === 'Y') {
                        $('#cont_fron_inpu').prop('checked', true);
                    }

                    $('#open_fee').val(money(acc_plan.open_fee));
                    $('#open_fee_acc').val(acc_plan.open_fee_acc).select2();
                    $('#clos_fee').val(money(acc_plan.clos_fee));
                    $('#clos_fee_acc').val(acc_plan.clos_fee_acc).select2();

                    $.ajax({
                        url: "{{url('getAccPlanCommis')}}",
                        method: 'get',
                        data: {
                            acc_plan: acc_plan.idaccplan
                        },
                        success: function (commisions) {
                            let row = '';
                            if (parseInt(commisions.length) > 0) {
                                $.each(commisions, function (i, commision) {
                                    row += '<tr>' +
                                        '<td class="text-center" style="width: 5%"><input type="checkbox" class="check">' +
                                        '<input type="hidden" name="comis_id[]" value="' + commision.idcommis + '"></td>' +
                                        '<td><input type="hidden" name="comis_names[]" value="' + commision.label + '">' + commision.label + '</td>' +
                                        '<td class="text-right"><input type="hidden" name="comis_rate[]" value="' + commision.rate + '">' + commision.rate + '</td>' +
                                        '<td class="text-right text-bold"><input type="hidden" name="comis_min[]" value="' + money(commision.mins) + '">' + money(commision.mins) + '</td>' +
                                        '<td class="text-center"><input type="hidden" name="comis_acc[]" value="' + commision.label_acc + '">' + commision.accnumb + '</td>' +
                                        '</tr>';
                                });
                                $('#commis').html(row);
                                $('#minus').removeAttr('disabled');

                                other_in_out();
                            }
                        }
                    });

                    $('#int_debt_rate').val(acc_plan.int_debt_rate);
                    $('#int_debt_min').val(money(acc_plan.int_debt_min));
                    $('#int_debt_acc').val(acc_plan.int_debt_acc).select2();
                    $('#int_cred_rate').val(acc_plan.int_cred_rate);
                    $('#int_cred_min').val(money(acc_plan.int_cred_min));
                    $('#int_cred_acc').val(acc_plan.int_cred_acc).select2();

                    $('#pen_with_rate').val(acc_plan.pen_with_rate);
                    $('#pen_with_acc').val(acc_plan.pen_with_acc).select2();

                    $('#save').replaceWith('<button type="button" id="edit" class="btn btn-sm bg-aqua pull-right btn-raised fa fa-edit edit"></button>');

                    $('#form').show();
                }
            });
        }

        function remove(idacc_plan) {
            swal({
                icon: 'warning',
                title: "{{$title}}",
                text: '@lang('confirm.acc_plan_del_text')',
                closeOnClickOutside: false,
                allowOutsideClick: false,
                closeOnEsc: false,
                buttons: {
                    cancel: {
                        text: ' @lang('confirm.no')',
                        value: false,
                        visible: true,
                        closeModal: true,
                        className: "btn bg-red fa fa-close"
                    },
                    confirm: {
                        text: ' @lang('confirm.yes')',
                        value: true,
                        visible: true,
                        closeModal: true,
                        className: "btn bg-green fa fa-check"
                    },
                },
            }).then(function (isConfirm) {
                if (isConfirm) {
                    $('#acc_plan').val(idacc_plan);
                    $('#delForm').submit();
                }
            });
        }

        $('#exitForm').click(function () {
            $('#form').hide();
            in_out_form();
        });

        $(document).on('click', '#save, #edit', function () {
            let text = '';
            if ($('#idaccplan').val() === '')
                text = '@lang('confirm.accpsave_text')';
            else
                text = '@lang('confirm.accpedit_text')';

            mySwal("{{$title}}", text, '@lang('confirm.no')', '@lang('confirm.yes')', '#acc_planForm');
        });

        function in_out_form() {
            $('#title').text('@lang('label.new_acc_plan')');
            $('#idaccplan').val('');
            $('.fillform :input').val('');
            $('.fillform :input[type="checkbox"]').prop('checked', false);
            $('.select2').val('').select2();
            $('.edit').replaceWith('<button type="button" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>');
            other_in_out();
        }

        function other_in_out() {
            $('#comis_names').val('');
            $('#comis_rate').val('');
            $('#comis_min').val('');
            $('#comis_acc').val('').select2();
        }
    </script>
@stop

{{--
<div class="row">
    <div class="col-md-2 col-xs-6">
        <div class="form-group">
            <label for="">@lang('label.move')</label>
        </div>
    </div>
    <div class="col-md-2 col-xs-6">
        <div class="form-group">
            <label for="move_rate" class="col-md-4 control-label">@lang('label.rate')</label>
            <div class="col-md-8">
                <input type="text" name="move_rate" id="move_rate" class="form-control rate text-right">
            </div>
        </div>
    </div>
    <div class="col-md-3 col-xs-12">
        <div class="form-group">
            <label for="move_min" class="col-md-4 control-label">@lang('label.minimum')</label>
            <div class="col-md-8">
                <input type="text" name="move_min" id="move_min" class="text-bold form-control minim text-right">
            </div>
        </div>
    </div>
    <div class="col-md-5 col-xs-12">
        <div class="form-group">
            <label for="move_acc" class="col-md-4 control-label">@lang('label.accont')</label>
            <div class="col-md-8">
                <select name="move_acc" id="move_acc" class="form-control select2">
                    <option value=""></option>
                    @foreach($accounts as $account)
                        <option value="{{ $account->idaccount }}">
                            {{ $account->accnumb }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-2">
        <div class="form-group">
            <label for="">@lang('label.highover')</label>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="over_rate" class="col-md-4 control-label">@lang('label.rate')</label>
            <div class="col-md-8">
                <input type="text" name="over_rate" id="over_rate" class="form-control rate text-right">
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="over_min" class="col-md-4 control-label">@lang('label.minimum')</label>
            <div class="col-md-8">
                <input type="text" name="over_min" id="over_min" class="text-bold form-control minim text-right">
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group">
            <label for="over_acc" class="col-md-4 control-label">@lang('label.accont')</label>
            <div class="col-md-8">
                <select name="over_acc" id="over_acc" class="form-control select2">
                    <option value=""></option>
                    @foreach($accounts as $account)
                        <option value="{{ $account->idaccount }}">
                            {{ $account->accnumb }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>

$('#move_rate').val(param.move_rate);
$('#move_min').val(money(param.move_min));
$('#move_acc').val(param.move_acc).select2();
$('#over_rate').val(param.over_rate);
$('#over_min').val(money(param.over_min));
$('#over_acc').val(param.over_acc).select2();
--}}
