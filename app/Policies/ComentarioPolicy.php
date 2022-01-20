<?php

namespace App\Policies;

use App\Models\Comentario;
use App\Models\UtilizadorBanido;
use App\Models\Utilizador;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class ComentarioPolicy{
    
    use HandlesAuthorization;

    public function valido(?Utilizador $user) {
        if (is_null($user)) {
            return false;
        }
        $user_banned =$user->banido;
        if(!is_null($user_banned)) {
            return false;
        }
        return true;
    }

    public function editar(?Utilizador $user, Comentario $comentario) {
        return $this->valido($user) && ($user->id == $comentario->autor);
    }

    public function eliminar(?Utilizador $user, Comentario $comentario) {
        return $this->valido($user) && ($this->editar($user, $comentario) || $user->moderador || $user->administrador);
    }

    public function verEliminar(?Utilizador $user, Comentario $comentario) {
        return $this->eliminar($user, $comentario) && !$this->editar($user, $comentario);
    }

    public function notBanned(?Utilizador $user) {   
        if ($user==null)
            return true;
            $user_banned =$user->banido;
        return ($user_banned==null);
    }

}