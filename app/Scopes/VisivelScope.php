<?php

namespace App\Scopes;

use App\Models\UtilizadorAtivo;
use App\Models\UtilizadorBanido;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

abstract class VisivelScope implements Scope
{
    abstract protected function tabela();

    public function apply(Builder $builder, Model $model) {
        $ativosBanidos = UtilizadorAtivo::query()
            ->select('utilizador_ativo.id_utilizador AS id_utilizador')
            ->join('utilizador_banido', 'utilizador_banido.id_utilizador', '=', 'utilizador_ativo.id_utilizador');
        $builder->leftJoinSub($ativosBanidos, 'utilizadores_ativos_banidos', function($join) {
            $join->on('utilizadores_ativos_banidos.id_utilizador', '=', $this->tabela().'.autor');
        })->whereNull('utilizadores_ativos_banidos.id_utilizador');
    }
}
