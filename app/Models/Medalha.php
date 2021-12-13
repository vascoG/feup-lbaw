<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medalha extends Model {
    public $timestamp = false;

    public $table = 'utilizador_banido';

    protected $fillable = ['nome', 'imagem'];

    public function medalhados() {
        return $this->belongsToMany('App\Models\UtilizadorAtivo', 'utilizador_ativo_medalha', 'id_medalha', 'id_utilizador');
    }
}