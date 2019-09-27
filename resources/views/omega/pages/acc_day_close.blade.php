<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr') {
    App::setLocale('fr');
    $title = 'Fermeture Journée Comptable';
} else {
    $title = 'Account Day Closing';
}
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    <div class="box">
        <div class="box-header">
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right fa fa-close" id="home"></button>
            </div>
        </div>
        <div class="box-body">
            <form action="{{ url('acc_day_close/store') }}" method="POST" role="form" id="closeDateForm">
                {{ csrf_field() }}
                <div class="box-header with-border">
                    <div class="row">
                        <div class="text-bold text-purples">@lang('label.sitprevval')</div>
                    </div>
                    <table id="tableInput" class="table table-hover table-condensed table-responsive table-striped">
                        <thead>
                        <tr>
                            <th>@lang('label.refer')</th>
                            <th>@lang('label.debt')</th>
                            <th>@lang('label.credt')</th>
                            <th>@lang('label.diff')</th>
                            <th>@lang('label.status')</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td></td>
                            <td><input type="text" class="text-blue op" name="totdeb" id="totdeb" disabled></td>
                            <td><input type="text" class="text-blue op" name="totcred" id="totcred" disabled></td>
                            <td><input type="text" class="text-blue op" name="diff" id="diff" disabled></td>
                            <td></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="box-header with-border">
                    <div class="row">
                        <div class="text-bold text-purples">@lang('label.refnonval')</div>
                    </div>
                    <table id="tableInput" class="table table-hover table-condensed table-responsive table-striped">
                        <thead>
                        <tr>
                            <th>@lang('label.refer')</th>
                            <th>@lang('label.account')</th>
                            <th>@lang('label.reason')</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tbody>
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
        $(document).ready(function () {
            $('#save').click(function () {
                swal({
                        title: '@lang('confirm.closedate_header')',
                        text: '@lang('confirm.closedate_text')',
                        type: 'info',
                        showCancelButton: true,
                        cancelButtonClass: 'bg-red',
                        confirmButtonClass: 'bg-blue',
                        confirmButtonText: '@lang('confirm.yes')',
                        cancelButtonText: '@lang('confirm.no')',
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            $('#closeDateForm').submit();
                        }
                    }
                );
            })
        });
    </script>
@stop
