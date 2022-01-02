<?php

namespace App\Policies;

use App\Models\Utilizador;
use App\Models\UtilizadorAtivo;
use App\Policies\AdminDashboardPolicy;

class EtiquetaPolicy extends AdminDashboardPolicy {
    public function seguir(Utilizador $utilizador) {
        
    }
}
