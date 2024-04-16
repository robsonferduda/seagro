<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evento extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'evento';

    protected $fillable = ['id'];

}