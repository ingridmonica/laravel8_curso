<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Importar o Controller pra usar na rota
use  App\Http\Controllers\EventController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
// Route::post('/register', [RegisterController::class, 'register']);


// rota pra mostrar o formulário de login
Route::get('/login', [LoginController::class, 'login']);
// pra receber a requisição -> post
Route::post('/events/login', [LoginController::class, 'authenticate'])->name('authenticate.login');


// Dizendo que vai usar o index controller e a rota index
Route::get('/', [EventController::class, 'index'] ); // create || middleware() nas rotas que a gente precisa que o usuário esteja logado
                                                    // é algo que vai agir entre a ação de clicar no link até a view ser entregue
Route::get('/events/create', [EventController::class, 'create'])->middleware('auth');
Route::get('/events/{id}', [EventController::class, 'show']);
Route::post('/events', [EventController::class, 'store']);
Route::delete('/events/{id}', [EventController::class, 'destroy'])->middleware('auth');
Route::get('/events/edit/{id}', [EventController::class, 'edit'])->middleware('auth');     // ver no front o conteúdo que já existe               | Podendo fazer  os dois a partir de uma action só
Route::put('/events/update/{id}', [EventController::class, 'update'])->middleware('auth'); // vai inserir a atualização no banco (fazer o update) | pra não repetir código (boas práticas #27)

// Cria uma nova rota que recebe(get) dados, onde acessa a rota(url) '/contact'
// e retorna uma view, um arquivo de blade php que tem html e php (dados dinâmicos)
// para o usuário

Route::get('/dashboard', [EventController::class, 'dashboard'])->middleware('auth');

// Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified']) -> group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });

// Rota para funcionalicade do usuário participar do evento | action de 'join' no EventController
Route::post('/events/join/{id}', [EventController::class, 'joinEvent'])->middleware('auth');

// Rota para funcionalicade do usuário deixar evento | action 'leaveEvent' no EventController
Route::delete('/events/leave/{id}', [EventController::class, 'leaveEvent'])->middleware('auth');

