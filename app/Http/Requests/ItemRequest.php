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
                    'itemType_id' => 'required',
                    'number' => 'required',
                    'reorder' => 'required',
                    'min_stock' => 'required',
                ];
            case 'PUT':
                return [
                    'name' => "required|unique:items,name,$item->id",
                    'price' => 'required',
                    'itemType_id' => 'required',
                    'number' => 'required',
                    'reorder' => 'required',
                    'min_stock' => 'required',
                ];
            case 'PATCH':
                return [
                    'name' => "required|unique:items,name,$item->id",
                    'price' => 'required',
                    'itemType_id' => 'required',
                    'number' => 'required',
                    'reorder' => 'required',
                    'min_stock' => 'required',
                ];
            default:break;   
        }
    }

    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }
}
