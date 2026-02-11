<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Oportunidade extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'oportunidade';

    protected $fillable = [
        'id',
        'titulo',
        'descricao',
        'empresa',
        'tipo',
        'localizacao',
        'salario',
        'dt_publicacao',
        'dt_validade',
        'link_externo',
        'arquivo',
        'fl_ativo',
        'visualizacoes'
    ];

    // Verifica se a oportunidade está válida (não expirou)
    public function isValida()
    {
        if (!$this->dt_validade) {
            return true;
        }
        return \Carbon\Carbon::parse($this->dt_validade)->isFuture();
    }

    // Scope para oportunidades ativas e válidas
    public function scopeAtivas($query)
    {
        return $query->where('fl_ativo', 1)
                    ->where(function($q) {
                        $q->whereNull('dt_validade')
                          ->orWhere('dt_validade', '>=', date('Y-m-d'));
                    });
    }
}
