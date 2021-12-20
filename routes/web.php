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

Route::view('/', 'teste')->name('home');

#M01
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::get('/login/registo', 'Auth\RegistoController@showRegistrationForm')->name('registo');
#M02
Route::get('/sobrenos',function(){return view('pages.sobrenos');});
Route::get('/contactos',function(){return view('pages.contactos');});
Route::get('/faq',function(){return view('pages.faq');});
Route::get('/servicos',function(){return view('pages.servicos');});
Route::get('/admin/moderadores','AdminController@showModerador');
Route::put('/admin/moderadores','AdminController@createModerador');
Route::get('/admin/banimento','AdminController@showApelo');


#M04
Route::get('/criarquestao','QuestaoController@showCreateForm');
Route::post('/criarquestao','QuestaoController@create');
Route::get('/questao/{idQuestao}/editar','QuestaoController@showEditForm')->name('editar-questao');
Route::put('questao/{idQuestao}/editar','QuestaoController@edit');
