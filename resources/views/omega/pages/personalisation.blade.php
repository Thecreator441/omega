<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Personnalisation de Bon de Retrait';
else
    $title = 'Withdrawal Slip Personalisation';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    <div class="box">
        <div class="box-body">
            <form action="{{ url('personalisation/store') }}" method="POST" role="form">
                {{ csrf_field() }}
                <div class="box-header with-border">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date" class="col-md-4 control-label">@if($emp->lang == 'fr')
                                    Date Comptable @else Accounting Date @endif</label>
                            <div class="col-md-8">
                                <input type="text" name="date" id="date" class="form-control" disabled="disabled">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>

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

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="check_serie" class="col-md-4 control-label">@if($emp->lang == 'fr')
                                Série de Cheque @else Check Serie @endif</label>
                        <div class="col-md-8">
                            <select class="form-control select2" name="check_serie" id="check_serie">
                                <option></option>
                                <option value="AA">AA</option>
                                <option value="BB">BB</option>
                                <option value="LL">LL</option>
                                <option value="RR">RR</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="check_numb"
                               class="col-md-4 control-label">@if($emp->lang == 'fr') N° de Cheque @else
                                N° of Check @endif</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="check_numb" id="check_numb">
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="beg_check_numb"
                               class="col-md-2 control-label">@if($emp->lang == 'fr') Début N°
                            Cheque @else Begin Check N° @endif</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="beg_check_numb" id="beg_check_numb">
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="end_check_numb"
                               class="col-md-2 control-label">@if($emp->lang == 'fr') Fin N° Cheque @else End Check
                            N° @endif</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="end_check_numb" id="end_check_numb">
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
