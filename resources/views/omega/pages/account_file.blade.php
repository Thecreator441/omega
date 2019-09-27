<?php $emp = session()->get('employee');
App::setLocale($emp->lang);
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.account'))

@section('content')

    <div class="box">

        <div class="box-body">
            <div class="box-header with-border">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="all" class="text-blue">
                                <input type="radio" name="all" id="all" class="flat-blue">&nbsp;
                                @if($emp->lang == 'fr') Tous les Comptes @else All Accounts @endif</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="active" class="text-green">
                                <input type="radio" name="all" id="active" class="flat-green">&nbsp;
                                @if($emp->lang == 'fr') Comptes Active @else Active Accounts @endif</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="close" class="text-yellow">
                                <input type="radio" name="all" id="close" class="flat-yellow">&nbsp;
                                @if($emp->lang == 'fr') Comptes Fermer @else Close Accounts @endif</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="dead" class="text-red">
                                <input type="radio" name="all" id="dead" class="flat-red">&nbsp;
                                @if($emp->lang == 'fr') Comptes Mort @else Dead Accounts @endif</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date1" class="col-md-2 control-label">@lang('label.period')</label>
                            <label for="date1"
                                   class="col-md-1 control-label text-right"> @lang('label.from')</label>
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <input type="date" name="date1" id="date1" class="form-control">
                                </div>
                            </div>
                            <label for="date2"
                                   class="col-md-1 control-label text-center">@lang('label.to')</label>
                            <div class="col-md-4">
                                <input type="date" name="date2" id="date2" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>

            <div class="col-md-12">
                <table id="bootstrap-data-table" class="table table-condensed table-striped table-responsive">
                    <thead>
                    <tr>
                        <th>@lang('label.account')</th>
                        <th>@lang('label.label')</th>
                        <th style="width: 15%">@lang('label.acctype')</th>
                        <th style="width: 10%">@lang('label.idplan')</th>
                        <th>@lang('label.date')</th>
                    </tr>
                    </thead>
                    <tbody id="acc_table">
                    @foreach ($accounts as $account)
                        <tr>
                            <td>{{$account->accnumb}}</td>
                            <td>@if($emp->lang == 'fr') {{$account->labelfr}} @else {{$account->labeleng}} @endif</td>
                            <td>@if($emp->lang == 'fr') {{$account->Atfr}} @else {{$account->Ateng}} @endif</td>
                            <td>{{$account->accplan}}</td>
                            <td>{{changeFormat($account->created_at)}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="col-md-12">
                <button type="button" id="print" class="btn btn-sm btn-raised pull-right fa fa-print"></button>
            </div>
        </div>
    </div>

@stop
