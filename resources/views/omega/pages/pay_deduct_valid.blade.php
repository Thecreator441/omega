<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Validation des Modèles';
else
    $title = 'Payroll Deduction Validation';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    <div class="box">
        <div class="box-body">
            <form action="{{ url('pay_deduct_valid/store') }}" method="POST" role="form">
                {{ csrf_field() }}
                <div class="box-header with-border">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="mem_group" class="col-md-3 control-label">@if ($emp->lang == 'fr')
                                    Groupes Membre @else Member Groups @endif</label>
                            <div class="col-md-9">
                                <select name="mem_group" id="mem_group" class="form-control select2">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="receiv_acc_numb" class="col-md-3 control-label">@if($emp->lang == 'fr')
                                    Compte Recevable @else Receivable Account @endif</label>
                            <div class="col-md-2">
                                <select name="receiv_acc_numb" id="receiv_acc_numb" class="form-control select2">
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="col-md-7">
                                <input type="text" name="receiv_acc_name" id="receiv_acc_name" class="form-control"
                                       disabled="disabled">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="debit_title" class="col-md-3 control-label">@if($emp->lang == 'fr')
                                    Titre Débit @else Debit Title @endif</label>
                            <div class="col-md-9">
                                <input type="text" name="debit_title" id="debit_title" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="credit_title" class="col-md-3 control-label">@if($emp->lang == 'fr')
                                    Titre Crédit @else Credit Title @endif</label>
                            <div class="col-md-9">
                                <input type="text" name="credit_title" id="credit_title" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="other_gen_ledger_numb"
                                           class="col-md-2 control-label">@if($emp->lang == 'fr')
                                            Autre G.L @else Other G.L @endif</label>
                                    <div class="col-md-4">
                                        <select name="other_gen_ledger_numb" id="other_gen_ledger_numb"
                                                class="form-control select2">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="other_gen_ledger_name" id="other_gen_ledger_name"
                                               class="form-control" disabled="disabled">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="member_err" class="col-md-6 control-label">@if($emp->lang == 'fr')
                                            Erreur Membre @else Member's Error @endif</label>
                                    <div class="col-md-6">
                                        <select name="member_err" id="member_err" class="form-control select2">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="period" class="col-md-4 control-label">@if($emp->lang == 'fr')
                                    Période @else Period @endif</label>
                            <div class="col-md-8">
                                <select name="period" id="period" class="form-control select2">
                                    <option value=""></option>
                                    <option value="January">@if ($emp->lang == 'fr') Janvier @else
                                            January @endif</option>
                                    <option value="February">@if ($emp->lang == 'fr') Fervrier @else
                                            February @endif</option>
                                    <option value="March">@if ($emp->lang == 'fr') Mars @else
                                            March @endif</option>
                                    <option value="April">@if ($emp->lang == 'fr') Avril @else
                                            April @endif</option>
                                    <option value="May">@if ($emp->lang == 'fr') Mai @else
                                            May @endif</option>
                                    <option value="June">@if ($emp->lang == 'fr') Juin @else
                                            June @endif</option>
                                    <option value="July">@if ($emp->lang == 'fr') Juillet @else
                                            July @endif</option>
                                    <option value="August">@if ($emp->lang == 'fr') Août @else
                                            August @endif</option>
                                    <option value="September">@if ($emp->lang == 'fr') Septembre @else
                                            September @endif</option>
                                    <option value="October">@if ($emp->lang == 'fr') Octobre @else
                                            October @endif</option>
                                    <option value="November">@if ($emp->lang == 'fr') Novembre @else
                                            November @endif</option>
                                    <option value="December">@if ($emp->lang == 'fr') Decembre @else
                                            December @endif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="checkbox">
                                <label for="day_trans"><input type="checkbox" name="day_trans" id="day_trans">
                                    @if ($emp->lang == 'fr') Transaction Journée @else Day Transaction @endif
                                </label>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" name="date" id="date" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="col-md-12" id="tableInput">
                    <table
                        class="table table-hover table-condensed table-responsive table-striped">
                        <caption class="text-blue text-center text-bold">Total @if($emp->lang == 'fr') Modéles
                            Simuler @else Payroll Simulation @endif</caption>
                        <thead>
                        <tr>
                            <th>@if($emp->lang == 'fr') Compte @else Account @endif</th>
                            <th>@if($emp->lang == 'fr') Nom du Compte @else Account Name @endif</th>
                            <th>@if($emp->lang == 'fr') Titre @else Title @endif</th>
                            <th>@if($emp->lang == 'fr') Débit @else Debit @endif</th>
                            <th>@if($emp->lang == 'fr') Crédit @else Credit @endif</th>
                            <th>Date</th>
                            <th>@if($emp->lang == 'fr') Membre @else Member @endif</th>
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
                            <td colspan="3">Total</td>
                            <td><input type="text" name="tot_debit" id="tot_debit"></td>
                            <td><input type="text" name="tot_credit" id="tot_credit"></td>
                            <td colspan="2"></td>
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
