<?php

namespace App\Http\Controllers;

use App\Models\Utilizador;
use App\Models\UtilizadorAtivo;
use Illuminate\Http\Request;
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
        return view('pages.perfil.perfil', ['usr' => Auth::user()]);
    }
}
