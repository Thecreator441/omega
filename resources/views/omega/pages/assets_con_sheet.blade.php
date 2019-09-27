<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Feuille de Contrôle Active';
else
    $title = 'Assets Control Sheet';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    <div class="box">
        <div class="box-body">
            <form action="{{ url('assets_con_sheet/store') }}" method="POST" role="form">
                {{ csrf_field() }}
                <div class="box-header with-border">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="acc_numb1" class="col-md-2 control-label">@if($emp->lang == 'fr') Compte @else Account @endif</label>
                            <div class="col-md-2">
                                <select class="form-control select2" name="acc_numb1" id="acc_numb1">
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="acc_name1" id="acc_name1" class="form-control" disabled="disabled">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="acc_numb2" class="col-md-2 control-label">@if($emp->lang == 'fr') Compte @else Account @endif</label>
                            <div class="col-md-2">
                                <select class="form-control select2" name="acc_numb2" id="acc_numb2">
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="acc_name2" id="acc_name2" class="form-control" disabled="disabled">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="col-md-12" id="tableInput">
                        <table id="bootstrap-data-table"
                            class="table table-hover table-condensed table-responsive table-striped">
                            <thead>
                            <tr>
                                <th>@if($emp->lang == 'fr') Compte @else Account @endif</th>
                                <th>@if($emp->lang == 'fr') Ligne Budgetaire @else Budgetary Line @endif</th>
                                <th>@if($emp->lang == 'fr') Estimation @else Estimates @endif</th>
                                <th>Total Transaction</th>
                                <th>@if($emp->lang == 'fr') Différence @else Difference @endif</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="text-blue">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
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
