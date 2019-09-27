<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Compte Général';
else
    $title = 'General Account';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    <div class="box">
        <div class="box-body">
            <form action="{{ url('gen_account/store') }}" method="POST" role="form">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="branch_id" class="col-md-6 control-label">@if ($emp->lang == 'fr')
                                        Agence @else Branch @endif</label>
                                <div class="col-md-6">
                                    <input type="text" name="branch_id" id="branch_id" class="form-control"
                                           value="00{{$emp->idbranch}}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="branch_name" id="branch_name" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="acc_type" class="col-md-6 control-label">@if ($emp->lang == 'fr') Type
                                    Compte @else Account Type @endif</label>
                                <div class="col-md-6">
                                    <input type="text" name="acc_type" id="acc_type" class="form-control"
                                           value="00{{$emp->idbranch}}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <input type="text" name="acc_type_name" id="acc_type_name" class="form-control" readonly>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="date" class="col-md-3 control-label">Date</label>
                                <div class="col-md-9">
                                    <input type="text" name="date" id="date" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="client_ind" class="col-md-5 control-label">@if ($emp->lang == 'fr') Indices
                                    Client @else Client Index @endif</label>
                                <div class="col-md-7">
                                    <select name="client_ind" id="client_ind" class="form-control select2">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <input type="text" name="ind_type" id="ind_type" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="ind_name" id="ind_name" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="prod_code" class="col-md-4 control-label">@if ($emp->lang == 'fr') Code de
                                    Produit @else Product Code @endif</label>
                                <div class="col-md-8">
                                    <select name="prod_code" id="prod_code" class="form-control select2">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="acc_plan" class="col-md-4 control-label">@if ($emp->lang == 'fr') Plan
                                    Comptable @else Accounting Plan @endif</label>
                                <div class="col-md-8">
                                    <select name="acc_plan" id="acc_plan" class="form-control select2">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="acc_numb" class="col-md-5 control-label">@if ($emp->lang == 'fr') N°
                                    Compte @else Acccount N° @endif</label>
                                <div class="col-md-7">
                                    <select name="acc_numb" id="acc_numb" class="form-control select2">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <input type="text" name="acc_numb_type" id="acc_numb_type" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="acc_numb_name" class="col-md-4 control-label">@if ($emp->lang == 'fr')
                                        Intitulé @else Entitle @endif</label>
                                <div class="col-md-8">
                                    <input type="text" name="acc_numb_name" id="acc_numb_name" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row col-md-12">
                        <div class="form-group">
                            <label for="manager" class="col-md-2 control-label">@if ($emp->lang == 'fr')
                                    Gestionnaire @else Manager @endif</label>
                            <div class="col-md-10">
                                <select name="manager" id="manager" class="form-control select2">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row col-md-12">
                        <div class="form-group">
                            <label for="grouped_in" class="col-md-2 control-label">@if ($emp->lang == 'fr')
                                    Regrouper Dans @else Grouped In @endif</label>
                            <div class="col-md-10">
                                <select name="grouped_in" id="grouped_in" class="form-control select2">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row col-md-12">
                        <div class="form-group">
                            <label for="amo_acc" class="col-md-2 control-label">@if ($emp->lang == 'fr') Compte
                                d'Armotissement @else Amortisation Account @endif</label>
                            <div class="col-md-10">
                                <select name="amo_acc" id="amo_acc" class="form-control select2">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="recon_code" class="col-md-4 control-label">@if ($emp->lang == 'fr')
                                        Code Rapprochement @else Reconciliation Code @endif</label>
                                <div class="col-md-8">
                                    <select name="recon_code" id="recon_code" class="form-control select2">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label for="group_acc">@if ($emp->lang =='fr') Compte Regroupement @else Grouping
                                        Account @endif
                                        &nbsp;&nbsp;<input type="checkbox" name="group_acc" id="group_acc" class="flat-blue">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label for="ana_input">@if ($emp->lang =='fr') Saisie Analytique @else Analytical
                                        Input @endif
                                        &nbsp;&nbsp;<input type="checkbox" name="ana_input" id="ana_input" class="flat-blue">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label for="budget_man">@if ($emp->lang =='fr') Gestion Budget @else Budget
                                        Management @endif
                                        &nbsp;&nbsp;<input type="checkbox" name="budget_man" id="budget_man" class="flat-blue">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                </div>

                <div class="col-md-12">
                    <button type="button" id="delete" class="btn btn-sm bg-red pull-right btn-raised fa fa-trash"></button>
                    <button type="button" id="edit" class="btn btn-sm bg-aqua pull-right btn-raised fa fa-edit"></button>
                    <button type="button" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>
                </div>
            </form>
        </div>
    </div>

@stop
