<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\ComentarioVisivelScope;

class Comentario extends Model {
    public $timestamps = false;

    public $table = 'comentario';

    protected $fillable = ['texto', 'autor', 'id_questao', 'id_resposta'];

    protected static function booted() {
        static::addGlobalScope(new ComentarioVisivelScope);
    }

    public function criador() {
        return $this->belongsTo('App\Models\UtilizadorAtivo', 'autor', 'id');
    }

    public function questao() {
        return $this->belongsTo('App\Models\Questao', 'id_questao', 'id');
    }

    public function resposta() {
        return $this->belongsTo('App\Models\Resposta', 'id_resposta', 'id');
    }

    public function notificacoes() {
        return $this->hasMany('App\Models\Notificacao', 'id_comentario', 'id');
    }

    public function historicos() {
        return $this->hasMany('App\Models\HistoricoInteracao', 'id_comentario', 'id');
    }
}