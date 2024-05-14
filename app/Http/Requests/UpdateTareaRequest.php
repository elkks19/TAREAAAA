<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\Tarea;
use App\Models\User;

class UpdateTareaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'string',
            'descripcion' => 'string',
            'fechaVencimiento' => 'date',
            'estado' => 'string|in:pendiente,en_proceso,terminada,eliminada',
            'usuario' => 'string|exists:users,name'
        ];
    }

    public function update(Tarea $tarea): Tarea
    {
        $tarea->fill($this->validated())->save();

        if ($this->usuario) {
            $tarea->user()->associate(User::where('name', $this->usuario)->first());
        }

        $tarea->save();

        return $tarea;
    }
}
