<?php $emp = session()->get('employee'); ?>

@extends('layouts.dashboard')

@section('title', 'Journal')

@section('content')

    <div class="box">
        <div class="box-body">
            <form action="{{ url('journal/store') }}" method="POST" role="form">
                {{ csrf_field() }}
                <div class="col-md-6">
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
                <div class="col-md-2"></div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="user" class="col-md-3 control-label">@if($emp->lang == 'fr')
                                Utilisateur @else User @endif
                        </label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="user" id="user">
                        </div>
                    </div>
                </div>

                <div class="col-md-2"></div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="all" class="text-blue">
                            <input type="radio" name="all" id="all" class="flat-blue">&nbsp;
                            @if($emp->lang == 'fr') Général @else General @endif</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="active" class="text-green">
                            <input type="radio" name="all" id="active" class="flat-green">&nbsp;
                            @if($emp->lang == 'fr') Versement @else Cash In @endif</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="close" class="text-yellow">
                            <input type="radio" name="all" id="close" class="flat-yellow">&nbsp;
                            @if($emp->lang == 'fr') Retrait @else Cash Out @endif</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="dead" class="text-red">
                            <input type="radio" name="all" id="dead" class="flat-red">&nbsp;
                            @if($emp->lang == 'fr') Opérations Forcés @else Forced Operations @endif</label>
                    </div>
                </div>
                <div class="col-md-1"></div>

                <div class="col-md-12">
                    <table id="tableInput" class="table table-hover table-condensed table-responsive table-striped">
                        <caption class="text-center text-blue text-bold">Total</caption>
                        <thead>
                        <tr>
                            <th>@if($emp->lang == 'fr') Référence @else Reference @endif</th>
                            <th>@if($emp->lang == 'fr') Numéro Compte @else Account Number @endif</th>
                            <th>@if($emp->lang == 'fr') Description Compte @else Account Description @endif</th>
                            <th>@if($emp->lang == 'fr') Description Transaction @else Transaction
                                Description @endif</th>
                            <th>@if($emp->lang == 'fr') Montant Débit @else Debit Amount @endif</th>
                            <th>@if($emp->lang == 'fr') Montant Crédit @else Credit Amount @endif</th>
                            <th>@if($emp->lang == 'fr') Date Transaction @else Transaction Date @endif</th>
                            <th>@if($emp->lang == 'fr') Date Valeur @else Value Date @endif</th>
                            <th>@if($emp->lang == 'fr') Till @else Till @endif</th>
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
                    <button type="submit" name="save" id="save" class="btn btn-success bg-blue pull-right btn-raised">
                        <i class="fa fa-save"></i>&nbsp; @if ($emp->lang == 'fr') ENREGISTRER @else SAVE @endif
                    </button>
                </div>
            </form>
        </div>
    </div>

@stop
