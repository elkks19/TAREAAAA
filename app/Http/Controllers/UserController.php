<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tarea;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all()->except(Auth::id());
        $users = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'nombre' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created_at->format('Y/m/d H:i:s'),
                'updated_at' => $user->updated_at->format('Y/m/d H:i:s'),
            ];
        });

        return $users;
    }

    public function store(StoreUserRequest $request)
    {
        $user = $request->save();
        return response()->json(['message' => 'Usuario creado correctamente'], 201);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user = $request->update($user);
        return response()->json(['message' => 'Usuario actualizado correctamente'], 200);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'Usuario eliminado correctamente'], 200);
    }

    public function indexTareas(User $user)
    {
        $selectedTareas = $user->tareas->pluck('nombre');
        $allTareas = Tarea::all()->pluck('nombre');

        return response()->json([
            'tareas' => $allTareas,
            'selectedTareas' => $selectedTareas,
        ]);
    }
}
