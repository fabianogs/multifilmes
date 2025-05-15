<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Marca extends Model
{
    protected $fillable = [
        'nome',
        'imagem',
        'slug'
    ];

    public function produtos(): HasMany
    {
        return $this->hasMany(Produto::class);
    }
}
