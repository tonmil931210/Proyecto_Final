<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;
use Log;
class DevolutionRequest extends Request
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
     * @return array
     */
    public function rules()
    {
        log::info("entro a DevolutionRequest");
        return [
            'item_id' => 'required',
            'number' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'number.required' => 'El numero es un campo obligatorio',
            'item_id.required'  => 'La ID del item es un campo obligatorio',
        ];
    }

    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }

}
