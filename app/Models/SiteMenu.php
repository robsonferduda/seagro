<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteMenu extends Model
{
    protected $connection = 'mysql';
    protected $table = 'site_menu';

    protected $fillable = [
        'descricao',
        'apelido',
        'url',
        'id_pagina',
        'fl_ativo',
        'fl_pai',
        'id_pai',
        'ordem',
    ];

    public function pai()
    {
        return $this->belongsTo(self::class, 'id_pai');
    }

    public function filhos()
    {
        return $this->hasMany(self::class, 'id_pai')
            ->orderBy('ordem')
            ->orderBy('descricao');
    }

    public function pagina()
    {
        return $this->belongsTo(Pagina::class, 'id_pagina');
    }

    public function scopeRaizes($query)
    {
        return $query->whereNull('id_pai')->orWhere('id_pai', 0);
    }

    public function scopeAtivos($query)
    {
        return $query->where('fl_ativo', 1);
    }

    public function scopeOrdenados($query)
    {
        return $query->orderBy('ordem')->orderBy('descricao');
    }

    public function isRaiz(): bool
    {
        return empty($this->id_pai);
    }

    public function tipoDestino(): string
    {
        if ($this->id_pagina) {
            return 'pagina';
        }

        if (trim((string) $this->url) !== '') {
            return 'link';
        }

        return 'agrupador';
    }

    public function urlPublica(): ?string
    {
        $url = trim((string) $this->url);

        if ($url === '' && $this->pagina) {
            return url('pagina/' . $this->pagina->apelido);
        }

        if ($url === '') {
            return null;
        }

        if (preg_match('#^https?://#i', $url) || strpos($url, '//') === 0) {
            return $url;
        }

        if (strpos($url, '/') === 0) {
            return url(ltrim($url, '/'));
        }

        return url($url);
    }
}
