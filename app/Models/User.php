<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
        'foto_perfil',
        'bio',
        'telefono',
        'verificado',
        'bloqueado',
        'is_admin'
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
            'verificado' => 'boolean',
            'is_admin' => 'boolean'
        ];
    }

    // Relaciones
    public function anuncios(): HasMany
    {
        return $this->hasMany(Anuncio::class);
    }

    public function mensajesEnviados(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function mensajesRecibidos(): HasMany
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function resenas(): HasMany
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    public function resenasPara(): HasMany
    {
        return $this->hasMany(Review::class, 'reviewed_id');
    }

    public function favoritos(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function reportes(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    // Métodos útiles
    public function obtenerCalificacionPromedio(): float
    {
        return $this->resenasPara()->avg('calificacion') ?? 0;
    }

    public function obtenerTotalVentas(): int
    {
        return $this->anuncios()->where('tipo_operacion', 'VENTA')->count();
    }

    public function obtenerTotalCompras(): int
    {
        return $this->anuncios()->where('tipo_operacion', 'COMPRA')->count();
    }
}
