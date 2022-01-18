<?php

namespace App\Policies;

use App\Models\Resposta;
use App\Models\Utilizador;
use App\Models\UtilizadorBanido;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class RespostaPolicy{
    
    use HandlesAuthorization;

    public function valido(?Utilizador $user) {
        if (is_null($user)) {
            return false;
        }
        $user_banned = UtilizadorBanido::find($user->id);
        if(!is_null($user_banned)) {
            return false;
        }
        return true;
    }

    public function editar(?Utilizador $user, Resposta $resposta) {   
        return $this->valido($user) && ($user->ativo->id == $resposta->autor);
    }

    public function eliminar(?Utilizador $user, Resposta $resposta) {
        return $this->valido($user) && !$this->editar($user, $resposta) && ($user->moderador || $user->administrador);
    }

    public function notBanned(?Utilizador $user)
    {   
        if ($user==null)
            return true;
        $user_banned = UtilizadorBanido::find($user->id);
        return ($user_banned==null);
    }

    public function notOwner(?Utilizador $user, Resposta $resposta)
    {
        return $user->id != $resposta->autor;
    }
}