<?php $emp = session()->get('employee'); ?>

@extends('layouts.dashboard')

@section('title', 'Zones')

@section('content')
    {{--    Insert Zone--}}
    <div class="box">
        <div class="box box-info" id="newForm" style="display: none;">
            <div class="box-header with-border">
                <h3 class="box-title text-bold"> @if($emp->lang == 'fr') Zones @else Zones @endif </h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-alert bg-red btn-sm pull-right" id="exitForm">
                        <i class="fa fa-close"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="container-fluid">
                    <form action="{{ route('admin/zone/store') }}" method="post" role="form">{{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">@if($emp->lang == 'fr') NOMS @else NAME @endif</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                           placeholder="<?php echo $emp->lang === 'fr' ? 'Entrez le Noms' : 'Enter the Name'; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="value">@if($emp->lang == 'fr') NENUMÉRO DE TÉLÉPHONE @else
                                            PHONE NUMBER @endif</label>
                                    <input type="number" class="form-control" name="phone1" id="phone1"
                                           placeholder="<?php echo $emp->lang === 'fr' ? 'Entrez le Numéro de Téléphone 1' : 'Enter the Telephone Number 1'; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="format">@if($emp->lang == 'fr') NENUMÉRO DE TÉLÉPHONE @else
                                            PHONE NUMBER @endif</label>
                                    <input type="number" class="form-control" name="phone2" id="phone2"
                                           placeholder="<?php echo $emp->lang === 'fr' ? 'Entrez le Numéro de Téléphone 2' : 'Enter the Telephone Number 2'; ?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">@if($emp->lang == 'fr') EMAIL @else EMAIL @endif</label>
                                    <input type="email" class="form-control" name="email" id="email"
                                           placeholder="<?php echo $emp->lang === 'fr' ? 'Entrez le Email' : 'Enter the Email'; ?>">
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
                                           placeholder="<?php echo $emp->lang === 'fr' ? 'Entrez le Région' : 'Enter the Region'; ?>">
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
                                           placeholder="<?php echo $emp->lang === 'fr' ? 'Entrez le Adresse' : 'Enter the Address'; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="format">@if($emp->lang == 'fr') CODE POSTAL @else
                                            POSTCODE @endif</label>
                                    <input type="text" class="form-control" name="postcode" id="postcode"
                                           placeholder="<?php echo $emp->lang === 'fr' ? 'Entrez le Code Postal' : 'Enter the Postcode'; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="network">@if($emp->lang == 'fr') Réseau @else
                                            Network @endif</label>
                                    <select class="form-control" name="network" id="network">
                                        <option>@if($emp->lang == 'fr') Sélectionnez Réseau @else Select
                                            Network @endif</option>
                                        @foreach($networks as $net)
                                            <option value="{{$net->idnetwork}}">{{$net->name}}</option>
                                        @endforeach
                                    </select>
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
        {{--    Insert Zone--}}

        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Zones</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-success bg-green btn-sm pull-right" id="insertForm">
                        <i class="oin ion-plus"></i>&nbsp;@if($emp->lang == 'fr') Nouvelle @else New @endif Zone
                    </button>
                </div>
            </div>
            <div class="box-body">
                <table id="bootstrap-data-table" class="table table-striped table-hover table-responsive-xl">
                    <thead>
                    <tr>
                        <th> @if($emp->lang == 'fr') Noms @else Name @endif </th>
                        <th>@if($emp->lang == 'fr') Numéro de Téléphone @else Phone @endif </th>
                        <th> @if($emp->lang == 'fr') Email @else Email @endif </th>
                        <th> @if($emp->lang == 'fr') Adresse @else Address @endif </th>
                        <th>@if($emp->lang == 'fr') Action @else Action @endif </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($zones as $z)
                        <tr>
                            <td>{{$z->name}}</td>
                            <td>{{$z->phone1}}</td>
                            <td>{{$z->email}}</td>
                            <td>{{$z->address}}</td>
                            <td>
                                <button class="btn btn-info bg-aqua btn-sm" onclick="edit()">
                                    <i class="ion ion-edit"></i>&nbsp;@if($emp->lang == 'fr') Modifier @else
                                        Edit @endif
                                </button>
                                <button class="btn bg-red btn-sm" data-toggle="modal" data-target="#delete"
                                        onclick="setData('admin', 'zone', '{{ $z->idzone }}')">
                                    <i class="ion ion-trash-b"></i>&nbsp;@if($emp->lang == 'fr') Effacer @else
                                        Delete @endif
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
@stop
