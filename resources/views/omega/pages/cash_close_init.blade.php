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
                {{ $cashes->appends(request()->query())->links('layouts.includes.pagination') }}
            </div>
        </div>
        <div class="box-body">
            {{-- <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12">
                        {{ $cashes->appends(request()->query())->links('layouts.includes.pagination') }}
                    </div>
                </div>
            </div> --}}
            
            <form action="{{ url('cash_close_init/store') }}" method="post" role="form" id="cashclose_initForm">
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
                                    <label for="employee" class="col-md-3 col-xs-2 control-label">@lang('label.user')</label>
                                    <div class="col-md-9 col-xs-10">
                                        <input type="text" id="employee" class="form-control" disabled value="{{$emp->name}} {{$emp->surname}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-xs-0"></div>
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
                                    <tr>
                                        <td class="bg-gray"></td>
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
                                        <td colspan="4" class="bg-green-active text-bold" id="totinword"></td>
                                        <td colspan="2" class="bg-green-active text-bold" id="totopera"></td>
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
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <button type="button" id="close_init" class="btn btn-sm bg-blue pull-right btn-raised fa fa-folder"></button>
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

        $('#close_init').click(function () {
            mySwal("{{ $title }}", "@lang('confirm.close_init_text')", '@lang('confirm.no')', '@lang('confirm.yes')', '#cashclose_initForm');
        })
    </script>
@stop
