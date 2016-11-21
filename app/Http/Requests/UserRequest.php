<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;
use Log;
use App\User;

class UserRequest extends Request
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
        log::info("entro a userRequest");
        $user = User::find($this->users);
        log::info($user);
        switch($this->method())
        {
            case 'POST':
                return [
                    'name' => 'required',
                    'password' => 'required',
                    'email' => 'required|unique:users,email',
                    'type' => "required|in:admin,asistente,asesor,bodega,director",
                ];
            case 'PUT':
                return [
                    'name' => 'required',
                    'email' => "required|unique:users,email,$user->id",
                    'type' => "required|in:admin,asistente,asesor,bodega,director",
                ];
            case 'PATCH':
                return [
                    'name' => 'required',
                    'email' => "required|unique:users,email,$user->id",
                    'type' => "required|in:admin,asistente,asesor,bodega, director",
                ];
            default:break;   
        }
    }

    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }
}
