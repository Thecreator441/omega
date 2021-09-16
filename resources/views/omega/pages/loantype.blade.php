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
<div class="box" id="form" style="display: none;">
    <div class="box-header with-border">
        <h3 class="box-title text-bold" id="title"> @lang('label.new_loan_type')</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-alert bg-red btn-sm pull-right" id="exitForm">
                <i class="fa fa-close"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        <form action="{{ route('loantype/store') }}" method="post" role="form" id="loan_typeForm" class="needs-validation">
            {{ csrf_field() }}

            <div class="row fillform">
                <input type="hidden" id="idloan_type" name="idloan_type" value="">

                <div class="row">
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col=xs-12">
                        <div class="form-group has-error">
                            <label for="loan_type_code" class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-3 control-label">@lang('label.code')<span class="text-red text-bold">*</span></label>
                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-9">
                                <input type="text" name="loan_type_code" id="loan_type_code" class="form-control text-right code_" value="{{ (int)$loan_types->count() + 1 }}" readonly required>
                                <div class="help-block">@lang('placeholder.code')</div>
                            </div>
                        </div>
                    </div>
                    @if($emp->lang == 'fr')
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <div class="form-group has-error">
                                <label for="labelfr" class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-3 control-label">@lang('label.loan_type_fr')<span class="text-red text-bold">*</span></label>
                                <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-9">
                                    <input type="text" class="form-control" name="labelfr" id="labelfr" required>
                                    <div class="help-block">@lang('placeholder.loan_type_fr')</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <div class="form-group has-error">
                                <label for="labeleng" class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-3 control-label">@lang('label.loan_type_eng')<span class="text-red text-bold">*</span></label>
                                <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-9">
                                    <input type="text" class="form-control" name="labeleng" id="labeleng" required>
                                    <div class="help-block">@lang('placeholder.loan_type_eng')</div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <div class="form-group has-error">
                                <label for="labeleng" class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-3 control-label">@lang('label.loan_type_eng')<span class="text-red text-bold">*</span></label>
                                <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-9">
                                    <input type="text" class="form-control" name="labeleng" id="labeleng" required>
                                    <div class="help-block">@lang('placeholder.loan_type_eng')</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <div class="form-group has-error">
                                <label for="labelfr" class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-3 control-label">@lang('label.loan_type_fr')<span class="text-red text-bold">*</span></label>
                                <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-9">
                                    <input type="text" class="form-control" name="labelfr" id="labelfr" required>
                                    <div class="help-block">@lang('placeholder.loan_type_fr')</div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <div class="form-group has-info">
                            <label for="loan_per" class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-3 control-label">@lang('label.loan_per')</label>
                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-9">
                                <select id="loan_per" name="loan_per" class="form-control select2">
                                    <option value="Al" selected>@lang('label.al_period')</option>
                                    <option value="D">@lang('label.daily')</option>
                                    <option value="W">@lang('label.weekly')</option>
                                    <option value="B">@lang('label.bimens')</option>
                                    <option value="M">@lang('label.mens')</option>
                                    <option value="T">@lang('label.trim')</option>
                                    <option value="S">@lang('label.sem')</option>
                                    <option value="A">@lang('label.ann')</option>
                                </select>
                                <div class="help-block">@lang('placeholder.loan_per')</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-6">
                        <div class="form-group has-info">
                            <label for="max_dur" class="col-xl-4 col-lg-4 col-md-4 col-sm-4 control-label">@lang('label.max_dur')</label>
                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
                                <input type="text" name="max_dur" id="max_dur" class="form-control digit text-right">
                                <div class="help-block">@lang('placeholder.max_dur')</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-6">
                        <div class="form-group has-info">
                            <label for="max_amt" class="col-xl-4 col-lg-4 col-md-4 col-sm-4 control-label">@lang('label.max_amt')</label>
                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
                                <input type="text" name="max_amt" id="max_amt" class="form-control amount text-right text-bold">
                                <div class="help-block">@lang('placeholder.max_amt')</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <div class="form-group has-info">
                            <label for="inst_pen_day_space" class="col-xl-4 col-lg-4 col-md-4 col-sm-4 control-label">@lang('label.inst_pen_day_space')</label>
                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
                                <input type="text" name="inst_pen_day_space" id="inst_pen_day_space" class="form-control digit text-right">
                                <div class="help-block">@lang('placeholder.inst_pen_day_space')</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="form-group has-error">
                            <label for="loan_acc" class="col-xl-3 col-lg-3 col-md-4 col-sm-4 control-label">@lang('label.loan_acc')<span class="text-red text-bold">*</span></label>
                            <div class="col-xl-9 col-lg-9 col-md-8 col-sm-8">
                                <select name="loan_acc" id="loan_acc" class="select2" required>
                                    <option value=""></option>
                                    @foreach ($accplans as $accplan)
                                        @if ($accplan->accabbr === 'Co')
                                            <option value="{{ $accplan->idaccplan }}">{{ substrWords($accplan->plan_code, 4) }} : @if($emp->lang == 'fr') {{ $accplan->labelfr }} @else {{ $accplan->labeleng }} @endif </option>
                                        @endif
                                    @endforeach
                                </select>
                                <div class="help-block">@lang('placeholder.loan_acc')</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="form-group has-error">
                            <label for="trans_acc" class="col-xl-3 col-lg-3 col-md-4 col-sm-4 control-label">@lang('label.trans_acc')<span class="text-red text-bold">*</span></label>
                            <div class="col-xl-9 col-lg-9 col-md-8 col-sm-8">
                                <select name="trans_acc" id="trans_acc" class="select2" required>
                                    <option value=""></option>
                                    @foreach ($accplans as $accplan)
                                        @if ($accplan->accabbr === 'Or' || $accplan->accabbr === 'Co')
                                            <option value="{{ $accplan->idaccplan }}">{{ substrWords($accplan->plan_code, 4) }} : @if($emp->lang == 'fr') {{ $accplan->labelfr }} @else {{ $accplan->labeleng }} @endif </option>
                                        @endif
                                    @endforeach
                                </select>
                                <div class="help-block">@lang('placeholder.trans_acc')</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="form-group has-error">
                            <label for="int_paid_acc" class="col-xl-4 col-lg-4 col-md-4 col-sm-4 control-label">@lang('label.int_paid_acc')<span class="text-red text-bold">*</span></label>
                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
                                <select name="int_paid_acc" id="int_paid_acc" class="select2" required>
                                    <option value=""></option>
                                    @foreach ($accplans as $accplan)
                                        <option value="{{ $accplan->idaccplan }}">{{ substrWords($accplan->plan_code, 6) }} : @if($emp->lang == 'fr') {{ $accplan->labelfr }} @else {{ $accplan->labeleng }} @endif </option>
                                    @endforeach
                                </select>
                                <div class="help-block">@lang('placeholder.int_paid_acc')</div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="form-group col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for="">@lang('label.seicomaker')</label>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-6">
                        <div class="form-group col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="checkbox">
                                <label for="seicomaker_Y">
                                    <input type="radio" name="seicomaker" value="Y" id="seicomaker_Y" class="seicomaker">&nbsp;&nbsp;
                                    @lang('label.yes')
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-6">
                        <div class="form-group col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="checkbox">
                                <label for="seicomaker_N">
                                    <input type="radio" name="seicomaker" value="N" id="seicomaker_N" class="seicomaker">&nbsp;&nbsp;
                                    @lang('label.no')
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2"></div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <div class="form-group col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for="">@lang('label.block_acc')</label>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-4">
                        <div class="form-group col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="checkbox">
                                <label for="none">
                                    <input type="radio" name="block_acc" value="N" id="none" class="block_acc">&nbsp;&nbsp;
                                    @lang('label.none')
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-8">
                        <div class="form-group col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="checkbox">
                                <label for="mem_acc">
                                    <input type="radio" name="block_acc" value="M" id="mem_acc" class="block_acc">&nbsp;&nbsp;
                                    @lang('label.mem_acc')
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <div class="form-group col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="checkbox">
                                <label for="mem&co">
                                    <input type="radio" name="block_acc" value="MC" id="mem&co" class="block_acc">&nbsp;&nbsp;
                                    @lang('label.mem&co')
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1"></div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <div class="form-group col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for="">@lang('label.pay_tax')</label>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <div class="form-group">
                            <label for="pay_tax_rate" class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-3 control-label">@lang('label.rate')</label>
                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-9">
                                <input type="text" name="pay_tax_rate" id="pay_tax_rate" class="rate form-control text-right">
                                <div class="help-block">@lang('placeholder.pay_tax_rate')</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-12">
                        <div class="form-group">
                            <label for="pay_tax_acc" class="col-xl-2 col-lg-2 col-md-2 col-sm-2 control-label">@lang('label.account')</label>
                            <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10">
                                <select name="pay_tax_acc" id="pay_tax_acc" class="form-control select2">
                                    <option value=""></option>
                                    @foreach($accplans as $accplan)
                                        <option value="{{ $accplan->idaccplan }}">
                                            {{ substrWords($accplan->plan_code, 6) }} : @if($emp->lang == 'fr') {{$accplan->labelfr}} @else {{$accplan->labeleng}} @endif
                                        </option>
                                    @endforeach
                                </select>
                                <div class="help-block">@lang('placeholder.pay_tax_acc')</div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <div class="form-group col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for="">@lang('label.use_quod')</label>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <div class="form-group">
                            <label for="use_quod_rate" class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-3 control-label">@lang('label.rate')</label>
                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-9">
                                <input type="text" name="use_quod_rate" id="use_quod_rate" class="rate form-control text-right">
                                <div class="help-block">@lang('placeholder.use_quod_rate')</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-12">
                        <div class="form-group">
                            <label for="use_quod_acc" class="col-xl-2 col-lg-2 col-md-2 col-sm-2 control-label">@lang('label.account')</label>
                            <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10">
                                <select name="use_quod_acc" id="use_quod_acc" class="form-control select2">
                                    <option value=""></option>
                                    @foreach($accplans as $accplan)
                                        <option value="{{ $accplan->idaccplan }}">
                                            {{ substrWords($accplan->plan_code, 6) }} : @if($emp->lang == 'fr') {{$accplan->labelfr}} @else {{$accplan->labeleng}} @endif
                                        </option>
                                    @endforeach
                                </select>
                                <div class="help-block">@lang('placeholder.use_quod_acc')</div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <div class="form-group col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for="">@lang('label.pen_req')</label>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <div class="form-group">
                            <label for="pen_req_tax" class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-3 control-label">@lang('label.tax')</label>
                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-9">
                                <input type="text" name="pen_req_tax" id="pen_req_tax" class="rate form-control text-right">
                                <div class="help-block">@lang('placeholder.pen_req_tax')</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-12">
                        <div class="form-group">
                            <label for="pen_req_acc" class="col-xl-2 col-lg-2 col-md-2 col-sm-2 control-label">@lang('label.account')</label>
                            <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10">
                                <select name="pen_req_acc" id="pen_req_acc" class="form-control select2">
                                    <option value=""></option>
                                    @foreach($accplans as $accplan)
                                        <option value="{{ $accplan->idaccplan }}">
                                            {{ substrWords($accplan->plan_code, 6) }} : @if($emp->lang == 'fr') {{$accplan->labelfr}} @else {{$accplan->labeleng}} @endif
                                        </option>
                                    @endforeach
                                </select>
                                <div class="help-block">@lang('placeholder.pen_req_acc')</div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button type="submit" id="save" class="btn btn-sm bg-blue pull-right fa fa-save btn-raised"></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title text-bold">{{ $title }}</h3>
        @if ($emp->level === 'B')
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-success bg-green btn-sm pull-right" id="new_loan_type">
                    <i class="fa fa-plus"></i>&nbsp;@lang('label.new_loan_type')
                </button>
            </div>
        @endif
    </div>
    <div class="box-body">
        <table id="admin-data-table" class="table table-condensed table-striped table-responsive table-hover table-responsive-xl table-bordered">
            <thead>
            <tr>
                <th>@lang('label.code')</th>
                <th>{{ $title }}</th>
                <th>@lang('label.loan_acc')</th>
                <th>@lang('label.trans_acc')</th>
                <th>@lang('label.int_paid_acc')</th>
                <th>@lang('label.loan_per')</th>
                <th>@lang('label.max_amt')</th>
                <th>@lang('label.date')</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($loan_types as $loan_type)
                <tr>
                    <td class="text-center">{{pad($loan_type->loan_type_code, 3)}}</td>
                    <td>@if($emp->lang == 'fr') {{ $loan_type->labelfr }} @else {{ $loan_type->labeleng }} @endif</td>
                    <td class="text-center">{{ $loan_type->laccnumb }}</td>
                    <td class="text-center">{{ $loan_type->taccnumb }}</td>
                    <td class="text-center">{{ $loan_type->iaccnumb }}</td>
                    <td>
                        @if ($loan_type->loan_per === 'D')
                            @lang('label.daily')
                        @elseif ($loan_type->loan_per === 'W')
                            @lang('label.weekly')
                        @elseif ($loan_type->loan_per === 'B')
                            @lang('label.bimens')
                        @elseif ($loan_type->loan_per === 'M')
                            @lang('label.mens')
                        @elseif ($loan_type->loan_per === 'T')
                            @lang('label.trim')
                        @elseif ($loan_type->loan_per === 'S')
                            @lang('label.sem')
                        @elseif ($loan_type->loan_per === 'A')
                            @lang('label.ann')
                        @else
                            @lang('label.al_period')
                        @endif
                    </td>
                    <td class="text-right text-bold">{{ money((int)$loan_type->max_amt) }}</td>
                    <td class="text-center">{{changeFormat($loan_type->created_at)}}</td>
                    <td class="text-center">
                        <button type="button" class="btn bg-green btn-sm fa fa-eye" onclick="view('{{$loan_type->idltype}}')"></button>
                        @if ($emp->level === 'B')
                            <button type="button" class="btn bg-aqua btn-sm fa fa-edit" onclick="edit('{{$loan_type->idltype}}')"></button>
                            <button type="button" class="btn bg-red btn-sm fa fa-trash-o" onclick="remove('{{$loan_type->idltype}}')"></button>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <form action="{{route('loantype/delete')}}" method="post" role="form" id="delForm" style="display: none">
            {{ csrf_field() }}
            <input type="hidden" name="loan_type" id="loan_type" value="">
        </form>
    </div>
</div>
@stop

@section('script')
    <script>
        $(document).ready(function () {
            $('.rate').verifTax();
        });

        $('.amount').on('input', function () {
            $(this).val(money($(this).val()));
        });

        $('.code_, .digit').on('input', function () {
            $(this).val(accounting.formatNumber($(this).val()).replace(/,/g, ''));
        });

        $('#new_loan_type').click(function () {
            in_out_form();

            $.ajax({
                url: "{{ url('getLoanTypes') }}",
                method: 'get',
                data: {
                    institution: "{{ $emp->institution }}",
                    branch: "{{ $emp->branch }}"
                },
                success: function (loan_typees) {
                    $('#loan_type_code').val(loan_typees.length + 1);
                }
            });

            $('#form').show();
        });

        function view(idloan_type) {
            setDisabled(true);

            $.ajax({
                url: "{{ url('getLoanType') }}",
                method: 'get',
                data: {
                    id: idloan_type
                },
                success: function (loan_type) {
                    $('#title').text("@if($emp->lang === 'fr') " + loan_type.labelfr + " @else " + loan_type.labeleng + "@endif");

                    $('#idloan_type').val(loan_type.idltype);
                    $('#loan_type_code').val(loan_type.loan_type_code);
                    $('#labeleng').val(loan_type.labeleng);
                    $('#labelfr').val(loan_type.labelfr);
                    $('#loan_per').val(loan_type.loan_per).select2();
                    $('#max_dur').val(loan_type.max_dur);
                    $('#max_amt').val(money(loan_type.max_amt));
                    $('#inst_pen_day_space').val(loan_type.inst_pen_day_space);

                    $.ajax({
                        url: "{{ url('getAccount') }}",
                        method: 'get',
                        data: {
                            id: loan_type.loan_acc
                        },
                        success: function (loan_Acc) {
                            $('#loan_acc').val(loan_Acc.idplan).select2();
                        }
                    });

                    $.ajax({
                        url: "{{ url('getAccount') }}",
                        method: 'get',
                        data: {
                            id: loan_type.trans_acc
                        },
                        success: function (trans_Acc) {
                            $('#trans_acc').val(trans_Acc.idplan).select2();
                        }
                    });

                    $.ajax({
                        url: "{{ url('getAccount') }}",
                        method: 'get',
                        data: {
                            id: loan_type.int_paid_acc
                        },
                        success: function (int_paid_Acc) {
                            $('#int_paid_acc').val(int_paid_Acc.idplan).select2();
                        }
                    });

                    $('.seicomaker').each(function () {
                        if ($(this).val() === loan_type.seicomaker) {
                            $(this).prop('checked', true)
                        } else {
                            $(this).prop('checked', false)
                        }
                    });

                    $('.block_acc').each(function () {
                        if ($(this).val() === loan_type.block_acc) {
                            $(this).prop('checked', true)
                        } else {
                            $(this).prop('checked', false)
                        }
                    });

                    if (parseInt(loan_type.pay_tax_rate) > 0 && loan_type.pay_tax_acc !== null) {
                        $('#pay_tax_rate').val(loan_type.pay_tax_rate);

                        $.ajax({
                            url: "{{ url('getAccount') }}",
                            method: 'get',
                            data: {
                                id: loan_type.pay_tax_acc
                            },
                            success: function (pay_tax_Acc) {
                                $('#pay_tax_acc').val(pay_tax_Acc.idplan).select2();
                            }
                        });
                    }

                    if (parseInt(loan_type.use_quod_rate) > 0 && loan_type.use_quod_acc !== null) {
                        $('#use_quod_rate').val(loan_type.use_quod_rate);

                        $.ajax({
                            url: "{{ url('getAccount') }}",
                            method: 'get',
                            data: {
                                id: loan_type.use_quod_acc
                            },
                            success: function (use_quod_Acc) {
                                $('#use_quod_acc').val(use_quod_Acc.idplan).select2();
                            }
                        });
                    }

                    if (parseInt(loan_type.pen_req_tax) > 0 && loan_type.pen_req_acc !== null) {
                        $('#pen_req_tax').val(loan_type.pen_req_tax);

                        $.ajax({
                            url: "{{ url('getAccount') }}",
                            method: 'get',
                            data: {
                                id: loan_type.pen_req_acc
                            },
                            success: function (pen_req_Acc) {
                                $('#pen_req_acc').val(pen_req_Acc.idplan).select2();
                            }
                        });
                    }
                    

                    $('#save').replaceWith('<button type="submit" id="save" class="btn btn-sm bg-aqua pull-right btn-raised fa fa-edit" style="display: none"></button>');
                    $('.edit').replaceWith('<button type="submit" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save" style="display: none"></button>');

                    $('#form').show();
                }
            });
        }

        function edit(idloan_type) {
            setDisabled(false);

            $.ajax({
                url: "{{ url('getLoanType') }}",
                method: 'get',
                data: {
                    id: idloan_type
                },
                success: function (loan_type) {
                    $('#title').text("@lang('label.edit') @if($emp->lang === 'fr') " + loan_type.labelfr + " @else " + loan_type.labeleng + "@endif");

                    $('#idloan_type').val(loan_type.idltype);
                    $('#loan_type_code').val(loan_type.loan_type_code);
                    $('#labeleng').val(loan_type.labeleng);
                    $('#labelfr').val(loan_type.labelfr);
                    $('#loan_per').val(loan_type.loan_per).select2();
                    $('#max_dur').val(loan_type.max_dur);
                    $('#max_amt').val(money(loan_type.max_amt));
                    $('#inst_pen_day_space').val(loan_type.inst_pen_day_space);

                    $.ajax({
                        url: "{{ url('getAccount') }}",
                        method: 'get',
                        data: {
                            id: loan_type.int_paid_acc
                        },
                        success: function (int_paid_Acc) {
                            $('#int_paid_acc').val(int_paid_Acc.idplan).select2();
                        }
                    });

                    $.ajax({
                        url: "{{ url('getAccount') }}",
                        method: 'get',
                        data: {
                            id: loan_type.loan_acc
                        },
                        success: function (loan_Acc) {
                            $('#loan_acc').val(loan_Acc.idplan).select2();
                        }
                    });

                    $('.seicomaker').each(function () {
                        if ($(this).val() === loan_type.seicomaker) {
                            $(this).prop('checked', true)
                        } else {
                            $(this).prop('checked', false)
                        }
                    });

                    $('.block_acc').each(function () {
                        if ($(this).val() === loan_type.block_acc) {
                            $(this).prop('checked', true)
                        } else {
                            $(this).prop('checked', false)
                        }
                    });

                    if (parseInt(loan_type.pay_tax_rate) > 0 && loan_type.pay_tax_acc !== null) {
                        $('#pay_tax_rate').val(loan_type.pay_tax_rate);

                        $.ajax({
                            url: "{{ url('getAccount') }}",
                            method: 'get',
                            data: {
                                id: loan_type.pay_tax_acc
                            },
                            success: function (pay_tax_Acc) {
                                $('#pay_tax_acc').val(pay_tax_Acc.idplan).select2();
                            }
                        });
                    }

                    if (parseInt(loan_type.use_quod_rate) > 0 && loan_type.use_quod_acc !== null) {
                        $('#use_quod_rate').val(loan_type.use_quod_rate);

                        $.ajax({
                            url: "{{ url('getAccount') }}",
                            method: 'get',
                            data: {
                                id: loan_type.use_quod_acc
                            },
                            success: function (use_quod_Acc) {
                                $('#use_quod_acc').val(use_quod_Acc.idplan).select2();
                            }
                        });
                    }

                    if (parseInt(loan_type.pen_req_tax) > 0 && loan_type.pen_req_acc !== null) {
                        $('#pen_req_tax').val(loan_type.pen_req_tax);

                        $.ajax({
                            url: "{{ url('getAccount') }}",
                            method: 'get',
                            data: {
                                id: loan_type.pen_req_acc
                            },
                            success: function (pen_req_Acc) {
                                $('#pen_req_acc').val(pen_req_Acc.idplan).select2();
                            }
                        });
                    }
                    
                    $('#save').replaceWith('<button type="button" id="edit" class="btn btn-sm bg-aqua pull-right btn-raised fa fa-edit edit"></button>');

                    $('#form').show();
                }
            });
        }

        function remove(idloan_type) {
            swal({
                icon: 'warning',
                title: "{{$title}}",
                text: "@lang('confirm.loan_type_del_text')",
                closeOnClickOutside: false,
                allowOutsideClick: false,
                closeOnEsc: false,
                buttons: {
                    cancel: {
                        text: " @lang('confirm.no')",
                        value: false,
                        visible: true,
                        closeModal: true,
                        className: "btn bg-red fa fa-close"
                    },
                    confirm: {
                        text: " @lang('confirm.yes')",
                        value: true,
                        visible: true,
                        closeModal: true,
                        className: "btn bg-green fa fa-check"
                    },
                },
            }).then(function (isConfirm) {
                if (isConfirm) {
                    $('#loan_type').val(idloan_type);
                    $('#delForm').submit();
                }
            });
        }

        $('#exitForm').click(function () {
            $('#form').hide();
            in_out_form();
        });

        $(document).on('click', '#save, .edit', function () {
            var text = "@lang('confirm.loan_type_edit_text')";
            if ($('#idloan_type').val() === '') {
                text = "@lang('confirm.loan_type_save_text')";
            }
                
            mySwal("{{$title}}", text, "@lang('confirm.no')", "@lang('confirm.yes')", '#loan_typeForm');
        });

        function in_out_form() {
            setDisabled(false);

            $('#title').text("@lang('label.new_loan_type')");
            $('#idloan_type').val('');
            $('.fillform :input').val('');
            $('.fillform :input[type="checkbox"]').prop('checked', false);
            $('.select2').val('').select2();
            $('.edit').replaceWith('<button type="button" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>');
        }
    </script>
@stop
