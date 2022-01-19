<?php

namespace App\Scopes;

use App\Scopes\VisivelScope;

class ComentarioVisivelScope extends VisivelScope
{
    protected function tabela() {
        return 'comentario';
    }
}
