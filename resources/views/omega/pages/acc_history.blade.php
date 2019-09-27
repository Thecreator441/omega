d<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Historique Compte';
else
    $title = 'Account History';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    <div class="box">
        <div class="box-body">
            <div class="box-header with-border">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="mem_numb" class="col-md-2 control-label">@if($emp->lang == 'fr')
                                N° Membre @else Member N° @endif</label>
                        <div class="col-md-3">
                            <select name="mem_numb" id="mem_numb" class="form-control select2">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="mem_name" id="mem_name" class="form-control"
                                   disabled="disabled">
                        </div>
                        <div class="col-md-3">
                            <select name="account" id="account" class="form-control select2">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                </div>

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
                <div class="col-md-1"></div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="last_int" class="col-md-5 control-label">@if($emp->lang == 'fr')
                                Dernier Intêrét @else Last Interest @endif</label>
                        <div class="col-md-7">
                            <input type="text" name="last_int" id="last_int" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12" id="tableInput">
                <table
                    class="table table-hover table-condensed table-responsive table-striped">
                    <caption>
                        <div class="col-md-12 text-center text-blue text-bold">Total</div>

                        <div class="col-md-1"></div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="blocked_amt" class="col-md-5 control-label">@if($emp->lang == 'fr')
                                        Montant Bloquée @else Blocked Amount @endif</label>
                                <div class="col-md-7">
                                    <input type="text" name="blocked_amt" id="blocked_amt" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="init_bal" class="col-md-4 control-label">@if($emp->lang == 'fr')
                                        Solde Initial @else Initial Balance @endif</label>
                                <div class="col-md-8">
                                    <input type="text" name="init_bal" id="init_bal" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1"></div>

                        <div class="col-md-1"></div>
                        <div class="col-md-5 text-gray text-bold text-right">
                            @if ($emp->lang == 'fr') Rapport Solde Au @else Report Balance To @endif <span
                                id="date">31/08/2019</span>
                        </div>
                        <div class="col-md-5 text-gray text-bold text-right"><span id="amt">-61 679</span></div>
                        <div class="col-md-1"></div>
                    </caption>
                    <thead>
                    <tr>
                        <th>Transaction</th>
                        <th>@if($emp->lang == 'fr') Référence @else Reference @endif</th>
                        <th>@if($emp->lang == 'fr') Description Transaction @else Transaction
                            Description @endif</th>
                        <th>@if($emp->lang == 'fr') Débit @else Debit @endif</th>
                        <th>@if($emp->lang == 'fr') Crédit @else Credit @endif</th>
                        <th>@if($emp->lang == 'fr') Balance Total @else Total Balance @endif</th>
                        <th>@if($emp->lang == 'fr') Valeur @else Value @endif</th>
                        <th>@if($emp->lang == 'fr') V... @else V... @endif</th>
                        <th>@if($emp->lang == 'fr') Bénéficiaire @else Beneficiary @endif</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="text-blue">
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
                        <td colspan="2">@if($emp->lang == 'fr') Disponible @else Available @endif</td>
                        <td><input type="text" class="text-blue op" name="tot_balance" id="tot_balance" disabled>
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
        </div>
    </div>

@stop
