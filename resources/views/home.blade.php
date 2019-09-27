<?php $emp = session()->get('employee'); ?>
@extends('layouts.home.dashboard')

@section('title', 'Dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper"
         style="background: url({{ asset('images/bgLogo3.png') }}) no-repeat; background-position: center">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            @yield('main')
        </section>
        <!-- Main content -->
        <section class="content">

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@stop
