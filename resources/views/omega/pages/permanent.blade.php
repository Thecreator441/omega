<?php $emp = session()->get('employee'); ?>

@extends('layouts.dashboard')

@section('title', 'Permanent')

@section('content')

    <div class="box">
        <div class="box-body">
            <form action="{{ url('permanent/store') }}" method="POST" role="form">
                {{ csrf_field() }}
                <div class="col-md-7">
                    <div class="form-group">
                        <label for="file_numb" class="col-md-4 control-label">@if($emp->lang == 'fr') Numéro
                            de dossier @else File Number @endif</label>
                        <div class="col-md-2">
                            <input type="text" name="file_numb" id="file_numb" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="filename" id="filename" class="form-control" disabled="disabled">
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="date" class="col-md-6 control-label">@if($emp->lang == 'fr')Date de
                            la Transaction @else Transaction Date @endif</label>
                        <div class="col-md-6">
                            <input type="text" name="date" id="date" class="form-control"
                                   disabled="disabled">
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="box-header with-border">
                        <h4 class="text-bold text-blue">@if($emp->lang == 'fr') Donneur d'Ordre @else
                                Order Giver @endif</h4>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="acc_debit" class="col-md-2 control-label">@if($emp->lang == 'fr')
                                    Compte à Débiter @else Acccount To Debit @endif</label>
                            <div class="col-md-2">
                                <input type="text" name="acc_debit" id="acc_debit" class="form-control">
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="acc_debit_name" id="acc_debit_name" class="form-control"
                                       disabled="disabled">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="box-header with-border">
                        <h4 class="text-bold text-blue">@if($emp->lang == 'fr') Bénéficiaire @else
                                Beneficiary @endif</h4>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="acc_credit" class="col-md-2 control-label">@if($emp->lang == 'fr')
                                    Compte à Créditer @else Acccount To Credit @endif</label>
                            <div class="col-md-2">
                                <input type="text" name="acc_credit" id="acc_credit" class="form-control">
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="acc_credit_name" id="acc_credit_name" class="form-control"
                                       disabled="disabled">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="box-header with-border">
                        <h4 class="text-bold text-blue">@if($emp->lang == 'fr')Eléments
                            Administrative @else Administration Elements @endif</h4>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="imp_amount" class="col-md-8 control-label">@if($emp->lang == 'fr')
                                    Montant d'Imputation @else Imputation Amount @endif</label>
                            <div class="col-md-4">
                                <input type="text" name="imp_amount" id="imp_amount" class="form-control text-right">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="checkbox">
                                <label for="bank_over" class="control-label">@if($emp->lang == 'fr')
                                        Découvert Bancaire @else Bank Overdraft @endif
                                    <input type="checkbox" name="bank_over" id="bank_over">
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="nxt_imp_date" class="col-md-6 control-label">@if($emp->lang == 'fr')
                                    Prochaine Imputation @else Next Imputation @endif</label>
                            <div class="col-md-6">
                                <input type="text" name="nxt_imp_date" id="nxt_imp_date" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <div class="form-group">
                            <label for="freq" class="col-md-3 control-label">@if($emp->lang == 'fr')
                                    Fréquence @else Frequency @endif</label>
                            <div class="col-md-3">
                                <input type="text" name="freq" id="freq" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="freq_name" id="freq_name" class="form-control"
                                       disabled="disabled">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="numb_imp" class="col-md-6 control-label">@if($emp->lang == 'fr')
                                    N° d'Imputation @else N° of Imputation @endif</label>
                            <div class="col-md-6">
                                <input type="text" name="numb_imp" id="numb_imp" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <div class="form-group">
                            <label for="oper_desc" class="col-md-5 control-label">@if($emp->lang == 'fr')
                                    Description d'Opération @else Operation Description @endif</label>
                            <div class="col-md-7">
                                <input type="text" name="oper_desc" id="oper_desc" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="end_imp_date" class="col-md-6 control-label">@if($emp->lang == 'fr')
                                    Fin Imputation @else End Imputation @endif</label>
                            <div class="col-md-6">
                                <input type="text" name="end_imp_date" id="end_imp_date" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="col-md-12">
                        <button type="submit" name="save" id="save"
                                class="btn btn-success bg-blue pull-right btn-raised"><i
                                class="fa fa-save"></i>&nbsp;@if ($emp->lang == 'fr') ENREGISTRER @else SAVE @endif
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
