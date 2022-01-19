<?php

namespace App\Scopes;

use App\Scopes\VisivelScope;

class QuestaoVisivelScope extends VisivelScope
{
    protected function tabela() {
        return 'questao';
    }
}
