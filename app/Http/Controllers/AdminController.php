<?php

namespace App\Http\Controllers;
use App\Models\ApeloDesbloqueio;
use App\Models\UtilizadorAtivo;
use App\Models\Utilizador;
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
        $this->authorize('admin');
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
}
