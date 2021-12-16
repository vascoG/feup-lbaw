<?php

namespace App\Policies;

use App\Models\Questao;
use App\Models\UtilizadorAtivo;
use App\Models\UtilizadorBanido;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class QuestaoPolicy{
    
    use HandlesAuthorization;

    public function notBanned(UtilizadorAtivo $utilizadorAtivo)
    {   
        $user_banned = UtilizadorBanido::find($utilizadorAtivo->id_utilizador);
        return ($user_banned==null);
    }


}