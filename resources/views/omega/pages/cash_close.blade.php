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
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12">
                        {{ $cashes->appends(['level' => $menu->pLevel, 'menu' => $menu->pMenu])->links('layouts.includes.pagination') }}
                    </div>
                </div>
            </div>
            
            <form action="{{ url('cash_close/store') }}" method="post" role="form" id="cashcloseForm">
                {{csrf_field()}}

                <div class="box-header with-border">
                    @foreach ($cashes as $cash)
                        <input type="hidden" id="idcash" name="idcash" value="{{$cash->idcash}}">

                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-4 col-xs-12">
                                <div class="form-group">
                                    <label for="cashcode" class="col-md-2 col-xs-2 control-label">@lang('label.cash')</label>
                                    <div class="col-md-10 col-xs-10">
                                        <input type="text" id="cashcode" class="form-control" value="{{$cash->cashcode}} : @if ($emp->lang == 'fr') {{$cash->labelfr}} @else {{$cash->labeleng}} @endif" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <div class="form-group">
                                    <label for="cash_amt" class="col-md-2 col-xs-2 control-label">@lang('label.amount')</label>
                                    <div class="col-md-10 col-xs-10">
                                        <input type="text" name="cash_amt" id="cash_amt" class="form-control text-bold text-right" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2"></div>
                        </div>

                        <div class="row">
                            <div class="row">
                                <div class="col-md-12 col-xs-12">
                                    <div class="form-group col-md-12">
                                        <label for="" class="text-blue text-bold">@lang('label.break')</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12" id="tableInput">
                                    <table id="billet-data-table" class="table table-striped table-hover table-condensed table-bordered table-responsive no-padding">
                                        <thead>
                                        <tr class="text-blue">
                                            <th>@lang('label.value')</th>
                                            <th>@lang('label.label')</th>
                                            <th>@lang('label.in')</th>
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
                                                    <td id="mon{{$money->idmoney}}" class="text-right text-bold">{{money($cash->{'mon'.$money->idmoney}) }}</td>
                                                    <td class="text-right amount text-bold" id="{{$money->moncode}}Sum">{{money($money->value * $cash->{'mon'.$money->idmoney} )}}</td>
                                                    <td class="text-light-blue text-bold {{ $money->moncode }}SumWord"></td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        <tr>
                                            <td class="bg-gray"></td>
                                            <td class="bg-gray"></td>
                                            <td class="bg-gray"></td>
                                            <td class="bg-gray"></td>
                                            <td class="bg-gray"></td>
                                        </tr>
                                        @foreach ($moneys as $money)
                                            @if ($money->format == 'C')
                                                <tr>
                                                    <td id="bil">{{$money->value}}</td>
                                                    <td id="bill">@if($emp->lang == 'fr') {{$money->labelfr}} @else {{$money->labeleng}} @endif</td>
                                                    <td id="mon{{$money->idmoney}}" class="text-right text-bold">{{money($cash->{'mon'.$money->idmoney}) }}</td>
                                                    <td class="text-right amount text-bold" id="{{$money->moncode}}Sum">{{money($money->value * $cash->{'mon'.$money->idmoney} )}}</td>
                                                    <td class="text-light-blue text-bold {{ $money->moncode }}SumWord"></td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr class="bg-green-active">
                                            <td colspan="3"
                                                style="text-align: center !important;">@lang('label.tobreak')</td>
                                            <td class="text-bold text-right" id="totamt"></td>
                                            <td class="text-bold" id="totinword"></td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <button type="button" id="close" class="btn btn-sm bg-red pull-right btn-raised fa fa-close"></button>
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
            let sumIn = 0;

            $('.amount').each(function () {
                var input = trimOver($(this).text(), null);

                if (parseInt(input)) {
                    sumIn += parseInt(input);
                    $('.' + $(this).prop('id') + 'Word').text(toWord(input, '{{$emp->lang}}'));
                }
            });
            $('#totamt').text(money(parseInt(sumIn)));
            $('#totinword').text(toWord(sumIn, '{{$emp->lang}}'));

            $('#cash_amt').val(money(parseInt(sumIn)));
        });

        $('#close').click(function () {
            mySwal("{{ $title }}", "@lang('confirm.close_text')", '@lang('confirm.no')', '@lang('confirm.yes')', '#cashcloseForm');
        })
    </script>
@stop
