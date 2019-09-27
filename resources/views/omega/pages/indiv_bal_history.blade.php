<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Historique Balance Individuelle';
else
    $title = 'Individual Balance History';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    <div class="box">
        <div class="box-body">
            <div class="box-header with-border">
                <div class="col-md-12">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="date" class="col-md-3 control-label">Date</label>
                            <div class="col-md-9">
                                <input type="text" name="date" id="date" class="form-control" disabled="disabled">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4"></div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <div class="checkbox">
                            <label for="all" class="control-label">
                                <input type="checkbox" name="all" id="all" checked>
                                @if($emp->lang == 'fr') Tous @else All @endif
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <div class="checkbox">
                            <label for="interval" class="control-label">
                                <input type="checkbox" name="interval" id="interval">
                                @if($emp->lang == 'fr') Intervalle @else Interval @endif
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-md-8" id="byInterval" style="display: none">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="period" class="col-md-3 control-label">@if($emp->lang == 'fr')
                                    Période @else Period @endif</label>
                            <div class="col-md-9">
                                <input type="text" name="period" id="period" class="form-control text-center">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="col-md-6">
                                <div class="checkbox">
                                    <label for="by_sex">
                                        <input type="checkbox" name="by_sex" id="by_sex">
                                        @if($emp->lang == 'fr') Par Sexe @else By Sex @endif
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6" id="bySex" style="display: none">
                                <select name="sex" id="sex" class="form-control">
                                    <option value="All">@if($emp->lang == 'fr') Tous @else All @endif</option>
                                    <option value="Male">@if ($emp->lang == 'fr') Masculin @else
                                            Male @endif</option>
                                    <option value="Female">@if ($emp->lang == 'fr') Féminin @else
                                            Female @endif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12" id="tableInput">
                <table
                    class="table table-hover table-condensed table-responsive table-striped">
                    <caption class="text-blue text-center text-bold">Total</caption>
                    <thead>
                    <tr>
                        <th>@if($emp->lang == 'fr') N° Membre @else Member N° @endif</th>
                        <th>@if($emp->lang == 'fr') Noms Membre @else Member's Names @endif</th>
                        <th>@if($emp->lang == 'fr') Fond Solidarity @else Solidarity Fund @endif</th>
                        <th>@if($emp->lang == 'fr') Part Sociale @else Shares @endif</th>
                        <th>@if($emp->lang == 'fr') Epargne @else Saving @endif</th>
                        <th>@if($emp->lang == 'fr') Dépot à Vue @else Dépot à Vue @endif</th>
                        <th>@if($emp->lang == 'fr') Dépot @else Deposit @endif</th>
                        <th>Others</th>
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
                        <td></td>
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
