<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Arrondissements';
else
    $title = 'Sub Divisions';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')
    {{--    Insert and Update SubDivision Box--}}
    <div class="box box-info" id="newForm" style="display: none;">
        <div class="box-header with-border">
            <h3 class="box-title text-bold">@if($emp->lang == 'fr') Nouvelle Arrondissement @else New
                Sub Division @endif</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right" id="exitForm">
                    <i class="fa fa-close"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <div class="container-fluid">
                <form action="{{ route('admin/subdivision/store') }}" method="post" role="form">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        @if($emp->lang == 'fr')
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="labelfr">@if($emp->lang == 'fr') NOMS EN FRANÇAIS @else NAME IN
                                        FRENCH @endif</label>
                                    <input type="text" class="form-control" name="labelfr" id="labelfr"
                                           placeholder="<?php echo $emp->lang === 'fr' ? 'Entrez le Noms en Français' : 'Enter the Name in French'; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="labeleng">@if($emp->lang == 'fr') NOMS EN ANGLAIS @else NAME IN
                                        ENGLISH @endif</label>
                                    <input type="text" class="form-control" name="labeleng" id="labeleng"
                                           placeholder="<?php echo $emp->lang === 'fr' ? 'Entrez le Noms en Anglais' : 'Enter the Name in English'; ?>">
                                </div>
                            </div>
                        @else
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="labeleng">@if($emp->lang == 'fr') NOMS EN ANGLAIS @else NAME IN
                                        ENGLISH @endif</label>
                                    <input type="text" class="form-control" name="labeleng" id="labeleng"
                                           placeholder="<?php echo $emp->lang === 'fr' ? 'Entrez le Noms en Anglais' : 'Enter the Name in English'; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="labelfr">@if($emp->lang == 'fr') NOMS EN FRANÇAIS @else NAME IN
                                        FRENCH @endif</label>
                                    <input type="text" class="form-control" name="labelfr" id="labelfr"
                                           placeholder="<?php echo $emp->lang === 'fr' ? 'Entrez le Noms en Français' : 'Enter the Name in French'; ?>">
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="division">@if($emp->lang == 'fr') DÉPARTEMENT @else
                                        DIVISION @endif</label>
                                <select class="form-control" id="division" name="division">
                                    <option>@if($emp->lang == 'fr') Selectionez le Départment @else Select
                                        Division @endif</option>
                                    @foreach($divisions as $division)
                                        <option value="{{ $division->iddiv }}">@if($emp->lang == 'fr') {{ $division->labelfr }} @else {{ $division->labeleng }} @endif</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="region">@if($emp->lang == 'fr') RÉGION @else
                                        REGION @endif</label>
                                <select class="form-control" id="region" name="region">
                                    <option>@if($emp->lang == 'fr') Selectionez la Region @else Select
                                        Region @endif</option>
                                    @foreach($regions as $region)
                                        <option value="{{ $region->idregi }}">@if($emp->lang == 'fr') {{ $region->labelfr }} @else {{ $region->labeleng }} @endif</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="country">@if($emp->lang == 'fr') PAYS @else COUNTRY @endif</label>
                                <select class="form-control" id="country" name="country">
                                    <option>@if($emp->lang == 'fr') Selectionez le Pays @else Select
                                        Country @endif</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->idcountry }}">@if($emp->lang == 'fr') {{ $country->labelfr }} @else {{ $country->labeleng }} @endif</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary bg-primary pull-right btn-raised">Save</button>
                </form>
            </div>
        </div>
    </div>
    {{--    Insert and Update SubDivision Box--}}

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">@if($emp->lang == 'fr') Arrondissements @else Sub Divisions @endif</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-success bg-green btn-sm pull-right" id="insertForm">
                    <i class="oin ion-plus"></i>&nbsp;@if($emp->lang == 'fr') Nouveau Arrondissement @else New Sub
                    Division @endif
                </button>
            </div>
        </div>
        <div class="box-body">
            <table id="bootstrap-data-table" class="table table-striped table-hover table-responsive-xl">
                <thead>
                <tr>
                    <th>@if($emp->lang == 'fr') Arrondissement @else Sub Division @endif</th>
                    <th>@if($emp->lang == 'fr') Département @else Division @endif</th>
                    <th>@if($emp->lang == 'fr') Région @else Region @endif</th>
                    <th>@if($emp->lang == 'fr') Pays @else Country @endif</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($subdivisions as $subdivision)
                    <tr>
                        <td>@if($emp->lang == 'fr') {{ $subdivision->labelfr }} @else {{ $subdivision->labeleng }} @endif</td>
                        <td>
                            @foreach($divisions as $division)
                                @if($division->iddiv == $subdivision->iddiv)
                                    @if($emp->lang == 'fr') {{ $division->labelfr }} @else {{ $division->labeleng }} @endif
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach($regions as $region)
                                @if($division->idregi == $region->idregi)
                                    @if($emp->lang == 'fr') {{ $region->labelfr }} @else {{ $region->labeleng }} @endif
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach($countries as $country)
                                @if($country->idcountry == $region->idcountry)
                                    @if($emp->lang == 'fr') {{ $country->labelfr }} @else {{ $country->labeleng }} @endif
                                @endif
                            @endforeach
                        </td>
                        <td>
                            <button class="btn btn-info bg-aqua btn-sm" onclick="edit()">
                                <i class="ion ion-edit"></i>&nbsp; @if($emp->lang == 'fr') Modifier @else
                                    Edit @endif
                            </button>
                            <button class="btn bg-red btn-sm" data-toggle="modal" data-target="#delete"
                                    onclick="setData('admin', 'subdivision', '{{ $subdivision->idsub }}')">
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
