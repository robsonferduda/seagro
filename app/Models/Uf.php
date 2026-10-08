<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Uf extends Model
{
    protected $connection = 'mysql';
    protected $table = 'uf';

    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['id', 'sigla', 'nome'];

    public function cidades()
    {
        return $this->hasMany(Cidade::class, 'id_uf');
    }
}
