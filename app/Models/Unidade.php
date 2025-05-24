<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
    //
    protected $fillable = [
        'nome',
        'uf',
        'cidade',
        'url',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function seo()
    {
        return $this->hasOne(Seo::class);
    }

    public function config()
    {
        return $this->hasOne(Config::class);
    }    
}
