<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;
use Log;
use App\Order;
class OrderRequest extends Request
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
        log::info("entre orderRequest");
        switch($this->method())
        {
            case 'POST':
                return [
                    'name_client' => 'required',
                    'items' => 'required',
                    'event_id' => 'required',  
                    'order_status_id' => 'required',
                    'type' => 'required|in:retornable,consumible',
                ];
            case 'PUT':
                return [
                    'name_client' => 'required',
                    'items' => 'required',
                    'event_id' => 'required',
                    'type' => 'required|in:retornable,consumible',
                ];
            case 'PATCH':
                return [
                    'name_client' => 'required',
                    'items' => 'required',
                    'event_id' => 'required',
                    'type' => 'required|in:retornable,consumible',
                ];
            default:break;   
        }
    }
    public function messages()
    {
        return [
            'name_client.required' => 'El nombre del cliente es un campo obligatorio',
            'items.required'  => 'Los articulos son un campo obligatorio',
            'event_id.required' => 'El ID del evento es un campo obligatorio',
            'order_status_id.required'  => 'El ID del estado de la orden es un campo obligatorio',
            'type.required' => 'El Tipo de la orden es un campo obligatorio',
        ];
    }

    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }
}
