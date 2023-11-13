@extends('layouts.main')

@section('title', 'HDC Events')

@section('content')

    <head>
        <title>Login</title>

        <!-- Bootstrap core CSS -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/geral.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="assets/css/login.css" rel="stylesheet">

        <link rel="icon" href="images/favicon.ico">
    </head>

    <body class="text-center">
        <div class="col-md-6 offset-md-3">
            <div id="login-container">
                <h1 class="login-text">Faça Login</h1>
                <form method="POST" action="{{ route('authenticate.login') }}">
                    @csrf
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="email" class="text-login-form">Email:</label>
                        <input type="email" name="email" id="email" class="form-control"
                            placeholder="nome@example.com.br" required>
                    </div>
                    <div class="form-group">
                        <label for="password" class="text-login-form">Senha:</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Senha"
                            required>
                    </div>
                    <button type="submit" class="btn btn-primary">Entrar</button>
                </form>
                <p class="register-link">Ainda não tem uma conta? <a href="{{ route('register') }}">Registre-se aqui</a></p>
            </div>
        </div>

@endsection
