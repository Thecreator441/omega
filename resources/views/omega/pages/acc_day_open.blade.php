<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr') {
    App::setLocale('fr');
    $title = 'Ouverture Journée Comptable';
} else {
    $title = 'Account Day Opening';
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
            <form action="{{ url('acc_day_open/store') }}" method="POST" role="form" id="openDateForm">
                {{ csrf_field() }}
                <div class="box-header with-border">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="date" class="col-md-6 control-label">@lang('label.accdate')</label>
                            <div class="col-md-6">
                                <input type="text" name="date" id="date" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4"></div>
                </div>

                <div class="col-md-12" id="tableInput">
                    <table class="table table-hover table-condensed table-responsive table-striped">
                        <thead>
                        <tr>
                            <th>@lang('label.procedure')</th>
                            <th>@lang('label.desc')</th>
                            <th>@lang('label.execstat')</th>
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
                    <button type="button" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save">
                    </button>
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
                        title: '@lang('confirm.opendate_header')',
                        text: '@lang('confirm.opendate_text')',
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
                            $('#openDateForm').submit();
                        }
                    }
                );
            })
        });
    </script>
@stop
