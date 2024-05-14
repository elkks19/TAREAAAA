<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTareaRequest;
use App\Http\Requests\UpdateTareaRequest;
use App\Models\Tarea;
use App\Models\User;

class TareaController extends Controller
{
    public function index()
    {
        $tareas = Tarea::with('user')->get();
        $tareas = $tareas->map(function ($tarea) {
            return [
                'id' => $tarea->id,
                'usuario' => $tarea->user->name,
                'nombre' => $tarea->nombre,
                'descripcion' => $tarea->descripcion,
                'fechaVencimiento' => date('Y/m/d', strtotime($tarea->fechaVencimiento)),
                'created_at' => $tarea->created_at->format('Y/m/d H:i:s'),
                'updated_at' => $tarea->updated_at->format('Y/m/d H:i:s'),
                'estado' => $tarea->estado,
            ];
        });
        return response()->json([
            'usuarios' => User::all()->pluck('name'),
            'tareas' => $tareas,
        ]);
    }

    public function store(StoreTareaRequest $request)
    {
        $tarea = $request->save();

        $tarea->user()->associate(User::where('name', $request->usuario)->first());

        $tarea->save();

        return response()->json(['message' => 'Tarea creada correctamente'], 201);
    }

    public function update(UpdateTareaRequest $request, Tarea $tarea)
    {
        $tarea = $request->update($tarea);

        return response()->json(['message' => 'Tarea actualizada correctamente'], 200);
    }

    public function destroy(Tarea $tarea)
    {
        $tarea->delete();
        return response()->json(['message' => 'Tarea eliminada correctamente'], 200);
    }
}
