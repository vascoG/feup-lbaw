<?php

namespace App\Http\Controllers;

use App\Models\Etiqueta;
use App\Models\HistoricoInteracao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\Questao;

class QuestaoController extends Controller
{
    /**
     * Mostra o formulário para criar uma questão
     * @return Response
     */
    public function showCreateForm()
    {
        //if(!Auth::check()) return redirect('/login');
       // $this->authorize('notBanned',Questao::class);
        $tags = Etiqueta::all();
        return view('pages.criarquestao', ['tags'=>$tags]);
    }

    /**
     * Cria uma questão
     * @return Questao A questao criada
     */
    public function create(Request $request)
    {
        //if(!Auth::check()) return redirect('/login');
        //$this->authorize('notBanned',Questao::class);
        $validator = Validator::make($request->all(),
            [
                'titulo' => 'required|max:100',
                'texto' => 'required',
                'etiqueta' => 'required',
            ]);
        if($validator->fails())
        {
            return redirect('/criarquestao')->withErrors($validator);
        }

        $questao = new Questao([
            'autor' => Auth::user()->id,
            'titulo' => $request->get('titulo'),
            'texto' => $request->get('texto'),
        ]);
        $etiquetas = $request->get('etiqueta');
        foreach($etiquetas as $tag)
            $questao->etiquetas()->attach($tag->id);
        $questao->save();
        return redirect()->route('questao',[$questao->id]);
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
        return view('pages.editarQuestao',['questao'=>$questao]);
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
                'titulo' => 'required|max:100',
                'texto' => 'required',
                'etiqueta' => 'required',
            ]);
        if($validator->fails())
        {
            return redirect()->route('editar-questao',[$idQuestao])->withErrors($validator);
        }
        
        $questao->etiquetas()->attach(Etiqueta::where('nome',$request->get('etiqueta'))->first()->id);

        //caso nao edite nada, nao deve adicionar historico
        $historicoQuestao = new HistoricoInteracao([
            'texto' => $questao->texto,
            'id_questao' => $idQuestao,
        ]);
        $historicoQuestao->save();
        $questao->save();
        return redirect()->route('questao',[$idQuestao]);
    }

}
