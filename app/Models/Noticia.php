<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Noticia extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'noticia';

    protected $fillable = ['id'];

}