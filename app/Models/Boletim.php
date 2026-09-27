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

    /**
     * Boletins antigos não têm o campo imagem preenchido; a imagem está só no HTML de texto.
     */
    public function urlImagem()
    {
        if ($this->imagem) {
            return asset('boletim/' . $this->imagem);
        }

        if ($this->texto && preg_match('/<img[^>]+src="([^"]+)"/i', $this->texto, $m)) {
            return $m[1];
        }

        return null;
    }

}