<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnuncioImagen extends Model
{
    use HasFactory;

    protected $table = 'j2_anuncio_imagenes';

    protected $fillable = [
        'anuncio_id',
        'url',
    ];

    public function anuncio()
    {
        return $this->belongsTo(Anuncio::class, 'anuncio_id');
    }
}
