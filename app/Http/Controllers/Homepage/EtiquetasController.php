<?php

namespace App\Http\Controllers\Homepage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EtiquetasController extends Controller{
    public function mostraEtiquetas() {
        return view('pages.home.etiquetas', [
            'selecionado' => 'etiquetas'
        ]);
    }
}
