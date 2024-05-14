<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tarea extends Model
{
    use HasFactory;

    protected $table = 'tareas';

    protected $attributes = [
        'estado' => 'pendiente',
    ];


    protected $fillable = [
        'nombre',
        'descripcion',
        'fechaVencimiento',
        'estado',
    ];

    protected $casts = [
        'fechaVencimiento' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
