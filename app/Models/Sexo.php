<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sexo extends Model
{
    protected $connection = 'mysql';
    protected $table = 'sexo';

    public $timestamps = false;

    protected $fillable = ['sigla', 'nome'];
}
