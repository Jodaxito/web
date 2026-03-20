<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    protected $fillable = [
        'user_id',
        'anuncio_id',
        'razon',
        'descripcion',
        'estado'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function anuncio(): BelongsTo
    {
        return $this->belongsTo(Anuncio::class);
    }
}
