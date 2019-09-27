<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Type de compte';
else
    $title = 'Account Types';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    <div class="box box-info" id="newForm" style="display: block;">
        <div class="box-header">
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right" id="exitForm">
                    <i class="fa fa-close"></i>
                </button>
            </div>

            <form action="{{ route('admin/acctype/store') }}" method="post" role="form">
                {{ csrf_field() }}
                <input type="hidden" name="id" id="id">
                <div class="col-md-12">
                    @if($emp->lang == 'fr')
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="labelfr" >@if($emp->lang == 'fr') LABEL  @else LABEL @endif</label>
                                <input type="text" class="form-control" name="labelfr" id="labelfr">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="labeleng">@if($emp->lang == 'fr') LABEL   @else LABEL @endif</label>
                                <input type="text" class="form-control" name="labeleng" id="labeleng"
                                       placeholder="<?php echo $emp->lang === 'fr' ? 'Entrez le Label en Anglais' : 'Enter the Label in English'; ?>">
                            </div>
                        </div>
                    @else
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="labelfr">@if($emp->lang == 'fr') LABEL  @else LABEL @endif</label>
                                <input type="text" class="form-control" name="labelfr" id="labelfr"
                                       placeholder="<?php echo $emp->lang === 'fr' ? 'Entrez le Label en Français' : 'Enter the Label in French'; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="labeleng">@if($emp->lang == 'fr') LABEL   @else LABEL @endif</label>
                                <input type="text" class="form-control" name="labeleng" id="labeleng">
                            </div>
                        </div>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary bg-primary pull-right btn-raised">Save</button>
            </form>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-success bg-green btn-sm pull-right" id="insertForm">
                    <i class="oin ion-plus"></i>&nbsp; @if($emp->lang == 'fr') Nouveau Type de compte @else New Account
                    Type @endif
                </button>
            </div>
        </div>
        <div class="box-body">
            <table id="bootstrap-data-table" class="table table-striped table-hover table-responsive-xl">
                <thead>
                <tr>
                    <th>@if($emp->lang == 'fr') Nom du compte @else Account Name @endif</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($acctypes as $acctype)
                    <tr>
                        <td>@if($emp->lang == 'fr') {{ $acctype->labelfr}} @else {{ $acctype->labeleng}} @endif</td>

                        <td>
                            <button class="btn btn-info bg-aqua btn-sm" onclick="edit()">
                                <i class="ion ion-edit"></i>&nbsp; @if($emp->lang == 'fr') Modifier @else
                                    Edit @endif
                            </button>
                            <button class="btn bg-red btn-sm" data-toggle="modal" data-target="#delete"
                                    onclick="setData('acctype', '{{ $acctype->idacctype }}')">
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
