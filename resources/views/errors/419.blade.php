@extends('layouts.error')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="error-page">
            <h2 class="headline text-red">419</h2>

            <div class="error-content">
                <h3><i class="fa fa-warning text-red"></i> Oops! Something went wrong.</h3>

                <p>
                    Session Timeout
                    Meanwhile, you may <a href="{{ url('/') }}">Return to Login</a>.
                </p>
            </div>
        </div>
        <!-- /.error-page -->
    </section>
    <!-- /.content -->
@stop
