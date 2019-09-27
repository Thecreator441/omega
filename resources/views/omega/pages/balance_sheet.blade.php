<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.balsheet'))

@section('content')

    <div class="box">
        <div class="box-body">
            <form action="{{ url('balance_sheet/store') }}" method="POST" role="form" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="box-header with-border">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="date1" class="col-md-2 control-label">@lang('label.date')</label>
                            <label for="date1" class="col-md-2 control-label">@lang('label.from')</label>
                            <div class="col-md-8">
                                <input type="date" name="date1" id="date1" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="date2" class="col-md-2 text-center control-label">@lang('label.to')</label>
                            <div class="col-md-10">
                                <input type="date" name="date2" id="date2" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="radio">
                                <label for="detail">@if($emp->lang == 'fr') Détailler @else Detail @endif
                                    <input type="radio" name="fetch" id="detail">
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="radio">
                                <label for="by_tot">@if($emp->lang == 'fr') Par @else By @endif Totalisation
                                    <input type="radio" name="fetch" id="by_tot">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="{{ url('#assets') }}"
                                                  data-toggle="tab">@if($emp->lang == 'fr') ASSETS @else
                                        ASSETS @endif</a></li>
                            <li><a href="{{ url('#libialities') }}" data-toggle="tab">@if($emp->lang == 'fr')
                                        LIABILITIES @else LIABILITIES @endif</a></li>
                        </ul>
                        <div class="tab-content" id="tableInput">
                            <div class="tab-pane active" id="assets">
                                <table
                                    class="table table-hover table-condensed table-responsive table-bordered table-striped">
                                    <caption class="text-center text-blue text-bold">Total ASSETS</caption>
                                    <thead>
                                    <tr>
                                        <th>@lang('label.account')</th>
                                        <th>@lang('label.entitle')</th>
                                        <th>@lang('label.amount')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane" id="libialities">
                                <table class="table table-hover table-condensed table-responsive table-striped">
                                    <caption class="text-center text-blue text-bold">Total LIABILITIES</caption>
                                    <thead>
                                    <tr>
                                        <th>@if($emp->lang == 'fr') Numéro Compte @else Account Number @endif</th>
                                        <th>@if($emp->lang == 'fr') Intitulé Compte @else Account
                                            Entitle @endif</th>
                                        <th>@if($emp->lang == 'fr') Montant @else Amount @endif</th>
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
                        </div>
                    </div>
                </div>

                <div class="col-md-11" id="tableInput">
                    <table class="table table-responsive">
                        <thead>
                        <tr class="text-bold text-blue bg-antiquewhite text-right">
                            <td style="width: 25%">Total @if($emp->lang == 'fr')Assets @else Assets @endif</td>
                            <td><input type="text" class="text-right text-blue" name="tot_assets" id="tot_assets" disabled></td>
                            <td>Total @if($emp->lang == 'fr')Liabilities @else Liabilities @endif</td>
                            <td><input type="text" class="text-right text-blue" name="tot_liabilities" id="tot_liabilities" disabled></td>
                            <td>@if($emp->lang == 'fr') Solde d'Exploitation @else Inc/Exp Outcome @endif</td>
                            <td><input type="text" class="text-right text-blue" name="tot_inc_exp" id="tot_inc_exp" disabled></td>
                        </tr>
                        </thead>
                    </table>
                </div>
                <div class="col-md-1">
                    <button type="button" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-download">
                    </button>
                </div>
            </form>
        </div>
    </div>

@stop
