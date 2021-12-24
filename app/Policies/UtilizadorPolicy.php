<?php

namespace App\Policies;

use App\Models\Utilizador;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UtilizadorPolicy {

    use HandlesAuthorization;

    public function editar(Utilizador $utilizador, Utilizador $perfil) {
        if (!is_null($utilizador->banido)) {
            return false;
        }
        return ($utilizador->id === $perfil->id);
    }
}