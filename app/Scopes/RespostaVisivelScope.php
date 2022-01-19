<?php

namespace App\Scopes;

use App\Scopes\VisivelScope;

class RespostaVisivelScope extends VisivelScope
{
    protected function tabela() {
        return 'resposta';
    }
}
