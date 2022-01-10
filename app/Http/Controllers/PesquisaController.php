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
            $questoes->whereRaw("tsvectors @@ to_tsquery('portuguese', ?)", "'".request('query')."'");
        }
        if(request('etiqueta')) {
            $etiquetasSelecionadas = explode(',', request('etiqueta'));
            $idTabela = 0; //Podiamos usar curEtiqueta mas tornariamos a query vulneravel a SQL injection
            foreach($etiquetasSelecionadas as $curEtiqueta) {
                $questoesEtiqueta = DB::table('questao_etiqueta')
                    ->select('questao_etiqueta.id_questao')
                    ->where('id_etiqueta', '=', $curEtiqueta);
                $nomeTabela = strtr('questoes_etiqueta_@id', ['@id' => $idTabela]);
                $questoes->joinSub($questoesEtiqueta, $nomeTabela, function($join) use($nomeTabela) {
                    $join->on('questao.id', '=', $nomeTabela.'.id_questao');
                });
                $idTabela++;
            }
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
        //dump(request('query'));
        //dd($questoes->toSql());
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
