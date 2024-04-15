<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estatistica extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'estatistica';

    protected $fillable = ['id'];

}