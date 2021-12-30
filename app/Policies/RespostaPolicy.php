<?php

namespace App\Policies;

use App\Models\Resposta;
use App\Models\UtilizadorAtivo;
use App\Models\UtilizadorBanido;
use App\Models\Utilizador;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class QuestaoPolicy{
    
    use HandlesAuthorization;


    public function editar(UtilizadorAtivo $utilizadorAtivo, Resposta $resposta)
    {   
        $user = Utilizador::find($utilizadorAtivo->id_utilizador);
        return $utilizadorAtivo->id_utilizador == $resposta->autor || $user->administrador || $user->moderador;
    }

}