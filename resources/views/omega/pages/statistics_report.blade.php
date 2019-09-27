<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Statistique des Prêts ';
else
    $title = 'Statistics Report';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    <div class="box">
        <div class="box-body">
            <form action="{{ url('statistics_report/store') }}" method="POST" role="form">
                {{ csrf_field() }}
                <div class="box-header with-border">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="loan_type"
                                   class="col-md-2 control-label">@if($emp->lang == 'fr') Type de Prets @else Type
                                of Loans @endif</label>
                            <div class="col-md-10">
                                <select class="form-control select2" name="loan_type" id="loan_type">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="radio">
                                <label for="mem_acc" class="col-md-6 control-label">
                                    <input type="radio" name="filter" id="mem_acc" value="mem_acc">
                                    @if($emp->lang == 'fr') C. Membre @else Members A. @endif
                                </label>
                                <div class="col-md-6">
                                    <select class="form-control select2" name="mem_acc_numb" id="mem_acc_numb" disabled>
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="radio">
                                <label for="all_memb">
                                    <input type="radio" name="filter" id="all_memb" value="all">
                                    @if($emp->lang == 'fr') Tout les Membres @else All Members @endif
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <div class="radio">
                                <label for="male">
                                    <input type="radio" name="filter" id="male" value="male">
                                    @if($emp->lang == 'fr') Masculin @else Male @endif
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="radio">
                                <label for="female">
                                    <input type="radio" name="filter" id="female" value="female">
                                    @if($emp->lang == 'fr') Feminine @else Female @endif
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <div class="radio">
                                <label for="groups">
                                    <input type="radio" name="filter" id="groups" value="groups">
                                    @if($emp->lang == 'fr') Groupes @else Groups @endif
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="form-group">
                            <div class="radio">
                                <label for="loans_amt" class="col-md-5 control-label">
                                    <input type="radio" name="filter" id="loans_amt" value="loans_amt">
                                    @if($emp->lang == 'fr') Montant Compte @else Loan Amount @endif
                                </label>
                            </div>
                            <div class="col-md-2">
                                <select class="form-control" name="loan_amt_cond" id="loan_amt_cond" disabled>
                                    <option value=">">></option>
                                    <option value="<"><</option>
                                    <option value="=">=</option>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <input type="text" class="form-control text-right" name="loan_amt" id="loan_amt" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <label for="date1" class="col-md-4 control-label">@if($emp->lang == 'fr')
                                    Date Accord @else According Date @endif</label>
                            <div class="col-md-3">
                                <input type="text" name="date1" id="date1" class="form-control">
                            </div>
                            <label for="date2" class="col-md-2 control-label text-center">@if($emp->lang == 'fr')
                                    Et @else And @endif</label>
                            <div class="col-md-3">
                                <input type="text" name="date2" id="date2" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <table
                           class="table table-striped table-hover table-condensed table-bordered table-responsive no-padding">
                        <thead>
                        <tr>
                            <th>@if($emp->lang == 'fr') Dossier @else File @endif</th>
                            <th>@if($emp->lang == 'fr') Membre @else Member @endif</th>
                            <th>@if($emp->lang == 'fr') Nom Membre @else Member Name @endif</th>
                            <th>@if($emp->lang == 'fr') Date Demande @else Application Date @endif</th>
                            <th>@if($emp->lang == 'fr') Type de Prêt @else Loan Type @endif</th>
                            <th>@if($emp->lang == 'fr') Montant @else Amount @endif</th>
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
                        <tfoot>
                        <tr class="text-red">
                            <th>N° @if($emp->lang == 'fr') de Prêts @else of Loans @endif</th>
                            <th>00</th>
                            <th></th>
                            <th></th>
                            <th class="text-right">Total @if($emp->lang == 'fr') des Prêts @else of Loans @endif</th>
                            <th class="text-blue">00</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="oper_amount"
                               class="col-md-4 control-label">@if($emp->lang == 'fr') Montant de prets @else Number
                            of Loans @endif</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control text-right" name="loan_amt" id="loan_amt">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="oper_amount"
                               class="col-md-4 control-label">@if($emp->lang == 'fr') Total de pret @else Total of
                            Loan @endif</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control text-right" name="loan_amt" id="loan_amt">
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

@section('script')
    <script>
        $(document).ready(function () {
            $('#mem_acc').click(function () {
                if ($(this).is(":checked")) {
                    $('#mem_acc_numb').removeAttr('disabled');
                } else {
                    $('#mem_acc_numb').attr('disabled', 'disabled');
                }
            });

            $('#loans_amt').click(function () {
                if ($(this).is(":checked")) {
                    $('#loan_amt_cond').removeAttr('disabled');
                    $('#loan_amt').removeAttr('disabled');
                } else {
                    $('#loan_amt_cond').attr('disabled', 'disabled');
                    $('#loan_amt').attr('disabled', 'disabled');
                }
            });
        });
    </script>
@stop
