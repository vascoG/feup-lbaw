<?php

namespace App\Http\Controllers;

use App\Models\Etiqueta;
use Illuminate\Http\Request;

class PesquisaEtiquetaController extends Controller {
    public function pesquisaEtiquetas(?String $queryString) {
        $etiquetas = Etiqueta::query();
        if (!is_null($queryString)) {
            $etiquetas->whereRaw("tsvectors @@ plainto_tsquery('portuguese', ?)", $queryString);
        }
        return $etiquetas->get();
    }
}
