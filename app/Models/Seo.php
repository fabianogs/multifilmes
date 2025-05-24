<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    use HasFactory;
    protected $table = 'seo';
    protected $fillable = ['tipo', 'script', 'status', 'nome'];

    public function unidade()
    {
        return $this->belongsTo(Unidade::class);
    }

}
