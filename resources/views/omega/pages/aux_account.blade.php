<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Compte Auxiliaire';
else
    $title = 'Auxiliary Account';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    <div class="box">
        <div class="box-body">
            <form action="{{ url('aux_account/store') }}" method="POST" role="form">
                <div class="box-header with-border">
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
                        <input type="text" name="acc_type_name" id="acc_type_name" class="form-control"
                               readonly>
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

                <div class="box-header with-border">
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
                        <input type="text" name="acc_numb_type" id="acc_numb_type" class="form-control"
                               readonly>
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

                    <div class="col-md-12">
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

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="group" class="col-md-2 control-label">@if ($emp->lang == 'fr')
                                    Groupe @else Group @endif</label>
                            <div class="col-md-10">
                                <select name="group" id="group" class="form-control select2">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label for="princ_acc">@if ($emp->lang =='fr') Compte Principal @else Principal
                                        Account @endif
                                        &nbsp;<input type="checkbox" name="princ_acc" id="princ_acc">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label for="check_deliv">@if ($emp->lang =='fr') Délivrance Chequier @else Check
                                        Delivery @endif
                                        &nbsp;<input type="checkbox" name="check_deliv" id="check_deliv">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label for="exo_taxes">@if ($emp->lang =='fr') Exonerer Taxe @else Exonerates
                                        Taxe @endif
                                        &nbsp;<input type="checkbox" name="exo_taxes" id="exo_taxes">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
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

                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label for="change_addr"><span class="text-green text-bold">@if ($emp->lang == 'fr')
                                                Changer d'Addresse ? @else Change Address ? @endif</span>
                                        &nbsp;<input type="checkbox" name="change_addr" id="change_addr">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="changeAddr" style="display: none">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="town" class="col-md-3 control-label">@if ($emp->lang == 'fr')
                                            Ville @else Town @endif</label>
                                    <div class="col-md-9">
                                        <input type="text" name="town" id="town" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="post_addr"
                                           class="col-md-3 control-label">@if ($emp->lang == 'fr')
                                            Addresse Postal @else Postal Address @endif</label>
                                    <div class="col-md-9">
                                        <input type="text" name="post_addr" id="post_addr" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="phone" class="col-md-4 control-label">@if ($emp->lang == 'fr')
                                            Téléphone @else Phone @endif</label>
                                    <div class="col-md-8">
                                        <input type="text" name="phone" id="phone" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fax" class="col-md-3 control-label">Fax</label>
                                    <div class="col-md-9">
                                        <input type="text" name="fax" id="fax" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email" class="col-md-3 control-label">Email</label>
                                    <div class="col-md-9">
                                        <input type="email" name="email" id="email" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <button type="button" id="save" class="btn btn-sm bg-blue pull-right btn-raised">
                        <i class="fa fa-save"></i>&nbsp;
                    </button>
                    <button type="button" id="edit" class="btn btn-sm bg-aqua pull-right btn-raised">
                        <i class="fa fa-edit"></i>&nbsp;
                    </button>
                    <button type="button" id="new" class="btn btn-sm bg-green pull-right btn-raised">
                        <i class="fa fa-plus"></i>&nbsp;
                    </button>
                </div>
            </form>
        </div>
    </div>

@stop
