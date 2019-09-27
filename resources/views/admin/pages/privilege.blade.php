<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Privilèges';
else
    $title = 'Privileges';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    {{--    Insert Privilege--}}
    <div class="box">
        <div class="box box-info" id="newForm" style="display: none;">
            <div class="box-header with-border">
                <h3 class="box-title text-bold">@if($emp->lang == 'fr') Privilèges @else Privileges @endif</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-alert bg-red btn-sm pull-right" id="exitForm">
                        <i class="fa fa-close"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="container-fluid">
                    <form action={{route('admin/privilege/store')}} method="post" role="form">{{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="value">@if($emp->lang == 'fr') LIBELLE ANGLAIS @else ENGLISH
                                        LABEL @endif</label>
                                    <input type="text" class="form-control" name="englishlabel" id="englishlabel"
                                           placeholder="<?php echo $emp->lang === 'fr' ? 'Entrer le Libélle en Anglais' : 'Enter the Label in English'; ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">@if($emp->lang == 'fr') LIBELLE FRANCAISE @else FRENCH
                                        LABEL @endif</label>
                                    <input type="text" class="form-control" name="frenchlabel" id="frenchlabel"
                                           placeholder="<?php echo $emp->lang === 'fr' ? 'Entrer le Libélle en Français' : 'Enter the Label in French'; ?> ">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="format">@if($emp->lang == 'fr') NIVEAU @else
                                            LEVEL @endif</label>
                                    <select class="form-control" name="level" id="level">
                                        <option>@if($emp->lang == 'fr') Sélectionnez Niveau @else Select
                                            Level @endif</option>
                                        <option value="1">@if($emp->lang == 'fr') Agence @else
                                                Branch @endif </option>
                                        <option value="2">Institution</option>
                                        <option value="3">Zone</option>
                                        <option value="4">@if($emp->lang == 'fr') Réseau @else
                                                Network @endif </option>
                                        <option value="5">@if($emp->lang == 'fr') Organe @else
                                                Organ @endif</option>
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
    {{--    Insert Privilege--}}

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold">@if($emp->lang == 'fr') Privilèges @else Privileges @endif</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-success bg-green btn-sm pull-right" id="insertForm">
                    <i class="oin ion-plus"></i>&nbsp;@if($emp->lang == 'fr') Nouveau Privilège @else New
                    Privilege @endif
                </button>
            </div>
        </div>
        <div class="box-body">
            <table id="bootstrap-data-table" class="table table-striped table-hover table-responsive-xl">
                <thead>
                <tr>
                    <th>@if($emp->lang == 'fr') Privilège @else Privilege @endif</th>
                    <th>@if($emp->lang == 'fr') Niveau @else Level @endif</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($privileges as $pri)
                    <tr>
                        <td>@if($emp->lang == 'fr') {{$pri->labelfr}} @else {{$pri->labeleng}} @endif </td>
                        <td>@switch($pri->level)
                                @case (1) @if($emp->lang == 'fr') Agence @else Branch @endif
                                @break
                                @case (2) Institution
                                @break
                                @case (3) Zone
                                @break
                                @case (4) @if($emp->lang == 'fr') Réseau @else Network @endif
                                @break
                                @case (5) @if($emp->lang == 'fr') Organe @else Organ @endif
                                @break
                                @default @if($emp->lang == 'fr') Administrateur @else Administrator @endif
                                @break
                            @endswitch

                        </td>
                        <td>
                            <button class="btn btn-info bg-aqua btn-sm" onclick="edit()">
                                <i class="ion ion-edit"></i>&nbsp; @if($emp->lang == 'fr') Modifier @else
                                    Edit @endif
                            </button>
                            <button class="btn bg-red btn-sm" data-toggle="modal" ddata-target="#delete"
                                    onclick="setData('admin', 'privilege', '{{ $pri->idpriv }}')">
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
