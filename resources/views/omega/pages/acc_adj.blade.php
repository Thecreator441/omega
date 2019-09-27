<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Ajustage Comptable';
else
    $title = 'Accounting Adjustment';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    <div class="box">
        <div class="box-body">
            <form action="{{ url('acc_adj/store') }}" method="POST" role="form">
                {{ csrf_field() }}
                <div class="box-header with-border">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="reference" class="col-md-3 control-label">@if($emp->lang == 'fr')
                                    Référence @else Reference @endif</label>
                            <div class="col-md-9">
                                <input type="text" name="reference" id="reference" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="debit" class="col-md-3 control-label">@if($emp->lang == 'fr') Débit @else
                                Debit @endif</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control text-blue text-right" name="debit" id="debit">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="credit" class="col-md-3 control-label">@if($emp->lang == 'fr') Crédit @else
                                Credit @endif</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control text-blue text-right" name="credit" id="credit">
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="trans_key" class="col-md-2 control-label">@if($emp->lang == 'fr') Clé
                            Transaction @else Transaction Key @endif</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="trans_key" id="trans_key">
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="trans_name" id="trans_name">
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="acc_numb" class="col-md-2 control-label">@if($emp->lang == 'fr') Numéro
                            Compte @else Account Number @endif</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="acc_numb" id="acc_numb">
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="acc_name" id="acc_name" disabled="disabled">
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="debit_amt" class="col-md-6 control-label">@if($emp->lang == 'fr')
                                Montant Débit @else Debit Amount @endif</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control text-right" name="debit_amt" id="debit_amt">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="credit_amt" class="col-md-6 control-label">@if($emp->lang == 'fr')
                                Montant Crédit @else Credit Amount @endif</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control text-right" name="credit_amt" id="credit_amt">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="ref_trans" class="col-md-8 control-label">@if($emp->lang == 'fr') Référence
                            Transaction @else Transaction Reference @endif</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="ref_trans" id="ref_trans">
                        </div>
                    </div>
                </div>

                <div class="col-md-12" id="tableInput">
                    <table class="table table-hover table-condensed table-responsive table-striped">
                        <thead>
                        <tr>
                            <th>@if($emp->lang == 'fr') Numéro Compte @else Account Number @endif</th>
                            <th>@if($emp->lang == 'fr') Clé Transaction @else Transaction Key @endif</th>
                            <th>@if($emp->lang == 'fr') Date Transaction @else Transaction Date @endif</th>
                            <th>@if($emp->lang == 'fr') Débit @else Debit @endif</th>
                            <th>@if($emp->lang == 'fr') Crédit @else Credit @endif</th>
                            <th>@if($emp->lang == 'fr')  @else  @endif</th>
                            <th>@if($emp->lang == 'fr') Référence @else Reference @endif</th>
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
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td>Total @if($emp->lang == 'fr') Débit @else Debit @endif</td>
                            <td><input type="text" class="text-blue op" name="tot_debit" id="tot_debit" disabled>
                            </td>
                            <td>Total @if($emp->lang == 'fr') Crédit @else Credit @endif</td>
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
