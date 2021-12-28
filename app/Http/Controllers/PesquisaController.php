<?php

namespace App\Http\Controllers;

use App\Models\Questao;
use Illuminate\Http\Request;

class PesquisaController extends Controller {
    private function pesquisaQuestao(String $pesquisa) {
        return Questao::whereRaw("tsvectors @@ to_tsquery('portuguese', ?)", [$pesquisa])
            ->get();
    }

    public function mostraPesquisa() {
        return view('pages.pesquisa.resultado', [
            'questoes' => $this->pesquisaQuestao(request('query'))
        ]);
    }
}
