<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Historique Membre';
else
    $title = 'Member History';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    <div class="box">
        <div class="box-body">
            <div class="box-header with-border">
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="mem_numb" class="col-md-4 control-label">@if($emp->lang == 'fr')
                                N° Membre @else Member N° @endif</label>
                        <div class="col-md-8">
                            <select name="mem_numb" id="mem_numb" class="form-control select2">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <input type="text" name="mem_name" id="mem_name" class="form-control"
                           disabled="disabled">
                </div>

                <div class="col-md-5">
                    <div class="form-group">
                        <label for="acc_from" class="col-md-4 control-label">@if($emp->lang == 'fr')
                                Du Compte @else From Account @endif</label>
                        <div class="col-md-8">
                            <select name="acc_to" id="acc_from" class="form-control select2">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-2" style="background: purple; height:35px; margin-top: 27px;"></div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="acc_to" class="col-md-4 control-label">@if($emp->lang == 'fr')
                                Au Compte @else To Account @endif</label>
                        <div class="col-md-8">
                            <select name="acc_to" id="acc_to" class="form-control select2">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-3"></div>
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
                <div class="col-md-3"></div>
            </div>

            <div class="col-md-12" id="tableInput">
                <table
                    class="table table-hover table-condensed table-responsive table-striped">
                    <caption class="text-blue text-center text-bold">Total</caption>
                    <thead>
                    <tr>
                        <th>@if($emp->lang == 'fr') Référence @else Reference @endif</th>
                        <th>@if($emp->lang == 'fr') Intitulé Compte @else Account Title @endif</th>
                        <th>@if($emp->lang == 'fr') Libellé @else Label @endif</th>
                        <th>@if($emp->lang == 'fr') Débit @else Debit @endif</th>
                        <th>@if($emp->lang == 'fr') Crédit @else Credit @endif</th>
                        <th>@if($emp->lang == 'fr') Date Opération @else Operation Date @endif</th>
                        <th>@if($emp->lang == 'fr') Valeur @else Value @endif</th>
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
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr class="text-right">
                        <td>Total @if($emp->lang == 'fr') Débit @else Debit @endif</td>
                        <td><input type="text" class="text-blue op" name="tot_debit" id="tot_debit" disabled>
                        </td>
                        <td>Total @if($emp->lang == 'fr') Crédit @else Credit @endif</td>
                        <td><input type="text" class="text-blue op" name="tot_credit" id="tot_credit" disabled>
                        </td>
                        <td colspan="2">Total @if($emp->lang == 'fr') Solde @else Balance @endif</td>
                        <td><input type="text" class="text-blue op" name="tot_balance" id="tot_balance" disabled>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>

            <div class="col-md-12">
                <button type="button" name="save" id="save" class="btn btn-success bg-blue pull-right btn-raised">
                    <i class="fa fa-save"></i>&nbsp; @if ($emp->lang == 'fr') ENREGISTRER @else SAVE @endif
                </button>
            </div>
        </div>
    </div>

@stop
