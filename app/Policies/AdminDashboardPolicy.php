<?php

namespace App\Policies;

use App\Models\Utilizador;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class AdminDashboardPolicy {

    use HandlesAuthorization;

    public function admin(Utilizador $utilizador) {
        if (!is_null($utilizador->banido)) {
            return false;
        }
        return ($utilizador->administrador);
    }
}
