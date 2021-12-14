<?php

use App\Models\UtilizadorAtivo;
use App\Models\Questao;

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
Route::get('/', function(){
    /*$user = UtilizadorAtivo::find(1);
    $message = '';
    foreach ($user->questoes as $questao) {
        $message .= '<br>' . $questao->toJson();
        echo $questao->getAutor->toJson();
    }
    return $message;*/
    foreach (UtilizadorAtivo::find(19)->notificacoes as $notificacao) {
        echo $notificacao->pivot;
    }
    //echo UtilizadorAtivo::find(19)->notificacoes;
});
