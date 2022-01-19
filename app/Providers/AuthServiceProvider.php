<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
      'App\Models\Utilizador' => 'App\Policies\UtilizadorPolicy',
      'App\Models\Etiqueta' => 'App\Policies\EtiquetaPolicy',
      'App\Models\Questao' => 'App\Policies\QuestaoPolicy',
      'App\Models\Etiqueta' => 'App\Policies\EtiquetaPolicy',
      'App\Models\Comentario' => 'App\Policies\ComentarioPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
