<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
			'title' => ['required', 'unique:projects', 'max:150'],
			'description' => ['nullable'],
			'type_id' => ['nullable', 'exists:types,id'],
			'technologies' => ['nullable', 'exists:technologies,id'],
			'cover_image' => ['nullable', 'image']
		];
	}

	public function messages()
	{
		return [
			'title.required' => 'Non hai inserito un titolo',
			'title.unique' => 'Il titolo inserito è già esistente',
			'title.max' => 'La lunghezza del titolo non può essere superiore a :max caratteri',
			'type_id.exists' => 'La categoria selezionata non è valida',
			'technologies.exists' => 'Le tecnologie selezionate non sono valide',
			'cover_image.image' => 'Inserire un formato immagine come file'
		];
	}
}
