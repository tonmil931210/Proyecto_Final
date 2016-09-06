<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;
use Log;
use App\Order_status;
class OrderStatusRequest extends Request
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
        log::info("entrw1");
        $order_status = Order_status::find($this->orderStatus);
        log::info($order_status);
        switch($this->method())
        {
            case 'POST':
                return [
                    'name' => 'required|unique:order_status,name',
                ];
            case 'PUT':
                return [
                    'name' => "required|unique:order_status,name,$order_status->id",
                ];
            case 'PATCH':
                return [
                    'name' => "required|unique:order_status,name,$order_status->id",
                ];
            default:break;   
        }
    }

    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }
}
