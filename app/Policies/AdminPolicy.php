<?php

namespace App\Policies;

use App\Models\Utilizador;
use App\Models\UtilizadorAtivo;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class AdminPolicy{

    use HandlesAuthorization;

    public function admin(Utilizador $user){
        return $user->administrador;
    }

}