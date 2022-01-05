<?php

namespace App\Policies;

use App\Models\Comentario;
use App\Models\UtilizadorBanido;
use App\Models\Utilizador;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class ComentarioPolicy{
    
    use HandlesAuthorization;


    public function editar(Utilizador $user, Comentario $comentario)
    {   
        $user_banned = UtilizadorBanido::find($user->id);
        if($user_banned!=null)
            return false;
        return $user->id == $comentario->autor || $user->administrador || $user->moderador;
    }
    public function notBanned(?Utilizador $user)
    {   
        if ($user==null)
            return true;
        $user_banned = UtilizadorBanido::find($user->id);
        return ($user_banned==null);
    }

}