<?php

namespace App\Policies;

use App\Models\UtilizadorAtivo;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class PerfilPolicy {

    use HandlesAuthorization;

    public function dono(UtilizadorAtivo $idUtilizador, UtilizadorAtivo $idPerfil) {
        return ($idUtilizador == $idPerfil);
    }
}