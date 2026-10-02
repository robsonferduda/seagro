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

    public const PROPORCAO_CAPA = 4 / 3;

    /**
     * Desvio máximo da proporção 4:3 para a capa preencher o quadro do carrossel (corte pequeno nas bordas).
     * Acima disso ela é exibida inteira, com a própria imagem desfocada ao fundo.
     */
    public const TOLERANCIA_CAPA = 0.15;

    public function ajusteCapa()
    {
        $caminho = $this->caminhoCapa();
        $info = $caminho && file_exists($caminho) ? @getimagesize($caminho) : null;

        if (!$info || !$info[1]) {
            return 'cover';
        }

        $desvio = abs(($info[0] / $info[1]) / self::PROPORCAO_CAPA - 1);

        return $desvio <= self::TOLERANCIA_CAPA ? 'cover' : 'contain';
    }

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