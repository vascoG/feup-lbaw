<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Resposta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\Questao;

class ComentarioController extends Controller
{
    /**
     * Mostra o formulário para editar um comentario
     * @return Response
     */
    public function showEditForm($idQuestao, $idComentario)
    {
        if(!Auth::check()) return redirect('/login');
        $questao = Questao::findOrFail($idQuestao);
        $comentario = Comentario::findOrFail($idComentario);
        $this->authorize('editar',$comentario);
        $resposta = $comentario->resposta;
        if($resposta!=null){
            if(!$questao->respostas->contains($resposta))
                return abort(404);
        }
        else if(!$questao->comentarios->contains($comentario))
            return abort(404);
        return view('pages.editarcomentario',['questao'=> $questao, 'comentario'=>$comentario]);
    }
    /**
     * Edita um comentario
     * @return Comentario O comentario editado
     */
    public function edit(Request $request, $idQuestao, $idComentario)
    {
        if(!Auth::check()) return redirect('/login');
        $questao = Questao::findOrFail($idQuestao);
        $comentario = Comentario::findOrFail($idComentario);
        $this->authorize('editar',$comentario);
        $resposta = $comentario->resposta;
        if($resposta!=null){
            if(!$questao->respostas->contains($resposta))
                return abort(404);
        }
        else if(!$questao->comentarios->contains($comentario))
            return abort(404);
        $validator = Validator::make($request->all(),
            [
                'texto' => 'required',
            ]);

        if($validator->fails())
        {
            return redirect()->route('editar-resposta',[$idQuestao, $idComentario])->withErrors($validator);
        }


        Comentario::where('id',$idComentario)->update([
            'texto' => $request->get('texto')]);
            
        return redirect()->route('questao',[$questao]);
    }

     /**
     * Apaga um comentario
     * @return Response
     */
    public function delete($idQuestao, $idComentario)
    {
        if(!Auth::check()) return redirect('/login');
        $questao = Questao::findOrFail($idQuestao);
        $comentario = Comentario::findOrFail($idComentario);
        $this->authorize('editar',$comentario);
        $resposta = $comentario->resposta;
        if($resposta!=null){
            if(!$questao->respostas->contains($resposta))
                return abort(404);
        }
        else if(!$questao->comentarios->contains($comentario))
            return abort(404);
        $comentario->delete();
        return redirect()->route('questao',[$questao]);
    }
    /**
     * Cria um comentario a uma questão
     * @return Comentario O novo comentário
     */
    public function createOnQuestion(Request $request, $idQuestao)
    {
        if(!Auth::check()) return redirect('/login');
        $this->authorize('notBanned',Comentario::class);
        $validator = Validator::make($request->all(),
            [
                'texto' => 'required',
            ]);
        if($validator->fails())
        {
            return redirect()->route('questao',[$idQuestao])->withErrors($validator);
        }

        $comentario = new Comentario([
            'autor' => Auth::id(),
            'texto' => $request->get('texto'),
            'id_questao' => $idQuestao,
        ]);
        $comentario->save();
        return redirect()->route('questao',[$idQuestao]);
    }
     /**
     * Cria um comentario a uma resposta
     * @return Comentario O novo comentário
     */
    public function createOnResponse(Request $request, $idQuestao, $idResposta)
    {
        if(!Auth::check()) return redirect('/login');
        $this->authorize('notBanned',Comentario::class);
        $validator = Validator::make($request->all(),
            [
                'texto' => 'required',
            ]);
        if($validator->fails())
        {
            return redirect()->route('questao',[$idQuestao])->withErrors($validator);
        }

        $comentario = new Comentario([
            'autor' => Auth::id(),
            'texto' => $request->get('texto'),
            'id_resposta' => $idResposta,
        ]);
        $comentario->save();
        return redirect()->route('questao',[$idQuestao]);
    }
}