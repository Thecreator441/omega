<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Monnaies';
else
    $title = 'Dévise';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('edit')
    {{--    Insert and Update Currency Box--}}
    <div class="box" id="editForm" style="display: none;">
        <div class="box-header">
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right" id="exitEditForm">
                    <i class="fa fa-close"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <div class="container-fluid">
                <form action="{{ url('admin/currency/store') }}" method="post" role="form">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group @error('label') has-error @enderror">
                                <label for="label">@if($emp->lang == 'fr') NOMS @else NAME @endif</label>
                                <input type="text" class="form-control @error('label') is-invalid @enderror"
                                       value="{{ old('label') }}" name="label" id="label"
                                       placeholder="<?php echo $emp->lang === 'fr' ? 'Entrez le Noms' : 'Enter the Name'; ?>">
                                <span class="form-control-feedback"></span>
                                @error('label')<span class="invalid-feedback text-red" id="name_text"
                                                     role="alert">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="format">FORMAT</label>
                                <input type="text" class="form-control" name="format" id="format"
                                       placeholder="<?php echo $emp->lang === 'fr' ? 'Entrez le Format' : 'Enter the Format'; ?>">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary bg-primary pull-right btn-raised">Update</button>
                </form>
            </div>
        </div>
    </div>
    {{--    Insert and Update Currency Box--}}
@stop

@section('content')

    @yield('edit')

    {{--    Insert and Update Currency Box--}}
    <div class="box box-info" id="newForm" style="display: none;">
        <div class="box-header">
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right" id="exitForm">
                    <i class="fa fa-close"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <div class="container-fluid">
                <form action="{{ url('admin/currency/store') }}" method="post" role="form">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group @error('label') has-error @enderror">
                                <label for="label">@if($emp->lang == 'fr') Noms @else Name @endif</label>
                                <input type="text" class="form-control @error('label') is-invalid @enderror"
                                       value="{{ old('label') }}" name="label" id="label"
                                       placeholder="<?php echo $emp->lang === 'fr' ? 'Entrez le Noms' : 'Enter the Name'; ?>">
                                <span class="form-control-feedback"></span>
                                @error('label')<span class="invalid-feedback text-red" id="name_text"
                                                     role="alert">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="format">FORMAT</label>
                                <input type="text" class="form-control" name="format" id="format"
                                       placeholder="<?php echo $emp->lang === 'fr' ? 'Entrez le Format' : 'Enter the Format'; ?>">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary bg-primary pull-right btn-raised"><i
                            class="fa fa-save"></i>@if($emp->lang == 'fr') Enregistrer @else Save @endif
                    </button>
                </form>
            </div>
        </div>
    </div>
    {{--    Insert and Update Currency Box--}}

    {{--    Currencies List Box--}}
    <div class="box">
        <div class="box-header">
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-success bg-green btn-sm pull-right" id="insertForm">
                    <i class="oin ion-plus"></i>&nbsp;@if($emp->lang == 'fr') Nouvelle Dévise @else New
                    Currency @endif
                </button>
            </div>
        </div>
        <div class="box-body">
            <table id="bootstrap-data-table" class="table table-striped table-responsive-xl table-condensed">
                <thead>
                <tr>
                    <th>@if($emp->lang == 'fr') Dévise @else Currency @endif</th>
                    <th>Format</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($currencies as $currency)
                    <tr>
                        <td>{{ $currency->label }}</td>
                        <td>{{ $currency->format }}</td>
                        <td>
                            <button class="btn btn-info bg-aqua btn-sm" id="updateForm"
                                    onclick="updateData('currency', '{{ $currency->idcurrency }}')">
                                <i class="ion ion-edit"></i>&nbsp; @if($emp->lang == 'fr') Modifier @else
                                    Edit @endif
                            </button>
                            <button class="btn bg-red btn-sm" data-toggle="modal" data-target="#delete"
                                    onclick="setData('currency', '{{ $currency->idcurrency }}')">
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
    {{--    Currencies List Box --}}

@stop
