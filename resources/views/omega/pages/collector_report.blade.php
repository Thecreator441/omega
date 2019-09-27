<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Rapport Colecteur';
else
    $title = 'Collector Report';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')
    <div class="box">
        <div class="box-body">
            @if ($emp->lang == 'fr') Rapport Collecteur @else Collector Report @endif
        </div>
    </div>
@stop
