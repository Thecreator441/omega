<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Régions';
else
    $title = 'Regions';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')
    {{--    Insert and Update Region Box--}}
    <div class="box box-info" id="newForm" style="display: none;">
        <div class="box-header with-border">
            <h3 class="box-title text-bold">@if($emp->lang == 'fr') Nouvelle Région @else New
                Region @endif</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right" id="exitForm">
                    <i class="fa fa-close"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <div class="container-fluid">
                <form action="{{ route('admin/region/store') }}" method="post" role="form">
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
                        <div class="col-md-6">
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
    {{--    Insert and Update Region Box--}}

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">@if($emp->lang == 'fr') Régions @else Regions @endif</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-success bg-green btn-sm pull-right" id="insertForm">
                    <i class="oin ion-plus"></i>&nbsp;@if($emp->lang == 'fr') Nouvelle Région @else New
                    Region @endif
                </button>
            </div>
        </div>
        <div class="box-body">
            <table id="bootstrap-data-table" class="table table-striped table-hover table-responsive-xl">
                <thead>
                <tr>
                    <th>@if($emp->lang == 'fr') Région @else Region @endif</th>
                    <th>@if($emp->lang == 'fr') Pays @else Country @endif</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($regions as $region)
                    <tr>
                        <td>@if($emp->lang == 'fr') {{ $region->labelfr }} @else {{ $region->labeleng }} @endif</td>
                        <td>
                            @foreach($countries as $country)
                                @if($region->idcountry == $country->idcountry)
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
                                    onclick="setData('admin', 'region', '{{ $region->idregi }}')">
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
