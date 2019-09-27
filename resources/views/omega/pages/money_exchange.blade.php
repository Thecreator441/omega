<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr') {
    App::setLocale('fr');
    $title = 'Echange Monnaie';
} else {
    $title = 'Currency Exchange';
}
?>
@extends('layouts.dashboard')

@section('title', $title)

@section('content')
    <div class="box">
        <div class="box-body">
            <form action="{{ url('money_exchange/store') }}" method="post" role="form" id="monExcForm">
                {{ csrf_field() }}
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="cashcode" class="col-md-3 control-label">@lang('label.cash')</label>
                                <div class="col-md-9">
                                    <input type="text" name="cashcode" id="cashcode" class="form-control"
                                           value="{{$cash->cashcode}} :@if ($emp->lang == 'fr') {{$cash->labelfr}} @else {{$cash->labeleng}} @endif"
                                           disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4"></div>
                    </div>
                </div>

                <div class="col-md-12">
                    <table id="tableInput"
                           class="table w-auto table-striped table-hover table-condensed table-bordered table-responsive no-padding">
                        <caption class="text-blue">@lang('label.break')</caption>
                        <thead>
                        <tr class="text-blue">
                            <th>@lang('label.value')</th>
                            <th>@lang('label.label')</th>
                            <th>@lang('label.in')</th>
                            <th>@lang('label.value') @lang('label.out')</th>
                            <th>@lang('label.amount')</th>
                            <th>@lang('label.value') @lang('label.in')</th>
                            <th>@lang('label.amount')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($moneys as $money)
                            @if ($money->format == 'B')
                                <tr>
                                    <td id="billet">{{money($money->value)}}</td>
                                    <td id="bill">@if($emp->lang == 'fr') {{$money->labelfr}} @else {{$money->labeleng}} @endif</td>
                                    <td id="mon{{$money->idmoney}}">{{money($cash->{'mon'.$money->idmoney}) }}</td>
                                    <td style="width: 10%">
                                        <input type="text" class="tot" name="{{$money->moncode}}Out"
                                               id="{{$money->moncode}}Out"
                                               oninput="sumOut('{{$money->value}}', '#{{$money->moncode}}Out', '#{{$money->moncode}}OutSum')">
                                    </td>
                                    <td class="sumOut text-right" id="{{$money->moncode}}OutSum"></td>
                                    <td style="width: 10%">
                                        <input type="text" class="tot" name="{{$money->moncode}}In"
                                               id="{{$money->moncode}}In"
                                               oninput="sumIn('{{$money->value}}', '#{{$money->moncode}}In', '#{{$money->moncode}}InSum')">
                                    </td>
                                    <td class="sumIn text-right" id="{{$money->moncode}}InSum"></td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                        <thead>
                        <tr>
                            <th colspan="7" class="bg-gray"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($moneys as $money)
                            @if ($money->format == 'C')
                                <tr>
                                    <td id="billet">{{money($money->value)}}</td>
                                    <td id="bill">@if($emp->lang == 'fr') {{$money->labelfr}} @else {{$money->labeleng}} @endif</td>
                                    <td id="mon{{$money->idmoney}}">{{money($cash->{'mon'.$money->idmoney}) }}</td>
                                    <td>
                                        <input type="text" class="tot" name="{{$money->moncode}}Out"
                                               id="{{$money->moncode}}Out"
                                               oninput="sumOut('{{$money->value}}', '#{{$money->moncode}}Out', '#{{$money->moncode}}OutSum')">
                                    </td>
                                    <td class="sumOut text-right" id="{{$money->moncode}}OutSum"></td>
                                    <td>
                                        <input type="text" class="tot" name="{{$money->moncode}}In"
                                               id="{{$money->moncode}}In"
                                               oninput="sumIn('{{$money->value}}', '#{{$money->moncode}}In', '#{{$money->moncode}}InSum')">
                                    </td>
                                    <td class="sumIn text-right" id="{{$money->moncode}}InSum"></td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr class="bg-green-active">
                            <td colspan="3"></td>
                            <td style="text-align: center !important;">@lang('label.total') @lang('label.out')</td>
                            <td id="totout" class="text-right"></td>
                            <td style="text-align: center !important;">@lang('label.total') @lang('label.in')</td>
                            <td id="totin" class="text-right"></td>
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
        function sumOut(amount, valueId, sumId) {
            $(valueId).val(money($(valueId).val()));
            $(sumId).text(money(amount * trimOver($(valueId).val(), null)));

            let sumOut = 0;
            $('.sumOut').each(function () {
                let cOut = trimOver($(this).text(), null);
                if (parseInt(cOut))
                    sumOut += parseInt(cOut);
            });
            $('#totout').text(money(parseInt(sumOut)));
        }

        function sumIn(amount, valueId, sumId) {
            $(valueId).val(money($(valueId).val()));
            $(sumId).text(money(amount * trimOver($(valueId).val(), null)));

            let sumIn = 0;
            $('.sumIn').each(function () {
                let cIn = trimOver($(this).text(), null);
                if (parseInt(cIn))
                    sumIn += parseInt(cIn);
            });
            $('#totin').text(money(parseInt(sumIn)));
        }

        $('#save').click(function () {
            if (parseInt(trimOver($('#totout').text(), null)) === parseInt(trimOver($('#totin').text(), null))) {
                swal({
                        title: '@lang('confirm.monexc_header')',
                        text: '@lang('confirm.monexc_text')',
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
                            $('#monExcForm').submit();
                        }
                    }
                );
            } else {
                swal({
                        title: '@lang('confirm.monexc_header')',
                        text: '@lang('confirm.monexcerror_text')',
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
