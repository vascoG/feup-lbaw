<?php

namespace App\Policies;

use App\Models\Resposta;
use App\Models\Utilizador;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class RespostaPolicy{
    
    use HandlesAuthorization;


    public function editar(Utilizador $user, Resposta $resposta)
    {   
        return $user->id == $resposta->autor || $user->administrador || $user->moderador;
    }

}