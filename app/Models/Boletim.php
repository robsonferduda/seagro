<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Boletim extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'boletim';

    protected $fillable = ['id','titulo','subtitulo','texto','dt_publicacao','arquivo','imagem','audio','fl_publicacao','acessos','downloads'];

}