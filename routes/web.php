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

Route::get('/', 'Admin\EtiquetaController@mostraEtiquetas')->name('home');

#M01
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/login/registo', 'Auth\RegistoController@showRegistrationForm')->name('registo');
Route::post('/login/registo', 'Auth\RegistoController@register');
Route::get('/recuperacao', 'Auth\RecuperaPassword@mostraFormularioPedido')->middleware('guest')->name('recupera-password');
Route::post('/recuperacao', 'Auth\RecuperaPassword@submetePedido');
Route::get('/recuperacao/{token}', 'Auth\RecuperaPassword@mostraFormularioRecuperacao')->middleware('guest');
Route::post('/recuperacao/{token}', 'Auth\RecuperaPassword@alteraPassword')->name('altera-password');
Route::get('/perfil/{nomeUtilizador}', 'PerfilController@mostraPerfil')->name('perfil');
Route::patch('/perfil/{nomeUtilizador}', 'PerfilController@alteraDados');
Route::delete('/perfil/{nomeUtilizador}', 'PerfilController@apagaPerfil');
Route::get('/perfil/{nomeUtilizador}/editar', 'PerfilController@mostraEditar')->name('editar-perfil');
Route::put('/perfil/{nomeUtilizador}/imagem', 'PerfilController@alteraImagem')->name('editar-perfil-imagem');
Route::delete('/perfil/{nomeUtilizador}/imagem', 'PerfilController@apagaImagem');

#M02
Route::view('/sobrenos', 'pages.sobrenos');
Route::view('/contactos', 'pages.contactos');
Route::view('/faq', 'pages.faq');
Route::view('/servicos', 'pages.servicos');
Route::get('/etiquetas', 'Admin\EtiquetaController@mostraEtiquetas')->name('etiquetas');
Route::put('/etiqueta/{id}', 'Admin\EtiquetaController@alteraEtiqueta');
Route::delete('/etiqueta/{id}', 'Admin\EtiquetaController@apagaEtiqueta');
Route::get('/admin/moderadores','AdminController@showModerador');
Route::put('/admin/moderadores','AdminController@createModerador');
Route::get('/admin/banimento','AdminController@showApelo');


#M03
Route::get('/questoes', 'PesquisaController@mostraPesquisa')->name('pesquisa');

#M04
Route::get('/criarquestao','QuestaoController@showCreateForm')->name('criarquestao');
Route::post('/criarquestao','QuestaoController@create');
Route::get('/questao/{idQuestao}/editar','QuestaoController@showEditForm')->name('editar-questao');
Route::put('questao/{idQuestao}/editar','QuestaoController@edit')->name('edit-questao');
Route::delete('questao/{idQuestao}/eliminar','QuestaoController@delete')->name('eliminar-questao');
Route::get('questao/{idQuestao}/editar-resposta/{idResposta}','RespostaController@showEditForm')->name('editar-resposta');
Route::put('questao/{idQuestao}/editar-resposta/{idResposta}','RespostaController@edit')->name('edit-resposta');
Route::delete('questao/{idQuestao}/eliminar-resposta/{idResposta}','RespostaController@delete')->name('eliminar-resposta');

