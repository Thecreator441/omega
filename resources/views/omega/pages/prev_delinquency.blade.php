<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Delinquance Exercice Anterieur';
else
    $title = 'Previous Exercise Delinquency';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    <div class="box">
        <div class="box-body">
            <form action="{{ url('prev_delinquency/store') }}" method="POST" role="form">
                {{ csrf_field() }}


                <div class="col-md-12">
                    <button type="submit" name="save" id="save" class="btn btn-success bg-blue pull-right btn-raised">
                        <i class="fa fa-save"></i>&nbsp; @if ($emp->lang == 'fr') ENREGISTRER @else SAVE @endif
                    </button>
                </div>
            </form>
        </div>
    </div>

@stop
