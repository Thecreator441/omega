<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Historique des Prêts';
else
    $title = 'Loans History';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    <div class="box">
        <div class="box-body">
            <form action="{{ url('loan_history/store') }}" method="POST" role="form">
                {{ csrf_field() }}
                <div class="box-header with-border">
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

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="loan_type"
                                   class="col-md-4 control-label">@if($emp->lang == 'fr') Types de Prêts @else Loan
                                Type @endif</label>
                            <div class="col-md-8">
                                <select class="form-control select2" name="loan_type" id="loan_type">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="loan_officer"
                                   class="col-md-4 control-label">@if($emp->lang == 'fr') Officier Crédit @else
                                    Credit Officer @endif</label>
                            <div class="col-md-8">
                                <select class="form-control select2" name="loan_officer" id="loan_officer">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-header with-border">
                    <div class="col-md-12">
                        <table
                            class="table table-striped table-hover table-condensed table-bordered table-responsive no-padding">
                            <caption class="text-bold text-blue text-center">Total</caption>
                            <thead>
                            <tr>
                                <th>@if($emp->lang == 'fr') N° Dossier @else File N° @endif</th>
                                <th>@if($emp->lang == 'fr') Membre @else Member @endif</th>
                                <th>@if($emp->lang == 'fr') Nom Membre @else Member Name @endif</th>
                                <th>@if($emp->lang == 'fr') Date Demande @else Application Date @endif</th>
                                <th>@if($emp->lang == 'fr') Type de Prêt @else Loan Type @endif</th>
                                <th>@if($emp->lang == 'fr') Montant @else Amount @endif</th>
                                <th>@if($emp->lang == 'fr') Motif Demande @else Loan Purpose @endif</th>
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
                </div>

                <div class="col-md-12">
                    <button type="submit" name="print" id="print" class="btn btn-success bg-blue pull-right btn-raised">
                        <i class="fa fa-print"></i>&nbsp; @if ($emp->lang == 'fr') IMPRIMER @else PRINT @endif
                    </button>
                </div>
            </form>
        </div>
    </div>

@stop
