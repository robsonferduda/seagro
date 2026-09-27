<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pagina extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'pagina';
    protected $fillable = ['id','nu_visualizacoes'];

    public function documentos()
    {
        return $this->hasMany(PaginaDocumento::class, 'id_pagina');
    }
}
