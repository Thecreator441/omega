<?php $emp = session()->get('employee'); ?>

@extends('layouts.dashboard')

@section('title', 'Special')

@section('content')

    <div class="box">
        <div class="box-body">
            <form action="{{ url('special/store') }}" method="POST" role="form">
                {{ csrf_field() }}
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="mem1_numb" class="col-md-2 control-label">@if ($emp->lang == 'fr')
                                Membre 1 @else Member 1 @endif</label>
                        <div class="col-md-2">
                            <input type="text" name="mem1_numb" id="mem1_numb" class="form-control">
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="mem1_name" id="mem1_name" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="mem2_numb" class="col-md-2 control-label">@if ($emp->lang == 'fr')
                                Membre 2 @else Member 2 @endif</label>
                        <div class="col-md-2">
                            <input type="text" name="mem2_numb" id="mem2_numb" class="form-control">
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="mem2_name" id="mem2_name" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="debit_title" class="col-md-4 control-label">@if ($emp->lang == 'fr') Titre
                            Débit @else Debit Title @endif</label>
                        <div class="col-md-8">
                            <input type="text" name="debit_title" id="debit_title" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="credit_title" class="col-md-3 control-label">@if ($emp->lang == 'fr') Titre
                            Crédit @else
                                Credit Title @endif</label>
                        <div class="col-md-9">
                            <input type="text" name="credit_title" id="credit_title" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="credit_title" class="col-md-6 control-label">@if ($emp->lang == 'fr') Compte a
                            Débiter @else
                                Account to Debit @endif</label>
                        <div class="col-md-6">
                            <input type="text" name="credit_title" id="credit_title" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="ledger" class="col-md-6 control-label">@if ($emp->lang == 'fr') General
                            Ledger @else
                                General Ledger @endif</label>
                        <div class="col-md-6">
                            <input type="text" name="ledger" id="ledger" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="st_amount" class="col-md-6 control-label">@if ($emp->lang == 'fr') Montant du
                            S.T @else Amount of S.T @endif</label>
                        <div class="col-md-6">
                            <input type="text" name="st_amount" id="st_amount" class="form-control text-right">
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="box-footer with-border"></div>
                    <div class="col-md-12 ">
                        <div class="col-md-5 bg-maroon-gradient"></div>
                        <div class="col-md-2 text-center text-blue text-bold">
                            @if($emp->lang == 'fr') Transfert Spécial @else Special Transfer @endif
                        </div>
                        <div class="col-md-5 bg-maroon-gradient"></div>
                    </div>
                    <table
                        class="table table-striped table-hover table-condensed table-bordered table-responsive no-padding">
                        <thead>
                        <tr class="bg-purples">
                            <th>@if($emp->lang == 'fr') Compte @else Account @endif</th>
                            <th>@if($emp->lang == 'fr') Titre @else Title @endif</th>
                            <th>@if($emp->lang == 'fr') Débit @else Debit @endif</th>
                            <th>@if($emp->lang == 'fr') Crédit @else Credit @endif</th>
                            <th>Date</th>
                            <th>@if($emp->lang == 'fr') Membre @else Member @endif</th>
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
                        <i class="fa fa-save"></i>&nbsp; @if ($emp->lang == 'fr') ENREGISTRER @else SAVE @endif
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop
