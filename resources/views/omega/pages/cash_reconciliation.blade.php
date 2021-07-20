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
            <div class="box-tools pull-right">
                {{ $cashes->appends(['level' => $menu->pLevel, 'menu' => $menu->pMenu])->links('layouts.includes.pagination') }}
            </div>
        </div>
        <div class="box-body">
            <form action="{{ url('cash_reconciliation/store') }}" method="post" role="form" id="cashReconForm">
                {{csrf_field()}}

                @foreach ($cashes as $cash)
                    <div class="row">
                        <div class="row">
                            <input type="hidden" id="idcash" name="idcash" value="{{$cash->idcash}}">

                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-1"></div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-5 col-xs-12">
                                <div class="form-group">
                                    <label for="cashcode" class="col-xl-1 col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">@lang('label.cash')</label>
                                    <div class="col-xl-11 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                        <input type="text" id="cashcode" class="form-control" value="{{$cash->cashcode}} : @if ($emp->lang == 'fr') {{$cash->labelfr}} @else {{$cash->labeleng}} @endif" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-5 col-xs-12">
                                <div class="form-group">
                                    <label for="employee" class="col-xl-1 col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">@lang('label.user')</label>
                                    <div class="col-xl-11 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                        <input type="text" id="employee" class="form-control" disabled value="{{$emp->name}} {{$emp->surname}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-1"></div>
                        </div>

                        <hr>
                    </div>

                    <div class="row" id="tableInput">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="table-responsive">
                                <table id="billet-data-table" class="table table-striped table-hover table-condensed table-bordered no-padding">
                                    <thead>
                                    <tr class="text-blue">
                                        <th>@lang('label.value')</th>
                                        <th>@lang('label.label')</th>
                                        <th>@lang('label.in')</th>
                                        <th> @lang('label.amount')</th>
                                        <th>@lang('label.out')</th>
                                        <th>@lang('label.amount')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($moneys as $money)
                                        @if ($money->format == 'B')
                                            <tr>
                                                <td id="bil">{{$money->value}}</td>
                                                <td id="bill">@if($emp->lang == 'fr') {{$money->labelfr}} @else {{$money->labeleng}} @endif</td>
                                                <td id="mon{{$money->idmoney}}"><input type="hidden" value="{{money($cash->{'mon'.$money->idmoney}) }}">
                                                    {{money($cash->{'mon'.$money->idmoney}) }}</td>
                                                <td id="mon{{$money->idmoney}}" class="inamt">{{money($money->value * $cash->{'mon'.$money->idmoney} )}}</td>
                                                <td>
                                                    <input type="text" class="tot" name="{{$money->moncode}}" id="{{$money->moncode}}"
                                                        oninput="sum('{{$money->value}}', '#{{$money->moncode}}', '#{{$money->moncode}}Sum')">
                                                </td>
                                                <td>
                                                    <input type="text" class="sum" id="{{$money->moncode}}Sum" disabled>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    <tr><td colspan="6" class="bg-gray"></td></tr>
                                    @foreach ($moneys as $money)
                                        @if ($money->format == 'C')
                                            <tr>
                                                <td id="bil">{{$money->value}}</td>
                                                <td id="bill">@if($emp->lang == 'fr') {{$money->labelfr}} @else {{$money->labeleng}} @endif</td>
                                                <td id="mon{{$money->idmoney}}"><input type="hidden"
                                                                                    value="{{money($cash->{'mon'.$money->idmoney}) }}">
                                                    {{money($cash->{'mon'.$money->idmoney}) }}</td>
                                                <td id="mon{{$money->idmoney}}"
                                                    class="inamt">{{money($money->value * $cash->{'mon'.$money->idmoney} )}}</td>
                                                <td>
                                                    <input type="text" class="tot" name="{{$money->moncode}}" id="{{$money->moncode}}"
                                                        oninput="sum('{{$money->value}}', '#{{$money->moncode}}', '#{{$money->moncode}}Sum')">
                                                </td>
                                                <td>
                                                    <input type="text" class="sum" id="{{$money->moncode}}Sum" disabled>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                    <tfoot class="bg-green-active">
                                    <tr>
                                        <td colspan="2"
                                            style="text-align: center !important;">@lang('label.tobreak')</td>
                                        <td colspan="2">
                                            <input type="text" class="bg-green-active pull-right text-bold"
                                                name="totin" id="totin" readonly>
                                        </td>
                                        <td colspan="2"><input type="text" class="bg-green-active pull-right text-bold"
                                                            name="totbil" id="totbil" readonly></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="bg-green-active text-bold text-right" id="totinword"></td>
                                        <td colspan="2" class="bg-green-active text-bold text-right" id="totopera"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: center !important;">@lang('label.diff')</td>
                                        <td colspan="2"><input type="text" class="bg-green-active pull-left text-bold"
                                                            name="diff" id="diff" readonly></td>
                                        <td colspan="2" id="diffinword"></td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
        $(document).ready(function () {
            let sumIn = 0;

            $('.inamt').each(function () {
                if (parseInt(trimOver($(this).text(), null)))
                    sumIn += parseInt(trimOver($(this).text(), null));
            });
            $('#totin').val(money(parseInt(sumIn)));
            $('#totinword').text(toWord(sumIn, '{{$emp->lang}}'));
        });

        function sum(amount, valueId, sumId) {
            $(valueId).val(money($(valueId).val()));
            $(sumId).val(money(amount * trimOver($(valueId).val(), null)));

            sumAmount();
        }

        $(document).on('input', '.amount', function () {
            $(this).val(money($(this).val()));

            sumAmount();
        });

        function sumAmount() {
            let sumIn = 0;

            $('.sum').each(function () {
                let input = trimOver($(this).val(), null);
                if (parseInt(input)) {
                    sumIn += parseInt(input);
                }
            });
            $('#totbil').val(money(sumIn));
            $('#totopera').text(toWord(sumIn, '{{$emp->lang}}'));

            setDisplay();
        }

        $('.tot').each(function () {
            $(this).keyup(function () {
                if (parseInt(trimOver($('#totbil').val(), null)))
                    setDisplay();
            });
        });

        function setDisplay() {
            let diff = Math.abs(parseInt(trimOver($('#totin').val(), null)) - parseInt(trimOver($('#totbil').val(), null)));

            $('#diff').val(money(diff));
            $('#diffinword').text(toWord(diff, '{{$emp->lang}}'));
            $('#closure').css('display', 'block');

            if (diff < 0 || diff > 0) {
                $('#diff').attr('class', 'text-red');
            } else {
                $('#diff').attr('class', 'text-white');
            }
        }

        $('#close').click(function () {
            let totin = parseInt(trimOver($('#totin').val(), null));
            let totbil = parseInt(trimOver($('#totbil').val(), null));

            let icon = 'info';
            let text = '@lang('confirm.close_text')';

            if (totin < totbil) {
                icon = 'error';
                text = '@lang('confirm.excess_text')';
            } else if (totin > totbil) {
                icon = 'error';
                text = '@lang('confirm.shortage_text')';
            }

            mySwal("{{ $title }}", text, '@lang('confirm.no')', '@lang('confirm.yes')', '#cashReconForm', icon);
        })
    </script>
@stop
