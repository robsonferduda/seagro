<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    protected $connection = 'mysql';
    protected $table = 'cidade';

    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['id', 'id_uf', 'nome'];

    public function uf()
    {
        return $this->belongsTo(Uf::class, 'id_uf');
    }

    public function scopeDaUf($query, $sigla)
    {
        return $query->whereHas('uf', function ($q) use ($sigla) {
            $q->where('sigla', mb_strtoupper((string) $sigla));
        });
    }

    public static function listaDaUf($sigla)
    {
        if (empty($sigla)) {
            return collect();
        }

        return static::daUf($sigla)->orderBy('nome')->get(['id', 'nome']);
    }

    public function nomeComUf(): string
    {
        return $this->nome . '/' . optional($this->uf)->sigla;
    }
}
