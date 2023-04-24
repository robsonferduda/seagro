<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pagina extends Model
{
    use SoftDeletes;

    protected $connection = 'pgsql';
    protected $table = 'pagina';

    protected $fillable = ['id'];

}