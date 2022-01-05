<?php

namespace App\Http\Controllers\Admin;

use App\Models\Etiqueta;
use App\Http\Controllers\PesquisaEtiquetaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EtiquetaController extends PesquisaEtiquetaController {
    public function mostraEtiquetas() {
        $this->authorize('admin', Etiqueta::class);
        $etiquetas = $this->pesquisaEtiquetas(request('query'));

        return view('pages.admin.etiquetas', [
            'query' => request('query'),
            'etiquetas' => $etiquetas
        ]);
    }

    public function criaEtiqueta(Request $request) {
        $this->authorize('admin', Etiqueta::class);
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

        $dadosValidados = $validator->validated();
        Etiqueta::create($dadosValidados);

        return response()->json([
            'sucesso' => true
        ]);
    }

    public function alteraEtiqueta(Request $request, $id) {
        $this->authorize('admin', Etiqueta::class);
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
        $this->authorize('admin', Etiqueta::class);
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
