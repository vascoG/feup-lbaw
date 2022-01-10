<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificacaoController extends Controller {
    public function mostraNotificacoes($nomeUtilizador) {
        $utilizador = Utilizador::procuraNomeUtilizador($nomeUtilizador);
        if (is_null($utilizador)) {
            return $this->viewNaoEncontrada();
        }
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        dump($utilizador->ativo->notifications()->count());
        $teste =$utilizador->ativo->notifications; 
        foreach($teste as $notification) {
            dump("passou aqui");
            dump($notification->type);
        }
        dd("PARA");

        return view('partials.notificacoes.dropdown');
    }
}
