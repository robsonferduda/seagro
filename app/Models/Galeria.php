<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Galeria extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'galeria';

    protected $fillable = [
        'titulo',
        'arquivo',
        'mime',
        'tamanho',
    ];

    public function urlPublica()
    {
        return asset('img/galeria/' . $this->arquivo);
    }

    public function caminhoLocal()
    {
        return public_path('img/galeria/' . $this->arquivo);
    }

    public function tamanhoFormatado()
    {
        if (!$this->tamanho) {
            return '—';
        }

        $bytes = (int) $this->tamanho;
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 1, ',', '.') . ' MB';
        }

        return number_format($bytes / 1024, 0, ',', '.') . ' KB';
    }
}
