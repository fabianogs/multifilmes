<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Solucao extends Model
{
    protected $table = "solucoes";
    protected $fillable = [
        'titulo',
        'descricao',
        'slug'
    ];

    public function categorias(): BelongsToMany
    {
        return $this->belongsToMany(Categoria::class, 'categoria_solucao');
    }

    public function produtos(): BelongsToMany
    {
        return $this->belongsToMany(Produto::class, 'produto_solucao');
    }
}
