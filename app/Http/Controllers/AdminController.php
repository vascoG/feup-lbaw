<?php

namespace App\Http\Controllers;
use App\Models\ApeloDesbloqueio;
use App\Models\UtilizadorAtivo;
use App\Models\Utilizador;
use App\Models\UtilizadorBanido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function showModerador()
    {
        if(!Auth::check()) return redirect('/login');
        $this->authorize('admin',Utilizador::class);
        $users = UtilizadorAtivo::paginate(40);
        return view('pages.admin.moderadores',['users'=>$users]);
    }
    public function alteraModerador(Request $request, $id_utilizador) 
    {
        $utilizador= Utilizador::find($id_utilizador);
        if (is_null($utilizador)) {
            return response('Utilizador nao encontrado', 404)
                ->header('Content-type', 'text/plain');
        }
        if(!Auth::check()) return redirect('/login');
        $this->authorize('admin', Utilizador::class);
        $moderador = $utilizador->moderador;
        
        if ($moderador) {
            $utilizador->moderador=false; $utilizador->save();
        } else {
            $utilizador->moderador=true; $utilizador->save();
        }
        return response()->json([
            'novoEstado' => $utilizador->moderador ?  'MODERADOR' : 'NAO_MODERADOR'
        ]);
    }
    public function showApelo()
    {
        if(!Auth::check()) return redirect('/login');
        $this->authorize('admin',Utilizador::class);
        $apelos=ApeloDesbloqueio::all();
        return view('pages.admin.apelos',['apelos'=>$apelos]);
    }
    public function bloqueia(Request $request, $id_utilizador)
    {
        $utilizador= Utilizador::find($id_utilizador);
        if (is_null($utilizador)) {
            return response('Utilizador nao encontrado', 404)
                ->header('Content-type', 'text/plain');
        }
        if(!Auth::check()) return redirect('/login');
        $this->authorize('admin',Utilizador::class);


        $questoes=$utilizador->ativo->questoes;
        if($questoes!=null)
        {
        foreach($questoes as $questao)
            $questao->delete();
        }

        $notificacoes=$utilizador->ativo->notificacoes;
        if($notificacoes!=null)
        {
        foreach($notificacoes as $notificacao)
            $notificacao->delete();
        }
        $respostas=$utilizador->ativo->respostas;
        if($respostas!=null)
        {
        foreach($respostas as $resposta)
            $resposta->delete();
        }
        $comentarios=$utilizador->ativo->comentarios;
        if($comentarios!=null)
        {
        foreach($comentarios as $comentario)
            $comentario->delete();
        }
        $questoesAvaliadas=$utilizador->ativo->questoesAvaliadas;
        if($questoesAvaliadas!=null)
        {
        foreach($questoesAvaliadas as $questaoAvaliada)
            $questaoAvaliada->delete();
        }
        $respostasAvaliadas=$utilizador->ativo->respostasAvaliadas;
        if($respostasAvaliadas!=null)
        {
        foreach($respostasAvaliadas as $respostaAvaliada)
            $respostaAvaliada->delete();
        }
        $utilizador->delete();
        return redirect()->route('admin-apelo');
    }
}


