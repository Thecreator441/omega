<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Initialisation des Charges/Produits';
else
    $title = 'Income/Expenses Initialisation';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    <div class="box">
        <div class="box-body">
            <form action="{{ url('inc-exp_init/store') }}" method="POST" role="form">
                {{ csrf_field() }}
                <div class="box-header with-border">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date" class="col-md-4 control-label">@if($emp->lang == 'fr')
                                    Date Imputation @else Imputation Date @endif</label>
                            <div class="col-md-8">
                                <input type="text" name="date" id="date" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="income" class="col-md-2 control-label">@if($emp->lang == 'fr')
                                Libelle Charge @else Income Label @endif</label>
                        <div class="col-md-10">
                            <input type="text" name="income" id="income" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="expenses" class="col-md-2 control-label">@if($emp->lang == 'fr')
                                Libelle Produit @else Expense Label @endif</label>
                        <div class="col-md-10">
                            <input type="text" name="expenses" id="expenses" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="result" class="col-md-2 control-label">@if($emp->lang == 'fr')
                                Libelle Resultat @else Result Label @endif</label>
                        <div class="col-md-10">
                            <input type="text" name="result" id="result" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="acc_result" class="col-md-4 control-label">@if($emp->lang == 'fr')
                                Resultat Compte @else Account Result @endif</label>
                        <div class="col-md-8">
                            <input type="text" name="acc_result" id="acc_result" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <input type="text" name="income" id="income" class="form-control" disabled="disabled">
                </div>

                <div class="col-md-12">
                    <div class="form-group text-center">
                        <label for="">@if($emp->lang == 'fr')Tratitement Compte Classe 6 @else Class 6 Account
                            Treatment @endif</label>
                        <div class="progress progress-xxs active">
                            <div class="progress-bar progress-bar-light-blue progress-bar-striped"
                                 role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                                 style="width: 10%">
                                <span class="sr-only">40% Complete (success)</span>
                            </div>
                        </div>
                    </div>
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
