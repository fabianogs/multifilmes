<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'unidade_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function unidade()
    {
        return $this->belongsTo(Unidade::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isFranqueado()
    {
        return $this->role === 'franqueado';
    }

    public function canAccessUnidade(Unidade $unidade)
    {
        return $this->isAdmin() || $this->unidade_id === $unidade->id;
    }

    public function canEditConfig(Config $config)
    {
        return $this->isAdmin() || 
               ($this->isFranqueado() && $this->unidade_id === $config->unidade_id);
    }

    public function canEditSeo(Seo $seo)
    {
        return $this->isAdmin() || 
               ($this->isFranqueado() && $this->unidade_id === $seo->unidade_id);
    }

    public function getUnidadePrincipal()
    {
        return $this->unidade;
    }
}
