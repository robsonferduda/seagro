<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Publicacao extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'publicacao';

    protected $fillable = [
        'titulo',
        'subtitulo',
        'arquivo',
        'link_externo',
        'nu_ordem',
        'fl_ativo',
    ];

    public function scopeAtivas($query)
    {
        return $query->where('fl_ativo', 1);
    }

    public function linkPublico()
    {
        if (!empty($this->link_externo)) {
            return $this->link_externo;
        }

        if (empty($this->arquivo)) {
            return null;
        }

        if (preg_match('#^https?://#i', $this->arquivo)) {
            return $this->arquivo;
        }

        return asset(ltrim($this->arquivo, '/'));
    }

    public function temArquivoLocal()
    {
        if (empty($this->arquivo) || preg_match('#^https?://#i', $this->arquivo)) {
            return false;
        }

        return file_exists(public_path(ltrim($this->arquivo, '/')));
    }
}
