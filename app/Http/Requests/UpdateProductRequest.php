<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class UpdateProductRequest extends apiFormRequest
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
                'name' => 'required|string|max:255',
                'description' => 'required|string|max:2000', 
                'price'=> 'required|numeric',
                'category_id'=>'required|exists:category,id'
        ];
    }

    public function messages()
    {
        return [
                // name
                'name.required' => 'El nombre del producto es obligatorio',
                'name.string' => 'El nombre del producto debe ser un texto válido',
                'name.max' => 'El nombre del producto no debe superar los 255 caracteres',

                // description
                'description.required' => 'La descripción es obligatoria',
                'description.string' => 'La descripción debe ser un texto válido',
                'description.max' => 'La descripción no debe superar los 2000 caracteres',

                // price
                'price.required' => 'El precio es obligatorio',
                'price.numeric' => 'El precio debe ser un número válido',

                // category_id
                'category_id.required' => 'La categoría es obligatoria',
                'category_id.exists' => 'La categoría seleccionada no existe en el sistema'
            ];
    }

   
}
