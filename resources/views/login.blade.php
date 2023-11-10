@extends('layouts.main')

@section('title', 'HDC Events')

@section('content')

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">

    <title>Login</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/geral.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/css/login.css" rel="stylesheet">

    <link rel="icon" href="images/favicon.ico">
</head>

<body class="text-center">
    <main class="form-signin">
        <div class="container">
            <form action="{{ route('authenticate.login') }}" method="POST">
                @csrf
                <h1 class="mb-4">HDC Events - Login</h1>
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
                <div class="mb-3">
                    <label for="floatingInput" class="visually-hidden">E-mail</label>
                    <input type="email" class="form-control" id="floatingInput" name="email" placeholder="nome@example.com.br"
                        autofocus>
                </div>
                <div class="mb-3">
                    <label for="floatingPassword" class="visually-hidden">Senha</label>
                    <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Senha">
                </div> <br>

                <button class="btn btn-primary" type="submit" name="bt_entrar">Entrar</button>
                <div class="mt-3">Não tem login? <a class="btn btn-warning" href="#">Cadastre-se</a></div>
            </form>
        </div>
    </main>
</body>

<footer class="mt-5">
    <div class="container">
        <p>HDC Events &copy; 2023</p>
    </div>
</footer>

</html>

@endsection
