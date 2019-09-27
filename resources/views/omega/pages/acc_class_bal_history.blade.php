<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Historique Balance Class Comptable';
else
    $title = 'Account Class Balance History';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    <div class="box">
        <div class="box-body">
            <div class="box-header with-border">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="acc_class_numb" class="col-md-2 control-label">@if($emp->lang == 'fr')
                                Classe Comptable @else Account Class @endif</label>
                        <div class="col-md-2">
                            <select name="acc_class_numb" id="acc_class_numb" class="form-control select2">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="acc_class_name_name" id="acc_class_name_name" class="form-control"
                                   disabled="disabled">
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
                        <label for="class_bal_report" class="col-md-6 control-label">@if($emp->lang == 'fr')
                                Rapport Solde Classe @else Class Balance Report @endif</label>
                        <div class="col-md-6">
                            <input type="text" name="class_bal_report" id="class_bal_report" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12" id="tableInput">
                <table
                    class="table table-hover table-condensed table-responsive table-striped">
                    <caption class="text-center text-blue text-bold">Total</caption>
                    <thead>
                    <tr>
                        <th>@if($emp->lang == 'fr') Référence @else Reference @endif</th>
                        <th>@if($emp->lang == 'fr') Compte @else Account @endif</th>
                        <th>@if($emp->lang == 'fr') Membre @else Member @endif</th>
                        <th>@if($emp->lang == 'fr') Description Transaction @else Transaction
                            Description @endif</th>
                        <th>@if($emp->lang == 'fr') Montant Débit @else Debit Amount @endif</th>
                        <th>@if($emp->lang == 'fr') Montant Crédit @else Credit Amount @endif</th>
                        <th>@if($emp->lang == 'fr') Solde @else Balance @endif</th>
                        <th>@if($emp->lang == 'fr') Transaction... @else Transaction... @endif</th>
                        <th>@if($emp->lang == 'fr') C... @else C... @endif</th>
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
                        <td colspan="2">@if($emp->lang == 'fr') Solde Total @else Total Balance @endif</td>
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
