<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Produto extends Model
{
    protected $fillable = [
        'nome',
        'descricao',
        'imagem',
        'slug',
        'ativo',
        'marca_id',
        'categoria_id'
    ];

    public function marca(): BelongsTo
    {
        return $this->belongsTo(Marca::class);
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    public function solucoes(): BelongsToMany
    {
        return $this->belongsToMany(Solucao::class, 'produto_solucao');
    }
}
