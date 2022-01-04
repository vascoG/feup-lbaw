<?php

namespace App\Http\Controllers\Homepage;

use App\Models\Questao;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class ParaSiController extends Controller {
    public function mostraParaSi() {
        if (Auth::user()) {
            $utilizador = Auth::user()->ativo;
            $questoes = $utilizador->etiquetasSeguidas->count() ? Questao::importante($utilizador) : Questao::emAlta();
            $questoes = $questoes
                ->take(20)
                ->get();
            return view('pages.home.para-si', [
                'selecionado' => 'para-si',
                'questoes' => $questoes
            ]);
        } else {
            return response('Nao esta autenticado', 403)
                ->header('Content-type', 'text/plain');
        }
    }
}
