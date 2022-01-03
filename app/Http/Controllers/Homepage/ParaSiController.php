<?php

namespace App\Http\Controllers\Homepage;

use App\Models\Questao;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;

class ParaSiController extends Controller {
    private function questoesImportantes() {
        $utilizador = Auth::user()->ativo;
        $idEtiquetasSeguidas = $utilizador->etiquetasSeguidas->map(function($etiqueta) {
            return $etiqueta->id;
        });
        $idQuestoes = DB::table('questao_etiqueta')
            ->select('id_questao')
            ->distinct()
            ->whereIn('id_questao', $idEtiquetasSeguidas);
        return Questao::query()
            ->joinSub($idQuestoes, 'questoes_seguidas', function($join) {
                $join->on('questao.id', '=', 'questoes_seguidas.id_questao');
            })
            ->orderByDesc('questao.data_publicacao')
            ->take(20)
            ->get();
    }

    public function mostraParaSi() {
        if (Auth::user()) {
            if (Auth::user()->ativo->etiquetasSeguidas->count()) {
                $questoes = $this->questoesImportantes();
            } else {
                $questoes = Questao::query()
                    ->orderByDesc('questao.data_publicacao')
                    ->take(20)
                    ->get();
            }
            return view('pages.home.para-si', [
                'selecionado' => 'para-si',
                'questoes' => $this->questoesImportantes()
            ]);
        }
    }
}
