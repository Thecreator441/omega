<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Assurance Prêt';
else
    $title = 'Loans Insurance';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    <div class="box">
        <div class="box-body">
            <form action="{{ url('loan_insurance/store') }}" method="POST" role="form">
                {{ csrf_field() }}
                <div class="box-header with-border">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="month" class="col-md-3 control-label">@if($emp->lang == 'fr')
                                    Mois @else Month @endif
                            </label>
                            <div class="col-md-9">
                                <select name="month" id="month" class="from-control select2">
                                    <option value=""></option>
                                    <option value="January">@if ($emp->lang == 'fr') Janvier @else
                                            January @endif</option>
                                    <option value="February">@if ($emp->lang == 'fr') Fervrier @else
                                            February @endif</option>
                                    <option value="March">@if ($emp->lang == 'fr') Mars @else
                                            March @endif</option>
                                    <option value="April">@if ($emp->lang == 'fr') Avril @else
                                            April @endif</option>
                                    <option value="May">@if ($emp->lang == 'fr') Mai @else
                                            May @endif</option>
                                    <option value="June">@if ($emp->lang == 'fr') Juin @else
                                            June @endif</option>
                                    <option value="July">@if ($emp->lang == 'fr') Juillet @else
                                            July @endif</option>
                                    <option value="August">@if ($emp->lang == 'fr') Août @else
                                            August @endif</option>
                                    <option value="September">@if ($emp->lang == 'fr') Septembre @else
                                            September @endif</option>
                                    <option value="October">@if ($emp->lang == 'fr') Octobre @else
                                            October @endif</option>
                                    <option value="November">@if ($emp->lang == 'fr') Novembre @else
                                            November @endif</option>
                                    <option value="December">@if ($emp->lang == 'fr') Decembre @else
                                            December @endif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <p class="text-blue text-center">@if ($emp->lang == 'fr') Déjà @else Already @endif
                                Total @if ($emp->lang == 'fr') Enregistrement(s) Traités @else Saving(s)
                                Treated @endif</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-12" id="tableInput">
                    <table class="table table-hover table-condensed table-responsive table-striped">
                        <thead>
                        <tr>
                            <th>@if($emp->lang == 'fr') Compte @else Account @endif</th>
                            <th>@if($emp->lang == 'fr') Member Name @else Member Name @endif</th>
                            <th>@if($emp->lang == 'fr') Prêts @else Loans @endif</th>
                            <th>@if($emp->lang == 'fr') Assurable @else Insurable @endif</th>
                            <th>@if($emp->lang == 'fr') Excess Du @else Excess Of @endif</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tbody>
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
