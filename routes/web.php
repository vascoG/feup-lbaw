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

//M05
Route::get('/', 'Homepage\HomepageController@mostraHomepage')->name('home');
Route::get('/para-si', 'Homepage\ParaSiController@mostraParaSi')->name('para-si');
Route::get('/tendencias', 'Homepage\TendenciasController@mostraTendencias')->name('tendencias');
Route::get('/etiquetas', 'Homepage\EtiquetasController@mostraEtiquetas')->name('homepage-etiquetas');

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
Route::get('/perfil/{nomeUtilizador}/etiquetas', 'PerfilController@mostraEtiquetas')->name('perfil-etiquetas');
Route::get('/perfil/{nomeUtilizador}/questoes', 'PerfilController@mostraQuestoes')->name('perfil-questoes');
Route::get('/perfil/{nomeUtilizador}/respostas', 'PerfilController@mostraRespostas')->name('perfil-respostas');
Route::delete('/perfil/{nomeUtilizador}/imagem', 'PerfilController@apagaImagem');
Route::patch('/seguidos/etiqueta/{idEtiqueta}', 'Homepage\EtiquetasController@mudaEstado');
Route::get('/notificacoes', 'NotificacaoController@mostraNotificacoes')->name('notificacoes');
Route::delete('notificacoes', 'NotificacaoController@marcaTodasLida');
Route::delete('/notificacao/{idNotificacao}', 'NotificacaoController@marcaLida');
Route::get('/perfil/{nomeUtilizador}/apelos','PerfilController@mostraApelos')->name('perfil-apelos');
Route::get('/perfil/{nomeUtilizador}/criarapelos','PerfilController@showApeloForm')->name('formulario-apelo');
Route::post('/perfil/{nomeUtilizador}/criarapelos','PerfilController@create')->name('criar-apelo');

#M02
Route::view('/sobrenos', 'pages.estaticas.sobrenos')->name('sobre-nos');
Route::view('/contactos', 'pages.estaticas.contactos')->name('contactos');
Route::view('/faq', 'pages.estaticas.faq')->name('faq');
Route::redirect('/admin', '/admin/etiquetas')->name('admin');
Route::get('/admin/etiquetas', 'Admin\EtiquetaController@mostraEtiquetas')->name('admin-etiquetas');
Route::post('/admin/etiquetas', 'Admin\EtiquetaController@criaEtiqueta');
Route::patch('/admin/etiqueta/{id}', 'Admin\EtiquetaController@alteraEtiqueta');
Route::delete('/admin/etiqueta/{id}', 'Admin\EtiquetaController@apagaEtiqueta');
Route::get('/admin/moderadores','Admin\ModeradorController@showModerador')->name('admin-moderadores');
Route::patch('/admin/moderadores/editar/{idUtilizador}','Admin\ModeradorController@alteraModerador');
Route::get('/admin/banimento','AdminController@showApelo')->name('admin-apelo');
Route::post('/admin/banir/{idUtilzador}','AdminController@bane')->name('admin-bane');
Route::post('/admin/bloqueio/{idUtilizador}','AdminController@bloqueia')->name('admin-bloqueia');
Route::delete('/admin/bloqueio/{idUtilizador}','AdminController@desbloqueia')->name('admin-desbloqueia');

#M03
Route::get('/questao/{idQuestao}','QuestaoController@show')->name('questao');
Route::get('/questoes', 'PesquisaController@mostraPesquisa')->name('pesquisa');
Route::post('questao/{idQuestao}/criar-comentario','ComentarioController@createOnQuestion')->name('criar-comentario');
Route::post('questao/{idQuestao}/criar-comentario-resposta/{idResposta}','ComentarioController@createOnResponse')->name('criar-comentario-resposta');
Route::post('questao/{idQuestao}/criar-resposta','RespostaController@create')->name('criar-resposta');
Route::patch('/votar/questao/{idQuestao}','QuestaoController@votar')->name('votar');
Route::patch('/votar/resposta/{idResposta}','RespostaController@votar')->name('votar-resposta');
Route::post('/questao/{idQuestao}/resposta-correta/{idResposta}', 'RespostaController@respostaCorreta')->name('resposta-correta');
Route::delete('/questao/{idQuestao}/resposta-correta/{idResposta}', 'RespostaController@retirarRespostaCorreta')->name('retirar-resposta-correta');


#M04
Route::get('/criarquestao','QuestaoController@showCreateForm')->name('criarquestao');
Route::post('/criarquestao','QuestaoController@create');
Route::get('/questao/{idQuestao}/editar','QuestaoController@showEditForm')->name('editar-questao');
Route::put('questao/{idQuestao}/editar','QuestaoController@edit')->name('edit-questao');
Route::delete('questao/{idQuestao}/eliminar','QuestaoController@delete')->name('eliminar-questao');
Route::get('questao/{idQuestao}/editar-resposta/{idResposta}','RespostaController@showEditForm')->name('editar-resposta');
Route::put('questao/{idQuestao}/editar-resposta/{idResposta}','RespostaController@edit')->name('edit-resposta');
Route::delete('questao/{idQuestao}/eliminar-resposta/{idResposta}','RespostaController@delete')->name('eliminar-resposta');
Route::get('questao/{idQuestao}/editar-comentario/{idComentario}','ComentarioController@showEditForm')->name('editar-comentario');
Route::put('questao/{idQuestao}/editar-comentario/{idComentario}','ComentarioController@edit')->name('edit-comentario');
Route::delete('questao/{idQuestao}/eliminar-comentario/{idComentario}','ComentarioController@delete')->name('eliminar-comentario');



