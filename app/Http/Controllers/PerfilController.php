<?php

namespace App\Http\Controllers;

use App\Models\Utilizador;
use App\Models\UtilizadorAtivo;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PerfilController extends Controller {
    public function showPerfil(String $nomeUtilizador) {
        $utilizador = Utilizador::procuraNomeUtilizador($nomeUtilizador);
        if (is_null($utilizador)) {
            return response(view('pages.perfil.erro'), 404)->header(
                'Content-type', 'text/html'
            );
        }
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        return view('pages.perfil.perfil', ['usr' => $utilizador, 
            'colecaoQuestoes' => $this->questoesMaisRecentes($utilizador->ativo->id),
            'totalQuestoes' => $utilizador->ativo->questoes->count(),
            'colecaoEtiquetas' => $utilizador->ativo->etiquetasSeguidas->slice(0, 4)
                ->map(function ($item, $chave) {
                    return ['id' => $item->id, 'desc' => $item->nome];
                }),
            'totalEtiquetas' => $utilizador->ativo->etiquetasSeguidas->count(),
        ]);
    }

    public function questoesMaisRecentes($id_utilizador) {
        return DB::table('questao')
                ->where('autor', $id_utilizador)
                ->orderBy('data_publicacao', 'desc')
                ->get()
                ->slice(0, 4)
                ->map(function ($item, $chave) {
                    return ['id' => $item->id, 'desc' => $item->titulo];
                });
    }
}
