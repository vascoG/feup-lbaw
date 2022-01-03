<?php

namespace App\Http\Controllers;

use App\Models\Etiqueta;
use App\Models\HistoricoInteracao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\Questao;
use App\Models\Utilizador;

class QuestaoController extends Controller
{
    /**
     * Mostra o formulário para criar uma questão
     * @return Response
     */
    public function showCreateForm()
    {
        if(!Auth::check()) return redirect('/login');
        $this->authorize('notBanned',Questao::class);
        $tags = Etiqueta::all();
        return view('pages.criarquestao', ['tags'=>$tags]);
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
        foreach($etiquetas as $tag)
            $questao->etiquetas()->attach($tag);
        return redirect()->route('questao',[$questao]);
    }

    /**
     * Mostra o formulário para editar uma questão
     * @return Response
     */
    public function showEditForm($idQuestao)
    {
        if(!Auth::check()) return redirect('/login');
        $questao = Questao::find($idQuestao);
        $this->authorize('editar',$questao);
        $tags = Etiqueta::all();

        return view('pages.editarquestao',['questao'=>$questao, 'tags'=>$tags]);
    }
    /**
     * Edita uma questão
     * @return Questao A questao editada
     */
    public function edit(Request $request, $idQuestao)
    {
        if(!Auth::check()) return redirect('/login');
        $questao = Questao::find($idQuestao);
        $this->authorize('editar',$questao);

        $validator = Validator::make($request->all(),
            [
                'titulo' => 'required',
                'texto' => 'required',
            ]);

        if($validator->fails())
        {
            return redirect()->route('editar-questao',[$idQuestao])->withErrors($validator);
        }


        Questao::where('id',$idQuestao)->update([
            'titulo'=>$request->get('titulo'),
            'texto' => $request->get('texto')]);

        $questao->etiquetas()->detach();
        $etiquetas = $request->get('etiqueta');
        foreach($etiquetas as $tag)
            $questao->etiquetas()->attach($tag);
        return redirect()->route('questao',[$questao]);
    }

    /**
    * 
    */
    public function show(Request $request, $idQuestao){
        $this->authorize('notBanned',Questao::class);
        $questao = Questao::findOrFail($idQuestao);
        $criador=Utilizador::find($questao->criador->id_utilizador);
        return view('pages.questao',['questao'=>$questao,'criador'=>$criador]);

    }
}
