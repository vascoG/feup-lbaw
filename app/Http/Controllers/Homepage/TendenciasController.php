<?php

namespace App\Http\Controllers\Homepage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TendenciasController extends Controller {
    public function mostraTendencias() {
        return view('teste', [
            'selecionado' => 'tendencias'
        ]);
    }
}
