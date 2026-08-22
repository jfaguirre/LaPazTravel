<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class FotoPerfilRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
             'foto_perfil' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'], // Máximo 2MB
        ];
    }

    public function messages()
    {
        return [

            'foto_perfil.required'  => 'Debes agregar una imagen valida.',
            'foto_perfil.image'     => 'Solo se permiten imagenes.',
            'foto_perfil.mimes'     => 'La imagen debe ser de formato JPG, JPEG, PNG o WEBP.',
            'foto_perfil.max'       => 'Solo puedes subir una imagen con un maximo de 2MB.',

        ]; 
    }
}
