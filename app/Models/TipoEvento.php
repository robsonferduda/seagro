<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoEvento extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'tipo_evento';

    protected $fillable = ['id'];

}