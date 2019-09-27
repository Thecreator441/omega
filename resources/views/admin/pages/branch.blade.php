<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Agences';
else
    $title = 'Branches';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    <div class="box box-info" id="newForm" style="display: none;">
        <div class="box-header with-border">
            <h3 class="box-title text-bold">@if($emp->lang == 'fr') Nouvelles Agence @else New Branch @endif</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right" id="exitForm">
                    <i class="fa fa-close"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <div class="container-fluid">
                <form action="{{ route('admin/branch/store') }}" method="post" role="form">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="labelfr">@if($emp->lang == 'fr') NOMS  @else NAME @endif</label>
                                <input type="text" class="form-control" name="name" id="name"
                                       placeholder="<?php echo $emp->lang === 'fr' ? 'Entrez le Noms en Français' : 'Enter the Name in French'; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="phone1">@if($emp->lang == 'fr') NUMERO TELEPHONE @else PHONE NUMBER @endif</label>
                                <input type="text" class="form-control" name="phone1" id="phone1"
                                       placeholder="<?php echo $emp->lang === 'fr' ? 'Entrez le numéro de téléphone 1' : 'Enter phone number 1'; ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="phone2">@if($emp->lang == 'fr') NUMERO TELEPHONE @else PHONE NUMBER @endif</label>
                                <input type="text" class="form-control" name="phone2" id="phone2"
                                       placeholder="<?php echo $emp->lang === 'fr' ? 'Entrez le numéro de téléphone 2' : 'Enter phone number 2'; ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email">EMAIL</label>
                                <input type="text" class="form-control" name="email" id="email"
                                       placeholder="<?php echo $emp->lang === 'fr' ? 'Entrer e-mail' : 'Enter email'; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="region">@if($emp->lang == 'fr') REGION @else REGION @endif</label>
                                <input type="text" class="form-control" name="region" id="region"
                                       placeholder="<?php echo $emp->lang === 'fr' ? 'Entrez le Région' : 'Enter Region'; ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="town">@if($emp->lang == 'fr') VILLE @else TOWN @endif</label>
                                <input type="text" class="form-control" name="town" id="town"
                                       placeholder="<?php echo $emp->lang === 'fr' ? 'Entrez le nom de la ville' : 'Enter name of town'; ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="address">@if($emp->lang == 'fr') ADRESSE @else
                                        ADDRESS @endif</label>
                                <input type="text" class="form-control" name="address" id="address"
                                       placeholder="<?php echo $emp->lang === 'fr' ? 'Entrez adresse' : 'Enter the address'; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="postcode">@if($emp->lang == 'fr') CODE POSTAL @else POST
                                    CODE @endif</label>
                                <input type="text" class="form-control" name="postcode" id="postcode"
                                       placeholder="<?php echo $emp->lang === 'fr' ? 'Entrez le codepostal' : 'Enter the postcode'; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="postal code">@if($emp->lang == 'fr') INSTITUTION @else
                                        INSTITUTION @endif</label>
                                <select class="form-control" id="idinst" name="idinst">
                                    <option>@if($emp->lang == 'fr') Selectionez la Institution @else Select
                                        institution @endif</option>
                                    @foreach($institutions as $ins)
                                        <option value="{{ $ins->idinst }}">{{ $ins->name }}</option>
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

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold">@if($emp->lang == 'fr') Agences @else Branches @endif</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-success bg-green btn-sm pull-right" id="insertForm">
                    <i class="oin ion-plus"></i>&nbsp;@if($emp->lang == 'fr') Nouvelles Agences @else New
                    Branches @endif
                </button>
            </div>
        </div>
        <div class="box-body">
            <table id="bootstrap-data-table" class="table table-striped table-hover table-responsive-xl">
                <thead>
                <tr>
                    <th>@if($emp->lang == 'fr') Noms @else Name @endif</th>
                    <th>@if($emp->lang == 'fr') Téléphone @else Phone @endif</th>
                    <th>@if($emp->lang == 'fr') Ville @else Town @endif</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($branches as $branch)
                    <tr>
                        <td>{{ $branch->name}}</td>
                        <td>{{$branch->phone1}}</td>
                        <td>{{$branch->town}}</td>
                        <td>{{$branch->email}}</td>
                        <td>
                            <button class="btn btn-info bg-aqua btn-sm" onclick="edit()">
                                <i class="ion ion-edit"></i>&nbsp; @if($emp->lang == 'fr') Modifier @else
                                    Edit @endif
                            </button>
                            <button class="btn bg-red btn-sm" data-toggle="modal" data-target="#delete"
                                    onclick="setData('branch', '{{ $branch->idbranch }}')">
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
