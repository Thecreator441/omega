<?php
$emp = Session::get('employee');
// dd($emp);

$title = $menu->labeleng;
if ($emp->lang == 'fr') {
    $title = $menu->labelfr;
    App::setLocale('fr');
}
?>

@extends('layouts.printing')
    
@section('title', $title)

@section('content')
    <h1>This is a test file</h1>
@stop
