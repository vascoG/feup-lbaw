<?php

namespace App\Models;

use App\Models\Etiqueta;
use App\Models\Questao;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\DatabaseNotification;
use DB;

class UtilizadorAtivo extends Model {
    use Notifiable;

    public $timestamps = false;

    public $table = 'utilizador_ativo';

    protected $fillable = ['id_utilizador'];
    
    protected static function booted() {
        static::deleted(function ($utilizador) {
            foreach($utilizador->notifications as $notificacao) {
                $notificacao->delete();
            }
        });
    }

    public function utilizador() {
        return $this->belongsTo('App\Models\Utilizador', 'id_utilizador', 'id');
    }

    public function questoes() {
        return $this->hasMany('App\Models\Questao', 'autor', 'id');
    }

    public function respostas() {
        return $this->hasMany('App\Models\Resposta', 'autor', 'id');
    }

    public function comentarios() {
        return $this->hasMany('App\Models\Comentario', 'autor', 'id');
    }

    public function medalhas() {
        return $this->belongsToMany('App\Models\Notificacao', 'utilizador_ativo_medalha', 'id_utilizador', 'id_medalha');
    }

    public function seguidas() {
        return $this->belongsToMany('App\Models\Questao', 'questao_seguida', 'id_utilizador', 'id_questao');
    }

    public function questoesAvaliadas() {
        return $this->belongsToMany('App\Models\Questao', 'questao_avaliada', 'id_utilizador', 'id_questao');
    }

    public function respostasAvaliadas() {
        return $this->belongsToMany('App\Models\Resposta', 'resposta_avaliada', 'id_utilizador', 'id_resposta');
    }

    public function etiquetasSeguidas() {
        return $this->belongsToMany('App\Models\Etiqueta', 'utilizador_ativo_etiqueta', 'id_utilizador', 'id_etiqueta');
    }

    public function segueEtiqueta(Etiqueta $etiqueta) {
        return $query = DB::table('utilizador_ativo_etiqueta')
            ->where('id_utilizador', $this->id)
            ->where('id_etiqueta', $etiqueta->id)
            ->exists();
    }

    public function unreadNotifications() {
        $idQuestoes = Questao::all()->map(function($questao) {
            return $questao->id;
        })->toArray();
        $notificacoesInvalidas = DatabaseNotification::query()
            ->select('notifications.id as id')
            ->where('type', 'App\Notifications\VotoRespostaNotification')
            ->whereNotIn('data->idQuestao', $idQuestoes)
            ->get()
            ->map(function($notificacao) {
                return $notificacao->id;
            })->toArray();
        return $this->notifications()
            ->whereNull('read_at')
            ->whereNotIn('id', $notificacoesInvalidas);
    }
}
