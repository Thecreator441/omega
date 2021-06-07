<?php

use Illuminate\Support\Facades\Session;

$emp = Session::get('employee');

if ($emp->lang === 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.home'))

@section('content')
    <h1>Admin Dashboard</h1>
{{--    @foreach($users as $user)--}}
{{--        <h2>@if ($emp->lang == 'fr') {{ $user->labelfr }} @else {{ $user->labeleng }} @endif</h2>--}}
{{--    @endforeach--}}
@stop()
