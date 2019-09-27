<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Ajustage Parts Mensuelles';
else
    $title = 'Share Months Adjustment';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    <div class="box">
        <div class="box-body">
            <form action="{{ url('share_mon_adj/store') }}" method="POST" role="form" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-12 text-bold text-purples">@if ($emp->lang == 'fr') Importer
                            Fichier @else Upload File @endif</div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="reference" class="col-md-3 control-label">@if ($emp->lang == 'fr')
                                    Importer Fichier @else Upload File @endif</label>
                            <div class="col-md-9">
                                <input type="file" name="reference" id="reference">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <button type="submit" name="save" id="save" class="btn btn-success bg-blue pull-right btn-raised">
                        <i class="fa fa-save"></i>&nbsp;@if ($emp->lang == 'fr') SAUVEGARDER @else BACKUP @endif
                    </button>
                </div>
            </form>
        </div>
    </div>

@stop
