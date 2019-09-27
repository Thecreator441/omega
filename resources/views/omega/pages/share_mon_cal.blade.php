<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Calcul des Parts Mensuelles';
else
    $title = 'Share Months Calculations';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    <div class="box">
        <div class="box-body">
            <form action="{{ url('share_mon_cal/store') }}" method="POST" role="form">
                {{ csrf_field() }}
                <div class="box-header with-border">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="reference" class="col-md-3 control-label">@if($emp->lang == 'fr')
                                    Référence @else Reference @endif</label>
                            <div class="col-md-9">
                                <input type="text" name="reference" id="reference" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>

                <div class="col-md-12" id="tableInput">
                    <table id="bootstrap-data-table"
                           class="table table-hover table-condensed table-responsive table-striped">
                        <caption class="text-blue text-center text-bold">Total</caption>
                        <thead>
                        <tr>
                            <th>@if($emp->lang == 'fr') Membre @else Member @endif</th>
                            <th>@if($emp->lang == 'fr') Noms @else Names @endif</th>
                            <th>@if($emp->lang == 'fr') Janvier @else January @endif</th>
                            <th>@if($emp->lang == 'fr') Fervrier @else February @endif</th>
                            <th>@if($emp->lang == 'fr') Mars @else March @endif</th>
                            <th>@if($emp->lang == 'fr') Avril @else April @endif</th>
                            <th>@if($emp->lang == 'fr') Mai @else May @endif</th>
                            <th>@if($emp->lang == 'fr') Juin @else June @endif</th>
                            <th>@if($emp->lang == 'fr') Juillet @else July @endif</th>
                            <th>@if($emp->lang == 'fr') Août @else August @endif</th>
                            <th>@if($emp->lang == 'fr') Septembre @else September @endif</th>
                            <th>@if($emp->lang == 'fr') Octobre @else October @endif</th>
                            <th>@if($emp->lang == 'fr') Novembre @else November @endif</th>
                            <th>@if($emp->lang == 'fr') Decembre @else December @endif</th>
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
                    <button type="submit" name="save" id="save" class="btn btn-success bg-blue pull-right btn-raised">
                        <i class="fa fa-save"></i>&nbsp; @if ($emp->lang == 'fr') ENREGISTRER @else SAVE @endif
                    </button>
                </div>
            </form>
        </div>
    </div>

@stop
