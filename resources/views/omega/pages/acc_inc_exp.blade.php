<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Compte d\'Exploitation Regrouper';
else
    $title = 'Scheduled Incomes/Expenses';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    <div class="box">
        <div class="box-body">
            <form action="{{ url('acc_inc_exp/store') }}" method="POST" role="form" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="col-md-12">
                    <button type="submit" name="save" id="save" class="btn btn-success bg-blue pull-right btn-raised">
                        <i class="fa fa-save"></i>&nbsp;@if ($emp->lang == 'fr') SAUVEGARDER @else BACKUP @endif
                    </button>
                </div>
            </form>
        </div>
    </div>

@stop
