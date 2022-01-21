<?php

namespace App\Http\Controllers;

use App\Models\Etiqueta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

use App\Models\Questao;
use App\Models\Utilizador;
use App\Models\Notificacao;
use App\Notifications\VotoQuestaoNotification;

class QuestaoController extends Controller
{
    private function encontraNotificacao($questao, $autorVoto) {
        return $questao
            ->criador
            ->unreadnotifications()
            ->where('type', 'App\Notifications\VotoQuestaoNotification')
            ->get()
            ->first(function($notificacao) use($questao, $autorVoto) {
                return (
                    ($notificacao->data['idQuestao'] == $questao->id) && 
                    ($notificacao->data['idAutorVoto'] == $autorVoto->id)
                );
            });
    }

    private function removeNotificacaoVoto($questao, $autorVoto) {
        if(!is_null($questao->autor)){
            $notificacaoVoto = $this->encontraNotificacao($questao, $autorVoto);
            if (!is_null($notificacaoVoto)) {
                $notificacaoVoto->delete();
            }
        }
    }

    private function notificaVoto($questao, $autorVoto) {
        if (!is_null($questao->autor)) {
            $notificacaoVoto = $this->encontraNotificacao($questao, $autorVoto);
            if (is_null($notificacaoVoto)) {
                $questao->criador->notify(new VotoQuestaoNotification($questao, Auth::user()));
            } else {
                $notificacaoVoto->touch();
            }
        }
    }

    /**
     * Mostra o formulário para criar uma questão
     * @return Response
     */
    public function showCreateForm()
    {
        if(!Auth::check()) return redirect('/login');
        $this->authorize('notBanned',Questao::class);
        return view('pages.criarquestao', [
            'etiquetas' => []
        ]);
    }

    /**
     * Cria uma questão
     * @return Questao A questao criada
     */
    public function create(Request $request)
    {
        if(!Auth::check()) return redirect('/login');
        $this->authorize('notBanned',Questao::class);
        $validator = Validator::make($request->all(),
            [
                'titulo' => 'required',
                'texto' => 'required',
            ]);
        if($validator->fails())
        {
            return redirect('/criarquestao')->withErrors($validator);
        }

        $questao = new Questao([
            'autor' => Auth::id(),
            'titulo' => $request->get('titulo'),
            'texto' => $request->get('texto'),
        ]);
        $questao->save();
        $etiquetas = $request->get('etiqueta');
        if(!is_null($etiquetas)) {
            $etiquetas = explode(',', $etiquetas);
            foreach($etiquetas as $tag) {
                $questao->etiquetas()->attach($tag);
            }
        }
        return redirect()->route('questao',[$questao]);
    }

    /**
     * Mostra o formulário para editar uma questão
     * @return Response
     */
    public function showEditForm($idQuestao)
    {
        if(!Auth::check()) return redirect('/login');
        $questao = Questao::findOrFail($idQuestao);
        $this->authorize('editar',$questao);
        $tags = Etiqueta::all();
        $etiquetasQuestao = $questao->etiquetas->map(function ($etiqueta) {
            return $etiqueta->id;
        })->toArray();
        return view('pages.editarquestao',[
            'questao'=> $questao,
            'etiquetas'=> is_null($questao->etiquetas) ? [] : $etiquetasQuestao
        ]);
    }
    /**
     * Edita uma questão
     * @return Questao A questao editada
     */
    public function edit(Request $request, $idQuestao)
    {
        if(!Auth::check()) return redirect('/login');
        $questao = Questao::findOrFail($idQuestao);
        $this->authorize('editar',$questao);

        $titulo = $request->get('titulo');
        if(is_null($titulo))
            $titulo = $questao->titulo;
        $texto = $request->get('texto');
        if(is_null($texto))
            $texto = $questao->texto;

        Questao::where('id',$idQuestao)->update([
            'titulo'=>$titulo,
            'texto' => $texto]);

        $questao->etiquetas()->detach();
        $etiquetas = $request->get('etiqueta');
        if(!is_null($etiquetas)) {
            $etiquetas = explode(',', $etiquetas);
            foreach($etiquetas as $tag) {
                $questao->etiquetas()->attach($tag);
            }
        }
        return redirect()->route('questao',[$questao]);
    }
    /**
     * Apaga uma questão
     * @return Response
     */
    public function delete($idQuestao)
    {
        if(!Auth::check()) return redirect('/login');
        $questao = Questao::findOrFail($idQuestao);
        $this->authorize('editar',$questao);
        $questao->delete();
        return redirect()->route('home');
    }

    /**
    * 
    */
    public function show(Request $request, $idQuestao){
        $this->authorize('notBanned',Questao::class);
        $questao = Questao::findOrFail($idQuestao);
        $criador = $questao->criador ? $questao->criador->utilizador : null;
        $respostas = $questao->respostas;
        $respostas = $respostas->sortBy('data_publicacao')->sortByDesc('resposta_aceite');
        return view('pages.questao',['questao'=>$questao,'criador'=>$criador,'respostas'=>$respostas]);
    }

    public function votar(Request $request, $idQuestao) {
        $questao = Questao::findOrFail($idQuestao);
        if (is_null($questao)) {
            return response(view('errors.404'), 404)
                ->header('Content-type', 'text/html');
        }
        if (!Auth::check()) {
            return response(view('errors.403'), 403)
                ->header('Content-type', 'text/html');
        }
        $this->authorize('notOwner',$questao);
        $utilizador = Auth::user()->ativo;
        $voto = $utilizador->questoesAvaliadas()->where('id_questao', $questao->id)->exists();
        if ($voto) {
            $this->removeNotificacaoVoto($questao, Auth::user());
            DB::table('questao_avaliada')
                ->where('id_utilizador', $utilizador->id)
                ->where('id_questao', $questao->id)
                ->delete();
        } else {
            $this->notificaVoto($questao, Auth::user());
            DB::table('questao_avaliada')->insert([
                'id_utilizador' => $utilizador->id,
                'id_questao' => $idQuestao
            ]);
        }
        $voto = !$voto;
        return response()->json([
            'novoEstado' => $voto ? 'VOTO' : 'NAO_VOTO',
            'numVotos' => $questao->numero_votos
        ]);
    }

}
