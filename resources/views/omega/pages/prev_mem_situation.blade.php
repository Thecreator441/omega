<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Situation Membre';
else
    $title = 'Member Situation';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    <div class="box">
        <div class="box-body">
            <div class="col-md-12">
                <div class="box-header with-border">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="mem_numb" class="col-md-4 control-label">@if($emp->lang == 'fr')
                                    N° Membre @else Member N° @endif</label>
                            <div class="col-md-8">
                                <select name="mem_numb" id="mem_numb" class="form-control select2">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <input type="text" name="mem_name" id="mem_name" class="form-control"
                               disabled="disabled">
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date1" class="col-md-2 control-label">@if($emp->lang == 'fr')
                                    Période @else Period @endif</label>
                            <div class="col-md-4">
                                <input type="text" name="date1" id="date1" class="form-control">
                            </div>
                            <label for="date2" class="col-md-2 control-label text-center">@if($emp->lang == 'fr')
                                    Au @else To @endif</label>
                            <div class="col-md-4">
                                <input type="text" name="date2" id="date2" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <button type="button" name="save" id="save" class="btn btn-success bg-blue pull-right btn-raised">
                    <i class="fa fa-save"></i>&nbsp; @if ($emp->lang == 'fr') ENREGISTRER @else SAVE @endif
                </button>
            </div>
        </div>
    </div>

        <div class="box">
            <div class="box-body">
                <div class="box-header with-border">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="date" class="col-md-3 control-label">Date</label>
                            <div class="col-md-9">
                                <input type="text" name="date" id="date" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="mem_numb" class="col-md-5 control-label">@if($emp->lang == 'fr')
                                    N° Membre @else Member N° @endif</label>
                            <div class="col-md-7">
                                <select name="mem_numb" id="mem_numb" class="form-control select2">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <input type="text" name="mem_name" id="mem_name" class="form-control"
                               disabled="disabled">
                    </div>
                </div>

                <div class="col-md-12" id="tableInput">
                    <div class="col-md-5 bg-maroon-gradient"></div>
                    <div class="col-md-2 text-center text-blue text-bold">
                        @if($emp->lang == 'fr') Compte Membre @else Member's Account @endif
                    </div>
                    <div class="col-md-5 bg-maroon-gradient"></div>

                    <table
                        class="table table-striped table-hover table-bordered table-condensed table-responsive no-padding text-left">
                        <thead>
                        <tr>
                            <th>@if($emp->lang == 'fr') Compte @else Account @endif</th>
                            <th>Description</th>
                            <th>@if($emp->lang == 'fr') Solde @else Balance @endif</th>
                            <th>@if($emp->lang == 'fr') Bloque @else Block @endif</th>
                            <th>@if($emp->lang == 'fr') Découvert @else Overdraft @endif</th>
                            <th>@if($emp->lang == 'fr') Disponible @else Available @endif</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="bg-antiquewhite text-blue">
                            <th><input type="text" name="account" style="display: none" value="322000031">322000031
                            </th>
                            <td>MAIN LOAN</td>
                            <td>28/04/2009</td>
                            <td>36</td>
                            <td>1600000</td>
                            <td>1600000</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-12" id="tableInput">
                    <div class="col-md-5 bg-maroon-gradient"></div>
                    <div class="col-md-2 text-center text-blue text-bold">
                        @if($emp->lang == 'fr') Information Prêts @else Loan's Information @endif
                    </div>
                    <div class="col-md-5 bg-maroon-gradient"></div>

                    <table id="tableInput"
                           class="table table-striped table-hover table-bordered table-condensed table-responsive no-padding text-left">
                        <thead>
                        <tr>
                            <th>@if($emp->lang == 'fr') Compte @else Account @endif</th>
                            <th>@if($emp->lang == 'fr') Type Prêt @else Loan Type @endif</th>
                            <th>@if($emp->lang == 'fr') Dernier Rap... @else Last Rep... @endif</th>
                            <th>@if($emp->lang == 'fr') Retard @else Delay @endif</th>
                            <th>@if($emp->lang == 'fr') Montant @else Amount @endif</th>
                            <th>Balance</th>
                            <th>@if($emp->lang == 'fr') Mo... Del. @else Del. Am... @endif</th>
                            <th>@if($emp->lang == 'fr') Inter... @else Inter... @endif</th>
                            <th>@if($emp->lang == 'fr') Retard Initial @else Initial Delay @endif</th>
                            <th>Total @if($emp->lang == 'fr') Initial @else Initial @endif</th>
                            <th>@if($emp->lang == 'fr') Amendes @else Fines @endif</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="bg-antiquewhite text-blue">
                            <th><input type="text" name="account" style="display: none" value="322000031">322000031
                            </th>
                            <td>MAIN LOAN</td>
                            <td>36</td>
                            <td>1600000</td>
                            <td>1600000</td>
                            <td>0</td>
                            <td>33600</td>
                            <td>400000</td>
                            <td>25000</td>
                            <td></td>
                            <td></td>
                            <td>28/04/2009</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-12">
                    <button type="button" name="save" id="save" class="btn btn-success bg-blue pull-right btn-raised">
                        <i class="fa fa-save"></i>&nbsp; @if ($emp->lang == 'fr') ENREGISTRER @else SAVE @endif
                    </button>
                </div>
            </div>
        </div>

@stop
