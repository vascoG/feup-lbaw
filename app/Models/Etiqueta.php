<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etiqueta extends Model {
    public $timestamp = false;

    public $table = 'etiqueta';

    protected $fillable = ['nome'];

    public function questoes() {
        return $this->belongsToMany('App\Models\Questao', 'questao_etiqueta', 'id_etiqueta', 'id_questao');
    }

    public function seguidores() {
        return $this->belongsToMany('App\Models\UtilizadorAtivo', 'utilizador_ativo_etiqueta', 'id_etiqueta', 'id_utilizador');
    }
}