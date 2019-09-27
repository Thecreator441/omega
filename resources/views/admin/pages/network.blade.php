<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Réseaux';
else
    $title = 'Networks';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')
    {{--    Insert Network--}}
    <div class="box">
        <div class="box box-info" id="newForm" style="display: none;">
            <div class="box-header with-border">
                <h3 class="box-title text-bold"> @if($emp->lang == 'fr') Réseaux @else Networks @endif </h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-alert bg-red btn-sm pull-right" id="exitForm">
                        <i class="fa fa-close"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="container-fluid">
                    <form action="{{ route('admin/network/store') }}" method="post" role="form">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">@if($emp->lang == 'fr') NOMS @else NAME @endif</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                           placeholder="<?php echo $emp->lang === 'fr' ? 'Entrez le Noms' : 'Enter the Name'; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="value">@if($emp->lang == 'fr') NENUMÉRO DE TÉLÉPHONE @else
                                            TELEPHONE NUMBER @endif</label>
                                    <input type="number" class="form-control" name="phone1" id="phone1"
                                           placeholder="<?php echo $emp->lang === 'fr' ? 'Entrez le Numéro de Téléphone 1' : 'Enter the Telephone Number 1'; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="format">@if($emp->lang == 'fr') NENUMÉRO DE TÉLÉPHONE @else
                                            TELEPHONE NUMBER @endif</label>
                                    <input type="number" class="form-control" name="phone2" id="phone2"
                                           placeholder="<?php echo $emp->lang === 'fr' ? 'Entrez le Numéro de Téléphone' : 'Enter the Telephone Number'; ?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">@if($emp->lang == 'fr') EMAIL @else EMAIL @endif</label>
                                    <input type="email" class="form-control" name="email" id="email"
                                           placeholder="<?php echo $emp->lang === 'fr' ? 'Entrez l\'Email' : 'Enter the Email'; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="value">@if($emp->lang == 'fr') PAYS @else COUNTRY @endif</label>
                                    <input type="text" class="form-control" name="country" id="country"
                                           placeholder="<?php echo $emp->lang === 'fr' ? 'Entrez le Pays' : 'Enter the Country'; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="format">@if($emp->lang == 'fr') RÉGION @else REGION @endif</label>
                                    <input type="text" class="form-control" name="region" id="region"
                                           placeholder="<?php echo $emp->lang === 'fr' ? 'Entrez la Région' : 'Enter the Region'; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="format">@if($emp->lang == 'fr') VILLE @else TOWN @endif</label>
                                    <input type="text" class="form-control" name="town" id="town"
                                           placeholder="<?php echo $emp->lang === 'fr' ? 'Entrez le Ville' : 'Enter the Town'; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="format">@if($emp->lang == 'fr') ADRESSE @else
                                            ADDRESS @endif</label>
                                    <input type="text" class="form-control" name="address" id="address"
                                           placeholder="<?php echo $emp->lang === 'fr' ? 'Entrez l\'Adresse' : 'Enter the Address'; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="format">@if($emp->lang == 'fr') CODE POSTAL @else
                                            POST CODE @endif</label>
                                    <input type="text" class="form-control" name="postcode" id="postcode"
                                           placeholder="<?php echo $emp->lang === 'fr' ? 'Entrez le Code Postal' : 'Enter the Post code'; ?>">
                                </div>
                            </div>
                        </div>
                        <button type="submit"
                                class="btn btn-primary bg-primary pull-right btn-raised">@if($emp->lang == 'fr')
                                ENREGISTRER @else SAVE @endif</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{--    Insert Network--}}

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">@if($emp->lang == 'fr') Réseaux @else Networks @endif</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-success bg-green btn-sm pull-right" id="insertForm">
                    <i class="oin ion-plus"></i>&nbsp;@if($emp->lang == 'fr') Nouveau Réseau @else New Network @endif
                </button>
            </div>
        </div>
        <div class="box-body">
            <table id="bootstrap-data-table" class="table table-striped table-hover table-responsive-xl">
                <thead>
                <tr>
                    <th> @if($emp->lang == 'fr') Noms @else Name @endif </th>
                    <th>@if($emp->lang == 'fr') Téléphone @else Phone @endif </th>
                    <th> @if($emp->lang == 'fr') Email @else Email @endif </th>
                    <th> @if($emp->lang == 'fr') Pays @else Country @endif </th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($networks as $net)
                    <tr>
                        <td>{{$net->name}}</td>
                        <td>{{$net->phone1}}</td>
                        <td>{{$net->email}}</td>
                        <td>{{$net->country}}</td>
                        <td>
                            <button class="btn btn-info bg-aqua btn-sm" onclick="edit()">
                                <i class="ion ion-edit"></i>&nbsp;@if($emp->lang == 'fr') Modifier @else Edit @endif
                            </button>
                            <button class="btn bg-red btn-sm" data-toggle="modal" data-target="#delete"
                                    onclick="setData('admin', 'network', '{{ $net->idnetwork }}')">
                                <i class="ion ion-trash-b"></i>&nbsp;@if($emp->lang == 'fr') Effacer @else Delete @endif
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
