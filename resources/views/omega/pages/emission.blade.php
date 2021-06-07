<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.emifund'))

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold"> @lang('sidebar.emifund') </h3>
        </div>
        {{--        <div class="box-header">--}}
        {{--            <div class="box-tools pull-right">--}}
        {{--                <button type="button" class="btn btn-alert bg-red btn-sm pull-right fa fa-close" id="home"></button>--}}
        {{--            </div>--}}
        {{--        </div>--}}
        <div class="box-body">
            <form action="{{ url('emission/store') }}" method="post" role="form" id="emisFundsForm">
                {{ csrf_field() }}
                <div class="box-header with-border">
                    <div class="col-md-1"></div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="cash" class="col-md-3 control-label">@lang('label.cash')</label>
                            <div class="col-md-9">
                                <input type="text" name="cash" id="cash" class="form-control" disabled
                                       value="{{$cash->cashcode}} :@if ($emp->lang == 'fr') {{$cash->labelfr}} @else {{$cash->labeleng}} @endif">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="cashto" class="col-md-3 control-label">@lang('label.cashto')</label>
                            <div class="col-md-9">
                                <select name="cashto" id="cashto" class="form-control select2" disabled>
                                    <option value="{{$maincash->idcash}}">{{$maincash->cashcode}}
                                        : @if ($emp->lang == 'fr') {{$maincash->labelfr}} @else {{$maincash->labeleng}} @endif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
{{--                    <div class="col-md-4">--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="opera" class="col-md-3 control-label">@lang('label.opera')</label>--}}
{{--                            <div class="col-md-9">--}}
{{--                                @foreach ($operas as $opera)--}}
{{--                                    @if ($opera->opercode == 5)--}}
{{--                                        <input type="text" class="form-control" disabled--}}
{{--                                               value="{{pad($opera->opercode, 3)}} : @if ($emp->lang == 'fr') {{$opera->labelfr}}@else {{$opera->labeleng}} @endif">--}}
{{--                                    @endif--}}
{{--                                @endforeach--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>

                <div class="col-md-12">
                    <table id="tableInput"
                           class="table table-striped table-hover table-condensed table-bordered table-responsive">
                        <caption class="text-blue text-bold h4"><b>@lang('label.break')</b></caption>
                        <thead>
                        <tr class="text-blue">
                            <th>@lang('label.value')</th>
                            <th>@lang('label.label')</th>
                            <th>@lang('label.in')</th>
                            <th>@lang('label.out')</th>
                            <th>@lang('label.amount')</th>
                            <th>@lang('label.letters')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($moneys as $money)
                            @if ($money->format == 'B')
                                <tr>
                                    <td id="bil">{{money($money->value)}}</td>
                                    <td id="bill">@if($emp->lang == 'fr') {{$money->labelfr}} @else {{$money->labeleng}} @endif</td>
                                    <td id="mon{{$money->idmoney}}">{{money($cash->{'mon'.$money->idmoney}) }}</td>
                                    <td style="width: 10%;">
                                        <input type="text" name="{{$money->moncode}}" id="{{$money->moncode}}"
                                               oninput="sum('{{$money->value}}', '#{{$money->moncode}}', '#{{$money->moncode}}Sum', '#{{$money->moncode}}Word')">
                                    </td>
                                    <td class="sum" id="{{$money->moncode}}Sum"></td>
                                    <td class="text-blue word" id="{{$money->moncode}}Word"></td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                        <thead>
                        <tr>
                            <th colspan="6" class="bg-gray"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($moneys as $money)
                            @if ($money->format == 'C')
                                <tr>
                                    <td id="bil">{{$money->value}}</td>
                                    <td id="bill">@if($emp->lang == 'fr') {{$money->labelfr}} @else {{$money->labeleng}} @endif</td>
                                    <td id="mon{{$money->idmoney}}">{{money($cash->{'mon'.$money->idmoney}) }}</td>
                                    <td>
                                        <input type="text" name="{{$money->moncode}}" id="{{$money->moncode}}"
                                               oninput="sum('{{$money->value}}', '#{{$money->moncode}}', '#{{$money->moncode}}Sum', '#{{$money->moncode}}Word')">
                                    </td>
                                    <td class="sum" id="{{$money->moncode}}Sum"></td>
                                    <td class="text-blue word" id="{{$money->moncode}}Word"></td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr class="bg-green-active">
                            <td colspan="4" style="text-align: center !important;">@lang('label.tobreak')</td>
                            <td>
                                <input type="text" class="bg-green-active pull-right text-bold"
                                       name="totbil" id="totbil" readonly>
                            </td>
                            <td class="text-left text-bold" id="totopera"></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="col-md-12">
                    <button type="button" id="save"
                            class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>
                </div>
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
        function sum(amount, valueId, sumId, wordId) {
            $(valueId).val(money($(valueId).val()));
            let totAmt = amount * trimOver($(valueId).val(), null);
            $(sumId).text(money(totAmt));
            $(wordId).text(toWord(totAmt));

            let sum = 0;

            $('.sum').each(function () {
                let numb = trimOver($(this).text(), null);

                if (parseInt(numb))
                    sum += parseInt(numb);
            });
            $('#totbil').val(money(sum));
            $('#totopera').text(toWord(sum));
        }

        $('#save').click(function () {
            let cash = parseInt($('#cashto').val());
            let tot = parseInt(trimOver($('#totbil').val(), null));
            // alert('Cash = ' + cash + '\nAmount = ' + tot);
            if (!isNaN(cash) && !isNaN(tot)) {
                swal({
                        title: '@lang('sidebar.emifund')',
                        text: '@lang('confirm.emifund_text')',
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
                            $('#emisFundsForm').submit();
                        }
                    }
                );
            } else {
                swal({
                        title: '@lang('sidebar.emifund')',
                        text: '@lang('confirm.emifunderror_text')',
                        type: 'error',
                        confirmButtonClass: 'bg-blue',
                        confirmButtonText: 'OK',
                        closeOnConfirm: true,
                    }
                );
            }
        })
    </script>
@stop
