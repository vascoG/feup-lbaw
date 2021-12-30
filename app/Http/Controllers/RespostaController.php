<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\Resposta;
use App\Models\Questao;

class RespostaController extends Controller
{
    /**
     * Mostra o formulário para editar uma resposta
     * @return Response
     */
    public function showEditForm($idQuestao, $idResposta)
    {
        if(!Auth::check()) return redirect('/login');
        $questao = Questao::findOrFail($idQuestao);
        $resposta = Resposta::findOrFail($idResposta);
        $this->authorize('editar',$resposta);
        if(!$questao->respostas->contains($resposta))
            return abort(404);
        return view('pages.editarresposta',['questao'=> $questao, 'resposta'=>$resposta]);
    }
    /**
     * Edita uma resposta
     * @return Resposta A resposta editada
     */
    public function edit(Request $request, $idQuestao, $idResposta)
    {
        if(!Auth::check()) return redirect('/login');
        $questao = Questao::findOrFail($idQuestao);
        $resposta = Resposta::findOrFail($idResposta);
        $this->authorize('editar',$resposta);
        if(!$questao->respostas->contains($resposta))
        return abort(404);
        $validator = Validator::make($request->all(),
            [
                'texto' => 'required',
            ]);

        if($validator->fails())
        {
            return redirect()->route('editar-resposta',[$idQuestao, $idResposta])->withErrors($validator);
        }


        Resposta::where('id',$idResposta)->update([
            'texto' => $request->get('texto')]);
            
        return redirect()->route('questao',[$questao]);
    }

     /**
     * Apaga uma resposta
     * @return Response
     */
    public function delete($idQuestao, $idResposta)
    {
        if(!Auth::check()) return redirect('/login');
        $questao = Questao::findOrFail($idQuestao);
        $resposta = Resposta::findOrFail($idResposta);
        $this->authorize('editar',$resposta);
        if(!$questao->respostas->contains($resposta))
            return abort(404);
        $resposta->delete();
        return redirect()->route('/');
    }
}