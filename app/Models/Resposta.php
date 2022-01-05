<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resposta extends Model {
    public $timestamps = false;

    public $table = 'resposta';

    protected $fillable = ['texto', 'autor', 'id_questao', 'resposta_aceite'];

    public function criador() {
        return $this->belongsTo('App\Models\UtilizadorAtivo', 'autor', 'id');
    }

    public function questao() {
        return $this->belongsTo('App\Models\Questao', 'id_questao', 'id');
    }

    public function comentarios() {
        return $this->hasMany('App\Models\Comentario', 'id_resposta', 'id');
    }

    public function notificacoes() {
        return $this->hasMany('App\Models\Notificacao', 'id_resposta', 'id');
    }

    public function historicos() {
        return $this->hasMany('App\Models\HistoricoInteracao', 'id_resposta', 'id');
    }
}