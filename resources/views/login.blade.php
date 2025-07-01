<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <title>Geebin Login</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords"
        content="Geebin">
    <meta name="author" content="Cybernetics">
    <meta name="robots" content="index, follow">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, minimal-ui, viewport-fit=cover">
    <meta name="description"
        content="Geebin">
    <meta property="og:title" content="Geebin">
    <meta property="og:description"
        content="Geebin">
    <meta property="og:image" content="">
    <meta name="format-detection" content="telephone=no">

    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('/assets/images/favicon.png') }}">
    <link href="{{ asset('/assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/css/style.css') }}" rel="stylesheet">

</head>

<body class="vh-100">
    <div class="authincation h-100">
        <div class="container-fluid h-100">
            <div class="row h-100">
                <div class="col-lg-6 col-md-12 col-sm-12 mx-auto align-self-center">
                    <div class="login-form">
                        <div class="text-center">
                            <img src="{{ asset('/assets/images/logo-full.png') }}" class="mb-3 login-sm-logo mx-auto" alt="">
                            <h3 class="title">Sign In</h3>
                            <p>Sign in to your account to start using Geebin Portal</p>
                        </div>
                        {{ html()->form('POST', route('login.auth'))->open() }}
                        <div class="mb-4">
                            <label class="mb-1">Email<span class="text-danger"> *</span></label>
                            {{ html()->email('email')->class('form-control')->placeholder('Email') }}
                            @error('email')
                            <small class="text-danger">{{ $errors->first('email') }}</small>
                            @enderror
                        </div>
                        <div class="mb-4 position-relative">
                            <label class="mb-1">Password<span class="text-danger"> *</span></label>
                            {{ html()->password('password', old('password'))->attribute('id', 'dz-password')->class('form-control')->placeholder('******') }}
                            <span class="show-pass eye">
                                <i class="fa fa-eye-slash"></i>
                                <i class="fa fa-eye"></i>
                            </span>
                            @error('password')
                            <small class="text-danger">{{ $errors->first('password') }}</small>
                            @enderror
                        </div>
                        <div class="text-center mb-4 d-grid">
                            {{ html()->submit('Sign In')->class('btn btn-primary btn-submit') }}
                        </div>
                        @if(session()->has('success'))
                        <div class="text-center mb-4 d-grid">
                            <p class="text-success">{{ session()->get('success') }}</p>
                        </div>
                        @endif
                        @if(session()->has('error'))
                        <div class="text-center mb-4 d-grid">
                            <p class="text-danger">{{ session()->get('error') }}</p>
                        </div>
                        @endif
                        <p class="text-center">Not registered?
                            <a class="btn-link text-primary" href="#">Register</a>
                        </p>
                        {{ html()->form()->close() }}
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <div class="pages-left h-100">
                        <div class="login-content">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--**********************************
	Scripts
***********************************-->
    <!-- Required vendors -->
    <script src="{{ asset('/assets/vendor/global/global.min.js') }}"></script>

    <script src="{{ asset('/assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('/assets/js/deznav-init.js') }}"></script>
    <script src="{{ asset('/assets/js/custom.js') }}"></script>
    <script>
        $(function() {
            "use strict"
            $('form').submit(function() {
                $(this).find(".btn-submit").attr("disabled", true);
                $(this).find(".btn-submit").html("Authenticating...<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span>");
            });
        });
    </script>
</body>

</html>