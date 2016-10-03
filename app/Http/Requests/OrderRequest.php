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
                ];
            case 'PUT':
                return [
                    'name_client' => 'required',
                    'items' => 'required',
                    'event_id' => 'required',
                ];
            case 'PATCH':
                return [
                    'name_client' => 'required',
                    'items' => 'required',
                    'event_id' => 'required',  
                ];
            default:break;   
        }
    }

    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }
}
