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
            $etiquetasSelecionadas = explode(',', request('etiqueta'));
            $questoesEtiquetas = DB::query()
                ->select('questoes_etiqueta_0.id_questao')
                ->fromSub (
                    DB::table('questao_etiqueta')
                        ->select('id_questao')
                        ->where('id_etiqueta', '=', $etiquetasSelecionadas[0]),
                    'questoes_etiqueta_0'
                );
            $idTabela = 1; //Podiamos usar curEtiqueta mas tornariamos a query vulneravel a SQL injection
            array_shift($etiquetasSelecionadas);
            foreach($etiquetasSelecionadas as $curEtiqueta) {
                $questoesCurEtiqueta = DB::table('questao_etiqueta')
                    ->select('questao_etiqueta.id_questao')
                    ->where('id_etiqueta', '=', $curEtiqueta);
                $nomeTabela = strtr('questoes_etiqueta_@id', ['@id' => $idTabela]);
                $questoesEtiquetas->joinSub($questoesCurEtiqueta, $nomeTabela, function($join) use($nomeTabela) {
                    $join->on('questoes_etiqueta_0.id_questao', '=', $nomeTabela.'.id_questao');
                });
                $idTabela++;
            }
            $questoes->joinSub($questoesEtiquetas, 'etiquetas_pesquisadas', function($join) {
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
        return $questoes->paginate(10)->withQueryString();
    }

    public function mostraPesquisa() {
        return view('pages.pesquisa.resultado', [
            'ordenarAtributo' => request('ordenar-atributo'),
            'ordenarOrdem' => request('ordenar-ordem'),
            'query' => request('query'),
            'etiquetas' => request('etiqueta') ? explode(',', request('etiqueta')) : [],
            'questoes' => $this->aplicaFiltros()
        ]);
    }
}
