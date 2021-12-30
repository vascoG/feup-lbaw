<?php

namespace App\Policies;

use App\Models\Questao;
use App\Models\UtilizadorAtivo;
use App\Models\UtilizadorBanido;
use App\Models\Utilizador;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class QuestaoPolicy{
    
    use HandlesAuthorization;

    public function notBanned(UtilizadorAtivo $utilizadorAtivo)
    {   
        $user_banned = UtilizadorBanido::find($utilizadorAtivo->id_utilizador);
        return ($user_banned==null);
    }

    public function editar(UtilizadorAtivo $utilizadorAtivo, Questao $questao)
    {   
        $user = Utilizador::find($utilizadorAtivo->id_utilizador);
        return $utilizadorAtivo->id_utilizador == $questao->autor || $user->administrador || $user->moderador;
    }

}