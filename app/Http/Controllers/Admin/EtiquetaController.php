<?php

namespace App\Http\Controllers\Admin;

use App\Models\Etiqueta;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EtiquetaController extends Controller {
    public function mostraEtiquetas() {
        return view('pages.admin.etiquetas', [
            'etiquetas' => Etiqueta::all()
        ]);
    }
}
