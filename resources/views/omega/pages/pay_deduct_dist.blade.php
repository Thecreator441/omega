<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Distribution des Modèles';
else
    $title = 'Payroll Deduction Distribution';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    <div class="box">
        <div class="box-body">
            <form action="{{ url('pay_deduct_dist/store') }}" method="POST" role="form">
                {{ csrf_field() }}
                <div class="box-header with-border">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="mem_group" class="col-md-2 control-label">@if ($emp->lang == 'fr')
                                    Groupe
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
                            <th>@if($emp->lang == 'fr') Prêt1 @else Loan1 @endif</th>
                            <th>@if($emp->lang == 'fr') Intêrét1 @else Interest1 @endif</th>
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

    <div class="box" id="newForm" style="display: inline-block;">
        <div class="box-header">
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right" id="exitForm">
                    <i class="fa fa-close"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <form action="{{ url('pay_deduct_dist/store') }}" method="POST" role="form">
                {{ csrf_field() }}
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <input type="text" name="member" id="member" class="form-control" disabled="disabled">
                </div>
                <div class="col-md-1"></div>

                <div class="col-md-12" id="tableInput">
                    <table
                        class="table table-hover table-condensed table-responsive table-striped">
                        <thead>
                        <tr class="bg-antiquewhite">
                            <th>@if($emp->lang == 'fr') Epargne @else Savings @endif</th>
                            <th>@if($emp->lang == 'fr') Dépot @else Deposit @endif</th>
                            <th>@if($emp->lang == 'fr') Autre Général @else Other General @endif</th>
                            <th>@if($emp->lang == 'fr') Autre Ind. @else Other Ind. @endif</th>
                            <th>@if($emp->lang == 'fr') Compte Ind. @else Ind. Account @endif</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><input type="text" name="savings" id="savings"></td>
                            <td><input type="text" name="deposit" id="deposit"></td>
                            <td><input type="text" name="other_gen" id="other_gen"></td>
                            <td><input type="text" name="other_ind" id="other_ind"></td>
                            <td><input type="text" name="ind_account" id="ind_account"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-12" id="tableInput">
                    <table
                        class="table table-hover table-condensed table-responsive table-striped">
                        <caption>
                            <div class="col-md-5 bg-maroon-gradient"></div>
                            <div class="col-md-2 text-center bg-blue text-bold">
                                @if($emp->lang == 'fr') Informations Prêts @else Loans Informations @endif
                            </div>
                            <div class="col-md-5 bg-maroon-gradient"></div>
                        </caption>
                        <thead>
                        <tr>
                            <th>@if($emp->lang == 'fr') Compte @else Account @endif</th>
                            <th>@if($emp->lang == 'fr') Type de Prêt @else Loan Type @endif</th>
                            <th>@if($emp->lang == 'fr') Balance Prêt @else Loan Balance @endif</th>
                            <th>@if($emp->lang == 'fr') Interet @else Interest @endif</th>
                            <th>@if($emp->lang == 'fr') N° d'Echeance @else N° of Installment @endif</th>
                            <th>@if($emp->lang == 'fr') Date d'Opération @else Operation Date @endif</th>
                            <th>@if($emp->lang == 'fr') Taux d'Interet @else Interest Rate @endif</th>
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
                    </table>
                </div>

                <div class="col-md-12" id="tableInput">
                    <table
                        class="table table-hover table-condensed table-responsive table-striped">
                        <thead>
                        <tr class="bg-blue">
                            <th>@if($emp->lang == 'fr') Ordre des Prêts @else Order of Loans @endif</th>
                            <th>@if($emp->lang == 'fr') Compte Prêt @else Loan Account @endif</th>
                            <th>@if($emp->lang == 'fr') Paiement des Prêt @else Loan Repayment @endif</th>
                            <th>@if($emp->lang == 'fr') Intêret des Prêt @else Loan Interest @endif</th>
                            <th>@if($emp->lang == 'fr') Amendes @else Fines @endif</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>@if($emp->lang == 'fr') Premier Prêt Membre @else Member First Loan @endif</td>
                            <td><input type="text" name="loan_acc" id="loan_acc"></td>
                            <td><input type="text" name="loan_repay" id="loan_repay"></td>
                            <td><input type="text" name="loan_int" id="loan_int"></td>
                            <td><input type="text" name="fines" id="fines"></td>
                        </tr>
                        <tr>
                            <td>@if($emp->lang == 'fr') Deuxieme Prêt Membre @else Member Seconde Loan @endif</td>
                            <td><input type="text" name="loan_acc" id="loan_acc"></td>
                            <td><input type="text" name="loan_repay" id="loan_repay"></td>
                            <td><input type="text" name="loan_int" id="loan_int"></td>
                            <td><input type="text" name="fines" id="fines"></td>
                        </tr>
                        <tr>
                            <td>@if($emp->lang == 'fr') Troisieme Prêt Membre @else Member Third Loan @endif</td>
                            <td><input type="text" name="loan_acc" id="loan_acc"></td>
                            <td><input type="text" name="loan_repay" id="loan_repay"></td>
                            <td><input type="text" name="loan_int" id="loan_int"></td>
                            <td><input type="text" name="fines" id="fines"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-3"></div>
                <div class="col-md-2">
                    <input type="text" name="loan_acc" id="loan_acc" class="form-control">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary bg-blue">Initialise</button>
                </div>
                <div class="col-md-2">
                    <input type="text" name="loan_acc" id="loan_acc" class="form-control">
                </div>
                <div class="col-md-3"></div>

                <div class="col-md-12">
                    <button type="submit" name="save" id="save" class="btn btn-success bg-blue pull-right btn-raised">
                        <i class="fa fa-save"></i>&nbsp; @if ($emp->lang == 'fr') ENREGISTRER @else SAVE @endif
                    </button>
                </div>
            </form>
        </div>
    </div>

@stop
