<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacao extends Model {
    public $timestamp = false;

    public $table = 'notificacao';

    protected $fillable = ['texto', 'autor', 'id_questao', 'id_comentario', 'id_resposta'];

    function questao() {
        return $this->belongsTo('App\Model\Questao', 'id_questao', 'id');
    }

    function resposta() {
        return $this->belongsTo('App\Model\Resposta', 'id_resposta', 'id');
    }

    function comentario() {
        return $this->belongsTo('App\Model\Comentario', 'id_comentario', 'id');
    }

    public function utilizadoresAfetados() {
        return $this->belongsToMany('App\Models\UtilizadorAtivo', 'utilizador_ativo_notificacao', 'id_notificacao', 'id_utilizador')->withPivot('data_lida');
    }
}