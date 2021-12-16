<?php

use App\Models\UtilizadorAtivo;
use App\Models\Questao;

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
// Home

Route::view('/', 'teste');
Route::get('login', 'Auth\Autenticacao@showLoginForm')->name('login');

#M04
Route::get('/criarquestao','QuestaoController@showCreateForm');
Route::post('/criarquestao','QuestaoController@create');
