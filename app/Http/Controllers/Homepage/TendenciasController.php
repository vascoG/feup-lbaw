<?php

namespace App\Http\Controllers\Homepage;

use App\Models\Questao;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class TendenciasController extends Controller {
    public function mostraTendencias() {
        $questoes = Questao::emAlta()->take(20)->get();
        
        return view('pages.home.tendencias', [
            'selecionado' => 'tendencias',
            'questoes' => $questoes
        ]);
    }
}
