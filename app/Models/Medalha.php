<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medalha extends Model {
    public $timestamp = false;

    public $table = 'utilizador_banido';

    protected $fillable = ['nome', 'imagem'];
}