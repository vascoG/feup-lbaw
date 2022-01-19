<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\DatabaseNotification;
use App\Models\UtilizadorAtivo;
use App\Scopes\RespostaVisivelScope;
use DB;

class Resposta extends Model {
    public $timestamps = false;

    public $table = 'resposta';

    protected $fillable = ['texto', 'autor', 'id_questao', 'resposta_aceite'];

    protected static function booted() {
        static::addGlobalScope(new RespostaVisivelScope);
        static::deleted(function ($resposta) {
            foreach($resposta->notificacoes as $notificacao) {
                $notificacao->delete();
            }
        });
    }

    public function criador() {
        return $this->belongsTo('App\Models\UtilizadorAtivo', 'autor', 'id');
    }

    public function questao() {
        return $this->belongsTo('App\Models\Questao', 'id_questao', 'id');
    }

    public function comentarios() {
        return $this->hasMany('App\Models\Comentario', 'id_resposta', 'id');
    }

    public function getNumeroVotosAttribute() {
        return DB::table('gosto_respostas')
            ->where('id_resposta', $this->id)
            ->get()
            ->first()
            ->n_gosto;
    }

    public function historicos() {
        return $this->hasMany('App\Models\HistoricoInteracao', 'id_resposta', 'id');
    }

    public function getNotificacoesAttribute() {
        return DatabaseNotification::query()
            ->where('type', 'App\Notifications\VotoRespostaNotification')
            ->where('data->idResposta', $this->id)
            ->get();
    }
}