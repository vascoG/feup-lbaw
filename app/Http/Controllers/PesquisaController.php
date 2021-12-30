<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Etiqueta;
use App\Models\Questao;
use Illuminate\Http\Request;

class PesquisaController extends Controller {
    private function aplicaFiltros() {
        $questoes = Questao::query();
        $ordem = 'desc';
        if (request('ordenar-ordem')) {
            $ordem = request('ordenar-ordem');
        }
        if(request('query')) {
            $questoes->whereRaw("tsvectors @@ to_tsquery('portuguese', ?)", request('query'));
        }
        if(request('etiqueta')) {
            $etiquetas = DB::table('questao_etiqueta')
                ->select('id_questao')
                ->whereIn('id_etiqueta', explode(',', request('etiqueta')));
            $questoes->joinSub($etiquetas, 'etiquetas_pesquisadas', function($join) {
                $join->on('questao.id', '=', 'etiquetas_pesquisadas.id_questao');
            });
        }
        if (request('ordenar-atributo')) {
            $atributo = request('ordenar-atributo');
            switch ($atributo) {
                case "mais-recentes": {
                    $questoes->orderBy('data_publicacao', $ordem);
                    break;
                }
                case "mais-votos": {
                    $questoes->join('gosto_questoes', 'questao.id', '=', 'gosto_questoes.id_questao')
                        ->orderBy('n_gosto', $ordem);
                }
                case "mais-reputacao": {
                    $questoes->join('reputacao', 'questao.autor', '=', 'reputacao.id_utilizador')
                        ->orderBy('reputacao.reputacao', $ordem);
                }
            }
        }
        return $questoes->paginate(10);
    }

    public function mostraPesquisa() {
        $paginasQuestoes = $this->aplicaFiltros();
        $paginasQuestoes->appends([
            'query' => request('query') ?: "",
            'ordenar-atributo' => request('ordenar-atributo') ?: "",
            'ordenar-ordem' => request('ordenar-ordem') ?: "",
            'etiquetas' => request('etiquetas') ?: ""
        ]);
        return view('pages.pesquisa.resultado', [
            'ordenarAtributo' => request('ordenar-atributo'),
            'ordenarOrdem' => request('ordenar-ordem'),
            'query' => request('query'),
            'etiquetas' => explode(',', request('etiqueta')),
            'questoes' => $paginasQuestoes
        ]);
    }
}