<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Pays';
else
    $title = 'Countries';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')
    {{--    Insert and Update Country Box--}}
    <div class="box box-info" id="newForm" style="display: none;">
        <div class="box-header with-border">
            <h3 class="box-title text-bold">@if($emp->lang == 'fr') Nouveau Pays @else New
                Country @endif</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right" id="exitForm">
                    <i class="fa fa-close"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <div class="container-fluid">
                <form action="{{ route('admin/country/store') }}" method="post" role="form">
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
                                <label for="isocode">@if($emp->lang == 'fr') CODE ISO @else ISO CODE @endif</label>
                                <input type="text" class="form-control" name="isocode" id="isocode"
                                       placeholder="<?php echo $emp->lang === 'fr' ? 'Entrez le Code ISO' : 'Enter ISO Code'; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phonecode">@if($emp->lang == 'fr') CODE TÉLÉPHONNIQUE @else PHONE
                                    CODE @endif</label>
                                <input type="text" class="form-control" name="phonecode" id="phonecode"
                                       placeholder="<?php echo $emp->lang === 'fr' ? 'Entrez le Code Téléphonique' : 'Enter Phone Code'; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="currency">@if($emp->lang == 'fr') DEVISE @else CURRENCY @endif</label>
                                <select class="form-control" id="currency" name="currency">
                                    <option>@if($emp->lang == 'fr') Selectionez la Dévise @else Select
                                        Currency @endif</option>
                                    @foreach($currencies as $currency)
                                        <option value="{{ $currency->idcurrency }}">{{ $currency->label }}</option>
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
    {{--    Insert and Update Country Box--}}


    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold">@if($emp->lang == 'fr') Pays @else Countries @endif</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-success bg-green btn-sm pull-right" id="insertForm">
                    <i class="oin ion-plus"></i>&nbsp;@if($emp->lang == 'fr') Nouveau Pays @else New Country @endif
                </button>
            </div>
        </div>
        <div class="box-body">
            <table id="bootstrap-data-table" class="table table-striped table-hover table-responsive-xl">
                <thead>
                <tr>
                    <th>@if($emp->lang == 'fr') Pays @else Country @endif</th>
                    <th>@if($emp->lang == 'fr') Code ISO @else ISO Code @endif</th>
                    <th>@if($emp->lang == 'fr') Code Téléphonique @else Phone Code @endif</th>
                    <th>@if($emp->lang == 'fr') Dévise @else Currency @endif</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($countries as $country)
                    <tr>
                        <td>@if($emp->lang == 'fr') {{ $country->labelfr }} @else {{ $country->labeleng }} @endif</td>
                        <td>{{ $country->isocode }}</td>
                        <td>+{{ $country->phonecode }}</td>
                        <td>
                            @foreach($currencies as $currency)
                                @if($country->idcurrency == $currency->idcurrency)
                                    {{ $currency->label }} ({{ $currency->format }})
                                @endif
                            @endforeach
                        </td>
                        <td>
                            <button class="btn btn-info bg-aqua btn-sm" onclick="edit()">
                                <i class="ion ion-edit"></i>&nbsp; @if($emp->lang == 'fr') Modifier @else
                                    Edit @endif
                            </button>
                            <button class="btn bg-red btn-sm" data-toggle="modal" data-target="#delete"
                                    onclick="setData('admin', 'country', '{{ $country->idcountry }}')">
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
