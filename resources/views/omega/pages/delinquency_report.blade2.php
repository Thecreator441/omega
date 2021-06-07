<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.delinq'))

@section('content')
    <div class="box">
        <div class="box-body">
            <form action="{{ url('delinquency_report/store') }}" method="POST" role="form">
                {{ csrf_field() }}
                <div class="box-header">
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="radio">
                                <label for="delinquency">
                                    <input type="radio" name="del_tab" id="delinquency" value="delinquency">
                                    @if($emp->lang == 'fr') Délinquance @else Delinquecy @endif
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="radio">
                                <label for="aging_bal">
                                    <input type="radio" name="del_tab" id="aging_bal" value="aging_bal">
                                    @if($emp->lang == 'fr') Balance Âgée @else Aging Balance @endif
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="radio">
                                <label for="loan_off">
                                    <input type="radio" name="del_tab" id="loan_off" value="loan_off">
                                    @if($emp->lang == 'fr') Officiers de Crédit @else Loan Officer @endif
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="radio">
                                <label for="black_list">
                                    <input type="radio" name="del_tab" id="black_list" value="black_list">
                                    @if($emp->lang == 'fr') Liste Noire @else Black List @endif
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-footer with-border" id="del_report" style="display: none">
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="radio">
                                <label for="general">
                                    <input type="radio" name="filter" id="general" value="General">
                                    @if($emp->lang == 'fr') Général @else General @endif
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="radio">
                                <label for="above_savings">
                                    <input type="radio" name="filter" id="above_savings" value="above_savings">
                                    @if($emp->lang == 'fr') Plus Que les Epargnes @else Above Savings @endif
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="radio">
                                <label for="Within savings">
                                    <input type="radio" name="filter" id="Within savings" value="Within savings">
                                    @if($emp->lang == 'fr') Entre les Epargnes @else Within Savings @endif
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="date"
                                   class="col-md-6 control-label">Date</label>
                            <div class="col-md-6">
                                <input type="text" name="date" id="date" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-footer with-border" id="aging_report" style="display: none">
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="radio">
                                <label for="general">
                                    <input type="radio" name="filter" id="general" value="General">
                                    @if($emp->lang == 'fr') Général @else General @endif
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="radio">
                                <label for="above_savings">
                                    <input type="radio" name="filter" id="above_savings" value="above_savings">
                                    @if($emp->lang == 'fr') Plus Que les Epargnes @else Above Savings @endif
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="radio">
                                <label for="Within savings">
                                    <input type="radio" name="filter" id="Within savings" value="Within savings">
                                    @if($emp->lang == 'fr') Entre les Epargnes @else Within Savings @endif
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="date"
                                   class="col-md-6 control-label">@if($emp->lang == 'fr') Fin Periode @else Ending
                                Period @endif</label>
                            <div class="col-md-6">
                                <input type="text" name="date" id="date" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row col-md-12">
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="class radio">
                                    <label for="Members">
                                        <input type="radio" name="filter" id="Members" value="Members">
                                        @if($emp->lang == 'fr') Membre @else Members @endif
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="above_savings" id="above_savings">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form group">
                                <input type="text" class="form-control" name="within_savings" id="within_savings">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="ageing"
                                   class="col-md-6 control-label">@if($emp->lang == 'fr') Âgée @else
                                    Ageing @endif</label>
                            <div class="col-md-6">
                                <select class="form-control select2" name="ageing" id="ageing">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="loan_type"
                                   class="col-md-6 control-label">@if($emp->lang == 'fr') Types de Prêts @else Loan
                                Type @endif</label>
                            <div class="col-md-6">
                                <select class="form-control select2" name="loan_type" id="loan_type">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="loan_officer"
                                   class="col-md-6 control-label">@if($emp->lang == 'fr') Officier Crédit @else
                                    Credit Officer @endif</label>
                            <div class="col-md-6">
                                <select class="form-control select2" name="loan_officer" id="loan_officer">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-footer with-border" id="loan_off_report" style="display: none">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="date"
                                   class="col-md-3 control-label">Date</label>
                            <div class="col-md-9">
                                <input type="text" name="date" id="date" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
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

                <div class="box-footer with-border" id="black_report" style="display: none">
                    <div class="box-header with-border">
                        <div class="row col-md-12">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="date"
                                           class="col-md-6 control-label">@if($emp->lang == 'fr') Fin Periode @else
                                            Ending
                                            Period @endif</label>
                                    <div class="col-md-6">
                                        <input type="text" name="date" id="date" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4"></div>
                        </div>

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

                    <div class="col-md-12">
                        <table
                            class="table table-striped table-hover table-condensed table-bordered table-responsive no-padding">
                            <caption class="text-bold text-blue text-center">Total</caption>
                            <thead>
                            <tr>
                                <th>@if($emp->lang == 'fr') ... @else ... @endif</th>
                                <th>@if($emp->lang == 'fr') Membre @else Member @endif</th>
                                <th>@if($emp->lang == 'fr') Date Demande @else Application Date @endif</th>
                                <th>@if($emp->lang == 'fr') Montant Prêt @else Loan Amount @endif</th>
                                <th>@if($emp->lang == 'fr') Capital Restant @else Remaining Capital @endif</th>
                                <th>@if($emp->lang == 'fr') Dernier Remboursement @else Last
                                    Reimbursement @endif</th>
                                <th>@if($emp->lang == 'fr') Retard @else Delay @endif</th>
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

@section('script')
    <script>
        $(document).ready(function () {
            $('#delinquency').click(function () {
                if ($(this).is(":checked")) {
                    $('#del_report').css('display', 'block');
                    $('#print').attr('name', 'print_delinquency');
                    $('#aging_report').css('display', 'none');
                    $('#loan_off_report').css('display', 'none');
                    $('#black_report').css('display', 'none');
                }
            });

            $('#aging_bal').click(function () {
                if ($(this).is(":checked")) {
                    $('#aging_report').css('display', 'block');
                    $('#print').attr('name', 'print_aging_bal');
                    $('#del_report').css('display', 'none');
                    $('#loan_off_report').css('display', 'none');
                    $('#black_report').css('display', 'none');
                }
            });

            $('#loan_off').click(function () {
                if ($(this).is(":checked")) {
                    $('#loan_off_report').css('display', 'block');
                    $('#print').attr('name', 'print_loan_off');
                    $('#aging_report').css('display', 'none');
                    $('#del_report').css('display', 'none');
                    $('#black_report').css('display', 'none');
                }
            });

            $('#black_list').click(function () {
                if ($(this).is(":checked")) {
                    $('#black_report').css('display', 'block');
                    $('#print').attr('name', 'print_black_list');
                    $('#aging_report').css('display', 'none');
                    $('#del_report').css('display', 'none');
                    $('#loan_off_report').css('display', 'none');
                }
            });
        });
    </script>
@stop
