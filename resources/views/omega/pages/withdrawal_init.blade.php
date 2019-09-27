<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Initialisation Bons de Retrait';
else
    $title = 'Withdrawal Slip Initialisation';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    <div class="box">
        <div class="box-body">
            <form action="{{ url('withdrawal_init/store') }}" method="POST" role="form">
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

                <div class="col-md-8">
                    <div class="form-group">
                        <label for="check_type" class="col-md-3 text-black control-label">@if($emp->lang == 'fr')
                                Type de Cheque @else Check Type @endif</label>
                        <div class="col-md-9">
                            <select class="form-control select2" name="check_type" id="check_type">
                                <option></option>
                                <option value="Counter">@if($emp->lang == 'fr') Guichet @else
                                        Counter @endif</option>
                                <option value="Member">@if($emp->lang == 'fr') Membre @else Member @endif</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="serie"
                               class="col-md-2 text-black control-label">@if($emp->lang == 'fr') Série @else
                                Serie @endif</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="serie" id="serie">
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="beg_check_numb"
                               class="col-md-2 text-black control-label">@if($emp->lang == 'fr') Début N°
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
