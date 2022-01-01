<?php

namespace App\Http\Controllers\Admin;

use App\Models\Etiqueta;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class EtiquetaController extends Controller {
    public function mostraEtiquetas() {
        $etiquetas = Etiqueta::query();
        if (request('query')) {
            $etiquetas->whereRaw("tsvectors @@ to_tsquery('portuguese', ?)", request('query'));
        }

        return view('pages.admin.etiquetas', [
            'query' => request('query'),
            'etiquetas' => $etiquetas->get()
        ]);
    }

    public function alteraEtiqueta(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|unique:etiqueta'
        ]);
        if ($validator->fails()) {
            return response([
                'sucesso' => false,
                'erro' => $validator->errors()
            ], 400)
                ->header('Content-type', 'application/json');

        }

        $etiqueta = Etiqueta::find($id);
        if (is_null($etiqueta)) {
            return response('Etiqueta nao encontrada', 404)
                ->header('Content-type', 'text/plain');
        }
        $etiqueta->update($request->all());
        $etiqueta->save();

        return response()->json([
            'sucesso' => true,
        ]);
    }

    public function apagaEtiqueta(Request $request, $id) {
        $etiqueta = Etiqueta::find($id);
        if (is_null($etiqueta)) {
            return response('Etiqueta nao encontrada', 404)
                ->header('Content-type', 'text/plain');
        }
        $etiqueta->delete();

        return response()->json([
            'sucesso' => true
        ]);
    }
}
