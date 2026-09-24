<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evento extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'evento';

    protected $fillable = [
        'id',
        'id_tipo',
        'data',
        'titulo',
        'descricao',
        'tp_destino',
        'url_destino',
        'fl_nova_aba',
        'apelido',
        'fl_ativo',
        'imagem',
    ];

    public function tipo()
    {
        return $this->belongsTo(TipoEvento::class, 'id_tipo');
    }

    public function isRedirect()
    {
        return $this->tp_destino === 'redirect' && !empty($this->url_destino);
    }

    public function linkPublico()
    {
        if ($this->isRedirect()) {
            return $this->url_destino;
        }

        return url('eventos/detalhes', $this->apelido);
    }

    public function abreNovaAba()
    {
        return $this->isRedirect() && (int) $this->fl_nova_aba === 1;
    }

    public function caminhoImagem()
    {
        if (empty($this->imagem)) {
            return null;
        }

        return public_path('img/eventos/' . $this->imagem);
    }

    public function urlImagem()
    {
        if (empty($this->imagem)) {
            return null;
        }

        $url = asset('img/eventos/' . $this->imagem);
        $path = $this->caminhoImagem();

        if ($path && file_exists($path)) {
            $url .= '?v=' . filemtime($path);
        }

        return $url;
    }
}
