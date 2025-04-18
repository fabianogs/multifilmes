<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Solucao extends Model
{
    protected $table = "solucoes";
    protected $fillable = [
        'titulo',
        'descricao',
        'slug'
    ];

    public function categorias(): HasMany
    {
        return $this->hasMany(Categoria::class);
    }
}
