<?php

namespace App\Http\Controllers;

use App\Models\Utilizador;
use App\Models\UtilizadorAtivo;
use Illuminate\Http\Request;

class PerfilController extends Controller {
    public function showPerfil(String $nomeUtilizador) {
        $utilizador = Utilizador::procuraNomeUtilizador($nomeUtilizador);
        if (is_null($utilizador )) {
            return response(view('pages.perfil.erro'), 404)->header(
                'Content-type', 'text/html'
            );
        }
    }
}
