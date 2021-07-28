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
            <h3 class="box-title text-bold">{{$title}}</h3>
        </div>
        <div class="box-body">
            <form action="{{ route('mem_setting/store') }}" method="post" role="form" id="memSetForm" class="needs-validation">
                {{csrf_field()}}

                <input type="hidden" name="idmem_set" id="idmem_set" value="@if ($mem_sets->count() > 0) {{ $mem_sets->last()->idmemset }} @endif">

                <div class="box-header with-border">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-2 col-xs-12">
                                <div class="form-group has-infos">
                                    <label for="chart_acc" class="text-center col-md-4 col-xs-4 control-label">@lang('label.chart')</label>
                                    <div class="col-md-8 col-xs-8">
                                        <select id="chart_acc" class="form-control select2">
                                            <option value=""></option>
                                            @foreach ($acc_plans as $acc_plan)
                                                @if ($acc_plan->accabbr == 'Or')
                                                    <option value="{{$acc_plan->idaccplan}}">{{substrWords($acc_plan->plan_code, 4)}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <div class="help-block">@lang('placeholder.chart_acc')</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group has-infos">
                                    <label for="chart_acc_name" class="text-center col-md-2 col-xs-2 control-label">@lang('label.label')</label>
                                    <div class="col-md-10 col-xs-10">
                                        <input type="text" id="chart_acc_name" class="form-control" disabled>
                                        <div class="help-block">@lang('placeholder.chart_acc_name')</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-xs-10">
                                <div class="form-group has-infos">
                                    <label for="chart_amt" class="text-center col-md-4 col-xs-4 control-label">@lang('label.amount')</label>
                                    <div class="col-md-8 col-xs-8">
                                        <input type="text" id="chart_amt" class="form-control text-right text-bold">
                                        <div class="help-block">@lang('placeholder.chart_amt')</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 col-xs-2">
                                <div class="form-group">
                                    <button type="button" id="chart_minus" class="btn btn-sm bg-red pull-right fa fa-minus"></button>
                                    <button type="button" id="chart_plus" class="btn btn-sm bg-green pull-right fa fa-plus"></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <table  id="billet-data-table" class="table table-hover-table-condensed table-bordered table-striped table-responsive">
                            <thead>
                            <tr>
                                <th style="width: 5%;"></th>
                                <th>@lang('label.chart')</th>
                                {{-- <th colspan="2">@lang('label.chart')</th> --}}
                                <th>@lang('label.opera')</th>
                                <th>@lang('label.amount')</th>
                            </tr>
                            </thead>
                            <tbody id="chart_rows">
                            @foreach ($mem_sets as $memset)
                                @if ($memset->accabbr === 'Or')
                                    <tr>
                                        <td class="text-center" style="width: 5%;"><input type="hidden" name="memsets[]" value="{{ $memset->idmemset }}"><input type="checkbox" class="gl_checks"></td>
                                        <td class="text-center"><input type="hidden" name="accounts[]" value="{{ $memset->account }}"> {{ $memset->accnumb }}</td>
                                        <td><input type="hidden" name="operations[]" value="{{ $memset->operation }}">@if($emp->lang === 'fr') {{$memset->acclabelfr}} @else {{$memset->acclabeleng}} @endif</td>
                                        <td class="text-right text-bold"><input type="hidden" name="amounts[]" value="{{ (int)$memset->amount }}">{{ money((int)$memset->amount) }}</td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="box-header with-border">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-3 col-xs-12">
                                <div class="form-group has-infos">
                                    <label for="gl_acc" class="text-center col-md-3 col-xs-3 control-label">@lang('label.gl_account')</label>
                                    <div class="col-md-9 col-xs-9">
                                        <select id="gl_acc" class="form-control select2">
                                            <option value=""></option>
                                            @foreach ($acc_plans as $acc_plan)
                                                @if ($acc_plan->accabbr != 'Or')
                                                    <option value="{{$acc_plan->idaccplan}}">{{pad($acc_plan->plan_code, 9, 'right')}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <div class="help-block">@lang('placeholder.gl_acc')</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 col-xs-12">
                                <div class="form-group has-infos">
                                    <label for="gl_acc_name" class="text-center col-md-2 col-xs-2 control-label">@lang('label.label')</label>
                                    <div class="col-md-10 col-xs-10">
                                        <input type="text" id="gl_acc_name" class="form-control" disabled>
                                        <div class="help-block">@lang('placeholder.gl_acc_name')</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-xs-10">
                                <div class="form-group has-infos">
                                    <label for="gl_amt" class="text-center col-md-4 col-xs-4 control-label">@lang('label.amount')</label>
                                    <div class="col-md-8 col-xs-8">
                                        <input type="text" id="gl_amt" class="form-control text-right text-bold">
                                        <div class="help-block">@lang('placeholder.amount')</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 col-xs-2">
                                <div class="form-group">
                                    <button type="button" id="gl_minus" class="btn btn-sm bg-red pull-right fa fa-minus"></button>
                                    <button type="button" id="gl_plus" class="btn btn-sm bg-green pull-right fa fa-plus"></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <table  id="billet-data-table" class="table table-hover-table-condensed table-bordered table-striped table-responsive">
                            <thead>
                            <tr>
                                <th style="width: 5%;"></th>
                                <th>@lang('label.account')</th>
                                {{-- <th colspan="2">@lang('label.account')</th> --}}
                                <th>@lang('label.opera')</th>
                                <th>@lang('label.amount')</th>
                            </tr>
                            </thead>
                            <tbody id="gl_rows">
                            @foreach ($mem_sets as $memset)
                                @if ($memset->accabbr !== 'Or')
                                    <tr>
                                        <td class="text-center" style="width: 5%;"><input type="hidden" name="memsets[]" value="{{ $memset->idmemset }}"><input type="checkbox" class="gl_checks"></td>
                                        <td class="text-center"><input type="hidden" name="accounts[]" value="{{ $memset->account }}"> {{ $memset->accnumb }}</td>
                                        <td><input type="hidden" name="operations[]" value="{{ $memset->operation }}">@if($emp->lang === 'fr') {{$memset->acclabelfr}} @else {{$memset->acclabeleng}} @endif</td>
                                        <td class="text-right text-bold"><input type="hidden" name="amounts[]" value="{{ (int)$memset->amount }}">{{ money((int)$memset->amount) }}</td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                @if ($mem_sets->count() > 0)
                    <div class="col-md-12">
                        <button type="button" id="edit" class="btn btn-sm bg-aqua pull-right btn-raised fa fa-edit .edit"></button>
                    </div>
                @else
                    <div class="col-md-12">
                        <button type="button" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>
                    </div>
                @endif
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
        $(document).ready(function () {
            if ($('#chart_rows tr, #gl_rows tr').length === 0) {
                $('#chart_minus, #gl_minus').prop('disabled', true);
            }
        });

        $('#chart_amt, #gl_amt').on('input', function () {
            $(this).val(money($(this).val()));
        });

        $('#chart_acc').change(function () {
            if ($(this).val() !== '') {
                $.ajax({
                    url: "{{ url('getAccPlan') }}",
                    method: 'get',
                    data: {
                        id: $(this).val()
                    },
                    success: function (acc_plan) {
                        $('#chart_acc_name').val("@if($emp->lang == 'fr')" + acc_plan.labelfr + " @else" + acc_plan.labeleng + " @endif");
                    }
                });
            } else {
                $('#chart_acc_name').val('');
            }
        });

        $('#chart_plus').click(function () {
            var chart_acc = $('#chart_acc');
            var chart_acc_name = $('#chart_acc_name');
            var chart_amt = $('#chart_amt');

            var chart_acc_code = pad(chart_acc.select2('data')[0]['text'], 9, 'right') + '' + pad("{{ $emp->institution }}", 3) + '' + pad("{{ $emp->branch }}", 3);

            var row = '<tr>' +
                    '<td class="text-center" style="width: 5%"><input type="checkbox" class="chart_check"></td>' +
                    '<td class="text-center" style="text-align: center"><input type="hidden" name="accplans[]" value="' + chart_acc.val() + '">' + chart_acc_code + '</td>' +
                    '<td><input type="hidden" name="accounts[]" value=""><input type="hidden" name="operations[]" value="">' + chart_acc_name.val() + '</td>' +
                    '<td class="text-right text-bold amount"><input type="hidden" name="amounts[]" value="' + trimOver(chart_amt.val(), null) + '">' + money(chart_amt.val()) + '</td>' +
                '</tr>';

            $('#chart_rows').append(row);
            $('#chart_minus').removeAttr('disabled');

            chart_acc.val('').select2();
            chart_acc_name.val('');
            chart_amt.val('');
        });

        $('#chart_minus').click(function () {
            $('.chart_check').each(function () {
                if ($(this).is(':checked'))
                    $(this).closest('tr').remove();
            });
        });

        $('#chart_minus').hover(function () {
            if ($('#chart_rows tr').length === 0)
                $(this).prop('disabled', true);
        });

        $('#gl_acc').change(function () {
            if ($(this).val() !== '') {
                $.ajax({
                    url: "{{ url('getAccPlan') }}",
                    method: 'get',
                    data: {
                        id: $(this).val()
                    },
                    success: function (acc_plan) {
                        $('#gl_acc_name').val("@if($emp->lang == 'fr')" + acc_plan.labelfr + " @else" + acc_plan.labeleng + " @endif");
                    }
                });
            } else {
                $('#gl_acc_name').val('');
            }
        });

        $('#gl_plus').click(function () {
            var gl_acc = $('#gl_acc');
            var gl_acc_name = $('#gl_acc_name');
            var gl_amt = $('#gl_amt');

            var gl_acc_code = pad(gl_acc.select2('data')[0]['text'], 9, 'right') + '' + pad("{{ $emp->institution }}", 3) + '' + pad("{{ $emp->branch }}", 3);

            var row = '<tr>' +
                    '<td class="text-center" style="width: 5%"><input type="checkbox" class="gl_check"></td>' +
                    '<td class="text-center"><input type="hidden" name="accplans[]" value="' + gl_acc.val() + '">' + gl_acc_code + '</td>' +
                    '<td><input type="hidden" name="accounts[]" value=""><input type="hidden" name="operations[]" value="">' + gl_acc_name.val() + '</td>' +
                    '<td class="text-right text-bold amount"><input type="hidden" name="amounts[]" value="' + trimOver(gl_amt.val(), null) + '">' + money(gl_amt.val()) + '</td>' +
                '</tr>';

            $('#gl_rows').append(row);
            $('#gl_minus').removeAttr('disabled');

            gl_acc.val('').select2();
            gl_acc_name.val('');
            gl_amt.val('');
        });

        $('#gl_minus').click(function () {
            $('.gl_check').each(function () {
                if ($(this).is(':checked'))
                    $(this).closest('tr').remove();
            });
        });

        $('#gl_minus').hover(function () {
            if ($('#gl_rows tr').length === 0)
                $(this).prop('disabled', true);
        });

        $(document).on('click', '#save, #edit', function () {
            let text = "@lang('confirm.mem_set_save_text')";
            if ($('#idmem_set').val() !== '') {
                text = "@lang('confirm.mem_set_edit_text')";
            }

            var len = $('#chart_rows tr, #gl_rows tr').length;

            if ($('#chart_rows tr, #gl_rows tr').length > 0) {
                mySwal("{{$title}}", text, "@lang('confirm.no')", "@lang('confirm.yes')", '#memSetForm');
            } else {
                myOSwal("{{$title}}", text, 'error');
            }
        });
    </script>
@stop
