<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UtilizadorBanido extends Model {
    public $timestamp = false;

    public $table = 'utilizador_banido';

    protected $fillable = ['id_utilizador'];

    function utilizador() {
        return $this->belongsTo('App\Models\Utilizador', 'id_utilizador', 'id');
    }

    function apelos() {
        return $this->hasMany('App\Models\ApeloDesbloqueio', 'id_utilizador', 'id');
    }
}