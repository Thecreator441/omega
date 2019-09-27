<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Bancaire';
else
    $title = 'Banking';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    <div class="box">
        <div class="box-body">
            <form action="{{ url('banking/store') }}" method="POST" role="form">
                {{ csrf_field() }}
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="oper_date" class="col-md-6 control-label">@if ($emp->lang == 'fr') Date
                            d'Opération @else Operation Date @endif</label>
                        <div class="col-md-6">
                            <input type="text" name="oper_date" id="oper_date" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="auth_month" class="col-md-7 control-label">@if ($emp->lang == 'fr') Mois
                            d'Authentification des Données @else Month of Authentication of Data @endif</label>
                        <div class="col-md-5">
                            <select name="auth_month" id="auth_month" class="form-control select2">
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

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="mem_numb" class="col-md-2 control-label">@if ($emp->lang == 'fr') N°
                            Membre @else Member N° @endif</label>
                        <div class="col-md-2">
                            <input type="text" name="mem_numb" id="mem_numb" class="form-control">
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="mem_name" id="mem_name" class="form-control" disabled="disabled">
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="remitter" class="col-md-4 control-label">@if ($emp->lang == 'fr')
                                Remettant @else Remitter @endif</label>
                        <div class="col-md-8">
                            <input type="text" name="remitter" id="remitter" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="in_ret" class="col-md-5 control-label">@if ($emp->lang == 'fr')
                                En Retour @else In Return @endif</label>
                        <div class="col-md-7">
                            <input type="text" name="in_ret" id="in_ret" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="col-md-12" id="tableInput">
                    <div class="box-footer with-border"></div>
                    <div class="col-md-12 ">
                        <div class="col-md-5 bg-maroon-gradient"></div>
                        <div class="col-md-2 text-center text-blue text-bold">
                            @if($emp->lang == 'fr') Autres Comptes @else Other Accounts @endif
                        </div>
                        <div class="col-md-5 bg-maroon-gradient"></div>
                    </div>
                    <table
                        class="table table-striped table-hover table-condensed table-bordered table-responsive no-padding">
                        <thead>
                        <tr class="bg-purples">
                            <th>@if($emp->lang == 'fr') Compte @else Account @endif</th>
                            <th>@if($emp->lang == 'fr') Nom Compte @else Account Name @endif</th>
                            <th>@if($emp->lang == 'fr') Description Transaction @else
                                    Transaction Description @endif</th>
                            <th>@if($emp->lang == 'fr') Montant @else Amount @endif</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <input type="text" class="operation" value="" style="width: 100%" name="amount"
                                       id="shares"
                                       oninput="sumOperation()">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-12" id="tableInput">
                    <div class="box-footer with-border"></div>
                    <div class="col-md-12">
                        <div class="col-md-5 bg-maroon-gradient"></div>
                        <div class="col-md-2 text-center text-blue text-bold">
                            @if($emp->lang == 'fr') Compte Prêts @else Loans Account @endif
                        </div>
                        <div class="col-md-5 bg-maroon-gradient"></div>
                    </div>
                    <table
                           class="table table-striped table-hover table-bordered table-condensed table-responsive no-padding text-right">
                        <thead>
                        <tr class="bg-antiquewhite text-blue">
                            <th>@if($emp->lang == 'fr') Compte @else Account @endif</th>
                            <th>@if($emp->lang == 'fr') Amende @else Fines @endif</th>
                            <th>@if($emp->lang == 'fr') Retard @else Delay @endif</th>
                            <th>@if($emp->lang == 'fr') Montant @else Amount @endif</th>
                            <th>Balance</th>
                            <th>@if($emp->lang == 'fr') Retard Initiale @else Initial Delay @endif</th>
                            <th>@if($emp->lang == 'fr') Totale Initiale @else Initial Total @endif</th>
                            <th>@if($emp->lang == 'fr') Paiement @else Payment @endif</th>
                            <th>@if($emp->lang == 'fr') Interet @else Interest @endif</th>
                            <th>@if($emp->lang == 'fr') Différence @else Difference @endif</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th><input type="text" name="account" style="display: none" value="322000031">322000031
                            </th>
                            <td>MAIN LOAN</td>
                            <td>28/04/2009</td>
                            <td>36</td>
                            <td>1600000</td>
                            <td>1600000</td>
                            <td>0</td>
                            <td>400000</td>
                            <td>25000</td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-12"  id="tableInput">
                    <div class="box-footer with-border"></div>
                    <div class="col-md-12">
                        <div class="col-md-5 bg-maroon-gradient"></div>
                        <div class="col-md-2 text-center text-blue text-bold">
                            @if($emp->lang == 'fr') Comptes Gestions @else Management Accounts @endif
                        </div>
                        <div class="col-md-5 bg-maroon-gradient"></div>
                    </div>
                    <table
                           class="table table-striped table-hover table-bordered table-condensed table-responsive no-padding text-right">
                        <thead>
                        <tr>
                            <th><input type="text" name="account" value="322000031"></th>
                            <th colspan="4"><input type="text" name="account" id="account" disabled="disabled"></th>
                            <th colspan="4">28/04/2009</th>
                            <th><input type="text" name="account" value="0"></th>
                        </tr>
                        </thead>
                    </table>
                </div>

                <div class="col-md-9">
                    <table id="tableInput"
                           class="table table-striped table-hover table-condensed table-responsive no-padding text-right">
                        <thead>
                        <tr class="text-bold text-blue bg-antiquewhite">
                            <td>@if($emp->lang == 'fr') Transaction Total @else Total Transaction @endif</td>
                            <td style="width: 15%"><input type="text" class="text-white op" name="totrans" id="totrans"
                                                          disabled></td>
                        </tr>
                        </thead>
                    </table>
                </div>
                <div class="col-md-3">
                    <button type="submit" name="save" id="save"
                            class="btn btn-success bg-blue pull-right btn-raised"><i
                            class="fa fa-save"></i>&nbsp; @if ($emp->lang == 'fr')
                            ENREGISTRER @else SAVE @endif
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop
