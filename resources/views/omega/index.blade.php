<?php
$emp = Session::get('employee');
//$acc_date = Session::get('acc_date');

if ($emp->lang == 'fr') {
    App::setLocale('fr');
    $title = 'Acceuil';
} else {
    $title = 'Home';
}
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    {{--    @if($emp->lang == 'fr') Date Comptable @else Accounting Date @endif : {{ changeFormat($acc_date->accdate, 'user') }}--}}
    {{--    <h1>Index Page</h1>--}}

@stop()

@section('script')

@stop
