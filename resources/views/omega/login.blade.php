@extends('layouts.default')

@section('title', 'Log In')

@section('content')
    <div id="wrapper" style="margin-top: 129px;">
        <div class="login-box-body">
            <img src="{{ asset('images/loginLogo.png') }}" class="avatar">
            <h1 style="margin-top: 50px;" id="headText">Login</h1>
            <form action="{{ url('login') }}" method="POST" role="form">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            @if ($message = Session::get('danger'))
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                                    </button>
                                    <h4><i class="icon fa fa-warning"></i>Alert!</h4>
                                    {{ $message }}
                                </div>
                            @endif
                            @if (Session::get('errors'))
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                                    </button>
                                    <h4><i class="icon fa fa-warning"></i>Alert!</h4>
                                    @error('name')
                                    {{$message}}
                                    @enderror
                                    <br>
                                    @error('password')
                                    {{$message}}
                                    @enderror
                                </div>
                            @endif
                        </div>
                        <div class="col-md-12">
                            <div class="form-group @error('name') has-error @enderror">
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}" name="name" id="name"
                                       placeholder="@lang('label.name')">
                                <i class="fa fa-user form-control-feedback"></i>
                                @error('name')<span class="invalid-feedback text-red" id="name_text"
                                                    role="alert"></span>@enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group @error('password') has-error @enderror">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                       name="password" id="password" placeholder="@lang('label.password')" autocomplete="off">
                                <i class="fa fa-key form-control-feedback"></i>
                                @error('password')<span class="invalid-feedback text-red" id="password_text"
                                                        role="alert"></span>@enderror
                            </div>
                        </div>

                        <div class="col-md-7"></div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <select class="form-control select2" id="langType" name="lang">
                                    <option value="eng" selected><span id="engText"> English</span></option>
                                    <option value="fr"><span id="frText"> Français</span></option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary bg-blue-gradient btn-raised pull-right">
                                <i class="fa fa-sign-in"></i>&nbsp; <span id="loginText">Sign In</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.login-box-body -->
    </div>
@stop

@section('script')
    <script>
        $(document).ready(function () {
            $('form').attr('autocomplete', 'on');

            // Used to set alerts automatic dismissal
            $(function () {
                setTimeout(function () {
                    $(".alert").alert('close');
                }, 5000);
            });
        });

        let name = $('#name');
        let password = $('#password');

        name.on('keyup', function () {
            $('#name_text').text('');
        });
        password.on('keyup', function () {
            $('#password_text').text('');
        });

        $(document).on('change', '#langType', function () {
            if ($(this).val() === 'fr') {
                $('#headText').text('S\'identifier');
                name.attr('placeholder', 'Noms');
                password.attr('placeholder', 'Mot de passe');
                $('#engText').text('Anglais');
                $('#frText').text('Français');
                $('#loginText').text('Connexion');
            } else {
                $('#headText').text('Login');
                name.attr('placeholder', 'Names');
                password.attr('placeholder', 'Password');
                $('#engText').text('English');
                $('#frText').text('French');
                $('#loginText').text('Sign In');
            }
        });
    </script>
@stop
