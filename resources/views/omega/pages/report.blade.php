<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Rapport';
else
    $title = 'Report';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')
    <h1>Report</h1>
@stop
