<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Regularisation Caisse';
else
    $title = 'Cash Regularisation';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    <div class="box">
        <div class="box-header">
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right fa fa-close" id="home"></button>
            </div>
        </div>
        <form action="{{ url('account/cash_regularisation/store') }}" method="POST" role="form">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="acc_date" class="col-md-4 control-label">@if($emp->lang == 'fr')
                                Journée Comptable @else Accounting Date @endif</label>
                        <div class="col-md-8">
                            <input type="text" name="acc_date" id="acc_date" class="form-control"
                                   disabled="disabled">
                        </div>
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="box-header with-border">
                            <span class="text-bold text-blue h5">@if($emp->lang == 'fr') Donneur d'Ordre: CLIENT
                                COMPTE GENREAUX CLAS4 @else Order Giver: CLAS4 CLIENT GENERAL ACCOUNT @endif</span>
                    </div>
                    <div class="body">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="acc_debit" class="col-md-5 control-label">@if($emp->lang == 'fr')
                                        Compte à Débiter @else Acccount To Debit @endif</label>
                                <div class="col-md-7">
                                    <input type="text" name="acc_debit" id="acc_debit" class="form-control"
                                           placeholder="<?php echo $emp->lang === 'fr' ? 'Entrer le N° du Compte' : 'Enter the Account N°'; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <input type="text" name="acc_debit_name" id="acc_debit_name" class="form-control"
                                   disabled="disabled">
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="debit_desc" class="col-md-2 control-label">@if($emp->lang == 'fr')
                                        Description Débit @else Debit Description @endif</label>
                                <div class="col-md-10">
                                    <input type="text" name="debit_desc" id="debit_desc" class="form-control"
                                           placeholder="<?php echo $emp->lang === 'fr' ? 'Entrer la Description du Débit' : 'Enter the Debit Description'; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="oper_amount"
                                   class="col-md-5 control-label">@if($emp->lang == 'fr')
                                    Montant Opération @else Operation Amount @endif</label>
                            <div class="col-md-7">
                                <input type="text" name="oper_amount" id="oper_amount" class="form-control"
                                       placeholder="<?php echo $emp->lang === 'fr' ? 'Entrer le Montant de l\'Opération' : 'Enter the Operation Amount'; ?>"
                                       disabled="disabled">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="oper_amount"
                                   class="col-md-4 control-label">@if($emp->lang == 'fr')
                                    Référence @else Reference @endif</label>
                            <div class="col-md-8">
                                <input type="text" name="oper_amount" id="oper_amount" class="form-control"
                                       placeholder="<?php echo $emp->lang === 'fr' ? 'Entrer la Référence' : 'Enter the Reference'; ?>"
                                       disabled="disabled">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="oper_date"
                                   class="col-md-5 control-label">@if($emp->lang == 'fr')
                                    Date Opération @else Operation Date @endif</label>
                            <div class="col-md-7">
                                <input type="text" name="oper_date" id="oper_date" class="form-control"
                                       value="Operation Date" disabled="disabled">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="col-md-12">
                            <input type="text" name="amt_text" id="amt_text" class="form-control"
                                   disabled="disabled">
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="box-header with-border">
                            <span class="text-bold text-blue h5">@if($emp->lang == 'fr') Bénéficiaire: CLIENT
                                COMPTE GENREAUX CLAS5 @else Beneficiary: CLAS5 CLIENT GENERAL ACCOUNT @endif</span>
                    </div>
                    <div class="body">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="acc_credit" class="col-md-5 control-label">@if($emp->lang == 'fr')
                                        Compte à Crediter @else Acccount To Credit @endif</label>
                                <div class="col-md-7">
                                    <input type="text" name="acc_credit" id="acc_credit" class="form-control"
                                           placeholder="<?php echo $emp->lang === 'fr' ? 'Entrer le N° du Compte' : 'Enter the Account N°'; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <input type="text" name="acc_credit_name" id="acc_credit_name" class="form-control"
                                   disabled="disabled">
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="credit_desc" class="col-md-2 control-label">@if($emp->lang == 'fr')
                                        Description Credit @else Credit Description @endif</label>
                                <div class="col-md-10">
                                    <input type="text" name="credit_desc" id="credit_desc" class="form-control"
                                           placeholder="<?php echo $emp->lang === 'fr' ? 'Entrer la Description du Credit' : 'Enter the Credit Description'; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <button type="submit" name="save" id="save"
                            class="btn btn-success bg-blue pull-right btn-raised"><i
                            class="fa fa-save"></i>&nbsp; @if ($emp->lang == 'fr') ENREGISTRER @else
                            SAVE @endif
                    </button>
                </div>
            </div>
        </form>
    </div>

@stop
