<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Plan Comptable';
else
    $title = 'Accounting Plan';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    <div class="box">
        <div class="box-body">
            <form action="{{ url('acc_plan/store') }}" method="POST" role="form">
                {{ csrf_field() }}
                <input type="hidden" name="id" id="id">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="plancode" class="col-md-5 control-label">Code</label>
                                <div class="col-md-7">
                                    <input type="text" name="plancode" id="plancode" class="form-control">
                                    {{--                                    <select name="code_plan" id="code_plan" class="form-control select2">--}}
                                    {{--                                        <option value=""></option>--}}
                                    {{--                                        @foreach($accplans as $accplan)--}}
                                    {{--                                            <option value="{{ $accplan->plancode }}">{{ $accplan->plancode }}</option>--}}
                                    {{--                                        @endforeach--}}
                                    {{--                                    </select>--}}
                                </div>
                            </div>
                        </div>
                        @if($emp->lang == 'fr')
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="acc_plan_name_fr" class="col-md-4 control-label">
                                        @if($emp->lang == 'fr') Libellè (Fr) @else Label (Fr) @endif</label>
                                    <div class="col-md-8">
                                        <input type="text" name="acc_plan_name_fr" id="acc_plan_name_fr"
                                               class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="acc_plan_name_eng" class="col-md-4 control-label">
                                        @if($emp->lang == 'fr') Libellè(Ang) @else Label(Eng) @endif </label>
                                    <div class="col-md-8">
                                        <input type="text" name="acc_plan_name_eng" id="acc_plan_name_eng"
                                               class="form-control">
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="acc_plan_name_eng" class="col-md-4 control-label">
                                        @if($emp->lang == 'fr') Libellè(Ang) @else Label(Eng) @endif </label>
                                    <div class="col-md-8">
                                        <input type="text" name="acc_plan_name_eng" id="acc_plan_name_eng"
                                               class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="acc_plan_name_fr" class="col-md-4 control-label">
                                        @if($emp->lang == 'fr') Libellè (Fr) @else Label (Fr) @endif</label>
                                    <div class="col-md-8">
                                        <input type="text" name="acc_plan_name_fr" id="acc_plan_name_fr"
                                               class="form-control">
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="acc_type" class="col-md-5 control-label">@if ($emp->lang == 'fr') Type
                                    Compte @else Account Type @endif</label>
                                <div class="col-md-7">
                                    <select type="text" name="acc_type" id="acc_type" class="form-control select2">
                                        <option value=""></option>
                                        @foreach($acctypes as $acctype)
                                            <option value="{{ $acctype->accabbr }}">
                                                {{ $acctype->accabbr }}
                                                @if ($emp->lang == 'fr') {{ $acctype->labelfr }} @else {{ $acctype->labeleng }} @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="acc_type" class="col-md-4 control-label">@if ($emp->lang == 'fr') Solde
                                    Min @else Min Balance @endif</label>
                                <div class="col-md-8">
                                    <input type="text" name="acc_type" id="acc_type" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="network" class="col-md-4 control-label">@if ($emp->lang == 'fr')
                                        Réseau @else Network @endif</label>
                                <div class="col-md-8">
                                    <select type="text" name="network" id="network" class="form-control select2">
                                        {{--                                        <option value=""></option>--}}
                                        @foreach($networks as $network)
                                            <option value="{{ $network->idnetwork }}">
                                                {{ $network->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row col-md-12">
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label for="adm_amor_acc">@if ($emp->lang == 'fr') Admet Compte Amortissement @else
                                            Admit Amortisation Account @endif
                                        &nbsp;&nbsp;<input type="checkbox" name="adm_amor_acc" id="adm_amor_acc">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label for="con_front_type">@if ($emp->lang == 'fr') Contrôle Saisie
                                        Front Office @else Control Front Office Typing @endif
                                        &nbsp;&nbsp;<input type="checkbox" name="con_front_type" id="con_front_type">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label for="debit_con">@if ($emp->lang == 'fr') Contrôle Débit @else Debit
                                        Control @endif
                                        &nbsp;&nbsp;<input type="checkbox" name="debit_con" id="debit_con">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row col-md-12">
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label for="cal_com">@if ($emp->lang == 'fr') Calcul Commission @else
                                            Commission Calculation @endif
                                        &nbsp;&nbsp;<input type="checkbox" name="cal_com" id="cal_com">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label for="bal_group">@if ($emp->lang == 'fr') Grouper Balance @else
                                            Balance Group @endif
                                        &nbsp;&nbsp;<input type="checkbox" name="bal_group" id="bal_group">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label for="trial_group">@if ($emp->lang == 'fr') Grouper Bilan @else Trial
                                        Balance @endif
                                        &nbsp;&nbsp;<input type="checkbox" name="trial_group" id="trial_group">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label for="int_cal">@if ($emp->lang == 'fr') Calcul Intérêt @else Interest
                                        Calculation @endif
                                        &nbsp;&nbsp;<input type="checkbox" name="int_cal" id="int_cal">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="open_cash_amt" class="col-md-6 control-label">
                                    @if ($emp->lang == 'fr') Frais Ouverture @else Opening Fees @endif
                                </label>
                                <div class="col-md-6">
                                    <input type="text" name="open_cash_amt" id="open_cash_amt" class="form-control"
                                           readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="open_cash_acc" class="col-md-4 control-label">
                                    @if ($emp->lang == 'fr') Compte Contrepartie @else Cash Account @endif
                                </label>
                                <div class="col-md-8">
                                    <select name="open_cash_acc" id="open_cash_acc" class="form-control select2">
                                        <option value=""></option>
                                        @foreach($cashaccs as $cashacc)
                                            <option value="{{ $cashacc->idaccount }}">
                                                {{ $cashacc->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="close_cash_amt" class="col-md-6 control-label">
                                    @if ($emp->lang == 'fr') Frais Fermeture @else Closing Fees @endif
                                </label>
                                <div class="col-md-6">
                                    <input type="text" name="close_cash_amt" id="close_cash_amt"
                                           class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="close_cash_acc" class="col-md-4 control-label">
                                    @if ($emp->lang == 'fr') Compte Contrepartie @else Cash Account @endif
                                </label>
                                <div class="col-md-8">
                                    <select name="close_cash_acc" id="close_cash_acc" class="form-control select2">
                                        <option value=""></option>
                                        @foreach($cashaccs as $cashacc)
                                            <option value="{{ $cashacc->idaccount }}">
                                                {{ $cashacc->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-header with-border">
                    <div class="col-md-12">
                        <div class="row text-muted">Commission</div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="col-md-6 control-label">@if($emp->lang === 'fr') Mouvement @else
                                        Movement @endif</label>
                                <label for="move_rate" class="col-md-2 control-label">@if($emp->lang === 'fr')
                                        Taux @else Rate @endif</label>
                                <div class="col-md-4">
                                    <input type="text" name="move_rate" id="move_rate" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="move_min" class="col-md-4 control-label">Min</label>
                                <div class="col-md-8">
                                    <input type="text" name="move_min" id="move_min" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="move_cash_acc" class="col-md-6 control-label">
                                    @if($emp->lang === 'fr') Compte Contrepartie @else Cash Account @endif
                                </label>
                                <div class="col-md-6">
                                    <select name="move_cash_acc" id="move_cash_acc" class="form-control select2">
                                        <option value=""></option>
                                        @foreach($cashaccs as $cashacc)
                                            <option value="{{ $cashacc->idaccount }}">
                                                {{ $cashacc->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="col-md-6 control-label">@if($emp->lang === 'fr') +Fort
                                    Decouverte @else Higher Overdraft @endif</label>
                                <label for="over_rate" class="col-md-2 control-label">@if($emp->lang === 'fr')
                                        Taux @else Rate @endif</label>
                                <div class="col-md-4">
                                    <input type="text" name="over_rate" id="over_rate" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="over_min" class="col-md-4 control-label">Min</label>
                                <div class="col-md-8">
                                    <input type="text" name="over_min" id="over_min" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="over_cash_acc" class="col-md-6 control-label">
                                    @if($emp->lang === 'fr') Compte Contrepartie @else Cash Account @endif
                                </label>
                                <div class="col-md-6">
                                    <select name="over_cash_acc" id="over_cash_acc" class="form-control select2">
                                        <option value=""></option>
                                        @foreach($cashaccs as $cashacc)
                                            <option value="{{ $cashacc->idaccount }}">
                                                {{ $cashacc->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="other1_rate" class="col-md-3 control-label">@if($emp->lang === 'fr')
                                        Autre @else Other @endif</label>
                                <div class="col-md-9">
                                    <input type="text" name="other1_rate" id="other1_rate" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="other1_min" class="col-md-4 control-label">Min</label>
                                <div class="col-md-8">
                                    <input type="text" name="other1_min" id="other1_min" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="debtor_cash_acc" class="col-md-6 control-label">
                                    @if($emp->lang === 'fr') Compte Contrepartie @else Cash Account @endif
                                </label>
                                <div class="col-md-6">
                                    <select name="other1_cash_acc" id="other1_cash_acc" class="form-control select2">
                                        <option value=""></option>
                                        @foreach($cashaccs as $cashacc)
                                            <option value="{{ $cashacc->idaccount }}">
                                                {{ $cashacc->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="other2_rate" class="col-md-3 control-label">@if($emp->lang === 'fr')
                                        Autre @else Other @endif</label>
                                <div class="col-md-9">
                                    <input type="text" name="other2_rate" id="other2_rate" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="other2_min" class="col-md-4 control-label">Min</label>
                                <div class="col-md-8">
                                    <input type="text" name="other2_min" id="other2_min" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="other2_cash_acc" class="col-md-6 control-label">
                                    @if($emp->lang === 'fr') Compte Contrepartie @else Cash Account @endif
                                </label>
                                <div class="col-md-6">
                                    <select name="other2_cash_acc" id="other2_cash_acc" class="form-control select2">
                                        <option value=""></option>
                                        @foreach($cashaccs as $cashacc)
                                            <option value="{{ $cashacc->idaccount }}">
                                                {{ $cashacc->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-header with-border">
                    <div class="col-md-12">
                        <div class="row text-muted">@if ($emp->lang == 'fr') Intérêt @else Interest @endif</div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="col-md-6 control-label">@if($emp->lang === 'fr') Débiteur @else
                                        Debitor @endif</label>
                                <label for="debtor_rate" class="col-md-2 control-label">@if($emp->lang === 'fr')
                                        Taux @else Rate @endif</label>
                                <div class="col-md-4">
                                    <input type="text" name="debtor_rate" id="debtor_rate" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="debtor_min" class="col-md-4 control-label">Min</label>
                                <div class="col-md-8">
                                    <input type="text" name="debtor_min" id="debtor_min" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="debtor_cash_acc" class="col-md-6 control-label">
                                    @if($emp->lang === 'fr') Compte Contrepartie @else Cash Account @endif
                                </label>
                                <div class="col-md-6">
                                    <select name="debtor_cash_acc" id="debtor_cash_acc" class="form-control select2">
                                        <option value=""></option>
                                        @foreach($cashaccs as $cashacc)
                                            <option value="{{ $cashacc->idaccount }}">
                                                {{ $cashacc->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="col-md-6 control-label">@if($emp->lang === 'fr') Créditeur @else
                                        Creditor @endif</label>
                                <label for="creditor_rate" class="col-md-2 control-label">@if($emp->lang === 'fr')
                                        Taux @else Rate @endif</label>
                                <div class="col-md-4">
                                    <input type="text" name="creditor_rate" id="creditor_rate" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="creditor_min" class="col-md-4 control-label">Min</label>
                                <div class="col-md-8">
                                    <input type="text" name="creditor_min" id="creditor_min" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="creditor_cash_acc" class="col-md-6 control-label">
                                    @if($emp->lang === 'fr') Compte Contrepartie @else Cash Account @endif
                                </label>
                                <div class="col-md-6">
                                    <select name="creditor_cash_acc" id="creditor_cash_acc"
                                            class="form-control select2">
                                        <option value=""></option>
                                        @foreach($cashaccs as $cashacc)
                                            <option value="{{ $cashacc->idaccount }}">
                                                {{ $cashacc->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-header with-border">
                    <div class="col-md-12">
                        <div class="row text-muted">
                            <div class="checkbox">
                                <label for="withdraw_pen">
                                    <input type="checkbox" name="withdraw_pen" id="withdraw_pen">&nbsp;&nbsp;
                                    @if ($emp->lang == 'fr') Penalité sur Rétrait @else Withdrawal on Penalty @endif
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="col-md-3"></div>
                            <label for="rate_amt" class="col-md-3 control-label">
                                @if ($emp->lang == 'fr') Taux @else Rate @endif
                            </label>
                            <div class="col-md-6">
                                <input type="text" name="rate_amt" id="open_cash_amt" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="rate_acc" class="col-md-4 control-label">
                                @if ($emp->lang == 'fr') Compte Contrepartie @else Cash Account @endif
                            </label>
                            <div class="col-md-8">
                                <select name="rate_acc" id="rate_acc" class="form-control select2">
                                    <option value=""></option>
                                    @foreach($cashaccs as $cashacc)
                                        <option value="{{ $cashacc->idaccount }}">
                                            {{ $cashacc->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <button type="submit" id="save" class="btn btn-sm bg-green pull-right fa fa-save btn-raised">
                    </button>
                </div>

                <div class="col-md-12">
                    <button type="button" id="delete" class="btn btn-sm bg-red pull-right fa fa-trash btn-raised">
                    </button>
                    <button type="button" id="edit" class="btn btn-sm bg-aqua pull-right fa fa-edit btn-raised">
                    </button>
                    <button type="button" id="new" class="btn btn-sm bg-green pull-right fa fa-file-o btn-raised">
                    </button>
                </div>
            </form>
        </div>
    </div>

@stop

@section('script')
    <script>
        $(document).ready(function () {
            let fr = $('#acc_plan_name_fr');
            let en = $('#acc_plan_name_eng');
            fr.keyup(function () {
                fr.val(fr.val().toUpperCase());
            });
            en.keyup(function () {
                en.val(en.val().toUpperCase());
            })
        });
    </script>
@stop
