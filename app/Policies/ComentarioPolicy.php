<?php

namespace App\Policies;

use App\Models\Comentario;
use App\Models\UtilizadorAtivo;
use App\Models\Utilizador;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class ComentarioPolicy{
    
    use HandlesAuthorization;


    public function editar(Utilizador $user, Comentario $comentario)
    {   
        return $user->id == $comentario->autor || $user->administrador || $user->moderador;
    }

}