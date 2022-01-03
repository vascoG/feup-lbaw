<?php

namespace App\Http\Controllers\Homepage;

use App\Models\Etiqueta;
use App\Http\Controllers\PesquisaEtiquetaController;
use Illuminate\Http\Request;
use Auth;
use DB;

class EtiquetasController extends PesquisaEtiquetaController {
    public function mostraEtiquetas() {        
        return view('pages.home.etiquetas', [
            'selecionado' => 'etiquetas',
            'query' => request('query'),
            'etiquetas' => $this->pesquisaEtiquetas(request('query'))
        ]);
    }

    public function mudaEstado(Request $request, $idEtiqueta) {
        $etiqueta = Etiqueta::find($idEtiqueta);
        if (is_null($etiqueta)) {
            return response('Etiqueta nao encontrada', 404)
                ->header('Content-type', 'text/plain');
        }
        if (!Auth::check()) {
            return response('Nao esta autenticado', 403)
                ->header('Content-type', 'text/plain');
        }
        $utilizador = Auth::user()->ativo;
        $segueEtiqueta = $utilizador->segueEtiqueta($etiqueta);

        if ($segueEtiqueta) {
            DB::table('utilizador_ativo_etiqueta')
                ->where('id_utilizador', $utilizador->id)
                ->where('id_etiqueta', $etiqueta->id)
                ->delete();
        } else {
            DB::table('utilizador_ativo_etiqueta')->insert([
                'id_utilizador' => $utilizador->id,
                'id_etiqueta' => $idEtiqueta
            ]);
        }
        $segueEtiqueta = !$segueEtiqueta;
        return response()->json([
            'novoEstado' => $segueEtiqueta ? 'SEGUE' : 'NAO_SEGUE'
        ]);
    }
}
