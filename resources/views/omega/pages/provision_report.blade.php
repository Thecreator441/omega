<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Rapport Provision des Prêts';
else
    $title = 'Loans Provision Report';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    <div class="box">
        <div class="box-body">
            <form action="{{ url('provision_report/store') }}" method="POST" role="form">
                {{ csrf_field() }}
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

                <div class="col-md-12">
                    <button type="submit" name="print" id="print" class="btn btn-sm bg-blue pull-right btn-raised">
                        <i class="fa fa-print"></i>&nbsp;
                    </button>
                </div>
            </form>
        </div>
    </div>

@stop
