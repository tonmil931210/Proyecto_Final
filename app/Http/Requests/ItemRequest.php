<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;
use Log;
use App\Item;

class ItemRequest extends Request
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
        log::info("entre itemRequest");
        $item = Item::find($this->items);
        log::info($item);
        switch($this->method())
        {
            case 'POST':
                return [
                    'name' => 'required|unique:items,name',
                    'price' => 'required',
                    'item_type_id' => 'required',
                    'number' => 'required',
                    'reorder' => 'required',
                    'min_stock' => 'required',
                ];
            case 'PUT':
                return [
                    'name' => "required|unique:items,name,$item->id",
                    'price' => 'required',
                    'item_type_id' => 'required',
                    'number' => 'required',
                    'reorder' => 'required',
                    'min_stock' => 'required',
                ];
            case 'PATCH':
                return [
                    'name' => "required|unique:items,name,$item->id",
                    'price' => 'required',
                    'item_type_id' => 'required',
                    'number' => 'required',
                    'reorder' => 'required',
                    'min_stock' => 'required',
                ];
            default:break;   
        }
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es un campo obligatorio',
            'price.required'  => 'El precio es un campo obligatorio',
            'item_type_id.required' => 'El ID del tipo de artículo es un campo obligatorio',
            'number.required'  => 'El numero es un campo obligatorio',
            'reorder.required' => 'El reorder es un campo obligatorio',
            'min_stock.required' => 'El min-stock es un campo obligatorio',
        ];
    }

    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }
}
