<?php

namespace App\Scopes;

use App\Models\Questao;
use App\Models\UtilizadorAtivo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class RespostaVisivelScope implements Scope
{
    public function apply(Builder $builder, Model $model) {
        $questoesVisiveis = Questao::query()
            ->select('id AS id_questao');
        $ativosBanidos = UtilizadorAtivo::query()
            ->select('utilizador_ativo.id_utilizador AS id_utilizador')
            ->join('utilizador_banido', 'utilizador_banido.id_utilizador', '=', 'utilizador_ativo.id_utilizador');
        $builder->leftJoinSub($ativosBanidos, 'utilizadores_ativos_banidos', function($join) {
            $join->on('utilizadores_ativos_banidos.id_utilizador', '=', 'resposta.autor');
        })
        ->leftJoinSub($questoesVisiveis, 'questoes_visiveis', function($join) {
            $join->on('questoes_visiveis.id_questao', '=', 'resposta.id_questao');
        })
        ->whereNotNull('questoes_visiveis.id_questao')
        ->whereNull('utilizadores_ativos_banidos.id_utilizador');
    }
}
