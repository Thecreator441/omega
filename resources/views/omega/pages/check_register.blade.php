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
            <form action="{{ url('check_register/store') }}" method="POST" id="cheRegForm" role="form" class="needs-validation">
                {{ csrf_field() }}

                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                            <table id="admin-data-table" class="table table-striped table-hover table-condensed table-bordered">
                                <thead>
                                <tr>
                                    <th rowspan="2">@lang('label.checkno')</th>
                                    <th rowspan="2">@lang('label.bank')</th>
                                    <th rowspan="2">@lang('label.carrier')</th>
                                    <th rowspan="2">@lang('label.opera')</th>
                                    <th rowspan="2">@lang('label.amount')</th>
                                    <th colspan="2">@lang('label.status')</th>
                                </tr>
                                <tr>
                                    
                                    <th>@lang('label.paid')</th>
                                    <th>@lang('label.unpaid')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($checks as $check)
                                    <tr>
                                        <td>{{$check->checknumb}}</td>
                                        <td>{{$check->bank}}</td>
                                        <td>{{ $check->carrier }}</td>
                                        <td>{{ $check->opera }}</td>
                                        <td class="text-right text-bold amount">{{money((int)$check->amount)}}</td>
                                        <td class="text-center">
                                            <label for="prov">
                                                <input type="radio" id="prov" name="provisions[{{$check->idcheck}}]" value="P{{$check->idcheck}}" class="bg-green">
                                            </label>
                                        </td>
                                        <td class="text-center">
                                            <label for="noprov">
                                                <input type="radio" id="noprov" name="provisions[{{$check->idcheck}}]" value="U{{$check->idcheck}}" class="bg-red">
                                            </label>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <button type="submit" id="save" class="save btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
        function submitForm() {
            mySwal("{{ $title }}", '@lang('confirm.check_register_text')', '@lang('confirm.no')', '@lang('confirm.yes')', '#cheRegForm');
        }
    </script>
@stop
