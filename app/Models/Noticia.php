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

    public function caminhoCapa()
    {
        if (empty($this->img_capa)) {
            return null;
        }

        return public_path('img/noticias/' . $this->img_capa);
    }

    public function urlCapa()
    {
        if (empty($this->img_capa)) {
            return null;
        }

        $url = asset('img/noticias/' . $this->img_capa);
        $path = $this->caminhoCapa();

        if ($path && file_exists($path)) {
            $url .= '?v=' . filemtime($path);
        }

        return $url;
    }
}