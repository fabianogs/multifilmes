<?php

// app/Models/Post.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['titulo', 'slug', 'chamada_curta', 'conteudo', 'link_video', 'imagem_principal', 'thumbnail', 'ativo', 'exibir_franqueado'];

    /**
     * Relacionamento com a tabela de Imagens (galeria)
     */
    public function imagens()
    {
        return $this->hasMany(Imagem::class);
    }

    /**
     * Relacionamento com a imagem principal
     */
    public function imagemPrincipal()
    {
        return $this->hasOne(Imagem::class)->whereNull('thumbnail');
    }

    /**
     * Relacionamento com a imagem da galeria
     */
    public function imagensGaleria()
    {
        return $this->hasMany(Imagem::class)->whereNotNull('thumbnail');
    }
}
