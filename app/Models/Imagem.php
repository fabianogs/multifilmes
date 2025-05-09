<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imagem extends Model
{
    //
    protected $table = 'imagens';
    protected $fillable = ['caminho', 'nome_arquivo', 'thumbnail', 'ativo', 'post_id'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }    


    public function origem()
    {
        return $this->morphTo();
    }
    
    // Acessor para URL completa
    public function getUrlCompletaAttribute()
    {
        return asset('storage/' . $this->caminho);
    }
    
    // Acessor para verificar se é imagem
    public function getEImagemAttribute()
    {
        return strpos($this->mime_type ?? '', 'image/') === 0;
    }    

}
