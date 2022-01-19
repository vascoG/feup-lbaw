<?php

namespace App\Scopes;

use App\Models\UtilizadorBanido;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class BanidoScope implements Scope
{
    public function apply(Builder $builder, Model $model) {
        $banidos = UtilizadorBanido::query()
            ->select('id_utilizador');
        $builder->leftJoinSub($banidos, 'utilizadores_banidos', function($join) {
            $join->on('utilizadores_banidos.id_utilizador', '=', 'utilizador.id');
        })->whereNull('utilizadores_banidos.id_utilizador');
    }
}