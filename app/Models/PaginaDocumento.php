<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaginaDocumento extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'pagina_documento';

    protected $fillable = [
        'id_pagina',
        'titulo',
        'subtitulo',
        'arquivo',
        'dt_publicacao',
        'nu_ordem',
        'fl_ativo',
    ];

    protected $dates = ['dt_publicacao', 'deleted_at'];

    public function pagina()
    {
        return $this->belongsTo(Pagina::class, 'id_pagina');
    }

    public function scopeAtivos($query)
    {
        return $query->where('fl_ativo', 1);
    }

    public function scopeOrdenados($query)
    {
        return $query->orderByRaw('dt_publicacao IS NULL')
            ->orderBy('dt_publicacao', 'desc')
            ->orderBy('nu_ordem')
            ->orderBy('id');
    }

    public function isExterno()
    {
        return (bool) preg_match('#^https?://#i', (string) $this->arquivo);
    }

    public function urlPublica()
    {
        if (empty($this->arquivo)) {
            return null;
        }

        if ($this->isExterno()) {
            return $this->arquivo;
        }

        $caminho = implode('/', array_map('rawurlencode', explode('/', ltrim($this->arquivo, '/'))));

        return asset($caminho);
    }

    public function caminhoLocal()
    {
        if (empty($this->arquivo) || $this->isExterno()) {
            return null;
        }

        return public_path(ltrim($this->arquivo, '/'));
    }

    /**
     * Só arquivos enviados pelo painel (pasta documentos/) podem ser apagados do disco;
     * os históricos em acordos/ e outras pastas são preservados.
     */
    public function arquivoRemovivel()
    {
        return !$this->isExterno()
            && strpos(ltrim($this->arquivo, '/'), 'documentos/') === 0
            && file_exists($this->caminhoLocal());
    }

    public function extensao()
    {
        $caminho = parse_url((string) $this->arquivo, PHP_URL_PATH) ?: (string) $this->arquivo;

        return strtolower(pathinfo($caminho, PATHINFO_EXTENSION));
    }
}
