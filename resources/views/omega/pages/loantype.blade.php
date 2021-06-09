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
<div class="box" id="form" style="display: block;">
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

            <div class="fillform">
                <input type="hidden" id="idloan_type" name="idloan_type" value="">

                <div class="row">
                    <div class="col-md-2 col=xs-12">
                        <div class="form-group has-error">
                            <label for="loan_type_code" class="col-md-4 col-xs-3 control-label">@lang('label.code')<span class="text-red text-bold">*</span></label>
                            <div class="col-md-8 col-xs-9">
                                <input type="text" name="loan_type_code" id="loan_type_code" class="form-control text-right code_" value="{{ (int)$loan_types->count() + 1 }}" readonly required>
                                <div class="help-block">@lang('placeholder.code')</div>
                            </div>
                        </div>
                    </div>
                    @if($emp->lang == 'fr')
                        <div class="col-md-5 col-xs-12">
                            <div class="form-group has-error">
                                <label for="labelfr" class="col-md-2 control-label">@lang('label.loan_type_fr')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="labelfr" id="labelfr" required>
                                    <div class="help-block">@lang('placeholder.loan_type_fr')</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 col-xs-12">
                            <div class="form-group has-error">
                                <label for="labeleng" class="col-md-2 control-label">@lang('label.loan_type_eng')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="labeleng" id="labeleng" required>
                                    <div class="help-block">@lang('placeholder.loan_type_eng')</div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-md-5 col-xs-12">
                            <div class="form-group has-error">
                                <label for="labeleng" class="col-md-2 control-label">@lang('label.loan_type_eng')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="labeleng" id="labeleng" required>
                                    <div class="help-block">@lang('placeholder.loan_type_eng')</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 col-xs-12">
                            <div class="form-group has-error">
                                <label for="labelfr" class="col-md-2 control-label">@lang('label.loan_type_fr')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="labelfr" id="labelfr" required>
                                    <div class="help-block">@lang('placeholder.loan_type_fr')</div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="row">
                    <div class="col-md-3 col-xs-12">
                        <div class="form-group has-info">
                            <label for="loan_per" class="col-md-4 col-xs-3 control-label">@lang('label.loan_per')</label>
                            <div class="col-md-8 col-xs-9">
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
                    <div class="col-md-3 col-xs-6">
                        <div class="form-group has-info">
                            <label for="max_dur" class="col-md-6 control-label">@lang('label.max_dur')</label>
                            <div class="col-md-6">
                                <input type="text" name="max_dur" id="max_dur" class="form-control text-right">
                                <div class="help-block">@lang('placeholder.max_dur')</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="form-group has-info">
                            <label for="max_amt" class="col-md-5 control-label">@lang('label.max_amt')</label>
                            <div class="col-md-7">
                                <input type="text" name="max_amt" id="max_amt" class="form-control text-right text-bold">
                                <div class="help-block">@lang('placeholder.max_amt')</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="form-group has-info">
                            <label for="inst_pen_day_space" class="col-md-8 control-label">@lang('label.inst_pen_day_space')</label>
                            <div class="col-md-4">
                                <input type="text" name="inst_pen_day_space" id="inst_pen_day_space" class="form-control text-right">
                                <div class="help-block">@lang('placeholder.inst_pen_day_space')</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-7 col-xs-12">
                        <div class="form-group has-error">
                            <label for="int_paid_acc" class="col-md-4 control-label">@lang('label.int_paid_acc')<span class="text-red text-bold">*</span></label>
                            <div class="col-md-8">
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
                    <div class="col-md-5 col-xs-6">
                        <div class="form-group has-error">
                            <label for="loan_acc" class="col-md-4 control-label">@lang('label.loan_acc')<span class="text-red text-bold">*</span></label>
                            <div class="col-md-8">
                                <select name="loan_acc" id="loan_acc" class="select2" required>
                                    <option value=""></option>
                                    @foreach ($accplans as $accplan)
                                        @if ($accplan->accabbr === 'Co')
                                            <option value="{{ $accplan->idaccplan }}">{{ substrWords($accplan->plan_code, 6) }} : @if($emp->lang == 'fr') {{ $accplan->labelfr }} @else {{ $accplan->labeleng }} @endif </option>
                                        @endif
                                    @endforeach
                                </select>
                                <div class="help-block">@lang('placeholder.loan_acc')</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-header with-border">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-4 col-xs-12">
                                <div class="form-group col-md-12">
                                    <label for="">@lang('label.seicomaker')</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-xs-6">
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label for="seicomaker_Y">
                                            <input type="radio" name="seicomaker" value="Y" id="seicomaker_Y" class="">&nbsp;&nbsp;
                                            @lang('label.yes')
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-xs-6">
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label for="seicomaker_N">
                                            <input type="radio" name="seicomaker" value="N" id="seicomaker_N" class="">&nbsp;&nbsp;
                                            @lang('label.no')
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                    </div>
                </div>

                <div class="box-header with-border">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-3 col-xs-12">
                                <div class="form-group col-md-12">
                                    <label for="">@lang('label.block_acc')</label>
                                </div>
                            </div>
                            <div class="col-md-2 col-xs-6">
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label for="none">
                                            <input type="radio" name="block_acc" value="N" id="none" class="">&nbsp;&nbsp;
                                            @lang('label.none')
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-xs-6">
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label for="mem_acc">
                                            <input type="radio" name="block_acc" value="M" id="mem_acc" class="">&nbsp;&nbsp;
                                            @lang('label.mem_acc')
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-xs-12">
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label for="mem&co">
                                            <input type="radio" name="block_acc" value="MC" id="mem&co" class="">&nbsp;&nbsp;
                                            @lang('label.mem&co')
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                    </div>
                </div>

                <div class="box-header with-border">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-2 col-xs-12">
                                <div class="form-group col-md-12">
                                    <label for="">@lang('label.pay_tax')</label>
                                </div>
                            </div>
                            <div class="col-md-2 col-xs-12">
                                <div class="form-group">
                                    <label for="pay_tax_rate" class="col-md-4 control-label">@lang('label.rate')</label>
                                    <div class="col-md-8">
                                        <input type="text" name="pay_tax_rate" id="pay_tax_rate" class="rate form-control text-right">
                                        <div class="help-block">@lang('placeholder.pay_tax_rate')</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 col-xs-12">
                                <div class="form-group">
                                    <label for="pay_tax_acc" class="col-md-2 control-label">@lang('label.account')</label>
                                    <div class="col-md-10">
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
                    </div>
                </div>

                <div class="box-header with-border">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-2 col-xs-12">
                                <div class="form-group col-md-12">
                                    <label for="">@lang('label.use_quod')</label>
                                </div>
                            </div>
                            <div class="col-md-2 col-xs-12">
                                <div class="form-group">
                                    <label for="use_quod_rate" class="col-md-4 control-label">@lang('label.rate')</label>
                                    <div class="col-md-8">
                                        <input type="text" name="use_quod_rate" id="use_quod_rate" class="rate form-control text-right">
                                        <div class="help-block">@lang('placeholder.use_quod_rate')</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 col-xs-12">
                                <div class="form-group">
                                    <label for="use_quod_acc" class="col-md-2 control-label">@lang('label.account')</label>
                                    <div class="col-md-10">
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
                    </div>
                </div>

                <div class="box-header">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-2 col-xs-12">
                                <div class="form-group col-md-12">
                                    <label for="">@lang('label.pen_req')</label>
                                </div>
                            </div>
                            <div class="col-md-2 col-xs-12">
                                <div class="form-group">
                                    <label for="pen_req_tax" class="col-md-4 control-label">@lang('label.tax')</label>
                                    <div class="col-md-8">
                                        <input type="text" name="pen_req_tax" id="pen_req_tax" class="rate form-control text-right">
                                        <div class="help-block">@lang('placeholder.pen_req_tax')</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 col-xs-12">
                                <div class="form-group">
                                    <label for="pen_req_acc" class="col-md-2 control-label">@lang('label.account')</label>
                                    <div class="col-md-10">
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
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <button type="submit" id="save" class="btn btn-sm bg-blue pull-right fa fa-save btn-raised"></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@stop

@section('script')
    <script>
        $(document).ready(function () {
            verifCheckbox();
        });

        $('#max_amt').on('input', function () {
            $(this).val(money($(this).val()));
        });

        $('#insert').click(function () {
            setEditable();
            $('#form :input').val('');
            $('#form input[type="radio"], #loanTypeForm input[type="checkbox"]').removeAttr('checked');
            $('.select2').select2().trigger('change');
            $(this).replaceWith('<button class="btn btn-sm bg-blue pull-right btn-raised fa fa-save" id="save" type="button"></button>');
            $('.bg-aqua').replaceWith('<button class="btn btn-sm bg-aqua pull-right btn-raised fa fa-recycle" disabled id="update" type="button"></button>');
            $('#form .bg-red').attr('disabled', true);
            verifCheckbox();
        });

        $('#update').click(function () {
            setEditable();
            $(this).replaceWith('<button type="button" id="edit" class="btn btn-sm bg-aqua pull-right btn-raised fa fa-edit"></button>');
        });

        $('input[type="checkbox"]').each(function () {
            $(this).click(function () {
                verifCheckbox();
            })
        });

        $('#intpayacc').change(function () {
            $.ajax({
                url: "{{ url('getaccplan') }}",
                method: 'get',
                data: {
                    accplan: $(this).val()
                },
                success: function (accplan) {
                    $('#intacc_name').val("@if($emp->lang == 'fr') " + accplan.labelfr + " @else " + accplan.labeleng + " @endif ");
                }
            });
        });

        $('#penacc').change(function () {
            $.ajax({
                url: "{{ url('getaccplan') }}",
                method: 'get',
                data: {
                    accplan: $(this).val()
                },
                success: function (accplan) {
                    $('#penacc_name').val("@if($emp->lang == 'fr') " + accplan.labelfr + " @else " + accplan.labeleng + " @endif ");
                }
            });
        });

        $(document).on('click', '#save, #edit', function () {
            let text = '';
            if ($('#idloantype').val() === '')
                text = '@lang('confirm.ltypesave_text')';
            else
                text = '@lang('confirm.ltypeedit_text')';

            swal({
                    title: '@lang('sidebar.loantype')',
                    text: text,
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
                        $('#loanTypeForm').submit();
                    }
                }
            );
        });

        $('#delete').click(function () {
            swal({
                    title: '@lang('sidebar.loantype')',
                    text: '@lang('confirm.ltypedel_text')',
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
                        let form = $('#loanTypeForm');
                        form.attr('action', 'loantype/delete');
                        form.submit();
                    }
                }
            );
        });

        function setEditable() {
            $('#form :input').removeAttr('readonly');
            $('select, #form input[type="radio"], #form input[type="checkbox"]').removeAttr('disabled');
        }

        function verifCheckbox() {
            if ($('#penreg').is(':checked')) {
                $('#penRegInfo').show();
            } else {
                $('#penRegInfo').hide();
            }
        }
    </script>
@stop
