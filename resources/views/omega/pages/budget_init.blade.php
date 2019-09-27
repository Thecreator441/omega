<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Initialisation Budget';
else
    $title = 'Budget Initialisation';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    <div class="box">
        <div class="box-body">
            <form action="{{ url('budget_init/store') }}" method="POST" role="form">
                {{ csrf_field() }}
                <div class="box-header with-border">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="acc_numb" class="col-md-2 control-label">@if($emp->lang == 'fr') N°
                                Compte @else Account N° @endif</label>
                            <div class="col-md-2">
                                <select class="form-control select2" name="acc_numb" id="acc_numb">
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="acc_name" id="acc_name" class="form-control"
                                       disabled="disabled">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="budget_line" class="col-md-2 control-label">@if($emp->lang == 'fr') Ligne
                                Budgetaire @else Budgetary Line @endif</label>
                            <div class="col-md-10">
                                <select class="form-control select2" name="budget_line" id="budget_line" disabled="disabled">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="budget_amt" class="col-md-2 control-label">@if($emp->lang == 'fr') Montant
                                Budget @else Budget Amount @endif</label>
                            <div class="col-md-2">
                                <input type="text" name="budget_amt" id="budget_amt" class="form-control text-right">
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="budget" id="budget" class="form-control" disabled="disabled">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="box-header with-border">
                        <div class="col-md-5">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="jan_amt"
                                           class="col-md-3 text-black control-label">@if ($emp->lang == 'fr') Janvier @else
                                            January @endif</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control text-right" name="jan_amt" id="jan_amt">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="feb_amt"
                                           class="col-md-3 text-black control-label">@if ($emp->lang == 'fr')
                                            Fervrier @else
                                            February @endif</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control text-right" name="feb_amt" id="feb_amt">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="mar_amt"
                                           class="col-md-3 text-black control-label">@if ($emp->lang == 'fr') Mars @else
                                            March @endif</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control text-right" name="mar_amt" id="mar_amt">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="apr_amt"
                                           class="col-md-3 text-black control-label">@if ($emp->lang == 'fr') Avril @else
                                            April @endif</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control text-right" name="apr_amt" id="apr_amt">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="may_amt"
                                           class="col-md-3 text-black control-label">@if ($emp->lang == 'fr') Mai @else
                                            May @endif</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control text-right" name="may_amt" id="may_amt">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="jun_amt"
                                           class="col-md-3 text-black control-label">@if ($emp->lang == 'fr') Juin @else
                                            June @endif</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control text-right" name="jun_amt" id="jun_amt">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="col-md-5"></div>
                            <div class="col-md-2" style="background: pink; height: 400px; margin-top: 35px;"></div>
                            <div class="col-md-5"></div>
                        </div>
                        <div class="col-md-5">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="jul_amt"
                                           class="col-md-3 text-black control-label">@if ($emp->lang == 'fr') Juillet @else
                                            July @endif</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control text-right" name="jul_amt" id="jul_amt">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="aug_amt"
                                           class="col-md-3 text-black control-label">@if ($emp->lang == 'fr') Août @else
                                            August @endif</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control text-right" name="aug_amt" id="aug_amt">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="sep_amt"
                                           class="col-md-3 text-black control-label">@if ($emp->lang == 'fr')
                                            Septembre @else
                                            September @endif</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control text-right" name="sep_amt" id="sep_amt">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="oct_amt"
                                           class="col-md-3 text-black control-label">@if ($emp->lang == 'fr') Octobre @else
                                            October @endif</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control text-right" name="oct_amt" id="oct_amt">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="nov_amt"
                                           class="col-md-3 text-black control-label">@if ($emp->lang == 'fr')
                                            Novembre @else
                                            November @endif</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control text-right" name="nov_amt" id="nov_amt">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="dec_amt"
                                           class="col-md-3 text-black control-label">@if ($emp->lang == 'fr')
                                            Decembre @else
                                            December @endif</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control text-right" name="dec_amt" id="dec_amt">
                                    </div>
                                </div>
                            </div>
                        </div>
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
