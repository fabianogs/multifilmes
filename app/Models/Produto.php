<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Produto extends Model
{
    protected $fillable = [
        'nome',
        'descricao',
        'imagem',
        'slug',
        'ativo',
        'marca_id'
    ];

    public function marca(): BelongsTo
    {
        return $this->belongsTo(Marca::class);
    }
}
