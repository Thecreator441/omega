<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Rapport Bons de Retrait';
else
    $title = 'Withdrawal Report';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    <div class="box">
        <div class="box-body">
            <form action="{{ url('withdrawal-report/store') }}" method="POST" role="form">
                {{ csrf_field() }}
                <div class="box-header with-border">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="mem_acc" class="col-md-3 control-label">@if($emp->lang == 'fr')
                                    N° Compte Membre @else Member Account N° @endif</label>
                            <div class="col-md-2">
                                <input type="text" name="mem_acc" id="mem_acc" class="form-control">
                            </div>
                            <div class="col-md-7">
                                <input type="text" name="mem_name" id="mem_name" class="form-control"
                                       disabled="disabled">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-header with-border">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="unblocked" class="text-blue">
                                <input type="radio" name="blocked/unblocked" id="unblocked" class="flat-blue"
                                       checked>&nbsp;
                                @if($emp->lang == 'fr') Tout les Chèques @else All Checks @endif
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="unblocked" class="text-green">
                                <input type="radio" name="blocked/unblocked" id="unblocked" class="flat-green">&nbsp;
                                @if($emp->lang == 'fr') Chèque Payé @else Paid Check @endif
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="blocked" class="text-yellow">
                                <input type="radio" name="blocked/unblocked" id="blocked" class="flat-yellow">&nbsp;
                                @if($emp->lang == 'fr') Chèque Bloqué @else Blocked Check @endif</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="not_used" class="text-red">
                                <input type="radio" name="blocked/unblocked" id="not_used" class="flat-red">&nbsp;
                                @if($emp->lang == 'fr') Chèque Non Utilisé @else Not Used Check @endif</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-12" id="tableInput">
                    <table
                        class="table table-hover table-condensed table-responsive table-striped">
                        <caption>
                            <div class="row">
                                <div class="col-md-12 text-blue text-center text-bold">Total</div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="period" class="col-md-2 control-label">@if($emp->lang == 'fr')
                                                Période @else Period @endif</label>
                                        <div class="col-md-10">
                                            <input type="text" name="period" id="period"
                                                   class="form-control text-center">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                        </caption>
                        <thead>
                        <tr>
                            <th>@if($emp->lang == 'fr') N° Cheque @else Check N° @endif</th>
                            <th>@if($emp->lang == 'fr') Série Cheque @else Check Serie @endif</th>
                            <th>@if($emp->lang == 'fr') N° Compte @else Account N° @endif</th>
                            <th>@if($emp->lang == 'fr') Montant Payé @else Paid Amount @endif</th>
                            <th>@if($emp->lang == 'fr') Etat Cheque @else Cheque State @endif</th>
                            <th>@if($emp->lang == 'fr') Date Comptable @else Account Date @endif</th>
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
