<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacao extends Model {
    public $timestamp = false;

    public $table = 'notificacao';

    protected $fillable = ['texto', 'autor', 'id_questao', 'id_comentario', 'id_resposta'];

    function questao() {
        return $this->hasOne('App\Model\Questao', 'id_questao', 'id');
    }

    function resposta() {
        return $this->hasOne('App\Model\Resposta', 'id_resposta', 'id');
    }

    function comentario() {
        return $this->hasOne('App\Model\Comentario', 'id_comentario', 'id');
    }
}