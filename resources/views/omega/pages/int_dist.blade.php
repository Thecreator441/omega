<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Ajustage Parts Mensuelles';
else
    $title = 'Share Months Adjustment';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    <div class="box">
        <div class="box-body">
            <form action="{{ url('int_dist/store') }}" method="POST" role="form" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="box-header with-border">
                    <div class="col-md-9">
                        <div class="form-group">
                            <label for="trans_title" class="col-md-3 control-label">@if ($emp->lang == 'fr')
                                    Titre Transaction @else Transaction Title @endif</label>
                            <div class="col-md-9">
                                <input type="text" name="trans_title" id="trans_title" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="result" class="col-md-4 control-label">@if ($emp->lang == 'fr')
                                    Resultat @else Result @endif</label>
                            <div class="col-md-8">
                                <input type="text" name="result" id="result" class="form-control text-right"
                                       disabled="disabled">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="share_month" class="col-md-6 control-label">@if ($emp->lang == 'fr')
                                    Parts du Mois @else Shares Month @endif</label>
                            <div class="col-md-6">
                                <input type="text" name="share_month" id="share_month" class="form-control text-right"
                                       disabled="disabled">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="rate" class="col-md-4 control-label">@if ($emp->lang == 'fr') Taux @else
                                    Rate @endif</label>
                            <div class="col-md-8">
                                <input type="text" name="rate" id="rate" class="form-control text-right"
                                       disabled="disabled">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="total" class="col-md-3 control-label">Total</label>
                            <div class="col-md-9">
                                <input type="text" name="total" id="total" class="form-control text-right"
                                       disabled="disabled">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="result" class="col-md-4 control-label">@if ($emp->lang == 'fr')
                                    Surpluse @else Surplus @endif</label>
                            <div class="col-md-8">
                                <input type="text" name="result" id="result" class="form-control text-right"
                                       disabled="disabled">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-header with-border" id="tableInput">
                    <table class="table table-hover table-condensed table-responsive table-striped">
                        <thead>
                        <tr>
                            <th>@if($emp->lang == 'fr') Compte @else Account @endif</th>
                            <th>@if($emp->lang == 'fr') Noms du Compte @else Account Name @endif</th>
                            <th>@if($emp->lang == 'fr') Titre @else Title @endif</th>
                            <th>@if($emp->lang == 'fr') Montant @else Amount @endif</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><select name="acc_numb" id="acc_numb" style="width: 100%">
                                    <option value=""></option>
                                </select>
                            </td>
                            <td><input type="text" name="acc_name" id="acc_name" disabled="disabled"></td>
                            <td><input type="text" name="title" id="title"></td>
                            <td><input type="text" name="amount" id="amount" disabled="disabled"></td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td class="text-right" colspan="3">@if($emp->lang == 'fr') Reste Solde au @else
                                    Remaining Balance to @endif</td>
                            <td><input type="text" name="rem_amt" id="rem_amt" disabled="disabled"></td>
                        </tr>
                        <tr>
                            <td><select name="acc_numb" id="acc_numb" style="width: 100%">
                                    <option value=""></option>
                                </select>
                            </td>
                            <td><input type="text" name="acc_name" id="acc_name" disabled="disabled"></td>
                            <td><input type="text" name="title" id="title"></td>
                            <td><input type="text" name="an_amt" id="an_amt"></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="col-md-8">
                    <div class="form-group">
                        <label for="chart_acc_numb" class="col-md-3 control-label">@if ($emp->lang == 'fr')
                                Chart du Compte @else Chart of Account @endif</label>
                        <div class="col-md-2">
                            <select type="text" name="chart_acc_numb" id="chart_acc_numb" class="form-control">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-md-7">
                            <input type="text" name="chart_acc_name" id="chart_acc_name" class="form-control"
                                   disabled="disabled">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="int_acc_numb" class="col-md-6 control-label">@if ($emp->lang == 'fr')
                                Compte Intêret @else Interest Account @endif</label>
                        <div class="col-md-6">
                            <select type="text" name="int_acc_numb" id="int_acc_numb" class="form-control select2">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-12" id="tableInput">
                    <table class="table table-hover table-condensed table-responsive table-striped">
                        <caption class="text-center text-blue text-bold">Total</caption>
                        <thead>
                        <tr>
                            <th>@if($emp->lang == 'fr') Compte du Membre @else Member's Account @endif</th>
                            <th>@if($emp->lang == 'fr') Noms du Membre @else Member's Name @endif</th>
                            <th>Total @if($emp->lang == 'fr') Parts Sociale @else Shares @endif</th>
                            <th>@if($emp->lang == 'fr') Taux @else Rate @endif</th>
                            <th>@if($emp->lang == 'fr') Intêret @else Interest @endif</th>
                            <th>@if($emp->lang == 'fr') Compte @else Account @endif</th>
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
                        </tr>
                        </tbody>
                    </table>
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
