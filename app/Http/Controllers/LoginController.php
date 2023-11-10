<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Lidar com tentativa de autenticação
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        // dd('teste');
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email é obrigatório',
            'password.required' => 'Senha é obrigatória'
        ]);

        // o attemptmétodo retornará 'true' se a autenticação for bem-sucedida. Caso contrário, 'false' será devolvido
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            //return view('/');

            return redirect()->intended('dashboard');
            // O intended método fornecido pelo redirecionador do Laravel irá redirecionar o usuário para a URL que ele
            // estava tentando acessar antes de ser interceptado pelo middleware de autenticação. Um URI substituto pode ser fornecido a este método caso
            // o destino pretendido não esteja disponível
        }

        return back()->withErrors([
            'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ]);
        

        // if (Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
        //     // O usuário está sendo lembrado
        //     }
    }

    // public function logout(Request $request)
    // {
    //     Auth::logout();

    //     $request->session()->invalidate();

    //     $request->session()->regenerateToken();

    //     return redirect('/');
    // }

    // para mostrar a pagina de login
    public function login() {
        return view('login');
    }
}
