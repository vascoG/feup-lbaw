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
// Home

Route::view('/', 'teste');

#M01
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::get('/login/registo', 'Auth\RegistoController@showRegistrationForm')->name('registo');

#M04
Route::get('/criarquestao','QuestaoController@showCreateForm');
Route::post('/criarquestao','QuestaoController@create');
Route::get('/questao/{idQuestao}/editar','QuestaoController@showEditForm')->name('editar-questao');
Route::put('questao/{idQuestao}/editar','QuestaoController@edit');
