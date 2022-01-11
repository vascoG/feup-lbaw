<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UtilizadorAtivo;
use Auth;

class NotificacaoController extends Controller {
    public function mostraNotificacoes() {
        if(!Auth::check()) {
            return response(view('errors.403'), 403)->header(
                'Content-type', 'text/html'
            );
        }
        return response()->json([
            'nNotificacoes' => Auth::user()->ativo->unreadNotifications->count(),
            'html' => view('partials.notificacoes.lista-notificacoes')->render()
        ]);
    }

    public function marcaTodasLida(Request $request) {
        if(!Auth::check()) {
            return response(view('errors.403'), 403)->header(
                'Content-type', 'text/html'
            );
        }
        foreach(Auth::user()->ativo->unreadNotifications as $notificacao) {
            $notificacao->markAsRead();
        }
        return response('OK', 200)->header(
            'Content-type', 'text/plain'
        );
    }

    public function marcaLida(Request $request, $idNotificacao) {
        if(!Auth::check()) {
            return response(view('errors.403'), 403)->header(
                'Content-type', 'text/html'
            );
        }
        $notificacoes = Auth::user()
            ->ativo
            ->unreadNotifications
            ->where('id', $idNotificacao);
        if (!$notificacoes->count()) {
            return response(view('errors.404'), 404)->header(
                'Content-type', 'text/html'
            );
        }
        $notificacoes->first()->markAsRead();
        return response('OK', 200)->header(
            'Content-type', 'text/plain'
        );
    }
}
