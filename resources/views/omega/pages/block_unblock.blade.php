<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Opposition/Annulation Opposition';
else
    $title = 'Block/Unblock';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    <div class="box">
        <div class="box-body">
            <form action="{{ url('block_unblock/store') }}" method="POST" role="form">
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

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="blocked" class="text-red">
                                        <input type="radio" name="blocked/unblocked" id="blocked" class="flat-red">&nbsp;
                                        @if($emp->lang == 'fr') Cheque Bloqué @else Blocked Check @endif</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="unblocked" class="text-green">
                                        <input type="radio" name="blocked/unblocked" id="unblocked" class="flat-green">&nbsp;
                                        @if($emp->lang == 'fr') Cheque Débloqué @else Unblocked Check @endif
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                    </div>
                </div>

                <div class="box-header with-border">
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

                <div class="col-md-12" id="tableInput">
                    <table
                        class="table table-hover table-condensed table-responsive table-striped">
                        <caption class="text-blue text-center text-bold">Total</caption>
                        <thead>
                        <tr>
                            <th>@if($emp->lang == 'fr') N° Cheque @else Check N° @endif</th>
                            <th>@if($emp->lang == 'fr') Série Cheque @else Check Serie @endif</th>
                            <th>@if($emp->lang == 'fr') Montant Payé @else Paid Amount @endif</th>
                            <th>@if($emp->lang == 'fr') Etat Cheque @else Cheque State @endif</th>
                            <th>@if($emp->lang == 'fr') Date Comptable @else Account Date @endif</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-blue">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr class="text-blue text-right bg-antiquewhite">
                            <td>@if($emp->lang == 'fr') Paiement @else Payment @endif</td>
                            <td style="width: 15%"><input type="text" class="text-right text-blue text-bold"
                                                          name="payment"
                                                          id="payment" value="3" disabled></td>
                            <td>@if($emp->lang == 'fr') Chèque Non Payé @else Unpaid Check @endif</td>
                            <td style="width: 15%"><input type="text" class="text-right text-blue text-bold"
                                                          name="unpaid_check"
                                                          id="unpaid_check" value="0" disabled></td>
                            <td></td>
                        </tr>
                        </tfoot>
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
@stop
