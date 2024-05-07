<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\Tarea;

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
            'estado' => 'string|in:pendiente,en_proceso,terminada,eliminada'
        ];
    }
}
