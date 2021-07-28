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
            <form action="{{ url('replenish/store') }}" method="post" role="form" id="repFundsForm" class="needs-validation">
                {{ csrf_field() }}

                <div class="row">
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-2"></div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-8 col-xs-12">
                            <div class="form-group">
                                <label for="cashto" class="col-xl-1 col-lg-2 col-md-3 col-sm-4 col-xs-3 control-label">@lang('label.cashto')</label>
                                <div class="col-xl-11 col-lg-10 col-md-9 col-sm-8 col-xs-9">
                                    <select name="cashto" id="cashto" class="form-control select2">
                                        <option value=""></option>
                                        @foreach($cashes as $cashe)
                                            @if ($cashe->idcash !== $cash->idcash)
                                                <option value="{{$cashe->idcash}}">{{$cashe->cashcode}}
                                                : @if ($emp->lang == 'fr') {{$cashe->labelfr}} @else {{$cashe->labeleng}} @endif
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-2"></div>
                    </div>

                    <hr>
                </div>

                <div class="row" id="tableInput">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-condensed table-bordered no-padding">
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
                                                <td id="bil">{{$money->value}}</td>
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
                                    <tr><th colspan="6" class="bg-gray"></th></tr>
                                    @foreach ($moneys as $money)
                                        @if ($money->format == 'C')
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
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <button type="submit" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>
                    </div>
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

        function submitForm() {
            let cash = parseInt($('#cashto').val());
            let tot = parseInt(trimOver($('#totbil').val(), null));

            if (cash !== '' && !isNaN(tot) && tot !== 0) {
                mySwal('{{ $title }}', '@lang('confirm.repfund_text')', '@lang('confirm.no')', '@lang('confirm.yes')', '#repFundsForm');
            } else {
                myOSwal('{{ $title }}', '@lang('confirm.repfunderror_text')', 'error');
            }
        }
    </script>
@stop
