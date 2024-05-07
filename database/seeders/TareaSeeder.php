<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tarea;

use Illuminate\Support\Carbon;

class TareaSeeder extends Seeder
{
    public function run(): void
    {
        Tarea::create([
            'nombre' => 'Tarea 1',
            'descripcion' => 'Descripción de la tarea 1',
            'fechaVencimiento' => Carbon::now()->addDays(1),
            'user_id' => 1,
        ]);
        Tarea::create([
            'nombre' => 'Tarea 2',
            'descripcion' => 'Descripción de la tarea 2',
            'estado' => 'en_proceso',
            'fechaVencimiento' => Carbon::now()->addDays(1),
            'user_id' => 1,
        ]);
        Tarea::create([
            'nombre' => 'Limpiar la casa',
            'descripcion' => 'Descripción de la tarea 1',
            'estado' => 'eliminada',
            'fechaVencimiento' => Carbon::now()->addDays(1),
            'user_id' => 1,
            'deleted_at' => Carbon::now(),
        ]);
        Tarea::create([
            'nombre' => 'Tarea 3',
            'descripcion' => 'Descripción de la tarea 3',
            'estado' => 'terminada',
            'fechaVencimiento' => Carbon::now(),
            'user_id' => 1,
        ]);
    }
}
