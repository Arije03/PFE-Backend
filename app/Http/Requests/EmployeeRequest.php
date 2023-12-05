<?php

namespace App\Http\Requests;

use App\Exceptions\RequestException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:18',
            'salary' => 'required|numeric|min:0',
            'function' => 'required|string|max:255',
            'sexe' => 'required|string|max:10',
            'date_of_employement' => 'required|date',
            'phone_number' => 'required|string|max:20',
           
            'departement_id'=>'required|exists:department,id'
        ];
    }

   
    protected function failedValidation(Validator $validator)
    {
        throw new RequestException($validator);
    }
}
