<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Administrateur';
else
    $title = 'Administrator';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')
    <h1>Index Page</h1>
{{--    @foreach($users as $user)--}}
{{--        <h2>@if ($emp->lang == 'fr') {{ $user->labelfr }} @else {{ $user->labeleng }} @endif</h2>--}}
{{--    @endforeach--}}
@stop()
