<?php

namespace App\Http\Controllers;

use App\Models\Utilizador;
use Illuminate\Http\Request;
use DB;
use Auth;
use Image;
use Storage;
use Validator;
use Carbon\Carbon;

class PerfilController extends Controller {
    private function viewNaoEncontrada() {
        return response(view('pages.perfil.erro'), 404)->header(
            'Content-type', 'text/html'
        );
    }
    
    public function mostraPerfil(String $nomeUtilizador) {
        $utilizador = Utilizador::procuraNomeUtilizador($nomeUtilizador);
        if (is_null($utilizador)) {
            return $this->viewNaoEncontrada();
        }
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        return view('pages.perfil.perfil', ['usr' => $utilizador, 
            'colecaoQuestoes' => $this->questoesMaisRecentes($utilizador->ativo->id),
            'totalQuestoes' => $utilizador->ativo->questoes->count(),
            'colecaoEtiquetas' => $utilizador->ativo->etiquetasSeguidas->slice(0, 4)
                ->map(function ($item, $chave) {
                    return ['id' => $item->id, 'desc' => $item->nome];
                }),
            'totalEtiquetas' => $utilizador->ativo->etiquetasSeguidas->count(),
        ]);
    }

    public function questoesMaisRecentes($id_utilizador) {
        return DB::table('questao')
                ->where('autor', $id_utilizador)
                ->orderBy('data_publicacao', 'desc')
                ->get()
                ->slice(0, 4)
                ->map(function ($item, $chave) {
                    return ['id' => $item->id, 'desc' => $item->titulo];
                });
    }

    public function mostraEditar(String $nomeUtilizador) {
        $perfil = Utilizador::procuraNomeUtilizador($nomeUtilizador);
        if (is_null($perfil)) {
            $this->viewNaoEncontrada();
        }
        $this->authorize('editar', $perfil);

        return view('pages.perfil.editar', [
            'descricaoTamanhoMax' => 1500, 
            'nomeUtilizador' => $nomeUtilizador,
            'imagem_perfil' => $perfil->imagem_perfil,
            'email' => $perfil->e_mail,
            'nome' => $perfil->nome,
            'dataNascimento' => $perfil->data_nascimento,
            'descricao' => $perfil->descricao,
        ]);
    }

    public function alteraImagem(Request $request, String $nomeUtilizador) {
        $perfil = Utilizador::procuraNomeUtilizador($nomeUtilizador);
        if (is_null($perfil)) {
            $this->viewNaoEncontrada();
        }
        $this->authorize('editar', $perfil);

        $validator = Validator::make($request->all(), [
            'imagem_perfil' => 'nullable|mimes:jpeg,jpg,png|max:1000'
        ]);
        $validator->validate();
        if ($request->hasFile('imagem_perfil')) {
            $picName = $perfil->id.'.jpg';
            $this->apagaImagem($request, $nomeUtilizador);
            $uploadedPic = $request->file('imagem_perfil');
            Image::make($uploadedPic->path())->resize(320, 320)->encode('jpg', 60)->save(public_path('storage').'/avatar-'.$picName);
            
            $perfil->update(['imagem_perfil' => 'storage/avatar-'.$picName]);
            $perfil->save();
            return redirect()->route('editar-perfil', $nomeUtilizador);
        }

        return redirect()->back()->withErrors('imagem_perfil', 'Submissão sem imagem selecionada!');
    }

    public function apagaImagem(Request $request, String $nomeUtilizador) {
        $perfil = Utilizador::procuraNomeUtilizador($nomeUtilizador);
        if (is_null($perfil)) {
            $this->viewNaoEncontrada();
        }
        $this->authorize('editar', $perfil);

        if (!is_null($perfil->imagem_perfil)) {
            Storage::disk('public')->delete('avatar-'.$perfil->id.'.jpg');
        }

        $perfil->update(['imagem_perfil' => null]);
        $perfil->save();
    }

    public function alteraDados(Request $request, String $nomeUtilizador) {
        $perfil = Utilizador::procuraNomeUtilizador($nomeUtilizador);
        if (is_null($perfil)) {
            $this->viewNaoEncontrada();
        }
        $this->authorize('editar', $perfil);

        $validator = Validator::make($request->all(), [
            'nome' => "required|string|max:512",
            'data_nascimento' => 'required|date|before_or_equal:'.Carbon::parse(Carbon::now())->format('Y-m-d'),
            'e_mail' => 'required|string|email|max:512|unique:utilizador,e_mail,'.$perfil->id,
            'descricao' => 'nullable|string|max: 1500',
            'palavra_passe' => 'nullable|string|min:8|confirmed',
        ]);
        $validator->validate();

        $validated = $validator->safe()->only(['nome', 'data_nascimento', 'e_mail', 'palavra_passe', 'descricao']);
        $validated['palavra_passe'] = is_null($validated['palavra_passe']) ? $perfil->palavra_passe : Hash::make($validated['palavra_passe']);

        $perfil->update($validated);
        $perfil->save();

        return redirect()->route('perfil', $nomeUtilizador);
    }

    public function apagaPerfil(Request $request, String $nomeUtilizador) {
        $perfil = Utilizador::procuraNomeUtilizador($nomeUtilizador);
        if (is_null($perfil)) {
            $this->viewNaoEncontrada();
        }
        $this->authorize('editar', $perfil);
        $perfil->delete();
        return response()->json([
            'sucesso' => true,
            'localizacao' => route('home')
        ]);
    }
}