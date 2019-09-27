<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Bilan';
else
    $title = 'Balance Sheet';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    <div class="box">
        <div class="box-body">
            <form action="{{ url('balance_sheet/store') }}" method="POST" role="form" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="col-md-7">
                    <div class="form-group">
                        <label for="date1" class="col-md-2 control-label">@if($emp->lang == 'fr')
                                Période @else Period @endif</label>
                        <div class="col-md-4">
                            <input type="text" name="date1" id="date1" class="form-control">
                        </div>
                        <label for="date2" class="col-md-2 control-label text-center">@if($emp->lang == 'fr')
                                Au @else To @endif</label>
                        <div class="col-md-4">
                            <input type="text" name="date2" id="date2" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="radio">
                                <label for="detailled">@if($emp->lang == 'fr') Détailler @else Detailled @endif
                                    <input type="radio" name="fetch" id="detailled">
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
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
                                <table class="table table-hover table-condensed table-responsive table-striped">
                                    <caption class="text-center text-blue text-bold">Total ASSETS</caption>
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

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tot_assets" class="col-md-6 control-label">Total @if($emp->lang == 'fr')
                                Assets @else Assets @endif</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control text-right text-blue" name="tot_assets" id="tot_assets" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tot_liabilities" class="col-md-6 control-label">Total @if($emp->lang == 'fr')
                                Liabilities @else Liabilities @endif</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control text-right text-blue" name="tot_liabilities" id="tot_liabilities" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tot_inc_exp" class="col-md-7 control-label">@if($emp->lang == 'fr') Solde
                            d'Exploitation @else Inc/Exp Outcome @endif</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control text-right text-blue" name="tot_inc_exp" id="tot_inc_exp" disabled>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <button type="submit" name="save" id="save" class="btn btn-success bg-blue pull-right btn-raised">
                        <i class="fa fa-save"></i>&nbsp;@if ($emp->lang == 'fr') SAUVEGARDER @else BACKUP @endif
                    </button>
                </div>
            </form>
        </div>
    </div>

@stop
