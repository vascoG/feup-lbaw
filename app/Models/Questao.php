<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Questao extends Model {

    public $timestamps = false;

    public $table = 'questao';

    protected $fillable = ['texto', 'autor', 'titulo'];

    public function criador() {
        return $this->belongsTo('App\Models\UtilizadorAtivo', 'autor', 'id');
    }

    public function respostas() {
        return $this->hasMany('App\Models\Resposta', 'id_questao', 'id');
    }

    public function comentarios() {
        return $this->hasMany('App\Models\Comentario', 'id_questao', 'id');
    }

    public function notificacoes() {
        return $this->hasMany('App\Models\Notificacao', 'id_questao', 'id');
    }

    public function historicos() {
        return $this->hasMany('App\Models\HistoricoInteracao', 'id_questao', 'id');
    }

    public function seguidores() {
        return $this->belongsToMany('App\Models\UtilizadorAtivo', 'questao_seguida', 'id_questao', 'id_utilizador');
    }

    public function avaliacoes() {
        return $this->belongsToMany('App\Models\UtilizadorAtivo', 'questao_avaliada', 'id_questao', 'id_utilizador');
    }

    public function etiquetas() {
        return $this->belongsToMany('App\Models\Etiqueta', 'questao_etiqueta', 'id_questao', 'id_etiqueta');
    }
}