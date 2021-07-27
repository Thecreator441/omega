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
            <form action="{{ url('money_exchange/store') }}" method="post" role="form" id="monExcForm">
                {{ csrf_field() }}
                <input type="hidden" id="idcash" name="idcash" value="{{$cash->idcash}}">

                <div class="row">
                    <div class="col-md-12" id="tableInput">
                        <div class="table-responsive">
                            <table id="billet-data-table" class="table table-striped table-hover table-condensed table-bordered no-padding">
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
                                            <td id="billExc" class="cin">{{$money->value}}</td>
                                            <td id="bill">@if($emp->lang == 'fr') {{$money->labelfr}} @else {{$money->labeleng}} @endif</td>
                                            <td id="mon{{$money->idmoney}}">{{money($cash->{'mon'.$money->idmoney}) }}</td>
                                            <td class="cout">
                                                <input type="text" class="tot" name="{{$money->moncode}}Out"
                                                    id="{{$money->moncode}}Out"
                                                    oninput="sumOut('{{$money->value}}', '#{{$money->moncode}}Out', '#{{$money->moncode}}OutSum')">
                                            </td>
                                            <td class="sumOut text-right" id="{{$money->moncode}}OutSum"></td>
                                            <td class="cout">
                                                <input type="text" class="tot" name="{{$money->moncode}}In"
                                                    id="{{$money->moncode}}In"
                                                    oninput="sumIn('{{$money->value}}', '#{{$money->moncode}}In', '#{{$money->moncode}}InSum')">
                                            </td>
                                            <td class="sumIn text-right" id="{{$money->moncode}}InSum"></td>
                                        </tr>
                                    @endif
                                @endforeach
                                <tr><td colspan="7" class="bg-gray"></td></tr>
                                @foreach ($moneys as $money)
                                    @if ($money->format == 'C')
                                        <tr>
                                            <td id="billExc" class="cin">{{$money->value}}</td>
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
                    </div>
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
            let totin = parseInt(trimOver($('#totin').text(), null));
            let totout = parseInt(trimOver($('#totout').text(), null));

            if ((totin === totout) && (totin != 0 || totout != 0)) {
                mySwal('@lang('sidebar.monexc')', '@lang('confirm.monexc_text')', '@lang('confirm.no')', '@lang('confirm.yes')', '#monExcForm');
            } else {
                myOSwal('@lang('sidebar.monexc')', '@lang('confirm.monexcerror_text')', 'error');
            }
        })
    </script>
@stop
