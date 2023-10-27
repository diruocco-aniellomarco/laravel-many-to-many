<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'=> ['required', 'string'],
            'description'=> ['required', 'string', 'max: 500'],
            'link'=> ['required', 'string'],
            'slug'=> ['required', 'string'],
        ];
    }

    public function messages() {
        return [
            'name.required'=> 'Il nome è obbligatorio',
            'name.string'=> 'Il nome deve essere una stringa',
            
            'description.required'=> 'La descrizione è obbligatoria',
            'description.string'=> 'La descrizione deve essere una stringa',
            'description.max'=> 'La descrizione deve essere massimo di 500 caratteri',
            
            'link.required'=> 'Il link è obbligatorio',
            'link.string'=> 'Il link deve essere una stringa',
            
            'slug.required'=> 'Lo slug è obbligatorio',
            'slug.string'=> 'Lo slug deve essere una stringa',
        ];
    }
}
