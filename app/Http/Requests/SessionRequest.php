<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;
use Log;
class SessionRequest extends Request
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
        log::info("entre SessionRequest");
        return [
            'email' => 'required',
            'password' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'El correo es un campo obligatorio',
            'password.required'  => 'La contraseña es un campo obligatorio',
        ];
    }

    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }
}
