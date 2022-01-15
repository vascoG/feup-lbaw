<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UtilizadorAtivo;
use App\Models\Utilizador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ModeradorController extends Controller
{
    private function pesquisaUtilizador($nomeUtilizadorSubstr) {
        return Utilizador::query()
            ->whereRaw("(POSITION(LOWER(:query) in LOWER(nome)) > 0) OR (POSITION(LOWER(:query) IN LOWER(nome_utilizador)) > 0)", [
                ':query' => $nomeUtilizadorSubstr
            ]);
    }

    public function showModerador() {
        if(!Auth::check()) return redirect('/login');
        $this->authorize('admin',Utilizador::class);
        $users = UtilizadorAtivo::query();
        if (!is_null(request('query'))) {
            $filtroUtilizadores = $this->pesquisaUtilizador(request('query'));
            $users = $users->joinSub($filtroUtilizadores, 'utilizadores_query', function($join) {
                $join->on('utilizador_ativo.id_utilizador', '=', 'utilizadores_query.id');
            });
        } else {
            $users = $users->join('utilizador', 'utilizador_ativo.id_utilizador', '=', 'utilizador.id');
        }
        $users = $users->orderBy('nome_utilizador', 'asc')
            ->paginate(15)
            ->withQueryString();
        return view('pages.admin.moderadores', [
            'users' => $users,
            'query' => request('query')
        ]);
    }

    public function alteraModerador(Request $request, $id_utilizador) {
        $utilizador= Utilizador::find($id_utilizador);
        if (is_null($utilizador)) {
            return response('Utilizador nao encontrado', 404)
                ->header('Content-type', 'text/plain');
        }
        if(!Auth::check()) return redirect('/login');
        $this->authorize('admin', Utilizador::class);
        $moderador = $utilizador->moderador;
        
        if ($moderador) {
            $utilizador->moderador=false; $utilizador->save();
        } else {
            $utilizador->moderador=true; $utilizador->save();
        }
        return response()->json([
            'novoEstado' => $utilizador->moderador ?  'MODERADOR' : 'NAO_MODERADOR'
        ]);
    }
}
