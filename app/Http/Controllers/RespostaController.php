<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Notifications\RespostaQuestaoNotification;
use App\Models\Resposta;
use App\Models\Questao;
use App\Notifications\VotoRespostaNotification;

class RespostaController extends Controller
{

    private function encontraNotificacao($resposta, $autorVoto) {
        return $resposta
            ->criador
            ->unreadnotifications()
            ->where('type', 'App\Notifications\VotoRespostaNotification')
            ->get()
            ->first(function($notificacao) use($resposta, $autorVoto) {
                return (
                    ($notificacao->data['idResposta'] == $resposta->id) && 
                    ($notificacao->data['idAutorVoto'] == $autorVoto->id)
                );
            });
    }

    private function removeNotificacaoVoto($resposta, $autorVoto) {
        if(!is_null($resposta->autor)){
        $notificacaoVoto = $this->encontraNotificacao($resposta, $autorVoto);
        if (!is_null($notificacaoVoto)) {
            $notificacaoVoto->delete();
        }
    }
    }

    private function notificaVoto($resposta, $autorVoto) {
        if (!is_null($resposta->autor)) {
            $notificacaoVoto = $this->encontraNotificacao($resposta,$autorVoto);
            if (is_null($notificacaoVoto)) {
                $resposta->criador->notify(new VotoRespostaNotification($resposta, Auth::user()));
            } else {
                $notificacaoVoto->touch();
            }
        }
    }

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
        $this->authorize('eliminar', $resposta);
        if(!$questao->respostas->contains($resposta))
            return abort(404);
        if($resposta->comentarios!=null)
        {
            foreach($resposta->comentarios as $comentario)
                $comentario->delete();
        }
        $resposta->delete();
        return redirect()->route('questao',[$questao]);
    }
     /**
     * Cria uma resposta
     * @return Resposta A novaresposta 
     */
    public function create(Request $request, $idQuestao)
    {
        if(!Auth::check()) return redirect('/login');
        $this->authorize('notBanned',Resposta::class);
        $validator = Validator::make($request->all(),
            [
                'texto' => 'required',
            ]);
        if($validator->fails())
        {
            return redirect()->route('questao',[$idQuestao])->withErrors($validator);
        }

        $resposta = new Resposta([
            'autor' => Auth::id(),
            'texto' => $request->get('texto'),
            'id_questao' => $idQuestao,
            'resposta_aceite' => false,
        ]);
        $resposta->save();
        Questao::find($idQuestao)->criador->notify(new RespostaQuestaoNotification($resposta));
        return redirect()->route('questao',[$idQuestao]);
    }
    public function votar(Request $request, $idResposta) {
        $resposta = Resposta::findOrFail($idResposta);
        if (is_null($resposta)) {
            return response(view('errors.404'), 404)
                ->header('Content-type', 'text/html');
        }
        if (!Auth::check()) {
            return response(view('errors.403'), 403)
                ->header('Content-type', 'text/html');
        }
        $this->authorize('notOwner',$resposta);
        $utilizador = Auth::user()->ativo;
        $voto = $utilizador->respostasAvaliadas()->where('id_resposta', $resposta->id)->exists();
        if ($voto) {
            $this->removeNotificacaoVoto($resposta, Auth::user());
            DB::table('resposta_avaliada')
                ->where('id_utilizador', $utilizador->id)
                ->where('id_resposta', $resposta->id)
                ->delete();
        } else {
            $this->notificaVoto($resposta, Auth::user());
            DB::table('resposta_avaliada')->insert([
                'id_utilizador' => $utilizador->id,
                'id_resposta' => $idResposta
            ]);
        }
        $voto = !$voto;
        return response()->json([
            'novoEstado' => $voto ? 'VOTO' : 'NAO_VOTO',
            'numVotos' => $resposta->numero_votos
        ]);
    }

    public function respostaCorreta(Request $request, $idQuestao, $idResposta)
    {
        if(!Auth::check()) return redirect('/login');
        $questao = Questao::findOrFail($idQuestao);
        $resposta = Resposta::findOrFail($idResposta);
        $this->authorize('editar',$questao);
        if($questao->temRespostaCorreta())
            return redirect()->route('questao',[$questao]);
        $resposta->update([
            'resposta_aceite' => true]);
            
        return redirect()->route('questao',[$questao]);
    }

    public function retirarRespostaCorreta(Request $request, $idQuestao, $idResposta)
    {
        if(!Auth::check()) return redirect('/login');
        $questao = Questao::findOrFail($idQuestao);
        $resposta = Resposta::findOrFail($idResposta);
        $this->authorize('editar',$questao);
        $resposta->update([
            'resposta_aceite' => false]);
            
        return redirect()->route('questao',[$questao]);
    }

}