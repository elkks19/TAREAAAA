<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Carbon;
use App\Models\Tarea;

class StoreTareaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
            'fechaVencimiento' => 'required|date',
            'estado' => 'required|string|in:pendiente,en_proceso,terminada,eliminada',
        ];
    }

    public function save(): Tarea
    {
        $tarea = new Tarea([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'fechaVencimiento' => $this->fechaVencimiento,
            'estado' => $this->estado,
        ]);
        return $tarea;
    }
}
