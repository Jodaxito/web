<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AnuncioImagen;

class Anuncio extends Model
{
    protected $fillable = [
        'user_id',
        'titulo',
        'descripcion',
        'tipo_operacion',
        'precio',
        'categoria_id',
        'imagen',
        'estado',
        'ubicacion',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function imagenes()
    {
        return $this->hasMany(AnuncioImagen::class);
    }

    /**
     * Scope a query with optional filters.
     *
     * Usage: Anuncio::filter([ 'categoria_id'=>1, 'estado'=>'DISPONIBLE' ])->get();
     */
    public function scopeFilter($query, array $filters)
    {
        if (!empty($filters['tipo_operacion'])) {
            $query->where('tipo_operacion', $filters['tipo_operacion']);
        }
        if (!empty($filters['categoria_id'])) {
            $query->where('categoria_id', $filters['categoria_id']);
        }
        if (!empty($filters['estado'])) {
            $query->where('estado', $filters['estado']);
        }

        return $query;
    }
}
