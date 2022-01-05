<?php

namespace App\Policies;

use App\Models\Resposta;
use App\Models\Utilizador;
use App\Models\UtilizadorBanido;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class RespostaPolicy{
    
    use HandlesAuthorization;


    public function editar(Utilizador $user, Resposta $resposta)
    {   
        $user_banned = UtilizadorBanido::find($user->id);
        if($user_banned!=null)
            return false;
        return $user->id == $resposta->autor || $user->administrador || $user->moderador;
    }
    public function notBanned(?Utilizador $user)
    {   
        if ($user==null)
            return true;
        $user_banned = UtilizadorBanido::find($user->id);
        return ($user_banned==null);
    }
}