<?php

namespace App\Http\Controllers;

use App\Models\Cidade;

class CidadeController extends Controller
{
    public function porUf($uf)
    {
        return response()
            ->json(Cidade::listaDaUf($uf))
            ->header('Cache-Control', 'public, max-age=86400');
    }
}
