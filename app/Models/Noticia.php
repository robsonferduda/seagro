<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Noticia extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'noticia';

    protected $fillable = [
        'titulo',
        'subtitulo',
        'dt_noticia',
        'corpo',
        'img_capa',
        'fl_ativa',
        'fl_banner',
        'url',
    ];

    protected $dates = ['dt_noticia', 'deleted_at'];
}