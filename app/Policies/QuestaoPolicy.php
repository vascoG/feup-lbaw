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

    public function notBanned(Utilizador $user)
    {   
        $user_banned = UtilizadorBanido::find($user->id);
        return ($user_banned==null);
    }

    public function editar(Utilizador $user, Resposta $resposta)
    {   
        return $user->id == $resposta->autor || $user->administrador || $user->moderador;
    }

}