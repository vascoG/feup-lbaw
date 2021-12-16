<?php

namespace App\Http\Controllers;

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
        if(!Auth::check()) return redirect('/login');
        $this->authorize('notBanned',Questao::class);
        return view('pages.criarquestao');
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
        //data publicacao no sql dá por default ou temos de calcular aqui?
        //como usar a etiqueta visto que é muitos para muitos
        $questao->save();
        return redirect()->route('questao',[$questao]);
    }




}
