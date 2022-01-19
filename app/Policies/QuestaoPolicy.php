<?php

namespace App\Policies;

use App\Models\Questao;
use App\Models\UtilizadorAtivo;
use App\Models\UtilizadorBanido;
use App\Models\Utilizador;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class QuestaoPolicy{
    
    use HandlesAuthorization;

    public function notBanned(?Utilizador $user) {   
        if ($user==null)
            return true;
        $user_banned = UtilizadorBanido::find($user->id);
        return ($user_banned == null);
    }

    public function valid(?Utilizador $user) {
        if (is_null($user)) {
            return false;
        }
        $user_banned = UtilizadorBanido::find($user->id);
        if($user_banned != null)
            return false;
        return true;
    }

    public function editar(?Utilizador $user, Questao $questao) {  
        return $this->valid($user) && ($user->ativo->id == $questao->autor || $user->administrador || $user->moderador);
    }

    public function interagir(?Utilizador $user, Questao $questao) {
        return $this->valid($user) && ($user->ativo->id != $questao->autor);
    }

    public function editarConteudo(?Utilizador $user, Questao $questao) {
        return $this->valid($user) && ($user->ativo->id != $questao->autor);
    }

    public function notOwner(Utilizador $user, Questao $questao) {
        return $user->id != $questao->autor;
    }

}