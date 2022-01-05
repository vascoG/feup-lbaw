<?php

namespace App\Policies;

use App\Models\Utilizador;
use App\Policies\AdminDashboardPolicy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UtilizadorPolicy extends AdminDashboardPolicy {

    use HandlesAuthorization;

    public function admin(Utilizador $user){
        return $user->administrador;
    }

    public function editar(Utilizador $utilizador, Utilizador $perfil) {
        if (!is_null($utilizador->banido)) {
            return false;
        }
        return ($utilizador->id === $perfil->id);
    }
}
