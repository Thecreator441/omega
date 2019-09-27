<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Sauvegarder';
else
    $title = 'Backup';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    <div class="box">
        <div class="box-body">
            <form action="{{ url('backup/store') }}" method="POST" role="form" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-12 text-bold text-purples">@if ($emp->lang == 'fr') Fichier
                            Sauvegarde @else Backup File @endif</div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="reference" class="col-md-3 control-label">@if ($emp->lang == 'fr')
                                    Fichier Sauvegarde @else Backup File @endif</label>
                            <div class="col-md-9">
                                <input type="file" name="reference" id="reference">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <button type="submit" id="save" class="btn btn-sm bg-blue pull-right btn-raised">
                        <i class="fa fa-save"></i>&nbsp;
                    </button>
                </div>
            </form>
        </div>
    </div>

@stop
