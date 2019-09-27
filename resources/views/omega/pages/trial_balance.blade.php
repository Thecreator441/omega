<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.trialbal'))

@section('content')
    <div class="box">
        <div class="box-header">
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right fa fa-close" id="home"></button>
            </div>
        </div>
        <div class="box-body">
            <form action="{{ url('trial_balance/store') }}" method="POST" role="form" id="trialForm">
                {{csrf_field()}}
                <div class="box-header with-border">
                    <div class="col-md-2"></div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="radio">
                                <label for="openbal">@lang('label.openbal')
                                    <input type="radio" name="column" id="openbal">
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="radio">
                                <label for="col4">@lang('label.col4')
                                    <input type="radio" name="column" id="col4">
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="radio">
                                <label for="col6">@lang('label.col6')
                                    <input type="radio" name="column" id="col6">
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                </div>

                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date1" class="col-md-2 control-label">@lang('label.date')</label>
                                <label for="date1" class="col-md-1 control-label">@lang('label.from')</label>
                                <div class="col-md-9">
                                    <input type="date" name="date1" id="date1" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date2" class="col-md-2 text-center control-label">@lang('label.to')</label>
                                <div class="col-md-10">
                                    <input type="date" name="date2" id="date2" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="acc1" class="col-md-2 control-label">@lang('label.account')</label>
                                <label for="acc1" class="col-md-1 control-label">@lang('label.from')</label>
                                <div class="col-md-9">
                                    <select type="text" name="acc1" id="acc1" class="form-control select2">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="acc2" class="col-md-2 text-center control-label">@lang('label.to')</label>
                                <div class="col-md-10">
                                    <select type="text" name="acc2" id="acc2" class="form-control select2">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="col-md-12">
                        <button type="button" id="print" class="btn btn-sm pull-right btn-raised fa fa-print">
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
