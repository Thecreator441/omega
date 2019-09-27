<?php $emp = session()->get('employee'); ?>

@extends('layouts.dashboard')

@section('title', 'Institutions')

@section('content')
    {{--    Insert Institution--}}
    <div class="box">
        <div class="box box-info" id="newForm" style="display: none;">
            <div class="box-header with-border">
                <h3 class="box-title text-bold"> @if($emp->lang == 'fr') Institution @else Institution @endif </h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-alert bg-red btn-sm pull-right" id="exitForm">
                        <i class="fa fa-close"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="container-fluid">
                    <form action="{{ route('admin/institution/store') }}" method="post" role="form">
                        {{ csrf_field() }}
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
                                    <label for="phone1">@if($emp->lang == 'fr') NENUMÉRO DE TÉLÉPHONE @else PHONE
                                        NUMBER @endif</label>
                                    <input type="number" class="form-control" name="phone1" id="phone1"
                                           placeholder="<?php echo $emp->lang === 'fr' ? 'Entrez le Numéro de Téléphone 1' : 'Enter the Telephone Number 1'; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone2">@if($emp->lang == 'fr') NENUMÉRO DE TÉLÉPHONE @else
                                            TELEPHONE NUMBER @endif</label>
                                    <input type="number" class="form-control" name="phone2" id="phone2"
                                           placeholder="<?php echo $emp->lang === 'fr' ? 'Entrez le Numéro de Téléphone 2' : 'Enter the Telephone Number 2'; ?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">@if($emp->lang == 'fr') EMAIL @else EMAIL @endif</label>
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
                                    <label for="format">zone</label>
                                    <select class="form-control" name="zone" id="zone">
                                        <option>@if($emp->lang == 'fr') Sélectionnez Zone @else Select
                                            Zone @endif</option>
                                        @foreach($zones as $z)
                                            <option value="{{$z->idzone}}">{{$z->name}}</option>
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
    </div>
    {{--    Insert Institution--}}

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Institutions</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-success bg-green btn-sm pull-right" id="insertForm">
                    <i class="oin ion-plus"></i>&nbsp;@if($emp->lang == 'fr') Nouvelle @else New @endif Institution
                </button>
            </div>
        </div>
        <div class="box-body">
            <table id="bootstrap-data-table" class="table table-striped table-hover table-responsive-xl">
                <thead>
                <tr>
                    <th>Institution</th>
{{--                    <th>Zone</th>--}}
                    <th>@if($emp->lang == 'fr') Téléphone @else Phone @endif</th>
                    <th>Email</th>
                    <th>@if($emp->lang == 'fr') Addresse @else Address @endif</th>
{{--                    <th>@if($employee->lang == 'fr') Région @else Region @endif</th>--}}
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($institutions as $ins)
                    <tr>
                        <td>{{$ins->name}}</td>
                        <td>{{$ins->phone1}}</td>
                        <td>{{$ins->email}}</td>
                        <td>{{$ins->address}}</td>
                        <td>
                            <button class="btn btn-info bg-aqua btn-sm" onclick="edit()">
                                <i class="ion ion-edit"></i>&nbsp; @if($emp->lang == 'fr') Modifier @else
                                    Edit @endif
                            </button>
                            <button class="btn bg-red btn-sm" data-toggle="modal" data-target="#delete"
                                    onclick="setData('admin', 'institution', '{{ $ins->idinst }}')">
                                <i class="ion ion-trash-b"></i>&nbsp; @if($emp->lang == 'fr') Effacer @else
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
