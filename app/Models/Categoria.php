<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Categoria extends Model
{
    protected $fillable = [
        'nome',
        'descricao',
        'slug',
        'solucao_id',
        'icone'
    ];

    public function solucoes(): BelongsToMany
    {
        return $this->belongsToMany(Solucao::class, 'categoria_solucao');
    }

    public function produtos(): HasMany
    {
        return $this->hasMany(Produto::class);
    }
}
