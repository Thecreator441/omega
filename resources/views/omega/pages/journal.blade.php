<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr') {
    App::setLocale('fr');
}
?>

@extends('layouts.dashboard')

@section('title', 'Journal')

@section('content')

    <div class="box">
        <div class="box-header">
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right fa fa-close" id="home"></button>
            </div>
        </div>
        <div class="box-body">
            <form action="{{ url('temp_journal/store') }}" method="POST" role="form">
                {{ csrf_field() }}
                <div class="col-md-7">
                    <div class="form-group">
                        <label for="date1" class="col-md-2 control-label">@lang('label.period')</label>
                        <label for="date1" class="col-md-1 control-label">@lang('label.from')</label>
                        <div class="col-md-4">
                            <input type="text" name="date1" id="date1" class="form-control">
                        </div>
                        <label for="date2" class="col-md-1 control-label text-center">@lang('label.to')</label>
                        <div class="col-md-4">
                            <input type="text" name="date2" id="date2" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="user" class="col-md-3 control-label">@lang('label.cashier')</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="user" id="user">
                        </div>
                    </div>
                </div>

                <div class="col-md-2"></div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="all" class="text-blue">
                            <input type="radio" name="all" id="all" class="flat-blue">&nbsp;@lang('label.gen')</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="active" class="text-green">
                            <input type="radio" name="all" id="active" class="flat-green">&nbsp;@lang('sidebar.cin')</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="close" class="text-yellow">
                            <input type="radio" name="all" id="close" class="flat-yellow">&nbsp;@lang('sidebar.cout')</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="dead" class="text-red">
                            <input type="radio" name="all" id="dead" class="flat-red"> @lang('label.foroper')</label>
                    </div>
                </div>
                <div class="col-md-1"></div>

                <div class="col-md-12" id="tableInput">
                    <table id="bootstrap-data-table" class="table table-hover table-condensed table-responsive table-striped">
                        <caption class="text-center text-blue text-bold">@lang('label.total')</caption>
                        <thead>
                        <tr>
                            <th>@lang('label.refer')</th>
                            <th>@lang('label.accno')</th>
                            <th>@lang('label.accdes')</th>
                            <th>@lang('label.trades')</th>
                            <th>@lang('label.debt')</th>
                            <th>@lang('label.credt')</th>
                            <th>@lang('label.tradate')</th>
                            <th>@lang('label.valdate')</th>
                            <th>@lang('label.cash')</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr class="text-right">
                            <td colspan="2">Total @if($emp->lang == 'fr') Débit @else Debit @endif</td>
                            <td><input type="text" class="text-blue op" name="tot_debit" id="tot_debit" disabled>
                            </td>
                            <td colspan="2">Total @if($emp->lang == 'fr') Crédit @else Credit @endif</td>
                            <td><input type="text" class="text-blue op" name="tot_credit" id="tot_credit" disabled>
                            </td>
                            <td colspan="2">Total Balance</td>
                            <td><input type="text" class="text-red op" name="tot_balance" id="tot_balance" disabled>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="col-md-12">
                    <button type="submit" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-print">
                    </button>
                </div>
            </form>
        </div>
    </div>

@stop
