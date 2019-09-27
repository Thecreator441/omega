<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Initialisation du Modèle';
else
    $title = 'Payroll Deduction Initialisation';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    <div class="box">
        <div class="box-body">
            <form action="{{ url('pay_deduct_init/store') }}" method="POST" role="form">
                {{ csrf_field() }}
                <div class="box-header with-border">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="mem_group" class="col-md-2 control-label">@if ($emp->lang == 'fr') Groupe
                                Membre @else Member Group @endif</label>
                            <div class="col-md-10">
                                <select name="mem_group" id="mem_group" class="form-control select2">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12" id="tableInput">
                    <table
                        class="table table-hover table-condensed table-responsive table-striped">
                        <caption class="text-blue text-center text-bold">Total @if($emp->lang == 'fr') Liste
                            Modèle @else Payroll List @endif
                        </caption>
                        <thead>
                        <tr>
                            <th>@if($emp->lang == 'fr') Compte @else Account @endif</th>
                            <th>@if($emp->lang == 'fr') Noms @else Names @endif</th>
                            <th>Matricule</th>
                            <th>@if($emp->lang == 'fr') Epargne @else Savings @endif</th>
                            <th>@if($emp->lang == 'fr') Dépot @else Deposit @endif</th>
                            <th>@if($emp->lang == 'fr') Part Sociale @else Shares @endif</th>
                            <th>@if($emp->lang == 'fr') Prêt @else Loans @endif</th>
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
