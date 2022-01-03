<?php

namespace App\Policies;

use App\Models\Utilizador;
use App\Models\UtilizadorAtivo;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class AdminPolicy{

    use HandlesAuthorization;

    public function admin(UtilizadorAtivo $utilizadorAtivo){
        $user = Utilizador::find($utilizadorAtivo->id_utilizador);
        return $user->administrador;
    }

}