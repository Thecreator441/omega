<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.close_acc_date'))

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold"> @lang('sidebar.close_acc_date') </h3>
        </div>
        <div class="box-body">
            <form action="{{ url('acc_day_close/store') }}" method="POST" role="form" id="openDateForm">
                {{ csrf_field() }}

                <input type="hidden" name="iddate" value="@if ($acc_date !== null) {{$acc_date->idaccdate}} @endif">

                <div class="col-md-3"></div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="date" class="col-md-5 control-label">@lang('label.accdate')</label>
                        <div class="col-md-7">
                            <input type="hidden" id="prev_date" class="form-control" value="@if ($acc_date !== null) {{$acc_date->accdate}} @endif">
                            <input type="date" name="date" id="date" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <button type="button" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>
                    </div>
                </div>
                <div class="col-md-4"></div>
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
        $(document).ready(function () {
            let prev_date = $('#prev_date').val();
            let date = null;
            let min = null;

            if (prev_date === null) {
                date = new Date();
                min = new Date();
            } else {
                date = new Date(prev_date);
                min = new Date(prev_date);
                min = min.addDays(-7);
            }
            min = Date.parse(min).toString('yyyy-MM-dd');
            $('#date').attr('min', min);

            date = Date.parse(date).toString('yyyy-MM-dd');
            $('#date').attr('value', date);
        });

        $('#save').click(function () {
            mySwal('@lang('sidebar.close_acc_date')', '@lang('confirm.closedate_text')', '@lang('confirm.no')', '@lang('confirm.yes')', '#openDateForm');
        })
    </script>
@stop
