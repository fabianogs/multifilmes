<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    //
    protected $fillable = [
        'titulo', 'subtitulo','link', 'midia_id', 'ativo'
    ];
}
